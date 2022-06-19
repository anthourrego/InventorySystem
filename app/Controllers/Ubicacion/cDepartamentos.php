<?php

namespace App\Controllers\Ubicacion;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\Ubicacion\mDepartamentos;
use App\Models\Ubicacion\mPaises;

class cDepartamentos extends BaseController {
	
  public function index() {
		$this->content['title'] = "Departamentos";
		$this->content['view'] = "Ubicacion/vDepartamentos";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
    $this->LSelect2();

    $mPaises = new mPaises();

		$this->content["paises"] = $mPaises->asObject()->select("nombre, id")->where("estado", 1)->findAll();

		$this->content['js_add'][] = [
			'Ubicacion/jsDepartamentos.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('departamentos d')
        ->select("
            d.id, 
            d.nombre, 
            d.estado,
						d.id_pais,
            CASE 
                WHEN d.estado = 1 THEN 'Activo' 
                ELSE 'Inactivo' 
            END AS Estadito,
            d.created_at,
            d.updated_at,
            p.nombre AS Pais,
						d.codigo
        ")
        ->join("Paises p", "d.id_pais = p.id", "LEFT");

		if($estado != "-1"){
			$query->where("d.estado", $estado);
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
			"codigo" => trim($postData["codigo"]),
      "id_pais" => trim($postData["id_pais"])
		);

		$depto = new mDepartamentos();
		if ($depto->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "El departamento <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el departamento." . listErrors($depto->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$depto = new mDepartamentos();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($depto->save($data)) {
			$resp["success"] = true;
				$resp['msj'] = "Departamento actualizado correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function validarDepto($campo, $nombre, $id){
		$depto = new mDepartamentos();

		$depto2 = $depto->asObject()->where([$campo => $nombre, "id != " => $id])->countAllResults();

		return $this->response->setJSON($depto2);
	}
}
