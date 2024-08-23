<?php

namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Models\MovimientoInventarioModel;

class cReporteInventario extends BaseController {

	public function index() {
		$this->content['title'] = "Reporte de inventario";
		$this->content['view'] = "vReporteInventario";

		$this->LDataTables();
		$this->LMoment();
		
		$this->content['js_add'][] = [
			'jsReporteInventario.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT() {
		$query = $this->db->table("movimientosinventario AS MI")
				->select("
						MI.id,
                        CONCAT(UPPER(P.referencia), ' | ', IF(P.item IS NULL, '', P.item)) AS referenciaItem,
                        P.descripcion,
                        P.referencia,
                        P.item,
                        P.id AS idProducto,
                        MI.cantidad,
                        MI.tipo,
                        CASE
							WHEN MI.tipo = 'I'
								THEN 'Ingreso'
							ELSE 'Salida'
						END AS Descripcion_Tipo,
                        MI.observacion,
                        MI.id_venta,
                        MI.id_pedido,
                        MI.id_compra,
                        MI.id_ingresomercancia,
                        MI.id_pedido_observacion,
						MI.created_at AS Fecha_Creacion,
						MI.id_usuario,
						U.nombre AS Nombre_Usuario
				")->join("productos AS P", "MI.id_producto = P.id", "left")
				->join("usuarios AS U", "MI.id_usuario = U.id", "left");

		$postData = (object) $this->request->getPost();

		if(isset($postData->tipo) && $postData->tipo != '-1'){
			$query->where("MI.tipo", $postData->tipo);
		}

		if(isset($postData->cantidadInicial) && $postData->cantidadInicial >= 0) {
			$query->where("MI.cantidad >= $postData->cantidadInicial");
		}

		if(isset($postData->cantidadFinal) && $postData->cantidadFinal >= 0){
			$query->where("MI.cantidad <= $postData->cantidadFinal");
		}

		if(isset($postData->fechaInicial) && $postData->fechaInicial != '') {
			$query->where("DATE_FORMAT(MI.created_at, '%Y-%m-%d') >= '$postData->fechaInicial'");
		}

		if(isset($postData->fechaFinal) && $postData->fechaFinal >= 0){
			$query->where("DATE_FORMAT(MI.created_at, '%Y-%m-%d') <= '$postData->fechaFinal'");
		}

		$query->orderBy('MI.created_at', 'DESC');

		return DataTable::of($query)->toJson(true);
	}

}
