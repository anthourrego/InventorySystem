<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\mVentas;
use App\Models\mProductos;
use App\Models\mUsuarios;
use App\Models\mClientes;
use App\Models\mVentasProductos;
use App\Models\mConfiguracion;

class cVentas extends BaseController {
	public function index() {
		$this->content['title'] = "Administador Ventas";
		$this->content['view'] = "Ventas/vAdministador";

		$this->LDataTables();
		$this->LMoment();

		$this->content['js_add'][] = [
			'Ventas/jsAdministrador.js'
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

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();

		$mConfiguracion = new mConfiguracion();
		$dataPref = (session()->has("prefijoFact") ? session()->get("prefijoFact") : '');
		$cantDigitos = (session()->has("digitosFact") ? session()->get("digitosFact") : 0);

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoFact")->first();

		$this->content["nroVenta"] = $dataPref . str_pad((is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1)), $cantDigitos, "0", STR_PAD_LEFT);

		$this->content["prefijoValido"] = ($dataPref != '' ? 'S' : 'N');

		$this->content["venta"] = null;

		$this->content["inventario_negativo"] = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');

		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0')
 		];

		$this->content["cantidadVendedores"] = $this->cantidadVendedores();

		$this->content['imagenProd'] = (session()->has("imageProd") ? session()->get("imageProd") : 0);

