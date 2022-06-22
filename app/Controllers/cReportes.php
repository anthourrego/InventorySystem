<?php

namespace App\Controllers;
use TCPDF;
use App\Models\mVentas;
use App\Models\mVentasProductos;

class cReportes extends BaseController {

	public function factura($id){
		$mVentas = new mVentas();
		$mVentasProductos = new mVentasProductos();
		
		$rutaLogo = base_url("assets/img/logo-negro-bloque.jpg");


		$datosFactura = $mVentas->cargarVenta($id)[0];

		$productosFactura = $mVentasProductos->select("
														P.referencia,
														P.item,
														P.descripcion,
														ventasproductos.cantidad,
														ventasproductos.valor,
														(ventasproductos.cantidad * ventasproductos.valor) AS Total
													")->join("productos AS P", "ventasproductos.id_producto = P.id", "left")
													->where("id_venta", $id)
													->findAll();

		$fecha = date("d/m/Y", strtotime($datosFactura->created_at));
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();

		// ---------------------------------------------------------

		$bloque1 = <<<EOF

			<table>	
				<tr>
					<td style="width:130px"><img src="$rutaLogo"></td>
					<td style="background-color:white; width:240px">
						<div style="font-size:10px; text-align:center; line-height:15px;">
							<br>
							NIT: 1088247875-1
							<br>
							Dirección: Carrera 12 sur # 8 - 51 Quebrada seca Guadalajara de Buga
							<br>
							Teléfono: 318 873 2564
							<br>
							importadoragomari@gmail.com
						</div>
					</td>

					<td style="background-color:white; width:150px; text-align:center; color:red"><br><br>ORDEN DE COMPRA N.<br>00$datosFactura->codigo</td>

				</tr>
			</table>

		EOF;

		$pdf->writeHTML($bloque1, false, false, false, false, '');

		// ---------------------------------------------------------

		$bloque2 = <<<EOF

			<table>
				<tr>
					<td style="width:540px"><img src="images/back.jpg"></td>
				</tr>
			</table>

			<table style="font-size:10px; padding:5px 10px;">
			
				<tr>
					<td style="border: 1px solid #666; background-color:white; width:390px">
						Cliente: $datosFactura->NombreCliente
					</td>

					<td style="border: 1px solid #666; background-color:white; width:150px; text-align:left">
						Fecha: $fecha
					</td>
				</tr>
				<tr>
					<td style="border: 1px solid #666; background-color:white; width:390px">
						Direccion: $datosFactura->Direccion
					</td>
					<td style="border: 1px solid #666; background-color:white; width:150px; text-align:left">
						Telefono: $datosFactura->telefono
					</td>
				</tr>
				<tr>
					<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $datosFactura->NombreVendedor</td>
				</tr>
				<tr>
					<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
				</tr>

			</table>

		EOF;

		$pdf->writeHTML($bloque2, false, false, false, false, '');
		// ---------------------------------------------------------

		$bloque3 = <<<EOF

			<table style="font-size:10px; padding:2px 7px;">

				<tr>
					
					<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Item</td>
					<td style="border: 1px solid #666; background-color:white; width:280px; text-align:center">Descripcion</td>
					<td style="border: 1px solid #666; background-color:white; width:40px; text-align:center">Und</td>
					<td style="border: 1px solid #666; background-color:white; width:60px; text-align:center">Valor Unit</td>
					<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Valor Total</td>
				</tr>

			</table>

		EOF;

		$pdf->writeHTML($bloque3, false, false, false, false, '');


		foreach ($productosFactura as $it) {
			$bloque4 = <<<EOF

				<table style="font-size:10px; padding:3px 3px;">

					<tr>

						<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:left">
							$it->item
						</td>

						<td style="border: 1px solid #666; color:#333; background-color:white; width:280px; text-align:left">
							$it->referencia - $it->descripcion
						</td>

						<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:center">
							$it->cantidad
						</td>

						<td style="border: 1px solid #666; color:#333; background-color:white; width:60px; text-align:right">$ 
							$it->valor
						</td>

						<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:right">$ 
							$it->Total
						</td>

					</tr>

				</table>

			EOF;

			$pdf->writeHTML($bloque4, false, false, false, false, '');
		}

		// ---------------------------------------------------------

		$bloque5 = <<<EOF

			<table style="font-size:10px; padding:5px 3px;">

				<tr>
					<td style="color:#333; background-color:white; width:340px; text-align:center"></td>
				</tr>

				<tr>
					<td style="border-right: 1px solid #666; color:#333; background-color:white; width:360px; text-align:center"></td>
					<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
						Total:
					</td>
					<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:right">$ 
						$datosFactura->total
					</td>
				</tr>

			</table>

		EOF;

		$pdf->writeHTML($bloque5, false, false, false, false, '');

		$pdf->Output("GOM00{$datosFactura->codigo}.pdf", 'I');
		exit;
	}

	public function pedido($id){
		$mVentas = new mVentas();
		$mVentasProductos = new mVentasProductos();
		
		$rutaLogo = base_url("assets/img/logo-negro-bloque.jpg");


		$datosFactura = $mVentas->cargarVenta($id)[0];

		$productosFactura = $mVentasProductos->select("
														P.referencia,
														P.item,
														P.descripcion,
														P.ubicacion,
														M.nombre AS manifiesto,
														ventasproductos.cantidad,
														ventasproductos.valor,
														(ventasproductos.cantidad * ventasproductos.valor) AS Total
													")->join("productos AS P", "ventasproductos.id_producto = P.id", "left")
													->join("manifiestos AS M", "P.id_manifiesto = M.id", "left")
													->where("id_venta", $id)
													->findAll();

		$fecha = date("d/m/Y", strtotime($datosFactura->created_at));
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();

		// ---------------------------------------------------------

		$bloque1 = <<<EOF
			<table>	
				<tr>
					<td style="width:130px"><img src="$rutaLogo"></td>
					<td style="background-color:white; width:240px">
						<div style="font-size:10px; text-align:center; line-height:15px;">
							<br>
							NIT: 1088247875-1
							<br>
							Dirección: Carrera 12 sur # 8 - 51 Quebrada seca Guadalajara de Buga
							<br>
							Teléfono: 318 873 2564
							<br>
							importadoragomari@gmail.com
						</div>
					</td>
					<td style="background-color:white; width:150px; text-align:center; color:red"><br><br>PEDIDO N.<br>00$datosFactura->codigo</td>
				</tr>
			</table>
		EOF;

		$pdf->writeHTML($bloque1, false, false, false, false, '');

		// ---------------------------------------------------------

		$bloque2 = <<<EOF
			<table>
				<tr>
					<td style="width:540px"><img src="images/back.jpg"></td>
				</tr>
			</table>

			<table style="font-size:10px; padding:5px 10px;">

				<tr>
					<td style="border: 1px solid #666; background-color:white; width:390px">
						Cliente: $datosFactura->NombreCliente
					</td>

					<td style="border: 1px solid #666; background-color:white; width:150px; text-align:left">
						Fecha: $fecha
					</td>
				</tr>

				<tr>
					<td style="border: 1px solid #666; background-color:white; width:390px">
						Direccion: $datosFactura->Direccion
					</td>

					<td style="border: 1px solid #666; background-color:white; width:150px; text-align:left">
						Telefono: $datosFactura->telefono
					</td>
				</tr>

				<tr>
					<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $datosFactura->NombreVendedor</td>
				</tr>

				<tr>
					<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
				</tr>

			</table>

		EOF;

		$pdf->writeHTML($bloque2, false, false, false, false, '');

		// ---------------------------------------------------------

		$bloque3 = <<<EOF

			<table style="font-size:10px; padding:3px 1px;">

				<tr>
				<td style="border: 1px solid #666; background-color:white; width:70px; text-align:center">Item</td>
				<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Descripcion</td>
				<td style="border: 1px solid #666; background-color:white; width:40px; text-align:center">Und</td>
				<td style="border: 1px solid #666; background-color:white; width:40px; text-align:center">Ubi</td>
				<td style="border: 1px solid #666; background-color:white; width:40px; text-align:center">Man</td>
				<td style="border: 1px solid #666; background-color:white; width:30px; text-align:center">Disp</td>
				<td style="border: 1px solid #666; background-color:white; width:30px; text-align:center">Rev</td>
				<td style="border: 1px solid #666; background-color:white; width:30px; text-align:center">Emp</td>
				</tr>

			</table>

		EOF;

		$pdf->writeHTML($bloque3, false, false, false, false, '');


		foreach ($productosFactura as $it) {
			$bloque4 = <<<EOF
				<table style="font-size:10px; padding:2px 7px;">
					<tr>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:70px; text-align:left">
							$it->item
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:left">
							$it->referencia - $it->descripcion
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:center">
							$it->cantidad
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:center">
							$it->ubicacion
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:center">
							$it->manifiesto
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:30px; text-align:center"></td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:30px; text-align:center"></td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:30px; text-align:center"> </td>
					</tr>
				</table>

			EOF;

			$pdf->writeHTML($bloque4, false, false, false, false, '');

			// ---------------------------------------------------------

			$bloque5 = <<<EOF
				<table style="font-size:10px; padding:5px 10px;">
					<tr>
						<td style="color:#333; background-color:white; width:350px; text-align:center"></td>
					</tr>

					<tr>
						<td style="border-right: 1px solid #666; color:#333; background-color:white; width:370px; text-align:center"></td>
						<td style="border: 1px solid #666; background-color:white; width:110px; text-align:center">
							Total Cajas:
						</td>
						<td style="border: 1px solid #666; color:#333; background-color:white; width:60px; text-align:right"></td>
					</tr>

				</table>
			EOF;

			$pdf->writeHTML($bloque5, false, false, false, false, '');

			// ---------------------------------------------------------

			//SALIDA DEL ARCHIVO 
			$pdf->Output("'Pedido00$datosFactura->codigo.pdf'", 'I');
			exit;
		}
	}
}
