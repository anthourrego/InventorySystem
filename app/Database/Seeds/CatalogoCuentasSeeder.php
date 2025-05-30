<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogoCuentasSeeder extends Seeder
{
    public function run()
    {
        // php spark db:seed CatalogoCuentasSeeder
        $datos = [
          [
            "id"=> "5001",
            "name"=> "Activos",
            "description"=> "Bajo esta categoría se encuentran los activos que tiene la empresa",
            "nature"=> "debit",
            "readOnly"=> true,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5002",
                "name"=> "Activos corrientes",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5003",
                    "name"=> "Efectivo y equivalentes de efectivo",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5004",
                        "name"=> "Caja",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "CASH_ACCOUNTS",
                        "children"=> [
                          [
                            "id"=> "5275",
                            "name"=> "Caja chica",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "CASH_ACCOUNTS",
                            "children"=> []
                          ],
                          [
                            "id"=> "5276",
                            "name"=> "Caja general",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "CASH_ACCOUNTS",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5005",
                        "name"=> "Bancos",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "BANK_ACCOUNTS",
                        "children"=> [
                          [
                            "id"=> "5277",
        
                            "name"=> "Banco 1",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "BANK_ACCOUNTS",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5006",
        
                    "name"=> "Deudores comerciales y otras cuentas por cobrar",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5007",
        
                        "name"=> "Cuentas por cobrar clientes",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5008",
                            "name"=> "Cuentas por cobrar clientes nacionales",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "RECEIVABLE_ACCOUNTS",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5010",
                        "name"=> "Cuentas por cobrar a socios y accionistas",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5011",
                            "name"=> "Cuentas por cobrar a socios",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5012",
                            "name"=> "Cuentas por cobrar a accionistas",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5013",
                        "name"=> "Avances y anticipos entregados",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "ADVANCE_OUT",
                        "children"=> [
                          [
                            "id"=> "5014",
                            "name"=> "Avances y anticipos a proveedores",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "ADVANCE_OUT",
                            "children"=> []
                          ],
                          [
                            "id"=> "5015",
                            "name"=> "Avances y anticipos a empleados",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "ADVANCE_OUT",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5016",
                        "name"=> "Otros deudores y cuentas por cobrar",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5017",
                            "name"=> "Cuentas por cobrar empleados",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5018",
                            "name"=> "Préstamos a terceros",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5019",
                            "name"=> "Otras cuentas por cobrar",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "accumulative",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> [
                              [
                                "id"=> "5020",
                                "name"=> "Cuentas por cobrar a cargo de terceros",
                                "description"=> "",
                                "nature"=> "debit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5021",
                                "name"=> "Devoluciones a proveedores",
                                "description"=> "",
                                "nature"=> "debit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> false,
                                "behavior"=> "RECEIVABLE_ACCOUNTS_RETURNS",
                                "children"=> []
                              ],
                              [
                                "id"=> "5022",
                                "name"=> "Intereses por cobrar",
                                "description"=> "",
                                "nature"=> "debit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ]
                            ]
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5023",
                    "name"=> "Inversiones financieras a corto plazo",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5024",
                        "name"=> "Acciones de otras compañías",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5025",
                        "name"=> "Depósitos a plazos fijos",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5026",
                        "name"=> "Otras inversiones",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5027",
                    "name"=> "Activos por impuestos corrientes",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5028",
                        "name"=> "Impuestos a favor",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "TAXES_IN_FAVOR",
                        "children"=> [
                          [
                            "id"=> "5029",
                            "name"=> "Impuesto a las ventas a favor",
                            "description"=> "",
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "TAXES_IN_FAVOR",
                            "children"=> [
                              [
                                "id"=> "5030",
        
                                "name"=> "IVA devuelto en compras a favor",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> false,
                                "behavior"=> "TAX_REFUND_IN_FAVOR",
                                "children"=> []
                              ]
                            ]
                          ],
                          [
                            "id"=> "5031",
        
                            "name"=> "Anticipos o saldos a favor del Impuesto de Industria y Comercio",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "TAXES_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5032",
        
                            "name"=> "Impuesto nacional al consumo a favor",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "TAXES_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5033",
        
                            "name"=> "Sobrantes en impuestos",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "TAXES_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5034",
        
                            "name"=> "Otro tipo de impuesto a favor",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "OTHER_TAX_TYPE_IN_FAVOR",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5035",
        
                    "name"=> "Activos por retenciones a favor",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "RETENTIONS_IN_FAVOR",
                    "children"=> [
                      [
                        "id"=> "5036",
        
                        "name"=> "Retención en la fuente a favor",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "RETENTIONS_IN_FAVOR",
                        "children"=> [
                          [
                            "id"=> "5037",
        
                            "name"=> "Retención compras 2.5%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5038",
        
                            "name"=> "Retención arrendamiento 3.5%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5039",
        
                            "name"=> "Retención servicio 4%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5040",
        
                            "name"=> "Retención servicio 6%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5041",
        
                            "name"=> "Retención honorarios y comisiones 10%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ],
                          [
                            "id"=> "5042",
        
                            "name"=> "Retención honorarios y comisiones 11%",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "RETENTIONS_IN_FAVOR",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5043",
        
                        "name"=> "Retención de impuesto a las ventas a favor",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "RETENTIONS_IN_FAVOR",
                        "children"=> []
                      ],
                      [
                        "id"=> "5044",
        
                        "name"=> "Impuesto de Industria y Comercio retenido",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "RETENTIONS_IN_FAVOR",
                        "children"=> []
                      ],
                      [
                        "id"=> "5045",
        
                        "name"=> "Otro tipo de retención a favor",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "OTHER_RETENTION_TYPE_IN_FAVOR",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5046",
        
                    "name"=> "Inventarios",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "INVENTORY",
                    "children"=> [
                      [
                        "id"=> "5047",
        
                        "name"=> "Inventario de mercancías",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "INVENTORY",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5048",
        
                    "name"=> "Activos pagados por anticipado",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5049",
        
                    "name"=> "Otros activos corrientes",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ],
              [
                "id"=> "5050",
        
                "name"=> "Activos no corrientes",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5051",
        
                    "name"=> "Propiedad, planta y equipo (Activos fijos)",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                    "children"=> [
                      [
                        "id"=> "5052",
        
                        "name"=> "Terrenos",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5053",
        
                        "name"=> "Construcciones y edificaciones",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5054",
        
                        "name"=> "Equipo de oficina",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5055",
        
                        "name"=> "Muebles y enseres",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5056",
        
                        "name"=> "Equipo de computación",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5057",
        
                        "name"=> "Flota y equipos de transporte",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "PROPERTY_PLANT_EQUIPMENT",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5058",
        
                    "name"=> "Depreciación acumulada",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5059",
        
                        "name"=> "Depreciación acumulada Construcciones y Edificaciones",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5060",
        
                        "name"=> "Depreciación acumulada Equipo de oficina",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5061",
        
                        "name"=> "Depreciación acumulada Muebles y enseres",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5062",
        
                        "name"=> "Depreciación acumulada Equipo de computación",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5063",
        
                        "name"=> "Depreciación acumulada Flota y equipos de transporte",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5064",
        
                    "name"=> "Deterioro acumulado de valor",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5065",
        
                    "name"=> "Propiedad, planta y equipo (Impuestos descontables)",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "PROPERTY_PLANT_EQUIPMENT_DISCOUNTABLE_TAX",
                    "children"=> []
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5066",
            "name"=> "Pasivos",
            "description"=> "Bajo esta cuenta se registran los pasivos de la empresa",
            "nature"=> "credit",
            "readOnly"=> true,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5067",
        
                "name"=> "Pasivos corrientes",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5068",
        
                    "name"=> "Acreedores comerciales y otras cuentas por pagar",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5069",
        
                        "name"=> "Cuentas por pagar a proveedores",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5070",
        
                            "name"=> "Cuentas por pagar a proveedores nacionales",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "DEBTS_TO_PAY_PROVIDERS",
                            "children"=> []
                          ],
                          [
                            "id"=> "5071",
        
                            "name"=> "Cuentas por pagar a proveedores del exterior",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5072",
        
                        "name"=> "Avances y anticipos recibidos",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "ADVANCE_IN",
                        "children"=> [
                          [
                            "id"=> "5073",
        
                            "name"=> "Avances y anticipos recibidos de clientes",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "ADVANCE_IN",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5074",
        
                        "name"=> "Otras cuentas por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5075",
        
                            "name"=> "Devoluciones de clientes",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "DEBTS_TO_PAY_RETURNS",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5076",
        
                    "name"=> "Obligaciones laborales",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5077",
        
                        "name"=> "Salarios y prestaciones sociales",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5078",
        
                            "name"=> "Salarios a empleados por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "accumulative",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> [
                              [
                                "id"=> "5079",
        
                                "name"=> "Salarios por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5080",
        
                                "name"=> "Cesantías por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5081",
        
                                "name"=> "Intereses sobre cesantías",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5082",
        
                                "name"=> "Prima de servicios",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5083",
        
                                "name"=> "Vacaciones consolidadas",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5084",
        
                                "name"=> "Prestaciones extralegales",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ],
                              [
                                "id"=> "5085",
        
                                "name"=> "Indemnizaciones laborales",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "",
                                "children"=> []
                              ]
                            ]
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5086",
        
                    "name"=> "Retenciones y aportes laborales",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5087",
        
                        "name"=> "Aportes de seguridad social",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5088",
        
                            "name"=> "Aportes a entidades promotoras de salud, EPS",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5089",
        
                            "name"=> "Aportes a administradoras de riesgos profesionales, ARP",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5090",
        
                            "name"=> "Aportes al ICBF, SENA y cajas de compensación",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5091",
        
                    "name"=> "Obligaciones financieras a corto plazo",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5092",
        
                        "name"=> "Préstamos bancarios a corto plazo",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5093",
        
                            "name"=> "Préstamos a corto plazo bancos nacionales",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5094",
        
                        "name"=> "Obligaciones gubernamentales",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5095",
        
                        "name"=> "Tarjetas de crédito",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "CREDIT_CARDS",
                        "children"=> [
                          [
                            "id"=> "5278",
        
                            "name"=> "Tarjeta de crédito empresarial",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "CREDIT_CARDS",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5096",
        
                    "name"=> "Pasivos por impuestos corrientes",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5097",
        
                        "name"=> "Impuestos por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "TAXES_TO_PAY",
                        "children"=> [
                          [
                            "id"=> "5098",
        
                            "name"=> "Impuesto a las ventas por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "TAXES_TO_PAY",
                            "children"=> [
                              [
                                "id"=> "5099",
        
                                "name"=> "Impuesto a las ventas descontable",
                                "description"=> "",
        
                                "nature"=> "debit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "TAXES_TO_PAY",
                                "children"=> [
                                  [
                                    "id"=> "5100",
        
                                    "name"=> "IVA devuelto en compras",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "IVA_REFUNDED_ON_SALES_COL",
                                    "children"=> []
                                  ]
                                ]
                              ],
                              [
                                "id"=> "5101",
        
                                "name"=> "IVA devuelto en ventas",
                                "description"=> "",
        
                                "nature"=> "debit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> false,
                                "behavior"=> "IVA_REFUNDED_ON_SALES_COL",
                                "children"=> []
                              ]
                            ]
                          ]
                        ]
                      ],
                      [
                        "id"=> "5102",
        
                        "name"=> "Impuesto de industria y comercio por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "TAXES_TO_PAY",
                        "children"=> []
                      ],
                      [
                        "id"=> "5103",
        
                        "name"=> "Impuesto nacional al consumo por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "TAXES_TO_PAY",
                        "children"=> []
                      ],
                      [
                        "id"=> "5104",
        
                        "name"=> "Otro tipo de impuesto por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "OTHER_TAX_TYPE_TO_PAY",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5105",
        
                    "name"=> "Pasivos por retenciones corrientes",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5106",
        
                        "name"=> "Retenciones por pagar",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> false,
                        "behavior"=> "RETENTIONS_TO_PAY",
                        "children"=> [
                          [
                            "id"=> "5107",
        
                            "name"=> "Retención en la fuente por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "RETENTIONS_TO_PAY",
                            "children"=> [
                              [
                                "id"=> "5108",
        
                                "name"=> "Salarios y pagos laborales",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "RETENTIONS_TO_PAY",
                                "children"=> []
                              ],
                              [
                                "id"=> "5109",
        
                                "name"=> "Retención honorarios y comisiones por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "RETENTIONS_TO_PAY",
                                "children"=> [
                                  [
                                    "id"=> "5110",
        
                                    "name"=> "Retenciones honorarios y comisiones 10% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ],
                                  [
                                    "id"=> "5111",
        
                                    "name"=> "Retenciones honorarios y comisiones 11% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ]
                                ]
                              ],
                              [
                                "id"=> "5112",
        
                                "name"=> "Retención servicios por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "RETENTIONS_TO_PAY",
                                "children"=> [
                                  [
                                    "id"=> "5113",
        
                                    "name"=> "Retenciones servicios 4% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ],
                                  [
                                    "id"=> "5114",
        
                                    "name"=> "Retenciones servicios 6% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ]
                                ]
                              ],
                              [
                                "id"=> "5115",
        
                                "name"=> "Retención arrendamientos por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "RETENTIONS_TO_PAY",
                                "children"=> [
                                  [
                                    "id"=> "5116",
        
                                    "name"=> "Retenciones arriendo 3.5% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ]
                                ]
                              ],
                              [
                                "id"=> "5117",
        
                                "name"=> "Retenciones compra por pagar",
                                "description"=> "",
        
                                "nature"=> "credit",
                                "readOnly"=> false,
                                "use"=> "movement",
                                "deletable"=> true,
                                "behavior"=> "RETENTIONS_TO_PAY",
                                "children"=> [
                                  [
                                    "id"=> "5118",
        
                                    "name"=> "Retenciones compra 2.5% por pagar",
                                    "description"=> "",
        
                                    "nature"=> "credit",
                                    "readOnly"=> false,
                                    "use"=> "movement",
                                    "deletable"=> true,
                                    "behavior"=> "RETENTIONS_TO_PAY",
                                    "children"=> []
                                  ]
                                ]
                              ]
                            ]
                          ],
                          [
                            "id"=> "5119",
        
                            "name"=> "Retención de IVA por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "RETENTIONS_TO_PAY",
                            "children"=> []
                          ],
                          [
                            "id"=> "5120",
        
                            "name"=> "Retención de industria y comercio por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "RETENTIONS_TO_PAY",
                            "children"=> []
                          ],
                          [
                            "id"=> "5121",
        
                            "name"=> "Otro tipo de retención por pagar",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> false,
                            "behavior"=> "OTHER_RETENTION_TYPE_TO_PAY",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5122",
        
                    "name"=> "Otros pasivos corrientes",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5123",
        
                        "name"=> "Ingresos recibidos para terceros",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ]
                ]
              ],
              [
                "id"=> "5124",
        
                "name"=> "Pasivos no corrientes",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5125",
        
                    "name"=> "Obligaciones financieras a largo plazo",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5126",
        
                        "name"=> "Préstamos a largo plazo bancos nacionales",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5127",
        
                            "name"=> "Préstamos bancarios a largo plazo",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ],
                  [
                    "id"=> "5128",
        
                    "name"=> "Otros pasivos no corrientes",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5129",
            "name"=> "Patrimonio",
            "description"=> "Bajo esta cuenta se registra el patrimonio de la empresa",
            "nature"=> "credit",
            "readOnly"=> true,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5130",
        
                "name"=> "Capital social",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5131",
        
                    "name"=> "Capital social suscrito y pagado",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5132",
        
                        "name"=> "Capital social suscrito",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5133",
        
                            "name"=> "Capital social autorizado",
                            "description"=> "",
        
                            "nature"=> "credit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5134",
        
                            "name"=> "Capital por suscribir o Acciones",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ],
                      [
                        "id"=> "5135",
        
                        "name"=> "Capital social suscrito por cobrar",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5136",
        
                            "name"=> "Capital suscrito por cobrar o Accionistas comunes",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ]
                ]
              ],
              [
                "id"=> "5137",
        
                "name"=> "Reservas",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5138",
        
                "name"=> "Resultado del ejercicio",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5139",
        
                    "name"=> "Utilidad del ejercicio",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5140",
        
                    "name"=> "Pérdida del ejercicio",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ],
              [
                "id"=> "5141",
        
                "name"=> "Ganancias acumuladas",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> false,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5142",
        
                "name"=> "Supertávit",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5143",
        
                "name"=> "Ajustes por saldos iniciales",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5144",
        
                    "name"=> "Ajustes iniciales en bancos",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5145",
        
                    "name"=> "Ajustes iniciales en inventario",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5146",
            "name"=> "Ingresos",
            "description"=> "Bajo esta cuenta se registran todos los tipos de ingresos",
            "nature"=> "credit",
            "readOnly"=> true,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5147",
        
                "name"=> "Ingresos de actividades ordinarias",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5148",
        
                    "name"=> "Ventas",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "SALES",
                    "children"=> []
                  ],
                  [
                    "id"=> "51481",
                    "name"=> "Pedidos",
                    "description"=> "",
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "ORDERS",
                    "children"=> []
                  ],
                  [
                    "id"=> "51482",
                    "name"=> "Compras",
                    "description"=> "",
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "BUYS",
                    "children"=> []
                  ],
                  [
                    "id"=> "5149",
        
                    "name"=> "Devoluciones en ventas",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "SALES",
                    "children"=> []
                  ]
                ]
              ],
              [
                "id"=> "5150",
        
                "name"=> "Otros Ingresos",
                "description"=> "",
        
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> false,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5151",
        
                    "name"=> "Ingresos financieros",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5152",
        
                        "name"=> "Ingresos por Intereses financieros",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5153",
        
                        "name"=> "Utilidad en venta de Activos",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5154",
        
                    "name"=> "Otros ingresos diversos",
                    "description"=> "",
        
                    "nature"=> "credit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5155",
        
                        "name"=> "Ganancia por diferencia en cambio",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5156",
        
                        "name"=> "Ajustes por aproximaciones en cálculos",
                        "description"=> "",
        
                        "nature"=> "credit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5157",
            "name"=> "Gastos",
            "description"=> "Bajo esta categoría se encuentran todos los tipos de gastos",
            "nature"=> "debit",
            "readOnly"=> true,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5158",
        
                "name"=> "Gastos de venta",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5159",
        
                    "name"=> "Gastos de personal de ventas",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5160",
        
                        "name"=> "Sueldos personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5161",
        
                        "name"=> "Horas extras y recargos personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5162",
        
                        "name"=> "Comisiones personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5163",
        
                        "name"=> "Auxilio de transporte personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5164",
        
                        "name"=> "Cesantías personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5165",
        
                        "name"=> "Intereses sobre cesantías personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5166",
        
                        "name"=> "Prima de servicios personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5167",
        
                        "name"=> "Vacaciones personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5168",
        
                        "name"=> "Dotación a trabajadores de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5169",
        
                        "name"=> "Aportes a ARL personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5170",
        
                        "name"=> "Aportes a EPS personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5171",
        
                        "name"=> "Aportes fondo de pensiones y cesantías personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5172",
        
                        "name"=> "Aportes cajas de compensación familiar personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5173",
        
                        "name"=> "Aportes ICBF personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5174",
        
                        "name"=> "Aportes SENA personal de ventas",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ]
                ]
              ],
              [
                "id"=> "5175",
        
                "name"=> "Gastos de administración",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5176",
        
                    "name"=> "Gastos de personal",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5177",
        
                        "name"=> "Sueldos y salarios",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5178",
        
                        "name"=> "Horas extras y recargos",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5179",
        
                        "name"=> "Comisiones",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5180",
        
                        "name"=> "Auxilio de transporte",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5181",
        
                        "name"=> "Cesantías",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5182",
        
                        "name"=> "Intereses sobre cesantías",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5183",
        
                        "name"=> "Prima de servicios",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5184",
        
                        "name"=> "Vacaciones",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5185",
        
                        "name"=> "Dotación a trabajadores",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5186",
        
                        "name"=> "Aportes a ARL",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5187",
        
                        "name"=> "Aportes a EPS",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5188",
        
                        "name"=> "Aportes fondo de pensiones y cesantías",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5189",
        
                        "name"=> "Aportes cajas de compensación familiar",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5190",
        
                        "name"=> "Aportes ICBF",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5191",
        
                        "name"=> "Aportes SENA",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ]
                ]
              ],
              [
                "id"=> "5192",
        
                "name"=> "Gastos generales",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5193",
        
                    "name"=> "Honorarios y servicios",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5194",
                        "name"=> "Asesoría jurídica",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5195",
                        "name"=> "Asesoría financiera",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5196",
                        "name"=> "Otros honorarios",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5197",
                    "name"=> "Arrendamientos",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5198",
                        "name"=> "Arrendamiento de equipos",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5199",
                        "name"=> "Arrendamiento de Oficinas",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5200",
                    "name"=> "Servicios públicos",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5201",
                        "name"=> "Gas",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5202",
                        "name"=> "Aseo",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5203",
                        "name"=> "Agua",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5204",
                        "name"=> "Asistencia técnica",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5205",
                        "name"=> "Alcantarillado/ Acueducto",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5206",
                        "name"=> "Energía eléctrica",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5207",
                        "name"=> "Teléfono / Internet",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5208",
                        "name"=> "Transporte y acarreo",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5209",
                        "name"=> "Otros servicios",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5210",
                    "name"=> "Gastos de representación",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5211",
                        "name"=> "Elementos de aseo y cafetería",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5212",
                        "name"=> "Utiles, papelería y fotocopia",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5213",
                        "name"=> "Combustibles y lubricantes",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5214",
                        "name"=> "Taxis y buses",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5215",
                        "name"=> "Estacionamiento",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5216",
                    "name"=> "Propaganda y publicidad",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5217",
                    "name"=> "Vigilancia y seguridad",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5218",
                    "name"=> "Seguros",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5219",
                        "name"=> "Seguro de vida",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5220",
                        "name"=> "Seguro de accidentes",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5221",
                        "name"=> "Seguro de vehículos",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5222",
                        "name"=> "Seguro contra Incendios",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5223",
                    "name"=> "Servicios Online",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5224",
                        "name"=> "Software contables",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5225",
                    "name"=> "Cuotas y suscripciones",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5226",
                    "name"=> "Gastos legales",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5227",
                        "name"=> "Notariales",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5228",
                        "name"=> "Registro mercantil",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5229",
        
                        "name"=> "Trámites legales",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5230",
        
                    "name"=> "Mantenimiento y reparaciones",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5231",
        
                        "name"=> "Construcción y edificación",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5232",
        
                        "name"=> "Equipo oficina",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5233",
        
                        "name"=> "Equipo computación",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5234",
        
                        "name"=> "Adecuaciones e instalaciones",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5235",
        
                    "name"=> "Combustibles y lubricantes",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5236",
        
                    "name"=> "Otros gastos generales",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5237",
        
                    "name"=> "Depreciaciones, amortizaciones y desvalorizaciones",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5238",
        
                        "name"=> "Deterioro de cuentas por cobrar",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "UNCOLLECTIBLE_ACCOUNTS",
                        "children"=> []
                      ],
                      [
                        "id"=> "5239",
        
                        "name"=> "Depreciación de propiedad, planta y equipo",
                        "description"=> "",
        
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "accumulative",
                        "deletable"=> true,
                        "behavior"=> "",
                        "children"=> [
                          [
                            "id"=> "5240",
        
                            "name"=> "Depreciación Construcciones y edificaciones",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5241",
        
                            "name"=> "Depreciación Equipo de oficina",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5242",
        
                            "name"=> "Depreciación furniture",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5243",
        
                            "name"=> "Depreciación Equipo de computación",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ],
                          [
                            "id"=> "5244",
        
                            "name"=> "Depreciación Flota y equipos de transporte",
                            "description"=> "",
        
                            "nature"=> "debit",
                            "readOnly"=> false,
                            "use"=> "movement",
                            "deletable"=> true,
                            "behavior"=> "",
                            "children"=> []
                          ]
                        ]
                      ]
                    ]
                  ]
                ]
              ],
              [
                "id"=> "5245",
        
                "name"=> "Gastos financieros",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> false,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5246",
        
                    "name"=> "Gastos por Intereses financieros",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5247",
        
                    "name"=> "Gastos por Intereses de mora",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ],
              [
                "id"=> "5248",
        
                "name"=> "Otros gastos",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> false,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5249",
        
                    "name"=> "Comisiones bancarias",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5250",
        
                    "name"=> "Pérdida en venta de Activos",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5251",
        
                    "name"=> "Pérdida por disposición de activos",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5252",
        
                    "name"=> "Pérdida por diferencia en cambio",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5253",
        
                    "name"=> "Ajustes por aproximaciones en cálculos",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ],
              [
                "id"=> "5254",
        
                "name"=> "Gastos por impuestos",
                "description"=> "",
        
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> false,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5255",
        
                    "name"=> "Impuestos de renta y complementarios",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> true,
                    "behavior"=> "",
                    "children"=> []
                  ],
                  [
                    "id"=> "5256",
        
                    "name"=> "Gastos por impuestos no acreditables",
                    "description"=> "",
        
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "TAX_NOT_DEDUCTIBLE",
                    "children"=> []
                  ],
                  [
                    "id"=> "5257",
                    "name"=> "Retención en la fuente asumida",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "ASSUMED_RETENTION_AT_SOURCE",
                    "children"=> []
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5258",
            "name"=> "Costos",
            "description"=> "Bajo esta categoría se encuentran todos los tipos de costos",
            "nature"=> "debit",
            "readOnly"=> false,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5259",
                "name"=> "Costos de ventas y operación",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> [
                  [
                    "id"=> "5260",
                    "name"=> "Costos de la mercancía vendida",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "accumulative",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> [
                      [
                        "id"=> "5261",
                        "name"=> "Costos del inventario",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> true,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "INVENTORY_COST",
                        "children"=> []
                      ],
                      [
                        "id"=> "5262",
                        "name"=> "Ajustes al inventario",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ],
                      [
                        "id"=> "5263",
                        "name"=> "Descuentos financieros",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> false,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "FINANCIAL_DISCOUNT",
                        "children"=> []
                      ],
                      [
                        "id"=> "5264",
                        "name"=> "Devoluciones en compras de inventario",
                        "description"=> "",
                        "nature"=> "debit",
                        "readOnly"=> true,
                        "use"=> "movement",
                        "deletable"=> false,
                        "behavior"=> "",
                        "children"=> []
                      ]
                    ]
                  ],
                  [
                    "id"=> "5265",
                    "name"=> "Costo de los servicios vendidos",
                    "description"=> "",
                    "nature"=> "debit",
                    "readOnly"=> false,
                    "use"=> "movement",
                    "deletable"=> false,
                    "behavior"=> "",
                    "children"=> []
                  ]
                ]
              ]
            ]
          ],
          [
            "id"=> "5266",
            "name"=> "Costos de producción",
            "description"=> "Bajo esta categoría se encuentran todos los tipos de costos de producción",
            "nature"=> "debit",
            "readOnly"=> false,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5267",
                "name"=> "Materia prima directa",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5268",
                "name"=> "Mano de obra",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5269",
                "name"=> "Costos indirectos",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5270",
                "name"=> "Contratos de servicios",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "movement",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ]
            ]
          ],
          [
            "id"=> "5271",
            "name"=> "Cuentas de orden",
            "description"=> "Bajo esta categoría se encuentran todos los tipos de cuentas de orden",
            "nature"=> "credit",
            "readOnly"=> false,
            "use"=> "accumulative",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> [
              [
                "id"=> "5272",
                "name"=> "Cuentas de orden deudoras",
                "description"=> "",
                "nature"=> "debit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ],
              [
                "id"=> "5273",
                "name"=> "Cuentas de orden acreedoras",
                "description"=> "",
                "nature"=> "credit",
                "readOnly"=> false,
                "use"=> "accumulative",
                "deletable"=> true,
                "behavior"=> "",
                "children"=> []
              ]
            ]
          ],
          [
            "id"=> "5274",
            "name"=> "Transferencias bancarias",
            "description"=> "Encuentra las transferencias realizadas entre bancos de la empresa",
            "nature"=> "credit",
            "readOnly"=> true,
            "use"=> "movement",
            "deletable"=> false,
            "behavior"=> "",
            "children"=> []
          ]
        ];

        $this->saveAccounts($datos);
    }

    private function saveAccounts($accounts, &$codeToIdMap = [], $parentCode = null) {
        foreach ($accounts as $account) {
            $codigo = $account['id'];
            $nombre = $account['name'];
    
            $clasificacion = $this->getClasificacion($parentCode);
    
            $idParent = $parentCode ? ($codeToIdMap[$parentCode] ?? null) : null;
    
            $decoded = json_decode('"' . $nombre . '"');

            $data = [
                'codigo'         => $codigo,
                'nombre'         => $decoded,
                'descripcion'    => $account['description'],
                'naturaleza'     => $account['nature'] == "credit" ? "credito" : "debito",
                'clasificacion'  => $clasificacion,
                'estado'         => 1,
                'solo_lectura'   => $account['readOnly'] ? 1: 0,
                'eliminable'     => $account['deletable'] ? 1: 0,
                'type'           => $account["use"] === 'movement' ? 'CMO' : "CMA",
                'comportamiento' => $account['behavior'],
                'id_parent'      => $idParent
            ];
    
            $this->db->table('catalogocuentas')->insert($data);
            $insertedId = $this->db->insertID();
    
            $codeToIdMap[$codigo] = $insertedId;
    
            if (!empty($account['children'])) {
                $this->saveAccounts($account['children'], $codeToIdMap, $codigo);
            }
        }
    }

    public function getClasificacion($parentCode) {
        if ($parentCode === null) return 'CL'; // Clase
        $length = strlen($parentCode);
        if ($length <= 4) return 'GR'; // Grupo
        if ($length == 5) return 'CU'; // Cuenta
        return 'SC'; // Subcuenta
    }

}
