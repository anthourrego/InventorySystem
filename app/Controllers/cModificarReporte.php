<?php

namespace App\Controllers;

class cModificarReporte extends BaseController {

  private $instrucciones = [
    "[HEAD HEAD] - Encabezado del reporte"
    , "[BODY BODY] - Contenido del reporte"
    , "[FOOTER FOOTER] - Pie de pagina del reporte"
    , "[DP DP] - Lista detallada de productos"
  ];

  private $reportes = [
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
    ]
  ];

	private $variables = [
    "logoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Logo de la empresa"
    ],
    "nombreEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Nombre de la empresa"
    ],
    "digitoVeriEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Digito de verificación de la empresa"
    ],
    "direccionEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Dirección de la empresa"
    ],
    "telefonoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Telefono de la empresa"
    ],
    "emailEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Correo electrónico de la empresa"
    ],
    "numeracion" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Consecutivo de documento"
    ],
    "nombreSucursal" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Nombre de la sucursal"
    ],
    "nombreCliente" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Nombre del cliente"
    ],
    "fechaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Fecha de generación del documento"
    ],
    "direccionSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Dirección de la sucursal"
    ],
    "telefonoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Telefono de la sucursal"
    ],
    "ciudadSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Ciudad de la sucursal"
    ],
    "deptoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo"],
      "descripcion" => "Departamento de la sucursal"
    ],
    "nombreVendedor" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Nombre del vendedor"
    ],
    "itemProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Número de item del producto"
    ],
    "referenciaProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Referencia del producto"
    ],
    "descripcionProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Descripcion del producto"
    ],
    "cantidadProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Cantidad solicitada del producto"
    ],
    "valorProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Valor de venta del producto"
    ],
    "totalProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Total por producto"
    ],
    "totalGeneral" => [
      "aplica" => ["Factura", "Pedido"],
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
      "aplica" => ["Pedido", "Factura", "Rotulo"],
      "descripcion" => "Observación del reporte"
    ],
    "numeroRotulo" => [
      "aplica" => ["Rotulo"],
      "descripcion" => "Numeración secuencial del rotulo"
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
      } catch(Exception $e) {
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
    } catch(Exception $e) {
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
    } catch(Exception $e) {
      $resp["success"] = false;
      $resp["msj"] = "No fue posible guardar el reporte";
    }

    return $this->response->setJSON($resp);
  }

}
