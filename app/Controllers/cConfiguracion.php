<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\mConfiguracion;

class cConfiguracion extends BaseController {
	public function index() {
		$this->content['title'] = "Configuración";
		$this->content['view'] = "vConfiguracion";

		$this->LSelect2();

		$this->content["editar"] = validPermissions([71], true);

		$this->content['css_add'][] = [
			'cssConfiguracion.css'
		];

		$this->content['js_add'][] = [
			'jsConfiguracion.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function datos(){
		$resp["success"] = true;
		$mConfiguracion = new mConfiguracion();

		$resp["msj"] = $mConfiguracion->select("campo, valor")->findAll();

		return $this->response->setJSON($resp);
	}

	public function actualizar(){
		$resp["success"] = false;
		$dataPost = $this->request->getPost();

		$mConfiguracion = new mConfiguracion();

		$validar = $mConfiguracion->where('campo', $dataPost["campo"])->first();

		$dataSave = [
			"campo" => $dataPost["campo"],
			"valor" => $dataPost["valor"]
		];
		
		if (!is_null($validar)) {
			$dataSave["id"] = $validar->id;
		}

		if($mConfiguracion->save($dataSave)) {
			$resp["success"] = true;
			$resp["msj"] = "<b>{$dataPost['nombre']}</b> se actualizo corractamente.";
		}	else {
			$resp["msj"] = "Error al actualizar <b>{$dataPost['nombre']}</b>.";
		}	

		return $this->response->setJSON($resp);
	}
}
