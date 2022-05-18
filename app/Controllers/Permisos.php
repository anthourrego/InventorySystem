<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermisosModel;
use App\Models\UsuariosModel;

class PermisosController extends BaseController {
	public function Permisos($id, $campo) {
		if ($this->request->isAJAX()){ 
			$permisoModel = new PermisosModel();

			$permisos = $permisoModel->select("permiso")->where($campo, $id)->findAll();
			
			return $this->response->setJSON($permisos);
		} else {
			show_404();
		}
	}

	public function Guardar() {
		if ($this->request->isAJAX()){ 
			$resp["success"] = false;
			$postData = (object) $this->request->getPost();
			$campo = $postData->tipo == 1 ? 'perfilId' : 'usuarioId';

			$permisoModel = new PermisosModel();
			
			$this->db->transBegin();

			if ($permisoModel->where($campo, $postData->id)->delete()) {
				if (isset($postData->checked) && count($postData->checked) > 0) {
					foreach ($postData->checked as $it) {
						$dataSave = [
							$campo => $postData->id,
							"permiso" => $it
						];

						if ($permisoModel->save($dataSave)) {
							$resp["success"] = true;		
						} else {
							$resp["success"] = false;		
							break;
						}
					}
				} else {
					$resp["success"] = true;
				}
				
			} else {
				$resp["msj"] = "No es posible actualizar los permisos del perfil.";
			}
			
			if($resp["success"] == true){
				$resp["msj"] = "Permisos actualizados correctamente";
				$this->db->transCommit();
			} else {
				$this->db->transRollback();
			}

			return $this->response->setJSON($resp);
		} else {
			show_404();
		}
	}

	public function sincronizar(){
		if ($this->request->isAJAX()){ 
			$userModel = new UsuariosModel();
			$permisoModel = new PermisosModel();

			$usuario = $userModel->asObject()->find(session()->get("id_user"));

			$id = $usuario->perfil == null ? session()->get("id_user") : $usuario->perfil;
			$campo = $usuario->perfil == null ? 'usuarioId' : 'perfilId';
			$permisos = $permisoModel->select("permiso")->where($campo, $id)->findAll();
			
			$per = [];
			foreach ($permisos as $it) {
					$per[] = $it->permiso;
			}

			$userdata = [
				'nombre'  => $usuario->nombre,
				'usuario'     => $usuario->usuario,
				'perfil'     => $usuario->perfil,
				'foto'     => $usuario->foto,
				'logged_in' => true,
				'permisos' => $per
			];

			$this->session->set($userdata);

			return $this->response->setJSON(true); 
		} else {
			show_404();
		}
	}
}
