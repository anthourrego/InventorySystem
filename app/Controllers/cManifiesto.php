<?php

namespace App\Controllers;
use App\Models\mManifiesto;
use App\Models\mProductos;
use \Hermawan\DataTables\DataTable;

class cManifiesto extends BaseController {

	public function index() {
		$this->content['title'] = "Manifiestos";
		$this->content['view'] = "vManifiesto";
		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
 		];

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		
		$this->content['js_add'][] = [
			'jsManifiesto.js'
		];

		$this->content['css_add'][] = [
			'cssManifiesto.css'
		];

		$this->content['imagenProd'] = (session()->has("imageProd") ? session()->get("imageProd") : 0);

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('manifiestos AS M')
      ->select("
        '' AS eliminar,  
				M.id,
				M.nombre, 
				M.estado, 
				M.ruta_archivo, 
				M.created_at,
				M.updated_at,
				CASE 
						WHEN M.estado = 1 THEN 'Activo' 
						ELSE 'Inactivo' 
				END AS Nombre_Estado
				, T.Total AS Total_Prods_Manifiesto
      ")->join("(
				SELECT 
					COUNT(*) AS Total
					, id_manifiesto 
				FROM productos 
				GROUP BY id_manifiesto
			) AS T", "M.id = T.id_manifiesto", "LEFT");

		if($estado == "2"){
			$query->where("T.Total > 0");
		} else if($estado == "0"){
			$query->where("T.Total IS NULL OR T.Total = 0");
		}

		return DataTable::of($query)->toJson(true);
	}

	public function archivo($file = null){
		$filename = UPLOADS_MANIFEST_PATH ."{$file}"; //<-- specify the image  file
		//Si la foto no existe la colocamos por defecto
		if(is_null($file) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		}
		$mime = mime_content_type($filename); //<-- detect file type
		header('Content-Length: '.filesize($filename)); //<-- sends filesize header
		header("Content-Type: {$mime}"); //<-- send mime-type header
		header("Content-Disposition: inline; filename='{$filename}';"); //<-- sends filename header
		readfile($filename); //<--reads and outputs the file onto the output buffer
		exit(); // or die()
	}

