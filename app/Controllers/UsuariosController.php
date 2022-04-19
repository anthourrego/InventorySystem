<?php

namespace App\Controllers;
use App\Models\UsuariosModel;
use \Hermawan\DataTables\DataTable;

class UsuariosController extends Libraries {

    public function index() {
        $this->content['title'] = "Usuarios";
        $this->content['view'] = "vUsuarios";

        $this->LDataTables();
        $this->LMoment();
        $this->LFancybox();
        $this->content['js_add'][] = [
            'Usuarios.js'
        ];

        return view('UI/viewDefault', $this->content);

    }

    public function listaUsuarios() {
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('usuarios')
                        ->select("
                            id, 
                            nombre, 
                            usuario, 
                            perfil, 
                            foto, 
                            estado, 
                            ultimo_login, 
                            fecha,
                            CASE 
                                WHEN estado = 1 THEN 'Activo' 
                                ELSE 'Inactivo' 
                            END AS Estadito
                        ");

        if($estado != "-1"){
            $query->where("estado", $estado);
        }

        return DataTable::of($query)->toJson(true);
    }

    public function foto($img = null){
        $filename= UPLOADS_PATH ."usuarios/{$img}"; //<-- specify the image  file
        //Si la foto no existe la colocamos por defecto
        if(!file_exists($filename)){ 
            $filename = ASSETS_PATH . "img/nofoto.png";
        }
        $mime = mime_content_type($filename); //<-- detect file type
        header('Content-Length: '.filesize($filename)); //<-- sends filesize header
        header("Content-Type: {$mime}"); //<-- send mime-type header
        header("Content-Disposition: inline; filename='{$filename}';"); //<-- sends filename header
        readfile($filename); //<--reads and outputs the file onto the output buffer
        exit(); // or die()
    }

    public function eliminar(){
        $resp["success"] = false;
        //Traemos los datos del post
        $id = $this->request->getPost("idUsuario");
        $estado = $this->request->getPost("estado");

        $usuario = new UsuariosModel();
        
        $data = [
            "id" => $id,
            "estado" => $estado
        ];

        if($usuario->save($data)) {
            $resp["success"] = true;
            $resp['msj'] = "Usuario se ha actualizado correctamente";
        } else {
            $resp['msj'] = "Error al cambiar el estado";
        }

        echo json_encode($resp);
    }
}
