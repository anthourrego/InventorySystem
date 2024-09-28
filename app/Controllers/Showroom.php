<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\ThirdParty\firebaseRDB;
use App\Models\mShoowroom;
use App\Models\mProductos;

class Showroom extends BaseController
{
	public function index()
	{
		$this->content['title'] = "Showroom";
		$this->content['view'] = "vShowroom";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();

		$this->content['js_add'][] = [
			'jsShowroom.js'
		];

		$showroomModel = new mShoowroom();
		$this->content['statusDescription'] = $showroomModel->getStatusDescription();
		$this->content['currentShowroom'] = $this->validCurrentShowroom(true)["showroom"];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$showroomModel = new mShoowroom();
		$caseStatus = $showroomModel->caseStatusDescription();
		$table = $showroomModel->getTable();

		$showroomModel->select("
				{$table}.id, 
				{$table}.nombre,
				{$table}.fechaInicio,
				{$table}.leerQR,
				(CASE {$table}.leerQR WHEN 1 THEN 'Si' ELSE 'No' END) As leerQRDesc,
				{$table}.muestraValor,
				(CASE {$table}.muestraValor WHEN 1 THEN 'Si' ELSE 'No' END) As muestraValorDesc,
				{$table}.inventarioNegativo,
				(CASE {$table}.inventarioNegativo WHEN 1 THEN 'Si' ELSE 'No' END) As inventarioNegativoDesc,
				{$table}.estado,
				({$caseStatus}) As estadoDesc,
				{$table}.created_at,
				{$table}.updated_at
			");

		return DataTable::of($showroomModel)->toJson(true);
	}

	public function crear(){
		$resp["success"] = false;
		//Traemos los datos del post
		$postData = $this->request->getPost();
		//Creamos los datos para guardar
		$datosSave = (object) [
			"nombre" => trim($postData["nombre"]),
			"descripcion" => trim($postData["descripcion"]),
			"leerQR" => trim($postData["leerQR"]),
			"muestraValor" => trim($postData["muestraValor"]),
			"inventarioNegativo" => trim($postData["inventarioNegativo"]),
			"estado" => "PE"
		];

		$showroomModel = new mShoowroom();
		if ($showroomModel->save($datosSave)) {
			$resp["success"] = true;
			$resp["msg"] = "La sucursal <b>{$datosSave->nombre}</b> se creo correctamente.";
		} else {
			$resp["msg"] = "No puede crear el Showroom." . listErrors($showroomModel->errors());
		}

		return $this->response->setJSON($resp);
	}

	function validCurrentShowroom($return = false){
		$resp["success"] = false;
		$resp["msg"] = "";
		$resp["alert"] = false;
		$resp["showroom"] = null;
		$firebaseRDB = new firebaseRDB();
		$data = $firebaseRDB->retrieve("showroom");
		
		if (isset($data->error)) {
			$resp["alert"] = true;
			$resp["msg"] = $data->error;
			if ($return){
				return $resp;
			} else {
				return $this->response->setJSON($resp);
			}
		}

		if (
			is_null($data) ||
			!is_object($data) ||
			$data == "" ||
			!isset($data->show1) || 
			!is_object($data->show1) ||
			$data->show1 == ""
		) {
			$resp["msg"] = "Actualmente no hay un Showroom iniciado";
			if ($return){
				return $resp;
			} else {
				return $this->response->setJSON($resp);
			}
		}

		//Validamos si el id existe en la base de datos
		$resp["success"] = true;
		$resp["showroom"] = $data->show1;
		$resp["msg"] = "Showroom iniciado.";

		if ($return){
			return $resp;
		} else {
			return $this->response->setJSON($resp);
		}
	}

	public function changeStatusShowroom(){ 
		$postData = (object) $this->request->getPost();

		switch ($postData->type) {
			case 'init':
				return $this->iniciarShowroom($postData->showroom);
				break;
			
			default:
				# code...
				break;
		}
	}

	function iniciarShowroom($showroom) {
		$resp["success"] = false;
		$resp["msj"] = "";
		$firebaseRDB = new firebaseRDB();
		$showroom = is_null($showroom) ? null : (object) $showroom;

		$firebaseRDB->delete("showroom");
		$firebaseRDB->delete("productos");
		$firebaseRDB->delete("alertas");
		$firebaseRDB->delete("sucursales");

		$dataSave = [
			"id" => $showroom->id,
			"nombre" => $showroom->nombre,
			"muestraValor" => ($showroom->muestraValor == "1" ? true : false),
			"inventarioNegativo" => ($showroom->inventarioNegativo == "1" ? true : false),
			"leerQr" => ($showroom->leerQR == "1" ? true : false),
			"estado" => "PE",
			"fechaInicio" => date("Y-m-d H:i:s"),
			"fechaRegistro" => $showroom->created_at
		];

		$firebaseRDB->insert("showroom/show1");
		$firebaseRDB->update("showroom", "show1", $dataSave);

		$mProductos = new mProductos();

		$dataProductos = $mProductos->asObject()->where("stock >", 50)->findAll();

		$cont = 1;
		$productoSave = [];
		foreach ($dataProductos as $producto) {
			$productoSave["prod{$producto->id}"] = (object) [
				"id" => $producto->id,
				"orden" => $cont,
				"cantidad" => $producto->stock,
				"estado" => "PE",
				"imagen" => "",
				"item" => $producto->item,
				"nombre" => $producto->descripcion,
				"precioVenta" => $producto->precio_venta,
				"referencia" => $producto->referencia
			];
			$cont++;
		}
		$firebaseRDB->insert("productos");
		$firebaseRDB->update("productos", null, $productoSave);

		$showroomModel = new mShoowroom();
		$showroom->estado = "AC";

		if ($showroomModel->save($showroom)) {
			$resp["success"] = true;
			$resp["msj"] = "El showroom {$showroom->nombre} se inicio correctamente.";
		} else {
			$resp["msj"] = "No puede iniciar el showroom." . listErrors($showroomModel->errors());
		}

		return $this->response->setJSON($resp);
	}
}
