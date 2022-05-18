<?php

namespace App\Controllers;
use App\Models\UsuariosModel;
use App\Models\PermisosModel;

class Home extends BaseController {

    public function index() {
        
        if ($this->session->has("logged_in") && $this->session->get("logged_in")) {
            $this->content['title'] = "Inicio";
            $this->content['view'] = "vInicio";
    
            return view('UI/viewDefault', $this->content);

        } else {
            $this->LJQueryValidation();
            
            $this->content['title'] = "Inicio Sesión";
            $this->content['view'] = "vLogin";
            $this->content['css_add'][] = [
                'Login.css'
            ];
    
            $this->content['js_add'][] = [
                'Login.js'
            ];
    
            return view('UI/viewSimple', $this->content);
        }
    }
    
    public function iniciarSesion(){
        $resp['success'] = false;

        if(preg_match('/^[a-zA-Z0-9]+$/', $this->request->getPost("usuario"))){
            $usuario = new UsuariosModel();
            $usuario->usuario = $this->request->getPost("usuario");
            $usuario->password = $this->request->getPost("password");

            if ($usuario->validarUsuario()){

                $updateData = [
                    "id" => $usuario->id
                    ,"ultimo_login" => date("Y-m-d H:i:s")
                ];

                if ($usuario->save($updateData)){

                    $permisosModel = new PermisosModel();

                    $campo = $usuario->perfil == null ? 'usuarioId' : 'perfilId';
                    $id = $usuario->perfil == null ? $usuario->id : $usuario->perfil;
                    $permisos = $permisosModel->select("permiso")->where($campo, $id)->findAll();
                    $per = [];

                    foreach ($permisos as $it) {
                        $per[] = $it->permiso;
                    }
                    
                    //Treamos los permisos del usuarios
                    $userdata = [
                        'id_user'  => $usuario->id,
                        'nombre'  => $usuario->nombre,
                        'usuario'     => $usuario->usuario,
                        'perfil'     => $usuario->perfil,
                        'foto'     => $usuario->foto,
                        'logged_in' => true,
                        'permisos' => $per
                    ];

                    $this->session->set($userdata);

                    $resp["success"] = true;
                } else {
                    $resp["msj"] = "Error al iniciar sesión.";  
                }

            } else {
                $resp["msj"] = "Usuario Y/O contraseña invalidos.";
            }

        } else {
            $resp["msj"] = "El usuario contiene caracteres extraños";
        }

        return $this->response->setJSON($resp);
    }

    public function cerrarSesion(){
        $this->session->destroy();
        $resp = array("success" => 1, "msj" => "Sesión cerrada.");
        return $this->response->setJSON($resp);
    }
}
