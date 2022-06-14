<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mSucursalesCliente;

class cSucursales extends BaseController {
	
  public function index() {}

	public function listaDT(){
		$estado = $this->request->getPost("estado");
    $cliente = $this->request->getPost("cliente");

		$query = $this->db->table('sucursales')
      ->select("
          id, 
          nombre, 
          direccion, 
          administrador, 
          cartera, 
          telefonocart, 
          estado, 
          created_at,
          updated_at,
          CASE 
              WHEN estado = 1 THEN 'Activo' 
              ELSE 'Inactivo' 
          END AS Estadito,
      ")
      ->where("id_cliente", $cliente);

		if($estado != "-1"){
			$query->where("estado", $estado);
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
      "id_cliente" => $postData["id_cliente"],
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

}
