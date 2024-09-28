<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Entities\MovimientoInventarioEntity;
use App\Models\mCategorias;
use App\Models\mCompraProductos;
use App\Models\mCompras;
use App\Models\mConfiguracion;
use App\Models\MovimientoInventarioModel;
use App\Models\mPedidosProductos;
use App\Models\mProductos;
use App\Models\mVentasProductos;

class cCompras extends BaseController {

	private $messageError = "Ha ocurrido un error al guardar la compra.";

	public function index() {
		$this->content['title'] = "Compras";
		$this->content['view'] = "vCompras";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LSelect2();
		$this->LInputMask();

		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0'),
			"ubicacion" => (session()->has("ubicacionProducto") ? session()->get("ubicacionProducto") : '0'),
			"costo" => (session()->has("costoProducto") ? session()->get("costoProducto") : '0'),
			// "manifiesto" => (session()->has("manifiestoProducto") ? session()->get("manifiestoProducto") : '0'),
			"paca" => (session()->has("pacaProducto") ? session()->get("pacaProducto") : '0')
 		];

		$categorias = new mCategorias();
		$this->content["categorias"] = $categorias->asObject()->where("estado", 1)->findAll();
		
		$this->content['js_add'][] = [
			'jsCompras.js'
		];

		$this->content['css_add'][] = [
			'cssCompras.css'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$query = $this->db->table("compras AS C")
				->select("
						C.id,
						C.codigo AS Codigo,
						U.nombre AS Nombre_Usuario,
						CP.Total_Productos,
						CP.Total_Costo,
						0 AS Ganancia,
						C.observacion,
						C.neto AS Neto,
						C.total AS Total,
						C.created_at AS Fecha_Creacion,
						C.estado AS Estado,
						C.id_proveedor,
						P.nombre AS Proveedor,
						CASE
							WHEN C.estado = 'AN'
								THEN 'Anulado'
							WHEN C.estado = 'CO'
								THEN 'Confirmado'
							ELSE 'Pendiente'
						END AS Descripcion_Estado
				")->join("usuarios AS U", "C.id_usuario = U.id", "left")
				->join("proveedores AS P", "C.id_proveedor = P.id", "left")
				->join("(
					SELECT
						COUNT(id) AS Total_Productos, SUM(costo) AS Total_Costo, id_compra
					FROM comprasproductos
					GROUP BY id_compra
				) AS CP", "C.id = CP.id_compra", "left");

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
				"id_proveedor" => (isset($dataPost->id_proveedor) && $dataPost->id_proveedor ? $dataPost->id_proveedor : null),
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"estado" => "PE"
			);

			if($mCompras->save($dataBuy)) {
				
				$dataBuy["id"] = $mCompras->getInsertID();

				foreach ($dataProdsBuy as $product) {

					$product->precioVenta = str_replace(",", "", trim(str_replace("$", "", $product->precioVenta)));

					$valorOriginal = $product->valorOriginal;
					if ($product->creadoCompra == 1) {
						$valorOriginal = number_format((float) $product->valorOriginal, 0, '.');
					}

					$dataProductoCompra = [
						"id_compra" => $dataBuy["id"],
						"cantidad" => $product->stock,
						"valor" => $product->precioVenta,
						"valor_original" => $valorOriginal,
						"creado_compra" => $product->creadoCompra,
						"cantPaca" => (
							session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? trim($product->pacaX) : 1
						),
						"costo" => (
							session()->has("costoProducto") && session()->get("costoProducto") == '1'
								? str_replace(",", "", trim(str_replace("$", "", $product->costo)))
								: '0'
						),
						'ubicacion' => $product->ubicacion,
						'id_categoria' => $product->idCategoria,
						'id_manifiesto' => $product->idManifiesto
					];

					$respSaveProd = $this->saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra);

					if (is_string($respSaveProd)) {
						$resp["msj"] = $respSaveProd;
						$resp["errorProd"] = true;
						break;
					}

					$valorTotal = $valorTotal + (((double) $product->stock) * ((double) $product->precioVenta));
				}

				if (!isset($resp["errorProd"]) && $this->db->transStatus() !== false) {
					$dataBuy["total"] = $valorTotal;
					$dataBuy["neto"] = $valorTotal;

					if ($mCompras->save($dataBuy)) {
						$resp["success"] = true;
						$resp["msj"] = $dataBuy;
					} else {
						$resp["msj"] = $this->messageError . listErrors($mCompras->errors());
					}
				}
			} else{
				$resp["msj"] = $this->messageError . listErrors($mCompras->errors());
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
					$builder = $this->db->table('configuracion')
						->set("valor", $codigo['numerVenta'])
						->where('campo', "consecutivoCompra");
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
				"observacion" => $dataPost->observacion,
				"id_proveedor" => (isset($dataPost->id_proveedor) && $dataPost->id_proveedor ? $dataPost->id_proveedor : null)
			);

