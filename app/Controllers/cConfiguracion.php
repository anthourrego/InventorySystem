<?php

namespace App\Controllers;

use \Config\Services;
use App\Controllers\BaseController;
use App\Models\mConfiguracion;
use App\Models\mPedidos;
use App\Models\mVentas;

class cConfiguracion extends BaseController {
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
    ],
    "Pedido" => [
      "icono" => "fa-solid fa-boxes-stacked",
      "color" => "secondary",
    ],
    "Rotulo" => [
      "icono" => "fa-solid fa-tags",
      "color" => "info",
    ],
    "Envio" => [
      "icono" => "fa-solid fa-paper-plane",
      "color" => "success",
    ]
  ];

	private $variables = [
    "logoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Logo de la empresa"
    ],
    "nombreEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Nombre de la empresa"
    ],
    "digitoVeriEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Digito de verificación de la empresa"
    ],
    "direccionEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Dirección de la empresa"
    ],
    "telefonoEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Telefono de la empresa"
    ],
    "emailEmpresa" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Correo electrónico de la empresa"
    ],
    "numeracion" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Consecutivo de documento"
    ],
    "nombreSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Nombre de la sucursal"
    ],
    "nombreCliente" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Nombre del cliente"
    ],
    "fechaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Fecha de generación del documento"
    ],
    "horaCreacion" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Hora de generación del documento"
    ],
    "direccionSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Dirección de la sucursal"
    ],
    "telefonoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Telefono de la sucursal"
    ],
    "barrioSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Barrio de la sucursal"
    ],
    "adminSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Administrador de la sucursal"
    ],
    "carteraSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Cartera de la sucursal"
    ],
    "telCartSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Telefono cartera de la sucursal"
    ],
    "ciudadSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
      "descripcion" => "Ciudad de la sucursal"
    ],
    "deptoSucursal" => [
      "aplica" => ["Factura", "Pedido", "Rotulo", "Envio"],
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
    "cantPacaProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Cantidad paca del producto"
    ],
    "paqueteProductoDP" => [
      "aplica" => ["Factura", "Pedido"],
      "descripcion" => "Cantidad paca x cantidad solicitada del producto"
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
    "numeroCajaDP" => [
      "aplica" => ["Factura"],
      "descripcion" => "Caja del producto"
    ],
    "totalCajas" => [
      "aplica" => ["Envio"],
      "descripcion" => "Total de cajas para el pedido"
    ],
    "costoEnvio" => [
      "aplica" => ["Envio"],
      "descripcion" => "Valor envio productos"
    ],
    "imagenQR" => [
      "aplica" => ["Rotulo"],
      "descripcion" => "Imagen del Qr para descarga de la factura"
    ]
  ];

	public function index($tab = null) {
		$this->content['title'] = "Configuración";
		$this->content['view'] = "vConfiguracion";

		//Validación de reportes
		$this->content['variables'] = $this->variables;
    $this->content['reportes'] = $this->reportes;
    $this->content['instrucciones'] = $this->instrucciones;

		if (!file_exists(UPLOADS_REPOR_PATH)) {
      mkdir(UPLOADS_REPOR_PATH);
    }

		$this->LSelect2();
		$this->LDataTables();

		//Tab si viene de la url
		$this->content["tab"] = $tab;

		$this->content["editar"] = validPermissions([71], true);

		$this->content['js_add'][] = [
			'jsConfiguracion.js',
			'jsModificarReporte.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function datos(){
		$resp["success"] = true;
		$mConfiguracion = new mConfiguracion();

		$resp["msj"] = $mConfiguracion->select("campo, valor")->findAll();

		return $this->response->setJSON($resp);
	}

	public function actualizar(){
		$resp["success"] = false;
		$dataPost = $this->request->getPost();

		$mConfiguracion = new mConfiguracion();

		$validar = $mConfiguracion->where('campo', $dataPost["campo"])->first();

		$dataSave = [
			"campo" => $dataPost["campo"],
			"valor" => $dataPost["valor"]
		];

		if($this->request->getFile($dataPost["campo"])) {

			$filenameDelete = UPLOADS_CONF_PATH . $dataPost["campo"];

			$file = $this->request->getFile($dataPost["campo"]);

			if (!empty($file->getBasename())) {

				// Validamos el archivo
				$validated = $this->validate([
					'rules' => [
						'uploaded[' . $dataPost["campo"] . ']',
						'mime_in[' . $dataPost["campo"] . ',image/jpg,image/jpeg,image/gif,image/png]',
						'max_size[' . $dataPost["campo"] . ',2048]',
					],
				]);
								
				//Se valida los datos de la imagen
				if ($validated) {
					if ($file->isValid() && !$file->hasMoved()) {
						//Validamos que la imagen suba correctamente
						$dataSave['valor'] = $dataPost["campo"] . '.' . $file->guessExtension();
						if ($file->move(UPLOADS_CONF_PATH, $dataSave['valor'], true)) {
							if ($dataSave["campo"] == "logoEmpresa") {
								Services::image()
									->withFile(UPLOADS_CONF_PATH . $dataSave['valor'])
									->resize(180, 180, true, 'height')
									->convert(IMAGETYPE_PNG)
									->save(UPLOADS_CONF_PATH . 'logoEmpresa-small.png');
							}

							$resp["file"] = $dataSave['valor'];
							$resp["msj"] = "Archivo <b>{$dataPost['nombre']}</b> se creo correctamente.";
						} else {
							$resp["msj"] = "Ha ocurrido un error al subir el archivo <b>{$dataPost['nombre']}</b>.";
						}
					} else {
						$resp["msj"] = "Error al subir el archivo <b>{$dataPost['nombre']}</b>, {$file->getErrorString()}";
					}
				} else {
					$resp["msj"] = "Error al subir el archivo <b>{$dataPost['nombre']}</b> " . trim(str_replace("rules", "", $this->validator->getErrors()["rules"])); 
				}
			}
			//Validamos para eliminar la foto
			if ($filenameDelete != '' && file_exists($filenameDelete)) {
				if(!@unlink($filenameDelete)) {
					$resp["success"] = false;
					$resp["msj"] = "Error al eliminar el archivo <b>{$dataPost['nombre']}</b>, intente de nuevo";
				} 
			}
		}
		
		if (!is_null($validar)) {
			$dataSave["id"] = $validar->id;
		}

		if($mConfiguracion->save($dataSave)) {

      $registros = [];
      $tabla = '';

      if ($dataSave["campo"] == "digitosFact") {

        $ventaModel = new mVentas();
        $dataPref = (session()->has("prefijoFact") ? session()->get("prefijoFact") : '');
        
        $registros = $ventaModel
        ->select("
          SUBSTRING_INDEX(codigo, '$dataPref', -1) AS Delimitado, 
          ventas.id
        ")
        ->where("codigo LIKE '$dataPref%'")
        ->findAll();

        $tabla = 'ventas';

      } else if ($dataSave["campo"] == "digitosPed") {

        $pedidosModel = new mPedidos();
        $dataPref = (session()->has("prefijoPed") ? session()->get("prefijoPed") : '');

        $registros = $pedidosModel
        ->select("
          SUBSTRING_INDEX(pedido, '$dataPref', -1) AS Delimitado, 
          pedidos.id
        ")
        ->where("pedido LIKE '$dataPref%'")
        ->findAll();

        $tabla = 'pedidos';
      }

      if (count($registros) > 0) {
        foreach ($registros as $value) {
          $index = 0;
          foreach (str_split($value->Delimitado) as $llave2 => $value2) {
            if ((int) $value2 > 0) {
              $index = $llave2;
              break;
            }
          }
          
          $numeroActual = substr($value->Delimitado, $index);
          $padAgregar = str_pad($numeroActual, $dataPost["valor"], "0", STR_PAD_LEFT);
          
          $builder = $this->db->table($tabla)
            ->set(($tabla == 'ventas' ? 'codigo' : 'pedido'), "{$dataPref}{$padAgregar}")
            ->where('id', $value->id)->update();
        }
      }

			$resp["success"] = true;
			$resp["msj"] = "<b>{$dataPost['nombre']}</b> se actualizo correctamente.";
		}	else {
			$resp["msj"] = "Error al actualizar <b>{$dataPost['nombre']}</b>.";
		}	

		return $this->response->setJSON($resp);
	}

	public function foto($img = null){
		$filename = UPLOADS_CONF_PATH ."{$img}"; //<-- specify the image  file
		//Si la foto no existe la colocamos por defecto
		if(is_null($img) || !file_exists($filename)){ 
			$filename = ASSETS_PATH . "img/nofoto.png";
		}
		//$mime = mime_content_type($filename); //<-- detect file type
		header('Content-Length: '.filesize($filename)); //<-- sends filesize header
		header("Content-Type: image/png"); //<-- send mime-type header
		header("Content-Disposition: inline; filename='{$filename}';"); //<-- sends filename header
		readfile($filename); //<--reads and outputs the file onto the output buffer
		exit(); // or die()
	}

	public function eliminar() {
		$resp["success"] = true;
		$dataPost = $this->request->getPost();

		$mConfiguracion = new mConfiguracion();

		$validar = $mConfiguracion->where('campo', $dataPost["file"])->first();

		$filenameDelete = UPLOADS_CONF_PATH . $validar->valor;
		if ($filenameDelete != '' && file_exists($filenameDelete)) {
			if(!@unlink($filenameDelete)) {
				$resp["success"] = false;
				$resp["msj"] = "Error al eliminar el archivo <b>{$dataPost['nombre']}</b>, intente de nuevo";
			} else {
				$builder = $this->db->table('configuracion')->set("valor", '')->where('campo', $dataPost["file"]);
				if($builder->update()) {
					$resp["success"] = true;
					$resp["msj"] = "<b>{$dataPost['nombre']}</b>, eliminado correctamente";
				} else {
					$resp["msj"] = "Error al eliminar <b>{$dataPost['nombre']}</b>.";
				}	
			}
		}
		return $this->response->setJSON($resp);
	}
}
