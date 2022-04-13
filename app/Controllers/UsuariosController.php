<?php

namespace App\Controllers;
use App\Models\UsuariosModel;
use \Hermawan\DataTables\DataTable;

class UsuariosController extends Libraries {

    public function index() {
        $this->content['title'] = "Usuarios";
        $this->content['view'] = "vUsuarios";

        $this->LDataTables();
        $this->content['js_add'][] = [
            'Usuarios.js'
        ];

        return view('UI/viewDefault', $this->content);

    }

    public function listaUsuarios() {
        $builder = $this->db->table('usuarios')->select('id, nombre, usuario, perfil, foto, estado, ultimo_login, fecha');

        return DataTable::of($builder)->toJson(true);
    }
}
