<?php

namespace App\Controllers;
use TCPDF;
use App\Models\mVentasProductos;
use App\Models\mPedidosProductos;
use App\Models\mConfiguracion;

class cReportes extends BaseController {

	private $mConfiguracion;

	function __construct() {
		$this->mConfiguracion = new mConfiguracion();
	}

	public function factura($id) {
		$estrucPdf = $this->estructuraReporte("Factura");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "ventas");
		$estrucPdf = $dataVenta['pdf'];

		$mVentasProductos = new mVentasProductos();

		$productosFactura = $mVentasProductos->select("
				P.referencia AS referenciaProductoDP,
				P.item AS itemProductoDP,
				P.descripcion AS descripcionProductoDP,
				ventasproductos.cantidad AS cantidadProductoDP,
				ventasproductos.valor AS valorProductoDP,
				(ventasproductos.cantidad * ventasproductos.valor) AS totalProductoDP
			")->join("productos AS P", "ventasproductos.id_producto = P.id", "left")
			->where("id_venta", $id)
			->findAll();

		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura);

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf->setTitle('Factura ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", 'I');
		exit;
	}

	public function pedido($id) {

		$estrucPdf = $this->estructuraReporte("Pedido");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "pedidos");
		$estrucPdf = $dataVenta['pdf'];

		$mPedidosProductos = new mPedidosProductos();
		$productosFactura = $mPedidosProductos->select("
				P.referencia AS referenciaProductoDP,
				P.item AS itemProductoDP,
				P.descripcion AS descripcionProductoDP,
				P.ubicacion AS ubicacionProductoDP,
				M.nombre AS manifiestoProductoDP,
				pedidosproductos.cantidad AS cantidadProductoDP,
				pedidosproductos.valor AS valorProductoDP,
				(pedidosproductos.cantidad * pedidosproductos.valor) AS totalProductoDP
			")->join("productos AS P", "pedidosproductos.id_producto = P.id", "left")
			->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
			->where("id_pedido", $id)
			->findAll();

		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura);

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf->setTitle('Pedido ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", 'I');
		exit;
	}

	private function estructuraReporte($reporte) {
		$path = UPLOADS_REPOR_PATH . "$reporte.txt";

		try {
			if (file_exists($path)) {
				$arrContextOptions = array(
					"ssl"=>array(
						"verify_peer" => false,
						"verify_peer_name" => false,
					),
				);  
				$estructuraPdf = file_get_contents($path, false, stream_context_create($arrContextOptions));
			} else {
				echo "<h1>No se encontra estructura relacionada</h1>";
				exit;
			}
		} catch(Exception $e) {
			echo "<h1>No se encontra estructura relacionada</h1>";
			exit;
		}
		return $estructuraPdf;
	}

	private function setValuesCompany($pdf) {
		$files = ['logoEmpresa', 'tipoDocumentoEmpresa', 'documentoEmpresa', 'digitoVeriEmpresa', 'telefonoEmpresa', 'nombreEmpresa', 'direccionEmpresa', 'emailEmpresa'];
		$datos = $this->mConfiguracion
			->select("
				IF(valor IS NOT NULL AND valor <> ''
					, valor
					, IF(campo = 'logoEmpresa', '" . base_url("assets/img/logo-negro-bloque.jpg") . "', '')
				) AS valor,
				campo
			")
			->whereIn('campo', $files)
			->get()->getResult();

		foreach ($datos as $value) {
			if ($value->campo == 'logoEmpresa') {
				$value->valor = '<img src="' . UPLOADS_CONF_PATH . $value->valor. '" width="130px" height="100px">';
			}
			$pdf = str_replace("{{$value->campo}}", $value->valor, $pdf);
		}
		return $pdf;
	}

	private function cargarDataVenta($pdf, $id, $tabla) {
		$venta = $this->db->table("$tabla AS V")
			->select("
				V." . ($tabla == 'pedidos' ? 'pedido' : 'codigo') . " AS numeracion,
				C.nombre AS nombreCliente,
				U.nombre AS nombreVendedor,
				V.total AS totalGeneral,
				V.created_at AS fechaCreacion,
				S.direccion AS direccionSucursal,
				S.nombre AS nombreSucursal,
				S.telefono AS telefonoSucursal,
				CI.nombre AS ciudadSucursal,
				DEP.nombre AS deptoSucursal,
				V.observacion
			")->join("clientes AS C", "V.id_cliente = C.id", "left")
			->join("usuarios AS U", "V.id_vendedor = U.id", "left")
			->join("sucursales AS S", "V.id_sucursal = S.id", "left")
			->join("ciudades AS CI", "S.id_ciudad = CI.id", "left")
			->join("departamentos AS DEP", "CI.id_depto = DEP.codigo", "left")
			->where("V.id", $id)
			->get()->getResultObject()[0];

		foreach ($venta as $key => $value) {
			if ($key == 'totalGeneral') {
				$value = '$ ' . number_format($value, 0, ',', '.');
			}
			$pdf = str_replace("{{$key}}", $value, $pdf);
		};
		return array(
			"pdf" => $pdf,
			"codigo" => $venta->numeracion
		);
	}

	private function estructuraProductos($pdf, $productos) {
		$contentReplace = "";
		if (strpos($pdf, "[DP")) {
			$contentReplace = explode("[DP", $pdf);
			$contentReplace = explode("DP]", $contentReplace[1])[0];
		}

		if ($contentReplace != "") {
			if (strpos($contentReplace, "<tbody>")) {
				$table = explode("<tbody>", $contentReplace);
				$table = explode("</tbody>", $table[1])[0];
				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $table;
					foreach ($value as $key => $value) {
						if ($key == 'valorProductoDP' || $key == 'totalProductoDP') {
							$value = '$ ' . number_format($value, 0, ',', '.');
						}
						$estructura = str_replace("{{$key}}", $value, $estructura);
					}
				}
				$parte1 = explode("<tbody>", $contentReplace)[0];
				$estructura = $parte1 . $estructura . explode("</tbody>", $contentReplace)[1];
			} else {
				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $contentReplace;
					foreach ($value as $key => $value) {
						if ($key == 'valorProductoDP' || $key == 'totalProductoDP') {
							$value = '$ ' . number_format($value, 0, ',', '.');
						}
						$estructura = str_replace("{{$key}}", $value, $estructura);
					}
				}
			}
			$parte1 = explode("[DP", $pdf)[0];
			$pdf = $parte1 . $estructura . explode("DP]", $pdf)[1];
		}
		return $pdf;
	}

}
