<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\Contabilidad\mParametrizacionCuentas;

class cParametrizacionCuentas extends BaseController {
	public function index() {
		$this->content['title'] = "Parametrización";
		$this->content['view'] = "Contabilidad/vParametrizacionCuentas";

		$this->LSelect2();

		$this->content["editar"] = validPermissions([120201], true);

		$this->content['js_add'][] = [
			'Contabilidad/jsParametrizacionCuentas.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function datos(){
		$resp["success"] = true;
		$mParametrizacionCuentas = new mParametrizacionCuentas();

		$resp["msj"] = $mParametrizacionCuentas->select("campo, valor")->findAll();

		return $this->response->setJSON($resp);
	}

	public function actualizar(){
		$resp["success"] = false;
		$dataPost = $this->request->getPost();

		$mParametrizacionCuentas = new mParametrizacionCuentas();

		$validar = $mParametrizacionCuentas->where('campo', $dataPost["campo"])->first();

		$dataSave = [
			"campo" => $dataPost["campo"],
			"valor" => $dataPost["valor"]
		];

		if (!is_null($validar)) {
			$dataSave["id"] = $validar->id;
		}

		if($mParametrizacionCuentas->save($dataSave)) {
			$resp["success"] = true;
			$resp["msj"] = "<b>{$dataPost['nombre']}</b> se actualizo correctamente.";
		}	else {
			$resp["msj"] = "Error al actualizar <b>{$dataPost['nombre']}</b>.";
		}
		return $this->response->setJSON($resp);
	}

}
