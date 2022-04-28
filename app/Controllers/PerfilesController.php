<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Models\PerfilesModel;

class PerfilesController extends Libraries {
    public function index() {
        $this->content['title'] = "Perfiles";
        $this->content['view'] = "vPerfiles";

        $this->LDataTables();
        $this->LMoment();
        $this->LJQueryValidation();

        $this->content['js_add'][] = [
            'Perfiles.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT(){
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('perfiles')
                        ->select("
                            id, 
                            nombre, 
                            descripcion, 
                            estado, 
                            CASE 
                                WHEN estado = 1 THEN 'Activo' 
                                ELSE 'Inactivo' 
                            END AS Estadito,
                            created_at,
                            updated_at
                        ");

        if($estado != "-1"){
            $query->where("estado", $estado);
        }

        return DataTable::of($query)->toJson(true);
    }

    public function eliminar(){
        if ($this->request->isAJAX()){
            $resp["success"] = false;
            //Traemos los datos del post
            $id = $this->request->getPost("id");
            $estado = $this->request->getPost("estado");
    
            $perfil = new PerfilesModel();
            
            $data = [
                "id" => $id,
                "estado" => $estado
            ];
    
            if($perfil->save($data)) {
                $resp["success"] = true;
                $resp['msj'] = "Perfil actualizado correctamente";
            } else {
                $resp['msj'] = "Error al cambiar el estado";
            }
    
            return $this->response->setJSON($resp);
        } else {
            show_404();
        }
    }

    public function crearEditar(){
        if ($this->request->isAJAX()){
            $resp["success"] = false;
            //Traemos los datos del post
            $postData = $this->request->getPost();
            //Creamos los datos para guardar
            $datosSave = array(
                "id" => $postData["id"],
                "nombre" => trim($postData["nombre"]),
                "descripcion" => trim($postData["descripcion"]),
            );

            $perfil = new PerfilesModel();
            if ($perfil->save($datosSave)) {
                $resp["success"] = true;
                $resp["msj"] = "El pefil <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
            } else {
                $resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el perfil." . listErrors($perfil->errors());
            }

            return $this->response->setJSON($resp);
        } else {
            show_404();
        }
    }
}
