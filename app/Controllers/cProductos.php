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
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0'),
			"pacDescarga" => (session()->has("pacDescarga") ? session()->get("pacDescarga") : '1')
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

		$mProductos = new mProductos();
		$datosInventario = $mProductos->asObject()->select("SUM(stock * precio_venta) AS valorInventario, SUM(stock * costo) AS costoInventario", false)->where("estado", '1')->first();

		$this->content["valorInventarioActual"] = 0;
		if (validPermissions([54], true)) {
			$this->content["valorInventarioActual"] = $datosInventario->valorInventario;
		}

		$this->content["costoInventarioActual"] = 0;
		if (validPermissions([57], true) && $this->content["camposProducto"]["costo"] == "1") {
			$this->content["costoInventarioActual"] = $datosInventario->costoInventario;
		}
		
		$this->content['js_add'][] = [
			'jsProductos.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$postData = (object) $this->request->getPost();
		session()->remove(['filtrosProductos']);
		$arrayFiltro['estado'] = $postData->estado;

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
			$arrayFiltro['categoria'] = $postData->categoria;
			$query->where("P.id_categoria", $postData->categoria);
		}

		if(isset($postData->cantIni) && $postData->cantIni >= 0) {
			$arrayFiltro['cantIni'] = $postData->cantIni;
			$query->where("P.stock >= $postData->cantIni");
		}

		if(isset($postData->cantFin) && $postData->cantFin >= 0){
			$arrayFiltro['cantFin'] = $postData->cantFin;
			$query->where("P.stock <= $postData->cantFin");
		}

		if(isset($postData->preciIni) && $postData->preciIni >= 0) {
			$arrayFiltro['preciIni'] = $postData->preciIni;
			$query->where("P.precio_venta >= $postData->preciIni");
		}

		if(isset($postData->preciFin) && $postData->preciFin >= 0){
			$arrayFiltro['preciFin'] = $postData->preciFin;
			$query->where("P.precio_venta <= $postData->preciFin");
		}

		//validamos si aplica para ventas para realziar algunas validaciones
		if (isset($postData->ventas) && $postData->ventas == 1) {
			$arrayFiltro['ventas'] = $postData->ventas;
			$inventarioNegativo = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');
			if ($inventarioNegativo == "0") {
				$query->where("P.stock >=", 0);
			}
		}

		if (isset($postData->search) && $postData->search["value"] != "") {
			$arrayFiltro['search'] = $postData->search["value"];
		}

		session()->set('filtrosProductos', $arrayFiltro);
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
				,"updated_at" => date("Y-m-d H:i:s")
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
							$nameLogo = "01-logo.png";
							$nameSmallImg = "01-small.png";

							$image = Services::image()
												->withFile($imgFoto)
												->convert(IMAGETYPE_PNG)
												->resize(1080, 1080, true, 'height');

							$ruta = UPLOADS_PRODUCT_PATH ."/" . $product->id  ."/";
							if (!file_exists($ruta)) {
									mkdir($ruta, 0777, true);
							}

							if ($image->save($ruta . $nameImg)) {

								$product->imagen = $nameImg;
								$this->marcaAguaProducto($product);

								$imageSmall = Services::image()
												->withFile($ruta . $nameLogo)
												->convert(IMAGETYPE_PNG)
												->resize(250, 250, true, 'height');
								if ($imageSmall->save($ruta . $nameSmallImg)) {
									$updateFoto = array(
										"id" => $product->id,
										"imagen" => $nameImg
									);
		
									if ($product->save($updateFoto)) { 
										$this->convertirFoto($product->id, $nameImg);
										$resp["success"] = true;
										$resp["msj"] = "El producto <b>{$product->referencia}</b> se " . (empty($postData->id) ? 'creo' : 'actualizo') . " correctamente.";
									} else {
										$resp["msj"] = "Ha ocurrido un error al actualizar los datos de la foto.";
									}
								} else {
									$resp["msj"] = "Ha ocurrido un error al subir la foto miniatura.";
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

					if (!empty($postData->id)) {
						$foto = $product->find($postData->id)["imagen"];

						if (!is_null($foto)) {
							$this->convertirFoto($product->id, $foto);
						}
					}
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
		$ruta = UPLOADS_PRODUCT_PATH ."{$id}/";
		$filename = $ruta . $img; //<-- specify the image  file/<-- specify the image  file
		//Si la foto no existe la colocamos por defecto
		if(is_null($img) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		} else {
			$dataImg = (object) pathinfo($img);

			//Si el archivo existe validamos que existe si existe utilizamos ese
			if (file_exists($ruta . $dataImg->filename . "-logo." . $dataImg->extension)) {
				$filename = $ruta . $dataImg->filename . "-logo." . $dataImg->extension;
			}
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
		$ruta = UPLOADS_PRODUCT_PATH ."{$id}/";
		$filename = $ruta . $img; //<-- specify the image  file

		//Si la foto no existe la colocamos por defecto
		if(is_null($img) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		} else {
			$dataImg = (object) pathinfo($img);

			//Si el archivo existe validamos que existe si existe utilizamos ese
			if (file_exists($ruta . $dataImg->filename . "-logo." . $dataImg->extension)) {
				$filename = $ruta . $dataImg->filename . "-logo." . $dataImg->extension;
			}
		}

		if (is_null($datos)) {
			$mProductos = new mProductos();
	
			$producto = $mProductos->asObject()->find($id);
		} else {
			$producto = $datos;
		}

		$descripcion = substr($producto->descripcion, 0, 66) . (strlen($producto->descripcion) > 66 ? "..." : "");
		$nombreArchivo = strtotime($producto->updated_at);

		if (!file_exists(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/{$nombreArchivo}.png")) {
			//Elimanos el directorio si existe lo eliminamos para crear el nuevo
			if(is_dir(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/")){
				$this->borrar_directorio(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/");
			}

			if (!is_dir(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/")) {
				mkdir(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/", 0777, TRUE);
			}
			
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
				'fontPath'   => ASSETS_PATH . 'fonts/Cooper_Black_Regular.ttf'
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
				'fontPath'   => ASSETS_PATH . 'fonts/Cooper_Black_Regular.ttf'
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
				'fontPath'   => ASSETS_PATH . 'fonts/Cooper_Black_Regular.ttf'
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
				'fontPath'   => ASSETS_PATH . 'fonts/Cooper_Black_Regular.ttf'
			])->convert(IMAGETYPE_PNG)
			->save(UPLOADS_PRODUCT_PATH ."{$producto->id}/convert/{$nombreArchivo}.png");
		}

		if (is_null($datos)) {
			return $this->response->download(UPLOADS_PRODUCT_PATH . "{$producto->id}/convert/{$nombreArchivo}.png", null)->setFileName($producto->referencia . '.png');
		}

	}

	public function descargarFoto($limit = null, $offset = null){
		$filtros = (object) session()->get("filtrosProductos");
		$search = [
			"P.id",
			"P.referencia",
			"P.item",
			"P.descripcion",
			"P.stock",
			"P.cantPaca",
			"P.costo",
			"P.precio_venta",
			"P.ubicacion",
			"P.created_at",
			"C.nombre",
			"M.nombre"
		];

		$mProducto = new mProductos();
		$mProducto1 = new mProductos();

		$mProducto->select($search)
			->select("P.imagen, P.updated_at")
			->from("productos AS P", true)
			->join('categorias AS C', 'P.id_categoria = C.id', 'left')
			->join('manifiestos AS M', 'P.id_manifiesto = M.id', 'left')
			->where('P.imagen IS NOT NULL', NULL, FALSE);

		$mProducto1->select($search)
			->select("P.imagen, P.updated_at")
			->from("productos AS P", true)
			->join('categorias AS C', 'P.id_categoria = C.id', 'left')
			->join('manifiestos AS M', 'P.id_manifiesto = M.id', 'left')
			->where('P.imagen IS NOT NULL', NULL, FALSE);

		if($filtros->estado != "-1"){
			$mProducto->where("P.estado", $filtros->estado);
			$mProducto1->where("P.estado", $filtros->estado);
		}

		if(isset($filtros->categoria) && $filtros->categoria > 0){
			$arrayFiltro['categoria'] = $filtros->categoria;
			$mProducto->where("P.id_categoria", $filtros->categoria);
			$mProducto1->where("P.id_categoria", $filtros->categoria);
		}

		if(isset($filtros->cantIni) && $filtros->cantIni >= 0) {
			$arrayFiltro['cantIni'] = $filtros->cantIni;
			$mProducto->where("P.stock >= $filtros->cantIni");
			$mProducto1->where("P.stock >= $filtros->cantIni");
		}

		if(isset($filtros->cantFin) && $filtros->cantFin >= 0){
			$arrayFiltro['cantFin'] = $filtros->cantFin;
			$mProducto->where("P.stock <= $filtros->cantFin");
			$mProducto1->where("P.stock <= $filtros->cantFin");
		}

		if(isset($filtros->preciIni) && $filtros->preciIni >= 0) {
			$arrayFiltro['preciIni'] = $filtros->preciIni;
			$mProducto->where("P.precio_venta >= $filtros->preciIni");
			$mProducto1->where("P.precio_venta >= $filtros->preciIni");
		}

		if(isset($filtros->preciFin) && $filtros->preciFin >= 0){
			$arrayFiltro['preciFin'] = $filtros->preciFin;
			$mProducto->where("P.precio_venta <= $filtros->preciFin");
			$mProducto1->where("P.precio_venta <= $filtros->preciFin");
		}

		//validamos si aplica para ventas para realziar algunas validaciones
		if (isset($filtros->ventas) && $filtros->ventas == 1) {
			$arrayFiltro['ventas'] = $filtros->ventas;
			$inventarioNegativo = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');
			if ($inventarioNegativo == "0") {
				$mProducto->where("P.stock >=", 0);
				$mProducto1->where("P.stock >=", 0);
			}
		}

		if (isset($filtros->search) && $filtros->search != "") {
			$mProducto->groupStart();
			foreach ($search as $it) {
				$mProducto->orLike(trim($it), $filtros->search);
			}
			$mProducto->groupEnd();

			$mProducto1->groupStart();
			foreach ($search as $it) {
				$mProducto1->orLike(trim($it), $filtros->search);
			}
			$mProducto1->groupEnd();
		}

		if (!is_null($offset)) {
			$productos = $mProducto->asObject()->findAll($limit, $offset);

			$zipFile = new ZipFile();
			ob_start();
			foreach ($productos as $it) {
				$this->convertirFoto($it->id, $it->imagen, $it);
				$nombreArchivo = strtotime($it->updated_at);
				$zipFile->addFile(UPLOADS_PRODUCT_PATH . "{$it->id}/convert/{$nombreArchivo}.png", "{$it->referencia}.png");
			}
	
			$zipFile->saveAsFile(UPLOADS_PRODUCT_PATH . "fotos.zip"); 
			return $this->response->download(UPLOADS_PRODUCT_PATH .  "fotos.zip", null)->setFileName("fotos.zip");
		} else {

			$mProducto1->paginate($limit);
			
			$resp = [
				"totalRegistros" => $mProducto->countAllResults(),
				"totalPaginas" => $mProducto1->pager->getPageCount()
			];
			return $this->response->setJSON($resp);
		}
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
					END As FotoURL,
					CASE 
						WHEN P.imagen IS NULL THEN '' 
						ELSE CONCAT('" . base_url() . "/fotoProductosAPP/', P.id, '/', SUBSTRING(P.imagen,1,LOCATE('.', P.imagen)+-1), '-small', SUBSTRING(P.imagen,LOCATE('.', P.imagen),LENGTH(P.imagen)-LOCATE('.', P.imagen)+1)) 
					END As FotoURLSmall			
			")->join('categorias AS C', 'P.id_categoria = C.id', 'left')
			->where("P.estado", 1)
			->where("P.stock >", 0)
			->get()->getResult();

		return $this->response->setJSON($productos);
	} 

	public function sincronizar(){
		$resp['success'] = false;
		$resp['listProd'] = "";
		$contProd = 0;

		$mProducto = new mProductos();
		$productos = $mProducto->where('imagen IS NOT NULL', NULL, FALSE)->asObject()->findAll();


		foreach ($productos as $it) {
			$ruta = UPLOADS_PRODUCT_PATH ."/" . $it->id  ."/";
			$filename = UPLOADS_PRODUCT_PATH ."{$it->id}/{$it->imagen}"; //<-- specify the image  file

			//Si la foto no existe la colocamos por defecto
			if(file_exists($filename)){ 
				$dataFoto = (object) pathinfo($filename);

				//Si la extension de la imagen es jpg convertimos todo a png para evitar conflictos
				if ($dataFoto->extension != "png") {
					Services::image()
						->withFile($filename)
						->convert(IMAGETYPE_PNG)
						->save($ruta . "{$dataFoto->filename}.png");

					$filename = $ruta . "{$dataFoto->filename}.png";
					
					//Eliminamos los archivos restantes en jpg
					$rutaFoto = $ruta . $it->imagen;
					if (file_exists($rutaFoto)) {
						unlink($rutaFoto);
					}
					$rutaLogo = $ruta . $dataFoto->filename . "-logo." . $dataFoto->extension; 
					if (file_exists($rutaLogo)) {
						unlink($rutaLogo);
					}
					$rutaSmall = $ruta . $dataFoto->filename . "-small." . $dataFoto->extension; 
					if (file_exists($rutaSmall)) {
						unlink($rutaSmall);
					}

					$it->imagen = "{$dataFoto->filename}.png";

					$mProducto->save(["id" => $it->id, "imagen" => $it->imagen]);


					$dataFoto = (object) pathinfo($filename);
				}
				
				$this->marcaAguaProducto($it);

				$this->convertirFoto($it->id, $it->imagen, $it);

				$nameSmallImg = "01-small.{$dataFoto->extension}";
	
				$imageSmall = Services::image()
								->withFile($ruta . $dataFoto->filename . "-logo." . $dataFoto->extension)
								->resize(250, 250, true, 'height');
				if (!$imageSmall->save($ruta . $nameSmallImg)) {
					$resp["listProd"] .= "<li>{$it->referencia}</li>";
					$contProd++;
				}
			}
		}

		if ($contProd == 0) {
			$resp['success'] = true;
			$resp['msj'] = "Imagenes de small y/o con logo creadas correctamente";
		} else {
			$resp["msj"] = "Ha ocurrido un error al convertir estas imagenes. <br> <ul>{$resp['listProd']}</ul>"; 
		}

		return $this->response->setJSON($resp);
	}

	public function marcaAguaProducto($prod){
		$ruta = UPLOADS_PRODUCT_PATH ."/" . $prod->id  ."/";
		$filename = $ruta . "{$prod->imagen}";
		$ext = (object) pathinfo($filename);

		//Colocamos la marca de agua
		if (session()->has("logoEmpresa")) {
			//Si la foto no existe la colocamos por defecto
			$logoEmpresa = UPLOADS_CONF_PATH . 'logoEmpresa-small.png';
			if(!file_exists($logoEmpresa)){ 
				Services::image()
					->withFile(UPLOADS_CONF_PATH . session()->get("logoEmpresa"))
					->resize(180, 180, true, 'height')
					->convert(IMAGETYPE_PNG)
					->save($logoEmpresa);
			}

			// Load the stamp and the photo to apply the watermark to
			$im = imagecreatefrompng($filename);
			$stamp = imagecreatefrompng($logoEmpresa);

			// Set the margins for the stamp and get the height/width of the stamp image
			$sx = imagesx($stamp);

			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			imagecopy($im, $stamp, imagesx($im) - $sx - 10, 10, 0, 0, imagesx($stamp), imagesy($stamp));

			imagepng($im, $ruta ."{$ext->filename}-logo.png", 0);
			imagedestroy($im);
		} else {
			Services::image()
					->withFile($filename)
					->convert(IMAGETYPE_PNG)
					->save($ruta . "{$ext->filename}-logo.png");
		}
	}

	function borrar_directorio($dirname) {
		//si es un directorio lo abro
		if (is_dir($dirname)) {
			$dir_handle = opendir($dirname);
			//si no es un directorio devuelvo false para avisar de que ha habido un error
			if (!$dir_handle) return false;

			//recorro el contenido del directorio fichero a fichero
			while($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					//si no es un directorio elemino el fichero con unlink()
					if (!is_dir($dirname."/".$file))
						unlink($dirname."/".$file);
					else //si es un directorio hago la llamada recursiva con el nombre del directorio
						$this->borrar_directorio($dirname.'/'.$file);
				}
			}
			closedir($dir_handle);
		}
				
		//elimino el directorio que ya he vaciado
		rmdir($dirname);
		return true;
	}
}
