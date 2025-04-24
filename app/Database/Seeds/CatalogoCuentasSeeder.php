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
              "id" =>  "5001",
              "name" =>  "Activos",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5002",
                  "name" =>  "Activos corrientes",
                  "idParent" =>  "5001",
                  "children" =>  [
                    [
                      "id" =>  "5003",
                      "name" =>  "Efectivo y equivalentes de efectivo",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5004",
                          "name" =>  "Caja",
                          "idParent" =>  "5003",
                          "children" =>  [
                            [
                              "id" =>  "5275",
                              "name" =>  "Caja chica",
                              "idParent" =>  "5004",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5276",
                              "name" =>  "Caja general",
                              "idParent" =>  "5004",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5005",
                          "name" =>  "Bancos",
                          "idParent" =>  "5003",
                          "children" =>  [
                            [
                              "id" =>  "5277",
                              "name" =>  "Banco 1",
                              "idParent" =>  "5005",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5006",
                      "name" =>  "Deudores comerciales y otras cuentas por cobrar",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5007",
                          "name" =>  "Cuentas por cobrar clientes",
                          "idParent" =>  "5006",
                          "children" =>  [
                            [
                              "id" =>  "5008",
                              "name" =>  "Cuentas por cobrar clientes nacionales",
                              "idParent" =>  "5007",
                              "children" =>  [
                                [
                                  "id" =>  "5009",
                                  "name" =>  "Deterioro acumulado de cuentas por cobrar",
                                  "idParent" =>  "5008",
                                  "children" =>  []
                                ]
                              ]
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5010",
                          "name" =>  "Cuentas por cobrar a socios y accionistas",
                          "idParent" =>  "5006",
                          "children" =>  [
                            [
                              "id" =>  "5011",
                              "name" =>  "Cuentas por cobrar a socios",
                              "idParent" =>  "5010",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5012",
                              "name" =>  "Cuentas por cobrar a accionistas",
                              "idParent" =>  "5010",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5013",
                          "name" =>  "Avances y anticipos entregados",
                          "idParent" =>  "5006",
                          "children" =>  [
                            [
                              "id" =>  "5014",
                              "name" =>  "Avances y anticipos a proveedores",
                              "idParent" =>  "5013",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5015",
                              "name" =>  "Avances y anticipos a empleados",
                              "idParent" =>  "5013",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5016",
                          "name" =>  "Otros deudores y cuentas por cobrar",
                          "idParent" =>  "5006",
                          "children" =>  [
                            [
                              "id" =>  "5017",
                              "name" =>  "Cuentas por cobrar empleados",
                              "idParent" =>  "5016",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5018",
                              "name" =>  "Pr\u00e9stamos a terceros",
                              "idParent" =>  "5016",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5019",
                              "name" =>  "Otras cuentas por cobrar",
                              "idParent" =>  "5016",
                              "children" =>  [
                                [
                                  "id" =>  "5020",
                                  "name" =>  "Cuentas por cobrar a cargo de terceros",
                                  "idParent" =>  "5019",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5021",
                                  "name" =>  "Devoluciones a proveedores",
                                  "idParent" =>  "5019",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5022",
                                  "name" =>  "Intereses por cobrar",
                                  "idParent" =>  "5019",
                                  "children" =>  []
                                ]
                              ]
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5023",
                      "name" =>  "Inversiones financieras a corto plazo",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5024",
                          "name" =>  "Acciones de otras compa\u00f1\u00edas",
                          "idParent" =>  "5023",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5025",
                          "name" =>  "Dep\u00f3sitos a plazos fijos",
                          "idParent" =>  "5023",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5026",
                          "name" =>  "Otras inversiones",
                          "idParent" =>  "5023",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5027",
                      "name" =>  "Activos por impuestos corrientes",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5028",
                          "name" =>  "Impuestos a favor",
                          "idParent" =>  "5027",
                          "children" =>  [
                            [
                              "id" =>  "5029",
                              "name" =>  "Impuesto a las ventas a favor",
                              "idParent" =>  "5028",
                              "children" =>  [
                                [
                                  "id" =>  "5030",
                                  "name" =>  "IVA devuelto en compras a favor",
                                  "idParent" =>  "5029",
                                  "children" =>  []
                                ]
                              ]
                            ],
                            [
                              "id" =>  "5031",
                              "name" =>  "Anticipos o saldos a favor del Impuesto de Industria y Comercio",
                              "idParent" =>  "5028",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5032",
                              "name" =>  "Impuesto nacional al consumo a favor",
                              "idParent" =>  "5028",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5033",
                              "name" =>  "Sobrantes en impuestos",
                              "idParent" =>  "5028",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5034",
                              "name" =>  "Otro tipo de impuesto a favor",
                              "idParent" =>  "5028",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5035",
                      "name" =>  "Activos por retenciones a favor",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5036",
                          "name" =>  "Retenci\u00f3n en la fuente a favor",
                          "idParent" =>  "5035",
                          "children" =>  [
                            [
                              "id" =>  "5037",
                              "name" =>  "Retenci\u00f3n compras 2.5%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5038",
                              "name" =>  "Retenci\u00f3n arrendamiento 3.5%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5039",
                              "name" =>  "Retenci\u00f3n servicio 4%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5040",
                              "name" =>  "Retenci\u00f3n servicio 6%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5041",
                              "name" =>  "Retenci\u00f3n honorarios y comisiones 10%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5042",
                              "name" =>  "Retenci\u00f3n honorarios y comisiones 11%",
                              "idParent" =>  "5036",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5043",
                          "name" =>  "Retenci\u00f3n de impuesto a las ventas a favor",
                          "idParent" =>  "5035",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5044",
                          "name" =>  "Impuesto de Industria y Comercio retenido",
                          "idParent" =>  "5035",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5045",
                          "name" =>  "Otro tipo de retenci\u00f3n a favor",
                          "idParent" =>  "5035",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5046",
                      "name" =>  "Inventarios",
                      "idParent" =>  "5002",
                      "children" =>  [
                        [
                          "id" =>  "5047",
                          "name" =>  "Inventario de mercanc\u00edas",
                          "idParent" =>  "5046",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5048",
                      "name" =>  "Activos pagados por anticipado",
                      "idParent" =>  "5002",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5049",
                      "name" =>  "Otros activos corrientes",
                      "idParent" =>  "5002",
                      "children" =>  []
                    ]
                  ]
                ],
                [
                  "id" =>  "5050",
                  "name" =>  "Activos no corrientes",
                  "idParent" =>  "5001",
                  "children" =>  [
                    [
                      "id" =>  "5051",
                      "name" =>  "Propiedad, planta y equipo (Activos fijos)",
                      "idParent" =>  "5050",
                      "children" =>  [
                        [
                          "id" =>  "5052",
                          "name" =>  "Terrenos",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5053",
                          "name" =>  "Construcciones y edificaciones",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5054",
                          "name" =>  "Equipo de oficina",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5055",
                          "name" =>  "Muebles y enseres",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5056",
                          "name" =>  "Equipo de computaci\u00f3n",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5057",
                          "name" =>  "Flota y equipos de transporte",
                          "idParent" =>  "5051",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5058",
                      "name" =>  "Depreciaci\u00f3n acumulada",
                      "idParent" =>  "5050",
                      "children" =>  [
                        [
                          "id" =>  "5059",
                          "name" =>  "Depreciaci\u00f3n acumulada Construcciones y Edificaciones",
                          "idParent" =>  "5058",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5060",
                          "name" =>  "Depreciaci\u00f3n acumulada Equipo de oficina",
                          "idParent" =>  "5058",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5061",
                          "name" =>  "Depreciaci\u00f3n acumulada Muebles y enseres",
                          "idParent" =>  "5058",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5062",
                          "name" =>  "Depreciaci\u00f3n acumulada Equipo de computaci\u00f3n",
                          "idParent" =>  "5058",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5063",
                          "name" =>  "Depreciaci\u00f3n acumulada Flota y equipos de transporte",
                          "idParent" =>  "5058",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5064",
                      "name" =>  "Deterioro acumulado de valor",
                      "idParent" =>  "5050",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5065",
                      "name" =>  "Propiedad, planta y equipo (Impuestos descontables)",
                      "idParent" =>  "5050",
                      "children" =>  []
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5066",
              "name" =>  "Pasivos",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5067",
                  "name" =>  "Pasivos corrientes",
                  "idParent" =>  "5066",
                  "children" =>  [
                    [
                      "id" =>  "5068",
                      "name" =>  "Acreedores comerciales y otras cuentas por pagar",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5069",
                          "name" =>  "Cuentas por pagar a proveedores",
                          "idParent" =>  "5068",
                          "children" =>  [
                            [
                              "id" =>  "5070",
                              "name" =>  "Cuentas por pagar a proveedores nacionales",
                              "idParent" =>  "5069",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5071",
                              "name" =>  "Cuentas por pagar a proveedores del exterior",
                              "idParent" =>  "5069",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5072",
                          "name" =>  "Avances y anticipos recibidos",
                          "idParent" =>  "5068",
                          "children" =>  [
                            [
                              "id" =>  "5073",
                              "name" =>  "Avances y anticipos recibidos de clientes",
                              "idParent" =>  "5072",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5074",
                          "name" =>  "Otras cuentas por pagar",
                          "idParent" =>  "5068",
                          "children" =>  [
                            [
                              "id" =>  "5075",
                              "name" =>  "Devoluciones de clientes",
                              "idParent" =>  "5074",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5076",
                      "name" =>  "Obligaciones laborales",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5077",
                          "name" =>  "Salarios y prestaciones sociales",
                          "idParent" =>  "5076",
                          "children" =>  [
                            [
                              "id" =>  "5078",
                              "name" =>  "Salarios a empleados por pagar",
                              "idParent" =>  "5077",
                              "children" =>  [
                                [
                                  "id" =>  "5079",
                                  "name" =>  "Salarios por pagar",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5080",
                                  "name" =>  "Cesant\u00edas por pagar",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5081",
                                  "name" =>  "Intereses sobre cesant\u00edas",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5082",
                                  "name" =>  "Prima de servicios",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5083",
                                  "name" =>  "Vacaciones consolidadas",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5084",
                                  "name" =>  "Prestaciones extralegales",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5085",
                                  "name" =>  "Indemnizaciones laborales",
                                  "idParent" =>  "5078",
                                  "children" =>  []
                                ]
                              ]
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5086",
                      "name" =>  "Retenciones y aportes laborales",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5087",
                          "name" =>  "Aportes de seguridad social",
                          "idParent" =>  "5086",
                          "children" =>  [
                            [
                              "id" =>  "5088",
                              "name" =>  "Aportes a entidades promotoras de salud, EPS",
                              "idParent" =>  "5087",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5089",
                              "name" =>  "Aportes a administradoras de riesgos profesionales, ARP",
                              "idParent" =>  "5087",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5090",
                              "name" =>  "Aportes al ICBF, SENA y cajas de compensaci\u00f3n",
                              "idParent" =>  "5087",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5091",
                      "name" =>  "Obligaciones financieras a corto plazo",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5092",
                          "name" =>  "Pr\u00e9stamos bancarios a corto plazo",
                          "idParent" =>  "5091",
                          "children" =>  [
                            [
                              "id" =>  "5093",
                              "name" =>  "Pr\u00e9stamos a corto plazo bancos nacionales",
                              "idParent" =>  "5092",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5094",
                          "name" =>  "Obligaciones gubernamentales",
                          "idParent" =>  "5091",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5095",
                          "name" =>  "Tarjetas de cr\u00e9dito",
                          "idParent" =>  "5091",
                          "children" =>  [
                            [
                              "id" =>  "5278",
                              "name" =>  "Tarjeta de cr\u00e9dito empresarial",
                              "idParent" =>  "5095",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5096",
                      "name" =>  "Pasivos por impuestos corrientes",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5097",
                          "name" =>  "Impuestos por pagar",
                          "idParent" =>  "5096",
                          "children" =>  [
                            [
                              "id" =>  "5098",
                              "name" =>  "Impuesto a las ventas por pagar",
                              "idParent" =>  "5097",
                              "children" =>  [
                                [
                                  "id" =>  "5099",
                                  "name" =>  "Impuesto a las ventas descontable",
                                  "idParent" =>  "5098",
                                  "children" =>  [
                                    [
                                      "id" =>  "5100",
                                      "name" =>  "IVA devuelto en compras",
                                      "idParent" =>  "5099",
                                      "children" =>  []
                                    ]
                                  ]
                                ],
                                [
                                  "id" =>  "5101",
                                  "name" =>  "IVA devuelto en ventas",
                                  "idParent" =>  "5098",
                                  "children" =>  []
                                ]
                              ]
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5102",
                          "name" =>  "Impuesto de industria y comercio por pagar",
                          "idParent" =>  "5096",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5103",
                          "name" =>  "Impuesto nacional al consumo por pagar",
                          "idParent" =>  "5096",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5104",
                          "name" =>  "Otro tipo de impuesto por pagar",
                          "idParent" =>  "5096",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5105",
                      "name" =>  "Pasivos por retenciones corrientes",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5106",
                          "name" =>  "Retenciones por pagar",
                          "idParent" =>  "5105",
                          "children" =>  [
                            [
                              "id" =>  "5107",
                              "name" =>  "Retenci\u00f3n en la fuente por pagar",
                              "idParent" =>  "5106",
                              "children" =>  [
                                [
                                  "id" =>  "5108",
                                  "name" =>  "Salarios y pagos laborales",
                                  "idParent" =>  "5107",
                                  "children" =>  []
                                ],
                                [
                                  "id" =>  "5109",
                                  "name" =>  "Retenci\u00f3n honorarios y comisiones por pagar",
                                  "idParent" =>  "5107",
                                  "children" =>  [
                                    [
                                      "id" =>  "5110",
                                      "name" =>  "Retenciones honorarios y comisiones 10% por pagar",
                                      "idParent" =>  "5109",
                                      "children" =>  []
                                    ],
                                    [
                                      "id" =>  "5111",
                                      "name" =>  "Retenciones honorarios y comisiones 11% por pagar",
                                      "idParent" =>  "5109",
                                      "children" =>  []
                                    ]
                                  ]
                                ],
                                [
                                  "id" =>  "5112",
                                  "name" =>  "Retenci\u00f3n servicios por pagar",
                                  "idParent" =>  "5107",
                                  "children" =>  [
                                    [
                                      "id" =>  "5113",
                                      "name" =>  "Retenciones servicios 4% por pagar",
                                      "idParent" =>  "5112",
                                      "children" =>  []
                                    ],
                                    [
                                      "id" =>  "5114",
                                      "name" =>  "Retenciones servicios 6% por pagar",
                                      "idParent" =>  "5112",
                                      "children" =>  []
                                    ]
                                  ]
                                ],
                                [
                                  "id" =>  "5115",
                                  "name" =>  "Retenci\u00f3n arrendamientos por pagar",
                                  "idParent" =>  "5107",
                                  "children" =>  [
                                    [
                                      "id" =>  "5116",
                                      "name" =>  "Retenciones arriendo 3.5% por pagar",
                                      "idParent" =>  "5115",
                                      "children" =>  []
                                    ]
                                  ]
                                ],
                                [
                                  "id" =>  "5117",
                                  "name" =>  "Retenciones compra por pagar",
                                  "idParent" =>  "5107",
                                  "children" =>  [
                                    [
                                      "id" =>  "5118",
                                      "name" =>  "Retenciones compra 2.5% por pagar",
                                      "idParent" =>  "5117",
                                      "children" =>  []
                                    ]
                                  ]
                                ]
                              ]
                            ],
                            [
                              "id" =>  "5119",
                              "name" =>  "Retenci\u00f3n de IVA por pagar",
                              "idParent" =>  "5106",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5120",
                              "name" =>  "Retenci\u00f3n de industria y comercio por pagar",
                              "idParent" =>  "5106",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5121",
                              "name" =>  "Otro tipo de retenci\u00f3n por pagar",
                              "idParent" =>  "5106",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5122",
                      "name" =>  "Otros pasivos corrientes",
                      "idParent" =>  "5067",
                      "children" =>  [
                        [
                          "id" =>  "5123",
                          "name" =>  "Ingresos recibidos para terceros",
                          "idParent" =>  "5122",
                          "children" =>  []
                        ]
                      ]
                    ]
                  ]
                ],
                [
                  "id" =>  "5124",
                  "name" =>  "Pasivos no corrientes",
                  "idParent" =>  "5066",
                  "children" =>  [
                    [
                      "id" =>  "5125",
                      "name" =>  "Obligaciones financieras a largo plazo",
                      "idParent" =>  "5124",
                      "children" =>  [
                        [
                          "id" =>  "5126",
                          "name" =>  "Pr\u00e9stamos a largo plazo bancos nacionales",
                          "idParent" =>  "5125",
                          "children" =>  [
                            [
                              "id" =>  "5127",
                              "name" =>  "Pr\u00e9stamos bancarios a largo plazo",
                              "idParent" =>  "5126",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5128",
                      "name" =>  "Otros pasivos no corrientes",
                      "idParent" =>  "5124",
                      "children" =>  []
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5129",
              "name" =>  "Patrimonio",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5130",
                  "name" =>  "Capital social",
                  "idParent" =>  "5129",
                  "children" =>  [
                    [
                      "id" =>  "5131",
                      "name" =>  "Capital social suscrito y pagado",
                      "idParent" =>  "5130",
                      "children" =>  [
                        [
                          "id" =>  "5132",
                          "name" =>  "Capital social suscrito",
                          "idParent" =>  "5131",
                          "children" =>  [
                            [
                              "id" =>  "5133",
                              "name" =>  "Capital social autorizado",
                              "idParent" =>  "5132",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5134",
                              "name" =>  "Capital por suscribir o Acciones",
                              "idParent" =>  "5132",
                              "children" =>  []
                            ]
                          ]
                        ],
                        [
                          "id" =>  "5135",
                          "name" =>  "Capital social suscrito por cobrar",
                          "idParent" =>  "5131",
                          "children" =>  [
                            [
                              "id" =>  "5136",
                              "name" =>  "Capital suscrito por cobrar o Accionistas comunes",
                              "idParent" =>  "5135",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ]
                  ]
                ],
                [
                  "id" =>  "5137",
                  "name" =>  "Reservas",
                  "idParent" =>  "5129",
                  "children" =>  []
                ],
                [
                  "id" =>  "5138",
                  "name" =>  "Resultado del ejercicio",
                  "idParent" =>  "5129",
                  "children" =>  [
                    [
                      "id" =>  "5139",
                      "name" =>  "Utilidad del ejercicio",
                      "idParent" =>  "5138",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5140",
                      "name" =>  "P\u00e9rdida del ejercicio",
                      "idParent" =>  "5138",
                      "children" =>  []
                    ]
                  ]
                ],
                [
                  "id" =>  "5141",
                  "name" =>  "Ganancias acumuladas",
                  "idParent" =>  "5129",
                  "children" =>  []
                ],
                [
                  "id" =>  "5142",
                  "name" =>  "Supert\u00e1vit",
                  "idParent" =>  "5129",
                  "children" =>  []
                ],
                [
                  "id" =>  "5143",
                  "name" =>  "Ajustes por saldos iniciales",
                  "idParent" =>  "5129",
                  "children" =>  [
                    [
                      "id" =>  "5144",
                      "name" =>  "Ajustes iniciales en bancos",
                      "idParent" =>  "5143",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5145",
                      "name" =>  "Ajustes iniciales en inventario",
                      "idParent" =>  "5143",
                      "children" =>  []
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5146",
              "name" =>  "Ingresos",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5147",
                  "name" =>  "Ingresos de actividades ordinarias",
                  "idParent" =>  "5146",
                  "children" =>  [
                    [
                      "id" =>  "5148",
                      "name" =>  "Ventas",
                      "idParent" =>  "5147",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5149",
                      "name" =>  "Devoluciones en ventas",
                      "idParent" =>  "5147",
                      "children" =>  []
                    ]
                  ]
                ],
                [
                  "id" =>  "5150",
                  "name" =>  "Otros Ingresos",
                  "idParent" =>  "5146",
                  "children" =>  [
                    [
                      "id" =>  "5151",
                      "name" =>  "Ingresos financieros",
                      "idParent" =>  "5150",
                      "children" =>  [
                        [
                          "id" =>  "5152",
                          "name" =>  "Ingresos por Intereses financieros",
                          "idParent" =>  "5151",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5153",
                          "name" =>  "Utilidad en venta de Activos",
                          "idParent" =>  "5151",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5154",
                      "name" =>  "Otros ingresos diversos",
                      "idParent" =>  "5150",
                      "children" =>  [
                        [
                          "id" =>  "5155",
                          "name" =>  "Ganancia por diferencia en cambio",
                          "idParent" =>  "5154",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5156",
                          "name" =>  "Ajustes por aproximaciones en c\u00e1lculos",
                          "idParent" =>  "5154",
                          "children" =>  []
                        ]
                      ]
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5157",
              "name" =>  "Gastos",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5158",
                  "name" =>  "Gastos de venta",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5159",
                      "name" =>  "Gastos de personal de ventas",
                      "idParent" =>  "5158",
                      "children" =>  [
                        [
                          "id" =>  "5160",
                          "name" =>  "Sueldos personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5161",
                          "name" =>  "Horas extras y recargos personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5162",
                          "name" =>  "Comisiones personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5163",
                          "name" =>  "Auxilio de transporte personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5164",
                          "name" =>  "Cesant\u00edas personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5165",
                          "name" =>  "Intereses sobre cesant\u00edas personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5166",
                          "name" =>  "Prima de servicios personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5167",
                          "name" =>  "Vacaciones personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5168",
                          "name" =>  "Dotaci\u00f3n a trabajadores de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5169",
                          "name" =>  "Aportes a ARL personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5170",
                          "name" =>  "Aportes a EPS personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5171",
                          "name" =>  "Aportes fondo de pensiones y cesant\u00edas personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5172",
                          "name" =>  "Aportes cajas de compensaci\u00f3n familiar personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5173",
                          "name" =>  "Aportes ICBF personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5174",
                          "name" =>  "Aportes SENA personal de ventas",
                          "idParent" =>  "5159",
                          "children" =>  []
                        ]
                      ]
                    ]
                  ]
                ],
                [
                  "id" =>  "5175",
                  "name" =>  "Gastos de administraci\u00f3n",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5176",
                      "name" =>  "Gastos de personal",
                      "idParent" =>  "5175",
                      "children" =>  [
                        [
                          "id" =>  "5177",
                          "name" =>  "Sueldos y salarios",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5178",
                          "name" =>  "Horas extras y recargos",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5179",
                          "name" =>  "Comisiones",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5180",
                          "name" =>  "Auxilio de transporte",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5181",
                          "name" =>  "Cesant\u00edas",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5182",
                          "name" =>  "Intereses sobre cesant\u00edas",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5183",
                          "name" =>  "Prima de servicios",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5184",
                          "name" =>  "Vacaciones",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5185",
                          "name" =>  "Dotaci\u00f3n a trabajadores",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5186",
                          "name" =>  "Aportes a ARL",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5187",
                          "name" =>  "Aportes a EPS",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5188",
                          "name" =>  "Aportes fondo de pensiones y cesant\u00edas",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5189",
                          "name" =>  "Aportes cajas de compensaci\u00f3n familiar",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5190",
                          "name" =>  "Aportes ICBF",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5191",
                          "name" =>  "Aportes SENA",
                          "idParent" =>  "5176",
                          "children" =>  []
                        ]
                      ]
                    ]
                  ]
                ],
                [
                  "id" =>  "5192",
                  "name" =>  "Gastos generales",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5193",
                      "name" =>  "Honorarios y servicios",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5194",
                          "name" =>  "Asesor\u00eda jur\u00eddica",
                          "idParent" =>  "5193",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5195",
                          "name" =>  "Asesor\u00eda financiera",
                          "idParent" =>  "5193",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5196",
                          "name" =>  "Otros honorarios",
                          "idParent" =>  "5193",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5197",
                      "name" =>  "Arrendamientos",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5198",
                          "name" =>  "Arrendamiento de equipos",
                          "idParent" =>  "5197",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5199",
                          "name" =>  "Arrendamiento de Oficinas",
                          "idParent" =>  "5197",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5200",
                      "name" =>  "Servicios p\u00fablicos",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5201",
                          "name" =>  "Gas",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5202",
                          "name" =>  "Aseo",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5203",
                          "name" =>  "Agua",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5204",
                          "name" =>  "Asistencia t\u00e9cnica",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5205",
                          "name" =>  "Alcantarillado/ Acueducto",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5206",
                          "name" =>  "Energ\u00eda el\u00e9ctrica",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5207",
                          "name" =>  "Tel\u00e9fono / Internet",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5208",
                          "name" =>  "Transporte y acarreo",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5209",
                          "name" =>  "Otros servicios",
                          "idParent" =>  "5200",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5210",
                      "name" =>  "Gastos de representaci\u00f3n",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5211",
                          "name" =>  "Elementos de aseo y cafeter\u00eda",
                          "idParent" =>  "5210",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5212",
                          "name" =>  "\u00datiles, papeler\u00eda y fotocopia",
                          "idParent" =>  "5210",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5213",
                          "name" =>  "Combustibles y lubricantes",
                          "idParent" =>  "5210",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5214",
                          "name" =>  "Taxis y buses",
                          "idParent" =>  "5210",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5215",
                          "name" =>  "Estacionamiento",
                          "idParent" =>  "5210",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5216",
                      "name" =>  "Propaganda y publicidad",
                      "idParent" =>  "5192",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5217",
                      "name" =>  "Vigilancia y seguridad",
                      "idParent" =>  "5192",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5218",
                      "name" =>  "Seguros",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5219",
                          "name" =>  "Seguro de vida",
                          "idParent" =>  "5218",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5220",
                          "name" =>  "Seguro de accidentes",
                          "idParent" =>  "5218",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5221",
                          "name" =>  "Seguro de veh\u00edculos",
                          "idParent" =>  "5218",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5222",
                          "name" =>  "Seguro contra Incendios",
                          "idParent" =>  "5218",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5223",
                      "name" =>  "Servicios Online",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5224",
                          "name" =>  "Software contables",
                          "idParent" =>  "5223",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5225",
                      "name" =>  "Cuotas y suscripciones",
                      "idParent" =>  "5192",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5226",
                      "name" =>  "Gastos legales",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5227",
                          "name" =>  "Notariales",
                          "idParent" =>  "5226",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5228",
                          "name" =>  "Registro mercantil",
                          "idParent" =>  "5226",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5229",
                          "name" =>  "Tr\u00e1mites legales",
                          "idParent" =>  "5226",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5230",
                      "name" =>  "Mantenimiento y reparaciones",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5231",
                          "name" =>  "Construcci\u00f3n y edificaci\u00f3n",
                          "idParent" =>  "5230",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5232",
                          "name" =>  "Equipo oficina",
                          "idParent" =>  "5230",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5233",
                          "name" =>  "Equipo computaci\u00f3n",
                          "idParent" =>  "5230",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5234",
                          "name" =>  "Adecuaciones e instalaciones",
                          "idParent" =>  "5230",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5235",
                      "name" =>  "Combustibles y lubricantes",
                      "idParent" =>  "5192",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5236",
                      "name" =>  "Otros gastos generales",
                      "idParent" =>  "5192",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5237",
                      "name" =>  "Depreciaciones, amortizaciones y desvalorizaciones",
                      "idParent" =>  "5192",
                      "children" =>  [
                        [
                          "id" =>  "5238",
                          "name" =>  "Deterioro de cuentas por cobrar",
                          "idParent" =>  "5237",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5239",
                          "name" =>  "Depreciaci\u00f3n de propiedad, planta y equipo",
                          "idParent" =>  "5237",
                          "children" =>  [
                            [
                              "id" =>  "5240",
                              "name" =>  "Depreciaci\u00f3n Construcciones y edificaciones",
                              "idParent" =>  "5239",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5241",
                              "name" =>  "Depreciaci\u00f3n Equipo de oficina",
                              "idParent" =>  "5239",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5242",
                              "name" =>  "Depreciaci\u00f3n furniture",
                              "idParent" =>  "5239",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5243",
                              "name" =>  "Depreciaci\u00f3n Equipo de computaci\u00f3n",
                              "idParent" =>  "5239",
                              "children" =>  []
                            ],
                            [
                              "id" =>  "5244",
                              "name" =>  "Depreciaci\u00f3n Flota y equipos de transporte",
                              "idParent" =>  "5239",
                              "children" =>  []
                            ]
                          ]
                        ]
                      ]
                    ]
                  ]
                ],
                [
                  "id" =>  "5245",
                  "name" =>  "Gastos financieros",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5246",
                      "name" =>  "Gastos por Intereses financieros",
                      "idParent" =>  "5245",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5247",
                      "name" =>  "Gastos por Intereses de mora",
                      "idParent" =>  "5245",
                      "children" =>  []
                    ]
                  ]
                ],
                [
                  "id" =>  "5248",
                  "name" =>  "Otros gastos",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5249",
                      "name" =>  "Comisiones bancarias",
                      "idParent" =>  "5248",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5250",
                      "name" =>  "P\u00e9rdida en venta de Activos",
                      "idParent" =>  "5248",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5251",
                      "name" =>  "P\u00e9rdida por disposici\u00f3n de activos",
                      "idParent" =>  "5248",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5252",
                      "name" =>  "P\u00e9rdida por diferencia en cambio",
                      "idParent" =>  "5248",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5253",
                      "name" =>  "Ajustes por aproximaciones en c\u00e1lculos",
                      "idParent" =>  "5248",
                      "children" =>  []
                    ]
                  ]
                ],
                [
                  "id" =>  "5254",
                  "name" =>  "Gastos por impuestos",
                  "idParent" =>  "5157",
                  "children" =>  [
                    [
                      "id" =>  "5255",
                      "name" =>  "Impuestos de renta y complementarios",
                      "idParent" =>  "5254",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5256",
                      "name" =>  "Gastos por impuestos no acreditables",
                      "idParent" =>  "5254",
                      "children" =>  []
                    ],
                    [
                      "id" =>  "5257",
                      "name" =>  "Retenci\u00f3n en la fuente asumida",
                      "idParent" =>  "5254",
                      "children" =>  []
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5258",
              "name" =>  "Costos",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5259",
                  "name" =>  "Costos de ventas y operaci\u00f3n",
                  "idParent" =>  "5258",
                  "children" =>  [
                    [
                      "id" =>  "5260",
                      "name" =>  "Costos de la mercanc\u00eda vendida",
                      "idParent" =>  "5259",
                      "children" =>  [
                        [
                          "id" =>  "5261",
                          "name" =>  "Costos del inventario",
                          "idParent" =>  "5260",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5262",
                          "name" =>  "Ajustes al inventario",
                          "idParent" =>  "5260",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5263",
                          "name" =>  "Descuentos financieros",
                          "idParent" =>  "5260",
                          "children" =>  []
                        ],
                        [
                          "id" =>  "5264",
                          "name" =>  "Devoluciones en compras de inventario",
                          "idParent" =>  "5260",
                          "children" =>  []
                        ]
                      ]
                    ],
                    [
                      "id" =>  "5265",
                      "name" =>  "Costo de los servicios vendidos",
                      "idParent" =>  "5259",
                      "children" =>  []
                    ]
                  ]
                ]
              ]
            ],
            [
              "id" =>  "5266",
              "name" =>  "Costos de producci\u00f3n",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5267",
                  "name" =>  "Materia prima directa",
                  "idParent" =>  "5266",
                  "children" =>  []
                ],
                [
                  "id" =>  "5268",
                  "name" =>  "Mano de obra",
                  "idParent" =>  "5266",
                  "children" =>  []
                ],
                [
                  "id" =>  "5269",
                  "name" =>  "Costos indirectos",
                  "idParent" =>  "5266",
                  "children" =>  []
                ],
                [
                  "id" =>  "5270",
                  "name" =>  "Contratos de servicios",
                  "idParent" =>  "5266",
                  "children" =>  []
                ]
              ]
            ],
            [
              "id" =>  "5271",
              "name" =>  "Cuentas de orden",
              "idParent" =>  null,
              "children" =>  [
                [
                  "id" =>  "5272",
                  "name" =>  "Cuentas de orden deudoras",
                  "idParent" =>  "5271",
                  "children" =>  []
                ],
                [
                  "id" =>  "5273",
                  "name" =>  "Cuentas de orden acreedoras",
                  "idParent" =>  "5271",
                  "children" =>  []
                ]
              ]
            ],
            [
              "id" =>  "5274",
              "name" =>  "Transferencias bancarias",
              "idParent" =>  null,
              "children" =>  []
            ]
        ];

        $this->saveAccounts($datos);
    }

    function saveAccounts($accounts, &$codeToIdMap = [], $parentCode = null) {
        foreach ($accounts as $account) {
            $codigo = $account['id'];
            $nombre = $account['name'];
    
            $clasificacion = $this->getClasificacion($parentCode);
            $type = (!empty($account['children'])) ? 'CMA' : 'CMO';
    
            $idParent = $parentCode ? ($codeToIdMap[$parentCode] ?? null) : null;
    
            $decoded = json_decode('"' . $nombre . '"');

            $data = [
                'codigo'        => $codigo,
                'nombre'        => $decoded,
                'clasificacion' => $clasificacion,
                'estado'        => 1,
                'type'          => $type,
                'id_parent'     => $idParent
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
