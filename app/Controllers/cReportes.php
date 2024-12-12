<?php

namespace App\Controllers;
use App\Models\mConfiguracion;
use App\Models\mManifiesto;
use App\Models\mPedidosCajas;
use App\Models\mPedidosCajasProductos;
use App\Models\mPedidosProductos;
use App\Models\mVentasProductos;
use App\Models\mCompraProductos;
use App\Models\mIngresoMercanciaProductos;
use App\Models\mCuentasCobrar;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use setasign\Fpdi\TcpdfFpdi;
use NumberFormatter;

class cReportes extends BaseController {

	private $mConfiguracion;

	public function __construct() {
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
					CAST((ventasproductos.cantidad / P.cantPaca) AS DECIMAL(12,2)) AS paqueteProductoDP,
					ventasproductos.cantidad AS cantidadProductoDP,
					ventasproductos.valor AS valorProductoDP,
					(ventasproductos.cantidad * ventasproductos.valor) AS totalProductoDP,
					'' AS numeroCajaDP,
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
					CAST((PCP.cantidad / P.cantPaca) AS DECIMAL(12,2)) AS paqueteProductoDP,
					PCP.cantidad AS cantidadProductoDP,
					PV.valor AS valorProductoDP,
					(PCP.cantidad * PV.valor) AS totalProductoDP,
					numero_caja AS numeroCajaDP,
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

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf = $this->downloadFile($download, $pdf);

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
				CAST((pedidosproductos.cantidad / P.cantPaca) AS DECIMAL(12,2)) AS paqueteProductoDP,
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
			->orderBy("P.ubicacion ASC, P.referencia")
			->findAll();
		
		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura, $fotoProd);

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');

		$pdf = $this->downloadFile($download, $pdf);

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

		$pdf = $this->initPdf(true, false);

		for ($i=0; $i < $cantidad; $i++) { 
			$pdf->AddPage();
			$estrucPdf2 = str_replace("{numeroRotulo}", ($i + 1) . '/' . $cantidad, $estrucPdf);
			$pdf->writeHTML($estrucPdf2, false, false, false, false, '');
		}

