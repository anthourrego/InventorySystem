<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\mPermisos;
use App\Models\mUsuarios;
use App\Models\mConfiguracion;
use App\Models\mAlmacen;

class cPermisos extends BaseController {
	public function Permisos($id, $campo) {
		$permisoModel = new mPermisos();

		$permisos = $permisoModel->select("permiso")->where($campo, $id)->findAll();
		
		return $this->response->setJSON($permisos);
	}

	public function Guardar() {
		$resp["success"] = false;
		$postData = (object) $this->request->getPost();
		$campo = $postData->tipo == 1 ? 'perfilId' : 'usuarioId';

		$permisoModel = new mPermisos();
		
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
	}

	public function sincronizar(){
		$userModel = new mUsuarios();
		$permisoModel = new mPermisos();

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
			'permisos' => $per,
			'imageProd' => (is_null($usuario->imageProd) ? '' : $usuario->imageProd)
		];

		$mConfiguracion = new mConfiguracion();

		$config = $mConfiguracion->select("campo, valor")->findAll(); 

		foreach ($config as $it) {
			$userdata[$it->campo] = $it->valor;
		}

		if (!is_null($usuario->imageProd)) {
			$userdata['imagenProducto'] = $usuario->imageProd;
		}

		$mAlmacen = new mAlmacen();
		if (!is_null($usuario->id_almacen)) {
			$dataAlmacen = $mAlmacen->find($usuario->id_almacen);
		} else {
			//Traemos el primer almacen encontrado en la DB
			$dataAlmacen = $mAlmacen->where("estado", 1)->first();
		}

		$userdata['almacenId'] = $dataAlmacen->id;
		$userdata['nombreAlmacen'] = $dataAlmacen->nombre;

		session()->set($userdata);

		return $this->response->setJSON(true); 
	}
}
