<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\mAlmacen;
use App\Models\Contabilidad\mCuentaMovimientos;
use \Hermawan\DataTables\DataTable;

class cCuentaMovimientos extends BaseController {
	public function index() {

		/* $mCuentaMovimientos = new mCuentaMovimientos();
		$data = $mCuentaMovimientos->guardarCompra(6);
		dd($data); */

		$this->content['title'] = "Movimiento de cuentas";
		$this->content['view'] = "Contabilidad/vCuentaMovimientos";

		$this->LMoment();

		$this->content['js_add'][] = [
			'Contabilidad/jsCuentaMovimientos.js'
		];

		return view('UI/viewDefault', $this->content);
	}
}
