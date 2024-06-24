<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use firebaseRDB;

class Showroom extends BaseController
{
	public function index()
	{
		$this->content['title'] = "Showroom";
		$this->content['view'] = "vShowroom";

		/* $this->LDataTables();
		$this->LMoment();

		$this->content['js_add'][] = [
			'Ventas/jsAdministrador.js',
			'ProductosReportados/jsProductosReportadosAcciones.js'
		]; */

		return view('UI/viewDefault', $this->content);
	}
}
