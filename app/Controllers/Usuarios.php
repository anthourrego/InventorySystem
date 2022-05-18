<?php

namespace App\Controllers;
use App\Models\UsuariosModel;
use App\Models\PerfilesModel;
use \Hermawan\DataTables\DataTable;
use App\Models\PermisosModel;

class Usuarios extends BaseController {

    public function index() {
        $this->content['title'] = "Usuarios";
        $this->content['view'] = "vUsuarios";

        $this->LDataTables();
        $this->LMoment();
        $this->LFancybox();
        $this->LSelect2();
        $this->LJQueryValidation();
        $this->Lgijgo();

        $permisosModel = new PermisosModel();
        $this->content["permisos"] = $permisosModel->lista();

        $perfilesModel = new PerfilesModel();

        $this->content["perfiles"] = $perfilesModel->asObject()->where("estado", 1)->findAll();
        
        $this->content['js_add'][] = [
            'Usuarios.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT() {
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('usuarios AS u')
                        ->select("
                            u.id, 
                            u.nombre, 
                            u.usuario, 
                            CASE 
                                WHEN u.perfil IS NULL THEN 'Perfil Libre'
                                ELSE p.nombre
                            END perfil, 
                            u.perfil AS perfilId,
                            u.foto, 
                            u.estado, 
                            u.ultimo_login, 
                            u.created_at,
                            u.updated_at,
                            CASE 
                                WHEN u.estado = 1 THEN 'Activo' 
                                ELSE 'Inactivo' 
                            END AS Estadito
                        ")->join('perfiles AS p', 'u.perfil = p.id', 'left');

        if($estado != "-1"){
            $query->where("u.estado", $estado);
        }

        return DataTable::of($query)->toJson(true);
    }

    public function foto($img = null){
        $filename = UPLOADS_USER_PATH ."{$img}"; //<-- specify the image  file
        //Si la foto no existe la colocamos por defecto
        if(is_null($img) || !file_exists($filename)){ 
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
        
        return $this->response->setJSON($resp);
    }

    public function validaUsuario($usuario, $id){
        $user = new UsuariosModel();

        $usuario = $user->asObject()
                ->where(['usuario' => $usuario, "id != " => $id])
                ->countAllResults();

        return $this->response->setJSON($usuario);
    }

    public function crearEditar(){
        $resp["success"] = false;
        $filenameDelete = "";
        $user = new UsuariosModel();
        //Creamos el usuario y llenamos los datos
        $usuario = array(
            "id" => $this->request->getPost("id")
            ,"usuario" => trim($this->request->getPost("usuario"))
            ,"nombre" => trim($this->request->getPost("nombre"))
            ,"perfil" => trim($this->request->getPost("perfil")) == 0 ? null : trim($this->request->getPost("perfil"))
        );

        if (empty($this->request->getPost("id"))) {
            $usuario["password"] = password_hash(trim($this->request->getPost("pass")), PASSWORD_DEFAULT, array("cost" => 15));
        }

        //Validamos si eliminar la foto de perfil y buscamos el usuario
        if($this->request->getPost("editFoto") != 0 && !empty($this->request->getPost("id"))) {
            $foto = $user->find($this->request->getPost("id"))["foto"];
            $usuario["foto"] = null;
            $filenameDelete = UPLOADS_USER_PATH . $foto; //<-- specify the image  file
        }

        $this->db->transBegin();
        
        //Validamos si el usuario que ingresaron ya existe
        if ($user->save($usuario)) {
            //Traemos el id insertado
            $user->id = empty($this->request->getPost("id")) ? $user->getInsertID() : $this->request->getPost("id"); 
            $imgFoto = $this->request->getFile("foto"); 
            if (!empty($imgFoto->getBasename())) {
                //Validamos la foto
                $validated = $this->validate([
                    'rules' => [
                        'uploaded[foto]',
                        'mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[foto,2048]',
                    ],
                ]);
                
                //Se valida los datos de la imagen
                if ($validated) {
                    if ($imgFoto->isValid() && !$imgFoto->hasMoved()) {
                        //Validamos que la imagen suba correctamente
                        $nameImg = "{$user->id}.{$imgFoto->getClientExtension()}";
                        if ($imgFoto->move(UPLOADS_USER_PATH, $nameImg, true)) {
                            $updateFoto = array(
                                "id" => $user->id,
                                "foto" => $nameImg
                            );

                            if ($user->save($updateFoto)) { 
                                $resp["success"] = true;
                                $resp["msj"] = "El usuario <b>{$user->usuario}</b> se creo correctamente.";
                            } else {
                                $resp["msj"] = "Ha ocurrido un error al actualizar los datos de la foto.";
                            }
                        } else {
                            $resp["msj"] = "Ha ocurrido un error al subir la foto.";
                        }
                    } else {
                        $resp["msj"] = "Error al subir la foto, {$imgFoto->getErrorString()}";
                    }
                } else {
                    $resp["msj"] = "Error al subir la foto, " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
                }
            } else {
                $resp["success"] = true;
                $resp["msj"] = "El usuario <b>{$user->usuario}</b> se creo correctamente.";
            }
        } else {
            $resp["msj"] = "No puede " . (empty($this->request->getPost("id")) ? 'crear' : 'actualizar') . " el usuario." . listErrors($user->errors());
        }

        
        //Validamos para elminar la foto
        if ($filenameDelete != '' && file_exists($filenameDelete)) {
            if(!@unlink($filenameDelete)) {
                $resp["success"] = false;
                $resp["msj"] = "Error al eliminar la foto de perfil, intente de nuevo";
            } 
        }

        if($resp["success"] == true){
            $this->db->transCommit();
        } else {
            $this->db->transRollback();
        }

        return $this->response->setJSON($resp);
    }

    public function cambiarPass(){
        $resp['success'] = false;
        $resp['msj'] = "Funca";

        $dataPost = $this->request->getPost();

        $user = new UsuariosModel();
        
        if (!empty(trim($dataPost["id"]))) {
            if (trim($dataPost["pass"]) == trim($dataPost["RePass"])) {
                $dataSave = array(
                    "id" => trim($dataPost["id"]),
                    "password" => password_hash(trim($dataPost["pass"]), PASSWORD_DEFAULT, array("cost" => 15))
                );

                if ($user->save($dataSave)) {
                    $resp["success"] = true;
                    $resp['msj'] = "Contraseña actualizada correctamente";
                } else {
                    $resp['msj'] = "Error al actualizar la contraseña del usuario";
                }
            } else {
                $resp["msj"] = "La contraseñas no coinciden, intentelo de nuevo";
            }
        } else {
            $resp["msj"] = "No se ha definido usuario para actualizar";
        }
        
        return $this->response->setJSON($resp);
    }

    public function getUsuario(){
        $resp["success"] = false;
        //Traemos los datos del post
        $data = (object) $this->request->getPost();
        
        $userModel = new UsuariosModel();

        $result = $userModel->like('usuario', $data->buscar)
                            ->orLike('nombre', $data->buscar)
                            ->find();
        
        if(count($result) == 1) {
            $resp["success"] = true;
            $resp["data"] = $result[0]; 
        }

        return $this->response->setJSON($resp);
    }
}
