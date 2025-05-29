<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\mAlmacen;
use App\Models\Contabilidad\mCuentaMovimientos;
use App\Models\Contabilidad\mCatalogoCuentas;
use \Hermawan\DataTables\DataTable;

class cCuentaMovimientos extends BaseController {
	public function index() {

		/* $mCuentaMovimientos = new mCuentaMovimientos();
		$data = $mCuentaMovimientos->guardarCompra(6);
		dd($data); */

		$mCatalogoCuentas = new mCatalogoCuentas();
		$cuentasContables = $mCatalogoCuentas->getCuentas(null);


		$cuentas = [
			[
				'nombre' => 'Activos',
				'hijos' => [
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
				],
				[
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
				],
				[
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
					[
						'nombre' => 'Activos corrientes',
						'hijos' => [
							[
								'nombre' => 'Inventarios',
								'saldo_inicial_debito' => 106000000,
								'saldo_inicial_credito' => 0,
								'movimiento_debito' => 0,
								'movimiento_credito' => 0,
								'saldo_final_debito' => 106000000,
								'saldo_final_credito' => 0,
								'hijos' => []
							],
							// ...
						]
					],
				]
			],
			// Pasivos, Patrimonio...
		];
		$this->content['cuentas'] = $cuentas;

		$balance_data = [
            'activos' => [
                'name' => 'Activos',
                'total' => 106000000,
                'children' => [
                    'activos_corrientes' => [
                        'name' => 'Activos corrientes',
                        'total' => 106000000,
                        'children' => [
                            'efectivo' => [
                                'name' => 'Efectivo y equivalentes de efectivo',
                                'total' => 0,
                                'children' => [
                                    'caja' => [
                                        'name' => 'Caja',
                                        'total' => 0,
                                        'children' => [
                                            'caja_chica' => [
                                                'name' => 'Caja chica',
                                                'total' => 0,
                                                'values' => [0, 0, 0, 0, 0, 0]
                                            ],
                                            'caja_general' => [
                                                'name' => 'Caja general',
                                                'total' => 0,
                                                'values' => [0, 0, 0, 0, 0, 0]
                                            ]
                                        ]
                                    ],
                                    'bancos' => [
                                        'name' => 'Bancos',
                                        'total' => 0,
                                        'values' => [0, 0, 0, 0, 0, 0]
                                    ]
                                ]
                            ],
                            'deudores_comerciales' => [
                                'name' => 'Deudores comerciales y otras cuentas por cobrar',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ],
                            'inversiones_financieras' => [
                                'name' => 'Inversiones financieras a corto plazo',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ],
                            'activos_impuestos' => [
                                'name' => 'Activos por impuestos corrientes',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ],
                            'activos_retenciones' => [
                                'name' => 'Activos por retenciones a favor',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ],
                            'inventarios' => [
                                'name' => 'Inventarios',
                                'total' => 106000000,
                                'values' => [106000000, 0, 0, 0, 106000000, 0]
                            ],
                            'activos_pagados' => [
                                'name' => 'Activos pagados por anticipado',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ],
                            'otros_activos' => [
                                'name' => 'Otros activos corrientes',
                                'total' => 0,
                                'values' => [0, 0, 0, 0, 0, 0]
                            ]
                        ]
                    ],
                    'activos_no_corrientes' => [
                        'name' => 'Activos no corrientes',
                        'total' => 0,
                        'values' => [0, 0, 0, 0, 0, 0]
                    ]
                ]
            ]
        ];
		$this->content['balance_data'] = $balance_data;



		$this->content['cuentasContables'] = $cuentasContables;

		$this->content['title'] = "Movimiento de cuentas";
		$this->content['view'] = "Contabilidad/vCuentaMovimientos";

		$this->LMoment();
		$this->Lgijgo();

		$this->content['js_add'][] = [
			'Contabilidad/jsCuentaMovimientos.js'
		];

		return view('UI/viewDefault', $this->content);
	}
}
