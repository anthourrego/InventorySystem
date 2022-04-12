<?php

namespace App\Controllers;
use App\Models\UsuariosModel;
use \Config\Services;

class Home extends Libraries {

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
    
            return view('UI/viewDefault', $this->content);
        }
    }
    
    public function iniciarSesion(){
        if ($this->request->isAJAX()){
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

                        $userdata = [
                            'id_user'  => $usuario->id,
                            'nombre'  => $usuario->nombre,
                            'usuario'     => $usuario->usuario,
                            'perfil'     => $usuario->perfil,
                            'foto'     => $usuario->foto,
                            'logged_in' => true,
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

            echo json_encode($resp);
        } else {
            show_404();
        }
    }
}
