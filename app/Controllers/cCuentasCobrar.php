<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Models\mVentas;
use App\Models\mConfiguracion;
use App\Models\mCuentasCobrar;

class cCuentasCobrar extends BaseController {

	private $messageError = "Ha ocurrido un error al guardar la compra.";

	public function index() {
		$this->content['title'] = "Cuentas por cobrar";
		$this->content['view'] = "vCuentasCobrar";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LInputMask();
		$this->LSelect2();

		//Buscamos facturas que no tengas fecha de vencimiento
		$mVentas = new mVentas();

		$facturaVencidas = $mVentas->where("fecha_vencimiento IS NULL")->countAllResults();

		$this->content['facturaVencidas'] = $facturaVencidas;

		$this->content['css_add'][] = [
			'CuentasCobrar.css'
		];

		$this->content['js_add'][] = [
			'jsCuentasCobrar.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$postData = (object) $this->request->getPost();

		$subQuery = $this->db->table("abonosventas AS AV")
			->select("
				AV.id_venta,
				SUM(CASE WHEN AV.estado = 'CO' THEN AV.valor ELSE 0 END) AS TotalAbonosVenta
			")->groupBy("AV.id_venta")
			->getCompiledSelect();

		$query = $this->db->table('ventas AS V')
			->select("
				V.id,
				V.codigo,
				V.descuento,
				U.id AS IdVendedor,
				U.nombre AS NombreVendedor,
				(V.total - V.descuento) AS total,
				((V.total - V.descuento) - IFNULL(TA.TotalAbonosVenta, 0)) AS ValorPendiente,
				V.created_at,
				IFNULL(TA.TotalAbonosVenta, 0) AS AbonosVenta,
				V.fecha_vencimiento AS FechaVencimiento,
				V.id_pedido,
				C.nombre AS NombreCliente,
				S.nombre As Sucursal,
				CU.nombre AS Ciudad
			")->join('clientes AS C', 'V.id_cliente = C.id', 'left')
			->join('usuarios AS U', 'V.id_vendedor = U.id', 'left')
			->join('sucursales AS S', 'V.id_sucursal = S.id', 'left')
			->join('ciudades AS CU', 'S.id_ciudad = CU.id', 'left')
			->join("({$subQuery}) TA", "V.id = TA.id_venta", "left")
			->where("V.metodo_pago", "2")
			->where("V.fecha_vencimiento IS NOT NULL");

		if ($postData->type == "0") {
			$query->where("IFNULL(TA.TotalAbonosVenta, 0) <= 0");
		}
	
		if ($postData->type == "1") {
			$query->where("IFNULL(TA.TotalAbonosVenta, 0) > 0 AND IFNULL(TA.TotalAbonosVenta, 0) < (V.total - V.descuento)");
		}

		if ($postData->type == "2") {
			$query->where("IFNULL(TA.TotalAbonosVenta, 0) >= (V.total - V.descuento)");
		}

		if ($postData->type == "3" || $postData->type == "4") {
			$query->where("V.fecha_vencimiento < CURRENT_DATE()");
		}
		
		if ($postData->type == "3") {
			$query->where("IFNULL(TA.TotalAbonosVenta, 0) <=", "(V.total - V.descuento)");
		}

		if ($postData->type == "4") {
			$query->where("IFNULL(TA.TotalAbonosVenta, 0) >", 0);
		}

		if (isset($postData->branches) && $postData->branches != "") {
			$query->where("S.id", $postData->branches);
		}

		return DataTable::of($query)->toJson(true);
	}

	public function getCurrentBuy($http = 1) {

		$mConfiguracion = new mConfiguracion();

		$cantDigitos = (session()->has("digitosCuentaCobrar") ? session()->get("digitosCuentaCobrar") : 0);
		$dataConse = $mConfiguracion->select("valor")->where("campo", "consecutivoCuentaCobrar")->first();

		$numerVenta = str_pad((is_null($dataConse) ? 1 : (((int) $dataConse->valor) + 1)), $cantDigitos, "0", STR_PAD_LEFT);

		$codigo = (session()->has("prefijoCuentaCobrar") ? session()->get("prefijoCuentaCobrar") : '') . $numerVenta;

		if ($http == 0) {
			return array(
				"codigo" => $codigo,
				"dataConse" => $dataConse,
				"numerVenta" => $numerVenta
			);
		}
		return $this->response->setJSON(["codigo" => $codigo]);
	}

	public function crear() {
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		
		$mCuentasCobrar = new mCuentasCobrar();

		$codigo = $this->getCurrentBuy(0);

		$this->db->transBegin();

		$dataAccount = array(
			"codigo" => $codigo['codigo'],
			"valor" => $dataPost->valor,
			"estado" => "CO",
			"observacion" => $dataPost->observacion,
			"id_venta" => $dataPost->idVenta,
			"id_usuario" => session()->get("id_user"),
			"tipo_abono" => $dataPost->tipoAbono
		);

		if($mCuentasCobrar->save($dataAccount)) {

			if (is_null($codigo['dataConse'])) {
				$mConfiguracion = new mConfiguracion();
				$dataSave = [
					"campo" => "consecutivoCuentaCobrar",
					"valor" => $codigo['numerVenta']
				];
				if(!$mConfiguracion->save($dataSave)) {
					$this->db->transRollback();
					$resp["msj"] = "Ha ocurrido un error al guardar el abono." . listErrors($mConfiguracion->errors());
				} else {
					$resp["success"] = true;
					$this->db->transCommit();
				}
			} else {
				$builder = $this->db->table('configuracion')
					->set("valor", $codigo['numerVenta'])
					->where('campo', "consecutivoCuentaCobrar");
				if($builder->update()) {
					$this->db->transCommit();
					$resp["success"] = true;
				} else {
					$this->db->transRollback();
				}
			}

			if ($resp["success"]) {
				$resp["msj"] = "Abono creado exitosamente";
				$resp["info"] = $this->getAccounts($dataPost->idVenta, 0);
			}

		} else{
			$this->db->transRollback();
			$resp["msj"] = $this->messageError . listErrors($mCuentasCobrar->errors());
		}
		return $this->response->setJSON($resp);
	}

	public function getAccounts($idBill, $http = 1) {

		$mVentas = new mVentas();
		$mCuentasCobrar = new mCuentasCobrar();

		$dataBuy = $mVentas->cargarVenta($idBill);

		$dataAccountBill = $mCuentasCobrar->select("
				abonosventas.id,
				abonosventas.codigo,
				abonosventas.valor,
				abonosventas.estado,
				abonosventas.observacion,
				abonosventas.id_usuario,
				abonosventas.created_at,
				abonosventas.tipo_abono,
				U.nombre AS NombreUsuario,
				CASE
					WHEN abonosventas.estado = 'AN'
						THEN 'Anulado'
					ELSE 'Confirmado'
				END AS Descripcion_Estado
			")->join("usuarios AS U", "abonosventas.id_usuario = U.id", "left")
			->where("abonosventas.id_venta", $idBill)
			->findAll();

		$informationBuy = array(
			"venta" => $dataBuy[0]
			, "accountsBill" => $dataAccountBill
		);
		if ($http == 1) {
			return $this->response->setJSON($informationBuy);
		}
		return $informationBuy;
	}

	public function anular() {
		$resp["success"] = true;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();

		$mCuentasCobrar = new mCuentasCobrar();

		$dataAddAccount = array(
			"id" => $data->idAbonoVenta,
			"estado" => "AN"
		);
		$this->db->transBegin();

		if($mCuentasCobrar->save($dataAddAccount)) {
			$this->db->transCommit();
			$resp['msj'] = "Abono anulado correctamente";
			$resp["info"] = $this->getAccounts($data->idVenta, 0);
		} else {
			$this->db->transRollback();
			$resp["success"] = false;
			$resp['msj'] = "Error al anular el abono";
		}
		return $this->response->setJSON($resp);
	}

}
