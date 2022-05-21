<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Models\mCategorias;
use App\Models\mProductos;

class cProductos extends BaseController {
    public function index() {
        $this->content['title'] = "Productos";
        $this->content['view'] = "vProductos";

        $this->LDataTables();
        $this->LMoment();
        $this->LJQueryValidation();
        $this->LSelect2();
        $this->LFancybox();
        $this->LInputMask();

        $categorias = new mCategorias();
        $this->content["categorias"] = $categorias->asObject()->where("estado", 1)->findAll();
        
        $this->content['js_add'][] = [
            'Productos.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT() {
        $estado = $this->request->getPost("estado");

        $query = $this->db->table('productos AS P')
                        ->select("
                            P.id,
                            P.id_categoria,
                            P.referencia,
                            P.item,
                            P.descripcion,
                            P.imagen,
                            P.stock,
                            P.precio_venta,
                            P.ubicacion,
                            P.manifiesto,
                            P.ventas, 
                            P.estado, 
                            P.created_at,
                            P.updated_at,
                            C.nombre AS nombreCategoria,
                            CASE 
                                WHEN P.estado = 1 THEN 'Activo' 
                                ELSE 'Inactivo' 
                            END AS Estadito
                        ")->join('categorias AS C', 'P.id_categoria = C.id', 'left');

        if($estado != "-1"){
            $query->where("P.estado", $estado);
        }

        return DataTable::of($query)->toJson(true);
    }

    public function validarProducto($campo, $nombre, $id){
        $prod = new mProductos();

        $producto = $prod->asObject()
                ->where([$campo => $nombre, "id != " => $id])
                ->countAllResults();

        return $this->response->setJSON($producto);
    }

    public function crearEditar(){
        $resp["success"] = false;
        $filenameDelete = "";
        $postData = (object) $this->request->getPost();

        $product = new mProductos();
        //Creamos el producto y llenamos los datos
        $producto = array(
            "id" => $postData->id
            ,"id_categoria" => trim($postData->categoria)
            ,"referencia" => trim($postData->referencia)
            ,"item" => trim($postData->item)
            ,"descripcion" => trim($postData->descripcion)
            ,"stock" => $postData->stock
            ,"precio_venta" => str_replace(",", "", trim(str_replace("$", "", $postData->precioVent)))
            ,"ubicacion" => trim($postData->ubicacion)
            ,"manifiesto" => trim($postData->manifiesto)
        );

        //Validamos si eliminar la foto de perfil y buscamos el usuario
        if($postData->editFoto != 0 && !empty($postData->id)) {
            $foto = $product->find($postData->id)["imagen"];
            $producto["imagen"] = null;
            $filenameDelete = UPLOADS_PRODUCT_PATH . $postData->id . "/" . $foto; //<-- specify the image  file
        }

        $this->db->transBegin();
        
        //Validamos si el usuario que ingresaron ya existe
        if ($product->save($producto)) {
            //Traemos el id insertado
            $product->id = empty($postData->id) ? $product->getInsertID() : $postData->id; 
            $imgFoto = $this->request->getFile("imagen"); 
            if (!empty($imgFoto->getBasename())) {
                //Validamos la foto
                $validated = $this->validate([
                    'rules' => [
                        'uploaded[imagen]',
                        'mime_in[imagen,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[imagen,2048]',
                    ],
                ]);
                
                //Se valida los datos de la imagen
                if ($validated) {
                    if ($imgFoto->isValid() && !$imgFoto->hasMoved()) {
                        //Validamos que la imagen suba correctamente
                        $nameImg = "01.{$imgFoto->getClientExtension()}";
                        if ($imgFoto->move(UPLOADS_PRODUCT_PATH . "/" . $product->id, $nameImg, true)) {
                            $updateFoto = array(
                                "id" => $product->id,
                                "imagen" => $nameImg
                            );

                            if ($product->save($updateFoto)) { 
                                $resp["success"] = true;
                                $resp["msj"] = "El producto <b>{$product->referencia}</b> se creo correctamente.";
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
                $resp["msj"] = "El producto <b>{$product->referencia}</b> se creo correctamente.";
            }
        } else {
            $resp["msj"] = "No puede " . (empty($postData->id) ? 'crear' : 'actualizar') . " el producto." . listErrors($product->errors());
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

    public function foto($id = null, $img = null){
        $filename = UPLOADS_PRODUCT_PATH ."{$id}/{$img}"; //<-- specify the image  file
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
        $data = (object) $this->request->getPost();

        $perfil = new mProductos();
        
        if($perfil->save($data)) {
            $resp["success"] = true;
            $resp['msj'] = "Producto actualizado correctamente";
        } else {
            $resp['msj'] = "Error al cambiar el estado";
        }

        return $this->response->setJSON($resp);
    }
}