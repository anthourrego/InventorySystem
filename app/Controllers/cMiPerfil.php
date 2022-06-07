<?php

namespace App\Controllers;

class cMiPerfil extends BaseController {

	public function index() {
		$this->content['title'] = "Mi Perfil";
		$this->content['view'] = "vMiPerfil";
		
		$this->content['js_add'][] = [
      'MiPerfil/jsMiPerfilModulos.js'
			, 'MiPerfil/jsMiPerfil.js'
		];

    $this->Lgijgo();

		return view('UI/viewDefault', $this->content);
	}

}
