<?php

namespace App\Controllers;
use App\Models\UsuariosModel;

class UsuariosController extends Libraries {

    public function index() {
        $this->content['title'] = "Usuarios";
        $this->content['view'] = "vUsuarios";
        return view('UI/viewDefault', $this->content);

    }
}
