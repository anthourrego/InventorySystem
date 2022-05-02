<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\VentasModel;

class VentasController extends Libraries {
    public function index() {
        $this->content['title'] = "Administador Ventas";
        $this->content['view'] = "Ventas/vAdministador";

        $this->LDataTables();
        $this->LMoment();

        $this->content['js_add'][] = [
            'Ventas/Administrador.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function crear() {
        $this->content['title'] = "Crear venta";
        $this->content['view'] = "Ventas/vCrear";

        $this->LDataTables();
        $this->LMoment();
        $this->LSelect2();
        $this->LInputMask();
        $this->LJQueryValidation();

        $ventaModel = new VentasModel();

        $this->content["nroVenta"] = $ventaModel->asObject()->first();
        $this->content["nroVenta"] = is_null($ventaModel->asObject()->first()) ? 1 : ($ventaModel->asObject()->first()->codigo + 1);

        $this->content['js_add'][] = [
            'Ventas/Crear.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function listaDT(){
        $query = $this->db->table('ventas AS V')
                        ->select("
                            V.id,
                            V.codigo,
                            V.id_cliente,
                            C.nombre AS NombreCliente,
                            V.id_vendedor,
                            U.nombre AS NombreVendedor,
                            V.productos,
                            V.impuesto,
                            V.neto,
                            V.total,
                            V.metodo_pago,
                            V.created_at,
                            V.updated_at
                        ")->join('clientes AS C', 'V.id_cliente = C.id', 'left')
                        ->join('usuarios AS U', 'V.id_vendedor = U.id', 'left');

        return DataTable::of($query)->toJson(true);
    }

    public function eliminar(){
        if ($this->request->isAJAX()){
            $resp["success"] = false;
            //Traemos los datos del post
            $data = (object) $this->request->getPost();
            
            $ventas = new VentasModel();

            if ($ventas->delete($data->id)) { 
                $resp["success"] = true;
                $resp['msj'] = "Venta eliminada correctamente";
            } else {
                $resp['msj'] = "Error al eliminar la venta";
            }
    
            return $this->response->setJSON($resp);
        } else {
            show_404();
        }
    }
}
