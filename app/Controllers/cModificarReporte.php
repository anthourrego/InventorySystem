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
      "color" => "primary",
      "url" => ""
    ],
    "Pedido" => [
      "icono" => "fa-solid fa-boxes-stacked",
      "color" => "secondary",
      "url" => ""
    ],
    "Rotulo" => [
      "icono" => "fa-solid fa-tags",
      "color" => "info",
      "url" => ""
    ],
    "Envio" => [
      "icono" => "fa-solid fa-paper-plane",
      "color" => "success",
      "url" => ""
    ],
    "Empaque" => [
      "icono" => "fa-solid fa-file-invoice",
      "color" => "warning",
      "url" => ""
    ],
    "Compra" => [
      "icono" => "fa-solid fa-dollar",
      "color" => "dark",
      "url" => ""
    ],
    "Sticker" => [
      "icono" => "fa-solid fa-note-sticky",
      "color" => "danger",
      "url" => ""
    ]
  ];

	public $variables = [
    "logoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Logo de la empresa"
    ],
    "nombreEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Nombre de la empresa"
    ],
    "digitoVeriEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Digito de verificación de la empresa"
    ],
    "direccionEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Dirección de la empresa"
    ],
    "telefonoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Telefono de la empresa"
    ],
    "emailEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Correo electrónico de la empresa"
    ],
    "numeracion" => [
      "aplica" => ["Factura", "Pedido", "Empaque", "Compra"],
      "descripcion" => "Consecutivo de documento"
    ],
    "nombreSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Nombre de la sucursal"
    ],
    "nombreCliente" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Nombre del cliente"
    ],
    "fechaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
      "descripcion" => "Fecha de generación del documento"
    ],
    "horaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque", "Compra"],
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
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Ciudad de la sucursal"
    ],
    "deptoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio", "Empaque"],
      "descripcion" => "Departamento de la sucursal"
    ],
    "nombreVendedor" => [
      "aplica" => ["Factura", "Pedido", "Empaque", "Compra"],
      "descripcion" => "Nombre del vendedor"
    ],
    "itemProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra"],
      "descripcion" => "Número de item del producto"
    ],
    "referenciaProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker"],
      "descripcion" => "Referencia del producto"
    ],
    "descripcionProductoDP" => [
      "aplica" => ["Factura", "Pedido", "Compra", "Sticker"],
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
      "aplica" => ["Factura", "Pedido", "Compra"],
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
      "aplica" => ["Pedido", "Factura", "Rotulo", "Empaque", "Compra"],
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
      "aplica" => ["Compra"],
      "descripcion" => "Estado de la informacion cargada"
    ],
    "proveedor" => [
      "aplica" => ["Compra"],
      "descripcion" => "Proveedor de la compra"
    ],
  ];

	function index() {
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

  function reporte($reporte) {
    $reporte = str_replace("_", " ", $reporte);
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

    $this->LCKEditor();

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

  function guardar() {
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

  function plantilla() {
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
