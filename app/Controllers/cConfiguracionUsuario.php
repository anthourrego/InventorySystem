<?php

namespace App\Controllers;

class cConfiguracionUsuario extends BaseController {

	public function index() {
		$this->content['title'] = "Configuración Usuario";
		$this->content['view'] = "vConfiguracionUsuario";
		
		$this->content['js_add'][] = [
      'ConfiguracionUsuario/jsConfiguracionUsuarioModulos.js'
			, 'ConfiguracionUsuario/jsConfiguracionUsuario.js'
		];

    $this->Lgijgo();

		return view('UI/viewDefault', $this->content);
	}

}
