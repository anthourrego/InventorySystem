<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mClientes;

class cClientes extends BaseController {
	public function index() {
		$this->content['title'] = "Clientes";
		$this->content['view'] = "vClientes";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LInputMask();

		$this->content['js_add'][] = [
			'jsClientes.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('clientes')
											->select("
													id, 
													documento, 
													nombre, 
													direccion, 
													telefono, 
													administrador, 
													cartera, 
													telefonocart, 
													compras, 
													ultima_compra, 
													estado, 
													created_at,
													updated_at,
													CASE 
															WHEN estado = 1 THEN 'Activo' 
															ELSE 'Inactivo' 
													END AS Estadito,
											");

		if($estado != "-1"){
			$query->where("estado", $estado);
		}

		return DataTable::of($query)->toJson(true);
	}

	public function validaCliente($nroDocumento, $id){
		$user = new mClientes();

		$usuario = $user->asObject()
										->where(['documento' => $nroDocumento, "id != " => $id])
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
			"documento" => trim($postData["documento"]),
			"nombre" => trim($postData["nombre"]),
			"direccion" => trim($postData["direccion"]),
			"telefono" => trim($postData["telefono"]),
			"administrador" => trim($postData["administrador"]),
			"cartera" => trim($postData["cartera"]),
			"telefonocart" => trim($postData["telefonoCart"]),
		);

		$clienteModel = new mClientes();
		if ($clienteModel->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "El cliente <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
			$resp['id'] = (empty($postData['id']) ? $clienteModel->getInsertID() : $postData['id']);
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el cliente." . listErrors($clienteModel->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$cliente = new mClientes();
        
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($cliente->save($data)) {
			$resp["success"] = true;
			$resp['msj'] = "Cliente actualizada correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function getCliente(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
        
		$clienteModel = new mClientes();

		$result = $clienteModel->like('documento', $data->buscar)
													->orLike('nombre', $data->buscar)
													->find();

		if(count($result) == 1) {
			$resp["success"] = true;
			$resp["data"] = $result[0]; 
		}

		return $this->response->setJSON($resp);
	}
}
