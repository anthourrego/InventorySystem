<?php

namespace App\Controllers;

class cModificarReporte extends BaseController {

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
    ]
  ];

  /* 
    pos1 => Factura,
    pos2 => Pedido
  */
	private $variables = [
    "logo" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Logo de la empresa"
    ],
    "nombreEmpresa" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Nombre de la empresa"
    ],
    "digitoVerifiEmpresa" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Digito de verificación de la empresa"
    ],
    "direccionEmpresa" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Dirección de la empresa"
    ],
    "telefonoEmpresa" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Telefono de la empresa"
    ],
    "emailEmpresa" => [
      "aplica" => ["Factura", "Pedido"],
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
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Nombre del cliente"
    ],
    "fechaCreacion" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Fecha de generación del documento"
    ],
    "direccionSucursal" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Dirección de la sucursal"
    ],
    "telefonoSucursal" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Telefono de la sucursal"
    ],
    "ciudadSucursal" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Ciudad de la sucursal"
    ],
    "deptoSucursal" => [
      "aplica" => ["Factura", "Pedido"],
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
  ];

	function index() {
    $this->content['title'] = "Modificar Reporte";
		$this->content['view'] = "vModificarReporte";

		$this->LDataTables();
		$this->LMoment();

		$this->content['js_add'][] = [
			'jsModificarReporte.js'
		];

    $this->content['variables'] = $this->variables;

    $this->content['reportes'] = $this->reportes;


		return view('UI/viewDefault', $this->content);
  }

}
