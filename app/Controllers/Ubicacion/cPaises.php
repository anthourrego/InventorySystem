<?php

namespace App\Controllers\Ubicacion;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\Ubicacion\mPaises;

class cPaises extends BaseController {
	
  public function index() {
		$this->content['title'] = "Paises";
		$this->content['view'] = "Ubicacion/vPaises";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();

		$this->content['js_add'][] = [
			'Ubicacion/jsPaises.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('paises')
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

		$pais = new mPaises();
		if ($pais->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "El pais <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el pais." . listErrors($pais->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$pais = new mPaises();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($pais->save($data)) {
			$resp["success"] = true;
				$resp['msj'] = "Pais actualizado correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function getPaises() {
		$resp["success"] = true;
		$mPaises = new mPaises();
		$resp["data"] = $mPaises->asObject()->select("nombre, id")->where("estado", 1)->findAll();
		return $this->response->setJSON($resp);
	}
}
