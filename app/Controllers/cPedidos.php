<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\mPedidos;
use App\Models\mProductos;
use App\Models\mUsuarios;
use App\Models\mClientes;
use App\Models\mPedidosProductos;
use App\Models\mConfiguracion;

class cPedidos extends BaseController {
	public function index() {
		$this->content['title'] = "Administador Pedidos";
		$this->content['view'] = "Pedidos/vAdministador";

		$this->LDataTables();
		$this->LMoment();

		$this->content['js_add'][] = [
			'Pedidos/jsAdministrador.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function crear() {
		$this->content['title'] = "Crear pedido";
		$this->content['view'] = "Pedidos/vCrear";

		$this->LDataTables();
		$this->LMoment();
		$this->LSelect2();
		$this->LInputMask();
		$this->LJQueryValidation();
    $this->LFancybox();

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();

    $mConfiguracion = new mConfiguracion();

		$dataPref = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '');

    $dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoPed")->first();

		$this->content["nroPedido"] = $dataPref . (is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1));

		$this->content["prefijoValido"] = ($dataPref != '' ? 'S' : 'N');

		$this->content["pedido"] = null;

		$this->content["inventario_negativo"] = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');

		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0')
 		];

		$this->content["cantidadVendedores"] = $this->cantidadVendedores();

		$this->content['imagenProd'] = (session()->has("imageProd") ? session()->get("imageProd") : 0);

		$this->content['js_add'][] = [
			'Pedidos/jsCrear.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function Editar($id) {
		$pedidoModel = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();

		$pedido = $pedidoModel->cargarPedido($id);

		if (count($pedido) != 1) {
			return redirect()->route('Pedidos/Administrar');
		}
		$pedido = $pedido[0];
		
		$productos = $mPedidosProductos->select("
				p.id,
				pedidosproductos.id AS idProductoPedido,
				p.referencia, 
				p.item, 
				p.descripcion,
				(p.stock + pedidosproductos.cantidad) AS stock,
				pedidosproductos.cantidad,
				pedidosproductos.cantidad AS cantidadOriginal,
				pedidosproductos.valor AS valorUnitario,
				pedidosproductos.valor AS valorUnitarioOriginal,
				pedidosproductos.valor_original,
				p.precio_venta,
				(pedidosproductos.valor * pedidosproductos.cantidad) AS valorTotal
			")->join("productos AS p", "pedidosproductos.id_producto = p.id")
			->where("pedidosproductos.id_pedido", $pedido->id)
			->findAll();

		$pedido->productos = $productos;
		
		$this->content["pedido"] = $pedido;
		$this->content["prefijoValido"] = 'S';

		$this->content["nroPedido"] = $pedido->pedido;

		$this->content['title'] = "Editar pedido Nro " . $pedido->pedido;
		$this->content['view'] = "Pedidos/vCrear";

		$this->LDataTables();
		$this->LMoment();
		$this->LSelect2();
		$this->LInputMask();
		$this->LJQueryValidation();
		$this->LFancybox();

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();
		$this->content["cantidadVendedores"] = $this->cantidadVendedores();
		$this->content["inventario_negativo"] = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');
		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0')
 		];

		$this->content['imagenProd'] = (session()->has("imageProd") ? session()->get("imageProd") : 0);

		$this->content['js_add'][] = [
			'Pedidos/jsCrear.js',
			'Pedidos/jsEditar.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$query = $this->db->table('pedidos AS P')
			->select("
				P.id,
				P.pedido,
				P.id_cliente,
				C.nombre AS NombreCliente,
				P.id_vendedor,
				U.nombre AS NombreVendedor,
				P.impuesto,
				P.created_at,
				P.updated_at,
				P.estado,
				CASE WHEN P.Estado = 0 THEN 'Pendiente' WHEN P.Estado = 1 THEN 'Alistamiento' ELSE 'Facturado' END AS NombreEstado,
				P.total,
				S.direccion,
				S.nombre AS NombreSucursal
			")->join('clientes AS C', 'P.id_cliente = C.id', 'left')
			->join('sucursales AS S', 'P.id_sucursal = S.id', 'left')
			->join('usuarios AS U', 'P.id_vendedor = U.id', 'left');

		return DataTable::of($query)->toJson(true);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$contActProd = true;
        
		$this->db->transBegin();

		$mPedidosProductos = new mPedidosProductos();
		$mProductos = new mProductos();

		$productosPedidos = $mPedidosProductos->where("id_pedido", $data->id)->findAll();

		//Actualizamos el inventario de los productos
		foreach ($productosPedidos as $it) {
			$producto = $mProductos->asObject()->find($it->id_producto);
			
			$dataSave = [
				"id" => $it->id_producto,
				"stock" => ($producto->stock + $it->cantidad)
			];

			if (!$mProductos->save($dataSave)) {
				$contActProd = false;
				break;
			}
		}
		
		//Eliminamos todos los datos
		if($contActProd) {
			if($mPedidosProductos->where("id_pedido", $data->id)->delete()){
				$pedidos = new mPedidos();
				if ($pedidos->delete($data->id)) { 
					$resp["success"] = true;
					$resp['msj'] = "Pedido eliminado correctamente";
				} else {
					$resp['msj'] = "Error al eliminar el pedido";
				}
			} else {
				$resp['msj'] = "Error al eliminar los productos del pedido.";
			}
		} else {
			$resp['msj'] = "Error al actualizar el inventario.";
		}

		if($resp["success"] == false || $this->db->transStatus() === false) {
			$this->db->transRollback();
		} else {
			//$this->db->transRollback();
			$this->db->transCommit();
		}

		return $this->response->setJSON($resp);
	}

	public function crearEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		$valorTotal = 0;
		$prod = json_decode($dataPost->productos);

		$productoModel = new mProductos();
		$pedidoModel = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();
    $mConfiguracion = new mConfiguracion();

    $dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoPed")->first();

		$numerPedido = (is_null($dataConse) ? 1 : ($dataConse->valor + 1));
		$pedido = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '') . $numerPedido;

		if (count($prod) > 0) {
			$this->db->transBegin();

			$dataSave = array(
				"pedido" => $pedido,
				"id_cliente" => $dataPost->idCliente,
				"id_vendedor" => $dataPost->idUsuario,
        "id_sucursal" => $dataPost->idSucursal,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($pedidoModel->save($dataSave)){
				$dataSave["id"] = $pedidoModel->getInsertID();
				foreach ($prod as $it) {
					$dataProductoPedido = [
						"id_pedido" => $dataSave["id"],
            "pedido" => $pedido,
						"id_producto" => $it->id,
						"cantidad" => $it->cantidad,
						"valor" => $it->valorUnitario,
						"valor_original" => $it->precio_venta
					];

					$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);

					$product = $productoModel->find($it->id);
					$product["stock"] = $product["stock"] - $it->cantidad;

					if (!$mPedidosProductos->save($dataProductoPedido)) {
						$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mPedidosProductos->errors());
						break;
					}

					if(!$productoModel->save($product)){
						$resp["msj"] = "Error al guardar al actualizar el producto. " . listErrors($productoModel->errors());
						break;
					}
				}

				if ($this->db->transStatus() !== false) {
					$dataSave["total"] = $valorTotal;
					$dataSave["neto"] = $valorTotal;

					if ($pedidoModel->save($dataSave)) {
						$resp["success"] = true;
						$resp["msj"] = $dataSave;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar el pedido." . listErrors($pedidoModel->errors());
					}
				}
			} else{
				$resp["msj"] = "Ha ocurrido un error al guardar el pedido." . listErrors($pedidoModel->errors());
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {

        $builder = $this->db->table('configuracion')->set("valor", $numerPedido)->where('campo', "consecutivoPed");

		    if($builder->update()) {
          $this->db->transCommit();
        } else {
          $resp["success"] = false;
          $this->db->transRollback();
        }
			}

		} else {
			$resp['msj'] = "No se puede generar el pedido si no hay productos seleccionados";
		}

		return $this->response->setJSON($resp);
	}

	public function guardarEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		$prod = json_decode($dataPost->productos);
		$valorTotal = 0;

		$mProductos = new mProductos();
		$mPedidos = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();

		$pediOrigi = $mPedidos->asObject()->where("id", $dataPost->idPedido)->first();
		
		if (count($prod) > 0) {
			$this->db->transBegin();
			$dataSave = array(
				"id" => $dataPost->idPedido,
				"id_cliente" => $dataPost->idCliente,
				"id_vendedor" => $dataPost->idUsuario,
				"id_sucursal" => $dataPost->idSucursal,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($mPedidos->save($dataSave)){
				//Tramos los productos actuales para comparalos con los que ingresan
				$productoActuales = $mPedidosProductos->asArray()->where("id_pedido", $dataPost->idPedido)->findAll();

				foreach ($prod as $it) {
					$it->idProductoPedido = isset($it->idProductoPedido) ? $it->idProductoPedido : 0;
					$productoAct = array_search($it->idProductoPedido, array_column($productoActuales, 'id'));
					//Si el producto no existe se debe de agregar
					if($productoAct !== false){
						//Validamos si los valores y las cantidades cambian
						if($it->cantidad != $productoActuales[$productoAct]["cantidad"] || $it->valorUnitario != $productoActuales[$productoAct]["valor"]) {
							$cantidadNueva = $productoActuales[$productoAct]["cantidad"] - $it->cantidad;
							
							$dataProductoPedido = [
								"id" => $it->idProductoPedido,
								"cantidad" => $it->cantidad,
								"valor" => $it->valorUnitario,
							];

							if (!$mPedidosProductos->save($dataProductoPedido)) {
								$resp["msj"] = "Ha ocurrido un error al actualizar los productos." . listErrors($mPedidosProductos->errors());
								break;
							}

							$product = $mProductos->find($it->id);
							$product["stock"] = $product["stock"] + $cantidadNueva;

							if(!$mProductos->save($product)){
								$resp["msj"] = "Error al guardar al actualizar el producto. " . listErrors($mProductos->errors());
								break;
							}
						}

						$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);
						unset($productoActuales[$productoAct]);
						$productoActuales = array_values($productoActuales);
					} else {
						$dataProductoPedido = [
							"id_pedido" => $dataPost->idPedido,
							"pedido" => $pediOrigi->pedido,
							"id_producto" => $it->id,
							"cantidad" => $it->cantidad,
							"valor" => $it->valorUnitario,
							"valor_original" => $it->precio_venta
						];
	
						$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);
	
						$product = $mProductos->find($it->id);
						$product["stock"] = $product["stock"] - $it->cantidad;
	
						if (!$mPedidosProductos->save($dataProductoPedido)) {
							$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mPedidosProductos->errors());
							break;
						}
	
						if(!$mProductos->save($product)){
							$resp["msj"] = "Error al guardar al actualizar el producto. " . listErrors($mProductos->errors());
							break;
						}
					}
				}

				//Eliminamos los productos restantes de la venta
				foreach ($productoActuales as $it) {
					if($mPedidosProductos->delete($it["id"])) {

						$product = $mProductos->find($it["id_producto"]);
						$product["stock"] = $product["stock"] + $it["cantidad"];
	
						if(!$mProductos->save($product)){
							$resp["msj"] = "Error al guardar al actualizar el inventario del producto eliminado. " . listErrors($mProductos->errors());
							break;
						}
					} else {
						$resp["msj"] = "Error al guardar al eliminar el producto de la factura. " . listErrors($mPedidosProductos->errors());
							break;
					}
				}

				if ($this->db->transStatus() !== false) {
					$resp["success"] = true;
					$dataSave["total"] = $valorTotal;
					$dataSave["neto"] = $valorTotal;

					if ($mPedidos->save($dataSave)) {
						$resp["msj"] = $dataSave;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar el pedido." . listErrors($mPedidos->errors());
					}
				}
			} else {
				$resp["msj"] = "Ha ocurrido un error al guardar el pedido." . listErrors($mPedidos->errors());
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {
				$this->db->transCommit();
			}

		} else {
			$resp['msj'] = "No se puede generar el pedido si no hay productos seleccionados";
		}

		return $this->response->setJSON($resp);
	}

	public function cantidadVendedores(){
		$mUsuarios = new mUsuarios();

		$vendedores = $mUsuarios->join("(
											SELECT 
												usuarioId,
												perfilId, 
												COUNT(*) AS Vendedor 
											FROM permisosusuarioperfil 
											WHERE permiso = '61' 
											GROUP BY usuarioId, perfilId) AS pup", 
											"(CASE WHEN usuarios.perfil IS NULL THEN usuarios.id = pup.usuarioId ELSE usuarios.perfil = pup.perfilId END)", "inner", 
											false)
											->where("usuarios.estado", 1)
											->countAllResults();
		
		return $vendedores;
	}

	public function estadoPedido(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
        
		$this->db->transBegin();

		$builder = $this->db->table('pedidos')->set("estado", $data->estado)->where('id', $data->id);

		//Ponemos en alistamiento el pedido
		if($builder->update()) {
			$this->db->transCommit();
			$resp["success"] = true;
			$resp['msj'] = "Pedido en proceso alistamiento";
		} else {
			$this->db->transRollback();
			$resp['msj'] = "No fue posible guardar la información";
		}

		return $this->response->setJSON($resp);
	}
}
