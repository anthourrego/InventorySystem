<?php

namespace App\Controllers\ProductosReportados;
use App\Controllers\BaseController;

class cProductosReportadosMenu extends BaseController {
	public function index() {
		$this->content['title'] = "Reporte de Empaque";
    	$this->content['view'] = "ProductosReportados/vProductosReportadosMenu";

		$this->LDataTables();

		$this->content['js_add'][] = [
			'ProductosReportados/jsProductosReportadosMenu.js'
		];

		return view('UI/viewDefault', $this->content);
	}
}
