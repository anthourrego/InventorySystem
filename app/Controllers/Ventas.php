<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\VentasModel;
use App\Models\ProductosModel;

class Ventas extends BaseController {
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
        $this->LFancybox();

        $ventaModel = new VentasModel();
        $codigo = $ventaModel->asObject()->orderBy('id', 'desc')->first();

        $this->content["nroVenta"] = is_null($codigo) ? 1 : ($codigo->codigo + 1);

        $this->content['js_add'][] = [
            'Ventas/Crear.js'
        ];

        return view('UI/viewDefault', $this->content);
    }

    public function Editar($id) {
        $ventaModel = new VentasModel();
        $venta = $ventaModel->cargarVenta($id);

        if (count($venta) != 1) {
            return redirect()->route('Ventas/Administrar');
        }

        $venta = $venta[0];
        
        $this->content["venta"] = $venta;

        $this->content["nroVenta"] = $venta->codigo;

        $this->content['title'] = "Editar venta Nro " . $venta->codigo;
        $this->content['view'] = "Ventas/vCrear";

        $this->LDataTables();
        $this->LMoment();
        $this->LSelect2();
        $this->LInputMask();
        $this->LJQueryValidation();
        $this->LFancybox();

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
    }

    public function crearEditar(){
        $resp["success"] = false;
        //Traemos los datos del post
        $dataPost = (object) $this->request->getPost();
        //var_dump($dataPost);
        $valorTotal = 0;
        $prod = json_decode($dataPost->productos);
        
        $productoModel = new ProductosModel();
        $ventaModel = new VentasModel();

        $codigo = $ventaModel->asObject()->orderBy('id', 'desc')->first();
        $codigo = is_null($codigo) ? 1 : ($codigo->codigo + 1);


        if (count($prod) > 0) {
            $this->db->transBegin();

            $dataSave = array(
                "codigo" => $codigo,
                "id_cliente" => $dataPost->idCliente,
                "id_vendedor" => $dataPost->idUsuario,
                "productos" => $dataPost->productos,
                "impuesto" => 0,
                "neto" => 0,
                "total" => 0,
                "metodo_pago" => $dataPost->metodoPago
            );

            if($ventaModel->save($dataSave)){
                $dataSave["id"] = $ventaModel->getInsertID();
                foreach ($prod as $it) {
                    $valorTotal = $valorTotal + ($it->cantidad * $it->precio_venta);

                    $product = $productoModel->find($it->id);
                    $product["stock"] = $product["stock"] - $it->cantidad;

                    if(!$productoModel->save($product)){
                        $resp["msj"] = "Error al guardar al actualizar el producto.";
                        break;
                    }
                }

                if ($this->db->transStatus() !== false) {
                    $dataSave["total"] = $valorTotal;
                    $dataSave["neto"] = $valorTotal;

                    if ($ventaModel->save($dataSave)) {
                        $resp["success"] = true;
                        $resp["msj"] = $dataSave;
                    } else {
                        $resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($ventaModel->errors());
                    }
                }
            } else{
                $resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($ventaModel->errors());
            }

            if($resp["success"] == false || $this->db->transStatus() === false) {
                $this->db->transRollback();
            } else {
                $this->db->transCommit();
            }

        } else {
            $resp['msj'] = "No se puede generar la venta si no hay productos seleccionados";
        }

        return $this->response->setJSON($resp);
    }

    private function cargarVenta(){

    }
}
