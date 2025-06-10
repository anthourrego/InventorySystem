<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\mAlmacen;
use App\Models\Contabilidad\mCatalogoCuentas;
use \Hermawan\DataTables\DataTable;

class cCatalogoCuentas extends BaseController {
	public function index() {
		$this->content['title'] = "Catálogo de cuentas";
		$this->content['view'] = "Contabilidad/vCatalogoCuentas";

		$this->LMoment();
		$this->LJQueryValidation();
		$this->Lgijgo();

		$this->content['js_add'][] = [
			'Contabilidad/jsCatalogoCuentas.js'
		];

		$this->content['cuentas'] = $this->listaCuentas();

		return view('UI/viewDefault', $this->content);
	}

	public function listaCuentas() {
		$mCatalogoCuentas = new mCatalogoCuentas();
		return $mCatalogoCuentas->getCuentas(0);
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
			"clasificacion" => trim($postData["clasificacion"]),
			"estado" => $postData["estado"] === "true" ? 1 : 0,
			"type" => trim($postData["tipo"]),
			"id_parent" => trim($postData["idParent"]),
			"naturaleza" => trim($postData["naturaleza"]),
			"comportamiento" => trim($postData["comportamiento"]),
		);

		$mCatalogoCuentas = new mCatalogoCuentas();
		if ($mCatalogoCuentas->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "La cuenta <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " la cuenta." . listErrors($mCatalogoCuentas->errors());
		}

		$resp['cuentas'] = $this->listaCuentas();

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");

		$mCatalogoCuentas = new mCatalogoCuentas();

		if($mCatalogoCuentas->delete($id)) {
			$resp["success"] = true;
			$resp['msj'] = "Cuenta eliminada correctamente";
		} else {
			$resp['msj'] = "Error al eliminar cuenta";
		}

		$resp['cuentas'] = $this->listaCuentas();

		return $this->response->setJSON($resp);
	}
}
