<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mProveedores;

class cProveedores extends BaseController {

	public function index() {
		$this->content['title'] = "Proveedores";
		$this->content['view'] = "vProveedores";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LInputMask();
		$this->LSelect2();

		$this->content['js_add'][] = [
			'jsProveedores.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$estado = $this->request->getPost("estado");
		$paisProveedor = $this->request->getPost("paisProveedor");
		$departamentoProveedor = $this->request->getPost("departamentoProveedor");
		$ciudadProveedor = $this->request->getPost("ciudadProveedor");

		$query = $this->db->table('proveedores')
											->select("
													proveedores.id, 
													proveedores.nit, 
													proveedores.nombre, 
													proveedores.estado,
													proveedores.telefono, 
													proveedores.direccion, 
													proveedores.contacto, 
													proveedores.telefonocontacto AS telefonoContacto, 
													P.nombre AS pais,
													proveedores.id_pais,
													proveedores.id_depto,
													D.nombre AS depto,
													C.nombre AS ciudad, 
													proveedores.id_ciudad,
													proveedores.created_at,
													proveedores.updated_at,
													CASE 
															WHEN proveedores.estado = 1
																THEN 'Activo' 
															ELSE 'Inactivo' 
													END AS NombreEstado
											");

		if($estado != "-1"){
			$query->where("proveedores.estado", $estado);
		}

		if(!is_null($paisProveedor) && $paisProveedor != "-1") {
			$query->where("proveedores.id_pais", $paisProveedor);
		}
		
		if(!is_null($departamentoProveedor) && $departamentoProveedor != "-1") {
			$query->where("proveedores.id_depto", $departamentoProveedor);
		}
		
		if(!is_null($ciudadProveedor) && $ciudadProveedor != "-1") {
			$query->where("proveedores.id_ciudad", $ciudadProveedor);
		}

		$query->join("paises AS P", "proveedores.id_pais = P.id", "LEFT");
		$query->join("departamentos AS D", "proveedores.id_depto = D.id", "LEFT");
		$query->join("ciudades AS C", "proveedores.id_ciudad = C.id", "LEFT");

		return DataTable::of($query)->toJson(true);
	}

	public function validaProveedor($nroDocumento, $id) {
		$user = new mProveedores();

		$usuario = $user->asObject()
										->where(['nit' => $nroDocumento, "id != " => $id])
              		  ->countAllResults();

		return $this->response->setJSON($usuario);
	}

	public function crearEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$postData = $this->request->getPost();
		//Creamos los datos para guardar
		$datosSave = array(
			"id" => $postData["id"],
			"nit" => trim($postData["nit"]),
			"nombre" => trim($postData["nombre"]),
			"direccion" => trim($postData["direccion"]),
			"telefono" => trim($postData["telefono"]),
			"contacto" => trim($postData["contacto"]),
			"telefonocontacto" => trim($postData["telefonocontacto"]),
			"id_pais" => trim($postData["id_pais"]),
			"id_depto" => trim($postData["id_depto"]),
			"id_ciudad" => trim($postData["id_ciudad"]),
		);

		$proveedorModel = new mProveedores();
		if ($proveedorModel->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "El proveedor <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
			$resp['id'] = (empty($postData['id']) ? $proveedorModel->getInsertID() : $postData['id']);
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el proveedor." . listErrors($proveedorModel->errors());
		}
		return $this->response->setJSON($resp);
	}

	public function eliminar() {
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$proveedor = new mProveedores();
        
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($proveedor->save($data)) {
			$resp["success"] = true;
			$resp['msj'] = "Proveedor actualizada correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}
		return $this->response->setJSON($resp);
	}

	public function getProveedores(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$limit = 10;
		$offset = ($data->page - 1) * $limit;  
		$proveedorModel = new mProveedores();

		if (isset($data->search) && strlen(trim($data->search))) {
			$resp['data'] = $proveedorModel->select("
					proveedores.id,
					CONCAT(proveedores.nit, ' | ', proveedores.nombre, ' | ', IF(C.nombre IS NULL, '', C.nombre)) AS text
				")
				->join("ciudades AS C", "proveedores.id_ciudad = C.id", "left")
				->where("proveedores.estado", 1)
				->like('proveedores.nit', $data->search)
				->orLike('proveedores.nombre', $data->search)
				->orLike('C.nombre', $data->search)
				->findAll($limit, $offset);

			$resp['total_count'] = $proveedorModel->like('proveedores.nit', $data->search)
																					->orLike('proveedores.nombre', $data->search)
																					->where("proveedores.estado", 1)
																					->countAllResults();
		} else {
			$resp['data'] = $proveedorModel->select("
					proveedores.id,
					CONCAT(proveedores.nit, ' | ', proveedores.nombre, ' | ', IF(C.nombre IS NULL, '', C.nombre)) AS text
				")
				->join("ciudades AS C", "proveedores.id_ciudad = C.id", "left")
				->where("proveedores.estado", 1)
				->findAll($limit, $offset);

			$resp['total_count'] = $proveedorModel->where("proveedores.estado", 1)->countAllResults();
		}

		return $this->response->setJSON($resp);
	}
}
