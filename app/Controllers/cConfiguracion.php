<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class cConfiguracion extends BaseController {
	public function index() {
		$this->content['title'] = "Configuración";
		$this->content['view'] = "vConfiguracion";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LInputMask();

		$this->content['js_add'][] = [
			'jsConfiguracion.js'
		];

		return view('UI/viewDefault', $this->content);
	}
}
