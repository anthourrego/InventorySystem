<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mSucursalesCliente;

class cSucursales extends BaseController {
	
  public function index() {}

	public function listaDT(){
		$estado = $this->request->getPost("estado");
    $cliente = $this->request->getPost("cliente");

		$query = $this->db->table('sucursales s')
      ->select("
          s.id, 
          s.nombre, 
          s.direccion, 
          s.administrador, 
          s.cartera, 
          s.telefonocart, 
					s.telefono, 
          s.estado,
          s.created_at,
          s.updated_at,
					s.id_depto,
					s.id_ciudad,
					c.nombre AS ciudad,
          CASE 
              WHEN s.estado = 1 THEN 'Activo' 
              ELSE 'Inactivo' 
          END AS Estadito,
      ")
			->join("ciudades c", "s.id_ciudad = c.id", "LEFT")
      ->where("s.id_cliente", $cliente);

		if($estado != "-1"){
			$query->where("s.estado", $estado);
		}

		return DataTable::of($query)->toJson(true);
	}

	public function crearEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$postData = $this->request->getPost();
		//Creamos los datos para guardar
		$datosSave = array(
			"id" => $postData["idSucursal"],
			"nombre" => trim($postData["nombreSucursal"]),
			"direccion" => trim($postData["direccionSucursal"]),
			"administrador" => trim($postData["administradorSucursal"]),
			"cartera" => trim($postData["carteraSucursal"]),
			"telefonocart" => trim($postData["telefonoCartSucursal"]),
			"telefono" => trim($postData["telefonoSucursal"]),
      "id_cliente" => $postData["id_cliente"],
			"id_depto" => $postData["id_deptoSucursal"],
			"id_ciudad" => $postData["id_ciudadSucursal"],
		);

		$sucursal = new mSucursalesCliente();
		if ($sucursal->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "La sucursal <b>{$datosSave["nombre"]}</b> se " . (empty($postData['idSucursal']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['idSucursal']) ? 'crear' : 'actualizar') . " la sucursal." . listErrors($sucursal->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$cliente = new mSucursalesCliente();
        
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($cliente->save($data)) {
			$resp["success"] = true;
			$resp['msj'] = "Sucursal actualizada correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function getSucursales(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$limit = 10;
		$offset = ($data->page - 1) * $limit;  
		$sucursal = new mSucursalesCliente();
		
		$cliente = trim($data->cliente);

		if (isset($data->search) && strlen(trim($data->search))) {
			$resp['data'] = $sucursal->select("id, nombre AS text")
					->where("estado", 1)
					->where("id_cliente", $cliente)
					->like('nombre', $data->search)
					->findAll($limit, $offset);

			$resp['total_count'] = $sucursal->like('nombre', $data->search)
					->where("estado", 1)
					->where("id_cliente", $cliente)
					->countAllResults();
		} else {
			$resp['data'] = $sucursal->select("id, nombre AS text")
					->where("estado", 1)
					->where("id_cliente", $cliente)
					->findAll($limit, $offset);

			$resp['total_count'] = $sucursal->where("estado", 1)
					->where("id_cliente", $cliente)
					->countAllResults();
		}

		return $this->response->setJSON($resp);
	}

}
