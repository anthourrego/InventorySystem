<?php

namespace App\Controllers\Ubicacion;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\Ubicacion\mCiudades;
use App\Models\Ubicacion\mDepartamentos;

class cCiudades extends BaseController {
	
  public function index() {
		$this->content['title'] = "Ciudades";
		$this->content['view'] = "Ubicacion/vCiudades";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
    $this->LSelect2();


    $mDepartamentos = new mDepartamentos();

		$this->content["deptos"] = $mDepartamentos->asObject()->select("nombre, codigo")->where("estado", 1)->findAll();

		$this->content['js_add'][] = [
			'Ubicacion/jsCiudades.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('ciudades c')
        ->select("
            c.id, 
            c.nombre, 
            c.estado, 
            CASE 
                WHEN c.estado = 1 THEN 'Activo' 
                ELSE 'Inactivo' 
            END AS Estadito,
            c.created_at,
            d.nombre AS Departamento,
            c.updated_at,
						c.id_depto
        ")
        ->join("departamentos d", "c.id_depto = d.codigo", "LEFT");

		if($estado != "-1"){
			$query->where("c.estado", $estado);
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
			"nombre" => trim($postData["nombre"]),
      "id_depto" => trim($postData["id_depto"])
		);

		$city = new mCiudades();
		if ($city->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "La ciudad <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " la ciudad." . listErrors($city->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$city = new mCiudades();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($city->save($data)) {
			$resp["success"] = true;
				$resp['msj'] = "Ciudad actualizada correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function getCiudades($depto) {
		$resp["success"] = true;
		$mCiudades = new mCiudades();

		$builder = $mCiudades->asObject()->select("nombre, id")->where("estado", 1);

		if ($depto != 0) {
			$builder = $builder->where("id_depto", $depto);
		}

		$resp["data"] = $builder->findAll();
		return $this->response->setJSON($resp);
	}
}
