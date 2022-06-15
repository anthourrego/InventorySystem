<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mAlmacen;

class cAlmacen extends BaseController {
	public function index() {
		$this->content['title'] = "Almacenes";
		$this->content['view'] = "vAlmacen";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();

		$this->content['js_add'][] = [
			'jsAlmacen.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('almacenes')
				->select("
						id,
						nombre, 
						estado, 
						CASE 
								WHEN estado = 1 THEN 'Activo' 
								ELSE 'Inactivo' 
						END AS Estadito,
						created_at,
						updated_at
				");

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
			"id" => $postData["id"],
			"nombre" => trim($postData["nombre"])
		);

		$mAlmacen = new mAlmacen();
		if ($mAlmacen->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "El almacen <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el almacen." . listErrors($mAlmacen->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$mAlmacen = new mAlmacen();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($mAlmacen->save($data)) {
			$resp["success"] = true;
				$resp['msj'] = "Almacen actualizado correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}
}
