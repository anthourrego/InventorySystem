<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use stdClass;

class Membresia extends BaseController
{
	public $planDias = [
		'1' => 30,
		'2' => 30,
		'3' => 90,
		'4' => 180,
		'5' => 30,
		'6' => 360,
		'7' => 1,
		'8' => 30,
		'10' => 30,
		'11' => 7,
		'12' => 15,
		'13' => 30,
		'14' => 30,
	];

	public function index() {
		$this->content['title'] = "Membresias";
		$this->content['view'] = "vMembresia";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();
		$this->LBsCustomFileInput();

		$this->content['js_add'][] = [
			'jsMembresia.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function ImportarExcel(){
		$resp["success"] = false;
		$resp["msj"] = "Ha ocurrido un error al leer el archivo de excel.";
		$resp["data"] = [];
		$archivoExcel = $this->request->getFile("excelFile");
		$membresiaImportar = [];

		if (!empty($archivoExcel->getBasename())) {
			//Validamos la foto
			$validated = $this->validate([
				'rules' => [
					'uploaded[excelFile]',
					'mime_in[excelFile,application/vnd.ms-excel,xls,csv,application/xml,application/zip,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vn.openxmlformats-officedocument.spreadsheetml.sheet]',
					'max_size[excelFile,50480]',
				],
			]);

			if ($validated) { 
				if ($archivoExcel->isValid() && !$archivoExcel->hasMoved()) {
					$ruta = UPLOADS_PEDIDOS_PATH ."/";
					if (!file_exists($ruta)) {
						mkdir($ruta, 0777, true);
					}

					$name = explode('.', $archivoExcel->getClientName());
					$name = str_replace(' ', '_', $name[0]) . "." . $archivoExcel->getClientExtension();

					if ($archivoExcel->move(UPLOADS_PEDIDOS_PATH, $name, true)) {
						$rutaExcel = UPLOADS_PEDIDOS_PATH . "/". $name;

						/**  Identify the type of $inputFileName  **/
						$inputFileType = IOFactory::identify($rutaExcel);
						/**  Create a new Reader of the type that has been identified  **/
						$reader = IOFactory::createReader($inputFileType);
						/**  Load $inputFileName to a Spreadsheet Object  **/
						$reader->setReadDataOnly(true);
						$spreadsheet = $reader->load($rutaExcel);

						$totalrows = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();
						$hojadeExcel = $spreadsheet->setActiveSheetIndex(0);

						$errores = "";
						if (($totalrows - 3) > 0) {

							$formatearFecha = function($valor, $formato = 'Y-m-d') {
								if (is_numeric($valor)) {
									// Convertir el número de Excel a una fecha de PHP
									return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($valor)->format($formato);
								} elseif (is_string($valor) && preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}$/', $valor)) {
									// Si es una cadena con formato de fecha (como "01/05/25"), convertir a formato estándar
									$fecha = \DateTime::createFromFormat('d/m/y', $valor);
									if ($fecha) {
										return $fecha->format($formato);
									}
								}
								return $valor;
							};
							

							for ($i=4; $i <= $totalrows; $i++) { 
								$fila = new stdClass();
										// Función para convertir valores numéricos de Excel a fechas
								
								$fila->planId = trim($hojadeExcel->getCell("A".$i)->getValue());
								$fila->plan = trim($hojadeExcel->getCell("B".$i)->getValue());
								$fila->documento = trim($hojadeExcel->getCell("C".$i)->getValue());
								$fila->fechaAfiliacion = $formatearFecha(trim($hojadeExcel->getCell("D".$i)->getValue()), 'Y-m-d');
								$fila->fechaInicio = $formatearFecha(trim($hojadeExcel->getCell("E".$i)->getValue()), 'Y-m-d');
								$fila->fechaPago = $formatearFecha(trim($hojadeExcel->getCell("G".$i)->getValue()), 'Y-m-d');
								$fila->idAfiliado = trim($hojadeExcel->getCell("H".$i)->getValue());
								$fila->Afiliado = trim($hojadeExcel->getCell("I".$i)->getValue());
								$fila->valorPagado = trim($hojadeExcel->getCell("J".$i)->getValue());
								$fila->efectivo = trim($hojadeExcel->getCell("K".$i)->getValue());
								$fila->tarjeta = trim($hojadeExcel->getCell("L".$i)->getValue());
								$fila->transferencia = trim($hojadeExcel->getCell("M".$i)->getValue());
								$fila->cuentasxCobrar = trim($hojadeExcel->getCell("N".$i)->getValue());
								$fila->celular = trim($hojadeExcel->getCell("P".$i)->getValue());
								$fila->correo = trim($hojadeExcel->getCell("Q".$i)->getValue());
								$fila->nroPagos = trim($hojadeExcel->getCell("R".$i)->getValue());								$fila->porceDecuento = trim($hojadeExcel->getCell("S".$i)->getValue());
								
								// Comentamos el var_dump y exit para permitir continuar con el proceso
								$membresiaImportar[] = $fila;

								/* $referencia = trim($hojadeExcel->getCell("A".$i)->getValue());
								$cantidad = trim($hojadeExcel->getCell("B".$i)->getValue());
								$precio = trim($hojadeExcel->getCell("C".$i)->getValue()); */

								/* if (strlen($referencia) > 0 && strlen($cantidad) > 0 && $cantidad > 0) {
									$fila = $producto->detalleProducto($referencia); 
									if (!is_null($fila)) {
										if ($cantidad <= $fila->stock) {
											$fila->cantidad = $cantidad;

											if (strlen($precio) >= 0 && $precio != '' && $precio > 0) {
												$fila->precio_venta = $precio;
												$fila->valorUnitario = $precio;
											}

											$membresiaImportar[] = $fila;
										} else {
											$errores .= "<li><b>{$referencia}</b> el inventario solicitado es {$cantidad} de {$fila->stock} disponible.</li>";
										}
									} else {
										$errores .= "<li><b>{$referencia}</b> no se encontro en la base de datos.</li>";
									}
								} */
							}
						}

						if ($errores == "") {
							if (count($membresiaImportar) > 0) {
								$resp["success"] = true;
								$resp["data"] = $membresiaImportar;
							} else {
								$resp["msj"] = "No se han encontrado membresias para ser cargados";	
							}
						} else {
							$resp["msj"] = "<ul>{$errores}</ul>";
						}

					} else {
						$resp["msj"] = "Ha ocurrido un error al subir el pedido de excel.";
					}
				} else {
					$resp["msj"] = "Error al subir el excel, {$archivoExcel->getErrorString()}";
				}
			} else {
				$resp["msj"] = "Error al subir el excel, " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
			}
		}
		return $this->response->setJSON($resp);
	}
}
