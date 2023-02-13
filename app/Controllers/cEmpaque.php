<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mEmpaque;
use App\Models\mPedidos;
use App\Models\mPedidosProductos;
use App\Models\mPedidosCajas;
use App\Models\mPedidosCajasProductos;
use App\Models\mObservacionProductos;

class cEmpaque extends BaseController {
	
	public function index() {
		$this->content['title'] = "Empaque";
		$this->content['view'] = "vEmpaque";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LFancybox();

		$this->content['js_add'][] = [
			'jsEmpaque.js'
		];

		$this->content['css_add'][] = [
			'cssEmpaque.css'
		];

		$this->content['usuario'] = (session()->has("id_user") ? session()->get("id_user") : null);

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
				CASE WHEN P.Estado = 'PE' THEN 'Pendiente' WHEN P.Estado = 'EP' THEN 'Alistamiento' ELSE 'Facturado' END AS NombreEstado,
				P.total,
				S.direccion,
				S.nombre AS NombreSucursal,
				V.id AS idFactura,
				P.inicio_empaque,
				P.fin_empaque,
				CUI.nombre AS Ciudad
			")->join('clientes AS C', 'P.id_cliente = C.id', 'left')
			->join('sucursales AS S', 'P.id_sucursal = S.id', 'left')
			->join('ciudades AS CUI', 'S.id_ciudad = CUI.id', 'left')
			->join('usuarios AS U', 'P.id_vendedor = U.id', 'left')
			->join('ventas AS V', 'P.id = V.id_pedido', 'left')
			->where('P.Estado', 'EP');

		return DataTable::of($query)->toJson(true);
	}

	public function iniciarEmpaque(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();

		$pedidoModel = new mPedidos();
		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}
        
		$pedidoActual = $this->db->table('pedidos')
			->select("inicio_empaque")
			->where('id', $data->idPedido)
			->get()->getResult()[0];

		if (is_null($pedidoActual->inicio_empaque)) {

			$this->db->transBegin();

			$builder = $this->db->table('pedidos')
				->set("inicio_empaque", date("Y-m-d H:i:s"))
				->where('id', $data->idPedido);

			//Ponemos en alistamiento el pedido actualizando la fecha
			if($builder->update()) {
				$this->db->transCommit();
				$resp["success"] = true;
				$resp['msj'] = "Inicio empaque pedido";
				$resp['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
			} else {
				$this->db->transRollback();
				$resp['msj'] = "No fue posible guardar la información";
			}
		} else {
			$resp['msj'] = "El pedido ya inicio empaque";
		}
		return $this->response->setJSON($resp);
	}

