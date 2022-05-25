<?php

namespace App\Controllers;
use App\Models\mManifiesto;
use \Hermawan\DataTables\DataTable;

class cManifiesto extends BaseController {

	public function index() {
		$this->content['title'] = "Manifiestos";
		$this->content['view'] = "vManifiesto";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		
		$this->content['js_add'][] = [
			'jsManifiesto.js'
		];

		$this->content['css_add'][] = [
			'cssManifiesto.css'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('manifiestos AS M')
      ->select("
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
      ");

		if($estado != "-1"){
			$query->where("M.estado", $estado);
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
		//Traemos los datos del post
		$id = $this->request->getPost("idManifiesto");
		$estado = $this->request->getPost("estado");

		$manifiesto = new mManifiesto();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($manifiesto->save($data)) {
			$resp["success"] = true;
			$resp['msj'] = "Manifiesto se ha actualizado correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
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
			$foto = $user->find($this->request->getPost("id"))["foto"];
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
								$resp["msj"] = "El manifiesto <b>{$manifiesto->nombre}</b> se creo correctamente.";
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
				$resp["msj"] = "El manifiesto <b>{$manifiesto->nombre}</b> se creo correctamente.";
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

	public function getManifiesto(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
        
		$userModel = new mManifiesto();

		$result = $userModel->like('nombre', $data->buscar)->orLike('nombre', $data->buscar)->find();
        
		if(count($result) == 1) {
			$resp["success"] = true;
			$resp["data"] = $result[0]; 
		}

		return $this->response->setJSON($resp);
	}
}
