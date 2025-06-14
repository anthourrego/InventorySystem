<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\MovimientoInventarioEntity;
use \Hermawan\DataTables\DataTable;
use App\Models\mPedidos;
use App\Models\mProductos;
use App\Models\mUsuarios;
use App\Models\mClientes;
use App\Models\mPedidosProductos;
use App\Models\mConfiguracion;
use App\Models\mObservacionProductos;
use App\Models\MovimientoInventarioModel;
use App\Models\mVentas;
use App\Models\mVentasProductos;
use App\Models\mPedidosCajas;
use App\Models\mPedidosCajasProductos;
use App\Models\mSucursalesCliente;
use App\Models\Contabilidad\mCuentaMovimientos;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use stdClass;

class cPedidos extends BaseController {
	public function index() {
		$this->content['title'] = "Administador Pedidos";
		$this->content['view'] = "Pedidos/vAdministador";

		$this->content['css_add'][] = [
			'Pedidos/cssAdministrador.css'
		];

		$this->LDataTables();
		$this->LMoment();

		$this->content['manejaEmpaque'] = (
			!session()->has("manejaEmpaque") || session()->get("manejaEmpaque") == "1" ? "1" : "0"
		);

		$this->content['usuario'] = (session()->has("id_user") ? session()->get("id_user") : null);

		$this->content['js_add'][] = [
			'Pedidos/jsAdministrador.js',
			'ProductosReportados/jsProductosReportadosAcciones.js'
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
		$this->LBsCustomFileInput();

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();

    	$mConfiguracion = new mConfiguracion();

		$dataPref = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '');
		$cantDigitos = (session()->has("digitosPed") ? session()->get("digitosPed") : 0);

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoPed")->first();

		$value = (is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1));
		$this->content["nroPedido"] = $dataPref . str_pad($value, $cantDigitos, "0", STR_PAD_LEFT);

		$this->content["prefijoValido"] = ($dataPref != '' ? 'S' : 'N');

		$this->content["pedido"] = null;

		$this->content["inventario_negativo"] = (
			session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0'
		);

