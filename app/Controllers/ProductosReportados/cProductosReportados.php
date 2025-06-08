<?php

namespace App\Controllers\ProductosReportados;
use App\Controllers\BaseController;
use App\Models\mPedidos;
use App\Models\mProductos;
use App\Models\mObservacionProductos;
use App\Models\mVentas;
use App\Models\Contabilidad\mCuentaMovimientos;
use App\Models\mPedidosProductos;
use \Hermawan\DataTables\DataTable;

class cProductosReportados extends BaseController {

	public function index($modulo, $idRegistro) {

    $this->content['modulo'] = $modulo;
    $this->content['idRegistro'] = $idRegistro;
    $this->content['datosContent'] = [];

    if ($idRegistro > 0) {
      if ($modulo == 'pedido') {
        $mPedidos = new mPedidos();
        $this->content['datosContent'] = $mPedidos->cargarPedido($idRegistro)[0];
      }
      if ($modulo == 'factura') {
        $mVentas = new mVentas();
        $this->content['datosContent'] = $mVentas->cargarVenta($idRegistro)[0];
      }
      if ($modulo == 'producto') {
        $mProductos = new mProductos();
        $this->content['datosContent'] = $mProductos->asObject()->find($idRegistro); 
      }
    }

		$this->content['js_add_file'][] = [
			'ProductosReportados/jsProductosReportados.js'
		];
		return view('ProductosReportados/vProductosReportados', $this->content);
	}

	public function listaDT() {
		$filtro = $this->request->getPost("filtro");

    if ($filtro['modulo'] == 'general') {
      $query = $this->db->table('observacionproductos AS OP')
        ->join('pedidosproductos AS PP', 'OP.id_pedido_producto = PP.id', 'left')
        ->join('pedidos AS PE', 'PP.id_pedido = PE.id', 'left');
    }

    if ($filtro['modulo'] == 'producto') {
      $query = $this->db->table('observacionproductos AS OP')
        ->join('pedidosproductos AS PP', 'OP.id_pedido_producto = PP.id')
        ->join('pedidos AS PE', 'PP.id_pedido = PE.id', 'left')
        ->where("PP.id_producto", $filtro['valor']);
    }

    if ($filtro['modulo'] == 'pedido') {
      $query = $this->db->table('pedidosproductos AS PP')
        ->join('observacionproductos AS OP', 'PP.id = OP.id_pedido_producto')
        ->join('pedidos AS PE', 'PP.id_pedido = PE.id', 'left')
        ->where("PP.id_pedido", $filtro['valor']);
    }

    if ($filtro['modulo'] == 'factura') {
      $query = $this->db->table('ventas AS V')
        ->join('pedidos AS PE', 'V.id_pedido = PE.id', 'left')
        ->join('pedidosproductos AS PP', 'PE.id = PP.id_pedido', 'left')
        ->join('observacionproductos AS OP', 'PP.id = OP.id_pedido_producto')
        ->where("V.id", $filtro['valor']);
    }

		$query->select("
        OP.id AS idObservacionProducto,
        OP.id_pedido_producto AS idPedidoProducto,
        OP.motivo,
        OP.observacion,
        (OP.cantidad_anterior - OP.cantidad_actual) AS cantidadReportada,
        OP.valor_anterior AS valorAnterior,
        OP.valor_actual AS valorActual,
        OP.tipo,
        OP.id_usuario AS idUsuario,
        OP.created_at AS createdAt,
        U.nombre AS nombreUsuario,
        OP.motivo AS motivo,
        PP.valor AS valorProductoPedido,
        PP.id_producto AS idProducto,
        CONCAT(P.referencia, ' | ', IF(P.item IS NULL, '', P.item)) AS referenciaItem,
        P.descripcion,
        P.descripcion AS codigo,
        PP.id_pedido AS idPedido,
        PE.pedido AS codigoPedido,
        OP.fecha_confirmacion AS fechaConfirmado,
        OP.cantidad_confirmada AS cantidadConfirmada
      ")->join('productos AS P', 'PP.id_producto = P.id', 'left')
      ->join('usuarios AS U', 'OP.id_usuario = U.id', 'left')
      ->orderBy("OP.created_at", "DESC");

		return DataTable::of($query)->toJson(true);
	}

  public function confirmar() {
    $resp["success"] = false;
		//Traemos los datos del post
		$postData = $this->request->getPost();

    $this->db->transBegin();

		$mPedidosProductos = new mPedidosProductos();
    $mObservacionProductos = new mObservacionProductos();
		$mProductos = new mProductos();

    //Creamos los datos para guardar
		$datosSave = array(
      "id" => $postData["idObservacionProducto"],
			"fecha_confirmacion" => date("Y-m-d H:i:s"),
			"cantidad_confirmada" => trim($postData["cantidadReportada"])
		);

		if ($mObservacionProductos->save($datosSave)) {

      $producto = $mProductos->asObject()->find($postData["idProducto"]);

      $stock = intval($producto->stock) + intval(trim($postData["cantidadConfirmada"]));

      $datosSaveProd = array(
        "id" => $postData["idProducto"],
        "stock" => $stock
      );

      if ($mProductos->save($datosSaveProd)) {
        $resp["success"] = true;
        $resp["msj"] = "Producto confrontado correctamente";

        if (+$postData["cantidadReportada"] > 0) {
          $observacion = $mObservacionProductos->asObject()->find($postData["idObservacionProducto"]);
          
          $pedidoProducto = $mPedidosProductos->asObject()->find($observacion->id_pedido_producto);
          
          $total = +$producto->precio_venta * (+$postData["cantidadReportada"]);
  
          $mCuentaMovimientos = new mCuentaMovimientos();
          $mCuentaMovimientos->guardarInventarioProducto($postData["idProducto"], ($total * -1), "id_pedido", $pedidoProducto->id_pedido);
        }
      } else {
        $resp["msj"] = "No fue posible modificar el invetario del producto." . listErrors($mObservacionProductos->errors());
      }
		} else {
			$resp["msj"] = "No fue posible confrontar el productos." . listErrors($mObservacionProductos->errors());
		}

		if($resp["success"] == false || $this->db->transStatus() === false) {
			$this->db->transRollback();
		} else {
			$this->db->transCommit();
		}
		return $this->response->setJSON($resp);
  }
}
