<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mClientes;
use App\Models\mSucursalesCliente;

class cClientes extends BaseController {
	public function index() {
		$this->content['title'] = "Clientes";
		$this->content['view'] = "vClientes";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LInputMask();
		$this->LSelect2();

		$this->content['js_add'][] = [
			'jsClientes.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");
		$departamentoSucursal = $this->request->getPost("departamentoSucursal");
		$ciudadSucursal = $this->request->getPost("ciudadSucursal");

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
													S.sucursales
											");

		if($estado != "-1"){
			$query->where("estado", $estado);
		}

		$where = "";
		if(!is_null($departamentoSucursal) && $departamentoSucursal != "-1") {
			$where = "WHERE id_depto = '$departamentoSucursal'";
			$where .= (!is_null($ciudadSucursal) && $ciudadSucursal != "-1") ? " AND id_ciudad = '$ciudadSucursal'" : "";
		}
		$query->join("(
			SELECT 
				GROUP_CONCAT(' ', nombre) AS sucursales
				, id_cliente 
			FROM sucursales
			$where
			GROUP BY id_cliente
		) AS S", "clientes.id = S.id_cliente", ($where == "" ? "LEFT" : "INNER"));

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
			/* "administrador" => trim($postData["administrador"]),
			"cartera" => trim($postData["cartera"]),
			"telefonocart" => trim($postData["telefonoCart"]), */
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

	public function getClientes(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$limit = 10;
		$offset = ($data->page - 1) * $limit;  
		$clienteModel = new mClientes();

		if (isset($data->search) && strlen(trim($data->search))) {
			$resp['data'] = $clienteModel->select("
					clientes.id,
					CONCAT(clientes.documento, ' | ', clientes.nombre, ' | ', IF(C.nombre IS NULL, '', C.nombre)) AS text
				")
				->join("sucursales AS S", "clientes.id = S.id_cliente", "left")
				->join("ciudades AS C", "S.id_ciudad = C.id", "left")
				->where("clientes.estado", 1)
				->like('clientes.documento', $data->search)
				->orLike('clientes.nombre', $data->search)
				->orLike('C.nombre', $data->search)
				->findAll($limit, $offset);

			$resp['total_count'] = $clienteModel->like('documento', $data->search)
																					->orLike('nombre', $data->search)
																					->where("estado", 1)
																					->countAllResults();
		} else {
			$resp['data'] = $clienteModel->select("
					clientes.id,
					CONCAT(clientes.documento, ' | ', clientes.nombre, ' | ', IF(C.nombre IS NULL, '', C.nombre)) AS text
				")
				->join("sucursales AS S", "clientes.id = S.id_cliente", "left")
				->join("ciudades AS C", "S.id_ciudad = C.id", "left")
				->where("clientes.estado", 1)
				->findAll($limit, $offset);

			$resp['total_count'] = $clienteModel->where("estado", 1)->countAllResults();
		}

		return $this->response->setJSON($resp);
	}

	public function inicioAppCliente() {
		$resp["success"] = false;
		$data = (object) $this->request->getPost();
		$clienteModel = new mClientes();
		$sucursalModel = new mSucursalesCliente();

		if (isset($data->username) && strlen(trim($data->username))) {

			if (isset($data->password) && strlen(trim($data->password))) {

				$clienteModel = $clienteModel->like('nombre', $data->username);
				if ($clienteModel->countAllResults() > 0) {
					
					$cliente = $clienteModel->where('documento', $data->password)->get()->getRow();

					if (!is_null($cliente)) {

						$sucursales = $sucursalModel->select("id, nombre, direccion, telefono")
							->where('id_cliente', $cliente->id)
							->findAll();

						$resp["success"] = true;
						$resp['cliente'] = array(
							"nombre" => $cliente->nombre,
							"direccion" => $cliente->direccion,
							"telefono" => $cliente->telefono,
							"id" => $cliente->id,
							"sucursales" => $sucursales,
							"isAdmin" => ($data->username == "Neider")
						);
					} else {
						$resp['msg'] = "No se encontro usuario";
					}
				} else {
					$resp['msg'] = "No se encontro usuario";
				}
			} else {
				$resp['msg'] = "No se encontro contraseña relacionada";
			}
		} else {
			$resp['msg'] = "No se encontro usuario relacionado";
		}
		return $this->response->setJSON($resp);
	}
}