	public function obtenerProductosPedido($id, $query = true) {
		
		$pedidoModel = new mPedidos();
		$mPedidosCajas = new mPedidosCajas();

		$pedido = $pedidoModel->cargarPedido($id);

		if (!isset($pedido[0])) {
			if ($query == true) {
				$res['success'] = false;
				$res['msj'] = "El Pedido fue eliminado";
				return $this->response->setJSON($res);
			} else {
				return null;
			}
		} else {
			$pedido = $pedido[0];
		}

		$productos = $this->pedidosPendientes($pedido->id);

		$cajas = $mPedidosCajas->select("
				pedidoscajas.id AS idCajaPedido,
				pedidoscajas.numero_caja AS numeroCaja,
				pedidoscajas.id_empacador AS empacador,
				pedidoscajas.inicio_empaque AS inicioEmpaque,
				pedidoscajas.fin_empaque AS finEmpaque,
				U.nombre AS nombreEmpacador
			")->join('usuarios AS U', 'pedidoscajas.id_empacador = U.id', 'left')
			->where("pedidoscajas.id_pedido", $pedido->id)
			->findAll();

		$pedido->productos = $productos;
		$pedido->cajas = $cajas;
		if ($query == true) {
			$res['success'] = true;
			$res['pedido'] = $pedido;
			return $this->response->setJSON($res);
		} else {
			return $pedido;
		}
	}

	private function pedidosPendientes($idPedido) {
		$mPedidosProductos = new mPedidosProductos();
		return $mPedidosProductos->select("
				p.id,
				p.referencia, 
				p.item,
				p.descripcion,
				p.imagen,
				pedidosproductos.cantidad,
				(
					pedidosproductos.cantidad - IF(prodCaja.CantTotalCajas IS NULL, 0, prodCaja.CantTotalCajas)
				) AS cantAgregar,
				prodCaja.CantTotalCajas,
				pedidosproductos.id AS idPedidoProducto,
				p.ubicacion AS ubicacionProd,
				CASE 
					WHEN p.imagen IS NULL THEN '' 
					ELSE CONCAT('" . base_url() . "/fotoProductosAPP/', p.id, '/', SUBSTRING(p.imagen,1,LOCATE('.', p.imagen)+-1), '-small', SUBSTRING(p.imagen,LOCATE('.', p.imagen),LENGTH(p.imagen)-LOCATE('.', p.imagen)+1)) 
				END As FotoURLSmall		
			")->join("productos AS p", "pedidosproductos.id_producto = p.id")
			->join("(
				SELECT
					SUM(PCP.cantidad) AS CantTotalCajas, PCP.id_producto
				FROM pedidoscajas PC
					LEFT JOIN pedidoscajasproductos PCP ON PC.id = PCP.id_caja
				WHERE id_pedido = '$idPedido'
				GROUP BY PCP.id_producto
			) AS prodCaja", "pedidosproductos.id_producto = prodCaja.id_producto", "left")
			->where("pedidosproductos.id_pedido", $idPedido)
			->where("pedidosproductos.cantidad > 0")
			->where("(prodCaja.CantTotalCajas IS NULL OR pedidosproductos.cantidad > prodCaja.CantTotalCajas)")
			->orderBy("cantAgregar", "ASC")
			->findAll();
	}

	public function obtenerProductosCaja($idCaja, $query = true) {
		
		$mPedidosCajasProductos = new mPedidosCajasProductos();

		$productosCaja = $mPedidosCajasProductos->select("
				pedidoscajasproductos.id AS idProductoCaja,
				pedidoscajasproductos.id_producto AS idProducto,
				pedidoscajasproductos.cantidad,
				pedidoscajasproductos.created_at AS FechaAgregado,
				p.id,
				p.referencia, 
				p.item, 
				p.descripcion,
				p.precio_venta
			")->join("productos AS p", "pedidoscajasproductos.id_producto = p.id")
			->where("pedidoscajasproductos.id_caja", $idCaja)
			->orderBy("pedidoscajasproductos.id DESC")
			->findAll();

		if ($query == true) {
			$res['success'] = true;
			$res['productosCaja'] = $productosCaja;
			return $this->response->setJSON($res);
		} else {
			return $productosCaja;
		}
	}

	public function agregarCaja() {
		$res['success'] = true;
		$res['msj'] = 'Caja creada correctamente';
		$mPedidosCajas = new mPedidosCajas();
		$pedidoModel = new mPedidos();
		$data = (object) $this->request->getPost();

		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$dataCaja = array(
			"id_pedido" => $data->idPedido
			,"numero_caja" => 1
			,"id_empacador" => (session()->has("id_user") ? session()->get("id_user") : null)
			,"inicio_empaque" => date("Y-m-d H:i:s")
		);

		$ultimaCaja = $mPedidosCajas->selectMax('numero_caja')->where('id_pedido', $data->idPedido)->get()->getResultObject()[0];

		if (is_null($ultimaCaja->numero_caja)) {
			$dataCaja['numero_caja'] = 1;	
		} else {
			$dataCaja['numero_caja'] = ($ultimaCaja->numero_caja + 1);
		}

		$this->db->transBegin();

		if ($mPedidosCajas->save($dataCaja)) {
			$this->db->transCommit();
			$res['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
		} else {
			$this->db->transRollback();
			$res['success'] = false;
			$res['msj'] = 'No fue posible agregar la caja';
		}
		return $this->response->setJSON($res);
	}

	public function eliminarCaja() {
		$res['success'] = true;
		$res['msj'] = 'Caja eliminada correctamente';
		$mPedidosCajas = new mPedidosCajas();
		$mPedidosCajasProductos = new mPedidosCajasProductos();
		$pedidoModel = new mPedidos();
		$data = (object) $this->request->getPost();

		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$caja = $mPedidosCajas->where('id', $data->idCaja)->first();

		$this->db->transBegin();
		
		if ($data->idProdCaja > 0) {
			
			if ($mPedidosCajasProductos->delete($data->idProdCaja)) {
				$this->db->transCommit();
				$res['msj'] = 'Producto retirado correctamente';
				$res['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
			} else {
				$this->db->transRollback();
				$res['success'] = false;
				$res['msj'] = 'No fue posible retirar el producto';
			}

		} else {

			$builder = $this->db->table('pedidoscajasproductos')->where('id_caja', $data->idCaja);

			if ($builder->delete()) { 
				
				if ($mPedidosCajas->delete($data->idCaja)) { 
					
					$builder = $this->db->table('pedidoscajas')
						->set("numero_caja", "(numero_caja - 1)", FALSE)
						->where('id_pedido', $data->idPedido)
						->where("numero_caja > $caja->numero_caja");
	
					if($builder->update()) {
						$this->db->transCommit();
						$res['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
					} else {
						$this->db->transRollback();
						$res['success'] = false;
						$res['msj'] = "No fue posible guardar la información";
					}
				} else {
					$this->db->transRollback();
					$res['success'] = false;
					$res['msj'] = 'No fue posible eliminar la caja';
				}
				
			} else {
				$this->db->transRollback();
				$res['success'] = false;
				$res['msj'] = 'No fue posible eliminar la caja';
			}
		}
		return $this->response->setJSON($res);
	}

	public function agregarProductoCaja() {
		$res['success'] = false;
		$res['msj'] = 'Producto agregado correctamente';
		$mPedidos = new mPedidos();
		$pedidoModel = new mPedidos();
		$data = (object) $this->request->getPost();

		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$this->db->transBegin();

		$dataCajaProd = array(
			"id_caja" => $data->idCaja
			, "id_producto" => $data->idProducto
			, "cantidad" => $data->cantidad
		);

		$producPedi = $mPedidos
			->select('pedidosproductos.cantidad')
			->join("pedidosproductos", "pedidos.id = pedidosproductos.id_pedido", "left")
			->where('pedidos.id', $data->idPedido)
			->where('pedidosproductos.id_producto', $data->idProducto)
			->get()->getResultObject();

		if (!isset($producPedi[0]->cantidad)) {
			$res['msj'] = 'No se encontro el producto en el pedido';
		} else {

			$mPedidosCajas = new mPedidosCajas();
			$producActual = $mPedidosCajas
				->selectSum('pedidoscajasproductos.cantidad')
				->join("pedidoscajasproductos", "pedidoscajas.id = pedidoscajasproductos.id_caja", "left")
				->where('id_pedido', $data->idPedido)
				->where('pedidoscajasproductos.id_producto', $data->idProducto)
				->groupBy('pedidoscajasproductos.id_producto')
				->get()->getResultObject();

			if (isset($producActual[0]->cantidad)) {
	
				$cantiFalta = ((double) $producPedi[0]->cantidad - ((double) $producActual[0]->cantidad));

				if (!($cantiFalta > 0 && $dataCajaProd["cantidad"] <= $cantiFalta)) {
					$res['msj'] = 'La cantidad supera a la cantidad faltante del pedido';	
				} else {
					$res['success'] = true;
				}
	
			} else {
	
				if (!($dataCajaProd['cantidad'] > 0 && $dataCajaProd['cantidad'] <= $producPedi[0]->cantidad)) {
					$res['msj'] = 'La cantidad supera a la registrada en el pedido';	
				} else {
					$res['success'] = true;
				}
			}
		}

		if ($res['success'] == true) {
			$mPedidosCajasProductos = new mPedidosCajasProductos();
			if ($mPedidosCajasProductos->save($dataCajaProd)) {
				$this->db->transCommit();
				$res['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
			} else {
				$this->db->transRollback();
				$res['msj'] = 'No fue posible agregar los productos a la caja';
			}
		}
		return $this->response->setJSON($res);
	}

	public function finalizarEmpaque() {
		$resp["success"] = false;
		// Traemos los datos del post
		$data = (object) $this->request->getPost();
		$pedidoModel = new mPedidos();
		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$this->db->transBegin();

		if ($data->caja == 1) {

			if (session()->has("id_user")) {

				$mPedidosCajas = new mPedidosCajas();

				$datos = $mPedidosCajas->select("id")
					->where("id_empacador", session()->get("id_user"))
					->where("fin_empaque IS NULL")
					->where('id_pedido', $data->idPedido)
					->get()->getResultObject();

				if (isset($datos[0]->id)) {

					$mPedidosCajasProductos = new mPedidosCajasProductos();

					$totalProds = $mPedidosCajasProductos->select("id")
						->where("id_caja", $datos[0]->id)
						->get()->getResultObject();

					if(count($totalProds) > 0) {

						$builder = $this->db->table('pedidoscajas')
							->set("fin_empaque", date("Y-m-d H:i:s"))
							->where("id_empacador", session()->get("id_user"))
							->where("fin_empaque IS NULL")
							->where('id_pedido', $data->idPedido);

						if($builder->update()) {
							$resp["success"] = true;
							$resp['msj'] = "Caja finalizada correctamente";
						} else {
							$resp['msj'] = "No fue posible finalizar la caja";
						}

					} else {
						$resp['msj'] = "No se econtraron productos dentro de la caja";
					}

				} else {
					$resp['msj'] = "No se econtro caja en proceso de empaque";
				}

			} else {
				$resp['msj'] = "No encontro registrado el usuario";
			}

		} else {

			$mPedidosCajas = new mPedidosCajas();
			$faltantes = $mPedidosCajas
				->select('id,numero_caja')
				->where('id_pedido', $data->idPedido)
				->where('fin_empaque IS NULL')
				->get()->getResultObject();
			
			if (count($faltantes) == 0) {
			
				$productos = $this->pedidosPendientes($data->idPedido);

				if (count($productos) == 0) {
		
					$builder = $this->db->table('pedidos')
						->set("fin_empaque", date("Y-m-d H:i:s"))
						->set("estado", 'EM')
						->where('id', $data->idPedido);
		
					if($builder->update()) {
						$resp["success"] = true;
						$resp['msj'] = "Empaque finalizado correctamente";
					} else {
						$resp['msj'] = "No fue posible finalizar el empaque";
					}
				} else {
					/* Se organiza por si desea dejar los prods sin empacar */
					$res['success'] = false;
					$res['msj'] = "¿Está seguro de finalizar el pedido con productos sin empacar?";
					$res['obsProds'] = $productos;
					return $this->response->setJSON($res);
				}
			} else {
				$resp['msj'] = "Aun falta la caja " . $faltantes[0]->numero_caja . " por cerrar";
			}
		}
		if ($resp["success"] == true) {
			$this->db->transCommit();
			$resp['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
		} else {
			$this->db->transRollback();
		}
		return $this->response->setJSON($resp);
	}

	public function reabrirCaja() {
		$resp["success"] = false;
		// Traemos los datos del post
		$data = (object) $this->request->getPost();

		$this->db->transBegin();

		if (session()->has("id_user")) {

			$pedidoModel = new mPedidos();
			$pedido = $pedidoModel->cargarPedido($data->idPedido);

			if (!isset($pedido[0])) {
				$res['success'] = false;
				$res['msj'] = "El Pedido fue eliminado";
				$res['recargar'] = true;
				return $this->response->setJSON($res);
			}

			$mPedidosCajas = new mPedidosCajas();

			$datos = $mPedidosCajas->select("id")
				->where("id_empacador", session()->get("id_user"))
				->where("fin_empaque IS NULL")
				->where('id_pedido', $data->idPedido)
				->get()->getResultObject();

			if (isset($datos[0]->id)) {
				$resp['msj'] = "Tiene una caja pendiente por cerrar";
			} else {

				$builder = $this->db->table('pedidoscajas')->set("fin_empaque", NULL)->where('id', $data->idCaja);

				if($builder->update()) {
					$resp["success"] = true;
					$resp['msj'] = "Caja abierta correctamente";
				} else {
					$resp['msj'] = "No fue posible abrir la caja";
				}

			}

		} else {
			$resp['msj'] = "No encontro registrado el usuario";
		}

		if ($resp["success"] == true) {
			$this->db->transCommit();
			$resp['pedido'] = $this->obtenerProductosPedido($data->idPedido, false);
		} else {
			$this->db->transRollback();
		}
		return $this->response->setJSON($resp);
	}

	public function reabrirEmpaque() {
		$resp["success"] = false;
		// Traemos los datos del post
		$data = (object) $this->request->getPost();

		$pedidoModel = new mPedidos();
		$pedido = $pedidoModel->cargarPedido($data->idPedido);

		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$this->db->transBegin();

		$mPedidos = new mPedidos();

		$builder = $this->db->table('pedidos')->set("fin_empaque", NULL)->where('id', $data->idPedido);

		if($builder->update()) {
			$this->db->transCommit();
			$resp["success"] = true;
			$resp['msj'] = "Caja abierta correctamente";
		} else {
			$this->db->transRollback();
			$resp['msj'] = "No fue posible reabrir la caja";
		}
		return $this->response->setJSON($resp);
	}

	public function observacionProductos() {
		$resp["success"] = false;
		// Traemos los datos del post
		$data = (object) $this->request->getPost();
		$mObservacionProductos = new mObservacionProductos();
		$pedidoModel = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();

		$pedido = $pedidoModel->cargarPedido($data->idPedido);
		if (!isset($pedido[0])) {
			$res['success'] = false;
			$res['msj'] = "El Pedido fue eliminado";
			$res['recargar'] = true;
			return $this->response->setJSON($res);
		}

		$productos = $this->pedidosPendientes($data->idPedido);
		if(count($productos) == 0) {
			$res['success'] = false;
			$res['msj'] = "No se encontraron productos pendientes por empacar";
			$res['empaque'] = true;
			return $this->response->setJSON($res);
		}

		$this->db->transBegin();

		$cantidad = 0;
		foreach ($data->productos as $it) {

			$pedidoProd = $mPedidosProductos->asObject()->find($it['pedidoProd']);

			$builder = $this->db->table('pedidosproductos')
												->set("cantidad", ($pedidoProd->cantidad - $it['cantidad']))
												->where('id', $it['pedidoProd']);
		
			if($builder->update()) {
				$dataObserSave = array(
					"id_pedido_producto" => $it['pedidoProd'],
					"motivo" => $it['motivo'],
					"observacion" => $it['observacion'],
					"cantidad_anterior" => $pedidoProd->cantidad,
					"cantidad_actual" => ($pedidoProd->cantidad - $it['cantidad']),
					"valor_anterior" => 0,
					"valor_actual" => 0,
					"tipo" => "E"
				);
			
				if(!$mObservacionProductos->save($dataObserSave)){
					$resp["msj"] = "Error al guardar la observación del producto. " . listErrors($mObservacionProductos->errors());
					break;
				} else {
					$cantidad++;
				}
			} else {
				$resp["msj"] = "No fue posible actualizar el pedido.";
				break;
			}
		}

		if (count($data->productos) == $cantidad) {

			$builder = $this->db->table('pedidoscajas')
				->set("fin_empaque", date("Y-m-d H:i:s"))
				->where("id_empacador", session()->get("id_user"))
				->where("fin_empaque IS NULL")
				->where('id_pedido', $data->idPedido);

			if($builder->update()) {

				$builder = $this->db->table('pedidos')
					->set("fin_empaque", date("Y-m-d H:i:s"))
					->set("estado", 'EM')
					->where('id', $data->idPedido);
	
				if($builder->update()) {
					$resp["success"] = true;
					$resp['msj'] = "Empaque finalizado correctamente";
				} else {
					$resp['msj'] = "No fue posible finalizar el empaque del pedido";
				}
			} else {
				$resp['msj'] = "No fue posible finalizar las cajas pendientes";
			}
		}

		if ($resp["success"] == true) {
			$this->db->transCommit();
		} else {
			$this->db->transRollback();
		}
		return $this->response->setJSON($resp);
	}
}