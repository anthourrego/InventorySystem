<?php

namespace App\Controllers;
use App\Models\mUsuarios;
use App\Models\mConfiguracion;

class cMiPerfil extends BaseController {

	public function index() {
		$this->content['title'] = "Mi Perfil";
		$this->content['view'] = "vMiPerfil";

		unset($this->content['css']);
		unset($this->content['css_add']);
		unset($this->content['js']);
		unset($this->content['js_add']);
		
		$this->LJQueryValidation();
		$this->LSelect2();
		$this->LCropperImageEditor();

		$this->content['cssMiP'] = $this->content['css'];

		$this->content['jsMiP'] = $this->content['js'];
		
		$this->content['js_addMiP'] = $this->content['js_add'];

		$this->content['js_addMiP'][] = [
			'jsMiPerfil.js'
		];

		$user = new mUsuarios();

		$this->content['usuario'] = $user->asObject()->where(["id = " => session()->get("id_user")])->first();

		$this->content['usuarioId'] = session()->get("id_user");

		return view('vMiPerfil', $this->content);
	}

	public function editar(){
		$resp["success"] = false;
		$filenameDelete = "";
		$user = new mUsuarios();
		//Creamos el usuario y llenamos los datos
		$usuario = array(
			"id" => $this->request->getPost("id")
			,"usuario" => trim($this->request->getPost("usuario"))
			,"nombre" => trim($this->request->getPost("nombre"))
		);

		if (empty($this->request->getPost("id"))) {
			$usuario["password"] = password_hash(trim($this->request->getPost("pass")), PASSWORD_DEFAULT, array("cost" => 15));
		}

		//Validamos si eliminar la foto de perfil y buscamos el usuario
		if($this->request->getPost("editFoto") != 0) {
			$foto = $user->find($this->request->getPost("id"))["foto"];
			$usuario["foto"] = null;
			$filenameDelete = UPLOADS_USER_PATH . $foto; //<-- specify the image  file
		}

		$this->db->transBegin();

		//Validamos para elminar la foto
		if ($filenameDelete != '' && file_exists($filenameDelete)) {
			if(!@unlink($filenameDelete)) {
				$resp["success"] = false;
				$resp["msj"] = "Error al eliminar la foto de perfil, intente de nuevo";
			} 
		}
			
		//Validamos si el usuario que ingresaron ya existe
		if ($user->save($usuario)) {
			//Traemos el id insertado
			$user->id = $this->request->getPost("id");
			$imgFoto = $this->request->getFile("foto"); 
			if (!empty($imgFoto->getBasename())) {
				//Validamos la foto
				$validated = $this->validate([
					'rules' => [
						'uploaded[foto]',
						'mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]',
						'max_size[foto,2048]',
					],
				]);
                
				//Se valida los datos de la imagen
				if ($validated) {
					if ($imgFoto->isValid() && !$imgFoto->hasMoved()) {
						//Validamos que la imagen suba correctamente
						$nameImg = "{$user->id}.png";
						
						if ($imgFoto->move(UPLOADS_USER_PATH, $nameImg, true)) {
							
							$updateFoto = array("id" => $user->id, "foto" => $nameImg);

							if ($user->save($updateFoto)) { 
								$resp["success"] = true;
								$resp["msj"] = "Datos actualizados.";
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
				$resp["msj"] = "Datos actualizados.";
			}
		} else {
			$resp["msj"] = "No puede se puede actualizar el usuario." . listErrors($user->errors());
		}

		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function password() {
		$resp["success"] = false;
		$filenameDelete = "";
		$user = new mUsuarios();
	
		$passAct = password_hash(trim($this->request->getPost("passActual")), PASSWORD_DEFAULT, array("cost" => 15));

		$usuario = $user->find($this->request->getPost("id"));

		if (password_verify($this->request->getPost("passActual"), $usuario['password'])) {
			//Creamos el usuario y llenamos los datos
			$usuario = array(
				"id" => $this->request->getPost("id")
				,"password" => password_hash(trim($this->request->getPost("passMi")), PASSWORD_DEFAULT, array("cost" => 15))
				,"usuario" => $usuario['usuario']
				,"nombre" => $usuario['nombre']
			);
	
			$this->db->transBegin();
	
			//Validamos si el usuario que ingresaron ya existe
			if ($user->save($usuario)) {
				$resp["success"] = true;
				$resp["msj"] = "Contraseña Actualizada.";
			} else {
				$resp["msj"] = "No puede se puede actualizar el usuario." . listErrors($user->errors());
			}
		} else {
			$resp["msj"] = "Contraseña actual incorrecta.";
		}


		if($resp["success"] == true){
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	public function actualizar() {
		$resp["success"] = false;
		$dataPost = $this->request->getPost();

		$builder = $this->db->table('usuarios')
												->set($dataPost["campo"], ($dataPost["valor"] == -1 ? null : $dataPost["valor"]))
												->where('id', session()->get("id_user"));
		
		if($builder->update()) {
			$resp["success"] = true;
			$session[$dataPost["campo"]] = ($dataPost["valor"] == -1 ? 0 : $dataPost["valor"]);
			if ($dataPost["valor"] == -1) {
				$mConfiguracion = new mConfiguracion();
				$config = $mConfiguracion->select("valor")->where("campo", $dataPost["campo"])->first();
				if (!is_null($config)) {
					$session[$dataPost["campo"]] = $config->valor;
				}
			}
			session()->set($session);
			$resp["msj"] = "<b>{$dataPost['nombre']}</b> se actualizo correctamente.";
		}	else {
			$resp["msj"] = "Error al actualizar <b>{$dataPost['nombre']}</b>.";
		}
		return $this->response->setJSON($resp);
	}

}