			if ($dataPost->canConfirmBuy == "1") {
				$dataBuy["estado"] = "CO";
			}

			if($mCompras->save($dataBuy)) {

				$dataConf = $this->getParamsConfig();

				$dataProdsCurrent = $mCompraProductos->asArray()->where("id_compra", $dataBuy["id"])->findAll();

				foreach ($dataProdsBuy as $product) {

					$product->precioVenta = str_replace(",", "", trim(str_replace("$", "", $product->precioVenta)));

					$currentProd = array_search($product->idCompraProd, array_column($dataProdsCurrent, 'id'));

					if ($currentProd !== false) {

						$dataProductoCompra = [
							"id" => $product->idCompraProd
						];

						if($product->stock != $dataProdsCurrent[$currentProd]["cantidad"]) {
							$dataProductoCompra["cantidad"] = $product->stock;
						}

						if($product->precioVenta != $dataProdsCurrent[$currentProd]["valor"]) {
							$dataProductoCompra["valor"] = $product->precioVenta;
						}

						if($product->pacaX != $dataProdsCurrent[$currentProd]["cantPaca"]) {
							$dataProductoCompra["cantPaca"] = ($dataConf["canPacaProd"] ? trim($product->pacaX) : 1);
						}

						if($product->costo != $dataProdsCurrent[$currentProd]["costo"]) {
							$costo = ($dataConf["canCostoProd"] ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0');
							$dataProductoCompra["costo"] = $costo;
						}

						if($product->ubicacion != $dataProdsCurrent[$currentProd]["ubicacion"]) {
							$dataProductoCompra["ubicacion"] = $product->ubicacion;
						}

						if($product->idCategoria != $dataProdsCurrent[$currentProd]["id_categoria"]) {
							$dataProductoCompra["id_categoria"] = $product->idCategoria;
						}

						if($product->idManifiesto != $dataProdsCurrent[$currentProd]["id_manifiesto"]) {
							$dataProductoCompra["id_manifiesto"] = $product->idManifiesto;
						}

						if (count($dataProductoCompra) > 1) {
							if (!$mCompraProductos->save($dataProductoCompra)) {
								$resp["msj"] = "Ha ocurrido un error al actualizar los productos." . listErrors($mCompraProductos->errors());
								break;
							}
						}

						$isValidUpdate = $this->validateDataProd($product->idProducto, $product);
						if (is_string($isValidUpdate)) {
							$resp["msj"] = $isValidUpdate;
							break;
						}

						unset($dataProdsCurrent[$currentProd]);
						$dataProdsCurrent = array_values($dataProdsCurrent);
					} else {

						$valorOriginal = $product->valorOriginal;
						if ($product->creadoCompra == 1) {
							$valorOriginal = number_format((float) $product->valorOriginal, 0, '.');
						}

						$dataProductoCompra = [
							"id_compra" => $dataBuy["id"],
							"cantidad" => $product->stock,
							"valor" => $product->precioVenta,
							"valor_original" => $valorOriginal,
							"creado_compra" => $product->creadoCompra,
							"cantPaca" => ($dataConf["canPacaProd"] ? trim($product->pacaX) : 1),
							"costo" => ($dataConf["canCostoProd"] ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0'),
							'ubicacion' => $product->ubicacion,
							'id_categoria' => $product->idCategoria,
							'id_manifiesto' => $product->idManifiesto
						];

						$respSaveProd = $this->saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra);

						if (is_string($respSaveProd)) {
							$resp["msj"] = $respSaveProd;
							$resp["isSavedProd"] = false;
							break;
						}
					}
					
					$valorTotal = $valorTotal + (((double) $product->stock) * ((double) $product->precioVenta));
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
						$resp["msj"] = "Error al eliminar el producto de la compra. " . listErrors($mCompraProductos->errors());
						break;
					}
				}

				if (!isset($resp["isSavedProd"]) && $this->db->transStatus() !== false) {
					$dataBuy["total"] = $valorTotal;
					$dataBuy["neto"] = $valorTotal;

					if ($mCompras->save($dataBuy)) {
						$resp["success"] = true;

						$dataBuy['codigo'] = $mCompras->where("id", $dataBuy["id"])->first()->codigo;

						$resp["msj"] = $dataBuy;
					} else {
						$resp["msj"] = $this->messageError . listErrors($mCompras->errors());
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
				CONCAT(UPPER(P.referencia), ' | ', IF(P.item IS NULL, '', P.item)) AS referenciaItem,
				P.descripcion,
				comprasproductos.cantPaca AS pacaX,
				comprasproductos.cantidad AS stock,
				comprasproductos.valor AS precioVenta,
				comprasproductos.costo,
				P.referencia,
				P.item,
				comprasproductos.valor_original AS valorOriginal,
				P.costo AS costoCompra,
				P.id AS idProducto,
				comprasproductos.creado_compra AS creadoCompra,
				comprasproductos.id AS idCompraProd,
				comprasproductos.ubicacion,
				C.nombre AS categoriaNombre,
				comprasproductos.id_categoria AS idCategoria,
				comprasproductos.id_manifiesto AS idManifiesto,
				M.nombre AS manifiestoNombre,
				0 AS ganancia
			")->join("productos AS P", "comprasproductos.id_producto = P.id", "left")
			->join("categorias AS C", "comprasproductos.id_categoria = C.id", "left")
			->join("manifiestos AS M", "comprasproductos.id_manifiesto = M.id", "left")
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
		$resp["success"] = true;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();

		$mCompras = new mCompras();

		$dataBuy = array(
			"id" => $data->idCompra,
			"estado" => "AN"
		);
		$this->db->transBegin();

		if($mCompras->save($dataBuy)) {
			$movimientoInventarioModel = new MovimientoInventarioModel();
			$movimiento = new MovimientoInventarioEntity();
			$mCompraProductos = new mCompraProductos();

			$dataProdsBuy = $mCompraProductos->asObject()->where('id_compra', $data->idCompra)->findAll();
			$codigoCompra = $mCompras->asObject()->find($data->idCompra)->codigo;

			foreach ($dataProdsBuy as $product) {
				$responseConfirm = $this->updateInventoryProduct($movimientoInventarioModel, $movimiento, $product->cantidad, $product->id_producto, $codigoCompra, $data->idCompra, "S");
				if (is_string($responseConfirm)) {
					$resp['msj'] = $responseConfirm;
					$resp["success"] = false;
					break;
				}
			}
		} else {
			$resp["success"] = false;
			$resp['msj'] = "Error al anular la compra";
		}

		if ($resp["success"]) {
			$this->db->transCommit();
			$resp['msj'] = "Compra anulada correctamente";
		} else {
			$this->db->transRollback();
		}

		return $this->response->setJSON($resp);
	}

	private function confirmBuy($idBuy) {
		$mCompraProductos = new mCompraProductos();
		$movimientoInventarioModel = new MovimientoInventarioModel();
		$movimiento = new MovimientoInventarioEntity();
		$mCompras = new mCompras();
		$mProductos = new mProductos();

		$dataProdsBuy = $mCompraProductos->asObject()->where('id_compra', $idBuy)->findAll();
        $codigoCompra = $mCompras->asObject()->find($idBuy)->codigo;

		$response = true;
		$dataConf = $this->getParamsConfig();

		foreach ($dataProdsBuy as $product) {

			$productSaved = $mProductos->find($product->id_producto);

			$isValidProd = $this->checkDataProduct($product, $productSaved);
			if(is_string($isValidProd)) {
				$response = $isValidProd;
				break;
			}

			$currentStock = $productSaved["stock"];
			
			// $productSaved["stock"] = $productSaved["stock"] + $product->cantidad;
			$productSaved["precio_venta"] = $product->valor;
			$productSaved["costo"] = ($dataConf["canPacaProd"] ? $product->costo : '0');
			$productSaved["cantPaca"] = ($dataConf["canPacaProd"] ? $product->cantPaca : 1);

			if ($currentStock <= 0) {
				$productSaved["ubicacion"] = $product->ubicacion;
			} else {
				$ubicacionNew = '';
				if (strlen(trim($product->ubicacion)) > 0 && !str_contains($productSaved["ubicacion"], $product->ubicacion)) {
					$ubicacionNew = ' - ' . $product->ubicacion;
				}
				$productSaved["ubicacion"] = $productSaved["ubicacion"] . $ubicacionNew;
			}

			$productSaved["id_categoria"] = $product->id_categoria;
			
			if ($product->creado_compra == 1) {
				$productSaved['estado'] = 1;
				$productSaved["id_manifiesto"] = $product->id_manifiesto;
			} else {
				$productSaved["id_manifiesto"] = null;
			}

			if(!$mProductos->save($productSaved)){
				$response = "Error al inventario del producto. " . listErrors($mProductos->errors());
				break;
			}

			$responseConfirm = $this->updateInventoryProduct($movimientoInventarioModel, $movimiento, $product->cantidad, $product->id_producto, $codigoCompra, $idBuy);
			if (is_string($responseConfirm)) {
				$response = $responseConfirm;
				break;
			}
		}
		return $response;
	}

	private function updateInventoryProduct($movimientoInventarioModel, $movimiento, $newStock, $idProduct, $codigo, $idCompra, $tipo = "I") {
		$response = true;
		$movimiento->id_producto = $idProduct;
		$movimiento->tipo = $tipo;
		$movimiento->id_compra = $idCompra;
		$movimiento->cantidad = $newStock;
		$movimiento->observacion = ($tipo === "I" ? "Confirma" : "Anula") . " compra con código " . $codigo;
		if(!$movimientoInventarioModel->save($movimiento)) {
			return "Error al registrar el movimiento. " . listErrors($movimientoInventarioModel->errors());
		}
		if($movimientoInventarioModel->errorAfterInsert){
			return $movimientoInventarioModel->errorAfterInsertMsg;
		}
		return $response;
	}

	private function prodRegisterOrderOrSale($idProducto) {
		$mVentasProductos = new mVentasProductos();

		$amountSale = $mVentasProductos->where("id_producto", $idProducto)->countAllResults();

		if ($amountSale > 0) { return true; }

		$mPedidosProductos = new mPedidosProductos();

		$amountSale = $mPedidosProductos->where("id_producto", $idProducto)->countAllResults();

		if ($amountSale > 0) { return true; }

		return false;
	}

	private function saveProdBuy($product, $mProductos, $mCompraProductos, $dataProductoCompra) {
		if ((int) $product->idProducto <= 0) {
			/* Se crean con valores iniciales para que al momento de confirmar
			la compra se pueda actualizar el inventario como debe ser */
			$dataNewProducto = array(
				"referencia" => trim($product->referencia)
				, "item" => (session()->has("itemProducto") && session()->get("itemProducto") == '1' ? trim($product->item) : null)
				, "descripcion" => trim($product->descripcion)
				, "stock" => 0
				, "precio_venta" => 0
				, "precio_venta_dos" => 0
				, "costo" => '0'
				, "cantPaca" => 1
				, "estado" => 0
				/* , "stock" => $product->stock
				, "precio_venta" => $product->precioVenta
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

			$isValidUpdate = $this->validateDataProd($product->idProducto, $product);
			if (is_string($isValidUpdate)) {
				return $isValidUpdate;
			}
		}

		if (!$mCompraProductos->save($dataProductoCompra)) {
			return "Ha ocurrido un error al guardar los productos. " . listErrors($mCompraProductos->errors());
		}
		return true;
	}

	private function validateDataProd($idProducto, $product) {
		$mProductosFind = new mProductos();

		$productoFind = $mProductosFind->asObject()->find($idProducto);

		if ($productoFind->descripcion != $product->descripcion) {
			$dataUpdateProducto = array(
				"id" => $idProducto
				, "descripcion" => trim($product->descripcion)
			);

			if(!$mProductosFind->save($dataUpdateProducto)) {
				return "Ha ocurrido un error al actualizar el producto." . listErrors($mProductosFind->errors());
			}
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
				"id_proveedor" => $informationBuy['compra']->id_proveedor,
				"impuesto" => $informationBuy['compra']->impuesto,
				"neto" => $informationBuy['compra']->neto,
				"total" => $informationBuy['compra']->total,
				"estado" => "PE"
			);

			if($mCompras->save($dataBuy)) {
				
				$dataBuy["id"] = $mCompras->getInsertID();

				$dataConf = $this->getParamsConfig();

				foreach ($dataProdsBuy as $product) {

					$product = (object) $product;

					$dataProductoCompra = [
						"id_compra" => $dataBuy["id"],
						"cantidad" => $product->stock,
						"id_producto" => $product->idProducto,
						"valor" => $product->precioVenta,
						"valor_original" => $product->valorOriginal,
						"cantPaca" => ($dataConf["canPacaProd"] ? trim($product->pacaX) : 1),
						"costo" => ($dataConf["canCostoProd"] ? str_replace(",", "", trim(str_replace("$", "", $product->costo))) : '0'),
						"creado_compra" => 0,
						'ubicacion' => $product->ubicacion,
						'id_categoria' => $product->idCategoria,
						'id_manifiesto' => $product->idManifiesto
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
				$builder = $this->db->table('configuracion')
					->set("valor", $codigo['numerVenta'])
					->where('campo', "consecutivoCompra");
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

	public function checkDataProduct($product, $productSaved) {
		$productConverted = (object) $product;
		
		$titleProd = "El producto ";
		$manejaUbicacion = (session()->has("ubicacionProducto") ? session()->get("ubicacionProducto") : '0');
		$isValidUbicacion = (!isset($productConverted->ubicacion) || strlen(trim($productConverted->ubicacion)) == 0);
		if($manejaUbicacion == '1' && $isValidUbicacion) {
			return $titleProd . $productSaved["referencia"] . " no cuenta con ubicación registrada.";
		}
		if(!isset($productConverted->id_categoria) || $productConverted->id_categoria <= 0){
			return $titleProd . $productSaved["referencia"] . " no cuenta con categoria registrada.";
		}

		$manejaCosto = (session()->has("costoProducto") ? session()->get("costoProducto") : '0');
		$arrayTypeNumbers = array(0 => "valor", 1 => "costo");
		foreach ($arrayTypeNumbers as $pos => $keyTwo) {
			if ($pos == 1 && $manejaCosto != '1') {
				continue;
			}
			if(!isset($productConverted->{$keyTwo}) || $productConverted->{$keyTwo} == 0){
				return $titleProd . $productSaved["referencia"] . " no cuenta con " . $keyTwo . " registrado.";
			}
		}
		return true;
	}

	private function getParamsConfig() {
		return [
			"canPacaProd" => (session()->has("pacaProducto") && session()->get("pacaProducto") == '1' ? true : false)
			, "canCostoProd" => (session()->has("costoProducto") && session()->get("costoProducto") == '1' ? true : false)
		];
	}

}
