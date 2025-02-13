<?php

namespace App\Controllers;

class cModificarReporte extends BaseController {

  public $instrucciones = [
    "[HEAD HEAD] - Encabezado del reporte"
    , "[BODY BODY] - Contenido del reporte"
    , "[FOOTER FOOTER] - Pie de pagina del reporte"
    , "[DP DP] - Lista detallada de productos"
  ];

  public $reportes = [
    "Factura" => [
      "icono" => "fa-solid fa-store",
      "color" => "#007bff",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Pedido" => [
      "icono" => "fa-solid fa-boxes-stacked",
      "color" => "#6c757d",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Rotulo" => [
      "icono" => "fa-solid fa-tags",
      "color" => "#17a2b8",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Envio" => [
      "icono" => "fa-solid fa-paper-plane",
      "color" => "#28a745",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Empaque" => [
      "icono" => "fa-solid fa-file-invoice",
      "color" => "#ffc107",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Compra" => [
      "icono" => "fa-solid fa-dollar",
      "color" => "#343a40",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Sticker" => [
      "icono" => "fa-solid fa-note-sticky",
      "color" => "#dc3545",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Ing_Mercancia" => [
      "icono" => "fa-solid fa-arrow-up-right-dots",
      "color" => "#4ba7a7",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Cuenta_Cobrar" => [
      "icono" => "fa-solid fa-file-invoice-dollar",
      "color" => "#d3d0a4",
      "color-text" => "#ffffff",
      "url" => ""
    ],
    "Recibo_Caja" => [
      "icono" => "fa-solid fa-money-check",
      "color" => "#d3a4cd",
      "color-text" => "#ffffff",
      "url" => ""
    ]
  ];