		$this->content["cantidad_despachar"] = (session()->has("cantDespachar") ? session()->get("cantDespachar") : '6');

		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0'),
			"ventaPaca" => (session()->has("ventaXPaca") ? session()->get("ventaXPaca") : '0')
 		];

		 $this->content["editarPedido"] = 'S';

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
				(pedidosproductos.valor * pedidosproductos.cantidad) AS valorTotal,
				SUB_PC.cantidadEnCaja,
				SUB_PC.productoEnCajas
			")->join("productos AS p", "pedidosproductos.id_producto = p.id")
			->join("(
				SELECT
					PCP.id_producto,
					SUM(PCP.cantidad) AS cantidadEnCaja,
					GROUP_CONCAT(DISTINCT(PC.numero_caja) ORDER BY PC.numero_caja ASC SEPARATOR ', ') AS productoEnCajas
				FROM pedidoscajas PC
					LEFT JOIN pedidoscajasproductos PCP ON PC.ID = PCP.id_caja
				WHERE PC.id_pedido = {$pedido->id}
				GROUP BY PCP.id_producto
			) AS SUB_PC", "pedidosproductos.id_producto = SUB_PC.id_producto", "LEFT")
			->where("pedidosproductos.id_pedido", $pedido->id)
			->where("pedidosproductos.cantidad > 0")
			->findAll();

		$pedido->productos = $productos;
		
		$this->content["pedido"] = $pedido;
		$this->content["prefijoValido"] = 'S';

		$this->content["editarPedido"] = 'S';
		if (!validPermissions([102], true)) {
			$this->content["editarPedido"] = 'N';
		} else {
			if (!is_null($pedido) && $pedido->estado == 'FA') {
				$this->content["editarPedido"] = 'N';
			}
		}

		$this->content["nroPedido"] = $pedido->pedido;

		$this->content["cantidad_despachar"] = (session()->has("cantDespachar") ? session()->get("cantDespachar") : '6');

		$this->content['title'] = ($pedido->estado == 'EM' ? "Ver" : "Editar") . " pedido " . $pedido->pedido;
		$this->content['view'] = "Pedidos/vCrear";

		$this->LDataTables();
		$this->LMoment();
		$this->LSelect2();
		$this->LInputMask();
		$this->LJQueryValidation();
		$this->LFancybox();
		$this->LBsCustomFileInput();

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();
		$this->content["cantidadVendedores"] = $this->cantidadVendedores();
		$this->content["inventario_negativo"] = (
			session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0'
		);
		$this->content["cantidad_despachar"] = (session()->has("cantDespachar") ? session()->get("cantDespachar") : '6');
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
		$estado = $this->request->getPost("estado");

		$dataPref = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '');

		$subQuery = $this->db->table("observacionproductos AS OP")
					->select("PP.id_pedido AS id_pedido, COUNT(PP.id_producto) AS TotalProductosReportados")
					->join("pedidosproductos PP", "OP.id_pedido_producto = PP.id", "left")
					->where("OP.fecha_confirmacion IS NULL")
					->groupBy("PP.id_pedido")->getCompiledSelect();

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
				CASE
					WHEN V.id IS NOT NULL
						THEN CASE
							WHEN V.leidoQR = 1
								THEN 'Facturado QR'
							ELSE 'Facturado'
						END
					WHEN P.Estado = 'DE'
						THEN 'Despachado'
					WHEN P.Estado = 'PE'
						THEN 'Pendiente'
					WHEN P.Estado = 'EP'
						THEN 'En Proceso'
					ELSE 'Empacado'
				END AS NombreEstado,
				CASE
					WHEN P.Estado = 'DE'
						THEN 1
					WHEN P.Estado = 'PE'
						THEN 2
					WHEN P.Estado = 'EP'
						THEN 3
					WHEN V.id IS NOT NULL
						THEN 5
					ELSE 4
				END AS Orden,
				P.total,
				S.direccion,
				S.nombre AS NombreSucursal,
				V.id AS idFactura,
				CUI.nombre AS Ciudad,
				TC.TotalCajas,
				V.codigo AS factura,
				V.leidoQR,
				CAST(SUBSTRING_INDEX(codigo, '$dataPref', -1) AS UNSIGNED) AS Delimitado,
				TPR.TotalProductosReportados,
				P.observacion
			")->join('clientes AS C', 'P.id_cliente = C.id', 'left')
			->join('sucursales AS S', 'P.id_sucursal = S.id', 'left')
			->join('ciudades AS CUI', 'S.id_ciudad = CUI.id', 'left')
			->join('usuarios AS U', 'P.id_vendedor = U.id', 'left')
			->join('ventas AS V', 'P.id = V.id_pedido', 'left')
			->join("(
				SELECT
					COUNT(id_pedido) AS TotalCajas
					, id_pedido
				FROM pedidoscajas
				GROUP BY id_pedido
			) AS TC", "P.id = TC.id_pedido", "left")
			->join("({$subQuery}) TPR", "P.id = TPR.id_pedido", "left");

		if($estado != "-1") {
			if($estado == "FA") {
				$query->where("V.id IS NOT NULL")
					->groupStart()
							->where("V.leidoQR IS NULL")
							->orWhere('V.leidoQR', '0')
					->groupEnd();
			} elseif ($estado == "FQ") {
				$query->where("V.id IS NOT NULL")
					->groupStart()
							->where("V.leidoQR IS NOT NULL")
							->Where('V.leidoQR', 1)
					->groupEnd();
			} elseif($estado == "EM") {
				$query->where("(P.Estado IN('EM', 'FA') AND V.id IS NULL)");
			} else {
				$query->where("P.Estado", $estado);
			}
		}

		return DataTable::of($query)->toJson(true);
	}

	public function eliminar() {
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$contActProd = true;
		$mPedidosCajas = new mPedidosCajas();
		$mPedidosCajasProductos = new mPedidosCajasProductos();
        
		$this->db->transBegin();

		$cajas = $mPedidosCajas->where('id_pedido', $data->id)->findAll();
		
		foreach ($cajas as $it) {
			
			/* Eliminamos los productos de la caja actual */
			if (!$mPedidosCajasProductos->where('id_caja', $it->id)->delete()) {
				$contActProd = false;
				break;
			}

			/* Eliminamos la caja */
			if (!$mPedidosCajas->delete($it->id)) {
				$contActProd = false;
				break;
			}
		}

		if ($contActProd == true) {
			$mPedidosProductos = new mPedidosProductos();
			$mObservacionProductos = new mObservacionProductos();
			$moveEntity = new MovimientoInventarioEntity(["tipo" => "I", "observacion" => "Elimia pedido {$data->codigo} con id {$data->id}"]);
			$moveInventoryModel = new MovimientoInventarioModel();
	
			$productosPedidos = $mPedidosProductos->where("id_pedido", $data->id)->findAll();

			//Actualizamos el inventario de los productos
			foreach ($productosPedidos as $it) {

				//Actualizamos los datos a cambiar
				$moveEntity->id_producto = $it->id_producto;
				$moveEntity->cantidad = $it->cantidad;
				
				if (!$moveInventoryModel->save($moveEntity)) {
					$contActProd = false;
					break;
				}

				if ($moveInventoryModel->errorAfterInsert) {
					$contActProd = false;
					break;
				}
				$mObservacionProductos->where('id_pedido_producto', $it->id)->where("tipo IS NULL")->delete();
			}
		}
		
		//Eliminamos todos los datos
		if ($contActProd == true) {
			//Actualizamos todos los movmientos de inventairo quitandole la relación con los pedidos
			$moveInventoryModel->set("id_pedido", null)->where("id_pedido", $data->id);

			if ($moveInventoryModel->update()) {
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
		} else {
			$resp['msj'] = "Error al actualizar el inventario.";
		}

		if($resp["success"] == false || $this->db->transStatus() === false) {
			$this->db->transRollback();
		} else {
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

		$pedidoModel = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();
		$mConfiguracion = new mConfiguracion();

		$dataPref = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '');
		$cantDigitos = (session()->has("digitosPed") ? session()->get("digitosPed") : 0);

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoPed")->first();

		$numerPedido = str_pad((is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1)), $cantDigitos, "0", STR_PAD_LEFT);
		$pedido = $dataPref . $numerPedido;

		$buscarPedido = $pedidoModel->select("id")->where("pedido", $pedido)->first();

		if (!is_null($buscarPedido) && $buscarPedido->id > 0) {
			$resp["msj"] = "El pedido <strong>$pedido</strong> ya se encuentra registrado.";
			return $this->response->setJSON($resp);
		}

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
				"estado" => "PE",
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($pedidoModel->save($dataSave)){
				$dataSave["id"] = $pedidoModel->getInsertID();
				$moventInventoryModel = new MovimientoInventarioModel();
				$moventEntity = new MovimientoInventarioEntity(["tipo" => "S", "id_pedido" => $dataSave["id"]]);

				foreach ($prod as $it) {
					$dataProductoPedido = [
						"id_pedido" => $dataSave["id"],
						"id_producto" => $it->id,
						"cantidad" => $it->cantidad,
						"valor" => $it->valorUnitario,
						"valor_original" => $it->precio_venta
					];

					$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);

					if (!$mPedidosProductos->save($dataProductoPedido)) {
						$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mPedidosProductos->errors());
						break;
					}

					$moventEntity->id_producto = $it->id;
					$moventEntity->cantidad = $it->cantidad;

					if(!$moventInventoryModel->save($moventEntity)){
						$resp["msj"] = "Error al guardar al registrar el movimiento. " . listErrors($moventInventoryModel->errors());
						break;
					}

					if($moventInventoryModel->errorAfterInsert){
						$resp["msj"] = $moventInventoryModel->errorAfterInsertMsg;
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

				if (is_null($dataConse)) {
					$mConfiguracion = new mConfiguracion();
					$dataSave = [
						"campo" => "consecutivoPed",
						"valor" => $numerPedido
					];
					if(!$mConfiguracion->save($dataSave)) {
						$this->db->transRollback();
						$resp["msj"] = "Ha ocurrido un error al guardar el pedido." . listErrors($mConfiguracion->errors());
					} else {
						$this->db->transCommit();
					}
				} else {
					$builder = $this->db->table('configuracion')->set("valor", $numerPedido)->where('campo', "consecutivoPed");
					if($builder->update()) {
						$this->db->transCommit();
					} else {
						$resp["success"] = false;
						$this->db->transRollback();
					}
				}

				$resp["nroPedido"] = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '') . ($numerPedido + 1);
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
		$mObservacionProductos = new mObservacionProductos();
		$moventInventoryModel = new MovimientoInventarioModel();
		$moventEntity = new MovimientoInventarioEntity(["id_pedido" => $dataPost->idPedido]);
		
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

			if ($dataPost->estado == 'EM' && $dataPost->regresarEmpaque == 1) {
				$dataSave['estado'] = 'EP';
				$dataSave['fin_empaque'] = null;
			}

			if($mPedidos->save($dataSave)){
				//mostramos los productos actuales para comparalos con los que ingresan
				$productoActuales = $mPedidosProductos->asArray()->where("id_pedido", $dataPost->idPedido)->findAll();

				foreach ($prod as $it) {
					$it->idProductoPedido = isset($it->idProductoPedido) ? $it->idProductoPedido : 0;
					$productoAct = array_search($it->idProductoPedido, array_column($productoActuales, 'id'));
					//Si el producto no existe se debe de agregar
					if($productoAct !== false){

						if (isset($it->eliminado) && $it->eliminado == true) {
							$it->cantidad = 0;
						}

						//Validamos si los valores y las cantidades cambian
						if(
							$it->cantidad != $productoActuales[$productoAct]["cantidad"]
							|| $it->valorUnitario != $productoActuales[$productoAct]["valor"]
						) {
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

							if (!isset($it->motivoDiferencia)) {
								$moventEntity->id_producto = $it->id;
								$moventEntity->tipo = ($cantidadNueva > 0 ? "I" : "S");
								$moventEntity->cantidad = abs($cantidadNueva);
								$moventEntity->observacion = ($cantidadNueva > 0 ? "Disminuye" : "Aumenta") . " el producto por edición del pedido {$dataPost->codigoPedido}";
								
								if(!$moventInventoryModel->save($moventEntity)){
									$resp["msj"] = "Error al guardar al registrar el movimiento. " . listErrors($moventInventoryModel->errors());
									break;
								}

								if($moventInventoryModel->errorAfterInsert){
									$resp["msj"] = $moventInventoryModel->errorAfterInsertMsg;
									break;
								}
							}
						}

						if (isset($it->motivoDiferencia) && $it->motivoDiferencia != '') {
							
							$dataObserSave = array(
								"id_pedido_producto" => $it->idProductoPedido,
								"motivo" => $it->motivoDiferencia,
								"observacion" => $it->observacionDiferencia,
								"cantidad_anterior" => $it->cantidadOriginal,
								"cantidad_actual" => $it->cantidad,
								"valor_anterior" => $it->valorUnitarioOriginal,
								"valor_actual" => $it->valorUnitario,
								"id_usuario" => (session()->has("id_user") ? session()->get("id_user") : null)
							);
						
							if(!$mObservacionProductos->save($dataObserSave)){
								$resp["msj"] = "Error al guardar la observación del producto. " . listErrors($mObservacionProductos->errors());
								break;
							}
						}

						$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);
						unset($productoActuales[$productoAct]);
						$productoActuales = array_values($productoActuales);
					} else {
						$dataProductoPedido = [
							"id_pedido" => $dataPost->idPedido,
							"id_producto" => $it->id,
							"cantidad" => $it->cantidad,
							"valor" => $it->valorUnitario,
							"valor_original" => $it->precio_venta
						];
	
						$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);

	
						if (!$mPedidosProductos->save($dataProductoPedido)) {
							$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mPedidosProductos->errors());
							break;
						}
	
						$moventEntity->id_producto = $it->id;
						$moventEntity->tipo = "S";
						$moventEntity->cantidad = $it->cantidad;
						$moventEntity->observacion = "Agrega el producto nuevo por edición de la venta {$dataPost->codigoPedido}";
						
						if(!$moventInventoryModel->save($moventEntity)){
							$resp["msj"] = "Error al guardar al registrar el movimiento. " . listErrors($moventInventoryModel->errors());
							break;
						}

						if($moventInventoryModel->errorAfterInsert){
							$resp["msj"] = $moventInventoryModel->errorAfterInsertMsg;
							break;
						}

						if (isset($it->motivoDiferencia) && $it->motivoDiferencia != '') {
							$dataObserSave = array(
								"id_pedido_producto" => $mPedidosProductos->getInsertID(),
								"motivo" => $it->motivoDiferencia,
								"observacion" => $it->observacionDiferencia,
								"cantidad_anterior" => isset($it->cantidadOriginal) ? $it->cantidadOriginal : 0,
								"cantidad_actual" => $it->cantidad,
								"valor_anterior" => isset($it->valorUnitarioOriginal) ? $it->valorUnitarioOriginal : 0,
								"valor_actual" => $it->valorUnitario,
								"id_usuario" => (session()->has("id_user") ? session()->get("id_user") : null)
							);
						
							if(!$mObservacionProductos->save($dataObserSave)){
								$resp["msj"] = "Error al guardar  la observación del producto. " . listErrors($mObservacionProductos->errors());
								break;
							}
						}
					}
				}

				//Eliminamos los productos restantes de la venta
				foreach ($productoActuales as $it) {
					$it = is_object($it) ? $it : (object) $it;

					$mObservacionProductos->where('id_pedido_producto', $it->id)->delete();

					if($mPedidosProductos->delete($it->id)) {
						$moventEntity->id_producto = $it->id_producto;
						$moventEntity->tipo = "I";
						$moventEntity->cantidad = $it->cantidad;
						$moventEntity->observacion = "Elimina el producto nuevo por edición de la venta {$dataPost->codigoPedido}";
						
						if(!$moventInventoryModel->save($moventEntity)){
							$resp["msj"] = "Error al guardar al registrar el movimiento. " . listErrors($moventInventoryModel->errors());
							break;
						}

						if($moventInventoryModel->errorAfterInsert){
							$resp["msj"] = $moventInventoryModel->errorAfterInsertMsg;
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
		return $mUsuarios->join("(
			SELECT
				usuarioId,
				perfilId,
				COUNT(*) AS Vendedor
			FROM permisosusuarioperfil
			WHERE permiso = '61'
			GROUP BY usuarioId, perfilId) AS pup",
			"(CASE WHEN usuarios.perfil IS NULL THEN usuarios.id = pup.usuarioId ELSE usuarios.perfil = pup.perfilId END
		)", "inner", false)
		->where("usuarios.estado", 1)
		->countAllResults();
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
			if ($data->estado == 'DE') {
				$resp['msj'] = "Pedido despachado correctamente";
			} else {
				$resp['msj'] = "Pedido en proceso alistamiento";
			}
		} else {
			$this->db->transRollback();
			$resp['msj'] = "No fue posible guardar la información";
		}

		return $this->response->setJSON($resp);
	}

	public function facturarPedido() {
		$resp["success"] = false;

		// Traemos los datos del post
		$data = (object) $this->request->getPost();
		$mVentas = new mVentas();
		
		$this->db->transBegin();
		
		$factura = $mVentas->asObject()->where("id_pedido", $data->id)->first();

		if (is_null($factura)) {
			$resp = $this->crearFacturaPedido($data);

			if ($resp['success'] == true) {
				$builder = $this->db->table('pedidos')->set("estado", $data->estado)->where('id', $data->id);
				if($builder->update()) {
					$this->db->transCommit();
				} else {
					$resp['msj'] = "No fue posible generar la factura";
					$this->db->transRollback();
				}
			} else {
				$this->db->transRollback();
			}

		} else {
			$builder = $this->db->table('ventas')->set("leidoQR", 0)->where('id_pedido', $data->id);
			if($builder->update()) {
				$resp["success"] = true;
				$resp['msj'] = "Pedido Facturado correctamente, Factura nro: " . $factura->codigo;
				$resp['id_factura'] = $factura->id;
				$this->db->transCommit();
			} else {
				$this->db->transRollback();
				$resp['msj'] = "No fue posible generar la factura";
			}
		}
		return $this->response->setJSON($resp);
	}

	public function cajasManifiestos($pedido) {
		$resp["success"] = false;
		$resp["msj"] = "Caja encontradas";
		$mPedidosCajas = new mPedidosCajas();

		$cajas = $mPedidosCajas->select("
				id AS idCaja,
				numero_caja AS numeroCaja
			")
			->where("id_pedido", $pedido)
			->orderBy("numero_caja", "ASC")
			->findAll();

		if (count($cajas) > 0) {

			$mPedidosCajasProductos = new mPedidosCajasProductos();

			foreach($cajas as $pos => $value1) {
				$productos = $mPedidosCajasProductos->select("
					M.nombre AS Manifiesto,
					M.id AS idManifiesto,
				")
				->join("productos AS P", "pedidoscajasproductos.id_producto = P.id", "left")
				->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
				->where("id_caja", $value1->idCaja)
				->orderBy("pedidoscajasproductos.id", "DESC")
				->findAll();
	
				$manifiestos = [];
				foreach ($productos as $value) {
					if (!is_null($value->idManifiesto)) {
						$enc = array_search($value->idManifiesto, array_column($manifiestos, "id"));
						if ($enc === false) {
							$data = [
								"id" => $value->idManifiesto,
								"nombre" => $value->Manifiesto
							];
							array_push($manifiestos, $data);
						}
					}
				}
				$cajas[$pos]->manifiestos = $manifiestos;
			}
			$resp["datos"] = $cajas;
			$resp["success"] = true;
		} else {
			$resp["msj"] = "No se encontraron cajas para el pedido";
		}
		return $this->response->setJSON($resp);
	}

	public function generarQR($pedido) {
		$resp["success"] = true;
		$resp["msj"] = "Código QR generado correctamente";
		$resp["name"] = "QR_$pedido";
		$options = new QROptions([
			'imageTransparent' => false
		]);
		$resp["qr"] = (new QRCode($options))->render(base_url() . "/FacturaQR/{$pedido}/0");
		return $this->response->setJSON($resp);
	}

	public function facturaQR($factura, $creaFactura) {
		$mVentas = new mVentas();
		$mPedidos = new mPedidos();
		$mVentasProductos = new mVentasProductos();
		$mPedidosCajas = new mPedidosCajas();
		$mConfiguracion = new mConfiguracion();

		$this->content['cajas'] = [];
		$this->content['productos'] = [];
		$this->content['creaFactura'] = $creaFactura;
		$this->content['codPedido'] = $factura;

		$this->content['factura'] = $mVentas->asObject()->where("id_pedido", $factura)->first();

		$this->db->transBegin();

		$nuevo = false;
		if ($creaFactura == 1 && is_null($this->content['factura'])) {

			$pedido = $mPedidos->asObject()->find($factura);

			if (in_array($pedido->estado, ['EM', 'FA', 'DE'])) {
				$prefijo = $mConfiguracion->select("valor")->where("campo", "prefijoFact")->first();
				$data = (object) array(
					"id" => $factura,
					"prefijo" => (isset($prefijo->valor) && !is_null($prefijo->valor) ? $prefijo->valor : '')
				);
				$resp = $this->crearFacturaPedido($data, true);
	
				if (isset($resp["id_factura"])) {
					$this->content['factura'] = $mVentas->asObject()->find($resp["id_factura"]);
					$nuevo = true;

					$builder = $this->db->table('pedidos')->set("estado", 'FA')->where('id', $factura);
					if(!$builder->update()) {
						$this->content['factura'] = null;
					}
				}
			}
		}

		if (isset($this->content['factura']->id_pedido)) {
			/* Cajas del pedido */
			$cajas = $mPedidosCajas->select("
				pedidoscajas.id AS idCajaPedido,
				pedidoscajas.numero_caja AS numeroCaja,
				pedidoscajas.id_empacador AS empacador,
				pedidoscajas.inicio_empaque AS inicioEmpaque,
				pedidoscajas.fin_empaque AS finEmpaque,
				U.nombre AS nombreEmpacador
			")->join('usuarios AS U', 'pedidoscajas.id_empacador = U.id', 'left')
			->where("pedidoscajas.id_pedido", $this->content['factura']->id_pedido)
			->findAll();

			if (count($cajas) > 0) {

				$mPedidosCajasProductos = new mPedidosCajasProductos();

				foreach($cajas as $pos => $value1) {
					$cajas[$pos]->productos = $mPedidosCajasProductos->select("
						P.item,
						P.referencia,
						P.descripcion,
						P.precio_venta,
						P.cantPaca,
						pedidoscajasproductos.cantidad,
						PP.valor,
						P.imagen,
						P.id
					")
					->join("productos AS P", "pedidoscajasproductos.id_producto = P.id", "left")
					->join("pedidosproductos AS PP", "pedidoscajasproductos.id_producto = PP.id_producto AND PP.id_pedido = '" . $this->content['factura']->id_pedido . "'", "left")
					->where("pedidoscajasproductos.id_caja", $value1->idCajaPedido)
					->orderBy("pedidoscajasproductos.id", "DESC")
					->findAll();
				}
			}
			$this->content['cajas'] = $cajas;

			$this->content['productos'] = $mVentasProductos->select("
				P.item,
				P.referencia,
				P.descripcion,
				ventasproductos.valor AS precio_venta,
				P.cantPaca,
				ventasproductos.cantidad
			")->join("productos AS P", "ventasproductos.id_producto = P.id", "left")
			->where("id_venta", $factura)
			->findAll();
		}

		if ($nuevo == true) {
			$builder = $this->db->table('ventas')->set("leidoQR", 1)->where('id_pedido', $factura);
			if($builder->update()) {
				$this->db->transCommit();
			} else {
				$this->db->transRollback();
			}
		} else {
			$this->db->transCommit();
		}

		if (!is_null($this->content['factura'])) {
			$mConfiguracion = new mConfiguracion();

			$emailEmpresa = $mConfiguracion->select("valor, campo")->where('campo', "emailEmpresa")->get()->getRow('valor');

			if (
				!is_null($emailEmpresa)
				&& $emailEmpresa != ''
				&& strpos($emailEmpresa, '@') !== false
				&& strpos($emailEmpresa, '.') !== false
			) {
				$body = "<div>
					<h3>Descarga Factura QR</h3>
					<p>
						Se ha descargado la factura " . $this->content['factura']->codigo .
						" por un total de " . $this->content['factura']->total . " desde la opción del QR
					</p>
				</div>";

				$this->content['respuestaCorreo'] = sendEmail(
					$mConfiguracion
					, [$emailEmpresa]
					, "Descarga Factura " . $this->content['factura']->codigo, $body
				);
			}

			$mClientes = new mClientes();
			$this->content['factura']->cliente =  $mClientes->asObject()->find($this->content['factura']->id_cliente);

			$this->content['factura'] = $mVentas->select("
				ventas.*,
				C.documento AS documentoEmpresa,
				C.nombre AS Cliente,
				U.nombre AS Vendedor,
				S.nombre AS Sucursal,
				D.nombre AS Depto,
				CI.nombre AS Ciudad,
				S.telefono AS Telefono,
				S.direccion AS Direccion,
				DATE_FORMAT(ventas.created_at, '%d-%m-%Y') AS Fecha
			")->join('clientes AS C', 'ventas.id_cliente = C.id', 'left')
			->join('usuarios AS U', 'ventas.id_vendedor = U.id', 'left')
			->join('sucursales AS S', 'ventas.id_sucursal = S.id', 'left')
			->join('departamentos AS D', 'S.id_depto = D.id', 'left')
			->join('ciudades AS CI', 'S.id_ciudad = CI.id', 'left')
			->where("ventas.id", $this->content['factura']->id)
			->first();
			
			$this->content['nitEmpresa'] = $this->content['factura']->documentoEmpresa;
		} else {

			$dataPedido = $mPedidos->select("
				C.documento AS documentoEmpresa
			")->join('clientes AS C', 'pedidos.id_cliente = C.id', 'left')
			->where("pedidos.id", $factura)
			->first();
			
			$this->content['nitEmpresa'] = $dataPedido->documentoEmpresa;
		}


		return view('vFacturaQR', $this->content);
	}

	private function crearFacturaPedido($data, $qr = false) {
		$resp["success"] = false;

		// Facturamos el pedido
		$mConfiguracion = new mConfiguracion();
		$pedidoModel = new mPedidos();
		$mPedidosProductos = new mPedidosProductos();
		$ventaModel = new mVentas();
		$mVentasProductos = new mVentasProductos();

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoFact")->first();
		$cantDigitos = (session()->has("digitosFact") ? session()->get("digitosFact") : 0);

		$numerVenta = str_pad((is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1)), $cantDigitos, "0", STR_PAD_LEFT);
		$prefijoVal = (isset($data->prefijo) ? $data->prefijo : '');
		$codigo = (session()->has("prefijoFact") ? session()->get("prefijoFact") : $prefijoVal) . $numerVenta;

		$pedido = $pedidoModel->find($data->id);
		$pedidoProductos = $mPedidosProductos->where("id_pedido", $data->id)->findAll();

		$fechaVencimiento = $this->calculateMaturiyInvoice($pedido->id_sucursal);

		$descuento = $this->calculateDiscount($pedido->total);

		$ventaSave = [
			"codigo" => $codigo,
			"id_cliente" => $pedido->id_cliente,
			"id_vendedor" => $pedido->id_vendedor,
			"observacion" => $pedido->observacion,
			"impuesto" => $pedido->impuesto,
			"neto" => $pedido->neto,
			"total" => $pedido->total,
			"metodo_pago" => $pedido->metodo_pago,
			"id_sucursal" => $pedido->id_sucursal,
			"id_pedido" => $data->id,
			"fecha_vencimiento" => $fechaVencimiento->format('Y-m-d'),
			"descuento" => $descuento,
		];

		if ($qr == true) {
			$ventaSave['leidoQR'] = 1;
		}

		if($ventaModel->save($ventaSave)){
			$ventaSave["id"] = $ventaModel->getInsertID();

			foreach ($pedidoProductos as $it) {
				$dataProductoVenta = [
					"id_venta" => $ventaSave["id"],
					"id_producto" => $it->id_producto,
					"cantidad" => $it->cantidad,
					"valor" => $it->valor,
					"valor_original" => $it->valor_original
				];

				if (!$mVentasProductos->save($dataProductoVenta)) {
					$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mVentasProductos->errors());
					break;
				}
			}
			if ($this->db->transStatus() !== false) {
				$resp["success"] = true;
				$resp['msj'] = "Pedido Facturado correctamente, Factura nro: " . $codigo;
				$resp["id_factura"] = $ventaSave["id"];
				$resp["nFactura"] = $codigo;

				$mCuentaMovimientos = new mCuentaMovimientos();
				$mCuentaMovimientos->guardarVenta($ventaSave["id"]);
			}
		} else {
			$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($ventaModel->errors());
		}

		if($resp["success"] == true || $this->db->transStatus() !== false) {
			if (is_null($dataConse)) {
				$mConfiguracion = new mConfiguracion();
				$dataSave = [
					"campo" => "consecutivoFact",
					"valor" => $numerVenta
				];
				if(!$mConfiguracion->save($dataSave)) {
					$resp["msj"] = "Ha ocurrido un error al guardar la factura." . listErrors($mConfiguracion->errors());
				}
			} else {
				$builder = $this->db->table('configuracion')->set("valor", $numerVenta)->where('campo', "consecutivoFact");
				if(!$builder->update()) {
					$resp["success"] = false;
				}
			}
		}
		return $resp;
	}

	public function detallePedido($idPedido) {
		$mPedidos = new mPedidos();
		$mPedidosCajas = new mPedidosCajas();
		$mPedidosCajasProductos = new mPedidosCajasProductos();

		$pedido = $mPedidos
			->select("
				pedidos.*,
				TIMEDIFF(pedidos.fin_empaque, pedidos.inicio_empaque) AS TiempoEmpaque
			")
			->find($idPedido);

		$pedido->{'cajas'} = $mPedidosCajas->select("
			pedidoscajas.*,
			TIMEDIFF(pedidoscajas.fin_empaque, pedidoscajas.inicio_empaque) AS TiempoEmpaque,
			U.nombre AS nombreEmpacador
		")->join('usuarios AS U', 'pedidoscajas.id_empacador = U.id', 'left')
		->where("id_pedido", $idPedido)->findAll();

		foreach ($pedido->cajas as $value) {
			$value->{'infoCaja'} = $mPedidosCajasProductos->select("
				COUNT(*) AS Total,
				COUNT(DISTINCT(P.referencia)) AS TotalRef,
				pedidoscajasproductos.id_caja,
				GROUP_CONCAT(DISTINCT(P.referencia) SEPARATOR ' | ') AS referenciasEnCajas
			")->join('productos P', 'pedidoscajasproductos.id_producto = P.id', 'left')
			->where("pedidoscajasproductos.id_caja", $value->id)
			->groupBy("pedidoscajasproductos.id_caja")
			->get()
 			->getRow();
		}

		return $this->response->setJSON($pedido);
	}

	public function detallePedidoCaja($idPedido, $idCaja) {
		$mPedidosCajas = new mPedidosCajas();

		$productos = $mPedidosCajas->select("
			P.referencia,
			P.item,
			P.descripcion
		")->join('pedidoscajasproductos AS PCP', 'pedidoscajas.id = PCP.id_caja', 'left')
		->join('productos AS P', 'PCP.id_producto = P.id', 'left')
		->where("pedidoscajas.id", $idCaja)
		->where("pedidoscajas.id_pedido", $idPedido)->findAll();

		return $this->response->setJSON($productos);
	}

	public function ImportarExcel(){
		$resp["success"] = false;
		$resp["msj"] = "Ha ocurrido un error al leer el archivo de excel.";
		$resp["data"] = [];
		$archivoExcel = $this->request->getFile("excelFile");
		if (!empty($archivoExcel->getBasename())) {
			//Validamos la foto
			$validated = $this->validate([
				'rules' => [
					'uploaded[excelFile]',
					'mime_in[excelFile,application/vnd.ms-excel,xls,csv,application/xml,application/zip,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vn.openxmlformats-officedocument.spreadsheetml.sheet]',
					'max_size[excelFile,50480]',
				],
			]);

			if ($validated) { 
				if ($archivoExcel->isValid() && !$archivoExcel->hasMoved()) {
					$ruta = UPLOADS_PEDIDOS_PATH ."/";
					if (!file_exists($ruta)) {
						mkdir($ruta, 0777, true);
					}

					$name = explode('.', $archivoExcel->getClientName());
					$name = str_replace(' ', '_', $name[0]) . "." . $archivoExcel->getClientExtension();

					if ($archivoExcel->move(UPLOADS_PEDIDOS_PATH, $name, true)) {
						$rutaExcel = UPLOADS_PEDIDOS_PATH . "/". $name;

						/**  Identify the type of $inputFileName  **/
						$inputFileType = IOFactory::identify($rutaExcel);
						/**  Create a new Reader of the type that has been identified  **/
						$reader = IOFactory::createReader($inputFileType);
						/**  Load $inputFileName to a Spreadsheet Object  **/
						$reader->setReadDataOnly(true);
						$spreadsheet = $reader->load($rutaExcel);

						$totalrows = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();
						$hojadeExcel = $spreadsheet->setActiveSheetIndex(0);

						$productosImportar = [];

						$errores = "";
						if ($totalrows > 0) {
							$producto = new mProductos();

							for ($i=2; $i <= $totalrows; $i++) { 
								$fila = new stdClass();

								$referencia = trim($hojadeExcel->getCell("A".$i)->getValue());
								$cantidad = trim($hojadeExcel->getCell("B".$i)->getValue());
								$precio = trim($hojadeExcel->getCell("C".$i)->getValue());

								if (strlen($referencia) > 0 && strlen($cantidad) > 0 && $cantidad > 0) {
									$fila = $producto->detalleProducto($referencia); 
									if (!is_null($fila)) {
										if ($cantidad <= $fila->stock) {
											$fila->cantidad = $cantidad;

											if (strlen($precio) >= 0 && $precio != '' && $precio > 0) {
												$fila->precio_venta = $precio;
												$fila->valorUnitario = $precio;
											}

											$productosImportar[] = $fila;
										} else {
											$errores .= "<li><b>{$referencia}</b> el inventario solicitado es {$cantidad} de {$fila->stock} disponible.</li>";
										}
									} else {
										$errores .= "<li><b>{$referencia}</b> no se encontro en la base de datos.</li>";
									}
								}
							}
						}

						if ($errores == "") {
							if (count($productosImportar) > 0) {
								$resp["success"] = true;
								$resp["data"] = $productosImportar;
							} else {
								$resp["msj"] = "No se han encontrado productos para ser cargados";	
							}
						} else {
							$resp["msj"] = "<ul>{$errores}</ul>";
						}

					} else {
						$resp["msj"] = "Ha ocurrido un error al subir el pedido de excel.";
					}
				} else {
					$resp["msj"] = "Error al subir el excel, {$archivoExcel->getErrorString()}";
				}
			} else {
				$resp["msj"] = "Error al subir el excel, " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
			}
		}
		return $this->response->setJSON($resp);
	}

	public function downloadExcel() {
		return $this->response->download(ASSETS_PATH .  "files/plantillaPedidos.xlsx", null)->setFileName("plantilla.xlsx");
	}

	private function calculateMaturiyInvoice($idSucursal) {
		$mConfiguracion = new mConfiguracion();
		$mSucursalesCliente = new mSucursalesCliente();
		$fechaVencimiento = new \DateTime();
		
		$diasVencimientoSucursal = $mSucursalesCliente->asObject()->find($idSucursal)->dias_vencimiento_factura;

		if (!is_null($diasVencimientoSucursal) && $diasVencimientoSucursal > 0) {
			$fechaVencimiento->modify("+{$diasVencimientoSucursal} days");
		} else {
			$diasVencimientoGeneral = $mConfiguracion->select("valor")->where("campo", "diasVencimientoVenta")->first();
			if (!is_null($diasVencimientoGeneral) && !is_null($diasVencimientoGeneral->valor) && $diasVencimientoGeneral->valor > 0) {
				$fechaVencimiento->modify("+{$diasVencimientoGeneral->valor} days");
			}
		}
		return $fechaVencimiento;
	}

	private function calculateDiscount($valueBill) {
		$mConfiguracion = new mConfiguracion();
		$porcentajeDescuentoGeneral = $mConfiguracion->select("valor")->where("campo", "porcentajeDescuento")->first();
		$totalDiscount = 0;
		if (!is_null($porcentajeDescuentoGeneral) && !is_null($porcentajeDescuentoGeneral->valor) && $porcentajeDescuentoGeneral->valor > 0) {
			$totalDiscount = ($porcentajeDescuentoGeneral->valor * $valueBill) / 100;
		}
		return $totalDiscount;
	}

}
