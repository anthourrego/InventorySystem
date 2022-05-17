<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\CategoriasModel;

class CategoriasController extends BaseController {
    public function index() {
        $this->content['title'] = "Categorias";
        $this->content['view'] = "vCategorias";

        $this->LDataTables();
        $this->LMoment();
        $this->LJQueryValidation();

        $this->content['js_add'][] = [
            'Categorias.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT(){
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('categorias')
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

            $perfil = new CategoriasModel();
            if ($perfil->save($datosSave)) {
                $resp["success"] = true;
                $resp["msj"] = "La categoria <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
            } else {
                $resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " la categoria." . listErrors($perfil->errors());
            }

            return $this->response->setJSON($resp);
        } else {
            show_404();
        }
    }

    public function eliminar(){
        if ($this->request->isAJAX()){
            $resp["success"] = false;
            //Traemos los datos del post
            $id = $this->request->getPost("id");
            $estado = $this->request->getPost("estado");
    
            $perfil = new CategoriasModel();
            
            $data = [
                "id" => $id,
                "estado" => $estado
            ];
    
            if($perfil->save($data)) {
                $resp["success"] = true;
                $resp['msj'] = "Categoria actualizada correctamente";
            } else {
                $resp['msj'] = "Error al cambiar el estado";
            }
    
            return $this->response->setJSON($resp);
        } else {
            show_404();
        }
    }
}