	public $variables = [
    "logoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Logo de la empresa"
    ],
    "nombreEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Nombre de la empresa"
    ],
    "digitoVeriEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Digito de verificación de la empresa"
    ],
    "direccionEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Dirección de la empresa"
    ],
    "telefonoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Telefono de la empresa"
    ],
    "emailEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Correo electrónico de la empresa"
    ],
    "numeracion" => [
      "aplica" => ["Factura", "Pedido", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Consecutivo de documento"
    ],
    "nombreSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Nombre de la sucursal"
    ],
    "nombreCliente" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Nombre del cliente"
    ],
    "fechaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Fecha de generación del documento"
    ],
    "horaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Hora de generación del documento"
    ],
    "direccionSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Dirección de la sucursal"
    ],
    "telefonoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Telefono de la sucursal"
    ],
    "barrioSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Barrio de la sucursal"
    ],
    "adminSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Administrador de la sucursal"
    ],
    "carteraSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Cartera de la sucursal"
    ],
    "telCartSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Telefono cartera de la sucursal"
    ],
    "ciudadSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Recibo_Caja"],
      "descripcion" => "Ciudad de la sucursal"
    ],
    "deptoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Recibo_Caja"],
      "descripcion" => "Departamento de la sucursal"
    ],
    "nombreVendedor" => [
      "aplica" => ["Factura", "Pedido", "Empaque", "Compra", "Ing_Mercancia", "Cuenta_Cobrar"],
      "descripcion" => "Nombre del vendedor"
    ],
    "itemProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Ing_Mercancia"],
      "descripcion" => "Número de item del producto"
    ],
    "referenciaProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker", "Ing_Mercancia"],
      "descripcion" => "Referencia del producto"
    ],
    "descripcionProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker", "Ing_Mercancia"],
      "descripcion" => "Descripcion del producto"
    ],
    "cantPacaProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker"],
      "descripcion" => "Cantidad paca del producto"
    ],
    "paqueteProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra"],
      "descripcion" => "Cantidad paca x cantidad solicitada del producto"
    ],
    "valorProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker"],
      "descripcion" => "Valor de venta del producto"
    ],
    "totalProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra"],
      "descripcion" => "Total por producto"
    ],
    "totalGeneral" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Cuenta_Cobrar", "Recibo_Caja"],
      "descripcion" => "Valor total de la venta"
    ],
    "ubicacionProductoDP" => [
      "aplica" => ["Pedido"],
      "descripcion" => "Ubicación del producto"
    ],
    "manifiestoProductoDP" => [
      "aplica" => ["Pedido"],
      "descripcion" => "Manifiesto del producto"
    ],
    "observacion" => [
      "aplica" => ["Pedido", "Factura", "Rotulo", "Empaque", "Compra", "Ing_Mercancia",],
      "descripcion" => "Observación del reporte"
    ],
    "numeroRotulo" => [
      "aplica" => ["Rotulo"],
      "descripcion" => "Numeración secuencial del rotulo"
    ],
    "numeroCajaDP" => [
      "aplica" => ["Factura"],
      "descripcion" => "Caja del producto"
    ],
    "totalCajas" => [
      "aplica" => ["Envio", "Empaque"],
      "descripcion" => "Total de cajas para el pedido"
    ],
    "costoEnvio" => [
      "aplica" => ["Envio"],
      "descripcion" => "Valor envio productos"
    ],
    "imagenQR" => [
      "aplica" => ["Rotulo"],
      "descripcion" => "Imagen del Qr para descarga de la factura"
    ],
    "fechaIniEmpa" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Fecha inicio del empaque de los productos del pedido"
    ],
    "horaIniEmpa" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Hora inicio del empaque de los productos del pedido"
    ],
    "fechaFinEmpa" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Fecha final del empaque de los productos del pedido"
    ],
    "horaFinEmpa" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Hora final del empaque de los productos del pedido"
    ],
    "tiempoEmpa" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Tiempo de empaque de los productos del pedido"
    ],
    "numeroCajaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Número de caja del pedido"
    ],
    "empacadorCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Nombre persona empaco la caja"
    ],
    "fechaIniEmpaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Fecha inicio de empaque de caja"
    ],
    "horaIniEmpaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Hora inicio de empaque de caja"
    ],
    "fechaFinEmpaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Fecha fin de empaque de caja"
    ],
    "horaFinEmpaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Hora fin de empaque de caja"
    ],
    "tiempoEmpaCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Tiempo de empaque de la caja"
    ],
    "totalRefsCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Total de referencias dentro de la caja"
    ],
    "totalProdsCJ" => [
      "aplica" => ["Empaque"],
      "descripcion" => "Total de productos dentro de la caja"
    ],
    "estadoRegistro" => [
      "aplica" => ["Compra", "Ing_Mercancia"],
      "descripcion" => "Estado de la informacion cargada"
    ],
    "proveedor" => [
      "aplica" => ["Compra"],
      "descripcion" => "Proveedor de la compra"
    ],
    "fechaVencimiento" => [
      "aplica" => ["Factura"],
      "descripcion" => "Fecha de vencimiento de la factura"
    ],
    "totalSinDescuento" => [
      "aplica" => ["Factura"],
      "descripcion" => "Valor de la factura sin el descuento"
    ],
    "descuento" => [
      "aplica" => ["Factura"],
      "descripcion" => "Descuento aplicado a la factura"
    ],
    "codigoAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Código de abono a la factura"
    ],
    "valorAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Valor del abono a la factura"
    ],
    "observacionAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Observación de abono a la factura"
    ],
    "estadoAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Estado de abono a la factura"
    ],
    "usuarioAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Usuario registro abono a la factura"
    ],
    "fechaAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Fecha de registro de abono a la factura"
    ],
    "tipoAbonoDP" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Tipo de abono a la factura"
    ],
    "totalAbono" => [
      "aplica" => ["Cuenta_Cobrar"],
      "descripcion" => "Total de abonos a la factura"
    ],
    "tipoPago" => [
      "aplica" => ["Recibo_Caja"],
      "descripcion" => "Tipo de pago del recibo de caja"
    ],
    "numeroFactura" => [
      "aplica" => ["Recibo_Caja"],
      "descripcion" => "Número de factura en el recibo de caja"
    ],
    "valorEnLetras" => [
      "aplica" => ["Recibo_Caja"],
      "descripcion" => "Valor del documento en letras"
    ]
  ];

	public function index() {
    $this->content['title'] = "Modificar Reporte";
		$this->content['view'] = "vModificarReporte";

		$this->LDataTables();

		$this->content['js_add'][] = [
			'jsModificarReporte.js'
		];

    $this->content['variables'] = $this->variables;

    $this->content['reportes'] = $this->reportes;

    $this->content['instrucciones'] = $this->instrucciones;

    if (!file_exists(UPLOADS_REPOR_PATH)) {
      mkdir(UPLOADS_REPOR_PATH);
    }

		return view('UI/viewDefault', $this->content);
  }

  public function reporte($reporte) {
    
    $datReporte = [];
    if (isset($this->reportes[$reporte])) {
      $datReporte = $this->reportes[$reporte];
    }
    $this->content['datReporte'] = $datReporte;
    $this->content['reporte'] = $reporte;

    $this->content['title'] = "Modificar Reporte " . $reporte;
		$this->content['view'] = "vModificarEstructuraReporte";

		$this->content['js_add'][] = [
			'jsModificarEstructuraReporte.js'
		];

    $this->LTinymceEditor();

    $this->content['variables'] = [];
    $this->content['contenidoEditor'] = '';
    if (isset($datReporte["url"])) {
      $this->content['variables'] = array_filter($this->variables, function ($it) use ($reporte) {
        return in_array($reporte, $it["aplica"]);
      });
      $this->content['contenidoEditor'] = '';
      $path = UPLOADS_REPOR_PATH . str_replace(" ", "_", $reporte) . ".txt";

      try {
        if (file_exists($path)) {
          $arrContextOptions = array(
            "ssl"=>array(
              "verify_peer"=>false,
              "verify_peer_name"=>false,
            ),
          );
          $this->content['contenidoEditor'] = file_get_contents($path, false, stream_context_create($arrContextOptions));
        } else {
          $this->content['contenidoEditor'] = '';
        }
      } catch(\Exception $e) {
        $this->content['contenidoEditor'] = '';
      }
    }

    $this->content['instrucciones'] = $this->instrucciones;

		return view('UI/viewDefault', $this->content);
  }

  public function guardar() {
    $resp["success"] = true;
    $resp["msj"] = "Reporte guardado correctamente";
    $postData = (object) $this->request->getPost();

    $path = UPLOADS_REPOR_PATH . str_replace(" ", "_", $postData->reporte) . ".txt";

    try {
      file_put_contents($path, $postData->contenido);
    } catch(\Exception $e) {
      $resp["success"] = false;
      $resp["msj"] = "No fue posible guardar el reporte";
    }

    return $this->response->setJSON($resp);
  }

  public function plantilla() {
    $resp["success"] = true;
    $resp["msj"] = "Reporte reemplazado con éxito";
    $postData = (object) $this->request->getPost();

    $path1 = REPOR_BASE_PATH . $postData->reporte . ".txt";
    $path2 = UPLOADS_REPOR_PATH . $postData->reporte . ".txt";

    try {
      $valid = copy($path1, $path2);
      if ($valid != true) {
        $resp["success"] = false;
        $resp["msj"] = "No fue posible guardar el reporte";
      }
    } catch(\Exception $e) {
      $resp["success"] = false;
      $resp["msj"] = "No fue posible guardar el reporte";
    }

    return $this->response->setJSON($resp);
  }

}