		$this->content['js_add'][] = [
			'Ventas/jsCrear.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function Editar($id) {
		$ventaModel = new mVentas();
		$mVentasProductos = new mVentasProductos();

		$venta = $ventaModel->cargarVenta($id);

		if (count($venta) != 1) {
			return redirect()->route('Ventas/Administrar');
		}
		$venta = $venta[0];
		
		$productos = $mVentasProductos->select("
				p.id,
				ventasproductos.id AS idProductoVenta,
				p.referencia, 
				p.item, 
				p.descripcion,
				(p.stock + ventasproductos.cantidad) AS stock,
				ventasproductos.cantidad,
				ventasproductos.valor AS valorUnitario,
				ventasproductos.valor_original,
				p.precio_venta,
				(ventasproductos.valor * ventasproductos.cantidad) AS valorTotal
			")->join("productos AS p", "ventasproductos.id_producto = p.id")
			->where("ventasproductos.id_venta", $venta->id)
			->findAll();

		$venta->productos = $productos;
		
		$this->content["venta"] = $venta;
		$this->content["prefijoValido"] = 'S';

		$this->content["nroVenta"] = $venta->codigo;

		$this->content['title'] = "Editar venta Nro " . $venta->codigo;
		$this->content['view'] = "Ventas/vCrear";

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
			'Ventas/jsCrear.js',
			'Ventas/jsEditar.js'
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
				V.impuesto,
				V.neto,
				V.total,
				CASE 
					WHEN V.metodo_pago = 1 THEN 'Contado' 
					ELSE 'Credito'
				END AS metodo_pago,
				V.created_at,
				V.updated_at,
				S.nombre AS NombreSucursal,
				V.id_pedido,
				CUI.nombre AS Ciudad
			")->join('clientes AS C', 'V.id_cliente = C.id', 'left')
			->join('sucursales AS S', 'V.id_sucursal = S.id', 'left')
			->join('ciudades AS CUI', 'S.id_ciudad = CUI.id', 'left')
			->join('usuarios AS U', 'V.id_vendedor = U.id', 'left');

		return DataTable::of($query)->toJson(true);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$contActProd = true;
        
		$this->db->transBegin();

		$mVentasProductos = new mVentasProductos();
		$mProductos = new mProductos();

		$productosVentas = $mVentasProductos->where("id_venta", $data->id)->findAll();

		//Actualizamos el inventario de los productos
		foreach ($productosVentas as $it) {
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
			if($mVentasProductos->where("id_venta", $data->id)->delete()){
				$ventas = new mVentas();
				if ($ventas->delete($data->id)) { 
					$resp["success"] = true;
					$resp['msj'] = "Venta eliminada correctamente";
				} else {
					$resp['msj'] = "Error al eliminar la venta";
				}
			} else {
				$resp['msj'] = "Error al eliminar los productos de la venta.";
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
		$ventaModel = new mVentas();
		$mVentasProductos = new mVentasProductos();
		$mConfiguracion = new mConfiguracion();

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoFact")->first();

		$numerVenta = (is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1));
		$codigo = (session()->has("prefijoFact") ? session()->get("prefijoFact") : '') . $numerVenta;

		if (count($prod) > 0) {
			$this->db->transBegin();

			$dataSave = array(
				"codigo" => $codigo,
				"id_cliente" => $dataPost->idCliente,
				"id_vendedor" => $dataPost->idUsuario,
				"id_sucursal" => $dataPost->sucursal,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($ventaModel->save($dataSave)){
				$dataSave["id"] = $ventaModel->getInsertID();
				foreach ($prod as $it) {
					$dataProductoVenta = [
						"id_venta" => $dataSave["id"],
						"id_producto" => $it->id,
						"cantidad" => $it->cantidad,
						"valor" => $it->valorUnitario,
						"valor_original" => $it->precio_venta
					];

					$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);

					$product = $productoModel->find($it->id);
					$product["stock"] = $product["stock"] - $it->cantidad;

					if (!$mVentasProductos->save($dataProductoVenta)) {
						$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mVentasProductos->errors());
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
				if (is_null($dataConse)) {
					$mConfiguracion = new mConfiguracion();
					$dataSave = [
						"campo" => "consecutivoFact",
						"valor" => $numerVenta
					];
					if(!$mConfiguracion->save($dataSave)) {
						$this->db->transRollback();
						$resp["msj"] = "Ha ocurrido un error al guardar la factura." . listErrors($mConfiguracion->errors());
					} else {
						$this->db->transCommit();
					}
				} else {
					$builder = $this->db->table('configuracion')->set("valor", $numerVenta)->where('campo', "consecutivoFact");
					if($builder->update()) {
						$this->db->transCommit();
					} else {
						$resp["success"] = false;
						$this->db->transRollback();
					}
				}

				$resp["nroPedido"] = (session()->has("prefijoFact") ? session()->get("prefijoFact") : '') . ($numerVenta + 1);
			}

		} else {
			$resp['msj'] = "No se puede generar la venta si no hay productos seleccionados";
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
		$mVentas = new mVentas();
		$mVentasProductos = new mVentasProductos();
		
		if (count($prod) > 0) {
			$this->db->transBegin();
			$dataSave = array(
				"id" => $dataPost->idVenta,
				"id_cliente" => $dataPost->idCliente,
				"id_vendedor" => $dataPost->idUsuario,
				"id_sucursal" => $dataPost->sucursal,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($mVentas->save($dataSave)){
				//Tramos los productos actuales para comparalos con los que ingresan
				$productoActuales = $mVentasProductos->asArray()->where("id_venta", $dataPost->idVenta)->findAll();

				foreach ($prod as $it) {
					$it->idProductoVenta = isset($it->idProductoVenta) ? $it->idProductoVenta : 0;
					$productoAct = array_search($it->idProductoVenta, array_column($productoActuales, 'id'));
					//Si el producto no existe se debe de agregar
					if($productoAct !== false){
						//Validamos si los valores y las cantidades cambian
						if($it->cantidad != $productoActuales[$productoAct]["cantidad"] || $it->valorUnitario != $productoActuales[$productoAct]["valor"]) {
							$cantidadNueva = $productoActuales[$productoAct]["cantidad"] - $it->cantidad;
							
							$dataProductoVenta = [
								"id" => $it->idProductoVenta,
								"cantidad" => $it->cantidad,
								"valor" => $it->valorUnitario,
							];

							if (!$mVentasProductos->save($dataProductoVenta)) {
								$resp["msj"] = "Ha ocurrido un error al actualizar los productos." . listErrors($mVentasProductos->errors());
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
						$dataProductoVenta = [
							"id_venta" => $dataPost->idVenta,
							"id_producto" => $it->id,
							"cantidad" => $it->cantidad,
							"valor" => $it->valorUnitario,
							"valor_original" => $it->precio_venta
						];
	
						$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);
	
						$product = $mProductos->find($it->id);
						$product["stock"] = $product["stock"] - $it->cantidad;
	
						if (!$mVentasProductos->save($dataProductoVenta)) {
							$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($mVentasProductos->errors());
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
					if($mVentasProductos->delete($it["id"])) {

						$product = $mProductos->find($it["id_producto"]);
						$product["stock"] = $product["stock"] + $it["cantidad"];
	
						if(!$mProductos->save($product)){
							$resp["msj"] = "Error al guardar al actualizar el inventario del producto eliminado. " . listErrors($mProductos->errors());
							break;
						}
					} else {
						$resp["msj"] = "Error al guardar al eliminar el producto de la factura. " . listErrors($mVentasProductos->errors());
							break;
					}
				}

				if ($this->db->transStatus() !== false) {
					$resp["success"] = true;
					$dataSave["total"] = $valorTotal;
					$dataSave["neto"] = $valorTotal;

					if ($mVentas->save($dataSave)) {
						$resp["msj"] = $dataSave;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($mVentas->errors());
					}
				}
			} else {
				$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($mVentas->errors());
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
}
