<?php

namespace App\Controllers;

use \Config\Services;
use \Hermawan\DataTables\DataTable;
use App\Models\mConfiguracion;
use App\Models\mProductos;
use App\Models\mCompras;
use App\Models\mCompraProductos;
use App\Models\mVentasProductos;
use App\Models\mPedidosProductos;

class cCompras extends BaseController {

	public function index() {
		$this->content['title'] = "Compras";
		$this->content['view'] = "vCompras";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LSelect2();
		$this->LInputMask();
		
		$this->content['js_add'][] = [
			'jsCompras.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$postData = (object) $this->request->getPost();

		$query = $this->db
				->table('compras AS C')
				->select("
						C.id,
						C.codigo AS Codigo,
						U.nombre AS Nombre_Usuario,
						CP.Total_Productos,
						C.observacion,
						C.neto AS Neto,
						C.total AS Total,
						C.created_at AS Fecha_Creacion,
						C.estado AS Estado,
						CASE
							WHEN C.estado = 'AN'
								THEN 'Anulado'
							WHEN C.estado = 'CO'
								THEN 'Confirmado'
							ELSE 'Pendiente'
						END AS Descripcion_Estado
				")->join('usuarios AS U', 'C.id_usuario = U.id', 'left')
				->join('(
					SELECT
						COUNT(id) AS Total_Productos, id_compra
					FROM comprasproductos
					GROUP BY id_compra
				) AS CP', 'C.id = CP.id_compra', 'left');

		return DataTable::of($query)->toJson(true);
	}

	public function getCurrentBuy($http = 1) {

		$mConfiguracion = new mConfiguracion();

		$cantDigitos = (session()->has("digitosCompra") ? session()->get("digitosCompra") : 0);
		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoCompra")->first();

		$numerVenta = str_pad((is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1)), $cantDigitos, "0", STR_PAD_LEFT);

		$codigo = (session()->has("prefijoCompra") ? session()->get("prefijoCompra") : '') . $numerVenta;

		if ($http == 0) {
			return array(
				"codigo" => $codigo,
				"dataConse" => $dataConse,
				"numerVenta" => $numerVenta
			);
		}
		return $this->response->setJSON(["codigo" => $codigo]);
	}

	public function validarProducto($campo, $nombre) {
		$prod = new mProductos();
		$respuesta = [];

		$producto = $prod->asObject()->where($campo, $nombre)->first();

		if (isset($producto->id)) {
			$respuesta['infoProd'] = $producto;
		} else {
			$respuesta['dataProds'] = $prod->asObject()->like($campo, $nombre)->findAll();
		}
		return $this->response->setJSON($respuesta);
	}

	public function crear() {
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		$valorTotal = 0;
		$dataProdsBuy = json_decode($dataPost->dataProdsBuy);

		$mProductos = new mProductos();
		$mCompras = new mCompras();
		$mCompraProductos = new mCompraProductos();

		$codigo = $this->getCurrentBuy(0);

		if (count($dataProdsBuy) > 0) {
			$this->db->transBegin();

			$dataBuy = array(
				"codigo" => $codigo['codigo'],
				"id_usuario" => session()->get("id_user"),
				"observacion" => $dataPost->observacion,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"estado" => "PE"
			);

			if($mCompras->save($dataBuy)) {
				
				$dataBuy["id"] = $mCompras->getInsertID();

				foreach ($dataProdsBuy as $product) {

					$product->valorCompra = str_replace(",", "", trim(str_replace("$", "", $product->valorCompra)));

					$dataProductoCompra = [
						"id_compra" => $dataBuy["id"],
						"cantidad" => $product->stock,
						"valor" => $product->valorCompra,
						"valor_original" => $product->valorCompra,
						"cantPaca" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($product->pacaX) : 1),
						"costo" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0')
					];

					$respSaveProd = $this->saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra);

					if (is_string($respSaveProd)) {
						$resp["msj"] = $respSaveProd;
						break;
					}

					$valorTotal = $valorTotal + (((double) $product->stock) * ((double) $product->valorCompra));
				}

				if ($this->db->transStatus() !== false) {
					$dataBuy["total"] = $valorTotal;
					$dataBuy["neto"] = $valorTotal;

					if ($mCompras->save($dataBuy)) {
						$resp["success"] = true;
						$resp["msj"] = $dataBuy;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar la compra." . listErrors($mCompras->errors());
					}
				}
			} else{
				$resp["msj"] = "Ha ocurrido un error al guardar la compra." . listErrors($mCompras->errors());
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {

				if (is_null($codigo['dataConse'])) {
					$mConfiguracion = new mConfiguracion();
					$dataSave = [
						"campo" => "consecutivoCompra",
						"valor" => $codigo['numerVenta']
					];
					if(!$mConfiguracion->save($dataSave)) {
						$this->db->transRollback();
						$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($mConfiguracion->errors());
					} else {
						$this->db->transCommit();
					}
				} else {
					$builder = $this->db->table('configuracion')->set("valor", $codigo['numerVenta'])->where('campo', "consecutivoCompra");
					if($builder->update()) {
						$this->db->transCommit();
					} else {
						$resp["success"] = false;
						$this->db->transRollback();
					}
				}
			}
		} else {
			$resp['msj'] = "No se puede generar la compra si no hay productos cargados";
		}
		return $this->response->setJSON($resp);
	}

