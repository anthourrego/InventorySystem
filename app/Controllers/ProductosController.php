<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Models\CategoriasModel;

class ProductosController extends Libraries {
    public function index() {
        $this->content['title'] = "Productos";
        $this->content['view'] = "vProductos";

        $this->LDataTables();
        $this->LMoment();
        $this->LJQueryValidation();
        $this->LSelect2();

        $categorias = new CategoriasModel();
        $this->content["categorias"] = $categorias->asObject()->where("estado", 1)->findAll();

        $this->content['css_add'][] = [
            'Productos.css'
        ];

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
}