		$pdf->setTitle('Rotulos | ' . session()->get("nombreEmpresa"));
		$pdf->Output("1.pdf", 'I');
		exit;
	}

	public function compra($id, $download = 0) {
		
		$estrucPdf = $this->estructuraReporte("Compra");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "compras");
		$estrucPdf = $dataVenta['pdf'];

		$mCompraProductos = new mCompraProductos();

		$productosFactura = $mCompraProductos->select("
				P.item AS itemProductoDP,
				UPPER(P.referencia) AS referenciaProductoDP,
				P.descripcion AS descripcionProductoDP,
				comprasproductos.cantPaca AS cantPacaProductoDP,
				CAST(
					(comprasproductos.cantidad / comprasproductos.cantPaca) AS DECIMAL(12,2)
				) AS paqueteProductoDP,
				comprasproductos.cantidad AS cantidadProductoDP,
				comprasproductos.valor AS valorProductoDP,
				(comprasproductos.cantidad * comprasproductos.valor) AS totalProductoDP,
			")->join("productos AS P", "comprasproductos.id_producto = P.id", "left")
			->where("id_compra", $id)
			->findAll();

		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura);

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');

		$pdf = $this->downloadFile($download, $pdf);

		$pdf->setTitle('Compra ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
		exit;
	}

	public function ingresoMercancia($id, $download = 0) {
		
		$estrucPdf = $this->estructuraReporte("Ing_Mercancia");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "ingresomercancia");
		$estrucPdf = $dataVenta['pdf'];

		$mIngresoMercanciaProductos = new mIngresoMercanciaProductos();

		$productosFactura = $mIngresoMercanciaProductos->select("
				P.item AS itemProductoDP,
				UPPER(P.referencia) AS referenciaProductoDP,
				P.descripcion AS descripcionProductoDP,
				ingresomercanciaproductos.cantidad AS cantidadProductoDP
			")->join("productos AS P", "ingresomercanciaproductos.id_producto = P.id", "left")
			->where("id_ingresomercancia", $id)
			->findAll();

		$estrucPdf = $this->estructuraProductos($estrucPdf, $productosFactura);

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf = $this->downloadFile($download, $pdf);
		$pdf->setTitle('Ingreso Mercancia ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
		exit;
	}

	public function stickerCompra($id, $download = 0) {
		
		$estrucPdf = $this->estructuraReporte("Sticker");

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "compras");

		$pdf = $this->initPdf();

		$mCompraProductos = new mCompraProductos();

		$productosCompra = $mCompraProductos->select("
				comprasproductos.cantPaca AS cantPacaProductoDP,
				P.descripcion AS descripcionProductoDP,
				UPPER(P.referencia) AS referenciaProductoDP,
				comprasproductos.valor AS valorProductoDP
			")->join("productos AS P", "comprasproductos.id_producto = P.id", "left")
			->where("id_compra", $id)
			->findAll();

		$pdf = $this->estructuraProductosSticker($estrucPdf, $productosCompra, $pdf);
		$pdf = $this->downloadFile($download, $pdf);

		$pdf->setTitle('Sticker Compra ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
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

	private function setValuesCompany($pdf, $widthLogo = 130, $heightLogo = 100) {
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
				$value->valor = '<img src="' . UPLOADS_CONF_PATH . $value->valor. '" width="' . $widthLogo . 'px" height="' . $heightLogo . 'px">';
			}
			$pdf = str_replace("{{$value->campo}}", (is_null($value->valor) ? '' : $value->valor), $pdf);
		}
		return $pdf;
	}

	private function cargarDataVenta($pdf, $id, $tabla) {
		$venta = null;
		switch ($tabla) {
			case 'ingresomercancia':
				$venta = $this->db->table("{$tabla} AS IM")
					->select("
						IM.codigo AS numeracion,
						U.nombre AS nombreVendedor,
						DATE_FORMAT(IM.created_at, '%d-%m-%Y') AS fechaCreacion,
						DATE_FORMAT(IM.created_at, '%H:%i:%s') AS horaCreacion,
						IM.observacion,
						CASE
							WHEN IM.estado = 'AN'
								THEN 'Anulado'
							WHEN IM.estado = 'CO'
								THEN 'Confirmado'
							ELSE 'Pendiente'
						END AS estadoRegistro
					")->join("usuarios AS U", "IM.id_usuario = U.id", "left")
					->where("IM.id", $id);
				break;
			case 'compras':
				$venta = $this->db->table("{$tabla} AS C")
					->select("
						C.codigo AS numeracion,
						U.nombre AS nombreVendedor,
						C.total AS totalGeneral,
						DATE_FORMAT(C.created_at, '%d-%m-%Y') AS fechaCreacion,
						DATE_FORMAT(C.created_at, '%H:%i:%s') AS horaCreacion,
						C.observacion,
						CASE
							WHEN C.estado = 'AN'
								THEN 'Anulado'
							WHEN C.estado = 'CO'
								THEN 'Confirmado'
							ELSE 'Pendiente'
						END AS estadoRegistro,
						P.nombre AS proveedor
					")->join("usuarios AS U", "C.id_usuario = U.id", "left")
					->join("proveedores AS P", "C.id_proveedor = P.id", "left")
					->where("C.id", $id);
				break;
			default:
			$venta = $this->db->table("{$tabla} AS V")
					->select("
						V." . ($tabla == 'pedidos' ? 'pedido' : 'codigo') . " AS numeracion,
						C.nombre AS nombreCliente,
						U.nombre AS nombreVendedor,
						" . ($tabla == 'ventas' ? "(V.total - V.descuento)" : "V.total") . " AS totalGeneral,
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
					$venta = $venta->select("V.total AS totalSinDescuento");
					$venta = $venta->select("V.descuento AS descuento");
					$venta = $venta->select("DATE_FORMAT(V.fecha_vencimiento, '%Y-%m-%d') AS fechaVencimiento");
				} else {
					$venta = $venta->select("
						DATE_FORMAT(V.inicio_empaque, '%d-%m-%Y') AS fechaIniEmpa,
						DATE_FORMAT(V.inicio_empaque, '%h:%i:%s %p') AS horaIniEmpa,
						DATE_FORMAT(V.fin_empaque, '%d-%m-%Y') AS fechaFinEmpa,
						DATE_FORMAT(V.fin_empaque, '%h:%i:%s %p') AS horaFinEmpa,
						TIMEDIFF(V.fin_empaque, V.inicio_empaque) AS tiempoEmpa
					");
				}
				break;
		}

		$venta = $venta->get()->getResultObject()[0];

		foreach ($venta as $key => $value) {
			if ($key == 'totalGeneral' || $key == 'descuento' || $key == 'totalSinDescuento') {
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

					/* Sacamos los th de tr del thead para agregar la columna de imagen */
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
						if ($key == 'valorProductoDP' || $key == 'totalProductoDP' || $key == 'valorAbonoDP') {
							$value2 = '$ ' . number_format($value2, 0, ',', '.');
						}
						if ($key == 'paqueteProductoDP') {
							$value2 = (fmod($value2, 1) == 0 ? (int) $value2 : $value2);
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
						if ($key == 'paqueteProductoDP') {
							$value = (fmod($value, 1) == 0 ? (int) $value : $value);
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

	public function manifiestos($boxesManifest) {

		$boxes = explode(".", $boxesManifest);
		$pdf = $this->initPdf(false, false);

		if (count($boxes) > 0) {

			$mManifiesto = new mManifiesto();

			foreach ($boxes as $box) {

				$informationBox = explode("-", $box);

				$idsManifest = explode("_", $informationBox[1]);
				$numberBox = str_replace("C", "", $informationBox[0]);

				$manifiestos = $mManifiesto->select("ruta_archivo")->whereIn("id", $idsManifest)->findAll();

				if (count($manifiestos) > 0) {
					$pdf->startPageGroup();
					$this->validarArchivoManifiesto($pdf, $manifiestos, $numberBox);
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

		$pdf = $this->initPdf();
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

		$qr = (new QRCode($options))->render(base_url() . "/FacturaQR/{$pedido}/0");
		$qr = '<img width="130px" height="100px" src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $qr) . '">';
		$estrucPdf = str_replace("{imagenQR}", $qr, $estrucPdf);
		return $estrucPdf;
	}

	public function empaque($id, $download = 0) {
		$mPedidosCajas = new mPedidosCajas();
		$mPedidosCajasProductos = new mPedidosCajasProductos();

		$estrucPdf = $this->estructuraReporte("Empaque");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $id, "pedidos");
		$estrucPdf = $dataVenta['pdf'];

		$cajas = $mPedidosCajas->select("
			pedidoscajas.id AS idCajaBuscar,
			pedidoscajas.numero_caja AS numeroCajaCJ,
			DATE_FORMAT(pedidoscajas.inicio_empaque, '%d-%m-%Y') AS fechaIniEmpaCJ,
			DATE_FORMAT(pedidoscajas.inicio_empaque, '%h:%i:%s %p') AS horaIniEmpaCJ,
			DATE_FORMAT(pedidoscajas.fin_empaque, '%d-%m-%Y') AS fechaFinEmpaCJ,
			DATE_FORMAT(pedidoscajas.fin_empaque, '%h:%i:%s %p') AS horaFinEmpaCJ,
			TIMEDIFF(pedidoscajas.fin_empaque, pedidoscajas.inicio_empaque) AS tiempoEmpaCJ,
			U.nombre AS empacadorCJ
		")->join('usuarios AS U', 'pedidoscajas.id_empacador = U.id', 'left')
		->where("id_pedido", $id)->findAll();

		foreach ($cajas as $key => $value) {
			$infoCaja = $mPedidosCajasProductos->select("
				COUNT(*) AS Total
				, COUNT(DISTINCT(P.referencia)) AS TotalRef
				, pedidoscajasproductos.id_caja
			")->join('productos P', 'pedidoscajasproductos.id_producto = P.id', 'left')
			->where("pedidoscajasproductos.id_caja", $value->idCajaBuscar)
			->groupBy("pedidoscajasproductos.id_caja")
			->first();

			$value->{'totalRefsCJ'} = $infoCaja->TotalRef;
			$value->{'totalProdsCJ'} = $infoCaja->Total;
		}
		
		$estrucPdf = $this->estructuraCajas($estrucPdf, $cajas);

		$totCajas = $mPedidosCajas->where("id_pedido", $id)->countAllResults();
		$estrucPdf = str_replace("{totalCajas}", $totCajas, $estrucPdf);

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');
		$pdf = $this->downloadFile($download, $pdf);
		$pdf->setTitle('Pedido ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", ($download == "1" ? 'D' : 'I'));
		exit;
	}

	private function estructuraCajas($pdf, $productos) {
		$contentReplace = "";
		if (strpos($pdf, "[CJ")) {
			$contentReplace = explode("[CJ", $pdf);
			$contentReplace = explode("CJ]", $contentReplace[1])[0];
		}

		if ($contentReplace != "") {
			if (strpos($contentReplace, "<tbody>")) {
				$table = explode("<tbody>", $contentReplace);
				$table = explode("</tbody>", $table[1])[0];

				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $table;
					foreach ($value as $key => $value2) {
						$estructura = str_replace("{{$key}}", (is_null($value2) ? '' : $value2), $estructura);
					}
				}
				$parte1 = explode("<tbody>", $contentReplace)[0];
				$estructura = $parte1 . $estructura . explode("</tbody>", $contentReplace)[1];
			} else {
				$estructura = "";
				foreach ($productos as $key => $value) {
					$estructura .= $contentReplace;
					foreach ($value as $key => $value) {
						$estructura = str_replace("{{$key}}", (is_null($value) ? '' : $value), $estructura);
					}
				}
			}
			$parte1 = explode("[CJ", $pdf)[0];
			$pdf = $parte1 . $estructura . explode("CJ]", $pdf)[1];
		}
		return $pdf;
	}

	private function estructuraProductosSticker($pdf, $productos, $filePdf) {
		$contentReplace = "";
		if (strpos($pdf, "[SC")) {
			$contentReplace = explode("[SC", $pdf);
			$contentReplace = explode("SC]", $contentReplace[1])[0];
		}

		if ($contentReplace != "") {

			$filePdf->resetColumns();
			$filePdf->setEqualColumns(3);
			$estructura = '';
			$totalColumns = 1;

			foreach ($productos as $key => $value) {
				$filePdf->selectColumn($totalColumns - 1);

				$estructura = $contentReplace;
				
				foreach ($value as $key2 => $value2) {
					if ($key2 == 'valorProductoDP') {
						$value2 = '$ ' . number_format($value2, 0, ',', '.');
					}
					$estructura = str_replace("{{$key2}}", (is_null($value2) ? '' : $value2), $estructura);
				}

				$filePdf->writeHTML($estructura, true, false, true, false, '');
				
				$totalColumns++;

				if (($totalColumns - 1) % 3 == 0) {
					$totalColumns = 1;
					$filePdf->resetColumns();
					$filePdf->setEqualColumns(3);
				}
			}
		}
		return $filePdf;
	}

	public function manifiestoSinRepetir($idPedido) {
		$mPedidosCajas = new mPedidosCajas();

		$manifiestosCajas = $mPedidosCajas->select("
				DISTINCT(M.id) AS idManifiesto,
				M.ruta_archivo
			")
			->join("pedidoscajasproductos AS PCP", "pedidoscajas.id = PCP.id_caja", "left")
			->join("productos AS P", "PCP.id_producto = P.id", "left")
			->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
			->where("id_pedido", $idPedido)
			->orderBy("numero_caja", "ASC")
			->orderBy("PCP.id", "DESC")
			->findAll();

		$pdf = $this->initPdf(true, false);

		if (count($manifiestosCajas) > 0) {
			$this->validarArchivoManifiesto($pdf, $manifiestosCajas, null);
		}
		$pdf->setTitle('Impresion Manifiestos | ' . session()->get("nombreEmpresa"));
		$pdf->Output("Manifiestos_No_Repetidos.pdf", 'I');
		exit;
	}

	private function validarArchivoManifiesto($pdf, $manifiestos, $numberBox) {
		foreach ($manifiestos as $manif) {
			$manif = (object) $manif;
			if (is_null($manif->ruta_archivo) || trim($manif->ruta_archivo) == '') {
				continue;
			}
			$ext = explode('.', $manif->ruta_archivo)[1];
			$file = UPLOADS_MANIFEST_PATH . $manif->ruta_archivo;
			if ($ext == 'pdf') {
				$pages = $pdf->setSourceFile($file);
				for($page=1; $page <= $pages; $page++) {
					$pdf->AddPage();

					$tplIdx = $pdf->importPage($page);
					if ($page == 1 && $numberBox) {
						$pdf->writeHTML('<p style="font-size:22px">Caja #' . $numberBox . '</p>', false, false, false, false, '');
					}
					$pdf->useTemplate($tplIdx, 10, ($page == 1 && $numberBox ? 20 : 10), 190);
				}
			} elseif ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
				$pdf->AddPage();
				if ($numberBox) {
					$pdf->writeHTML('<p style="font-size:22px">Caja #' . $numberBox . '</p>', false, false, false, false, '');
				}
				$pdf->Image($file, 10, ($numberBox ? 20 : 10), 190);
			}
		}
	}

	private function initPdf($setStartPage = true, $setAddPage = true) {
		$pdf = new TcpdfFpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		if ($setStartPage) {
			$pdf->startPageGroup();
		}
		if ($setAddPage) {
			$pdf->AddPage();
		}
		return $pdf;
	}

	private function downloadFile($download, $pdf) {
		if ($download == 1) {
			$nit = $this->getValConfig("documentoEmpresa");
			if ($nit != '') {
				$pdf->SetProtection(array('print','copy'), $nit, null, 0);
			}
		}
		return $pdf;
	}

	public function cuentaCobrar($idVenta, $idAbono) {

		$estrucPdf = $this->estructuraReporte("Cuenta_Cobrar");

		$estrucPdf = $this->setValuesCompany($estrucPdf);

		$dataVenta = $this->cargarDataVenta($estrucPdf, $idVenta, "ventas");
		$estrucPdf = $dataVenta['pdf'];

		$mCuentasCobrar = new mCuentasCobrar();

		$query = $mCuentasCobrar->select("
				abonosventas.codigo AS codigoAbonoDP,
				abonosventas.valor AS valorAbonoDP,
				abonosventas.observacion AS observacionAbonoDP,
				DATE_FORMAT(abonosventas.created_at, '%d-%m-%Y') AS fechaAbonoDP,
				U.nombre AS usuarioAbonoDP,
				CASE
					WHEN abonosventas.estado = 'AN'
						THEN 'Anulado'
					ELSE 'Confirmado'
				END AS estadoAbonoDP,
				abonosventas.tipo_abono AS tipoAbonoDP
			")->join("usuarios AS U", "abonosventas.id_usuario = U.id", "left")
			->where("abonosventas.id_venta", $idVenta);

		if ($idAbono > 0) {
			$query->where("abonosventas.id", $idAbono);
		}

		$dataAccountBill = $query->findAll();

		foreach ($dataAccountBill as $value) {
			$resultado = array_filter(TIPOSABONO, function($producto) use ($value) {
				return $producto['valor'] == $value->tipoAbonoDP;
			});
			$productoBuscado = reset($resultado);
			$value->tipoAbonoDP = $productoBuscado['titulo'];
		}

		$estrucPdf = $this->estructuraProductos($estrucPdf, $dataAccountBill);

		$pdf = $this->initPdf();
		$pdf->writeHTML($estrucPdf, false, false, false, false, '');

		$pdf->setTitle('Abonos Factura ' . $dataVenta['codigo'] . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($dataVenta['codigo'] . ".pdf", 'I');
		exit;
	}

	public function reciboCaja($idVenta, $idAbono) {

		$mCuentasCobrar = new mCuentasCobrar();

		$query = $mCuentasCobrar->select("
				abonosventas.codigo AS numeracion,
				TRUNCATE(abonosventas.valor, 0) AS totalGeneral,
				DATE_FORMAT(abonosventas.created_at, '%d-%m-%Y') AS fechaCreacion,
				abonosventas.tipo_abono AS tipoAbonoDP
			")->where("abonosventas.id_venta", $idVenta);

		if ($idAbono > 0) {
			$query->where("abonosventas.id", $idAbono);
		}

		$dataAccountBill = $query->findAll();

		$structurePrint = '';

		foreach ($dataAccountBill as $value) {

			$estrucPdf = '<div style="margin-bottom: 10px;">' . $this->estructuraReporte("Recibo_Caja") . '</div>';

			$estrucPdf = $this->setValuesCompany($estrucPdf, 30, 30);

			$estrucPdf = str_replace("{numeracion}", $value->numeracion, $estrucPdf);
			$estrucPdf = str_replace("{fechaCreacion}", $value->fechaCreacion, $estrucPdf);
			$estrucPdf = str_replace("{totalGeneral}", '$ ' . number_format($value->totalGeneral, 0, ',', '.'), $estrucPdf);

			$f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
			$estrucPdf = str_replace("{valorEnLetras}", ucfirst($f->format($value->totalGeneral)), $estrucPdf);

			$resultado = array_filter(TIPOSABONO, function($producto) use ($value) {
				return $producto['valor'] == $value->tipoAbonoDP;
			});
			$productoBuscado = reset($resultado);

			$estrucPdf = str_replace("{tipoPago}", $productoBuscado['titulo'], $estrucPdf);

			$dataVenta = $this->cargarDataVenta($estrucPdf, $idVenta, "ventas");
			$estrucPdf = $dataVenta['pdf'];

			$estrucPdf = str_replace("{numeroFactura}", $dataVenta['codigo'], $estrucPdf);

			$structurePrint .= $estrucPdf;
		}

		$pdf = $this->initPdf();

		$datos = $this->mConfiguracion
			->select("valor")
			->where('campo', 'logoEmpresa')
			->get()->getResult();
			
		if (count($datos) > 0) {
		    $datos = $datos[0];
		} else {
		    $datos = (object) ["valor" => null];
		}

		$pdf->writeHTML($structurePrint, false, false, false, false, '');

		$imageWater = $datos->valor;
		if (is_null($datos->valor) || $datos->valor == '') {
			$imageWater = base_url("assets/img/logo-negro-bloque.jpg");
		}

		// Agregar marca de agua como imagen
		$pdf->SetAlpha(0.1); // Hacer la imagen semitransparente (ajustar la transparencia según lo necesario)
		for ($y = 0; $y < 210; $y += 60) { // Repetir verticalmente
			for ($x = 0; $x < 210; $x += 60) { // Repetir horizontalmente
				// Insertar la imagen de marca de agua en cada posición de la cuadrícula
				$pdf->Image(UPLOADS_CONF_PATH . $imageWater, $x, $y, 70, 50, '', '', '', false, 300, '', false, false, 0);
			}
		}

		$ventaFind = $this->db->table("ventas")->select("ventas.codigo")->where("ventas.id", $idVenta)->get()->getResultObject()[0];

		$pdf->setTitle('Abonos Factura ' . $ventaFind->codigo . ' | ' . session()->get("nombreEmpresa"));
		$pdf->Output($ventaFind->codigo . ".pdf", 'I');
		exit;
	}

}
