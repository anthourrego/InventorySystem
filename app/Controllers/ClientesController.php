<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\ClientesModel;

class ClientesController extends Libraries {
    public function index() {
        $this->content['title'] = "Clientes";
        $this->content['view'] = "vClientes";

        $this->LDataTables();
        $this->LMoment();
        $this->LJQueryValidation();
        $this->LInputMask();

        $this->content['js_add'][] = [
            'Clientes.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT(){
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('clientes')
                        ->select("
                            id, 
                            documento, 
                            nombre, 
                            direccion, 
                            telefono, 
                            administrador, 
                            cartera, 
                            telefonocart, 
                            compras, 
                            ultima_compra, 
                            estado, 
                            created_at,
                            updated_at,
                            CASE 
                                WHEN estado = 1 THEN 'Activo' 
                                ELSE 'Inactivo' 
                            END AS Estadito,
                        ");

        if($estado != "-1"){
            $query->where("estado", $estado);
        }

        return DataTable::of($query)->toJson(true);
    }

    public function validaCliente($nroDocumento, $id){
        if ($this->request->isAJAX()){ 
            $user = new ClientesModel();
    
            $usuario = $user->asObject()
                    ->where(['documento' => $nroDocumento, "id != " => $id])
                    ->countAllResults();

            echo json_encode($usuario);
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
                "documento" => trim($postData["documento"]),
                "nombre" => trim($postData["nombre"]),
                "direccion" => trim($postData["direccion"]),
                "telefono" => trim($postData["telefono"]),
                "administrador" => trim($postData["administrador"]),
                "cartera" => trim($postData["cartera"]),
                "telefonoCart" => trim($postData["telefonoCart"]),
            );

            $perfil = new ClientesModel();
            if ($perfil->save($datosSave)) {
                $resp["success"] = true;
                $resp["msj"] = "El cliente <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
            } else {
                $resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " el cliente." . listErrors($perfil->errors());
            }

            return json_encode($resp);
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
    
            $cliente = new ClientesModel();
            
            $data = [
                "id" => $id,
                "estado" => $estado
            ];
    
            if($cliente->save($data)) {
                $resp["success"] = true;
                $resp['msj'] = "Cliente actualizada correctamente";
            } else {
                $resp['msj'] = "Error al cambiar el estado";
            }
    
            echo json_encode($resp);
        } else {
            show_404();
        }
    }

}