	public function guardarEditar() {
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();

		$valorTotal = 0;
		$dataProdsBuy = json_decode($dataPost->dataProdsBuy);
        
		$mProductos = new mProductos();
		$mCompras = new mCompras();
		$mCompraProductos = new mCompraProductos();

		if (count($dataProdsBuy) > 0) {
			$this->db->transBegin();

			$dataBuy = array(
				"id" => $dataPost->idCompra,
				"observacion" => $dataPost->observacion
			);

			if ($dataPost->canConfirmBuy == "1") {
				$dataBuy["estado"] = "CO";
			}

			if($mCompras->save($dataBuy)) {
				
				$dataProdsCurrent = $mCompraProductos->asArray()->where("id_compra", $dataBuy["id"])->findAll();

				foreach ($dataProdsBuy as $product) {

					$product->valorCompra = str_replace(",", "", trim(str_replace("$", "", $product->valorCompra)));

					$currentProd = array_search($product->idCompraProd, array_column($dataProdsCurrent, 'id'));

					if ($currentProd !== false) {

						if($product->stock != $dataProdsCurrent[$currentProd]["cantidad"] || $product->valorCompra != $dataProdsCurrent[$currentProd]["valor"]) {
							
							$dataProductoCompra = [
								"id" => $product->idCompraProd,
								"cantidad" => $product->stock,
								"valor" => $product->valorCompra,
							];

							if (!$mVentasProductos->save($dataProductoCompra)) {
								$resp["msj"] = "Ha ocurrido un error al actualizar los productos." . listErrors($mVentasProductos->errors());
								break;
							}
						}

						unset($dataProdsCurrent[$currentProd]);
						$dataProdsCurrent = array_values($dataProdsCurrent);
					} else {

						$dataProductoCompra = [
							"id_compra" => $dataBuy["id"],
							"cantidad" => $product->stock,
							"valor" => $product->valorCompra,
							"valor_original" => $product->valorCompra,
							"creado_compra" => 0,
							"cantPaca" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($product->pacaX) : 1),
							"costo" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0')
						];

						$respSaveProd = $this->saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra);

						if (is_string($respSaveProd)) {
							$resp["msj"] = $respSaveProd;
							break;
						}
					}
					
					$valorTotal = $valorTotal + (((double) $product->stock) * ((double) $product->valorCompra));
				}

				//Eliminamos los productos restantes de la compra
				foreach ($dataProdsCurrent as $prodDelete) {
					
					if($mCompraProductos->delete($prodDelete["id"])) {

						if (isset($prodDelete['creado_compra']) && $prodDelete['creado_compra'] == 1) {

							$hasSales = $this->prodRegisterOrderOrSale($prodDelete['id_producto']);
	
							if ($hasSales == false) {
								$product = $mProductos->where('id', $prodDelete["id_producto"]);
			
								if(!$product->delete()){
									$resp["msj"] = "Error al eliminar el producto. " . listErrors($mProductos->errors());
									break;
								}
							}
						}
					} else {
						$resp["msj"] = "Error al eliminar el producto de la compra. " . listErrors($mVentasProductos->errors());
						break;
					}
				}

				if ($this->db->transStatus() !== false) {
					$dataBuy["total"] = $valorTotal;
					$dataBuy["neto"] = $valorTotal;

					if ($mCompras->save($dataBuy)) {
						$resp["success"] = true;

						$dataBuy['codigo'] = $mCompras->where("id", $dataBuy["id"])->first()->codigo;

						$resp["msj"] = $dataBuy;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar la compra." . listErrors($mCompras->errors());
					}
				}
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {

				if ($dataPost->canConfirmBuy == "1") {

					$responseConfirm = $this->confirmBuy($dataPost->idCompra);

					if (is_string($responseConfirm)) {
						$resp["success"] = false;
						$resp["msj"] = $responseConfirm;
						$this->db->transRollback();
					} else {
						$this->db->transCommit();
					}
				} else {
					$this->db->transCommit();
				}
			}
		} else {
			$resp['msj'] = "No se puede modificar la compra si no hay productos cargados";
		}
		return $this->response->setJSON($resp);
	}

	public function getBuy($idBuy, $http = 1) {

		$mCompras = new mCompras();
		$mCompraProductos = new mCompraProductos();

		$dataBuy = $mCompras->cargarCompra($idBuy);

		$dataProdsBuy = $mCompraProductos->select("
				CONCAT(P.referencia, ' | ', P.item) AS referenciaItem,
				P.descripcion,
				P.cantPaca AS pacaX,
				comprasproductos.cantidad AS stock,
				comprasproductos.valor_original AS precioVenta,
				comprasproductos.costo,
				P.referencia,
				P.item,
				comprasproductos.valor_original AS valorCompra,
				P.costo AS costoCompra,
				P.id AS idProducto,
				comprasproductos.creado_compra AS creadoCompra,
				comprasproductos.id AS idCompraProd
			")->join("productos AS P", "comprasproductos.id_producto = P.id", "left")
			->where("comprasproductos.id_compra", $idBuy)
			->findAll();

		foreach ($dataProdsBuy as $key => $value) {	
			$dataProdsBuy[$key]->id = $dataProdsBuy[$key]->referencia . $key;
		}

		$informationBuy = array(
			"compra" => $dataBuy[0]
			, "productos" => $dataProdsBuy
		);
		
		if ($http == 1) {
			return $this->response->setJSON($informationBuy);
		} else {
			return $informationBuy;
		}
	}

	public function anular(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();

		$mCompras = new mCompras();

		$dataBuy = array(
			"id" => $data->idCompra,
			"estado" => "AN"
		);

		if($mCompras->save($dataBuy)) {
			$resp["success"] = true;
			$resp['msj'] = "Compra anulada correctamente";
		} else {
			$resp['msj'] = "Error al anular la compra";
		}

		return $this->response->setJSON($resp);
	}

	private function confirmBuy($idBuy) {
		$mCompraProductos = new mCompraProductos();

		$dataProdsBuy = $mCompraProductos->asObject()->where('id_compra', $idBuy)->findAll();
        
		$mProductos = new mProductos();

		$response = true;

		foreach ($dataProdsBuy as $product) {

			$productSaved = $mProductos->find($product->id_producto);
			
			$productSaved["stock"] = $productSaved["stock"] + $product->cantidad;
			$productSaved["precio_venta"] = $product->valor;
			$productSaved["costo"] = (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? $product->costo : '0');
			$productSaved["cantPaca"] = (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? $product->cantPaca : 1);

			if(!$mProductos->save($productSaved)){
				$response = "Error al inventario del producto. " . listErrors($mProductos->errors());
				break;
			}
		}

		return $response;
	}

	private function prodRegisterOrderOrSale($idProducto) {
		$mVentasProductos = new mVentasProductos();

		$amountSale = $mVentasProductos->where("id_producto", $idProducto)->countAllResults();

		if ($amountSale > 0) return true;

		$mPedidosProductos = new mPedidosProductos();

		$amountSale = $mPedidosProductos->where("id_producto", $idProducto)->countAllResults();

		if ($amountSale > 0) return true;

		return false;
	}

	private function saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra) {
		if ((int) $product->idProducto <= 0) {
			/* Se crean con valores iniciales para que al momento de confirmar la compra se pueda actualizar el inventario como debe ser */
			$dataNewProducto = array(
				"referencia" => trim($product->referencia)
				, "item" => (session()->has("itemProducto") && session()->get("itemProducto") == '1' ? trim($product->item) : null)
				, "descripcion" => trim($product->descripcion)
				, "stock" => 0
				, "precio_venta" => 0
				, "costo" => '0'
				, "cantPaca" => 1
				/* , "stock" => $product->stock
				, "precio_venta" => $product->valorCompra
				, "costo" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0')
				, "cantPaca" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($product->pacaX) : 1) */
			);

			if($mProductos->save($dataNewProducto)) {
				
				$dataProductoCompra['id_producto'] = $mProductos->getInsertID();
				$dataProductoCompra['creado_compra'] = 1;

			} else {
				return "Ha ocurrido un error al crear el producto." . listErrors($mProductos->errors());
			}

		} else {
			$dataProductoCompra['id_producto'] = $product->idProducto;
		}

		if (!$mCompraProductos->save($dataProductoCompra)) {
			return "Ha ocurrido un error al guardar los productos." . listErrors($mCompraProductos->errors());
		}
		return true;
	}

	public function clonar() {
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		
		$informationBuy = $this->getBuy($dataPost->idBuy, 0);

		$dataProdsBuy = $informationBuy['productos'];

		$mCompras = new mCompras();
		$mCompraProductos = new mCompraProductos();

		$codigo = $this->getCurrentBuy(0);

		if (count($dataProdsBuy) > 0) {
			$this->db->transBegin();

			$dataBuy = array(
				"codigo" => $codigo['codigo'],
				"id_usuario" => session()->get("id_user"),
				"observacion" => $informationBuy['compra']->observacion,
				"impuesto" => $informationBuy['compra']->impuesto,
				"neto" => $informationBuy['compra']->neto,
				"total" => $informationBuy['compra']->total,
				"estado" => "PE"
			);

			if($mCompras->save($dataBuy)) {
				
				$dataBuy["id"] = $mCompras->getInsertID();

				foreach ($dataProdsBuy as $product) {

					$product = (object) $product;

					$dataProductoCompra = [
						"id_compra" => $dataBuy["id"],
						"cantidad" => $product->stock,
						"id_producto" => $product->idProducto,
						"valor" => $product->valorCompra,
						"valor_original" => $product->valorCompra,
						"cantPaca" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($product->pacaX) : 1),
						"costo" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0'),
						"creado_compra" => 0
					];

					if (!$mCompraProductos->save($dataProductoCompra)) {
						return "Ha ocurrido un error al guardar los productos." . listErrors($mCompraProductos->errors());
					}
				}

				if ($this->db->transStatus() !== false) {
					$resp["success"] = true;
					$resp["msj"] = $dataBuy;
				} else {
					$resp["msj"] = "Ha ocurrido un error al clonar la compra." . listErrors($mCompras->errors());
				}
			} else{
				$resp["msj"] = "Ha ocurrido un error al clonar la compra." . listErrors($mCompras->errors());
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {
				$builder = $this->db->table('configuracion')->set("valor", $codigo['numerVenta'])->where('campo', "consecutivoCompra");
				if($builder->update()) {
					$this->db->transCommit();
				} else {
					$resp["success"] = false;
					$this->db->transRollback();
				}
			}
		} else {
			$resp['msj'] = "No se puede generar la compra si no hay productos cargados";
		}
		return $this->response->setJSON($resp);
	}

}
