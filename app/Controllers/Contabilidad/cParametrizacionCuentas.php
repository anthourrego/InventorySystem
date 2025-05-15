<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\Contabilidad\mParametrizacionCuentas;
use App\Models\Contabilidad\mCatalogoCuentas;

class cParametrizacionCuentas extends BaseController {
	public function index() {
		$this->content['title'] = "Parametrización";
		$this->content['view'] = "Contabilidad/vParametrizacionCuentas";

		$this->LSelect2();

		$this->content["editar"] = validPermissions([120201], true);

		$mCatalogoCuentas = new mCatalogoCuentas();
		$this->content["cuentas"] = $mCatalogoCuentas->getCuentas();

		// Pasar la función a la vista
		$this->content["renderAccountOptions"] = [$this, 'renderAccountOptions'];

		$this->content['js_add'][] = [
			'Contabilidad/jsParametrizacionCuentas.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	private function getIndentation($level) {
		return str_repeat('&nbsp;', $level);
	}

	private function createOptionHtml($cuenta, $indent, $disabled = '') {
		return "<option value='{$cuenta->id}' {$disabled}>{$indent}{$cuenta->nombre}</option>";
	}

	private function getOptionState($cuenta) {
		return ($cuenta->type !== 'CMO') ? 'disabled' : '';
	}

	public function renderAccountByBehavior($behavior, $cuenta, $level = 0) {
		$html = '';
		
		if ($cuenta->comportamiento === $behavior) {
			$indent = $this->getIndentation($level);
			$disabled = $this->getOptionState($cuenta);
			$html .= $this->createOptionHtml($cuenta, $indent, $disabled);
		}

		if (!empty($cuenta->children)) {
			foreach ($cuenta->children as $child) {
				$html .= $this->renderAccountByBehavior($behavior, $child, $level + 1);
			}
		}

		return $html;
	}

	public function renderAccountByParent($id_parent, $cuenta, $level = 0) {
		$html = '';

		if ($cuenta->codigo == $id_parent) {
			$indent = $this->getIndentation($level);
			$disabled = $this->getOptionState($cuenta);
			$html .= $this->createOptionHtml($cuenta, $indent, $disabled);
			
			if (!empty($cuenta->children)) {
				foreach ($cuenta->children as $child) {
					$html .= $this->renderAccountByParent($child->codigo, $child, $level + 1);
				}
			}
		}
		return $html;
	}

	public function renderAccountOptions($behavior, $cuenta, $level = 0, $id_parent = null) {
		if ($id_parent !== null) {
			return $this->renderAccountByParent($id_parent, $cuenta, $level);
		}
		return $this->renderAccountByBehavior($behavior, $cuenta, $level);
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
			$dataSave["id"] = is_array($validar) ? $validar['id'] : $validar->id;
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
