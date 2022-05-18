<?php

namespace App\Controllers;

class Busqueda extends BaseController {
    public function dataTables() {
        $this->content['campos'] = array();
		if(isset($_GET['campos'])){
			$this->content['campos'] = json_decode($_GET['campos']);
		}
        return view('UI/Busqueda', $this->content);
    }
}
