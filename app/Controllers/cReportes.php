<?php

namespace App\Controllers;
use setasign\Fpdi\TcpdfFpdi;
use App\Models\mVentasProductos;
use App\Models\mPedidosProductos;
use App\Models\mConfiguracion;
use App\Models\mPedidosCajas;
use App\Models\mPedidosCajasProductos;
use App\Models\mManifiesto;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class cReportes extends BaseController {

	private $mConfiguracion;

	function __construct() {
		$this->mConfiguracion = new mConfiguracion();
	}

	public function factura($id, $desdeFactura = 0, $download = 0, $fotoProd = 0) {
		$mPedidosCajas = new mPedidosCajas();

		$estrucPdf = $this->estructuraReporte("Factura");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "ventas");
		$estrucPdf = $dataVenta['pdf'];
		$manifiestos = [];

		$totCajas = $mPedidosCajas->where("id_pedido", $dataVenta['id_pedido'])->countAllResults();

		if (is_null($dataVenta['id_pedido']) || $dataVenta['id_pedido'] == '' || $totCajas == 0) {
			$mVentasProductos = new mVentasProductos();

			$productosFactura = $mVentasProductos->select("
					P.referencia AS referenciaProductoDP,
					P.item AS itemProductoDP,
					P.descripcion AS descripcionProductoDP,
					P.cantPaca AS cantPacaProductoDP,
					CAST((P.cantPaca / ventasproductos.cantidad) AS DECIMAL(12,2)) AS paqueteProductoDP,
					ventasproductos.cantidad AS cantidadProductoDP,
					ventasproductos.valor AS valorProductoDP,
					(ventasproductos.cantidad * ventasproductos.valor) AS totalProductoDP,
					'' AS numeroCaja,
					P.imagen AS imagenDP,
					P.id AS idProducto
				")->join("productos AS P", "ventasproductos.id_producto = P.id", "left")
				->where("id_venta", $id)
				->findAll();

			$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura, $fotoProd);
		} else {

			$productosFactura = $mPedidosCajas->select("
					P.referencia AS referenciaProductoDP,
					P.item AS itemProductoDP,
					P.descripcion AS descripcionProductoDP,
					P.cantPaca AS cantPacaProductoDP,
					CAST((P.cantPaca / PCP.cantidad) AS DECIMAL(12,2)) AS paqueteProductoDP,
					PCP.cantidad AS cantidadProductoDP,
					PV.valor AS valorProductoDP,
					(PCP.cantidad * PV.valor) AS totalProductoDP,
					numero_caja AS numeroCaja,
					M.ruta_archivo AS archivoManifiesto,
					M.id AS idManifiesto,
					P.imagen AS imagenDP,
					P.id AS idProducto
				")
				->join("pedidoscajasproductos AS PCP", "pedidoscajas.id = PCP.id_caja", "left")
				->join("productos AS P", "PCP.id_producto = P.id", "left")
				->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
				->join("(
					SELECT id_producto, valor, cantidad FROM ventasproductos WHERE id_venta = '$id'
				) AS PV", "PCP.id_producto = PV.id_producto", "left")
				->where("id_pedido", $dataVenta['id_pedido'])
				->orderBy("numero_caja", "ASC")
				->orderBy("PCP.id", "DESC")
				->findAll();

			$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura, $fotoProd);

			if ($desdeFactura == 0) {
				foreach ($productosFactura as $key => $value) {
					if (!is_null($value->idManifiesto)) {
						$enc = array_search($value->idManifiesto, array_column($manifiestos, "id"));
						if ($enc === false) {
							$data = [
								"id" => $value->idManifiesto,
								"archivo" => $value->archivoManifiesto
							];
							array_push($manifiestos, $data);
						}
					}
				}
			}
		}

		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');

		/* if (count($manifiestos) > 0) {
			foreach ($manifiestos as $llave => $manif) {
				$ext = explode('.', $manif['archivo'])[1];
				$file = UPLOADS_MANIFEST_PATH . $manif['archivo'];
				if ($ext == 'pdf') {

					$paginas = $pdf->setSourceFile($file);
					for($i=0; $i < $paginas; $i++) {
						$pdf->AddPage();
						$tplIdx = $pdf->importPage($i+1);
						$pdf->useTemplate($tplIdx, 10, 10, 200);
					}

				} else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
					$pdf->AddPage();
					$pdf->Image($file);
				}
			}
		} */

		if ($download == 1) {
			$nit = $this->getValConfig("documentoEmpresa");
			if ($nit != '') {
				$pdf->SetProtection(array('print','copy'), $nit, null, 0);
			}
		}

		$pdf->setTitle('Factura ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
		exit;
	}

	public function pedido($id, $download = 0, $fotoProd = 0) {

		$estrucPdf = $this->estructuraReporte("Pedido");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "pedidos");
		$estrucPdf = $dataVenta['pdf'];

		$mPedidosProductos = new mPedidosProductos();
		$productosFactura = $mPedidosProductos->select("
				P.referencia AS referenciaProductoDP,
				P.item AS itemProductoDP,
				P.descripcion AS descripcionProductoDP,
				P.cantPaca AS cantPacaProductoDP,
				CAST((P.cantPaca / pedidosproductos.cantidad) AS DECIMAL(12,2)) AS paqueteProductoDP,
				P.ubicacion AS ubicacionProductoDP,
				M.nombre AS manifiestoProductoDP,
				pedidosproductos.cantidad AS cantidadProductoDP,
				pedidosproductos.valor AS valorProductoDP,
				(pedidosproductos.cantidad * pedidosproductos.valor) AS totalProductoDP,
				P.imagen AS imagenDP,
				P.id AS idProducto
			")->join("productos AS P", "pedidosproductos.id_producto = P.id", "left")
			->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
			->where("id_pedido", $id)
			->findAll();

		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura, $fotoProd);

		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');

		if ($download == 1) {
			$nit = $this->getValConfig("documentoEmpresa");
			if ($nit != '') {
				$pdf->SetProtection(array('print','copy'), $nit, null, 0);
			}
		}
		$pdf->setTitle('Pedido ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
		exit;
	}

	public function rotulo($id, $cantidad) {

		$estrucPdf = $this->estructuraReporte("Rotulo");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$observacion = (isset($_GET['observacion']) ? $_GET['observacion'] : '');
		$observacion = str_replace('_', ' ', $observacion);

		$estrucPdf = str_replace("{observacion}", $observacion, $estrucPdf);
		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "pedidos");
		$estrucPdf = $dataVenta['pdf'];

		$estrucPdf = $this->generarQR($id, $estrucPdf);

		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();

		for ($i=0; $i < $cantidad; $i++) { 
			$pdf->AddPage();
			$estrucPdf2 = str_replace("{numeroRotulo}", ($i + 1) . '/' . $cantidad, $estrucPdf);
			$pdf->writeHTML($estrucPdf2, false, false, false, false, '');
		}

		$pdf->setTitle('Rotulos | ' . session()->get("nombreEmpresa"));
		$pdf->Output("1.pdf", 'I');
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
		} catch(\Exception $e) {
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
			$pdf = str_replace("{{$value->campo}}", (is_null($value->valor) ? '' : $value->valor), $pdf);
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
				DATE_FORMAT(V.created_at, '%d-%m-%Y') AS fechaCreacion,
				DATE_FORMAT(V.created_at, '%H:%i:%s') AS horaCreacion,
				S.direccion AS direccionSucursal,
				S.nombre AS nombreSucursal,
				S.telefono AS telefonoSucursal,
				S.barrio AS barrioSucursal,
				S.administrador AS adminSucursal,
				S.cartera AS carteraSucursal,
				S.telefonoCart AS telCartSucursal,
				CI.nombre AS ciudadSucursal,
				DEP.nombre AS deptoSucursal,
				V.observacion
			")->join("clientes AS C", "V.id_cliente = C.id", "left")
			->join("usuarios AS U", "V.id_vendedor = U.id", "left")
			->join("sucursales AS S", "V.id_sucursal = S.id", "left")
			->join("ciudades AS CI", "S.id_ciudad = CI.id", "left")
			->join("departamentos AS DEP", "CI.id_depto = DEP.codigo", "left")
			->where("V.id", $id);
		
		if ($tabla == 'ventas') {
			$venta = $venta->select("id_pedido");
		}
		$venta = $venta->get()->getResultObject()[0];

		foreach ($venta as $key => $value) {
			if ($key == 'totalGeneral') {
				$value = '$ ' . number_format($value, 0, ',', '.');
			}
			$pdf = str_replace("{{$key}}", (is_null($value) ? '' : $value), $pdf);
		};
		return array(
			"pdf" => $pdf,
			"codigo" => $venta->numeracion,
			"id_pedido" => isset($venta->id_pedido) ? $venta->id_pedido : null
		);
	}

	private function estructuraProductos($pdf, $productos, $imagen = 0) {
		$contentReplace = "";
		if (strpos($pdf, "[DP")) {
			$contentReplace = explode("[DP", $pdf);
			$contentReplace = explode("DP]", $contentReplace[1])[0];
		}

		if ($contentReplace != "") {
			if (strpos($contentReplace, "<tbody>")) {
				$table = explode("<tbody>", $contentReplace);
				$table = explode("</tbody>", $table[1])[0];

				if ($imagen == 1) {
					/* Partimos la estructura en el thead, dejamos solo el tr dentro */
					$tableHead = explode("<thead>", $contentReplace);
					$tableHead = explode("</thead>", $tableHead[1])[0];

					/* Sacamos los th de tr del thead para agregar la columan de imagen */
					$tableHeadtr = explode("<tr>", $tableHead);
					$tableHeadtr = explode("</tr>", $tableHeadtr[1])[0];
	
					$tableHeadtr = '<tr><th scope="col"><strong>Imagen</strong></th>' . $tableHeadtr . '</tr>';
	
					$tableHeadListo = explode("<thead>", $contentReplace)[0];
	
					/* Concatenamos las partes para volver a armar el thead */
					$contentReplace = $tableHeadListo . $tableHeadtr . explode("</thead>", $contentReplace)[1];

					/* Sacamos el tr del body y agregamos la columna imagen al inicio y volvemos a crear el tr */
					$tableBodytr = explode("<tr>", $table);
					$tableBodytr = explode("</tr>", $tableBodytr[1])[0];
					$table = '<tr><td>{imagenDP}</td>' . $tableBodytr . '</tr>';
				}

				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $table;
					foreach ($value as $key => $value2) {
						if ($imagen == 1 && $key == 'imagenDP') {
							$path = UPLOADS_PRODUCT_PATH . $value->idProducto . "/01-small.png";
							if (!file_exists($path)) {
								$path = ASSETS_PATH . "/img/nofoto.png";
							}
							$value2 = '<img src="' . $path . '" width="70px" height="40px">';
						}
						if ($key == 'valorProductoDP' || $key == 'totalProductoDP') {
							$value2 = '$ ' . number_format($value2, 0, ',', '.');
						}
						$estructura = str_replace("{{$key}}", (is_null($value2) ? '' : $value2), $estructura);
					}
				}
				$parte1 = explode("<tbody>", $contentReplace)[0];
				$estructura = $parte1 . $estructura . explode("</tbody>", $contentReplace)[1];
			} else {
				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $contentReplace;

					if ($imagen == 1) {
						$estructura .= 'Imagen: <img src="' . UPLOADS_PRODUCT_PATH . $value->idProducto . '"/01-small.png" width="70px" height="40px">';
					}

					foreach ($value as $key => $value) {
						if ($key == 'valorProductoDP' || $key == 'totalProductoDP') {
							$value = '$ ' . number_format($value, 0, ',', '.');
						}
						$estructura = str_replace("{{$key}}", (is_null($value) ? '' : $value), $estructura);
					}
				}
			}
			$parte1 = explode("[DP", $pdf)[0];
			$pdf = $parte1 . $estructura . explode("DP]", $pdf)[1];
		}
		return $pdf;
	}

	public function manifiestos($ids) {

		$mManifiesto = new mManifiesto();

		$ids = explode("_", $ids);

		$manifiestos = $mManifiesto->select("ruta_archivo")->whereIn("id", $ids)->findAll();

		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();

		if (count($manifiestos) > 0) {
			foreach ($manifiestos as $llave => $manif) {
				$ext = explode('.', $manif['ruta_archivo'])[1];
				$file = UPLOADS_MANIFEST_PATH . $manif['ruta_archivo'];
				if ($ext == 'pdf') {

					$paginas = $pdf->setSourceFile($file);
					for($i=0; $i < $paginas; $i++) {
						$pdf->AddPage();
						$tplIdx = $pdf->importPage($i+1);
						$pdf->useTemplate($tplIdx, 10, 10, 200);
					}

				} else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
					$pdf->AddPage();
					$pdf->Image($file);
				}
			}
		}

		$pdf->setTitle('Impresion Manifiestos | ' . session()->get("nombreEmpresa"));
		$pdf->Output("Manifiestos.pdf", 'I');
		exit;
	}

	public function envio($id, $valor) {
		$mPedidosCajas = new mPedidosCajas();

		$estrucPdf = $this->estructuraReporte("Envio");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "pedidos");
		$estrucPdf = $dataVenta['pdf'];

		$totCajas = $mPedidosCajas->where("id_pedido", $dataVenta['id_pedido'])->countAllResults();

		$estrucPdf = str_replace("{totalCajas}", $totCajas, $estrucPdf);
		$estrucPdf = str_replace("{costoEnvio}", '$ ' . number_format($valor, 0, ',', '.'), $estrucPdf);

		// $pageLayout = array(150, 150); // PDF_PAGE_FORMAT

		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// $pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf->setTitle('Envio Pedido ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", 'I');
		exit;
	}

	private function getValConfig($field) {
		return $this->mConfiguracion
				->select("IF(valor IS NULL OR valor = '', '', valor) AS valor")
				->where('campo', $field)->get()->getRow('valor');
	}

	public function generarQR($pedido, $estrucPdf) {
		$options = new QROptions([
			'imageTransparent' => false
		]);

		$qr = (new QRCode($options))->render(base_url() . "/FacturaQR/{$pedido}");
		$qr = '<img width="130px" height="100px" src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $qr) . '">';
		$estrucPdf = str_replace("{imagenQR}", $qr, $estrucPdf);
		return $estrucPdf;
	}

}
