<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Models\mCategorias;
use App\Models\mProductos;
use App\Models\mManifiesto;
use \Config\Services;
use \PhpZip\ZipFile;

class cProductos extends BaseController {
	public function index() {
		$this->content['title'] = "Productos";
		$this->content['view'] = "vProductos";
		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"ubicacion" => (session()->has("ubicacionProducto") ? session()->get("ubicacionProducto") : '0'),
			"costo" => (session()->has("costoProducto") ? session()->get("costoProducto") : '0'),
			"manifiesto" => (session()->has("manifiestoProducto") ? session()->get("manifiestoProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0')
 		];
		$this->content["inventario_negativo"] = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');
		$this->content['imagenProd'] = (session()->has("imageProd") ? session()->get("imageProd") : 0);

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LSelect2();
		$this->LFancybox();
		$this->LInputMask();
		$this->LCropperImageEditor();

		$categorias = new mCategorias();
		$this->content["categorias"] = $categorias->asObject()->where("estado", 1)->findAll();

		if ($this->content["camposProducto"]["manifiesto"] == "1") {
			$manifiestos = new mManifiesto();
			$this->content["manifiestos"] = $manifiestos->asObject()->where("estado", 1)->findAll();
		} else {
			$this->content["manifiestos"] = [];
		}	

		if (validPermissions([54], true)) {
			$mProductos = new mProductos();
			$this->content["valorInventarioActual"] = $mProductos->asObject()->select("SUM(stock * precio_venta) AS valorInventario", false)->where("estado", '1')->findAll();
			$this->content["valorInventarioActual"] = $this->content["valorInventarioActual"][0]->valorInventario;
		} else {
			$this->content["valorInventarioActual"] = 0;
		}
		
		$this->content['js_add'][] = [
			'jsProductos.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$postData = (object) $this->request->getPost();

		$query = $this->db
				->table('productos AS P')
				->select("
						P.id,
						P.id_categoria,
						P.referencia,
						P.item,
						P.descripcion,
						P.imagen,
						CASE 
							WHEN P.stock < 0 THEN 'dark'
							WHEN P.stock <= " . ((int) (session()->has("inventarioBajo") ? session()->get("inventarioBajo") : '0')) . "
								THEN 'danger'
							WHEN P.stock > " . ((int) (session()->has("inventarioBajo") ? session()->get("inventarioBajo") : '0')) . " AND P.stock <= " . ((int) (session()->has("inventarioMedio") ? session()->get("inventarioMedio") : '24')) . "
								THEN 'warning'
							ELSE 'success' 
						END AS ColorStock,
						P.stock,
						P.precio_venta,
						P.costo,
						P.ubicacion,
						M.nombre AS nombreManifiesto,
						P.ventas, 
						P.estado, 
						P.created_at,
						P.updated_at,
						C.nombre AS nombreCategoria,
						CASE 
								WHEN P.estado = 1 THEN 'Activo' 
								ELSE 'Inactivo' 
						END AS Estadito,
						P.cantPaca,
						CASE 
								WHEN 1 = "  . ((int) (session()->has("manifiestoProducto") ? session()->get("manifiestoProducto") : '0')) . "
									THEN P.id_manifiesto
								ELSE '0'
						END AS manifiesto
				")->join('categorias AS C', 'P.id_categoria = C.id', 'left')
				->join('manifiestos AS M', 'P.id_manifiesto = M.id', 'left');

		if($postData->estado != "-1"){
			$query->where("P.estado", $postData->estado);
		}

		if(isset($postData->categoria) && $postData->categoria > 0){
			$query->where("P.id_categoria", $postData->categoria);
		}

		if(isset($postData->cantIni) && $postData->cantIni >= 0) {
			$query->where("P.stock >= $postData->cantIni");
		}

		if(isset($postData->cantFin) && $postData->cantFin >= 0){
			$query->where("P.stock <= $postData->cantFin");
		}

		if(isset($postData->preciIni) && $postData->preciIni >= 0) {
			$query->where("P.precio_venta >= $postData->preciIni");
		}

		if(isset($postData->preciFin) && $postData->preciFin >= 0){
			$query->where("P.precio_venta <= $postData->preciFin");
		}

		//validamos si aplica para ventas para realziar algunas validaciones
		if (isset($postData->ventas) && $postData->ventas == 1) {
			$inventarioNegativo = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');
			if ($inventarioNegativo == "0") {
				$query->where("P.stock >=", 0);
			}
		}

		return DataTable::of($query)->toJson(true);
	}

	public function validarProducto($campo, $nombre, $id){
		$prod = new mProductos();

		$producto = $prod->asObject()
						->where([$campo => $nombre, "id != " => $id])
						->countAllResults();

		return $this->response->setJSON($producto);
	}

	public function crearEditar(){
		$resp["success"] = false;
		$filenameDelete = "";
		$postData = (object) $this->request->getPost();

		$inventarioNegativo = (session()->has("inventarioNegativo") ?  session()->get("inventarioNegativo") : '0');

		//Validamos si se puede guardar inventario negativo
		if ($inventarioNegativo == '0' && intval($postData->stock) < 0) {
			$inventarioNegativo = false;
		} else {
			$inventarioNegativo = true;
		}

		if ($inventarioNegativo) {
			$product = new mProductos();
			//Creamos el producto y llenamos los datos
			$producto = array(
				"id" => $postData->id
				,"id_categoria" => ($postData->categoria == '' ? null : trim($postData->categoria))
				,"referencia" => trim($postData->referencia)
				,"item" => (session()->has("itemProducto") && session()->get("itemProducto") == '1' ? trim($postData->item) : null)
				,"descripcion" => trim($postData->descripcion)
				,"stock" => $postData->stock
				,"precio_venta" => str_replace(",", "", trim(str_replace("$", "", $postData->precioVent)))
				,"ubicacion" => (session()->has("ubicacionProducto") && session()->get("ubicacionProducto") == '1' ? trim($postData->ubicacion) : null)
				,"id_manifiesto" => !isset($postData->manifiesto) || strlen(trim($postData->manifiesto)) == 0 ? null : trim($postData->manifiesto)
				,"costo" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? str_replace(",", "", trim(str_replace("$", "", $postData->costo))) : '0')
				,"cantPaca" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($postData->paca) : 1)
			);
	
			//Validamos si eliminar la foto de perfil y buscamos el usuario
			if($postData->editFoto != 0 && !empty($postData->id)) {
				$foto = $product->find($postData->id)["imagen"];
				$producto["imagen"] = null;
				$filenameDelete = UPLOADS_PRODUCT_PATH . $postData->id . "/" . $foto; //<-- specify the image  file
			}
	
			$this->db->transBegin();
					
			//Validamos si el usuario que ingresaron ya existe
			if ($product->save($producto)) {
				//Traemos el id insertado
				$product->id = empty($postData->id) ? $product->getInsertID() : $postData->id; 
				$imgFoto = $this->request->getFile("imagen"); 
				if (!empty($imgFoto->getBasename())) {
					//Validamos la foto
					$validated = $this->validate([
						'rules' => [
							'uploaded[imagen]',
							'mime_in[imagen,image/jpg,image/jpeg,image/gif,image/png]',
							'max_size[imagen,20480]',
						],
					]);
									
					//Se valida los datos de la imagen
					if ($validated) {
						if ($imgFoto->isValid() && !$imgFoto->hasMoved()) {
							//Validamos que la imagen suba correctamente
							$nameImg = "01.png";

							$image = Services::image()
												->withFile($imgFoto)
												->resize(1080, 1080, true, 'height');

							$ruta = UPLOADS_PRODUCT_PATH ."/" . $product->id  ."/";
							if (!file_exists($ruta)) {
									mkdir($ruta, 0777, true);
							}

							//$imgFoto->move(UPLOADS_PRODUCT_PATH . "/" . $product->id, $nameImg, true)
							if ($image->save($ruta . $nameImg)) {
								$updateFoto = array(
									"id" => $product->id,
									"imagen" => $nameImg
								);
	
								if ($product->save($updateFoto)) { 
									$resp["success"] = true;
									$resp["msj"] = "El producto <b>{$product->referencia}</b> se " . (empty($postData->id) ? 'creo' : 'actualizo') . " correctamente.";
								} else {
									$resp["msj"] = "Ha ocurrido un error al actualizar los datos de la foto.";
								}
							} else {
								$resp["msj"] = "Ha ocurrido un error al subir la foto.";
							}
						} else {
							$resp["msj"] = "Error al subir la foto, {$imgFoto->getErrorString()}";
						}
					} else {
						$resp["msj"] = "Error al subir la foto, " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
					}
				} else {
					$resp["success"] = true;
					$resp["msj"] = "El producto <b>{$product->referencia}</b> se " . (empty($postData->id) ? 'creo' : 'actualizo') . " correctamente.";
				}
			} else {
				$resp["msj"] = "No puede " . (empty($postData->id) ? 'crear' : 'actualizar') . " el producto." . listErrors($product->errors());
			}
					
			//Validamos para elminar la foto
			if ($filenameDelete != '' && file_exists($filenameDelete)) {
				if(!@unlink($filenameDelete)) {
					$resp["success"] = false;
					$resp["msj"] = "Error al eliminar la foto de perfil, intente de nuevo";
				} 
			}
		} else {
			$resp["msj"] = "El stock no puede estar en negativo.";
		}

		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function foto($id = null, $img = null){
		$filename = UPLOADS_PRODUCT_PATH ."{$id}/{$img}"; //<-- specify the image  file
		//Si la foto no existe la colocamos por defecto
		if(is_null($img) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		}
		//$mime = mime_content_type($filename); //<-- detect file type
		header('Content-Length: '.filesize($filename)); //<-- sends filesize header
		header("Content-Type: image/jpeg"); //<-- send mime-type header
		header("Content-Disposition: inline; filename='{$filename}';"); //<-- sends filename header
		readfile($filename); //<--reads and outputs the file onto the output buffer
		exit(); // or die()
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();

		$producto = new mProductos();
		
		if($producto->save($data)) {
			$resp["success"] = true;
			$resp['msj'] = "Producto actualizado correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function convertirFoto($id, $img, $datos = null){
		$filename = UPLOADS_PRODUCT_PATH ."{$id}/{$img}"; //<-- specify the image  file

		//Si la foto no existe la colocamos por defecto
		if(is_null($img) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		}

		if (!is_dir(UPLOADS_PRODUCT_PATH . 'convert/')) {
			mkdir(UPLOADS_PRODUCT_PATH . 'convert/', 0777, TRUE);
		}

		if (is_null($datos)) {
			$mProductos = new mProductos();
	
			$producto = $mProductos->asObject()->find($id);
		} else {
			$producto = $datos;
		}

		$descripcion = substr($producto->descripcion, 0, 66) . (strlen($producto->descripcion) > 66 ? "..." : "");

		$servicios = new Services();
		$servicios::image()
    ->withFile($filename)
    ->text($producto->referencia, [
			'color'      => '#000',
			'opacity'    => 0,
			'hOffset'    => '10',
			'vOffset'    => '-130',
			'withShadow' => true,
			'shadowColor' => '#fff',
			'hAlign'     => 'left',
			'vAlign'     => 'bottom',
			'fontSize'   => 80,
			'fontPath'   => ASSETS_PATH . 'fonts/Cooper Black Regular.ttf'
    ])->text("$ " . number_format($producto->precio_venta, 0, ',', '.'), [
			'color'      => '#000',
			'opacity'    => 0,
			'hOffset'    => '10',
			'vOffset'    => '-40',
			'withShadow' => true,
			'shadowColor' => '#fff',
			'hAlign'     => 'left',
			'vAlign'     => 'bottom',
			'fontSize'   => 80,
			'fontPath'   => ASSETS_PATH . 'fonts/Cooper Black Regular.ttf'
		])->text("Pac " . $producto->cantPaca, [
			'color'      => '#000',
			'opacity'    => 0,
			'hOffset'    => '10',
			'vOffset'    => '-60',
			'withShadow' => true,
			'shadowColor' => '#fff',
			'hAlign'     => 'right',
			'vAlign'     => 'bottom',
			'fontSize'   => 40,
			'fontPath'   => ASSETS_PATH . 'fonts/Cooper Black Regular.ttf'
		])->text($descripcion, [
			'color'      => '#000',
			'opacity'    => 0,
			'hOffset'    => '10',
			'vOffset'    => '-4',
			'withShadow' => true,
			'shadowColor' => '#fff',
			'hAlign'     => 'left',
			'vAlign'     => 'bottom',
			'fontSize'   => 40,
			'fontPath'   => ASSETS_PATH . 'fonts/Cooper Black Regular.ttf'
		])->convert(IMAGETYPE_PNG)
		->save(UPLOADS_PRODUCT_PATH ."convert/{$producto->id}.png");

		if (is_null($datos)) {
			return $this->response->download(UPLOADS_PRODUCT_PATH . "convert/{$producto->id}.png", null)->setFileName($producto->referencia . '.png');
		}
	}

	public function descargarFoto($minimo, $maximo){

		$mProducto = new mProductos();

		if ($minimo > 0) {
			$mProducto->where("precio_venta >=", $minimo);
		}

		if ($maximo > 0) {
			$mProducto->where("precio_venta <=", $maximo);
		}

		$productos = $mProducto->where("stock >", 0)->where('imagen IS NOT NULL', NULL, FALSE)->asObject()->findAll();

		$zipFile = new ZipFile();
		
		foreach ($productos as $it) {
			$this->convertirFoto($it->id, $it->imagen, $it);
			$zipFile->addFile(UPLOADS_PRODUCT_PATH . "convert/{$it->id}.png");
		}

		$zipFile->saveAsFile(UPLOADS_PRODUCT_PATH . "fotos.zip"); 

		return $this->response->download(UPLOADS_PRODUCT_PATH .  "fotos.zip", null)->setFileName("fotos" . date("Ymd") . '.zip');
		
	}

	public function productosAPP() {
		$productos = $this->db
			->table('productos AS P')
			->select("
					P.id,
					P.id_categoria,
					P.referencia,
					P.item,
					P.descripcion,
					P.imagen,
					P.stock,
					P.precio_venta,
					P.costo,
					P.ubicacion,
					P.ventas, 
					P.estado, 
					P.created_at,
					P.updated_at,
					C.nombre AS nombreCategoria,
					P.cantPaca,
					CASE 
						WHEN P.imagen IS NULL THEN '' 
						ELSE CONCAT('" . base_url() . "/fotoProductosAPP/', P.id, '/', P.imagen) 
					END As FotoURL				
			")->join('categorias AS C', 'P.id_categoria = C.id', 'left')
			->where("P.estado", 1)
			->where("P.stock >", 0)
			->get()->getResult();

		return $this->response->setJSON($productos);
	} 
}
