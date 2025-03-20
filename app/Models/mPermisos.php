<?php

namespace App\Models;

use CodeIgniter\Model;

class mPermisos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'permisosusuarioperfil';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"usuarioId",    
		"perfilId",
		"permiso",
		"created_at",
		"updated_at"
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'         => "permit_empty|is_natural_no_zero",
		'usuarioId'  => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'perfilId'   => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[perfiles.id]',
		'permiso'    => 'required|numeric|min_length[1]|max_length[11]',
	];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	public function lista($validar = '') {
		$permisos = [
			[
				"id" => 1,
				"text" => "Usuarios",
				"uri" => "Usuarios",
				"icon" => "fas fa-users",
				"color" => "bg-primary",
				"children" => [
					[
						"id" => 11,
						"text" => "Crear"
					],
					[
						"id" => 12,
						"text" => "Editar"
					],
					[
						"id" => 13,
						"text" => "Cambiar contraseña"
					],
					[
						"id" => 14,
						"text" => "Activar/Inactivar"
					],
					[
						"id" => 15,
						"text" => "Permisos"
					]
				]
			],
			[
				"id" => 2,
				"text" => "Perfiles",
				"uri" => "Perfiles",
				"icon" => "fa-solid fa-address-book",
				"color" => "bg-secondary",
				"children" => [
					[
						"id" => 21,
						"text" => "Crear"
					],
					[
						"id" => 22,
						"text" => "Editar"
					],
					[
						"id" => 23,
						"text" => "Permisos"
					],
					[
						"id" => 24,
						"text" => "Activar/Inactivar"
					]
				]
			],
			[
				"id" => 3,
				"text" => "Categorias",
				"uri" => "Categorias",
				"icon" => "fa-brands fa-buffer",
				"color" => "bg-success",
				"children" => [
					[
						"id" => 31,
						"text" => "Crear"
					],
					[
						"id" => 32,
						"text" => "Editar"
					],
					[
						"id" => 33,
						"text" => "Activar/Inactivar"
					]
				]
			],
			[
				"id" => 4,
				"text" => "Clientes",
				"uri" => "Clientes",
				"icon" => "fa-solid fa-user-tie",
				"color" => "bg-danger",
				"children" => [
					[
						"id" => 41,
						"text" => "Crear"
					],
					[
						"id" => 42,
						"text" => "Editar"
					],
					[
						"id" => 43,
						"text" => "Activar/Inactivar"
					],
					[
						"id" => 44,
						"text" => "Sucursales",
						"children" => [
							[
								"id" => 441,
								"text" => "Crear"
							],
							[
								"id" => 442,
								"text" => "Editar"
							],
							[
								"id" => 443,
								"text" => "Activar/Inactivar"
							],	
						]
					]
				]
			],
			[
				"id" => 5,
				"text" => "Productos",
				"uri" => "Productos",
				"icon" => "fa-brands fa-product-hunt",
				"color" => "bg-warning",
				"children" => [
					[
						"id" => 51,
						"text" => "Crear"
					],
					[
						"id" => 52,
						"text" => "Editar"
					],
					[
						"id" => 53,
						"text" => "Activar/Inactivar"
					],
					[
						"id" => 54,
						"text" => "Ver valor inventario"
					],
					[
						"id" => 55,
						"text" => "Descargar fotos"
					],
					[
						"id" => 56,
						"text" => "Sincronizar fotos"
					],
					[
						"id" => 57,
						"text" => "Ver costo inventario"
					],
					[
						"id" => 58,
						"text" => "Plantilla excel"
					],
					[
						"id" => 59,
						"text" => "Modificar ubicación (Bodeguero)"
					],
					[
						"id" => 510,
						"text" => "Reporte de Empaque",
						"children" => [
							[
								"id" => 51001,
								"text" => "Confirmar Producto Reportado"
							]
						]
					],
				]
			],
			[
				"id" => 6,
				"text" => "Ventas",
				"uri" => "Ventas/Administrar",
				"icon" => "fa-solid fa-store",
				"color" => "bg-info",
				"children" => [
					[
						"id" => 61, // Para mostrar en la lista de vendedores
						"text" => "Es vendedor"
					],
					[
						"id" => 62,
						"text" => "Reporte de Empaque",
						"children" => [
							[
								"id" => 6201,
								"text" => "Confirmar Producto Reportado"
							]
						]
					],
				]
			],
			[
				"id" => 7,
				"text" => "Configuración",
				"uri" => "Configuracion",
				"icon" => "fa-solid fa-gear",
				"color" => "bg-light",
				"children" => [
					[
						"id" => 71,
						"text" => "Modificar"
					]
				]
			],
			[
				"id" => 8,
				"text" => "Manifiesto",
				"uri" => "Manifiesto",
				"icon" => "fa-solid fa-file",
				"color" => "bg-dark",
				"children" => [
					[
						"id" => 81,
						"text" => "Crear"
					],
					[
						"id" => 82,
						"text" => "Editar"
					],
					[
						"id" => 83,
						"text" => "Eliminar"
					],
					[
						"id" => 84,
						"text" => "Ver Archivo"
					],
					[
						"id" => 85,
						"text" => "Descargar Archivo"
					],
					[
						"id" => 86,
						"text" => "Asignar Productos"
					],
					[
						"id" => 87,
						"text" => "Eliminar Multiple"
					],
					[
						"id" => 88,
						"text" => "Ver Productos"
					]
				]
			],
			[
				"id" => 9,
				"text" => "Ubicaciones",
				"uri" => "",
				"children" => [
					[
						"id" => 91,
						"text" => "Paises",
						"uri" => "Ubicacion/Paises",
						"icon" => "fa-solid fa-flag",
						"color" => "bg-primary",
						"children" => [
							[
								"id" => 911,
								"text" => "Crear"
							],
							[
								"id" => 912,
								"text" => "Editar"
							],
							[
								"id" => 913,
								"text" => "Activar/Inactivar"
							]
						]
					],
					[
						"id" => 92,
						"text" => "Departamentos",
						"uri" => "Ubicacion/Departamentos",
						"icon" => "fa-solid fa-earth-africa",
						"color" => "bg-secondary",
						"children" => [
							[
								"id" => 921,
								"text" => "Crear"
							],
							[
								"id" => 922,
								"text" => "Editar"
							],
							[
								"id" => 923,
								"text" => "Activar/Inactivar"
							]
						]
					],
					[
						"id" => 93,
						"text" => "Ciudades",
						"uri" => "Ubicacion/Ciudades",
						"icon" => "fa-solid fa-city",
						"color" => "bg-success",
						"children" => [
							[
								"id" => 931,
								"text" => "Crear"
							],
							[
								"id" => 932,
								"text" => "Editar"
							],
							[
								"id" => 933,
								"text" => "Activar/Inactivar"
							]
						]
					]
				]
			],
			[
				"id" => 10,
				"text" => "Pedidos",
				"uri" => "Pedidos/Administrar",
				"icon" => "fa-solid fa-boxes-stacked",
				"color" => "bg-danger",
				"children" => [
					[
						"id" => 101,
						"text" => "Crear"
					],
					[
						"id" => 102,
						"text" => "Editar"
					],
					[
						"id" => 103,
						"text" => "Eliminar"
					],
					[
						"id" => 105,
						"text" => "Facturar"
					],
					[
						"id" => 106,
						"text" => "Imprimir"
					],
					[
						"id" => 107,
						"text" => "Imprimir Rotulo"
					],
					[
						"id" => 108,
						"text" => "Ver Manifiestos Cajas",
						"children" => [
							[
								"id" => 1081,
								"text" => "Imprimir Manifiesto"
							],
							[
								"id" => 1082,
								"text" => "Imprimir Múltiple Manifiesto"
							],
							[
								"id" => 1083,
								"text" => "Imprimir Manifiestos Sin Repetir"
							],
						]
					],
					[
						"id" => 109,
						"text" => "Imprmir Orden de Envio"
					],
					[
						"id" => 110,
						"text" => "Despachar"
					],
					[
						"id" => 111,
						"text" => "Detalle Pedido"
					],
					[
						"id" => 112,
						"text" => "Reporte de Empaque",
						"children" => [
							[
								"id" => 1121,
								"text" => "Confirmar Producto Reportado"
							]
						]
					],
				]
			],
			[
				"id" => 40,
				"text" => "Compras",
				"uri" => "Compras",
				"icon" => "fa-solid fa-cart-shopping",
				"color" => "bg-warning",
				"children" => [
					[
						"id" => 401,
						"text" => "Crear"
					],
					[
						"id" => 402,
						"text" => "Editar"
					],
					[
						"id" => 403,
						"text" => "Confirmar compra"
					],
					[
						"id" => 404,
						"text" => "Anular compra"
					],
					[
						"id" => 405,
						"text" => "Clonar compra"
					],
					[
						"id" => 406,
						"text" => "Imprimir compra"
					],
					[
						"id" => 407,
						"text" => "Imprimir sticker"
					]
				]
			],
			[
				"id" => 50,
				"text" => "Proveedor",
				"uri" => "Proveedor",
				"icon" => "fa-solid fa-boxes-packing",
				"color" => "bg-info",
				"children" => [
					[
						"id" => 501,
						"text" => "Crear"
					],
					[
						"id" => 502,
						"text" => "Editar"
					],
					[
						"id" => 503,
						"text" => "Activar/Inactivar"
					]
				]
			],
			[
				"id" => 60,
				"text" => "Reporte de Empaque",
				"uri" => "ProductosReportados",
				"icon" => "fa-solid fa-exclamation-triangle",
				"color" => "bg-light",
				"children" => [
					[
						"id" => 6001,
						"text" => "Confirmar Producto Reportado"
					]
				]
			],
			[
				"id" => 70,
				"text" => "Showroom",
				"uri" => "Showroom",
				"icon" => "fa-solid fa-basket-shopping",
				"color" => "bg-success",
				"children" => [
					[
						"id" => 7001,
						"text" => "Crear"
					],
					[
						"id" => 7002,
						"text" => "Editar"
					]
				]
			],
			[
				"id" => 80,
				"text" => "Ingreso Mercancía",
				"uri" => "IngresoMercancia",
				"icon" => "fa-solid fa-arrow-up-right-dots",
				"color" => "bg-dark",
				"children" => [
					[
						"id" => 801,
						"text" => "Crear"
					],
					[
						"id" => 802,
						"text" => "Editar"
					],
					[
						"id" => 803,
						"text" => "Confirmar Ingreso Mercancía"
					],
					[
						"id" => 804,
						"text" => "Anular Ingreso Mercancía"
					],
					[
						"id" => 805,
						"text" => "Imprimir Ingreso Mercancía"
					]
				]
			],
			[
				"id" => 90,
				"text" => "Reporte de inventario",
				"uri" => "ReporteInventario",
				"icon" => "fa-solid fa-cart-flatbed",
				"color" => "bg-primary",
				"children" => [
					[
						"id" => 901,
						"text" => "Imprimir Factura"
					],
					[
						"id" => 902,
						"text" => "Imprimir Pedido"
					],
					[
						"id" => 903,
						"text" => "Imprimir Compra"
					],
					[
						"id" => 904,
						"text" => "Imprimir Ingreso Mercancia"
					]
				]
			],
			[
				"id" => 100,
				"text" => "Cuentas por cobrar",
				"uri" => "CuentasCobrar",
				"icon" => "fa-solid fa-receipt",
				"color" => "bg-success",
				"children" => [
					[
						"id" => 1001,
						"text" => "Crear"
					],
					[
						"id" => 1002,
						"text" => "Anular"
					],
					[
						"id" => 1003,
						"text" => "Imprimir"
					],
					[
						"id" => 1005,
						"text" => "Imprimir Recibo Caja"
					],
					[
						"id" => 1004,
						"text" => "Imprimir Todos"
					],
					[
						"id" => 1006,
						"text" => "Imprimir Todos Recibos Caja"
					],
					[
						"id" => 1007,
						"text" => "Asignar Fechas"
					],
				]
			],
			[
				"id" => 120,
				"text" => "Contabilidad",
				"uri" => "Contabilidad",
				"icon" => "fa-solid fa-calculator",
				"color" => "bg-danger",
				"children" => [
					[
						"id" => 1201,
						"text" => "Catalogo de cuentas",
						"children" => [
							[
								"id" => 120101,
								"text" => "Crear cuenta"
							],
							[
								"id" => 120102,
								"text" => "Eliminar cuenta"
							]
						]
					]
				]
			],
		];

		if (!session()->has("manejaEmpaque") || session()->get("manejaEmpaque") == "1") {
			array_push(
				$permisos
				, [
					"id" => 30,
					"text" => "Empaque",
					"uri" => "Empaque",
					"icon" => "fa-solid fa-box-open",
					"color" => "bg-secondary",
					"children" => [
						[
							"id" => 301,
							"text" => "Finalizar Empaque"
						],
						[
							"id" => 302,
							"text" => "Reabrir Empaque"
						],
					]
				]
			);

			array_push(
				$permisos[9]['children']
				, [
					"id" => 104,
					"text" => "Enviar a Alistamiento"
				]
			);
		}

		if ($validar != '') {
			$permisos = $this->validar($validar, $permisos, []);
		}

		return $permisos;
	}

	private function validar($llave, $permisos, $new) {
			foreach ($permisos as $key => $value) {
				if (isset($value[$llave]) && validPermissions([$value['id']], true)) {
					$info = $value;
					unset($info['children']);
					$new[] = $info;
					if (isset($value['children'])) {
						$datos = $this->validar($llave, $value['children'], []);
						$new = array_merge($new, $datos);
					}
				}
			}
			return $new;
	}

}
