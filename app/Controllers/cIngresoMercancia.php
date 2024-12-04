<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Entities\MovimientoInventarioEntity;
use App\Models\mConfiguracion;
use App\Models\mIngresoMercancia;
use App\Models\mIngresoMercanciaProductos;
use App\Models\MovimientoInventarioModel;
use App\Models\mProductos;

class cIngresoMercancia extends BaseController {

	private $messageError = "Ha ocurrido un error al guardar el ingreso.";

	public function index() {
		$this->content['title'] = "Ingreso mercancía";
		$this->content['view'] = "vIngresoMercancia";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();

		$this->content["camposProducto"] = [
			"item" => (session()->has("itemProducto") ? session()->get("itemProducto") : '0')
 		];
		
		$this->content['js_add'][] = [
			'jsIngresoMercancia.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$query = $this->db->table("ingresomercancia AS IM")
				->select("
						IM.id,
						IM.codigo AS Codigo,
						U.nombre AS Nombre_Usuario,
						IMP.Total_Productos,
						IM.observacion,
						IM.created_at AS Fecha_Creacion,
						IM.estado AS Estado,
						CASE
							WHEN IM.estado = 'AN'
								THEN 'Anulado'
							WHEN IM.estado = 'CO'
								THEN 'Confirmado'
							ELSE 'Pendiente'
						END AS Descripcion_Estado
				")->join("usuarios AS U", "IM.id_usuario = U.id", "left")
				->join("(
					SELECT
						COUNT(id) AS Total_Productos, id_ingresomercancia
					FROM ingresomercanciaproductos
					GROUP BY id_ingresomercancia
				) AS IMP", "IM.id = IMP.id_ingresomercancia", "left");

		return DataTable::of($query)->toJson(true);
	}

	public function getCurrentEntry($http = 1) {

		$mConfiguracion = new mConfiguracion();

		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoIngresoMercancia")->first();

		$codigo = (is_null($dataConse) ? 1 : ((int) $dataConse->valor) + 1);

		if ($http == 0) {
			if (is_null($dataConse)) {
				$dataSave = [
					"campo" => "consecutivoIngresoMercancia",
					"valor" => 0
				];
				$mConfiguracion->save($dataSave);
			}
			return array(
				"codigo" => $codigo,
				"dataConse" => $dataConse
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
		$resp["success"] = true;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		$dataProdsEntry = json_decode($dataPost->dataProdsEntry);

		$mIngresoMercancia = new mIngresoMercancia();
		$mIngresoMercanciaProductos = new mIngresoMercanciaProductos();

		$codigo = $this->getCurrentEntry(0);

		if (count($dataProdsEntry) > 0) {
			$this->db->transBegin();

			$dataEntry = array(
				"codigo" => $codigo['codigo'],
				"id_usuario" => session()->get("id_user"),
				"observacion" => $dataPost->observacion,
				"estado" => "PE"
			);

			if($mIngresoMercancia->save($dataEntry)) {
				
				$dataEntry["id"] = $mIngresoMercancia->getInsertID();

				foreach ($dataProdsEntry as $product) {
					$respSaveProd = $this->saveProdEntry($product, $mIngresoMercanciaProductos, $dataEntry["id"]);
					if (is_string($respSaveProd)) {
						$resp["msj"] = $respSaveProd;
						$resp["success"] = false;
						break;
					}
				}
			} else{
				$resp["msj"] = $this->messageError . listErrors($mIngresoMercancia->errors());
				$resp["success"] = false;
			}

			if(!$resp["success"] || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {
				$builder = $this->db->table('configuracion')
					->set("valor", $codigo['codigo'])
					->where('campo', "consecutivoIngresoMercancia");
				if($builder->update()) {
					$resp["msj"] = $dataEntry;
					$this->db->transCommit();
				} else {
					$resp["success"] = false;
					$this->db->transRollback();
				}
			}
		} else {
			$resp['msj'] = "No se puede generar el ingreso si no hay productos cargados";
			$resp["success"] = false;
		}
		return $this->response->setJSON($resp);
	}

	public function guardarEditar() {
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();

		$dataProdsEntry = json_decode($dataPost->dataProdsEntry);
        
		$mIngresoMercancia = new mIngresoMercancia();
		$mIngresoMercanciaProductos = new mIngresoMercanciaProductos();

		if (count($dataProdsEntry) > 0) {
			$this->db->transBegin();

			$dataEntry = array(
				"id" => $dataPost->idIngresoMercancia,
				"observacion" => $dataPost->observacion
			);

			if ($dataPost->canConfirmEntry == "1") {
				$dataEntry["estado"] = "CO";
			}

			if($mIngresoMercancia->save($dataEntry)) {

				$dataProdsCurrent = $mIngresoMercanciaProductos->asArray()->where("id_ingresomercancia", $dataEntry["id"])->findAll();

				foreach ($dataProdsEntry as $product) {

					$currentProd = array_search($product->idIngresoMercanciaProd, array_column($dataProdsCurrent, 'id'));

					if ($currentProd !== false) {

						$dataProductoIngreso = [
							"id" => $product->idIngresoMercanciaProd
						];

						if($product->cantidad != $dataProdsCurrent[$currentProd]["cantidad"]) {
							$dataProductoIngreso["cantidad"] = $product->cantidad;
						}

						if (count($dataProductoIngreso) > 1 && !$mIngresoMercanciaProductos->save($dataProductoIngreso)) {
							$resp["msj"] = "Ha ocurrido un error al actualizar los productos." . listErrors($mIngresoMercanciaProductos->errors());
							break;
						}

						unset($dataProdsCurrent[$currentProd]);
						$dataProdsCurrent = array_values($dataProdsCurrent);
					} else {
						$respSaveProd = $this->saveProdEntry($product, $mIngresoMercanciaProductos, $dataEntry["id"]);
						if (is_string($respSaveProd)) {
							$resp["msj"] = $respSaveProd;
							$resp["isSavedProd"] = false;
							break;
						}
					}
				}

				//Eliminamos los productos restantes del ingreso
				foreach ($dataProdsCurrent as $prodDelete) {
					if(!$mIngresoMercanciaProductos->delete($prodDelete["id"])) {
						$resp["msj"] = "Error al eliminar el producto del ingreso. " . listErrors($mIngresoMercanciaProductos->errors());
						$resp["isSavedProd"] = false;
						break;
					}
				}

				if (!isset($resp["isSavedProd"]) && $this->db->transStatus() !== false) {
					$dataEntry['codigo'] = $mIngresoMercancia->where("id", $dataEntry["id"])->first()->codigo;
					$resp["success"] = true;
					$resp["msj"] = $dataEntry;
				}
			}

			if(!$resp["success"] || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {
				if ($dataPost->canConfirmEntry == "1") {
					$codigo = $mIngresoMercancia->where("id", $dataEntry["id"])->first()->codigo;
					$responseConfirm = $this->updateInventoryEntry($dataPost->idIngresoMercancia, "I", $codigo);
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
			$resp['msj'] = "No se puede modificar el ingreso si no hay productos cargados";
		}
		return $this->response->setJSON($resp);
	}

	public function getEntry($idEntry) {
		$mIngresoMercancia = new mIngresoMercancia();
		$mIngresoMercanciaProductos = new mIngresoMercanciaProductos();

		$dataEntry = $mIngresoMercancia->cargarIngreso($idEntry);

		$dataProdsEntry = $mIngresoMercanciaProductos->select("
				CONCAT(UPPER(P.referencia), ' | ', IF(P.item IS NULL, '', P.item)) AS referenciaItem,
				P.descripcion,
				ingresomercanciaproductos.cantidad,
				P.referencia,
				P.item,
				P.stock,
				P.id AS idProducto,
				ingresomercanciaproductos.id AS idIngresoMercanciaProd
			")->join("productos AS P", "ingresomercanciaproductos.id_producto = P.id", "left")
			->where("ingresomercanciaproductos.id_ingresomercancia", $idEntry)
			->findAll();


		foreach ($dataProdsEntry as $key => $value) {
			$dataProdsEntry[$key]->id = $dataProdsEntry[$key]->referencia . $key;
		}

		$informationEntry = array(
			"ingreso" => $dataEntry[0]
			, "productos" => $dataProdsEntry
		);
		return $this->response->setJSON($informationEntry);
	}

	public function anular(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
		$this->db->transBegin();
		$mIngresoMercancia = new mIngresoMercancia();

		$dataEntry = array(
			"id" => $data->idIngresoMercancia,
			"estado" => "AN"
		);

		if($mIngresoMercancia->save($dataEntry)) {
			$dataIngreso = $mIngresoMercancia->find($data->idIngresoMercancia);
			$responseConfirm = $this->updateInventoryEntry($data->idIngresoMercancia, "S", $dataIngreso->codigo);
			if (is_string($responseConfirm)) {
				$this->db->transRollback();
				$resp["msj"] = $responseConfirm;
			} else {
				$this->db->transCommit();
				$resp["success"] = true;
				$resp['msj'] = "Ingreso anulado correctamente";
			}
		} else {
			$resp['msj'] = "Error al anular el ingreso";
		}

		return $this->response->setJSON($resp);
	}

	/* Execute from confirm entry o cancel entry */
	private function updateInventoryEntry($idEntry, $type, $codigo = null) {
		$movimientoInventarioModel = new MovimientoInventarioModel();
		$movimiento = new MovimientoInventarioEntity();
		$mIngresoMercanciaProductos = new mIngresoMercanciaProductos();
		$dataProdsEntry = $mIngresoMercanciaProductos->asObject()->where('id_ingresomercancia', $idEntry)->findAll();
		$response = true;

		foreach ($dataProdsEntry as $product) {
			$movimiento->id_producto = $product->id_producto;
			$movimiento->tipo = $type;
			$movimiento->cantidad = $product->cantidad;
			$movimiento->id_ingresomercancia = $product->id_ingresomercancia;
			if ($type == "S") {
				$movimiento->observacion = "Anula ingreso de mercancia con código " . $codigo;
			} else {
				$movimiento->observacion = "Confirma ingreso de mercancia con código " . $codigo;
			}
			if(!$movimientoInventarioModel->save($movimiento)) {
				$response = "Error al registrar el movimiento. " . listErrors($movimientoInventarioModel->errors());
				break;
			}
			if($movimientoInventarioModel->errorAfterInsert){
				$response = $movimientoInventarioModel->errorAfterInsertMsg;
				break;
			}
		}
		return $response;
	}

	private function saveProdEntry($product, $mIngresoMercanciaProductos, $idEntry) {
		$dataProductoIngreso = [
			"id_ingresomercancia" => $idEntry,
			"cantidad" => $product->cantidad,
			"id_producto" => $product->idProducto
		];
		if (!$mIngresoMercanciaProductos->save($dataProductoIngreso)) {
			return "Ha ocurrido un error al guardar los productos. " . listErrors($mIngresoMercanciaProductos->errors());
		}
		return true;
	}

}