	public function eliminar(){
		$resp["success"] = false;
		$resp['alert'] = true;
		//Traemos los datos del post
		$id = $this->request->getPost("idManifiesto");
		$estado = $this->request->getPost("estado");
		$muchos = $this->request->getPost("muchos");
		$producto = new mProductos();

		$this->db->transBegin();

		if ($muchos == "1") {
			$resp['alert'] = false;
			$todo = $this->request->getPost("todo");
			$manifiesto = new mManifiesto();
			$resp['msj'] = "No fue posible eliminar los manifiestos";
			$total = 0;

			if ($todo == "1") {

				$manifiestos = $manifiesto
					->select("id, nombre, ruta_archivo")
					->join("(
						SELECT 
							COUNT(*) AS Total
							, id_manifiesto 
						FROM productos 
						GROUP BY id_manifiesto
					) AS T", "id = T.id_manifiesto", "LEFT")
					->where("T.Total IS NULL OR T.Total = 0")
					->findAll();

				foreach ($manifiestos as $it) {
					
					if($manifiesto->delete($it['id'])) {
						$filenameDelete = UPLOADS_MANIFEST_PATH . $it['ruta_archivo']; //<-- specify the image  file
						
						if(!@unlink($filenameDelete)) {
							$resp['msj'] = "Error al eliminar documento anexo al manifiesto";
						} else {
							$total++;
						}
					}
				}

				if (count($manifiestos) == $total) {
					$resp["success"] = true;
					$resp['msj'] = "Manifiestos eliminados correctamente";
				}

			} else {
				$selecciones = $this->request->getPost("selecciones");

				foreach ($selecciones as $it) {
					
					if($manifiesto->delete($it['id'])) {
						$filenameDelete = UPLOADS_MANIFEST_PATH . $it['archivo']; //<-- specify the image  file
						
						if(!@unlink($filenameDelete)) {
							$resp['msj'] = "Error al eliminar documento anexo al manifiesto";
						} else {
							$total++;
						}
					};
				}

				if (count($selecciones) == $total) {
					$resp["success"] = true;
					$resp['msj'] = "Manifiestos eliminados correctamente";
				}
			}

		} else {
	
			$prods = $producto->select("descripcion")->where("id_manifiesto IS NULL")->findAll();
	
			if (count($prods) == 0) {	
				$prods = $producto->select("descripcion")->where("id_manifiesto", $id)->findAll();
	
				if (count($prods) == 0) {
					$resp['alert'] = false;
					$manifiesto = new mManifiesto();

					if($manifiesto->delete($id)) {
						$archivo = $this->request->getPost("archivo");
						$filenameDelete = UPLOADS_MANIFEST_PATH . $archivo; //<-- specify the image  file

						if(!@unlink($filenameDelete)) {
							$resp['msj'] = "Error al eliminar documento anexo al manifiesto";
						} else {
							$resp["success"] = true;
							$resp['msj'] = "Manifiesto se ha eliminado correctamente";
						}

					} else {
						$resp['msj'] = "Error al eliminar el manifiesto";
					}
				} else {
					$strProds = "Los siguientes productos pertenecen al manifiesto <br><ul>";
	
					foreach ($prods as $i) $strProds .= "<li>" . $i['descripcion'] . "</li>";
	
					$resp['msj'] = $strProds . "</ul>";
				}
			} else {
				$strProds = "Los siguientes productos no tienen manifiesto registrado <br><ul>";
	
				foreach ($prods as $i) $strProds .= "<li>" . $i['descripcion'] . "</li>";
	
				$resp['msj'] = $strProds . "</ul>";
			}
		}

		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function crearEditar(){
		$resp["success"] = false;
		$filenameDelete = "";
		$manifiesto = new mManifiesto();
		
    // Creamos el manifiesto y llenamos los datos
		$dataManifiesto = array(
			"id" => $this->request->getPost("id")
			,"nombre" => trim($this->request->getPost("nombre"))
		);

		//Validamos si eliminar la foto de perfil y buscamos el manifiesto
		if($this->request->getPost("editFoto") != 0 && !empty($this->request->getPost("id"))) {
			$foto = $manifiesto->find($this->request->getPost("id"))["foto"];
			$dataManifiesto["foto"] = null;
			$filenameDelete = UPLOADS_MANIFEST_PATH . $foto; //<-- specify the image  file
		}

		$this->db->transBegin();
			
		//Validamos si el manifiesto que ingresaron ya existe
		if ($manifiesto->save($dataManifiesto)) {
			//Traemos el id insertado
			$manifiesto->id = empty($this->request->getPost("id")) ? $manifiesto->getInsertID() : $this->request->getPost("id"); 

			$file = $this->request->getFile("fileUpload"); 

			if (!empty($file->getBasename())) {
				//Validamos la foto
				$validated = $this->validate([
					'rules' => [
						'uploaded[fileUpload]',
						'mime_in[fileUpload,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword]',
						'max_size[fileUpload,10240]',
					],
				]);
                
				//Se valida los datos de la imagen
				if ($validated) {
					if ($file->isValid() && !$file->hasMoved()) {
						//Validamos que la imagen suba correctamente
						$name = "{$manifiesto->id}.{$file->getClientExtension()}";
						if ($file->move(UPLOADS_MANIFEST_PATH, $name, true)) {
							$updateFile = array(
								"id" => $manifiesto->id,
								"ruta_archivo" => $name
							);

							if ($manifiesto->save($updateFile)) { 
								$resp["success"] = true;
								$resp["msj"] = "El manifiesto <b>{$manifiesto->nombre}</b> se " . (empty($this->request->getPost("id")) ? 'creo' : 'actualizo') . " correctamente.";
							} else {
								$resp["msj"] = "Ha ocurrido un error al actualizar los datos de el archivo.";
							}
						} else {
							$resp["msj"] = "Ha ocurrido un error al subir el archivo.";
						}
					} else {
						$resp["msj"] = "Error al subir el archivo, {$file->getErrorString()}";
					}
				} else {
					$resp["msj"] = "Error al subir el archivo, " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
				}
			} else {
				$resp["success"] = true;
				$resp["msj"] = "El manifiesto <b>{$manifiesto->nombre}</b> se " . (empty($this->request->getPost("id")) ? 'creo' : 'actualizo') . " correctamente.";
			}
		} else {
			$resp["msj"] = "No puede " . (empty($this->request->getPost("id")) ? 'crear' : 'actualizar') . " el manifiesto." . listErrors($manifiesto->errors());
		}
        
		//Validamos para elminar la foto
		if ($filenameDelete != '' && file_exists($filenameDelete)) {
			if(!@unlink($filenameDelete)) {
				$resp["success"] = false;
				$resp["msj"] = "Error al eliminar el documento, intente de nuevo";
			} 
		}

		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function listaDTProds() {

		$manifiesto = $this->request->getPost("manifiesto");
		$ver = $this->request->getPost("ver");
		
		$query = $this->db->table('productos AS P')
			->select("
					P.id,
					P.referencia,
					P.item,
					P.descripcion,
					P.imagen,
					P.id_manifiesto
			");

		$where = "";
		if (is_null($ver)) {
			$where = "(P.id_manifiesto IS NULL AND P.estado = 1";
			if (!is_null($manifiesto)) {
				$where .= " OR P.id_manifiesto = '$manifiesto'";
			}
			$where .= ")";
		} else {
			$where = "P.id_manifiesto = '$manifiesto'";
		}
		$query = $query->where($where);

		return DataTable::of($query)->toJson(true);
	}

	public function actualizarManifiesto() {
		$resp["success"] = false;
		$filenameDelete = "";
		$producto = new mProductos();
		
    // Creamos el manifiesto y llenamos los datos
		$dataProd = array(
			"id" => $this->request->getPost("idProd")
			, "id_manifiesto" => $this->request->getPost("idManifiesto") == '-1' ? null : trim($this->request->getPost("idManifiesto"))
		);

		$this->db->transBegin();
			
		//Validamos si el manifiesto que ingresaron ya existe
		if ($producto->save($dataProd)) {
			$resp["success"] = true;
			if ($this->request->getPost("idManifiesto") == '-1') {
				$resp["msj"] = "Producto <b>{$producto->nombre}</b> eliminado correctamente.";
			} else {
				$resp["msj"] = "Producto <b>{$producto->nombre}</b> agregado al manifiesto.";
			}
		} else {
			if ($this->request->getPost("idManifiesto") == '-1') {
				$resp["msj"] = "Ha ocurrido un error al quitar el producto.";
			} else {
				$resp["msj"] = "Ha ocurrido un error al agregar el producto.";
			}
		}

		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function descargarVerArchivo($id, $ver) {

		$manifiesto = new mManifiesto();

		$manif = $manifiesto->asObject()->where("id", $id)->find();

		$manif = $manif[0];
		if (isset($manif->ruta_archivo) && !is_null($manif->ruta_archivo)) {
			$path = UPLOADS_MANIFEST_PATH . $manif->ruta_archivo;

			if ($ver == 1) {

				$image = file_get_contents($path);

				if($image === FALSE) {
					show_404();
				} else {

					$file = new \CodeIgniter\Files\File($path);

					$mimeType = $file->getMimeType();
		
					$this->response->setStatusCode(200)
												->setContentType($mimeType)
												->setBody($image)
												->send();
				}

			} else {
				$name = str_replace($id, $manif->nombre, $manif->ruta_archivo);
				return $this->response->download($path, null)->setFileName($name);
			}

		}
	}

}
