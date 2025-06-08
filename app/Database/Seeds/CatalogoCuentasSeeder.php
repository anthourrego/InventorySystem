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
            "codigo" => "1",
            "name" => "Activo",
            "children" => [
              [
                "codigo" => "11",
                "name" => "Disponible",
                "children" => [
                    [
                        "codigo" => "1105",
                        "name" => "Caja",
                        "children" => [
                            [
                                "codigo" => "110505",
                                "name" => "Caja general",
                            ],
                            [
                                "codigo" => "110510",
                                "name" => "Cajas menores",
                            ],
                            [
                                "codigo" => "110515",
                                "name" => "Moneda extranjera",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1110",
                        "name" => "Bancos",
                        "children" => [
                            [
                                "codigo" => "111005",
                                "name" => "Moneda nacional",
                            ],
                            [
                                "codigo" => "111010",
                                "name" => "Moneda extranjera",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1115",
                        "name" => "Remesas en tránsito",
                        "children" => [
                            [
                                "codigo" => "111505",
                                "name" => "Moneda nacional",
                            ],
                            [
                                "codigo" => "111510",
                                "name" => "Moneda extranjera",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1120",
                        "name" => "Cuentas de ahorro",
                        "children" => [
                            [
                                "codigo" => "112005",
                                "name" => "Bancos",
                            ],
                            [
                                "codigo" => "112010",
                                "name" => "Corporaciones de ahorro y vivienda",
                            ],
                            [
                                "codigo" => "112015",
                                "name" => "Organismos cooperativos financieros",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1125",
                        "name" => "Fondos",
                        "children" => [
                            [
                                "codigo" => "112505",
                                "name" => "Rotatorios moneda nacional",
                            ],
                            [
                                "codigo" => "112510",
                                "name" => "Rotatorios moneda extranjera",
                            ],
                            [
                                "codigo" => "112515",
                                "name" => "Especiales moneda nacional",
                            ],
                            [
                                "codigo" => "112520",
                                "name" => "Especiales moneda extranjera",
                            ],
                            [
                                "codigo" => "112525",
                                "name" => "De amortización moneda nacional",
                            ],
                            [
                                "codigo" => "112530",
                                "name" => "De amortización moneda extranjera",
                            ],
                        ],
                    ],
                ],
              ],[
                "codigo" => "12",
                "name" => "Inversiones",
                "children" => [
                    [
                        "codigo" => "1205",
                        "name" => "Acciones",
                        "children" => [
                            [
                                "codigo" => "120505",
                                "name" => "Agricultura, ganadería, caza y silvicultura",
                            ],
                            [
                                "codigo" => "120510",
                                "name" => "Pesca",
                            ],
                            [
                                "codigo" => "120515",
                                "name" => "Explotación de minas y canteras",
                            ],
                            [
                                "codigo" => "120520",
                                "name" => "Industria manufacturera",
                            ],
                            [
                                "codigo" => "120525",
                                "name" => "Suministro de electricidad, gas y agua",
                            ],
                            [
                                "codigo" => "120530",
                                "name" => "Construcción",
                            ],
                            [
                                "codigo" => "120535",
                                "name" => "Comercio al por mayor y al por menor",
                            ],
                            [
                                "codigo" => "120540",
                                "name" => "Hoteles y restaurantes",
                            ],
                            [
                                "codigo" => "120545",
                                "name" => "Transporte, almacenamiento y comunicaciones",
                            ],
                            [
                                "codigo" => "120550",
                                "name" => "Actividad financiera",
                            ],
                            [
                                "codigo" => "120555",
                                "name" => "Actividades inmobiliarias, empresariales y de alquiler",
                            ],
                            [
                                "codigo" => "120560",
                                "name" => "Enseñanza",
                            ],
                            [
                                "codigo" => "120565",
                                "name" => "Servicios sociales y de salud",
                            ],
                            [
                                "codigo" => "120570",
                                "name" => "Otras actividades de servicios comunitarios, sociales y personales",
                            ],
                            [
                                "codigo" => "120599",
                                "name" => "Ajustes por inflación",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1210",
                        "name" => "Cuotas o partes de interés social",
                        "children" => [
                            [
                                "codigo" => "121005",
                                "name" => "Agricultura, ganadería, caza y silvicultura",
                            ],
                            [
                                "codigo" => "121010",
                                "name" => "Pesca",
                            ],
                            [
                                "codigo" => "121015",
                                "name" => "Explotación de minas y canteras",
                            ],
                            [
                                "codigo" => "121020",
                                "name" => "Industria manufacturera",
                            ],
                            [
                                "codigo" => "121025",
                                "name" => "Suministro de electricidad, gas y agua",
                            ],
                            [
                                "codigo" => "121030",
                                "name" => "Construcción",
                            ],
                            [
                                "codigo" => "121035",
                                "name" => "Comercio al por mayor y al por menor",
                            ],
                            [
                                "codigo" => "121040",
                                "name" => "Hoteles y restaurantes",
                            ],
                            [
                                "codigo" => "121045",
                                "name" => "Transporte, almacenamiento y comunicaciones",
                            ],
                            [
                                "codigo" => "121050",
                                "name" => "Actividad financiera",
                            ],
                            [
                                "codigo" => "121055",
                                "name" => "Actividades inmobiliarias, empresariales y de alquiler",
                            ],
                            [
                                "codigo" => "121060",
                                "name" => "Enseñanza",
                            ],
                            [
                                "codigo" => "121065",
                                "name" => "Servicios sociales y de salud",
                            ],
                            [
                                "codigo" => "121070",
                                "name" => "Otras actividades de servicios comunitarios, sociales y personales",
                            ],
                            [
                                "codigo" => "121099",
                                "name" => "Ajustes por inflación",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1215",
                        "name" => "Bonos",
                        "children" => [
                            [
                                "codigo" => "121505",
                                "name" => "Bonos públicos moneda nacional",
                            ],
                            [
                                "codigo" => "121510",
                                "name" => "Bonos públicos moneda extranjera",
                            ],
                            [
                                "codigo" => "121515",
                                "name" => "Bonos ordinarios",
                            ],
                            [
                                "codigo" => "121520",
                                "name" => "Bonos convertibles en acciones",
                            ],
                            [
                                "codigo" => "121595",
                                "name" => "Otros",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1220",
                        "name" => "Cédulas",
                        "children" => [
                            [
                                "codigo" => "122005",
                                "name" => "Cédulas de capitalización",
                            ],
                            [
                                "codigo" => "122010",
                                "name" => "Cédulas hipotecarias",
                            ],
                            [
                                "codigo" => "122015",
                                "name" => "Cédulas de inversión",
                            ],
                            [
                                "codigo" => "122095",
                                "name" => "Otras",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1225",
                        "name" => "Certificados",
                        "children" => [
                            [
                                "codigo" => "122505",
                                "name" => "Certificados de depósito a término (CDT)",
                            ],
                            [
                                "codigo" => "122510",
                                "name" => "Certificados de depósito de ahorro",
                            ],
                            [
                                "codigo" => "122515",
                                "name" => "Certificados de ahorro de valor constante (CAVC)",
                            ],
                            [
                                "codigo" => "122520",
                                "name" => "Certificados de cambio",
                            ],
                            [
                                "codigo" => "122525",
                                "name" => "Certificados cafeteros valorizables",
                            ],
                            [
                                "codigo" => "122530",
                                "name" => "Certificados eléctricos valorizables (CEV)",
                            ],
                            [
                                "codigo" => "122535",
                                "name" => "Certificados de reembolso tributario (CERT)",
                            ],
                            [
                                "codigo" => "122540",
                                "name" => "Certificados de desarrollo turístico",
                            ],
                            [
                                "codigo" => "122545",
                                "name" => "Certificados de inversión forestal (CIF)",
                            ],
                            [
                                "codigo" => "122595",
                                "name" => "Otros",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1230",
                        "name" => "Papeles comerciales",
                        "children" => [
                            [
                                "codigo" => "123005",
                                "name" => "Empresas comerciales",
                            ],
                            [
                                "codigo" => "123010",
                                "name" => "Empresas industriales",
                            ],
                            [
                                "codigo" => "123015",
                                "name" => "Empresas de servicios",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1235",
                        "name" => "Títulos",
                        "children" => [
                            [
                                "codigo" => "123505",
                                "name" => "Títulos de desarrollo agropecuario",
                            ],
                            [
                                "codigo" => "123510",
                                "name" => "Títulos canjeables por certificados de cambio",
                            ],
                            [
                                "codigo" => "123515",
                                "name" => "Títulos de tesorería (TES)",
                            ],
                            [
                                "codigo" => "123520",
                                "name" => "Títulos de participación",
                            ],
                            [
                                "codigo" => "123525",
                                "name" => "Títulos de crédito de fomento",
                            ],
                            [
                                "codigo" => "123530",
                                "name" => "Títulos financieros agroindustriales (TFA)",
                            ],
                            [
                                "codigo" => "123535",
                                "name" => "Títulos de ahorro cafetero (TAC)",
                            ],
                            [
                                "codigo" => "123540",
                                "name" => "Títulos de ahorro nacional (TAN)",
                            ],
                            [
                                "codigo" => "123545",
                                "name" => "Títulos energéticos de rentabilidad creciente (TER)",
                            ],
                            [
                                "codigo" => "123550",
                                "name" => "Títulos de ahorro educativo (TAE)",
                            ],
                            [
                                "codigo" => "123555",
                                "name" => "Títulos financieros industriales y comerciales",
                            ],
                            [
                                "codigo" => "123560",
                                "name" => "Tesoros",
                            ],
                            [
                                "codigo" => "123565",
                                "name" => "Títulos de devolución de impuestos nacionales (TIDIS)",
                            ],
                            [
                                "codigo" => "123570",
                                "name" => "Títulos inmobiliarios",
                            ],
                            [
                                "codigo" => "123595",
                                "name" => "Otros",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1240",
                        "name" => "Aceptaciones bancarias o financieras",
                        "children" => [
                            [
                                "codigo" => "124005",
                                "name" => "Bancos comerciales",
                            ],
                            [
                                "codigo" => "124010",
                                "name" => "Compañías de financiamiento comercial",
                            ],
                            [
                                "codigo" => "124015",
                                "name" => "Corporaciones financieras",
                            ],
                            [
                                "codigo" => "124095",
                                "name" => "Otras",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1245",
                        "name" => "Derechos fiduciarios",
                        "children" => [
                            [
                                "codigo" => "124505",
                                "name" => "Fideicomisos de inversión moneda nacional",
                            ],
                            [
                                "codigo" => "124510",
                                "name" => "Fideicomisos de inversión moneda extranjera",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1250",
                        "name" => "Derechos de recompra de inversiones negociadas (repos)",
                        "children" => [
                            [
                                "codigo" => "125005",
                                "name" => "Acciones",
                            ],
                            [
                                "codigo" => "125010",
                                "name" => "Cuotas o partes de interés social",
                            ],
                            [
                                "codigo" => "125015",
                                "name" => "Bonos",
                            ],
                            [
                                "codigo" => "125020",
                                "name" => "Cédulas",
                            ],
                            [
                                "codigo" => "125025",
                                "name" => "Certificados",
                            ],
                            [
                                "codigo" => "125030",
                                "name" => "Papeles comerciales",
                            ],
                            [
                                "codigo" => "125035",
                                "name" => "Títulos",
                            ],
                            [
                                "codigo" => "125040",
                                "name" => "Aceptaciones bancarias o financieras",
                            ],
                            [
                                "codigo" => "125095",
                                "name" => "Otros",
                            ],
                            [
                                "codigo" => "125099",
                                "name" => "Ajustes por inflación",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1255",
                        "name" => "Obligatorias",
                        "children" => [
                            [
                                "codigo" => "125505",
                                "name" => "Bonos de financiamiento especial",
                            ],
                            [
                                "codigo" => "125510",
                                "name" => "Bonos de financiamiento presupuestal",
                            ],
                            [
                                "codigo" => "125515",
                                "name" => "Bonos para desarrollo social y seguridad interna (BDSI)",
                            ],
                            [
                                "codigo" => "125595",
                                "name" => "Otras",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1260",
                        "name" => "Cuentas en participación",
                        "children" => [
                            [
                                "codigo" => "126099",
                                "name" => "Ajustes por inflación",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1295",
                        "name" => "Otras inversiones",
                        "children" => [
                            [
                                "codigo" => "129505",
                                "name" => "Aportes en cooperativas",
                            ],
                            [
                                "codigo" => "129510",
                                "name" => "Derechos en clubes sociales",
                            ],
                            [
                                "codigo" => "129515",
                                "name" => "Acciones o derechos en clubes deportivos",
                            ],
                            [
                                "codigo" => "129520",
                                "name" => "Bonos en colegios",
                            ],
                            [
                                "codigo" => "129595",
                                "name" => "Diversas",
                            ],
                            [
                                "codigo" => "129599",
                                "name" => "Ajustes por inflación",
                            ],
                        ]
                    
                    ],
                    [
                        "codigo" => "1299",
                        "name" => "Provisiones",
                        "children" => [
                            [
                                "codigo" => "129905",
                                "name" => "Acciones",
                            ],
                            [
                                "codigo" => "129910",
                                "name" => "Cuotas o partes de interés social",
                            ],
                            [
                                "codigo" => "129915",
                                "name" => "Bonos",
                            ],
                            [
                                "codigo" => "129920",
                                "name" => "Cédulas",
                            ],
                            [
                                "codigo" => "129925",
                                "name" => "Certificados",
                            ],
                            [
                                "codigo" => "129930",
                                "name" => "Papeles comerciales",
                            ],
                            [
                                "codigo" => "129935",
                                "name" => "Títulos",
                            ],
                            [
                                "codigo" => "129940",
                                "name" => "Aceptaciones bancarias o financieras",
                            ],
                            [
                                "codigo" => "129945",
                                "name" => "Derechos fiduciarios",
                            ],
                            [
                                "codigo" => "129950",
                                "name" => "Derechos de recompra de inversiones negociadas",
                            ],
                            [
                                "codigo" => "129955",
                                "name" => "Obligatorias",
                            ],
                            [
                                "codigo" => "129960",
                                "name" => "Cuentas en participación",
                            ],
                            [
                                "codigo" => "129995",
                                "name" => "Otras inversiones",
                            ],
                        ]
                    
                    ],
                ]
              ],[
                "codigo" => "13",
                "name" => "Deudores",
                "children" => [
                    [
                        "codigo" => "1305",
                        "name" => "Clientes",
                        "children" => [
                            [
                                "codigo" => "130505",
                                "name" => "Nacionales",
                            ],
                            [
                                "codigo" => "130510",
                                "name" => "Del exterior",
                            ],
                            [
                                "codigo" => "130515",
                                "name" => "Deudores del sistema",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1310",
                        "name" => "Cuentas corrientes comerciales",
                        "children" => [
                            [
                                "codigo" => "131005",
                                "name" => "Casa matriz",
                            ],
                            [
                                "codigo" => "131010",
                                "name" => "Compañías vinculadas",
                            ],
                            [
                                "codigo" => "131015",
                                "name" => "Accionistas o socios",
                            ],
                            [
                                "codigo" => "131020",
                                "name" => "Particulares",
                            ],
                            [
                                "codigo" => "131095",
                                "name" => "Otras",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1315",
                        "name" => "Cuentas por cobrar a casa matriz",
                        "children" => [
                            [
                                "codigo" => "131505",
                                "name" => "Ventas",
                            ],
                            [
                                "codigo" => "131510",
                                "name" => "Pagos a nombre de casa matriz",
                            ],
                            [
                                "codigo" => "131515",
                                "name" => "Valores recibidos por casa matriz",
                            ],
                            [
                                "codigo" => "131520",
                                "name" => "Préstamos",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1320",
                        "name" => "Cuentas por cobrar a vinculados económicos",
                        "children" => [
                            [
                                "codigo" => "132005",
                                "name" => "Filiales",
                            ],
                            [
                                "codigo" => "132010",
                                "name" => "Subsidiarias",
                            ],
                            [
                                "codigo" => "132015",
                                "name" => "Sucursales",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1323",
                        "name" => "Cuentas por cobrar a directores",
                    ],
                    [
                        "codigo" => "1325",
                        "name" => "Cuentas por cobrar a socios y accionistas",
                        "children" => [
                            [
                                "codigo" => "132505",
                                "name" => "A socios",
                            ],
                            [
                                "codigo" => "132510",
                                "name" => "A accionistas",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1328",
                        "name" => "Aportes por cobrar",
                    ],
                    [
                      "codigo" => "1330",
                      "name" => "Anticipos y avances",
                      "children" => [
                          [
                              "codigo" => "133005",
                              "name" => "A proveedores",
                          ],
                          [
                              "codigo" => "133010",
                              "name" => "A contratistas",
                          ],
                          [
                              "codigo" => "133015",
                              "name" => "A trabajadores",
                          ],
                          [
                              "codigo" => "133020",
                              "name" => "A agentes",
                          ],
                          [
                              "codigo" => "133025",
                              "name" => "A concesionarios",
                          ],
                          [
                              "codigo" => "133030",
                              "name" => "De adjudicaciones",
                          ],
                          [
                              "codigo" => "133095",
                              "name" => "Otros",
                          ],
                          [
                              "codigo" => "133099",
                              "name" => "Ajustes por inflación",
                          ],
                      ],
                    ],
                    [
                        "codigo" => "1332",
                        "name" => "Cuentas de operación conjunta",
                    ],
                    [
                        "codigo" => "1335",
                        "name" => "Depósitos",
                        "children" => [
                            [
                                "codigo" => "133505",
                                "name" => "Para importaciones",
                            ],
                            [
                                "codigo" => "133510",
                                "name" => "Para servicios",
                            ],
                            [
                                "codigo" => "133515",
                                "name" => "Para contratos",
                            ],
                            [
                                "codigo" => "133520",
                                "name" => "Para responsabilidades",
                            ],
                            [
                                "codigo" => "133525",
                                "name" => "Para juicios ejecutivos",
                            ],
                            [
                                "codigo" => "133530",
                                "name" => "Para adquisición de acciones, cuotas o derechos sociales",
                            ],
                            [
                                "codigo" => "133535",
                                "name" => "En garantía",
                            ],
                            [
                                "codigo" => "133595",
                                "name" => "Otros",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1340",
                        "name" => "Promesas de compra venta",
                        "children" => [
                            [
                                "codigo" => "134005",
                                "name" => "De bienes raíces",
                            ],
                            [
                                "codigo" => "134010",
                                "name" => "De maquinaria y equipo",
                            ],
                            [
                                "codigo" => "134015",
                                "name" => "De flota y equipo de transporte",
                            ],
                            [
                                "codigo" => "134020",
                                "name" => "De flota y equipo aéreo",
                            ],
                            [
                                "codigo" => "134025",
                                "name" => "De flota y equipo férreo",
                            ],
                            [
                                "codigo" => "134030",
                                "name" => "De flota y equipo fluvial y/o marítimo",
                            ],
                            [
                                "codigo" => "134035",
                                "name" => "De semovientes",
                            ],
                            [
                                "codigo" => "134095",
                                "name" => "De otros bienes",
                            ],
                        ],
                    ],
                    [
                      "codigo" => "1345",
                      "name" => "Ingresos por cobrar",
                      "children" => [
                          [
                              "codigo" => "134505",
                              "name" => "Dividendos y/o participaciones",
                          ],
                          [
                              "codigo" => "134510",
                              "name" => "Intereses",
                          ],
                          [
                              "codigo" => "134515",
                              "name" => "Comisiones",
                          ],
                          [
                              "codigo" => "134520",
                              "name" => "Honorarios",
                          ],
                          [
                              "codigo" => "134525",
                              "name" => "Servicios",
                          ],
                          [
                              "codigo" => "134530",
                              "name" => "Arrendamientos",
                          ],
                          [
                              "codigo" => "134535",
                              "name" => "CERT por cobrar",
                          ],
                          [
                              "codigo" => "134595",
                              "name" => "Otros",
                          ],
                      ],
                    ],
                    [
                      "codigo" => "1350",
                      "name" => "Retención sobre contratos",
                      "children" => [
                          [
                              "codigo" => "135005",
                              "name" => "De construcción",
                          ],
                          [
                              "codigo" => "135010",
                              "name" => "De prestación de servicios",
                          ],
                          [
                              "codigo" => "135095",
                              "name" => "Otros",
                          ],
                      ],
                    ],
                    [
                        "codigo" => "1355",
                        "name" => "Anticipo de impuestos y contribuciones o saldos a favor",
                        "children" => [
                            [
                                "codigo" => "135505",
                                "name" => "Anticipo de impuestos de renta y complementarios",
                            ],
                            [
                                "codigo" => "135510",
                                "name" => "Anticipo de impuestos de industria y comercio",
                            ],
                            [
                                "codigo" => "135515",
                                "name" => "Retención en la fuente",
                            ],
                            [
                                "codigo" => "135517",
                                "name" => "Impuesto a las ventas retenido",
                            ],
                            [
                                "codigo" => "135518",
                                "name" => "Impuesto de industria y comercio retenido",
                            ],
                            [
                                "codigo" => "135520",
                                "name" => "Sobrantes en liquidación privada de impuestos",
                            ],
                            [
                                "codigo" => "135525",
                                "name" => "Contribuciones",
                            ],
                            [
                                "codigo" => "135530",
                                "name" => "Impuestos descontables",
                            ],
                            [
                                "codigo" => "135595",
                                "name" => "Otros",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1360",
                        "name" => "Reclamaciones",
                        "children" => [
                            [
                                "codigo" => "136005",
                                "name" => "A compañías aseguradoras",
                            ],
                            [
                                "codigo" => "136010",
                                "name" => "A transportadores",
                            ],
                            [
                                "codigo" => "136015",
                                "name" => "Por tiquetes aéreos",
                            ],
                            [
                                "codigo" => "136095",
                                "name" => "Otras",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1365",
                        "name" => "Cuentas por cobrar a trabajadores",
                        "children" => [
                            [
                                "codigo" => "136505",
                                "name" => "Vivienda",
                            ],
                            [
                                "codigo" => "136510",
                                "name" => "Vehículos",
                            ],
                            [
                                "codigo" => "136515",
                                "name" => "Educación",
                            ],
                            [
                                "codigo" => "136520",
                                "name" => "Médicos, odontológicos y similares",
                            ],
                            [
                                "codigo" => "136525",
                                "name" => "Calamidad doméstica",
                            ],
                            [
                                "codigo" => "136530",
                                "name" => "Responsabilidades",
                            ],
                            [
                                "codigo" => "136595",
                                "name" => "Otros",
                            ],
                        ],
                    ],
                    [
                      "codigo" => "1370",
                      "name" => "Préstamos a particulares",
                      "children" => [
                          [
                              "codigo" => "137005",
                              "name" => "Con garantía real",
                          ],
                          [
                              "codigo" => "137010",
                              "name" => "Con garantía personal",
                          ],
                      ],
                    ],
                    [
                      "codigo" => "1380",
                      "name" => "Deudores varios",
                      "children" => [
                          [
                              "codigo" => "138005",
                              "name" => "Depositarios",
                          ],
                          [
                              "codigo" => "138010",
                              "name" => "Comisionistas de bolsas",
                          ],
                          [
                              "codigo" => "138015",
                              "name" => "Fondo de inversión",
                          ],
                          [
                              "codigo" => "138020",
                              "name" => "Cuentas por cobrar de terceros",
                          ],
                          [
                              "codigo" => "138025",
                              "name" => "Pagos por cuenta de terceros",
                          ],
                          [
                              "codigo" => "138030",
                              "name" => "Fondos de inversión social",
                          ],
                          [
                              "codigo" => "138095",
                              "name" => "Otros",
                          ],
                      ],
                    ],
                    [
                        "codigo" => "1385",
                        "name" => "Derechos de recompra de cartera negociada",
                    ],
                    [
                        "codigo" => "1390",
                        "name" => "Deudas de difícil cobro",
                    ],
                    [
                        "codigo" => "1399",
                        "name" => "Provisiones",
                        "children" => [
                            [
                                "codigo" => "139905",
                                "name" => "Clientes",
                            ],
                            [
                                "codigo" => "139910",
                                "name" => "Cuentas corrientes comerciales",
                            ],
                            [
                                "codigo" => "139915",
                                "name" => "Cuentas por cobrar a casa matriz",
                            ],
                            [
                                "codigo" => "139920",
                                "name" => "Cuentas por cobrar a vinculados económicos",
                            ],
                            [
                                "codigo" => "139925",
                                "name" => "Cuentas por cobrar a socios y accionistas",
                            ],
                            [
                                "codigo" => "139930",
                                "name" => "Anticipos y avances",
                            ],
                            [
                                "codigo" => "139932",
                                "name" => "Cuentas de operación conjunta",
                            ],
                            [
                                "codigo" => "139935",
                                "name" => "Depósitos",
                            ],
                            [
                                "codigo" => "139940",
                                "name" => "Promesas de compraventa",
                            ],
                            [
                                "codigo" => "139945",
                                "name" => "Ingresos por cobrar",
                            ],
                            [
                                "codigo" => "139950",
                                "name" => "Retención sobre contratos",
                            ],
                            [
                                "codigo" => "139955",
                                "name" => "Reclamaciones",
                            ],
                            [
                                "codigo" => "139960",
                                "name" => "Cuentas por cobrar a trabajadores",
                            ],
                            [
                                "codigo" => "139965",
                                "name" => "Préstamos a particulares",
                            ],
                            [
                                "codigo" => "139975",
                                "name" => "Deudores varios",
                            ],
                            [
                                "codigo" => "139980",
                                "name" => "Derechos de recompra de cartera negociada",
                            ],
                        ],
                    ]
                ],
              ],[
                "codigo" => "14",
                "name" => "Inventarios",
                "children" => [
                    [
                        "codigo" => "1405",
                        "name" => "Materias primas",
                        "children" => [
                            [
                                "codigo" => "140599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1410",
                        "name" => "Productos en proceso",
                        "children" => [
                            [
                                "codigo" => "141099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1415",
                        "name" => "Obras de construcción en curso",
                        "children" => [
                            [
                                "codigo" => "141599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1417",
                        "name" => "Obras de urbanismo",
                        "children" => [
                            [
                                "codigo" => "141799",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1420",
                        "name" => "Contratos en ejecución",
                        "children" => [
                            [
                                "codigo" => "142099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1425",
                        "name" => "Cultivos en desarrollo",
                        "children" => [
                            [
                                "codigo" => "142599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1428",
                        "name" => "Plantaciones agrícolas",
                        "children" => [
                            [
                                "codigo" => "142899",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1430",
                        "name" => "Productos terminados",
                        "children" => [
                            [
                                "codigo" => "143005",
                                "name" => "Productos manufacturados",
                            ],
                            [
                                "codigo" => "143010",
                                "name" => "Productos extraídos y/o procesados",
                            ],
                            [
                                "codigo" => "143015",
                                "name" => "Productos agrícolas y forestales",
                            ],
                            [
                                "codigo" => "143020",
                                "name" => "Subproductos",
                            ],
                            [
                                "codigo" => "143025",
                                "name" => "Productos de pesca",
                            ],
                            [
                                "codigo" => "143099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1435",
                        "name" => "Mercancías no fabricadas por la empresa",
                        "children" => [
                            [
                                "codigo" => "143599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1440",
                        "name" => "Bienes raíces para la venta",
                        "children" => [
                            [
                                "codigo" => "144099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1445",
                        "name" => "Semovientes",
                        "children" => [
                            [
                                "codigo" => "144599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1450",
                        "name" => "Terrenos",
                        "children" => [
                            [
                                "codigo" => "145005",
                                "name" => "Por urbanizar",
                            ],
                            [
                                "codigo" => "145010",
                                "name" => "Urbanizados por construir",
                            ],
                            [
                                "codigo" => "145099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1455",
                        "name" => "Materiales, repuestos y accesorios",
                        "children" => [
                            [
                                "codigo" => "145599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1460",
                        "name" => "Envases y empaques",
                        "children" => [
                            [
                                "codigo" => "146099",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1465",
                        "name" => "Inventarios en tránsito",
                        "children" => [
                            [
                                "codigo" => "146599",
                                "name" => "Ajustes por inflación",
                            ],
                        ],
                    ],
                    [
                        "codigo" => "1499",
                        "name" => "Provisiones",
                        "children" => [
                            [
                                "codigo" => "149905",
                                "name" => "Para obsolescencia",
                            ],
                            [
                                "codigo" => "149910",
                                "name" => "Para diferencia de inventario físico",
                            ],
                            [
                                "codigo" => "149915",
                                "name" => "Para pérdidas de inventarios",
                            ],
                            [
                                "codigo" => "149920",
                                "name" => "Lifo",
                            ],
                        ],
                    ],
                ],
              ],[
                "codigo" => "15",
                "name" => "Propiedades, planta y equipo",
                "children" => [
                    [
                        "codigo" => "1504",
                        "name" => "Terrenos",
                        "children" => [
                            ["codigo" => "150405", "name" => "Urbanos"],
                            ["codigo" => "150410", "name" => "Rurales"],
                            ["codigo" => "150499", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1506",
                        "name" => "Materiales proyectos petroleros",
                        "children" => [
                            ["codigo" => "150605", "name" => "Tuberías y equipo"],
                            ["codigo" => "150610", "name" => "Costos de importación materiales"],
                            ["codigo" => "150615", "name" => "Proyectos de construcción"],
                            ["codigo" => "150699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1508",
                        "name" => "Construcciones en curso",
                        "children" => [
                            ["codigo" => "150805", "name" => "Construcciones y edificaciones"],
                            ["codigo" => "150810", "name" => "Acueductos, plantas y redes"],
                            ["codigo" => "150815", "name" => "Vías de comunicación"],
                            ["codigo" => "150820", "name" => "Pozos artesianos"],
                            ["codigo" => "150825", "name" => "Proyectos de exploración"],
                            ["codigo" => "150830", "name" => "Proyectos de desarrollo"],
                            ["codigo" => "150899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1512",
                        "name" => "Maquinaria y equipos en montaje",
                        "children" => [
                            ["codigo" => "151205", "name" => "Maquinaria y equipo"],
                            ["codigo" => "151210", "name" => "Equipo de oficina"],
                            ["codigo" => "151215", "name" => "Equipo de computación y comunicación"],
                            ["codigo" => "151220", "name" => "Equipo médico-científico"],
                            ["codigo" => "151225", "name" => "Equipo de hoteles y restaurantes"],
                            ["codigo" => "151230", "name" => "Flota y equipo de transporte"],
                            ["codigo" => "151235", "name" => "Flota y equipo fluvial y/o marítimo"],
                            ["codigo" => "151240", "name" => "Flota y equipo aéreo"],
                            ["codigo" => "151245", "name" => "Flota y equipo férreo"],
                            ["codigo" => "151250", "name" => "Plantas y redes"],
                            ["codigo" => "151299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1516",
                        "name" => "Construcciones y edificaciones",
                        "children" => [
                            ["codigo" => "151605", "name" => "Edificios"],
                            ["codigo" => "151610", "name" => "Oficinas"],
                            ["codigo" => "151615", "name" => "Almacenes"],
                            ["codigo" => "151620", "name" => "Fábricas y plantas industriales"],
                            ["codigo" => "151625", "name" => "Salas de exhibición y ventas"],
                            ["codigo" => "151630", "name" => "Cafetería y casinos"],
                            ["codigo" => "151635", "name" => "Silos"],
                            ["codigo" => "151640", "name" => "Invernaderos"],
                            ["codigo" => "151645", "name" => "Casetas y campamentos"],
                            ["codigo" => "151650", "name" => "Instalaciones agropecuarias"],
                            ["codigo" => "151655", "name" => "Viviendas para empleados y obreros"],
                            ["codigo" => "151660", "name" => "Terminal de buses y taxis"],
                            ["codigo" => "151663", "name" => "Terminal marítimo"],
                            ["codigo" => "151665", "name" => "Terminal férreo"],
                            ["codigo" => "151670", "name" => "Parqueaderos, garajes y depósitos"],
                            ["codigo" => "151675", "name" => "Hangares"],
                            ["codigo" => "151680", "name" => "Bodegas"],
                            ["codigo" => "151695", "name" => "Otros"],
                            ["codigo" => "151699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1520",
                        "name" => "Maquinaria y equipo",
                        "children" => [
                            ["codigo" => "152099", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1524",
                        "name" => "Equipo de oficina",
                        "children" => [
                            ["codigo" => "152405", "name" => "Muebles y enseres"],
                            ["codigo" => "152410", "name" => "Equipos"],
                            ["codigo" => "152495", "name" => "Otros"],
                            ["codigo" => "152499", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1528",
                        "name" => "Equipo de computación y comunicación",
                        "children" => [
                            ["codigo" => "152805", "name" => "Equipos de procesamiento de datos"],
                            ["codigo" => "152810", "name" => "Equipos de telecomunicaciones"],
                            ["codigo" => "152815", "name" => "Equipos de radio"],
                            ["codigo" => "152820", "name" => "Satélites y antenas"],
                            ["codigo" => "152825", "name" => "Líneas telefónicas"],
                            ["codigo" => "152895", "name" => "Otros"],
                            ["codigo" => "152899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1532",
                        "name" => "Equipo médico-científico",
                        "children" => [
                            ["codigo" => "153205", "name" => "Médico"],
                            ["codigo" => "153210", "name" => "Odontológico"],
                            ["codigo" => "153215", "name" => "Laboratorio"],
                            ["codigo" => "153220", "name" => "Instrumental"],
                            ["codigo" => "153295", "name" => "Otros"],
                            ["codigo" => "153299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1536",
                        "name" => "Equipo de hoteles y restaurantes",
                        "children" => [
                            ["codigo" => "153605", "name" => "De habitaciones"],
                            ["codigo" => "153610", "name" => "De comestibles y bebidas"],
                            ["codigo" => "153695", "name" => "Otros"],
                            ["codigo" => "153699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1540",
                        "name" => "Flota y equipo de transporte",
                        "children" => [
                            ["codigo" => "154005", "name" => "Autos, camionetas y camperos"],
                            ["codigo" => "154008", "name" => "Camiones, volquetas y furgones"],
                            ["codigo" => "154010", "name" => "Tractomulas y remolques"],
                            ["codigo" => "154015", "name" => "Buses y busetas"],
                            ["codigo" => "154017", "name" => "Recolectores y contenedores"],
                            ["codigo" => "154020", "name" => "Montacargas"],
                            ["codigo" => "154025", "name" => "Palas y grúas"],
                            ["codigo" => "154030", "name" => "Motocicletas"],
                            ["codigo" => "154035", "name" => "Bicicletas"],
                            ["codigo" => "154040", "name" => "Estibas y carretas"],
                            ["codigo" => "154045", "name" => "Bandas transportadoras"],
                            ["codigo" => "154095", "name" => "Otros"],
                            ["codigo" => "154099", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1544",
                        "name" => "Flota y equipo fluvial y/o marítimo",
                        "children" => [
                            ["codigo" => "154405", "name" => "Buques"],
                            ["codigo" => "154410", "name" => "Lanchas"],
                            ["codigo" => "154415", "name" => "Remolcadoras"],
                            ["codigo" => "154420", "name" => "Botes"],
                            ["codigo" => "154425", "name" => "Boyas"],
                            ["codigo" => "154430", "name" => "Amarres"],
                            ["codigo" => "154435", "name" => "Contenedores y chasises"],
                            ["codigo" => "154440", "name" => "Gabarras"],
                            ["codigo" => "154495", "name" => "Otros"],
                            ["codigo" => "154499", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1548",
                        "name" => "Flota y equipo aéreo",
                        "children" => [
                            ["codigo" => "154805", "name" => "Aviones"],
                            ["codigo" => "154810", "name" => "Avionetas"],
                            ["codigo" => "154815", "name" => "Helicópteros"],
                            ["codigo" => "154820", "name" => "Turbinas y motores"],
                            ["codigo" => "154825", "name" => "Manuales de entrenamiento personal técnico"],
                            ["codigo" => "154830", "name" => "Equipos de vuelo"],
                            ["codigo" => "154895", "name" => "Otros"],
                            ["codigo" => "154899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1552",
                        "name" => "Flota y equipo férreo",
                        "children" => [
                            ["codigo" => "155205", "name" => "Locomotoras"],
                            ["codigo" => "155210", "name" => "Vagones"],
                            ["codigo" => "155215", "name" => "Redes férreas"],
                            ["codigo" => "155295", "name" => "Otros"],
                            ["codigo" => "155299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1556",
                        "name" => "Acueductos, plantas y redes",
                        "children" => [
                            ["codigo" => "155605", "name" => "Instalaciones para agua y energía"],
                            ["codigo" => "155610", "name" => "Acueducto, acequias y canalizaciones"],
                            ["codigo" => "155615", "name" => "Plantas de generación hidráulica"],
                            ["codigo" => "155620", "name" => "Plantas de generación térmica"],
                            ["codigo" => "155625", "name" => "Plantas de generación a gas"],
                            ["codigo" => "155628", "name" => "Plantas de generación diesel, gasolina y petróleo"],
                            ["codigo" => "155630", "name" => "Plantas de distribución"],
                            ["codigo" => "155635", "name" => "Plantas de transmisión y subestaciones"],
                            ["codigo" => "155640", "name" => "Oleoductos"],
                            ["codigo" => "155645", "name" => "Gasoductos"],
                            ["codigo" => "155647", "name" => "Poliductos"],
                            ["codigo" => "155650", "name" => "Redes de distribución"],
                            ["codigo" => "155655", "name" => "Plantas de tratamiento"],
                            ["codigo" => "155660", "name" => "Redes de recolección de aguas negras"],
                            ["codigo" => "155665", "name" => "Instalaciones y equipo de bombeo"],
                            ["codigo" => "155670", "name" => "Redes de distribución de vapor"],
                            ["codigo" => "155675", "name" => "Redes de aire"],
                            ["codigo" => "155680", "name" => "Redes alimentación de gas"],
                            ["codigo" => "155682", "name" => "Redes externas de telefonía"],
                            ["codigo" => "155685", "name" => "Plantas deshidratadoras"],
                            ["codigo" => "155695", "name" => "Otros"],
                            ["codigo" => "155699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1560",
                        "name" => "Armamento de vigilancia",
                        "children" => [
                            ["codigo" => "156099", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1562",
                        "name" => "Envases y empaques",
                        "children" => [
                            ["codigo" => "156299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1564",
                        "name" => "Plantaciones agrícolas y forestales",
                        "children" => [
                            ["codigo" => "156405", "name" => "Cultivos en desarrollo"],
                            ["codigo" => "156410", "name" => "Cultivos amortizables"],
                            ["codigo" => "156499", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1568",
                        "name" => "Vías de comunicación",
                        "children" => [
                            ["codigo" => "156805", "name" => "Pavimentación y patios"],
                            ["codigo" => "156810", "name" => "Vías"],
                            ["codigo" => "156815", "name" => "Puentes"],
                            ["codigo" => "156820", "name" => "Calles"],
                            ["codigo" => "156825", "name" => "Aeródromos"],
                            ["codigo" => "156895", "name" => "Otros"],
                            ["codigo" => "156899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1572",
                        "name" => "Minas y canteras",
                        "children" => [
                            ["codigo" => "157205", "name" => "Minas"],
                            ["codigo" => "157210", "name" => "Canteras"],
                            ["codigo" => "157299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1576",
                        "name" => "Pozos artesianos",
                        "children" => [
                            ["codigo" => "157699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1580",
                        "name" => "Yacimientos",
                        "children" => [
                            ["codigo" => "158099", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1584",
                        "name" => "Semovientes",
                        "children" => [
                            ["codigo" => "158499", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1588",
                        "name" => "Propiedades, planta y equipo en tránsito",
                        "children" => [
                            ["codigo" => "158805", "name" => "Maquinaria y equipo"],
                            ["codigo" => "158810", "name" => "Equipo de oficina"],
                            ["codigo" => "158815", "name" => "Equipo de computación y comunicación"],
                            ["codigo" => "158820", "name" => "Equipo médico-científico"],
                            ["codigo" => "158825", "name" => "Equipo de hoteles y restaurantes"],
                            ["codigo" => "158830", "name" => "Flota y equipo de transporte"],
                            ["codigo" => "158835", "name" => "Flota y equipo fluvial y/o marítimo"],
                            ["codigo" => "158840", "name" => "Flota y equipo aéreo"],
                            ["codigo" => "158845", "name" => "Flota y equipo férreo"],
                            ["codigo" => "158850", "name" => "Plantas y redes"],
                            ["codigo" => "158855", "name" => "Armamento de vigilancia"],
                            ["codigo" => "158860", "name" => "Semovientes"],
                            ["codigo" => "158865", "name" => "Envases y empaques"],
                            ["codigo" => "158899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1592",
                        "name" => "Depreciación acumulada",
                        "children" => [
                            ["codigo" => "159205", "name" => "Construcciones y edificaciones"],
                            ["codigo" => "159210", "name" => "Maquinaria y equipo"],
                            ["codigo" => "159215", "name" => "Equipo de oficina"],
                            ["codigo" => "159220", "name" => "Equipo de computación y comunicación"],
                            ["codigo" => "159225", "name" => "Equipo médico-científico"],
                            ["codigo" => "159230", "name" => "Equipo de hoteles y restaurantes"],
                            ["codigo" => "159235", "name" => "Flota y equipo de transporte"],
                            ["codigo" => "159240", "name" => "Flota y equipo fluvial y/o marítimo"],
                            ["codigo" => "159245", "name" => "Flota y equipo aéreo"],
                            ["codigo" => "159250", "name" => "Flota y equipo férreo"],
                            ["codigo" => "159255", "name" => "Acueductos, plantas y redes"],
                            ["codigo" => "159260", "name" => "Armamento de vigilancia"],
                            ["codigo" => "159265", "name" => "Envases y empaques"],
                            ["codigo" => "159299", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1596",
                        "name" => "Depreciación diferida",
                        "children" => [
                            ["codigo" => "159605", "name" => "Exceso fiscal sobre la contable"],
                            ["codigo" => "159610", "name" => "Defecto fiscal sobre la contable (CR)"],
                            ["codigo" => "159699", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1597",
                        "name" => "Amortización acumulada",
                        "children" => [
                            ["codigo" => "159705", "name" => "Plantaciones agrícolas y forestales"],
                            ["codigo" => "159710", "name" => "Vías de comunicación"],
                            ["codigo" => "159715", "name" => "Semovientes"],
                            ["codigo" => "159799", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1598",
                        "name" => "Agotamiento acumulado",
                        "children" => [
                            ["codigo" => "159805", "name" => "Minas y canteras"],
                            ["codigo" => "159815", "name" => "Pozos artesianos"],
                            ["codigo" => "159820", "name" => "Yacimientos"],
                            ["codigo" => "159899", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1599",
                        "name" => "Provisiones",
                        "children" => [
                            ["codigo" => "159904", "name" => "Terrenos"],
                            ["codigo" => "159906", "name" => "Materiales proyectos petroleros"],
                            ["codigo" => "159908", "name" => "Construcciones en curso"],
                            ["codigo" => "159912", "name" => "Maquinaria en montaje"],
                            ["codigo" => "159916", "name" => "Construcciones y edificaciones"],
                            ["codigo" => "159920", "name" => "Maquinaria y equipo"],
                            ["codigo" => "159924", "name" => "Equipo de oficina"],
                            ["codigo" => "159928", "name" => "Equipo de computación y comunicación"],
                            ["codigo" => "159932", "name" => "Equipo médico-científico"],
                            ["codigo" => "159936", "name" => "Equipo de hoteles y restaurantes"],
                            ["codigo" => "159940", "name" => "Flota y equipo de transporte"],
                            ["codigo" => "159944", "name" => "Flota y equipo fluvial y/o marítimo"],
                            ["codigo" => "159948", "name" => "Flota y equipo aéreo"],
                            ["codigo" => "159952", "name" => "Flota y equipo férreo"],
                            ["codigo" => "159956", "name" => "Acueductos, plantas y redes"],
                            ["codigo" => "159960", "name" => "Armamento de vigilancia"],
                            ["codigo" => "159962", "name" => "Envases y empaques"],
                            ["codigo" => "159964", "name" => "Plantaciones agrícolas y forestales"],
                            ["codigo" => "159968", "name" => "Vías de comunicación"],
                            ["codigo" => "159972", "name" => "Minas y canteras"],
                            ["codigo" => "159980", "name" => "Pozos artesianos"],
                            ["codigo" => "159984", "name" => "Yacimientos"],
                            ["codigo" => "159988", "name" => "Semovientes"],
                            ["codigo" => "159992", "name" => "Propiedades, planta y equipo en tránsito"],
                        ],
                    ],
                ],
              ],[
                "codigo"=> "16",
                "name"=> "Intangibles",
                "children"=> [
                  [
                    "codigo"=> "1605",
                    "name"=> "Crédito mercantil",
                    "children"=> [
                      ["codigo"=> "160505", "name"=> "Formado o estimado"],
                      ["codigo"=> "160510", "name"=> "Adquirido o comprado"],
                      ["codigo"=> "160599", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1610",
                    "name"=> "Marcas",
                    "children"=> [
                      ["codigo"=> "161005", "name"=> "Adquiridas"],
                      ["codigo"=> "161010", "name"=> "Formadas"],
                      ["codigo"=> "161099", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1615",
                    "name"=> "Patentes",
                    "children"=> [
                      ["codigo"=> "161505", "name"=> "Adquiridas"],
                      ["codigo"=> "161510", "name"=> "Formadas"],
                      ["codigo"=> "161599", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1620",
                    "name"=> "Concesiones y franquicias",
                    "children"=> [
                      ["codigo"=> "162005", "name"=> "Concesiones"],
                      ["codigo"=> "162010", "name"=> "Franquicias"],
                      ["codigo"=> "162099", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1625",
                    "name"=> "Derechos",
                    "children"=> [
                      ["codigo"=> "162505", "name"=> "Derechos de autor"],
                      ["codigo"=> "162510", "name"=> "Puesto de bolsa"],
                      ["codigo"=> "162515", "name"=> "En fideicomisos inmobiliarios"],
                      ["codigo"=> "162520", "name"=> "En fideicomisos de garantía"],
                      ["codigo"=> "162525", "name"=> "En fideicomisos de administración"],
                      ["codigo"=> "162530", "name"=> "De exhibición - películas"],
                      ["codigo"=> "162535", "name"=> "En bienes recibidos en arrendamiento financiero (leasing)"],
                      ["codigo"=> "162595", "name"=> "Otros"],
                      ["codigo"=> "162599", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1630",
                    "name"=> "Know how",
                    "children"=> [
                      ["codigo"=> "163099", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1635",
                    "name"=> "Licencias",
                    "children"=> [
                      ["codigo"=> "163599", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1698",
                    "name"=> "Depreciación y/o amortización acumulada",
                    "children"=> [
                      ["codigo"=> "169805", "name"=> "Crédito mercantil"],
                      ["codigo"=> "169810", "name"=> "Marcas"],
                      ["codigo"=> "169815", "name"=> "Patentes"],
                      ["codigo"=> "169820", "name"=> "Concesiones y franquicias"],
                      ["codigo"=> "169830", "name"=> "Derechos"],
                      ["codigo"=> "169835", "name"=> "Know how"],
                      ["codigo"=> "169840", "name"=> "Licencias"],
                      ["codigo"=> "169899", "name"=> "Ajustes por inflación"]
                    ]
                  ],
                  [
                    "codigo"=> "1699",
                    "name"=> "Provisiones"
                  ]
                ]
              ], [
                "codigo" => "17",
                "name" => "Diferidos",
                "children" => [
                    [
                        "codigo" => "1705",
                        "name" => "Gastos pagados por anticipado",
                        "children" => [
                            ["codigo" => "170505", "name" => "Intereses"],
                            ["codigo" => "170510", "name" => "Honorarios"],
                            ["codigo" => "170515", "name" => "Comisiones"],
                            ["codigo" => "170520", "name" => "Seguros y fianzas"],
                            ["codigo" => "170525", "name" => "Arrendamientos"],
                            ["codigo" => "170530", "name" => "Bodegajes"],
                            ["codigo" => "170535", "name" => "Mantenimiento equipos"],
                            ["codigo" => "170540", "name" => "Servicios"],
                            ["codigo" => "170545", "name" => "Suscripciones"],
                            ["codigo" => "170595", "name" => "Otros"],
                        ]
                    ],
                    [
                        "codigo" => "1710",
                        "name" => "Cargos diferidos",
                        "children" => [
                            ["codigo" => "171004", "name" => "Organización y preoperativos"],
                            ["codigo" => "171008", "name" => "Remodelaciones"],
                            ["codigo" => "171012", "name" => "Estudios, investigaciones y proyectos"],
                            ["codigo" => "171016", "name" => "Programas para computador (software)"],
                            ["codigo" => "171020", "name" => "Útiles y papelería"],
                            ["codigo" => "171024", "name" => "Mejoras a propiedades ajenas"],
                            ["codigo" => "171028", "name" => "Contribuciones y afiliaciones"],
                            ["codigo" => "171032", "name" => "Entrenamiento de personal"],
                            ["codigo" => "171036", "name" => "Ferias y exposiciones"],
                            ["codigo" => "171040", "name" => "Licencias"],
                            ["codigo" => "171044", "name" => "Publicidad, propaganda y promoción"],
                            ["codigo" => "171048", "name" => "Elementos de aseo y cafetería"],
                            ["codigo" => "171052", "name" => "Moldes y troqueles"],
                            ["codigo" => "171056", "name" => "Instrumental quirúrgico"],
                            ["codigo" => "171060", "name" => "Dotación y suministro a trabajadores"],
                            ["codigo" => "171064", "name" => "Elementos de ropería y lencería"],
                            ["codigo" => "171068", "name" => "Loza y cristalería"],
                            ["codigo" => "171069", "name" => "Platería"],
                            ["codigo" => "171070", "name" => "Cubiertería"],
                            ["codigo" => "171076", "name" => "Impuesto de renta diferido ?débitos? por diferencias temporales"],
                            ["codigo" => "171080", "name" => "Concursos y licitaciones"],
                            ["codigo" => "171095", "name" => "Otros"],
                            ["codigo" => "171099", "name" => "Ajustes por inflación"],
                        ]
                    ],
                    [
                        "codigo" => "1715",
                        "name" => "Costos de exploración por amortizar",
                        "children" => [
                            ["codigo" => "171505", "name" => "Pozos secos"],
                            ["codigo" => "171510", "name" => "Pozos no comerciales"],
                            ["codigo" => "171515", "name" => "Otros costos de exploración"],
                            ["codigo" => "171599", "name" => "Ajustes por inflación"],
                        ]
                    ],
                    [
                        "codigo" => "1720",
                        "name" => "Costos de explotación y desarrollo",
                        "children" => [
                            ["codigo" => "172005", "name" => "Perforación y explotación"],
                            ["codigo" => "172010", "name" => "Perforaciones campos en desarrollo"],
                            ["codigo" => "172015", "name" => "Facilidades de producción"],
                            ["codigo" => "172020", "name" => "Servicio a pozos"],
                            ["codigo" => "172099", "name" => "Ajustes por inflación"],
                        ]
                    ],
                    [
                        "codigo" => "1730",
                        "name" => "Cargos por corrección monetaria diferida",
                    ],
                    [
                        "codigo" => "1798",
                        "name" => "Amortización acumulada",
                        "children" => [
                            ["codigo" => "179805", "name" => "Costos de exploración por amortizar"],
                            ["codigo" => "179810", "name" => "Costos de explotación y desarrollo"],
                            ["codigo" => "179899", "name" => "Ajustes por inflación"],
                        ]
                    ]
                ]
              ],[
                "codigo" => "18",
                "name" => "Otros activos",
                "children" => [
                    [
                        "codigo" => "1805",
                        "name" => "Bienes de arte y cultura",
                        "children" => [
                            ["codigo" => "180505", "name" => "Obras de arte"],
                            ["codigo" => "180510", "name" => "Bibliotecas"],
                            ["codigo" => "180595", "name" => "Otros"],
                            ["codigo" => "180599", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1895",
                        "name" => "Diversos",
                        "children" => [
                            ["codigo" => "189505", "name" => "Máquinas porteadoras"],
                            ["codigo" => "189510", "name" => "Bienes entregados en comodato"],
                            ["codigo" => "189515", "name" => "Amortización acumulada de bienes entregados en comodato (CR)"],
                            ["codigo" => "189520", "name" => "Bienes recibidos en pago"],
                            ["codigo" => "189525", "name" => "Derechos sucesorales"],
                            ["codigo" => "189530", "name" => "Estampillas"],
                            ["codigo" => "189595", "name" => "Otros"],
                            ["codigo" => "189599", "name" => "Ajustes por inflación"],
                        ],
                    ],
                    [
                        "codigo" => "1899",
                        "name" => "Provisiones",
                        "children" => [
                            ["codigo" => "189905", "name" => "Bienes de arte y cultura"],
                            ["codigo" => "189995", "name" => "Diversos"],
                        ],
                    ],
                ],
              ],[
                "codigo" => "19",
                "name" => "Valorizaciones",
                "children" => [
                    [
                        "codigo" => "1905",
                        "name" => "De inversiones",
                        "children" => [
                            ["codigo" => "190505", "name" => "Acciones"],
                            ["codigo" => "190510", "name" => "Cuotas o partes de interés social"],
                            ["codigo" => "190515", "name" => "Derechos fiduciarios"],
                        ],
                    ],
                    [
                        "codigo" => "1910",
                        "name" => "De propiedades, planta y equipo",
                        "children" => [
                            ["codigo" => "191004", "name" => "Terrenos"],
                            ["codigo" => "191006", "name" => "Materiales proyectos petroleros"],
                            ["codigo" => "191008", "name" => "Construcciones y edificaciones"],
                            ["codigo" => "191012", "name" => "Maquinaria y equipo"],
                            ["codigo" => "191016", "name" => "Equipo de oficina"],
                            ["codigo" => "191020", "name" => "Equipo de computación y comunicación"],
                            ["codigo" => "191024", "name" => "Equipo médico-científico"],
                            ["codigo" => "191028", "name" => "Equipo de hoteles y restaurantes"],
                            ["codigo" => "191032", "name" => "Flota y equipo de transporte"],
                            ["codigo" => "191036", "name" => "Flota y equipo fluvial y/o marítimo"],
                            ["codigo" => "191040", "name" => "Flota y equipo aéreo"],
                            ["codigo" => "191044", "name" => "Flota y equipo férreo"],
                            ["codigo" => "191048", "name" => "Acueductos, plantas y redes"],
                            ["codigo" => "191052", "name" => "Armamento de vigilancia"],
                            ["codigo" => "191056", "name" => "Envases y empaques"],
                            ["codigo" => "191060", "name" => "Plantaciones agrícolas y forestales"],
                            ["codigo" => "191064", "name" => "Vías de comunicación"],
                            ["codigo" => "191068", "name" => "Minas y canteras"],
                            ["codigo" => "191072", "name" => "Pozos artesianos"],
                            ["codigo" => "191076", "name" => "Yacimientos"],
                            ["codigo" => "191080", "name" => "Semovientes"],
                        ],
                    ],
                    [
                        "codigo" => "1995",
                        "name" => "De otros activos",
                        "children" => [
                            ["codigo" => "199505", "name" => "Bienes de arte y cultura"],
                            ["codigo" => "199510", "name" => "Bienes entregados en comodato"],
                            ["codigo" => "199515", "name" => "Bienes recibidos en pago"],
                            ["codigo" => "199520", "name" => "Inventario de semovientes"],
                        ],
                    ],
                ],
              ]
            ]
          ],
          [
            "codigo" => "2",
            "name" => "Pasivo",
            "children" => [
              [
                "codigo" => "21",
                "name" => "Obligaciones financieras",
                "children" => [
                    [
                        "codigo" => "2105",
                        "name" => "Bancos nacionales",
                        "children" => [
                            ["codigo" => "210505", "name" => "Sobregiros", "children" => []],
                            ["codigo" => "210510", "name" => "Pagarés", "children" => []],
                            ["codigo" => "210515", "name" => "Cartas de crédito", "children" => []],
                            ["codigo" => "210520", "name" => "Aceptaciones bancarias", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2110",
                        "name" => "Bancos del exterior",
                        "children" => [
                            ["codigo" => "211005", "name" => "Sobregiros", "children" => []],
                            ["codigo" => "211010", "name" => "Pagarés", "children" => []],
                            ["codigo" => "211015", "name" => "Cartas de crédito", "children" => []],
                            ["codigo" => "211020", "name" => "Aceptaciones bancarias", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2115",
                        "name" => "Corporaciones financieras",
                        "children" => [
                            ["codigo" => "211505", "name" => "Pagarés", "children" => []],
                            ["codigo" => "211510", "name" => "Aceptaciones financieras", "children" => []],
                            ["codigo" => "211515", "name" => "Cartas de crédito", "children" => []],
                            ["codigo" => "211520", "name" => "Contratos de arrendamiento financiero (leasing)", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2120",
                        "name" => "Compañías de financiamiento comercial",
                        "children" => [
                            ["codigo" => "212005", "name" => "Pagarés", "children" => []],
                            ["codigo" => "212010", "name" => "Aceptaciones financieras", "children" => []],
                            ["codigo" => "212020", "name" => "Contratos de arrendamiento financiero (leasing)", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2125",
                        "name" => "Corporaciones de ahorro y vivienda",
                        "children" => [
                            ["codigo" => "212505", "name" => "Sobregiros", "children" => []],
                            ["codigo" => "212510", "name" => "Pagarés", "children" => []],
                            ["codigo" => "212515", "name" => "Hipotecarias", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2130",
                        "name" => "Entidades financieras del exterior",
                        "children" => [],
                    ],
                    [
                        "codigo" => "2135",
                        "name" => "Compromisos de recompra de inversiones negociadas",
                        "children" => [
                            ["codigo" => "213505", "name" => "Acciones", "children" => []],
                            ["codigo" => "213510", "name" => "Cuotas o partes de interés social", "children" => []],
                            ["codigo" => "213515", "name" => "Bonos", "children" => []],
                            ["codigo" => "213520", "name" => "Cédulas", "children" => []],
                            ["codigo" => "213525", "name" => "Certificados", "children" => []],
                            ["codigo" => "213530", "name" => "Papeles comerciales", "children" => []],
                            ["codigo" => "213535", "name" => "Títulos", "children" => []],
                            ["codigo" => "213540", "name" => "Aceptaciones bancarias o financieras", "children" => []],
                            ["codigo" => "213595", "name" => "Otros", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2140",
                        "name" => "Compromisos de recompra de cartera negociada",
                        "children" => [],
                    ],
                    [
                        "codigo" => "2145",
                        "name" => "Obligaciones gubernamentales",
                        "children" => [
                            ["codigo" => "214505", "name" => "Gobierno Nacional", "children" => []],
                            ["codigo" => "214510", "name" => "Entidades oficiales", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2195",
                        "name" => "Otras obligaciones",
                        "children" => [
                            ["codigo" => "219505", "name" => "Particulares", "children" => []],
                            ["codigo" => "219510", "name" => "Compañías vinculadas", "children" => []],
                            ["codigo" => "219515", "name" => "Casa matriz", "children" => []],
                            ["codigo" => "219520", "name" => "Socios o accionistas", "children" => []],
                            ["codigo" => "219525", "name" => "Fondos y cooperativas", "children" => []],
                            ["codigo" => "219530", "name" => "Directores", "children" => []],
                            ["codigo" => "219595", "name" => "Otras", "children" => []],
                        ],
                    ],
                ],
              ],

              [
                  "codigo" => "22",
                  "name" => "Proveedores",
                  "children" => [
                      ["codigo" => "2205", "name" => "Nacionales", "children" => []],
                      ["codigo" => "2210", "name" => "Del exterior", "children" => []],
                      ["codigo" => "2215", "name" => "Cuentas corrientes comerciales", "children" => []],
                      ["codigo" => "2220", "name" => "Casa matriz", "children" => []],
                      ["codigo" => "2225", "name" => "Compañías vinculadas", "children" => []],
                  ],
              ],

              [
                  "codigo" => "23",
                  "name" => "Cuentas por pagar",
                  "children" => [
                      ["codigo" => "2305", "name" => "Cuentas corrientes comerciales", "children" => []],
                      ["codigo" => "2310", "name" => "A casa matriz", "children" => []],
                      ["codigo" => "2315", "name" => "A compañías vinculadas", "children" => []],
                      ["codigo" => "2320", "name" => "A contratistas", "children" => []],
                      ["codigo" => "2330", "name" => "Órdenes de compra por utilizar", "children" => []],
                      [
                          "codigo" => "2335",
                          "name" => "Costos y gastos por pagar",
                          "children" => [
                              ["codigo" => "233505", "name" => "Gastos financieros", "children" => []],
                              ["codigo" => "233510", "name" => "Gastos legales", "children" => []],
                              ["codigo" => "233515", "name" => "Libros, suscripciones, periódicos y revistas", "children" => []],
                              ["codigo" => "233520", "name" => "Comisiones", "children" => []],
                              ["codigo" => "233525", "name" => "Honorarios", "children" => []],
                              ["codigo" => "233530", "name" => "Servicios técnicos", "children" => []],
                              ["codigo" => "233535", "name" => "Servicios de mantenimiento", "children" => []],
                              ["codigo" => "233540", "name" => "Arrendamientos", "children" => []],
                              ["codigo" => "233545", "name" => "Transportes, fletes y acarreos", "children" => []],
                              ["codigo" => "233550", "name" => "Servicios públicos", "children" => []],
                              ["codigo" => "233555", "name" => "Seguros", "children" => []],
                              ["codigo" => "233560", "name" => "Gastos de viaje", "children" => []],
                              ["codigo" => "233565", "name" => "Gastos de representación y relaciones públicas", "children" => []],
                              ["codigo" => "233570", "name" => "Servicios aduaneros", "children" => []],
                              ["codigo" => "233595", "name" => "Otros", "children" => []],
                          ],
                      ],
                      ["codigo" => "2340", "name" => "Instalamentos por pagar", "children" => []],
                      ["codigo" => "2345", "name" => "Acreedores oficiales", "children" => []],
                      ["codigo" => "2350", "name" => "Regalías por pagar", "children" => []],
                      [
                          "codigo" => "2355",
                          "name" => "Deudas con accionistas o socios",
                          "children" => [
                              ["codigo" => "235505", "name" => "Accionistas", "children" => []],
                              ["codigo" => "235510", "name" => "Socios", "children" => []],
                          ],
                      ],
                      ["codigo" => "2357", "name" => "Deudas con directores", "children" => []],
                      [
                          "codigo" => "2360",
                          "name" => "Dividendos o participaciones por pagar",
                          "children" => [
                              ["codigo" => "236005", "name" => "Dividendos", "children" => []],
                              ["codigo" => "236010", "name" => "Participaciones", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "2365",
                          "name" => "Retención en la fuente",
                          "children" => [
                              ["codigo" => "236505", "name" => "Salarios y pagos laborales", "children" => []],
                              ["codigo" => "236510", "name" => "Dividendos y/o participaciones", "children" => []],
                              ["codigo" => "236515", "name" => "Honorarios", "children" => []],
                              ["codigo" => "236520", "name" => "Comisiones", "children" => []],
                              ["codigo" => "236525", "name" => "Servicios", "children" => []],
                              ["codigo" => "236530", "name" => "Arrendamientos", "children" => []],
                              ["codigo" => "236535", "name" => "Rendimientos financieros", "children" => []],
                              ["codigo" => "236540", "name" => "Compras", "children" => []],
                              ["codigo" => "236545", "name" => "Loterías, rifas, apuestas y similares", "children" => []],
                              ["codigo" => "236550", "name" => "Por pagos al exterior", "children" => []],
                              ["codigo" => "236555", "name" => "Por ingresos obtenidos en el exterior", "children" => []],
                              ["codigo" => "236560", "name" => "Enajenación propiedades planta y equipo, personas naturales", "children" => []],
                              ["codigo" => "236565", "name" => "Por impuesto de timbre", "children" => []],
                              ["codigo" => "236570", "name" => "Otras retenciones y patrimonio", "children" => []],
                              ["codigo" => "236575", "name" => "Autorretenciones", "children" => []],
                          ],
                      ],
                      ["codigo" => "2367", "name" => "Impuesto a las ventas retenido", "children" => []],
                      ["codigo" => "2368", "name" => "Impuesto de industria y comercio retenido", "children" => []],
                      [
                          "codigo" => "2370",
                          "name" => "Retenciones y aportes de nómina",
                          "children" => [
                              ["codigo" => "237005", "name" => "Aportes a entidades promotoras de salud, EPS", "children" => []],
                              ["codigo" => "237006", "name" => "Aportes a administradoras de riesgos profesionales, ARP", "children" => []],
                              ["codigo" => "237010", "name" => "Aportes al ICBF, SENA y cajas de compensación", "children" => []],
                              ["codigo" => "237015", "name" => "Aportes al FIC", "children" => []],
                              ["codigo" => "237025", "name" => "Embargos judiciales", "children" => []],
                              ["codigo" => "237030", "name" => "Libranzas", "children" => []],
                              ["codigo" => "237035", "name" => "Sindicatos", "children" => []],
                              ["codigo" => "237040", "name" => "Cooperativas", "children" => []],
                              ["codigo" => "237045", "name" => "Fondos", "children" => []],
                              ["codigo" => "237095", "name" => "Otros", "children" => []],
                          ],
                      ],
                      ["codigo" => "2375", "name" => "Cuotas por devolver", "children" => []],
                      [
                          "codigo" => "2380",
                          "name" => "Acreedores varios",
                          "children" => [
                              ["codigo" => "238005", "name" => "Depositarios", "children" => []],
                              ["codigo" => "238010", "name" => "Comisionistas de bolsas", "children" => []],
                              ["codigo" => "238015", "name" => "Sociedad administradora-Fondos de inversión", "children" => []],
                              ["codigo" => "238020", "name" => "Reintegros por pagar", "children" => []],
                              ["codigo" => "238025", "name" => "Fondo de perseverancia", "children" => []],
                              ["codigo" => "238030", "name" => "Fondos de cesantías y/o pensiones", "children" => []],
                              ["codigo" => "238035", "name" => "Donaciones asignadas por pagar", "children" => []],
                              ["codigo" => "238095", "name" => "Otros", "children" => []],
                          ],
                      ],
                  ],
              ],
              [
                  "codigo" => "24",
                  "name" => "Impuestos, gravámenes y tasas",
                  "children" => [
                      [
                          "codigo" => "2404",
                          "name" => "De renta y complementarios",
                          "children" => [
                              ["codigo" => "240405", "name" => "Vigencia fiscal corriente", "children" => []],
                              ["codigo" => "240410", "name" => "Vigencias fiscales anteriores", "children" => []],
                          ],
                      ],
                      ["codigo" => "2408", "name" => "Impuesto sobre las ventas por pagar", "children" => []],
                      [
                          "codigo" => "2412",
                          "name" => "De industria y comercio",
                          "children" => [
                              ["codigo" => "241205", "name" => "Vigencia fiscal corriente", "children" => []],
                              ["codigo" => "241210", "name" => "Vigencias fiscales anteriores", "children" => []],
                          ],
                      ],
                      ["codigo" => "2416", "name" => "A la propiedad raíz", "children" => []],
                      ["codigo" => "2420", "name" => "Derechos sobre instrumentos públicos", "children" => []],
                      [
                          "codigo" => "2424",
                          "name" => "De valorización",
                          "children" => [
                              ["codigo" => "242405", "name" => "Vigencia fiscal corriente", "children" => []],
                              ["codigo" => "242410", "name" => "Vigencias fiscales anteriores", "children" => []],
                          ],
                      ],
                      ["codigo" => "2428", "name" => "De turismo", "children" => []],
                      ["codigo" => "2432", "name" => "Tasa por utilización de puertos", "children" => []],
                      ["codigo" => "2436", "name" => "De vehículos", "children" => [
                          ["codigo" => "243605", "name" => "Vigencia fiscal corriente", "children" => []],
                          ["codigo" => "243610", "name" => "Vigencias fiscales anteriores", "children" => []],
                      ]],
                      ["codigo" => "2440", "name" => "De espectáculos públicos", "children" => []],
                      [
                          "codigo" => "2444",
                          "name" => "De hidrocarburos y minas",
                          "children" => [
                              ["codigo" => "244405", "name" => "De hidrocarburos", "children" => []],
                              ["codigo" => "244410", "name" => "De minas", "children" => []],
                          ],
                      ],
                      ["codigo" => "2448", "name" => "Regalías e impuestos a la pequeña y mediana minería", "children" => []],
                      ["codigo" => "2452", "name" => "A las exportaciones cafeteras", "children" => []],
                      ["codigo" => "2456", "name" => "A las importaciones", "children" => []],
                      ["codigo" => "2460", "name" => "Cuotas de fomento", "children" => []],
                      [
                          "codigo" => "2464",
                          "name" => "De licores, cervezas y cigarrillos",
                          "children" => [
                              ["codigo" => "246405", "name" => "De licores", "children" => []],
                              ["codigo" => "246410", "name" => "De cervezas", "children" => []],
                              ["codigo" => "246415", "name" => "De cigarrillos", "children" => []],
                          ],
                      ],
                      ["codigo" => "2468", "name" => "Al sacrificio de ganado", "children" => []],
                      ["codigo" => "2472", "name" => "Al azar y juegos", "children" => []],
                      ["codigo" => "2476", "name" => "Gravámenes y regalías por utilización del suelo", "children" => []],
                      ["codigo" => "2495", "name" => "Otros", "children" => []],
                  ],
              ],
              [
                "codigo" => "25",
                "name" => "Obligaciones laborales",
                "children" => [
                    ["codigo" => "2505", "name" => "Salarios por pagar", "children" => []],
                    [
                        "codigo" => "2510",
                        "name" => "Cesantías consolidadas",
                        "children" => [
                            ["codigo" => "251005", "name" => "Ley laboral anterior", "children" => []],
                            ["codigo" => "251010", "name" => "Ley 50 de 1990 y normas posteriores", "children" => []],
                        ],
                    ],
                    ["codigo" => "2515", "name" => "Intereses sobre cesantías", "children" => []],
                    ["codigo" => "2520", "name" => "Prima de servicios", "children" => []],
                    ["codigo" => "2525", "name" => "Vacaciones consolidadas", "children" => []],
                    [
                        "codigo" => "2530",
                        "name" => "Prestaciones extralegales",
                        "children" => [
                            ["codigo" => "253005", "name" => "Primas", "children" => []],
                            ["codigo" => "253010", "name" => "Auxilios", "children" => []],
                            ["codigo" => "253015", "name" => "Dotación y suministro a trabajadores", "children" => []],
                            ["codigo" => "253020", "name" => "Bonificaciones", "children" => []],
                            ["codigo" => "253025", "name" => "Seguros", "children" => []],
                            ["codigo" => "253095", "name" => "Otras", "children" => []],
                        ],
                    ],
                    ["codigo" => "2532", "name" => "Pensiones por pagar", "children" => []],
                    ["codigo" => "2535", "name" => "Cuotas partes pensiones de jubilación", "children" => []],
                    ["codigo" => "2540", "name" => "Indemnizaciones laborales", "children" => []],
                ],
              ],
              [
                "codigo" => "26",
                "name" => "Pasivos estimados y provisiones",
                "children" => [
                    [
                        "codigo" => "2605",
                        "name" => "Para costos y gastos",
                        "children" => [
                            ["codigo" => "260505", "name" => "Intereses", "children" => []],
                            ["codigo" => "260510", "name" => "Comisiones", "children" => []],
                            ["codigo" => "260515", "name" => "Honorarios", "children" => []],
                            ["codigo" => "260520", "name" => "Servicios técnicos", "children" => []],
                            ["codigo" => "260525", "name" => "Transportes, fletes y acarreos", "children" => []],
                            ["codigo" => "260530", "name" => "Gastos de viaje", "children" => []],
                            ["codigo" => "260535", "name" => "Servicios públicos", "children" => []],
                            ["codigo" => "260540", "name" => "Regalías", "children" => []],
                            ["codigo" => "260545", "name" => "Garantías", "children" => []],
                            ["codigo" => "260550", "name" => "Materiales y repuestos", "children" => []],
                            ["codigo" => "260595", "name" => "Otros", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2610",
                        "name" => "Para obligaciones laborales",
                        "children" => [
                            ["codigo" => "261005", "name" => "Cesantías", "children" => []],
                            ["codigo" => "261010", "name" => "Intereses sobre cesantías", "children" => []],
                            ["codigo" => "261015", "name" => "Vacaciones", "children" => []],
                            ["codigo" => "261020", "name" => "Prima de servicios", "children" => []],
                            ["codigo" => "261025", "name" => "Prestaciones extralegales", "children" => []],
                            ["codigo" => "261030", "name" => "Viáticos", "children" => []],
                            ["codigo" => "261095", "name" => "Otras", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2615",
                        "name" => "Para obligaciones fiscales",
                        "children" => [
                            ["codigo" => "261505", "name" => "De renta y complementarios", "children" => []],
                            ["codigo" => "261510", "name" => "De industria y comercio", "children" => []],
                            ["codigo" => "261515", "name" => "Tasa por utilización de puertos", "children" => []],
                            ["codigo" => "261520", "name" => "De vehículos", "children" => []],
                            ["codigo" => "261525", "name" => "De hidrocarburos y minas", "children" => []],
                            ["codigo" => "261595", "name" => "Otros", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2620",
                        "name" => "Pensiones de jubilación",
                        "children" => [
                            ["codigo" => "262005", "name" => "Cálculo actuarial pensiones de jubilación", "children" => []],
                            ["codigo" => "262010", "name" => "Pensiones de jubilación por amortizar (DB)", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2625",
                        "name" => "Para obras de urbanismo",
                        "children" => [
                            ["codigo" => "262505", "name" => "Acueducto y alcantarillado", "children" => []],
                            ["codigo" => "262510", "name" => "Energía eléctrica", "children" => []],
                            ["codigo" => "262515", "name" => "Teléfonos", "children" => []],
                            ["codigo" => "262595", "name" => "Otros", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2630",
                        "name" => "Para mantenimiento y reparaciones",
                        "children" => [
                            ["codigo" => "263005", "name" => "Terrenos", "children" => []],
                            ["codigo" => "263010", "name" => "Construcciones y edificaciones", "children" => []],
                            ["codigo" => "263015", "name" => "Maquinaria y equipo", "children" => []],
                            ["codigo" => "263020", "name" => "Equipo de oficina", "children" => []],
                            ["codigo" => "263025", "name" => "Equipo de computación y comunicación", "children" => []],
                            ["codigo" => "263030", "name" => "Equipo médico-científico", "children" => []],
                            ["codigo" => "263035", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                            ["codigo" => "263040", "name" => "Flota y equipo de transporte", "children" => []],
                            ["codigo" => "263045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                            ["codigo" => "263050", "name" => "Flota y equipo aéreo", "children" => []],
                            ["codigo" => "263055", "name" => "Flota y equipo férreo", "children" => []],
                            ["codigo" => "263060", "name" => "Acueductos, plantas y redes", "children" => []],
                            ["codigo" => "263065", "name" => "Armamento de vigilancia", "children" => []],
                            ["codigo" => "263070", "name" => "Envases y empaques", "children" => []],
                            ["codigo" => "263075", "name" => "Plantaciones agrícolas y forestales", "children" => []],
                            ["codigo" => "263080", "name" => "Vías de comunicación", "children" => []],
                            ["codigo" => "263085", "name" => "Pozos artesianos", "children" => []],
                            ["codigo" => "263095", "name" => "Otros", "children" => []],
                        ],
                    ],
                    [
                        "codigo" => "2635",
                        "name" => "Para contingencias",
                        "children" => [
                            ["codigo" => "263505", "name" => "Multas y sanciones autoridades administrativas", "children" => []],
                            ["codigo" => "263510", "name" => "Intereses por multas y sanciones", "children" => []],
                            ["codigo" => "263515", "name" => "Reclamos", "children" => []],
                            ["codigo" => "263520", "name" => "Laborales", "children" => []],
                            ["codigo" => "263525", "name" => "Civiles", "children" => []],
                            ["codigo" => "263530", "name" => "Penales", "children" => []],
                            ["codigo" => "263535", "name" => "Administrativos", "children" => []],
                            ["codigo" => "263540", "name" => "Comerciales", "children" => []],
                            ["codigo" => "263595", "name" => "Otras", "children" => []],
                        ],
                    ],
                    ["codigo" => "2640", "name" => "Para obligaciones de garantías", "children" => []],
                    [
                        "codigo" => "2695",
                        "name" => "Provisiones diversas",
                        "children" => [
                            ["codigo" => "269505", "name" => "Para beneficencia", "children" => []],
                            ["codigo" => "269510", "name" => "Para comunicaciones", "children" => []],
                            ["codigo" => "269515", "name" => "Para pérdida en transporte", "children" => []],
                            ["codigo" => "269520", "name" => "Para operación", "children" => []],
                            ["codigo" => "269525", "name" => "Para protección de bienes agotables", "children" => []],
                            ["codigo" => "269530", "name" => "Para ajustes en redención de unidades", "children" => []],
                            ["codigo" => "269535", "name" => "Autoseguro", "children" => []],
                            ["codigo" => "269540", "name" => "Planes y programas de reforestación y electrificación", "children" => []],
                            ["codigo" => "269595", "name" => "Otras", "children" => []],
                        ],
                    ],
                ],
              ],
              [
                  "codigo" => "27",
                  "name" => "Diferidos",
                  "children" => [
                      [
                          "codigo" => "2705",
                          "name" => "Ingresos recibidos por anticipado",
                          "children" => [
                              ["codigo" => "270505", "name" => "Intereses", "children" => []],
                              ["codigo" => "270510", "name" => "Comisiones", "children" => []],
                              ["codigo" => "270515", "name" => "Arrendamientos", "children" => []],
                              ["codigo" => "270520", "name" => "Honorarios", "children" => []],
                              ["codigo" => "270525", "name" => "Servicios técnicos", "children" => []],
                              ["codigo" => "270530", "name" => "De suscriptores", "children" => []],
                              ["codigo" => "270535", "name" => "Transportes, fletes y acarreos", "children" => []],
                              ["codigo" => "270540", "name" => "Mercancía en tránsito ya vendida", "children" => []],
                              ["codigo" => "270545", "name" => "Matrículas y pensiones", "children" => []],
                              ["codigo" => "270550", "name" => "Cuotas de administración", "children" => []],
                              ["codigo" => "270595", "name" => "Otros", "children" => []],
                          ],
                      ],
                      ["codigo" => "2710", "name" => "Abonos diferidos", "children" => [
                          ["codigo" => "271005", "name" => "Reajuste del sistema", "children" => []],
                      ]],
                      ["codigo" => "2715", "name" => "Utilidad diferida en ventas a plazos", "children" => []],
                      ["codigo" => "2720", "name" => "Crédito por corrección monetaria diferida", "children" => []],
                      [
                          "codigo" => "2725",
                          "name" => "Impuestos diferidos",
                          "children" => [
                              ["codigo" => "272505", "name" => "Por depreciación flexible", "children" => []],
                              ["codigo" => "272595", "name" => "Diversos", "children" => []],
                              ["codigo" => "272599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
              ],
              [
                  "codigo" => "28",
                  "name" => "Otros pasivos",
                  "children" => [
                      [
                          "codigo" => "2805",
                          "name" => "Anticipos y avances recibidos",
                          "children" => [
                              ["codigo" => "280505", "name" => "De clientes", "children" => []],
                              ["codigo" => "280510", "name" => "Sobre contratos", "children" => []],
                              ["codigo" => "280515", "name" => "Para obras en proceso", "children" => []],
                              ["codigo" => "280595", "name" => "Otros", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "2810",
                          "name" => "Depósitos recibidos",
                          "children" => [
                              ["codigo" => "281005", "name" => "Para futura suscripción de acciones", "children" => []],
                              ["codigo" => "281010", "name" => "Para futuro pago de cuotas o derechos sociales", "children" => []],
                              ["codigo" => "281015", "name" => "Para garantía en la prestación de servicios", "children" => []],
                              ["codigo" => "281020", "name" => "Para garantía de contratos", "children" => []],
                              ["codigo" => "281025", "name" => "De licitaciones", "children" => []],
                              ["codigo" => "281030", "name" => "De manejo de bienes", "children" => []],
                              ["codigo" => "281035", "name" => "Fondo de reserva", "children" => []],
                              ["codigo" => "281095", "name" => "Otros", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "2815",
                          "name" => "Ingresos recibidos para terceros",
                          "children" => [
                              ["codigo" => "281505", "name" => "Valores recibidos para terceros", "children" => []],
                              ["codigo" => "281510", "name" => "Venta por cuenta de terceros", "children" => []],
                          ],
                      ],
                      ["codigo" => "2820", "name" => "Cuentas de operación conjunta", "children" => []],
                      ["codigo" => "2825", "name" => "Retenciones a terceros sobre contratos", "children" => [
                          ["codigo" => "282505", "name" => "Cumplimiento obligaciones laborales", "children" => []],
                          ["codigo" => "282510", "name" => "Para estabilidad de obra", "children" => []],
                          ["codigo" => "282515", "name" => "Garantía cumplimiento de contratos", "children" => []],
                      ]],
                      [
                          "codigo" => "2830",
                          "name" => "Embargos judiciales",
                          "children" => [
                              ["codigo" => "283005", "name" => "Indemnizaciones", "children" => []],
                              ["codigo" => "283010", "name" => "Depósitos judiciales", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "2835",
                          "name" => "Acreedores del sistema",
                          "children" => [
                              ["codigo" => "283505", "name" => "Cuotas netas", "children" => []],
                              ["codigo" => "283510", "name" => "Grupos en formación", "children" => []],
                          ],
                      ],
                      ["codigo" => "2840", "name" => "Cuentas en participación", "children" => []],
                      [
                          "codigo" => "2895",
                          "name" => "Diversos",
                          "children" => [
                              ["codigo" => "289505", "name" => "Préstamos de productos", "children" => []],
                              ["codigo" => "289510", "name" => "Reembolso de costos exploratorios", "children" => []],
                              ["codigo" => "289515", "name" => "Programa de extensión agropecuaria", "children" => []],
                          ],
                      ],
                  ],
              ],
              [
                  "codigo" => "29",
                  "name" => "Bonos y papeles comerciales",
                  "children" => [
                      ["codigo" => "2905", "name" => "Bonos en circulación", "children" => []],
                      ["codigo" => "2910", "name" => "Bonos obligatoriamente convertibles en acciones", "children" => []],
                      ["codigo" => "2915", "name" => "Papeles comerciales", "children" => []],
                      ["codigo" => "2920", "name" => "Bonos pensionales", "children" => [
                          ["codigo" => "292005", "name" => "Valor bonos pensionales", "children" => []],
                          ["codigo" => "292010", "name" => "Bonos pensionales por amortizar (DB)", "children" => []],
                          ["codigo" => "292015", "name" => "Intereses causados sobre bonos pensionales", "children" => []],
                      ]],
                      ["codigo" => "2925", "name" => "Títulos pensionales", "children" => [
                          ["codigo" => "292505", "name" => "Valor títulos pensionales", "children" => []],
                          ["codigo" => "292510", "name" => "Títulos pensionales por amortizar (DB)", "children" => []],
                          ["codigo" => "292515", "name" => "Intereses causados sobre títulos pensionales", "children" => []],
                      ]],
                  ],
              ]
            ]
          ],
          [
              "codigo" => "3",
              "name" => "Patrimonio",
              "children" => [
                [
                  "codigo" => "31",
                  "name" => "Capital social",
                  "children" => [
                      [
                          "codigo" => "3105",
                          "name" => "Capital suscrito y pagado",
                          "children" => [
                              ["codigo" => "310505", "name" => "Capital autorizado", "children" => []],
                              ["codigo" => "310510", "name" => "Capital por suscribir (DB)", "children" => []],
                              ["codigo" => "310515", "name" => "Capital suscrito por cobrar (DB)", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "3115",
                          "name" => "Aportes sociales",
                          "children" => [
                              ["codigo" => "311505", "name" => "Cuotas o partes de interés social", "children" => []],
                              ["codigo" => "311510", "name" => "Aportes de socios-fondo mutuo de inversión", "children" => []],
                              ["codigo" => "311515", "name" => "Contribución de la empresa-fondo mutuo de inversión", "children" => []],
                              ["codigo" => "311520", "name" => "Suscripciones del público", "children" => []],
                          ],
                      ],
                      ["codigo" => "3120", "name" => "Capital asignado", "children" => []],
                      ["codigo" => "3125", "name" => "Inversión suplementaria al capital asignado", "children" => []],
                      ["codigo" => "3130", "name" => "Capital de personas naturales", "children" => []],
                      ["codigo" => "3135", "name" => "Aportes del Estado", "children" => []],
                      ["codigo" => "3140", "name" => "Fondo social", "children" => []],
                  ],
                ],
                [
                    "codigo" => "32",
                    "name" => "Superávit de capital",
                    "children" => [
                        [
                            "codigo" => "3205",
                            "name" => "Prima en colocación de acciones, cuotas o partes de interés social",
                            "children" => [
                                ["codigo" => "320505", "name" => "Prima en colocación de acciones", "children" => []],
                                ["codigo" => "320510", "name" => "Prima en colocación de acciones por cobrar (DB)", "children" => []],
                                ["codigo" => "320515", "name" => "Prima en colocación de cuotas o partes de interés social", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "3210",
                            "name" => "Donaciones",
                            "children" => [
                                ["codigo" => "321005", "name" => "En dinero", "children" => []],
                                ["codigo" => "321010", "name" => "En valores mobiliarios", "children" => []],
                                ["codigo" => "321015", "name" => "En bienes muebles", "children" => []],
                                ["codigo" => "321020", "name" => "En bienes inmuebles", "children" => []],
                                ["codigo" => "321025", "name" => "En intangibles", "children" => []],
                            ],
                        ],
                        ["codigo" => "3215", "name" => "Crédito mercantil", "children" => []],
                        ["codigo" => "3220", "name" => "Know how", "children" => []],
                        [
                            "codigo" => "3225",
                            "name" => "Superávit método de participación",
                            "children" => [
                                ["codigo" => "322505", "name" => "De acciones", "children" => []],
                                ["codigo" => "322510", "name" => "De cuotas o partes de interés social", "children" => []],
                            ],
                        ],
                    ],
                ],
                [
                    "codigo" => "33",
                    "name" => "Reservas",
                    "children" => [
                        [
                            "codigo" => "3305",
                            "name" => "Reservas obligatorias",
                            "children" => [
                                ["codigo" => "330505", "name" => "Reserva legal", "children" => []],
                                ["codigo" => "330510", "name" => "Reservas por disposiciones fiscales", "children" => []],
                                ["codigo" => "330515", "name" => "Reserva para readquisición de acciones", "children" => []],
                                ["codigo" => "330516", "name" => "Acciones propias readquiridas (DB)", "children" => []],
                                ["codigo" => "330517", "name" => "Reserva para readquisición de cuotas o partes de interés social", "children" => []],
                                ["codigo" => "330518", "name" => "Cuotas o partes de interés social propias readquiridas (DB)", "children" => []],
                                ["codigo" => "330520", "name" => "Reserva para extensión agropecuaria", "children" => []],
                                ["codigo" => "330525", "name" => "Reserva Ley 7ª de 1990", "children" => []],
                                ["codigo" => "330530", "name" => "Reserva para reposición de semovientes", "children" => []],
                                ["codigo" => "330535", "name" => "Reserva Ley 4ª de 1980", "children" => []],
                                ["codigo" => "330595", "name" => "Otras", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "3310",
                            "name" => "Reservas estatutarias",
                            "children" => [
                                ["codigo" => "331005", "name" => "Para futuras capitalizaciones", "children" => []],
                                ["codigo" => "331010", "name" => "Para reposición de activos", "children" => []],
                                ["codigo" => "331015", "name" => "Para futuros ensanches", "children" => []],
                                ["codigo" => "331095", "name" => "Otras", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "3315",
                            "name" => "Reservas ocasionales",
                            "children" => [
                                ["codigo" => "331505", "name" => "Para beneficencia y civismo", "children" => []],
                                ["codigo" => "331510", "name" => "Para futuras capitalizaciones", "children" => []],
                                ["codigo" => "331515", "name" => "Para futuros ensanches", "children" => []],
                                ["codigo" => "331520", "name" => "Para adquisición o reposición de propiedades, planta y equipo", "children" => []],
                                ["codigo" => "331525", "name" => "Para investigaciones y desarrollo", "children" => []],
                                ["codigo" => "331530", "name" => "Para fomento económico", "children" => []],
                                ["codigo" => "331535", "name" => "Para capital de trabajo", "children" => []],
                                ["codigo" => "331540", "name" => "Para estabilización de rendimientos", "children" => []],
                                ["codigo" => "331545", "name" => "A disposición del máximo órgano social", "children" => []],
                                ["codigo" => "331595", "name" => "Otras", "children" => []],
                            ],
                        ],
                    ],
                ],
                [
                    "codigo" => "34",
                    "name" => "Revalorización del patrimonio",
                    "children" => [
                        [
                            "codigo" => "3405",
                            "name" => "Ajustes por inflación",
                            "children" => [
                                ["codigo" => "340505", "name" => "De capital social", "children" => []],
                                ["codigo" => "340510", "name" => "De superávit de capital", "children" => []],
                                ["codigo" => "340515", "name" => "De reservas", "children" => []],
                                ["codigo" => "340520", "name" => "De resultados de ejercicios anteriores", "children" => []],
                                ["codigo" => "340525", "name" => "De activos en período improductivo", "children" => []],
                                ["codigo" => "340530", "name" => "De saneamiento fiscal", "children" => []],
                                ["codigo" => "340535", "name" => "De ajustes Decreto 3019 de 1989", "children" => []],
                                ["codigo" => "340540", "name" => "De dividendos y participaciones decretadas en acciones, cuotas o partes de interés social", "children" => []],
                                ["codigo" => "340545", "name" => "Superávit método de participación", "children" => []],
                            ],
                        ],
                        ["codigo" => "3410", "name" => "Saneamiento fiscal", "children" => []],
                        ["codigo" => "3415", "name" => "Ajustes por inflación Decreto 3019 de 1989", "children" => []],
                    ],
                ],
                [
                    "codigo" => "35",
                    "name" => "Dividendos o participaciones decretados en acciones, cuotas o partes de interés social",
                    "children" => [
                        ["codigo" => "3505", "name" => "Dividendos decretados en acciones", "children" => []],
                        ["codigo" => "3510", "name" => "Participaciones decretadas en cuotas o partes de interés social", "children" => []],
                    ],
                ],
                [
                    "codigo" => "36",
                    "name" => "Resultados del ejercicio",
                    "children" => [
                        ["codigo" => "3605", "name" => "Utilidad del ejercicio", "children" => []],
                        ["codigo" => "3610", "name" => "Pérdida del ejercicio", "children" => []],
                    ],
                ],
                [
                    "codigo" => "37",
                    "name" => "Resultados de ejercicios anteriores",
                    "children" => [
                        ["codigo" => "3705", "name" => "Utilidades acumuladas", "children" => []],
                        ["codigo" => "3710", "name" => "Pérdidas acumuladas", "children" => []],
                    ],
                ],
                [
                    "codigo" => "38",
                    "name" => "Superávit por valorizaciones",
                    "children" => [
                        [
                            "codigo" => "3805",
                            "name" => "De inversiones",
                            "children" => [
                                ["codigo" => "380505", "name" => "Acciones", "children" => []],
                                ["codigo" => "380510", "name" => "Cuotas o partes de interés social", "children" => []],
                                ["codigo" => "380515", "name" => "Derechos fiduciarios", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "3810",
                            "name" => "De propiedades, planta y equipo",
                            "children" => [
                                ["codigo" => "381004", "name" => "Terrenos", "children" => []],
                                ["codigo" => "381006", "name" => "Materiales proyectos petroleros", "children" => []],
                                ["codigo" => "381008", "name" => "Construcciones y edificaciones", "children" => []],
                                ["codigo" => "381012", "name" => "Maquinaria y equipo", "children" => []],
                                ["codigo" => "381016", "name" => "Equipo de oficina", "children" => []],
                                ["codigo" => "381020", "name" => "Equipo de computación y comunicación", "children" => []],
                                ["codigo" => "381024", "name" => "Equipo médico-científico", "children" => []],
                                ["codigo" => "381028", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                                ["codigo" => "381032", "name" => "Flota y equipo de transporte", "children" => []],
                                ["codigo" => "381036", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                                ["codigo" => "381040", "name" => "Flota y equipo aéreo", "children" => []],
                                ["codigo" => "381044", "name" => "Flota y equipo férreo", "children" => []],
                                ["codigo" => "381048", "name" => "Acueductos, plantas y redes", "children" => []],
                                ["codigo" => "381052", "name" => "Armamento de vigilancia", "children" => []],
                                ["codigo" => "381056", "name" => "Envases y empaques", "children" => []],
                                ["codigo" => "381060", "name" => "Plantaciones agrícolas y forestales", "children" => []],
                                ["codigo" => "381064", "name" => "Vías de comunicación", "children" => []],
                                ["codigo" => "381068", "name" => "Minas y canteras", "children" => []],
                                ["codigo" => "381072", "name" => "Pozos artesianos", "children" => []],
                                ["codigo" => "381076", "name" => "Yacimientos", "children" => []],
                                ["codigo" => "381080", "name" => "Semovientes", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "3895",
                            "name" => "De otros activos",
                            "children" => [
                                ["codigo" => "389505", "name" => "Bienes de arte y cultura", "children" => []],
                                ["codigo" => "389510", "name" => "Bienes entregados en comodato", "children" => []],
                                ["codigo" => "389515", "name" => "Bienes recibidos en pago", "children" => []],
                                ["codigo" => "389520", "name" => "Inventario de semovientes", "children" => []],
                            ],
                        ],
                    ],
                ]
              ]
          ],
          [
              "codigo" => "4",
              "name" => "Ingresos",
              "children" => [
                [
                  "codigo" => "41",
                  "name" => "Operacionales",
                  "children" => [
                      [
                          "codigo" => "4105",
                          "name" => "Agricultura, ganadería, caza y silvicultura",
                          "children" => [
                              ["codigo" => "410505", "name" => "Cultivo de cereales", "children" => []],
                              ["codigo" => "410510", "name" => "Cultivos de hortalizas, legumbres y plantas ornamentales", "children" => []],
                              ["codigo" => "410515", "name" => "Cultivos de frutas, nueces y plantas aromáticas", "children" => []],
                              ["codigo" => "410520", "name" => "Cultivo de café", "children" => []],
                              ["codigo" => "410525", "name" => "Cultivo de flores", "children" => []],
                              ["codigo" => "410530", "name" => "Cultivo de caña de azúcar", "children" => []],
                              ["codigo" => "410535", "name" => "Cultivo de algodón y plantas para material textil", "children" => []],
                              ["codigo" => "410540", "name" => "Cultivo de banano", "children" => []],
                              ["codigo" => "410545", "name" => "Otros cultivos agrícolas", "children" => []],
                              ["codigo" => "410550", "name" => "Cría de ovejas, cabras, asnos, mulas y burdéganos", "children" => []],
                              ["codigo" => "410555", "name" => "Cría de ganado caballar y vacuno", "children" => []],
                              ["codigo" => "410560", "name" => "Producción avícola", "children" => []],
                              ["codigo" => "410565", "name" => "Cría de otros animales", "children" => []],
                              ["codigo" => "410570", "name" => "Servicios agrícolas y ganaderos", "children" => []],
                              ["codigo" => "410575", "name" => "Actividad de caza", "children" => []],
                              ["codigo" => "410580", "name" => "Actividad de silvicultura", "children" => []],
                              ["codigo" => "410595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "410599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4110",
                          "name" => "Pesca",
                          "children" => [
                              ["codigo" => "411005", "name" => "Actividad de pesca", "children" => []],
                              ["codigo" => "411010", "name" => "Explotación de criaderos de peces", "children" => []],
                              ["codigo" => "411095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "411099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4115",
                          "name" => "Explotación de minas y canteras",
                          "children" => [
                              ["codigo" => "411505", "name" => "Carbón", "children" => []],
                              ["codigo" => "411510", "name" => "Petróleo crudo", "children" => []],
                              ["codigo" => "411512", "name" => "Gas natural", "children" => []],
                              ["codigo" => "411514", "name" => "Servicios relacionados con extracción de petróleo y gas", "children" => []],
                              ["codigo" => "411515", "name" => "Minerales de hierro", "children" => []],
                              ["codigo" => "411520", "name" => "Minerales metalíferos no ferrosos", "children" => []],
                              ["codigo" => "411525", "name" => "Piedra, arena y arcilla", "children" => []],
                              ["codigo" => "411527", "name" => "Piedras preciosas", "children" => []],
                              ["codigo" => "411528", "name" => "Oro", "children" => []],
                              ["codigo" => "411530", "name" => "Otras minas y canteras", "children" => []],
                              ["codigo" => "411532", "name" => "Prestación de servicios sector minero", "children" => []],
                              ["codigo" => "411595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "411599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "4120",
                        "name" => "Industrias manufactureras",
                        "children" => [
                            ["codigo" => "412001", "name" => "Producción y procesamiento de carnes y productos cárnicos", "children" => []],
                            ["codigo" => "412002", "name" => "Productos de pescado", "children" => []],
                            ["codigo" => "412003", "name" => "Productos de frutas, legumbres y hortalizas", "children" => []],
                            ["codigo" => "412004", "name" => "Elaboración de aceites y grasas", "children" => []],
                            ["codigo" => "412005", "name" => "Elaboración de productos lácteos", "children" => []],
                            ["codigo" => "412006", "name" => "Elaboración de productos de molinería", "children" => []],
                            ["codigo" => "412007", "name" => "Elaboración de almidones y derivados", "children" => []],
                            ["codigo" => "412008", "name" => "Elaboración de alimentos para animales", "children" => []],
                            ["codigo" => "412009", "name" => "Elaboración de productos para panadería", "children" => []],
                            ["codigo" => "412010", "name" => "Elaboración de azúcar y melazas", "children" => []],
                            ["codigo" => "412011", "name" => "Elaboración de cacao, chocolate y confitería", "children" => []],
                            ["codigo" => "412012", "name" => "Elaboración de pastas y productos farináceos", "children" => []],
                            ["codigo" => "412013", "name" => "Elaboración de productos de café", "children" => []],
                            ["codigo" => "412014", "name" => "Elaboración de otros productos alimenticios", "children" => []],
                            ["codigo" => "412015", "name" => "Elaboración de bebidas alcohólicas y alcohol etílico", "children" => []],
                            ["codigo" => "412016", "name" => "Elaboración de vinos", "children" => []],
                            ["codigo" => "412017", "name" => "Elaboración de bebidas malteadas y de malta", "children" => []],
                            ["codigo" => "412018", "name" => "Elaboración de bebidas no alcohólicas", "children" => []],
                            ["codigo" => "412019", "name" => "Elaboración de productos de tabaco", "children" => []],
                            ["codigo" => "412020", "name" => "Preparación e hilatura de fibras textiles y tejeduría", "children" => []],
                            ["codigo" => "412021", "name" => "Acabado de productos textiles", "children" => []],
                            ["codigo" => "412022", "name" => "Elaboración de artículos de materiales textiles", "children" => []],
                            ["codigo" => "412023", "name" => "Elaboración de tapices y alfombras", "children" => []],
                            ["codigo" => "412024", "name" => "Elaboración de cuerdas, cordeles, bramantes y redes", "children" => []],
                            ["codigo" => "412025", "name" => "Elaboración de otros productos textiles", "children" => []],
                            ["codigo" => "412026", "name" => "Elaboración de tejidos", "children" => []],
                            ["codigo" => "412027", "name" => "Elaboración de prendas de vestir", "children" => []],
                            ["codigo" => "412028", "name" => "Preparación, adobo y teñido de pieles", "children" => []],
                            ["codigo" => "412029", "name" => "Curtido, adobo o preparación de cuero", "children" => []],
                            ["codigo" => "412030", "name" => "Elaboración de maletas, bolsos y similares", "children" => []],
                            ["codigo" => "412031", "name" => "Elaboración de calzado", "children" => []],
                            ["codigo" => "412032", "name" => "Producción de madera, artículos de madera y corcho", "children" => []],
                            ["codigo" => "412033", "name" => "Elaboración de pasta y productos de madera, papel y cartón", "children" => []],
                            ["codigo" => "412034", "name" => "Ediciones y publicaciones", "children" => []],
                            ["codigo" => "412035", "name" => "Impresión", "children" => []],
                            ["codigo" => "412036", "name" => "Servicios relacionados con la edición y la impresión", "children" => []],
                            ["codigo" => "412037", "name" => "Reproducción de grabaciones", "children" => []],
                            ["codigo" => "412038", "name" => "Elaboración de productos de horno de coque", "children" => []],
                            ["codigo" => "412039", "name" => "Elaboración de productos de la refinación de petróleo", "children" => []],
                            ["codigo" => "412040", "name" => "Elaboración de sustancias químicas básicas", "children" => []],
                            ["codigo" => "412041", "name" => "Elaboración de abonos y compuestos de nitrógeno", "children" => []],
                            ["codigo" => "412042", "name" => "Elaboración de plástico y caucho sintético", "children" => []],
                            ["codigo" => "412043", "name" => "Elaboración de productos químicos de uso agropecuario", "children" => []],
                            ["codigo" => "412044", "name" => "Elaboración de pinturas, tintas y masillas", "children" => []],
                            ["codigo" => "412045", "name" => "Elaboración de productos farmacéuticos y botánicos", "children" => []],
                            ["codigo" => "412046", "name" => "Elaboración de jabones, detergentes y preparados de tocador", "children" => []],
                            ["codigo" => "412047", "name" => "Elaboración de otros productos químicos", "children" => []],
                            ["codigo" => "412048", "name" => "Elaboración de fibras", "children" => []],
                            ["codigo" => "412049", "name" => "Elaboración de otros productos de caucho", "children" => []],
                            ["codigo" => "412050", "name" => "Elaboración de productos de plástico", "children" => []],
                            ["codigo" => "412051", "name" => "Elaboración de vidrio y productos de vidrio", "children" => []],
                            ["codigo" => "412052", "name" => "Elaboración de productos de cerámica, loza, piedra, arcilla y porcelana", "children" => []],
                            ["codigo" => "412053", "name" => "Elaboración de cemento, cal y yeso", "children" => []],
                            ["codigo" => "412054", "name" => "Elaboración de artículos de hormigón, cemento y yeso", "children" => []],
                            ["codigo" => "412055", "name" => "Corte, tallado y acabado de la piedra", "children" => []],
                            ["codigo" => "412056", "name" => "Elaboración de otros productos minerales no metálicos", "children" => []],
                            ["codigo" => "412057", "name" => "Industrias básicas y fundición de hierro y acero", "children" => []],
                            ["codigo" => "412058", "name" => "Productos primarios de metales preciosos y de metales no ferrosos", "children" => []],
                            ["codigo" => "412059", "name" => "Fundición de metales no ferrosos", "children" => []],
                            ["codigo" => "412060", "name" => "Fabricación de productos metálicos para uso estructural", "children" => []],
                            ["codigo" => "412061", "name" => "Forja, prensado, estampado, laminado de metal y pulvimetalurgia", "children" => []],
                            ["codigo" => "412062", "name" => "Revestimiento de metales y obras de ingeniería mecánica", "children" => []],
                            ["codigo" => "412063", "name" => "Fabricación de artículos de ferretería", "children" => []],
                            ["codigo" => "412064", "name" => "Elaboración de otros productos de metal", "children" => []],
                            ["codigo" => "412065", "name" => "Fabricación de maquinaria y equipo", "children" => []],
                            ["codigo" => "412066", "name" => "Fabricación de equipos de elevación y manipulación", "children" => []],
                            ["codigo" => "412067", "name" => "Elaboración de aparatos de uso doméstico", "children" => []],
                            ["codigo" => "412068", "name" => "Elaboración de equipo de oficina", "children" => []],
                            ["codigo" => "412069", "name" => "Elaboración de pilas y baterías primarias", "children" => []],
                            ["codigo" => "412070", "name" => "Elaboración de equipo de iluminación", "children" => []],
                            ["codigo" => "412071", "name" => "Elaboración de otros tipos de equipo eléctrico", "children" => []],
                            ["codigo" => "412072", "name" => "Fabricación de equipos de radio, televisión y comunicaciones", "children" => []],
                            ["codigo" => "412073", "name" => "Fabricación de aparatos e instrumentos médicos", "children" => []],
                            ["codigo" => "412074", "name" => "Fabricación de instrumentos de medición y control", "children" => []],
                            ["codigo" => "412075", "name" => "Fabricación de instrumentos de óptica y equipo fotográfico", "children" => []],
                            ["codigo" => "412076", "name" => "Fabricación de relojes", "children" => []],
                            ["codigo" => "412077", "name" => "Fabricación de vehículos automotores", "children" => []],
                            ["codigo" => "412078", "name" => "Fabricación de carrocerías para automotores", "children" => []],
                            ["codigo" => "412079", "name" => "Fabricación de partes piezas y accesorios para automotores", "children" => []],
                            ["codigo" => "412080", "name" => "Fabricación y reparación de buques y otras embarcaciones", "children" => []],
                            ["codigo" => "412081", "name" => "Fabricación de locomotoras y material rodante para ferrocarriles", "children" => []],
                            ["codigo" => "412082", "name" => "Fabricación de aeronaves", "children" => []],
                            ["codigo" => "412083", "name" => "Fabricación de motocicletas", "children" => []],
                            ["codigo" => "412084", "name" => "Fabricación de bicicletas y sillas de ruedas", "children" => []],
                            ["codigo" => "412085", "name" => "Fabricación de otros tipos de transporte", "children" => []],
                            ["codigo" => "412086", "name" => "Fabricación de muebles", "children" => []],
                            ["codigo" => "412087", "name" => "Fabricación de joyas y artículos conexos", "children" => []],
                            ["codigo" => "412088", "name" => "Fabricación de instrumentos de música", "children" => []],
                            ["codigo" => "412089", "name" => "Fabricación de artículos y equipo para deporte", "children" => []],
                            ["codigo" => "412090", "name" => "Fabricación de juegos y juguetes", "children" => []],
                            ["codigo" => "412091", "name" => "Reciclamiento de desperdicios", "children" => []],
                            ["codigo" => "412095", "name" => "Productos de otras industrias manufactureras", "children" => []],
                            ["codigo" => "412099", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                        "codigo" => "4125",
                        "name" => "Suministro de electricidad, gas y agua",
                        "children" => [
                            ["codigo" => "412501", "name" => "Producción, transporte y distribución de electricidad", "children" => []],
                            ["codigo" => "412502", "name" => "Captación, tratamiento y distribución de agua", "children" => []],
                            ["codigo" => "412503", "name" => "Producción y distribución de gas", "children" => []],
                            ["codigo" => "412504", "name" => "Recolección y tratamiento de aguas residuales", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "4130",
                          "name" => "Construcción",
                          "children" => [
                              ["codigo" => "413005", "name" => "Preparación de terrenos", "children" => []],
                              ["codigo" => "413010", "name" => "Construcción de edificios y obras de ingeniería civil", "children" => []],
                              ["codigo" => "413015", "name" => "Acondicionamiento de edificios", "children" => []],
                              ["codigo" => "413020", "name" => "Terminación de edificaciones", "children" => []],
                              ["codigo" => "413025", "name" => "Alquiler de equipo con operarios", "children" => []],
                              ["codigo" => "413095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "413099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "4135",
                        "name" => "Comercio al por mayor y al por menor",
                        "children" => [
                            ["codigo" => "413502", "name" => "Venta de vehículos automotores", "children" => []],
                            ["codigo" => "413504", "name" => "Mantenimiento, reparación y lavado de vehículos automotores", "children" => []],
                            ["codigo" => "413506", "name" => "Venta de partes, piezas y accesorios de vehículos automotores", "children" => []],
                            ["codigo" => "413508", "name" => "Venta de combustibles sólidos, líquidos, gaseosos", "children" => []],
                            ["codigo" => "413510", "name" => "Venta de lubricantes, aditivos, llantas y lujos para automotores", "children" => []],
                            ["codigo" => "413512", "name" => "Venta a cambio de retribución o por contrata", "children" => []],
                            ["codigo" => "413514", "name" => "Venta de insumos, materias primas agropecuarias y flores", "children" => []],
                            ["codigo" => "413516", "name" => "Venta de otros insumos y materias primas no agropecuarias", "children" => []],
                            ["codigo" => "413518", "name" => "Venta de animales vivos y cueros", "children" => []],
                            ["codigo" => "413520", "name" => "Venta de productos en almacenes no especializados", "children" => []],
                            ["codigo" => "413522", "name" => "Venta de productos agropecuarios", "children" => []],
                            ["codigo" => "413524", "name" => "Venta de productos textiles, de vestir, de cuero y calzado", "children" => []],
                            ["codigo" => "413526", "name" => "Venta de papel y cartón", "children" => []],
                            ["codigo" => "413528", "name" => "Venta de libros, revistas, elementos de papelería, útiles y textos escolares", "children" => []],
                            ["codigo" => "413530", "name" => "Venta de juegos, juguetes y artículos deportivos", "children" => []],
                            ["codigo" => "413532", "name" => "Venta de instrumentos quirúrgicos y ortopédicos", "children" => []],
                            ["codigo" => "413534", "name" => "Venta de artículos en relojerías y joyerías", "children" => []],
                            ["codigo" => "413536", "name" => "Venta de electrodomésticos y muebles", "children" => []],
                            ["codigo" => "413538", "name" => "Venta de productos de aseo, farmacéuticos, medicinales, y artículos de tocador", "children" => []],
                            ["codigo" => "413540", "name" => "Venta de cubiertos, vajillas, cristalería, porcelanas, cerámicas y otros artículos de uso doméstico", "children" => []],
                            ["codigo" => "413542", "name" => "Venta de materiales de construcción, fontanería y calefacción", "children" => []],
                            ["codigo" => "413544", "name" => "Venta de pinturas y lacas", "children" => []],
                            ["codigo" => "413546", "name" => "Venta de productos de vidrios y marquetería", "children" => []],
                            ["codigo" => "413548", "name" => "Venta de herramientas y artículos de ferretería", "children" => []],
                            ["codigo" => "413550", "name" => "Venta de químicos", "children" => []],
                            ["codigo" => "413552", "name" => "Venta de productos intermedios, desperdicios y desechos", "children" => []],
                            ["codigo" => "413554", "name" => "Venta de maquinaria, equipo de oficina y programas de computador", "children" => []],
                            ["codigo" => "413556", "name" => "Venta de artículos en cacharrerías y misceláneas", "children" => []],
                            ["codigo" => "413558", "name" => "Venta de instrumentos musicales", "children" => []],
                            ["codigo" => "413560", "name" => "Venta de artículos en casas de empeño y prenderías", "children" => []],
                            ["codigo" => "413562", "name" => "Venta de equipo fotográfico", "children" => []],
                            ["codigo" => "413564", "name" => "Venta de equipo óptico y de precisión", "children" => []],
                            ["codigo" => "413566", "name" => "Venta de empaques", "children" => []],
                            ["codigo" => "413568", "name" => "Venta de equipo profesional y científico", "children" => []],
                            ["codigo" => "413570", "name" => "Venta de loterías, rifas, chance, apuestas y similares", "children" => []],
                            ["codigo" => "413572", "name" => "Reparación de efectos personales y electrodomésticos", "children" => []],
                            ["codigo" => "413595", "name" => "Venta de otros productos", "children" => []],
                            ["codigo" => "413599", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                        "codigo" => "4140",
                        "name" => "Hoteles y restaurantes",
                        "children" => [
                            ["codigo" => "414005", "name" => "Hotelería", "children" => []],
                            ["codigo" => "414010", "name" => "Campamento y otros tipos de hospedaje", "children" => []],
                            ["codigo" => "414015", "name" => "Restaurantes", "children" => []],
                            ["codigo" => "414020", "name" => "Bares y cantinas", "children" => []],
                            ["codigo" => "414095", "name" => "Actividades conexas", "children" => []],
                            ["codigo" => "414099", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "4145",
                          "name" => "Transporte, almacenamiento y comunicaciones",
                          "children" => [
                              ["codigo" => "414505", "name" => "Servicio de transporte por carretera", "children" => []],
                              ["codigo" => "414510", "name" => "Servicio de transporte por vía férrea", "children" => []],
                              ["codigo" => "414515", "name" => "Servicio de transporte por vía acuática", "children" => []],
                              ["codigo" => "414520", "name" => "Servicio de transporte por vía aérea", "children" => []],
                              ["codigo" => "414525", "name" => "Servicio de transporte por tuberías", "children" => []],
                              ["codigo" => "414530", "name" => "Manipulación de carga", "children" => []],
                              ["codigo" => "414535", "name" => "Almacenamiento y depósito", "children" => []],
                              ["codigo" => "414540", "name" => "Servicios complementarios para el transporte", "children" => []],
                              ["codigo" => "414545", "name" => "Agencias de viaje", "children" => []],
                              ["codigo" => "414550", "name" => "Otras agencias de transporte", "children" => []],
                              ["codigo" => "414555", "name" => "Servicio postal y de correo", "children" => []],
                              ["codigo" => "414560", "name" => "Servicio telefónico", "children" => []],
                              ["codigo" => "414565", "name" => "Servicio de telégrafo", "children" => []],
                              ["codigo" => "414570", "name" => "Servicio de transmisión de datos", "children" => []],
                              ["codigo" => "414575", "name" => "Servicio de radio y televisión por cable", "children" => []],
                              ["codigo" => "414580", "name" => "Transmisión de sonido e imágenes por contrato", "children" => []],
                              ["codigo" => "414595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "414599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4150",
                          "name" => "Actividad financiera",
                          "children" => [
                              ["codigo" => "415005", "name" => "Venta de inversiones", "children" => []],
                              ["codigo" => "415010", "name" => "Dividendos de sociedades anónimas y/o asimiladas", "children" => []],
                              ["codigo" => "415015", "name" => "Participaciones de sociedades limitadas y/o asimiladas", "children" => []],
                              ["codigo" => "415020", "name" => "Intereses", "children" => []],
                              ["codigo" => "415025", "name" => "Reajuste monetario-UPAC (hoy UVR)", "children" => []],
                              ["codigo" => "415030", "name" => "Comisiones", "children" => []],
                              ["codigo" => "415035", "name" => "Operaciones de descuento", "children" => []],
                              ["codigo" => "415040", "name" => "Cuotas de inscripción-consorcios", "children" => []],
                              ["codigo" => "415045", "name" => "Cuotas de administración-consorcios", "children" => []],
                              ["codigo" => "415050", "name" => "Reajuste del sistema-consorcios", "children" => []],
                              ["codigo" => "415055", "name" => "Eliminación de suscriptores-consorcios", "children" => []],
                              ["codigo" => "415060", "name" => "Cuotas de ingreso o retiro-sociedad administradora", "children" => []],
                              ["codigo" => "415065", "name" => "Servicios a comisionistas", "children" => []],
                              ["codigo" => "415070", "name" => "Inscripciones y cuotas", "children" => []],
                              ["codigo" => "415075", "name" => "Recuperación de garantías", "children" => []],
                              ["codigo" => "415080", "name" => "Ingresos método de participación", "children" => []],
                              ["codigo" => "415095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "415099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4155",
                          "name" => "Actividades inmobiliarias, empresariales y de alquiler",
                          "children" => [
                              ["codigo" => "415505", "name" => "Arrendamientos de bienes inmuebles", "children" => []],
                              ["codigo" => "415510", "name" => "Inmobiliarias por retribución o contrata", "children" => []],
                              ["codigo" => "415515", "name" => "Alquiler equipo de transporte", "children" => []],
                              ["codigo" => "415520", "name" => "Alquiler maquinaria y equipo", "children" => []],
                              ["codigo" => "415525", "name" => "Alquiler de efectos personales y enseres domésticos", "children" => []],
                              ["codigo" => "415530", "name" => "Consultoría en equipo y programas de informática", "children" => []],
                              ["codigo" => "415535", "name" => "Procesamiento de datos", "children" => []],
                              ["codigo" => "415540", "name" => "Mantenimiento y reparación de maquinaria de oficina", "children" => []],
                              ["codigo" => "415545", "name" => "Investigaciones científicas y de desarrollo", "children" => []],
                              ["codigo" => "415550", "name" => "Actividades empresariales de consultoría", "children" => []],
                              ["codigo" => "415555", "name" => "Publicidad", "children" => []],
                              ["codigo" => "415560", "name" => "Dotación de personal", "children" => []],
                              ["codigo" => "415565", "name" => "Investigación y seguridad", "children" => []],
                              ["codigo" => "415570", "name" => "Limpieza de inmuebles", "children" => []],
                              ["codigo" => "415575", "name" => "Fotografía", "children" => []],
                              ["codigo" => "415580", "name" => "Envase y empaque", "children" => []],
                              ["codigo" => "415585", "name" => "Fotocopiado", "children" => []],
                              ["codigo" => "415590", "name" => "Mantenimiento y reparación de maquinaria y equipo", "children" => []],
                              ["codigo" => "415595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "415599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4160",
                          "name" => "Enseñanza",
                          "children" => [
                              ["codigo" => "416005", "name" => "Actividades relacionadas con la educación", "children" => []],
                              ["codigo" => "416095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "416099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4165",
                          "name" => "Servicios sociales y de salud",
                          "children" => [
                              ["codigo" => "416505", "name" => "Servicio hospitalario", "children" => []],
                              ["codigo" => "416510", "name" => "Servicio médico", "children" => []],
                              ["codigo" => "416515", "name" => "Servicio odontológico", "children" => []],
                              ["codigo" => "416520", "name" => "Servicio de laboratorio", "children" => []],
                              ["codigo" => "416525", "name" => "Actividades veterinarias", "children" => []],
                              ["codigo" => "416530", "name" => "Actividades de servicios sociales", "children" => []],
                              ["codigo" => "416595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "416599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4170",
                          "name" => "Otras actividades de servicios comunitarios, sociales y personales",
                          "children" => [
                              ["codigo" => "417005", "name" => "Eliminación de desperdicios y aguas residuales", "children" => []],
                              ["codigo" => "417010", "name" => "Actividades de asociación", "children" => []],
                              ["codigo" => "417015", "name" => "Producción y distribución de filmes y videocintas", "children" => []],
                              ["codigo" => "417020", "name" => "Exhibición de filmes y videocintas", "children" => []],
                              ["codigo" => "417025", "name" => "Actividad de radio y televisión", "children" => []],
                              ["codigo" => "417030", "name" => "Actividad teatral, musical y artística", "children" => []],
                              ["codigo" => "417035", "name" => "Grabación y producción de discos", "children" => []],
                              ["codigo" => "417040", "name" => "Entretenimiento y esparcimiento", "children" => []],
                              ["codigo" => "417045", "name" => "Agencias de noticias", "children" => []],
                              ["codigo" => "417050", "name" => "Lavanderías y similares", "children" => []],
                              ["codigo" => "417055", "name" => "Peluquerías y similares", "children" => []],
                              ["codigo" => "417060", "name" => "Servicios funerarios", "children" => []],
                              ["codigo" => "417065", "name" => "Zonas francas", "children" => []],
                              ["codigo" => "417095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "417099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4175",
                          "name" => "Devoluciones en ventas (DB)",
                          "children" => [
                              ["codigo" => "417595", "name" => "Devoluciones en ventas", "children" => []],
                              ["codigo" => "417599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ]
                  ],
                ],
                [
                  "codigo" => "42",
                  "name" => "No operacionales",
                  "children" => [
                      [
                          "codigo" => "4205",
                          "name" => "Otras ventas",
                          "children" => [
                              ["codigo" => "420505", "name" => "Materia prima", "children" => []],
                              ["codigo" => "420510", "name" => "Material de desecho", "children" => []],
                              ["codigo" => "420515", "name" => "Materiales varios", "children" => []],
                              ["codigo" => "420520", "name" => "Productos de diversificación", "children" => []],
                              ["codigo" => "420525", "name" => "Excedentes de exportación", "children" => []],
                              ["codigo" => "420530", "name" => "Envases y empaques", "children" => []],
                              ["codigo" => "420535", "name" => "Productos agrícolas", "children" => []],
                              ["codigo" => "420540", "name" => "De propaganda", "children" => []],
                              ["codigo" => "420545", "name" => "Productos en remate", "children" => []],
                              ["codigo" => "420550", "name" => "Combustibles y lubricantes", "children" => []],
                              ["codigo" => "420599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4210",
                          "name" => "Financieros",
                          "children" => [
                              ["codigo" => "421005", "name" => "Intereses", "children" => []],
                              ["codigo" => "421010", "name" => "Reajuste monetario-UPAC (hoy UVR)", "children" => []],
                              ["codigo" => "421015", "name" => "Descuentos amortizados", "children" => []],
                              ["codigo" => "421020", "name" => "Diferencia en cambio", "children" => []],
                              ["codigo" => "421025", "name" => "Financiación vehículos", "children" => []],
                              ["codigo" => "421030", "name" => "Financiación sistemas de viajes", "children" => []],
                              ["codigo" => "421035", "name" => "Aceptaciones bancarias", "children" => []],
                              ["codigo" => "421040", "name" => "Descuentos comerciales", "children" => []],
                              ["codigo" => "421045", "name" => "Descuentos bancarios", "children" => []],
                              ["codigo" => "421050", "name" => "Comisiones cheques de otras plazas", "children" => []],
                              ["codigo" => "421055", "name" => "Multas y recargos", "children" => []],
                              ["codigo" => "421060", "name" => "Sanciones cheques devueltos", "children" => []],
                              ["codigo" => "421095", "name" => "Otros", "children" => []],
                              ["codigo" => "421099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4215",
                          "name" => "Dividendos y participaciones",
                          "children" => [
                              ["codigo" => "421505", "name" => "De sociedades anónimas y/o asimiladas", "children" => []],
                              ["codigo" => "421510", "name" => "De sociedades limitadas y/o asimiladas", "children" => []],
                              ["codigo" => "421599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4218",
                          "name" => "Ingresos método de participación",
                          "children" => [
                              ["codigo" => "421805", "name" => "De sociedades anónimas y/o asimiladas", "children" => []],
                              ["codigo" => "421810", "name" => "De sociedades limitadas y/o asimiladas", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4220",
                          "name" => "Arrendamientos",
                          "children" => [
                              ["codigo" => "422005", "name" => "Terrenos", "children" => []],
                              ["codigo" => "422010", "name" => "Construcciones y edificios", "children" => []],
                              ["codigo" => "422015", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "422020", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "422025", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "422030", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "422035", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "422040", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "422045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "422050", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "422055", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "422060", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "422062", "name" => "Envases y empaques", "children" => []],
                              ["codigo" => "422065", "name" => "Plantaciones agrícolas y forestales", "children" => []],
                              ["codigo" => "422070", "name" => "Aeródromos", "children" => []],
                              ["codigo" => "422075", "name" => "Semovientes", "children" => []],
                              ["codigo" => "422099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4225",
                          "name" => "Comisiones",
                          "children" => [
                              ["codigo" => "422505", "name" => "Sobre inversiones", "children" => []],
                              ["codigo" => "422510", "name" => "De concesionarios", "children" => []],
                              ["codigo" => "422515", "name" => "De actividades financieras", "children" => []],
                              ["codigo" => "422520", "name" => "Por venta de servicios de taller", "children" => []],
                              ["codigo" => "422525", "name" => "Por venta de seguros", "children" => []],
                              ["codigo" => "422530", "name" => "Por ingresos para terceros", "children" => []],
                              ["codigo" => "422535", "name" => "Por distribución de películas", "children" => []],
                              ["codigo" => "422540", "name" => "Derechos de autor", "children" => []],
                              ["codigo" => "422545", "name" => "Derechos de programación", "children" => []],
                              ["codigo" => "422599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4230",
                          "name" => "Honorarios",
                          "children" => [
                              ["codigo" => "423005", "name" => "Asesorías", "children" => []],
                              ["codigo" => "423010", "name" => "Asistencia técnica", "children" => []],
                              ["codigo" => "423015", "name" => "Administración de vinculadas", "children" => []],
                              ["codigo" => "423099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4235",
                          "name" => "Servicios",
                          "children" => [
                              ["codigo" => "423505", "name" => "De báscula", "children" => []],
                              ["codigo" => "423510", "name" => "De transporte", "children" => []],
                              ["codigo" => "423515", "name" => "De prensa", "children" => []],
                              ["codigo" => "423520", "name" => "Administrativos", "children" => []],
                              ["codigo" => "423525", "name" => "Técnicos", "children" => []],
                              ["codigo" => "423530", "name" => "De computación", "children" => []],
                              ["codigo" => "423535", "name" => "De telefax", "children" => []],
                              ["codigo" => "423540", "name" => "Taller de vehículos", "children" => []],
                              ["codigo" => "423545", "name" => "De recepción de aeronaves", "children" => []],
                              ["codigo" => "423550", "name" => "De transporte programa gas natural", "children" => []],
                              ["codigo" => "423555", "name" => "Por contratos", "children" => []],
                              ["codigo" => "423560", "name" => "De trilla", "children" => []],
                              ["codigo" => "423565", "name" => "De mantenimiento", "children" => []],
                              ["codigo" => "423570", "name" => "Al personal", "children" => []],
                              ["codigo" => "423575", "name" => "De casino", "children" => []],
                              ["codigo" => "423580", "name" => "Fletes", "children" => []],
                              ["codigo" => "423585", "name" => "Entre compañías", "children" => []],
                              ["codigo" => "423595", "name" => "Otros", "children" => []],
                              ["codigo" => "423599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4240",
                          "name" => "Utilidad en venta de inversiones",
                          "children" => [
                              ["codigo" => "424005", "name" => "Acciones", "children" => []],
                              ["codigo" => "424010", "name" => "Cuotas o partes de interés social", "children" => []],
                              ["codigo" => "424015", "name" => "Bonos", "children" => []],
                              ["codigo" => "424020", "name" => "Cédulas", "children" => []],
                              ["codigo" => "424025", "name" => "Certificados", "children" => []],
                              ["codigo" => "424030", "name" => "Papeles comerciales", "children" => []],
                              ["codigo" => "424035", "name" => "Títulos", "children" => []],
                              ["codigo" => "424045", "name" => "Derechos fiduciarios", "children" => []],
                              ["codigo" => "424050", "name" => "Obligatorias", "children" => []],
                              ["codigo" => "424095", "name" => "Otras", "children" => []],
                              ["codigo" => "424099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "4245",
                        "name" => "Utilidad en venta de propiedades, planta y equipo",
                        "children" => [
                            ["codigo" => "424504", "name" => "Terrenos", "children" => []],
                            ["codigo" => "424506", "name" => "Materiales industria petrolera", "children" => []],
                            ["codigo" => "424508", "name" => "Construcciones en curso", "children" => []],
                            ["codigo" => "424512", "name" => "Maquinaria en montaje", "children" => []],
                            ["codigo" => "424516", "name" => "Construcciones y edificaciones", "children" => []],
                            ["codigo" => "424520", "name" => "Maquinaria y equipo", "children" => []],
                            ["codigo" => "424524", "name" => "Equipo de oficina", "children" => []],
                            ["codigo" => "424528", "name" => "Equipo de computación y comunicación", "children" => []],
                            ["codigo" => "424532", "name" => "Equipo médico-científico", "children" => []],
                            ["codigo" => "424536", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                            ["codigo" => "424540", "name" => "Flota y equipo de transporte", "children" => []],
                            ["codigo" => "424544", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                            ["codigo" => "424548", "name" => "Flota y equipo aéreo", "children" => []],
                            ["codigo" => "424552", "name" => "Flota y equipo férreo", "children" => []],
                            ["codigo" => "424556", "name" => "Acueductos, plantas y redes", "children" => []],
                            ["codigo" => "424560", "name" => "Armamento de vigilancia", "children" => []],
                            ["codigo" => "424562", "name" => "Envases y empaques", "children" => []],
                            ["codigo" => "424564", "name" => "Plantaciones agrícolas y forestales", "children" => []],
                            ["codigo" => "424568", "name" => "Vías de comunicación", "children" => []],
                            ["codigo" => "424572", "name" => "Minas y Canteras", "children" => []],
                            ["codigo" => "424580", "name" => "Pozos artesianos", "children" => []],
                            ["codigo" => "424584", "name" => "Yacimientos", "children" => []],
                            ["codigo" => "424588", "name" => "Semovientes", "children" => []],
                            ["codigo" => "424599", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "4248",
                          "name" => "Utilidad en venta de otros bienes",
                          "children" => [
                              ["codigo" => "424805", "name" => "Intangibles", "children" => []],
                              ["codigo" => "424810", "name" => "Otros activos", "children" => []],
                              ["codigo" => "424899", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4250",
                          "name" => "Recuperaciones",
                          "children" => [
                              ["codigo" => "425005", "name" => "Deudas malas", "children" => []],
                              ["codigo" => "425010", "name" => "Seguros", "children" => []],
                              ["codigo" => "425015", "name" => "Reclamos", "children" => []],
                              ["codigo" => "425020", "name" => "Reintegro por personal en comisión", "children" => []],
                              ["codigo" => "425025", "name" => "Reintegro garantías", "children" => []],
                              ["codigo" => "425030", "name" => "Descuentos concedidos", "children" => []],
                              ["codigo" => "425035", "name" => "De provisiones", "children" => []],
                              ["codigo" => "425040", "name" => "Gastos bancarios", "children" => []],
                              ["codigo" => "425045", "name" => "De depreciación", "children" => []],
                              ["codigo" => "425050", "name" => "Reintegro de otros costos y gastos", "children" => []],
                              ["codigo" => "425099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4255",
                          "name" => "Indemnizaciones",
                          "children" => [
                              ["codigo" => "425505", "name" => "Por siniestro", "children" => []],
                              ["codigo" => "425510", "name" => "Por suministros", "children" => []],
                              ["codigo" => "425515", "name" => "Lucro cesante compañías de seguros", "children" => []],
                              ["codigo" => "425520", "name" => "Daño emergente compañías de seguros", "children" => []],
                              ["codigo" => "425525", "name" => "Por pérdida de mercancía", "children" => []],
                              ["codigo" => "425530", "name" => "Por incumplimiento de contratos", "children" => []],
                              ["codigo" => "425535", "name" => "De terceros", "children" => []],
                              ["codigo" => "425540", "name" => "Por incapacidades ISS", "children" => []],
                              ["codigo" => "425595", "name" => "Otras", "children" => []],
                              ["codigo" => "425599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4260",
                          "name" => "Participaciones en concesiones",
                          "children" => [
                              ["codigo" => "426099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4265",
                          "name" => "Ingresos de ejercicios anteriores",
                          "children" => [
                              ["codigo" => "426599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4275",
                          "name" => "Devoluciones en otras ventas (DB)",
                          "children" => [
                              ["codigo" => "427599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "4295",
                          "name" => "Diversos",
                          "children" => [
                              ["codigo" => "429503", "name" => "CERT", "children" => []],
                              ["codigo" => "429505", "name" => "Aprovechamientos", "children" => []],
                              ["codigo" => "429507", "name" => "Auxilios", "children" => []],
                              ["codigo" => "429509", "name" => "Subvenciones", "children" => []],
                              ["codigo" => "429511", "name" => "Ingresos por investigación y desarrollo", "children" => []],
                              ["codigo" => "429513", "name" => "Por trabajos ejecutados", "children" => []],
                              ["codigo" => "429515", "name" => "Regalías", "children" => []],
                              ["codigo" => "429517", "name" => "Derivados de las exportaciones", "children" => []],
                              ["codigo" => "429519", "name" => "Otros ingresos de explotación", "children" => []],
                              ["codigo" => "429521", "name" => "De la actividad ganadera", "children" => []],
                              ["codigo" => "429525", "name" => "Derechos y licitaciones", "children" => []],
                              ["codigo" => "429530", "name" => "Ingresos por elementos perdidos", "children" => []],
                              ["codigo" => "429533", "name" => "Multas y recargos", "children" => []],
                              ["codigo" => "429535", "name" => "Preavisos descontados", "children" => []],
                              ["codigo" => "429537", "name" => "Reclamos", "children" => []],
                              ["codigo" => "429540", "name" => "Recobro de daños", "children" => []],
                              ["codigo" => "429543", "name" => "Premios", "children" => []],
                              ["codigo" => "429545", "name" => "Bonificaciones", "children" => []],
                              ["codigo" => "429547", "name" => "Productos descontados", "children" => []],
                              ["codigo" => "429549", "name" => "Reconocimientos ISS", "children" => []],
                              ["codigo" => "429551", "name" => "Excedentes", "children" => []],
                              ["codigo" => "429553", "name" => "Sobrantes de caja", "children" => []],
                              ["codigo" => "429555", "name" => "Sobrantes en liquidación fletes", "children" => []],
                              ["codigo" => "429557", "name" => "Subsidios estatales", "children" => []],
                              ["codigo" => "429559", "name" => "Capacitación distribuidores", "children" => []],
                              ["codigo" => "429561", "name" => "De escrituración", "children" => []],
                              ["codigo" => "429563", "name" => "Registro promesas de venta", "children" => []],
                              ["codigo" => "429567", "name" => "Útiles, papelería y fotocopias", "children" => []],
                              ["codigo" => "429571", "name" => "Resultados, matrículas y traspasos", "children" => []],
                              ["codigo" => "429573", "name" => "Decoraciones", "children" => []],
                              ["codigo" => "429575", "name" => "Manejo de carga", "children" => []],
                              ["codigo" => "429579", "name" => "Historia clínica", "children" => []],
                              ["codigo" => "429581", "name" => "Ajuste al peso", "children" => []],
                              ["codigo" => "429583", "name" => "Llamadas telefónicas", "children" => []],
                              ["codigo" => "429595", "name" => "Otros", "children" => []],
                              ["codigo" => "429599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
                ],
                [
                  "codigo" => "47",
                  "name" => "Ajustes por inflación",
                  "children" => [
                      ["codigo" => "4705", "name" => "Corrección monetaria", "children" => [
                          ["codigo" => "470505", "name" => "Inversiones (CR)", "children" => []],
                          ["codigo" => "470510", "name" => "Inventarios (CR)", "children" => []],
                          ["codigo" => "470515", "name" => "Propiedades, planta y equipo (CR)", "children" => []],
                          ["codigo" => "470520", "name" => "Intangibles (CR)", "children" => []],
                          ["codigo" => "470525", "name" => "Activos diferidos", "children" => []],
                          ["codigo" => "470530", "name" => "Otros activos (CR)", "children" => []],
                          ["codigo" => "470535", "name" => "Pasivos sujetos de ajuste", "children" => []],
                          ["codigo" => "470540", "name" => "Patrimonio", "children" => []],
                          ["codigo" => "470545", "name" => "Depreciación acumulada (DB)", "children" => []],
                          ["codigo" => "470550", "name" => "Depreciación diferida (CR)", "children" => []],
                          ["codigo" => "470555", "name" => "Agotamiento acumulado (DB)", "children" => []],
                          ["codigo" => "470560", "name" => "Amortización acumulada (DB)", "children" => []],
                          ["codigo" => "470565", "name" => "Ingresos operacionales (DB)", "children" => []],
                          ["codigo" => "470568", "name" => "Devoluciones en ventas (CR)", "children" => []],
                          ["codigo" => "470570", "name" => "Ingresos no operacionales (DB)", "children" => []],
                          ["codigo" => "470575", "name" => "Gastos operacionales de administración (CR)", "children" => []],
                          ["codigo" => "470580", "name" => "Gastos operacionales de ventas (CR)", "children" => []],
                          ["codigo" => "470585", "name" => "Gastos no operacionales (CR)", "children" => []],
                          ["codigo" => "470590", "name" => "Compras (CR)", "children" => []],
                          ["codigo" => "470591", "name" => "Devoluciones en compras (DB)", "children" => []],
                          ["codigo" => "470592", "name" => "Costo de ventas (CR)", "children" => []],
                          ["codigo" => "470594", "name" => "Costos de producción o de operación (CR)", "children" => []],
                      ]],
                  ],
                ],
              ]
          ],
          [
              "codigo" => "5",
              "name" => "Gastos",
              "children" => [
                [
                  "codigo" => "51",
                  "name" => "Operacionales de administración",
                  "children" => [
                      [
                          "codigo" => "5105",
                          "name" => "Gastos de personal",
                          "children" => [
                              ["codigo" => "510503", "name" => "Salario integral", "children" => []],
                              ["codigo" => "510506", "name" => "Sueldos", "children" => []],
                              ["codigo" => "510512", "name" => "Jornales", "children" => []],
                              ["codigo" => "510515", "name" => "Horas extras y recargos", "children" => []],
                              ["codigo" => "510518", "name" => "Comisiones", "children" => []],
                              ["codigo" => "510521", "name" => "Viáticos", "children" => []],
                              ["codigo" => "510524", "name" => "Incapacidades", "children" => []],
                              ["codigo" => "510527", "name" => "Auxilio de transporte", "children" => []],
                              ["codigo" => "510530", "name" => "Cesantías", "children" => []],
                              ["codigo" => "510533", "name" => "Intereses sobre cesantías", "children" => []],
                              ["codigo" => "510536", "name" => "Prima de servicios", "children" => []],
                              ["codigo" => "510539", "name" => "Vacaciones", "children" => []],
                              ["codigo" => "510542", "name" => "Primas extralegales", "children" => []],
                              ["codigo" => "510545", "name" => "Auxilios", "children" => []],
                              ["codigo" => "510548", "name" => "Bonificaciones", "children" => []],
                              ["codigo" => "510551", "name" => "Dotación y suministro a trabajadores", "children" => []],
                              ["codigo" => "510554", "name" => "Seguros", "children" => []],
                              ["codigo" => "510557", "name" => "Cuotas partes pensiones de jubilación", "children" => []],
                              ["codigo" => "510558", "name" => "Amortización cálculo actuarial pensiones de jubilación", "children" => []],
                              ["codigo" => "510559", "name" => "Pensiones de jubilación", "children" => []],
                              ["codigo" => "510560", "name" => "Indemnizaciones laborales", "children" => []],
                              ["codigo" => "510561", "name" => "Amortización bonos pensionales", "children" => []],
                              ["codigo" => "510562", "name" => "Amortización títulos pensionales", "children" => []],
                              ["codigo" => "510563", "name" => "Capacitación al personal", "children" => []],
                              ["codigo" => "510566", "name" => "Gastos deportivos y de recreación", "children" => []],
                              ["codigo" => "510568", "name" => "Aportes a administradoras de riesgos profesionales, ARP", "children" => []],
                              ["codigo" => "510569", "name" => "Aportes a entidades promotoras de salud, EPS", "children" => []],
                              ["codigo" => "510570", "name" => "Aportes a fondos de pensiones y/o cesantías", "children" => []],
                              ["codigo" => "510572", "name" => "Aportes cajas de compensación familiar", "children" => []],
                              ["codigo" => "510575", "name" => "Aportes ICBF", "children" => []],
                              ["codigo" => "510578", "name" => "SENA", "children" => []],
                              ["codigo" => "510581", "name" => "Aportes sindicales", "children" => []],
                              ["codigo" => "510584", "name" => "Gastos médicos y drogas", "children" => []],
                              ["codigo" => "510595", "name" => "Otros", "children" => []],
                              ["codigo" => "510599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5110",
                          "name" => "Honorarios",
                          "children" => [
                              ["codigo" => "511005", "name" => "Junta directiva", "children" => []],
                              ["codigo" => "511010", "name" => "Revisoría fiscal", "children" => []],
                              ["codigo" => "511015", "name" => "Auditoría externa", "children" => []],
                              ["codigo" => "511020", "name" => "Avalúos", "children" => []],
                              ["codigo" => "511025", "name" => "Asesoría jurídica", "children" => []],
                              ["codigo" => "511030", "name" => "Asesoría financiera", "children" => []],
                              ["codigo" => "511035", "name" => "Asesoría técnica", "children" => []],
                              ["codigo" => "511095", "name" => "Otros", "children" => []],
                              ["codigo" => "511099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5115",
                          "name" => "Impuestos",
                          "children" => [
                              ["codigo" => "511505", "name" => "Industria y comercio", "children" => []],
                              ["codigo" => "511510", "name" => "De timbres", "children" => []],
                              ["codigo" => "511515", "name" => "A la propiedad raíz", "children" => []],
                              ["codigo" => "511520", "name" => "Derechos sobre instrumentos públicos", "children" => []],
                              ["codigo" => "511525", "name" => "De valorización", "children" => []],
                              ["codigo" => "511530", "name" => "De turismo", "children" => []],
                              ["codigo" => "511535", "name" => "Tasa por utilización de puertos", "children" => []],
                              ["codigo" => "511540", "name" => "De vehículos", "children" => []],
                              ["codigo" => "511545", "name" => "De espectáculos públicos", "children" => []],
                              ["codigo" => "511550", "name" => "Cuotas de fomento", "children" => []],
                              ["codigo" => "511570", "name" => "IVA descontable", "children" => []],
                              ["codigo" => "511595", "name" => "Otros", "children" => []],
                              ["codigo" => "511599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5120",
                          "name" => "Arrendamientos",
                          "children" => [
                              ["codigo" => "512005", "name" => "Terrenos", "children" => []],
                              ["codigo" => "512010", "name" => "Construcciones y edificaciones", "children" => []],
                              ["codigo" => "512015", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "512020", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "512025", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "512030", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "512035", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "512040", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "512045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "512050", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "512055", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "512060", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "512065", "name" => "Aeródromos", "children" => []],
                              ["codigo" => "512070", "name" => "Semovientes", "children" => []],
                              ["codigo" => "512095", "name" => "Otros", "children" => []],
                              ["codigo" => "512099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5125",
                          "name" => "Contribuciones y afiliacianes",
                          "children" => [
                              ["codigo" => "512505", "name" => "Contribuciones", "children" => []],
                              ["codigo" => "512510", "name" => "Afiliaciones y sostenimiento", "children" => []],
                              ["codigo" => "512515", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "5130",
                        "name" => "Seguros",
                        "children" => [
                            ["codigo" => "513005", "name" => "Manejo", "children" => []],
                            ["codigo" => "513010", "name" => "Cumplimiento", "children" => []],
                            ["codigo" => "513015", "name" => "Corriente débil", "children" => []],
                            ["codigo" => "513020", "name" => "Vida colectiva", "children" => []],
                            ["codigo" => "513025", "name" => "Incendio", "children" => []],
                            ["codigo" => "513030", "name" => "Terremoto", "children" => []],
                            ["codigo" => "513035", "name" => "Sustracción y hurto", "children" => []],
                            ["codigo" => "513040", "name" => "Flota y equipo de transporte", "children" => []],
                            ["codigo" => "513045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                            ["codigo" => "513050", "name" => "Flota y equipo aéreo", "children" => []],
                            ["codigo" => "513055", "name" => "Flota y equipo férreo", "children" => []],
                            ["codigo" => "513060", "name" => "Responsabilidad civil y extracontractual", "children" => []],
                            ["codigo" => "513065", "name" => "Vuelo", "children" => []],
                            ["codigo" => "513070", "name" => "Rotura de maquinaria", "children" => []],
                            ["codigo" => "513075", "name" => "Obligatorio accidente de tránsito", "children" => []],
                            ["codigo" => "513080", "name" => "Lucro cesante", "children" => []],
                            ["codigo" => "513085", "name" => "Transporte de mercancía", "children" => []],
                            ["codigo" => "513095", "name" => "Otros", "children" => []],
                            ["codigo" => "513099", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                        "codigo" => "5135",
                        "name" => "Servicios",
                        "children" => [
                            ["codigo" => "513505", "name" => "Aseo y vigilancia", "children" => []],
                            ["codigo" => "513510", "name" => "Temporales", "children" => []],
                            ["codigo" => "513515", "name" => "Asistencia técnica", "children" => []],
                            ["codigo" => "513520", "name" => "Procesamiento electrónico de datos", "children" => []],
                            ["codigo" => "513525", "name" => "Acueducto y alcantarillado", "children" => []],
                            ["codigo" => "513530", "name" => "Energía eléctrica", "children" => []],
                            ["codigo" => "513535", "name" => "Teléfono", "children" => []],
                            ["codigo" => "513540", "name" => "Correo, portes y telegramas", "children" => []],
                            ["codigo" => "513545", "name" => "Fax y télex", "children" => []],
                            ["codigo" => "513550", "name" => "Transporte, fletes y acarreos", "children" => []],
                            ["codigo" => "513555", "name" => "Gas", "children" => []],
                            ["codigo" => "513595", "name" => "Otros", "children" => []],
                            ["codigo" => "513599", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "5140",
                          "name" => "Gastos legales",
                          "children" => [
                              ["codigo" => "514005", "name" => "Notariales", "children" => []],
                              ["codigo" => "514010", "name" => "Registro mercantil", "children" => []],
                              ["codigo" => "514015", "name" => "Trámites y licencias", "children" => []],
                              ["codigo" => "514020", "name" => "Aduaneros", "children" => []],
                              ["codigo" => "514025", "name" => "Consulares", "children" => []],
                              ["codigo" => "514095", "name" => "Otros", "children" => []],
                              ["codigo" => "514099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5145",
                          "name" => "Mantenimiento y reparaciones",
                          "children" => [
                              ["codigo" => "514505", "name" => "Terrenos", "children" => []],
                              ["codigo" => "514510", "name" => "Construcciones y edificaciones", "children" => []],
                              ["codigo" => "514515", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "514520", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "514525", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "514530", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "514535", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "514540", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "514545", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "514550", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "514555", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "514560", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "514565", "name" => "Armamento de vigilancia", "children" => []],
                              ["codigo" => "514570", "name" => "Vías de comunicación", "children" => []],
                              ["codigo" => "514599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5150",
                          "name" => "Adecuación e instalación",
                          "children" => [
                              ["codigo" => "515005", "name" => "Instalaciones eléctricas", "children" => []],
                              ["codigo" => "515010", "name" => "Arreglos ornamentales", "children" => []],
                              ["codigo" => "515015", "name" => "Reparaciones locativas", "children" => []],
                              ["codigo" => "515095", "name" => "Otros", "children" => []],
                              ["codigo" => "515099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5155",
                          "name" => "Gastos de viaje",
                          "children" => [
                              ["codigo" => "515505", "name" => "Alojamiento y manutención", "children" => []],
                              ["codigo" => "515510", "name" => "Pasajes fluviales y/o marítimos", "children" => []],
                              ["codigo" => "515515", "name" => "Pasajes aéreos", "children" => []],
                              ["codigo" => "515520", "name" => "Pasajes terrestres", "children" => []],
                              ["codigo" => "515525", "name" => "Pasajes férreos", "children" => []],
                              ["codigo" => "515595", "name" => "Otros", "children" => []],
                              ["codigo" => "515599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "5160",
                        "name" => "Depreciaciones",
                        "children" => [
                            ["codigo" => "516005", "name" => "Construcciones y edificaciones", "children" => []],
                            ["codigo" => "516010", "name" => "Maquinaria y equipo", "children" => []],
                            ["codigo" => "516015", "name" => "Equipo de oficina", "children" => []],
                            ["codigo" => "516020", "name" => "Equipo de computación y comunicación", "children" => []],
                            ["codigo" => "516025", "name" => "Equipo médico-científico", "children" => []],
                            ["codigo" => "516030", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                            ["codigo" => "516035", "name" => "Flota y equipo de transporte", "children" => []],
                            ["codigo" => "516040", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                            ["codigo" => "516045", "name" => "Flota y equipo aéreo", "children" => []],
                            ["codigo" => "516050", "name" => "Flota y equipo férreo", "children" => []],
                            ["codigo" => "516055", "name" => "Acueductos, plantas y redes", "children" => []],
                            ["codigo" => "516060", "name" => "Armamento de vigilancia", "children" => []],
                            ["codigo" => "516099", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "5165",
                          "name" => "Amortizaciones",
                          "children" => [
                              ["codigo" => "516505", "name" => "Vías de comunicación", "children" => []],
                              ["codigo" => "516510", "name" => "Intangibles", "children" => []],
                              ["codigo" => "516515", "name" => "Cargos diferidos", "children" => []],
                              ["codigo" => "516595", "name" => "Otras", "children" => []],
                              ["codigo" => "516599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5195",
                          "name" => "Diversos",
                          "children" => [
                              ["codigo" => "519505", "name" => "Comisiones", "children" => []],
                              ["codigo" => "519510", "name" => "Libros, suscripciones, periódicos y revistas", "children" => []],
                              ["codigo" => "519515", "name" => "Música ambiental", "children" => []],
                              ["codigo" => "519520", "name" => "Gastos de representación y relaciones públicas", "children" => []],
                              ["codigo" => "519525", "name" => "Elementos de aseo y cafetería", "children" => []],
                              ["codigo" => "519530", "name" => "Útiles, papelería y fotocopias", "children" => []],
                              ["codigo" => "519535", "name" => "Combustibles y lubricantes", "children" => []],
                              ["codigo" => "519540", "name" => "Envases y empaques", "children" => []],
                              ["codigo" => "519545", "name" => "Taxis y buses", "children" => []],
                              ["codigo" => "519550", "name" => "Estampillas", "children" => []],
                              ["codigo" => "519555", "name" => "Microfilmación", "children" => []],
                              ["codigo" => "519560", "name" => "Casino y restaurante", "children" => []],
                              ["codigo" => "519565", "name" => "Parqueaderos", "children" => []],
                              ["codigo" => "519570", "name" => "Indemnización por daños a terceros", "children" => []],
                              ["codigo" => "519575", "name" => "Pólvora y similares", "children" => []],
                              ["codigo" => "519595", "name" => "Otros", "children" => []],
                              ["codigo" => "519599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5199",
                          "name" => "Provisiones",
                          "children" => [
                              ["codigo" => "519905", "name" => "Inversiones", "children" => []],
                              ["codigo" => "519910", "name" => "Deudores", "children" => []],
                              ["codigo" => "519915", "name" => "Propiedades, planta y equipo", "children" => []],
                              ["codigo" => "519995", "name" => "Otros activos", "children" => []],
                              ["codigo" => "519999", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
                ],
                [
                  "codigo" => "52",
                  "name" => "Operacionales de ventas",
                  "children" => [
                      [
                          "codigo" => "5205",
                          "name" => "Gastos de personal",
                          "children" => [
                              ["codigo" => "520503", "name" => "Salario integral", "children" => []],
                              ["codigo" => "520506", "name" => "Sueldos", "children" => []],
                              ["codigo" => "520512", "name" => "Jornales", "children" => []],
                              ["codigo" => "520515", "name" => "Horas extras y recargos", "children" => []],
                              ["codigo" => "520518", "name" => "Comisiones", "children" => []],
                              ["codigo" => "520521", "name" => "Viáticos", "children" => []],
                              ["codigo" => "520524", "name" => "Incapacidades", "children" => []],
                              ["codigo" => "520527", "name" => "Auxilio de transporte", "children" => []],
                              ["codigo" => "520530", "name" => "Cesantías", "children" => []],
                              ["codigo" => "520533", "name" => "Intereses sobre cesantías", "children" => []],
                              ["codigo" => "520536", "name" => "Prima de servicios", "children" => []],
                              ["codigo" => "520539", "name" => "Vacaciones", "children" => []],
                              ["codigo" => "520542", "name" => "Primas extralegales", "children" => []],
                              ["codigo" => "520545", "name" => "Auxilios", "children" => []],
                              ["codigo" => "520548", "name" => "Bonificaciones", "children" => []],
                              ["codigo" => "520551", "name" => "Dotación y suministro a trabajadores", "children" => []],
                              ["codigo" => "520554", "name" => "Seguros", "children" => []],
                              ["codigo" => "520557", "name" => "Cuotas partes pensiones de jubilación", "children" => []],
                              ["codigo" => "520558", "name" => "Amortización cálculo actuarial pensiones de jubilación", "children" => []],
                              ["codigo" => "520559", "name" => "Pensiones de jubilación", "children" => []],
                              ["codigo" => "520560", "name" => "Indemnizaciones laborales", "children" => []],
                              ["codigo" => "520561", "name" => "Amortización bonos pensionales", "children" => []],
                              ["codigo" => "520562", "name" => "Amortización títulos pensionales", "children" => []],
                              ["codigo" => "520563", "name" => "Capacitación al personal", "children" => []],
                              ["codigo" => "520566", "name" => "Gastos deportivos y de recreación", "children" => []],
                              ["codigo" => "520568", "name" => "Aportes a administradoras de riesgos profesionales, ARP", "children" => []],
                              ["codigo" => "520569", "name" => "Aportes a entidades promotoras de salud, EPS", "children" => []],
                              ["codigo" => "520570", "name" => "Aportes a fondos de pensiones y/o cesantías", "children" => []],
                              ["codigo" => "520572", "name" => "Aportes cajas de compensación familiar", "children" => []],
                              ["codigo" => "520575", "name" => "Aportes ICBF", "children" => []],
                              ["codigo" => "520578", "name" => "SENA", "children" => []],
                              ["codigo" => "520581", "name" => "Aportes sindicales", "children" => []],
                              ["codigo" => "520584", "name" => "Gastos médicos y drogas", "children" => []],
                              ["codigo" => "520595", "name" => "Otros", "children" => []],
                              ["codigo" => "520599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5210",
                          "name" => "Honorarios",
                          "children" => [
                              ["codigo" => "521005", "name" => "Junta directiva", "children" => []],
                              ["codigo" => "521010", "name" => "Revisoría fiscal", "children" => []],
                              ["codigo" => "521015", "name" => "Auditoría externa", "children" => []],
                              ["codigo" => "521020", "name" => "Avalúos", "children" => []],
                              ["codigo" => "521025", "name" => "Asesoría jurídica", "children" => []],
                              ["codigo" => "521030", "name" => "Asesoría financiera", "children" => []],
                              ["codigo" => "521035", "name" => "Asesoría técnica", "children" => []],
                              ["codigo" => "521095", "name" => "Otros", "children" => []],
                              ["codigo" => "521099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                        "codigo" => "5215",
                        "name" => "Impuestos",
                        "children" => [
                            ["codigo" => "521505", "name" => "Industria y comercio", "children" => []],
                            ["codigo" => "521510", "name" => "De timbres", "children" => []],
                            ["codigo" => "521515", "name" => "A la propiedad raíz", "children" => []],
                            ["codigo" => "521520", "name" => "Derechos sobre instrumentos públicos", "children" => []],
                            ["codigo" => "521525", "name" => "De valorización", "children" => []],
                            ["codigo" => "521530", "name" => "De turismo", "children" => []],
                            ["codigo" => "521535", "name" => "Tasa por utilización de puertos", "children" => []],
                            ["codigo" => "521540", "name" => "De vehículos", "children" => []],
                            ["codigo" => "521545", "name" => "De espectáculos públicos", "children" => []],
                            ["codigo" => "521550", "name" => "Cuotas de fomento", "children" => []],
                            ["codigo" => "521555", "name" => "Licores", "children" => []],
                            ["codigo" => "521560", "name" => "Cervezas", "children" => []],
                            ["codigo" => "521565", "name" => "Cigarrillos", "children" => []],
                            ["codigo" => "521570", "name" => "IVA descontable", "children" => []],
                            ["codigo" => "521595", "name" => "Otros", "children" => []],
                            ["codigo" => "521599", "name" => "Ajustes por inflación", "children" => []],
                        ],
                      ],
                      [
                          "codigo" => "5220",
                          "name" => "Arrendamientos",
                          "children" => [
                              ["codigo" => "522005", "name" => "Terrenos", "children" => []],
                              ["codigo" => "522010", "name" => "Construcciones y edificaciones", "children" => []],
                              ["codigo" => "522015", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "522020", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "522025", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "522030", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "522035", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "522040", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "522045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "522050", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "522055", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "522060", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "522065", "name" => "Aeródromos", "children" => []],
                              ["codigo" => "522070", "name" => "Semovientes", "children" => []],
                              ["codigo" => "522095", "name" => "Otros", "children" => []],
                              ["codigo" => "522099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5225",
                          "name" => "Contribuciones y afiliaciones",
                          "children" => [
                              ["codigo" => "522505", "name" => "Contribuciones", "children" => []],
                              ["codigo" => "522510", "name" => "Afiliaciones y sostenimiento", "children" => []],
                              ["codigo" => "522599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5230",
                          "name" => "Seguros",
                          "children" => [
                              ["codigo" => "523005", "name" => "Manejo", "children" => []],
                              ["codigo" => "523010", "name" => "Cumplimiento", "children" => []],
                              ["codigo" => "523015", "name" => "Corriente débil", "children" => []],
                              ["codigo" => "523020", "name" => "Vida colectiva", "children" => []],
                              ["codigo" => "523025", "name" => "Incendio", "children" => []],
                              ["codigo" => "523030", "name" => "Terremoto", "children" => []],
                              ["codigo" => "523035", "name" => "Sustracción y hurto", "children" => []],
                              ["codigo" => "523040", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "523045", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "523050", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "523055", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "523060", "name" => "Responsabilidad civil y extracontractual", "children" => []],
                              ["codigo" => "523065", "name" => "Vuelo", "children" => []],
                              ["codigo" => "523070", "name" => "Rotura de maquinaria", "children" => []],
                              ["codigo" => "523075", "name" => "Obligatorio accidente de tránsito", "children" => []],
                              ["codigo" => "523080", "name" => "Lucro cesante", "children" => []],
                              ["codigo" => "523095", "name" => "Otros", "children" => []],
                              ["codigo" => "523099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5235",
                          "name" => "Servicios",
                          "children" => [
                              ["codigo" => "523505", "name" => "Aseo y vigilancia", "children" => []],
                              ["codigo" => "523510", "name" => "Temporales", "children" => []],
                              ["codigo" => "523515", "name" => "Asistencia técnica", "children" => []],
                              ["codigo" => "523520", "name" => "Procesamiento electrónico de datos", "children" => []],
                              ["codigo" => "523525", "name" => "Acueducto y alcantarillado", "children" => []],
                              ["codigo" => "523530", "name" => "Energía eléctrica", "children" => []],
                              ["codigo" => "523535", "name" => "Teléfono", "children" => []],
                              ["codigo" => "523540", "name" => "Correo, portes y telegramas", "children" => []],
                              ["codigo" => "523545", "name" => "Fax y télex", "children" => []],
                              ["codigo" => "523550", "name" => "Transporte, fletes y acarreos", "children" => []],
                              ["codigo" => "523555", "name" => "Gas", "children" => []],
                              ["codigo" => "523560", "name" => "Publicidad, propaganda y promoción", "children" => []],
                              ["codigo" => "523595", "name" => "Otros", "children" => []],
                              ["codigo" => "523599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5240",
                          "name" => "Gastos legales",
                          "children" => [
                              ["codigo" => "524005", "name" => "Notariales", "children" => []],
                              ["codigo" => "524010", "name" => "Registro mercantil", "children" => []],
                              ["codigo" => "524015", "name" => "Trámites y licencias", "children" => []],
                              ["codigo" => "524020", "name" => "Aduaneros", "children" => []],
                              ["codigo" => "524025", "name" => "Consulares", "children" => []],
                              ["codigo" => "524095", "name" => "Otros", "children" => []],
                              ["codigo" => "524099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5245",
                          "name" => "Mantenimiento y reparaciones",
                          "children" => [
                              ["codigo" => "524505", "name" => "Terrenos", "children" => []],
                              ["codigo" => "524510", "name" => "Construcciones y edificaciones", "children" => []],
                              ["codigo" => "524515", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "524520", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "524525", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "524530", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "524535", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "524540", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "524545", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "524550", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "524555", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "524560", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "524565", "name" => "Armamento de vigilancia", "children" => []],
                              ["codigo" => "524570", "name" => "Vías de comunicación", "children" => []],
                              ["codigo" => "524599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5250",
                          "name" => "Adecuación e instalación",
                          "children" => [
                              ["codigo" => "525005", "name" => "Instalaciones eléctricas", "children" => []],
                              ["codigo" => "525010", "name" => "Arreglos ornamentales", "children" => []],
                              ["codigo" => "525015", "name" => "Reparaciones locativas", "children" => []],
                              ["codigo" => "525095", "name" => "Otros", "children" => []],
                              ["codigo" => "525099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5255",
                          "name" => "Gastos de viaje",
                          "children" => [
                              ["codigo" => "525505", "name" => "Alojamiento y manutención", "children" => []],
                              ["codigo" => "525510", "name" => "Pasajes fluviales y/o marítimos", "children" => []],
                              ["codigo" => "525515", "name" => "Pasajes aéreos", "children" => []],
                              ["codigo" => "525520", "name" => "Pasajes terrestres", "children" => []],
                              ["codigo" => "525525", "name" => "Pasajes férreos", "children" => []],
                              ["codigo" => "525595", "name" => "Otros", "children" => []],
                              ["codigo" => "525599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5260",
                          "name" => "Depreciaciones",
                          "children" => [
                              ["codigo" => "526005", "name" => "Construcciones y edificaciones", "children" => []],
                              ["codigo" => "526010", "name" => "Maquinaria y equipo", "children" => []],
                              ["codigo" => "526015", "name" => "Equipo de oficina", "children" => []],
                              ["codigo" => "526020", "name" => "Equipo de computación y comunicación", "children" => []],
                              ["codigo" => "526025", "name" => "Equipo médico-científico", "children" => []],
                              ["codigo" => "526030", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                              ["codigo" => "526035", "name" => "Flota y equipo de transporte", "children" => []],
                              ["codigo" => "526040", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                              ["codigo" => "526045", "name" => "Flota y equipo aéreo", "children" => []],
                              ["codigo" => "526050", "name" => "Flota y equipo férreo", "children" => []],
                              ["codigo" => "526055", "name" => "Acueductos, plantas y redes", "children" => []],
                              ["codigo" => "526060", "name" => "Armamento de vigilancia", "children" => []],
                              ["codigo" => "526065", "name" => "Envases y empaques", "children" => []],
                              ["codigo" => "526099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5265",
                          "name" => "Amortizaciones",
                          "children" => [
                              ["codigo" => "526505", "name" => "Vías de comunicación", "children" => []],
                              ["codigo" => "526510", "name" => "Intangibles", "children" => []],
                              ["codigo" => "526515", "name" => "Cargos diferidos", "children" => []],
                              ["codigo" => "526595", "name" => "Otras", "children" => []],
                              ["codigo" => "526599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5270",
                          "name" => "Financieros-reajuste del sistema",
                          "children" => [
                              ["codigo" => "527099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5275",
                          "name" => "Pérdidas método de participación",
                          "children" => [
                              ["codigo" => "527505", "name" => "De sociedades anónimas y/o asimiladas", "children" => []],
                              ["codigo" => "527510", "name" => "De sociedades limitadas y/o asimiladas", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5295",
                          "name" => "Diversos",
                          "children" => [
                              ["codigo" => "529505", "name" => "Comisiones", "children" => []],
                              ["codigo" => "529510", "name" => "Libros, suscripciones, periódicos y revistas", "children" => []],
                              ["codigo" => "529515", "name" => "Música ambiental", "children" => []],
                              ["codigo" => "529520", "name" => "Gastos de representación y relaciones públicas", "children" => []],
                              ["codigo" => "529525", "name" => "Elementos de aseo y cafetería", "children" => []],
                              ["codigo" => "529530", "name" => "Útiles, papelería y fotocopias", "children" => []],
                              ["codigo" => "529535", "name" => "Combustibles y lubricantes", "children" => []],
                              ["codigo" => "529540", "name" => "Envases y empaques", "children" => []],
                              ["codigo" => "529545", "name" => "Taxis y buses", "children" => []],
                              ["codigo" => "529550", "name" => "Estampillas", "children" => []],
                              ["codigo" => "529555", "name" => "Microfilmación", "children" => []],
                              ["codigo" => "529560", "name" => "Casino y restaurante", "children" => []],
                              ["codigo" => "529565", "name" => "Parqueaderos", "children" => []],
                              ["codigo" => "529570", "name" => "Indemnización por daños a terceros", "children" => []],
                              ["codigo" => "529575", "name" => "Pólvora y similares", "children" => []],
                              ["codigo" => "529595", "name" => "Otros", "children" => []],
                              ["codigo" => "529599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "5299",
                          "name" => "Provisiones",
                          "children" => [
                              ["codigo" => "529905", "name" => "Inversiones", "children" => []],
                              ["codigo" => "529910", "name" => "Deudores", "children" => []],
                              ["codigo" => "529915", "name" => "Inventarios", "children" => []],
                              ["codigo" => "529920", "name" => "Propiedades, planta y equipo", "children" => []],
                              ["codigo" => "529995", "name" => "Otros activos", "children" => []],
                              ["codigo" => "529999", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
                ],
                [
                    "codigo" => "53",
                    "name" => "No operacionales",
                    "children" => [
                        [
                            "codigo" => "5305",
                            "name" => "Financieros",
                            "children" => [
                                ["codigo" => "530505", "name" => "Gastos bancarios", "children" => []],
                                ["codigo" => "530510", "name" => "Reajuste monetario-UPAC (hoy UVR)", "children" => []],
                                ["codigo" => "530515", "name" => "Comisiones", "children" => []],
                                ["codigo" => "530520", "name" => "Intereses", "children" => []],
                                ["codigo" => "530525", "name" => "Diferencia en cambio", "children" => []],
                                ["codigo" => "530530", "name" => "Gastos en negociación certificados de cambio", "children" => []],
                                ["codigo" => "530535", "name" => "Descuentos comerciales condicionados", "children" => []],
                                ["codigo" => "530540", "name" => "Gastos manejo y emisión de bonos", "children" => []],
                                ["codigo" => "530545", "name" => "Prima amortizada", "children" => []],
                                ["codigo" => "530595", "name" => "Otros", "children" => []],
                                ["codigo" => "530599", "name" => "Ajustes por inflación", "children" => []],
                            ]
                        ],
                        [
                            "codigo" => "5310",
                            "name" => "Pérdida en venta y retiro de bienes",
                            "children" => [
                                ["codigo" => "531005", "name" => "Venta de inversiones", "children" => []],
                                ["codigo" => "531010", "name" => "Venta de cartera", "children" => []],
                                ["codigo" => "531015", "name" => "Venta de propiedades, planta y equipo", "children" => []],
                                ["codigo" => "531020", "name" => "Venta de intangibles", "children" => []],
                                ["codigo" => "531025", "name" => "Venta de otros activos", "children" => []],
                                ["codigo" => "531030", "name" => "Retiro de propiedades, planta y equipo", "children" => []],
                                ["codigo" => "531035", "name" => "Retiro de otros activos", "children" => []],
                                ["codigo" => "531040", "name" => "Pérdidas por siniestros", "children" => []],
                                ["codigo" => "531095", "name" => "Otros", "children" => []],
                                ["codigo" => "531099", "name" => "Ajustes por inflación", "children" => []],
                            ]
                        ],
                        [
                            "codigo" => "5313",
                            "name" => "Pérdidas método de participación",
                            "children" => [
                                ["codigo" => "531305", "name" => "De sociedades anónimas y/o asimiladas", "children" => []],
                                ["codigo" => "531310", "name" => "De sociedades limitadas y/o asimiladas", "children" => []],
                            ]
                        ],
                        [
                            "codigo" => "5315",
                            "name" => "Gastos extraordinarios",
                            "children" => [
                                ["codigo" => "531505", "name" => "Costas y procesos judiciales", "children" => []],
                                ["codigo" => "531510", "name" => "Actividades culturales y cívicas", "children" => []],
                                ["codigo" => "531515", "name" => "Costos y gastos de ejercicios anteriores", "children" => []],
                                ["codigo" => "531520", "name" => "Impuestos asumidos", "children" => []],
                                ["codigo" => "531595", "name" => "Otros", "children" => []],
                                ["codigo" => "531599", "name" => "Ajustes por inflación", "children" => []],
                            ]
                        ],
                        [
                            "codigo" => "5395",
                            "name" => "Gastos diversos",
                            "children" => [
                                ["codigo" => "539505", "name" => "Demandas laborales", "children" => []],
                                ["codigo" => "539510", "name" => "Demandas por incumplimiento de contratos", "children" => []],
                                ["codigo" => "539515", "name" => "Indemnizaciones", "children" => []],
                                ["codigo" => "539520", "name" => "Multas, sanciones y litigios", "children" => []],
                                ["codigo" => "539525", "name" => "Donaciones", "children" => []],
                                ["codigo" => "539530", "name" => "Constitución de garantías", "children" => []],
                                ["codigo" => "539535", "name" => "Amortización de bienes entregados en comodato", "children" => []],
                                ["codigo" => "539595", "name" => "Otros", "children" => []],
                                ["codigo" => "539599", "name" => "Ajustes por inflación", "children" => []],
                            ]
                        ]
                    ]
                ],
                [
                    "codigo" => "54",
                    "name" => "Impuesto de renta y complementarios",
                    "children" => [
                        [
                            "codigo" => "5405",
                            "name" => "Impuesto de renta y complementarios",
                            "children" => [
                                ["codigo" => "540505", "name" => "Impuesto de renta y complementarios", "children" => []],
                            ]
                        ]
                    ]
                ],
                [
                    "codigo" => "59",
                    "name" => "Ganancias y pérdidas",
                    "children" => [
                        [
                            "codigo" => "5905",
                            "name" => "Ganancias y pérdidas",
                            "children" => [
                                ["codigo" => "590505", "name" => "Ganancias", "children" => []],
                                ["codigo" => "590510", "name" => "Pérdidas", "children" => []],
                            ]
                        ]
                    ]
                ],
              ]
          ],
          [
              "codigo" => "6",
              "name" => "Costos de venta",
              "children" => [
                [
                  "codigo" => "61",
                  "name" => "Costo de ventas y de prestación de servicios",
                  "children" => [
                      [
                          "codigo" => "6105",
                          "name" => "Agricultura, ganadería, caza y silvicultura",
                          "children" => [
                              ["codigo" => "610505", "name" => "Cultivo de cereales", "children" => []],
                              ["codigo" => "610510", "name" => "Cultivos de hortalizas, legumbres y plantas ornamentales", "children" => []],
                              ["codigo" => "610515", "name" => "Cultivos de frutas, nueces y plantas aromáticas", "children" => []],
                              ["codigo" => "610520", "name" => "Cultivo de café", "children" => []],
                              ["codigo" => "610525", "name" => "Cultivo de flores", "children" => []],
                              ["codigo" => "610530", "name" => "Cultivo de caña de azúcar", "children" => []],
                              ["codigo" => "610535", "name" => "Cultivo de algodón y plantas para material textil", "children" => []],
                              ["codigo" => "610540", "name" => "Cultivo de banano", "children" => []],
                              ["codigo" => "610545", "name" => "Otros cultivos agrícolas", "children" => []],
                              ["codigo" => "610550", "name" => "Cría de ovejas, cabras, asnos, mulas y burdéganos", "children" => []],
                              ["codigo" => "610555", "name" => "Cría de ganado caballar y vacuno", "children" => []],
                              ["codigo" => "610560", "name" => "Producción avícola", "children" => []],
                              ["codigo" => "610565", "name" => "Cría de otros animales", "children" => []],
                              ["codigo" => "610570", "name" => "Servicios agrícolas y ganaderos", "children" => []],
                              ["codigo" => "610575", "name" => "Actividad de caza", "children" => []],
                              ["codigo" => "610580", "name" => "Actividad de silvicultura", "children" => []],
                              ["codigo" => "610595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "610599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6110",
                          "name" => "Pesca",
                          "children" => [
                              ["codigo" => "611005", "name" => "Actividad de pesca", "children" => []],
                              ["codigo" => "611010", "name" => "Explotación de criaderos de peces", "children" => []],
                              ["codigo" => "611095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "611099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6115",
                          "name" => "Explotación de minas y canteras",
                          "children" => [
                              ["codigo" => "611505", "name" => "Carbón", "children" => []],
                              ["codigo" => "611510", "name" => "Petróleo crudo", "children" => []],
                              ["codigo" => "611512", "name" => "Gas natural", "children" => []],
                              ["codigo" => "611514", "name" => "Servicios relacionados con extracción de petróleo y gas", "children" => []],
                              ["codigo" => "611515", "name" => "Minerales de hierro", "children" => []],
                              ["codigo" => "611520", "name" => "Minerales metalíferos no ferrosos", "children" => []],
                              ["codigo" => "611525", "name" => "Piedra, arena y arcilla", "children" => []],
                              ["codigo" => "611527", "name" => "Piedras preciosas", "children" => []],
                              ["codigo" => "611528", "name" => "Oro", "children" => []],
                              ["codigo" => "611530", "name" => "Otras minas y canteras", "children" => []],
                              ["codigo" => "611532", "name" => "Prestación de servicios sector minero", "children" => []],
                              ["codigo" => "611595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "611599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6120",
                          "name" => "Industrias manufactureras",
                          "children" => [
                              ["codigo" => "612001", "name" => "Producción y procesamiento de carnes y productos cárnicos", "children" => []],
                              ["codigo" => "612002", "name" => "Productos de pescado", "children" => []],
                              ["codigo" => "612003", "name" => "Productos de frutas, legumbres y hortalizas", "children" => []],
                              ["codigo" => "612004", "name" => "Elaboración de aceites y grasas", "children" => []],
                              ["codigo" => "612005", "name" => "Elaboración de productos lácteos", "children" => []],
                              ["codigo" => "612006", "name" => "Elaboración de productos de molinería", "children" => []],
                              ["codigo" => "612007", "name" => "Elaboración de almidones y derivados", "children" => []],
                              ["codigo" => "612008", "name" => "Elaboración de alimentos para animales", "children" => []],
                              ["codigo" => "612009", "name" => "Elaboración de productos para panadería", "children" => []],
                              ["codigo" => "612010", "name" => "Elaboración de azúcar y melazas", "children" => []],
                              ["codigo" => "612011", "name" => "Elaboración de cacao, chocolate y confitería", "children" => []],
                              ["codigo" => "612012", "name" => "Elaboración de pastas y productos farináceos", "children" => []],
                              ["codigo" => "612013", "name" => "Elaboración de productos de café", "children" => []],
                              ["codigo" => "612014", "name" => "Elaboración de otros productos alimenticios", "children" => []],
                              ["codigo" => "612015", "name" => "Elaboración de bebidas alcohólicas y alcohol etílico", "children" => []],
                              ["codigo" => "612016", "name" => "Elaboración de vinos", "children" => []],
                              ["codigo" => "612017", "name" => "Elaboración de bebidas malteadas y de malta", "children" => []],
                              ["codigo" => "612018", "name" => "Elaboración de bebidas no alcohólicas", "children" => []],
                              ["codigo" => "612019", "name" => "Elaboración de productos de tabaco", "children" => []],
                              ["codigo" => "612020", "name" => "Preparación e hilatura de fibras textiles y tejeduría", "children" => []],
                              ["codigo" => "612021", "name" => "Acabado de productos textiles", "children" => []],
                              ["codigo" => "612022", "name" => "Elaboración de artículos de materiales textiles", "children" => []],
                              ["codigo" => "612023", "name" => "Elaboración de tapices y alfombras", "children" => []],
                              ["codigo" => "612024", "name" => "Elaboración de cuerdas, cordeles, bramantes y redes", "children" => []],
                              ["codigo" => "612025", "name" => "Elaboración de otros productos textiles", "children" => []],
                              ["codigo" => "612026", "name" => "Elaboración de tejidos", "children" => []],
                              ["codigo" => "612027", "name" => "Elaboración de prendas de vestir", "children" => []],
                              ["codigo" => "612028", "name" => "Preparación, adobo y teñido de pieles", "children" => []],
                              ["codigo" => "612029", "name" => "Curtido, adobo o preparación de cuero", "children" => []],
                              ["codigo" => "612030", "name" => "Elaboración de maletas, bolsos y similares", "children" => []],
                              ["codigo" => "612031", "name" => "Elaboración de calzado", "children" => []],
                              ["codigo" => "612032", "name" => "Producción de madera, artículos de madera y corcho", "children" => []],
                              ["codigo" => "612033", "name" => "Elaboración de pasta y productos de madera, papel y cartón", "children" => []],
                              ["codigo" => "612034", "name" => "Ediciones y publicaciones", "children" => []],
                              ["codigo" => "612035", "name" => "Impresión", "children" => []],
                              ["codigo" => "612036", "name" => "Servicios relacionados con la edición y la impresión", "children" => []],
                              ["codigo" => "612037", "name" => "Reproducción de grabaciones", "children" => []],
                              ["codigo" => "612038", "name" => "Elaboración de productos de horno de coque", "children" => []],
                              ["codigo" => "612039", "name" => "Elaboración de productos de la refinación de petróleo", "children" => []],
                              ["codigo" => "612040", "name" => "Elaboración de sustancias químicas básicas", "children" => []],
                              ["codigo" => "612041", "name" => "Elaboración de abonos y compuestos de nitrógeno", "children" => []],
                              ["codigo" => "612042", "name" => "Elaboración de plástico y caucho sintético", "children" => []],
                              ["codigo" => "612043", "name" => "Elaboración de productos farmacéuticos", "children" => []],
                              ["codigo" => "612044", "name" => "Elaboración de productos de caucho y plástico", "children" => []],
                              ["codigo" => "612045", "name" => "Elaboración de otros productos minerales no metálicos", "children" => []],
                              ["codigo" => "612046", "name" => "Producción de metales básicos", "children" => []],
                              ["codigo" => "612047", "name" => "Elaboración de productos metálicos", "children" => []],
                              ["codigo" => "612048", "name" => "Elaboración de productos metálicos", "children" => []],
                              ["codigo" => "612049", "name" => "Fabricación de maquinaria y equipo", "children" => []],
                              ["codigo" => "612050", "name" => "Fabricación de equipos de informática y comunicación", "children" => []],
                              ["codigo" => "612051", "name" => "Fabricación de equipos eléctricos", "children" => []],
                              ["codigo" => "612052", "name" => "Fabricación de aparatos y equipo de radio, televisión y comunicación", "children" => []],
                              ["codigo" => "612053", "name" => "Fabricación de maquinaria y equipo n.c.p.", "children" => []],
                              ["codigo" => "612054", "name" => "Fabricación de vehículos automotores, remolques y semirremolques", "children" => []],
                              ["codigo" => "612055", "name" => "Fabricación de otros equipos de transporte", "children" => []],
                              ["codigo" => "612056", "name" => "Fabricación de muebles", "children" => []],
                              ["codigo" => "612057", "name" => "Otras industrias manufactureras", "children" => []],
                              ["codigo" => "612058", "name" => "Reciclaje", "children" => []],
                              ["codigo" => "612099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6125",
                          "name" => "Suministro de electricidad, gas y agua",
                          "children" => [
                              ["codigo" => "612505", "name" => "Suministro de electricidad", "children" => []],
                              ["codigo" => "612510", "name" => "Suministro de gas", "children" => []],
                              ["codigo" => "612515", "name" => "Suministro de agua", "children" => []],
                              ["codigo" => "612595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "612599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6130",
                          "name" => "Construcción",
                          "children" => [
                              ["codigo" => "613005", "name" => "Construcción de edificaciones", "children" => []],
                              ["codigo" => "613010", "name" => "Obras de ingeniería civil", "children" => []],
                              ["codigo" => "613015", "name" => "Actividades de construcción especializada", "children" => []],
                              ["codigo" => "613095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "613099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6135",
                          "name" => "Comercio al por mayor y al por menor",
                          "children" => [
                              ["codigo" => "613505", "name" => "Comercio al por mayor", "children" => []],
                              ["codigo" => "613510", "name" => "Comercio al por menor", "children" => []],
                              ["codigo" => "613595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "613599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6140",
                          "name" => "Hoteles y restaurantes",
                          "children" => [
                              ["codigo" => "614005", "name" => "Hoteles", "children" => []],
                              ["codigo" => "614010", "name" => "Restaurantes, bares y similares", "children" => []],
                              ["codigo" => "614095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "614099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6145",
                          "name" => "Transporte, almacenamiento y comunicaciones",
                          "children" => [
                              ["codigo" => "614505", "name" => "Transporte terrestre", "children" => []],
                              ["codigo" => "614510", "name" => "Transporte por agua", "children" => []],
                              ["codigo" => "614515", "name" => "Transporte aéreo", "children" => []],
                              ["codigo" => "614520", "name" => "Almacenamiento y actividades anexas al transporte", "children" => []],
                              ["codigo" => "614525", "name" => "Comunicaciones", "children" => []],
                              ["codigo" => "614595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "614599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6150",
                          "name" => "Actividad financiera",
                          "children" => [
                              ["codigo" => "615005", "name" => "De inversiones", "children" => []],
                              ["codigo" => "615010", "name" => "De servicio de bolsa", "children" => []],
                              ["codigo" => "615099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6155",
                          "name" => "Actividades inmobiliarias, empresariales y de alquiler",
                          "children" => [
                              ["codigo" => "615505", "name" => "Actividades inmobiliarias", "children" => []],
                              ["codigo" => "615510", "name" => "Actividades empresariales", "children" => []],
                              ["codigo" => "615515", "name" => "Actividades de alquiler", "children" => []],
                              ["codigo" => "615595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "615599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6160",
                          "name" => "Enseñanza",
                          "children" => [
                              ["codigo" => "616005", "name" => "Actividades relacionadas con la educación", "children" => []],
                              ["codigo" => "616095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "616099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6165",
                          "name" => "Servicios sociales y de salud",
                          "children" => [
                              ["codigo" => "616505", "name" => "Servicios sociales", "children" => []],
                              ["codigo" => "616510", "name" => "Servicios de salud", "children" => []],
                              ["codigo" => "616595", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "616599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "6170",
                          "name" => "Otras actividades de servicios comunitarios, sociales y personales",
                          "children" => [
                              ["codigo" => "617005", "name" => "Actividades de servicios personales", "children" => []],
                              ["codigo" => "617095", "name" => "Actividades conexas", "children" => []],
                              ["codigo" => "617099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
                ],
                [
                    "codigo" => "62",
                    "name" => "Compras",
                    "children" => [
                        [
                            "codigo" => "6205",
                            "name" => "De mercancías",
                            "children" => [
                                ["codigo" => "620599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "6210",
                            "name" => "De materias primas",
                            "children" => [
                                ["codigo" => "621095", "name" => "Compra De materias primas", "children" => []],
                                ["codigo" => "621099", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "6215",
                            "name" => "De materiales indirectos",
                            "children" => [
                                ["codigo" => "621599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "6220",
                            "name" => "Compra de energía",
                            "children" => [
                                ["codigo" => "622099", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "6225",
                            "name" => "Devoluciones en compras (CR)",
                            "children" => [
                                ["codigo" => "622599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                    ],
                ],
              ]
          ],
          [
              "codigo" => "7",
              "name" => "Costos de producción o de operación",
              "children" => [
                [
                    "codigo" => "71",
                    "name" => "Materia prima",
                    "children" => []
                ],
                [
                    "codigo" => "72",
                    "name" => "Mano de obra directa",
                    "children" => []
                ],
                [
                    "codigo" => "73",
                    "name" => "Costos indirectos",
                    "children" => []
                ],
                [
                    "codigo" => "74",
                    "name" => "Contratos de servicios",
                    "children" => []
                ],
              ]
          ],
          [
              "codigo" => "8",
              "name" => "Cuentas de orden deudoras",
              "children" => [
                [
                  "codigo" => "81",
                  "name" => "Derechos contingentes",
                  "children" => [
                      [
                          "codigo" => "8105",
                          "name" => "Bienes y valores entregados en custodia",
                          "children" => [
                              ["codigo" => "810505", "name" => "Valores mobiliarios", "children" => []],
                              ["codigo" => "810510", "name" => "Bienes muebles", "children" => []],
                              ["codigo" => "810599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "8110",
                          "name" => "Bienes y valores entregados en garantía",
                          "children" => [
                              ["codigo" => "811005", "name" => "Valores mobiliarios", "children" => []],
                              ["codigo" => "811010", "name" => "Bienes muebles", "children" => []],
                              ["codigo" => "811015", "name" => "Bienes inmuebles", "children" => []],
                              ["codigo" => "811020", "name" => "Contratos de ganado en participación", "children" => []],
                              ["codigo" => "811099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "8115",
                          "name" => "Bienes y valores en poder de terceros",
                          "children" => [
                              ["codigo" => "811505", "name" => "En arrendamiento", "children" => []],
                              ["codigo" => "811510", "name" => "En préstamo", "children" => []],
                              ["codigo" => "811515", "name" => "En depósito", "children" => []],
                              ["codigo" => "811520", "name" => "En consignación", "children" => []],
                              ["codigo" => "811599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "8120",
                          "name" => "Litigios y/o demandas",
                          "children" => [
                              ["codigo" => "812005", "name" => "Ejecutivos", "children" => []],
                              ["codigo" => "812010", "name" => "Incumplimiento de contratos", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "8125",
                          "name" => "Promesas de compraventa",
                          "children" => [],
                      ],
                      [
                          "codigo" => "8195",
                          "name" => "Diversas",
                          "children" => [
                              ["codigo" => "819505", "name" => "Valores adquiridos por recibir", "children" => []],
                              ["codigo" => "819595", "name" => "Otras", "children" => []],
                              ["codigo" => "819599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                  ],
                ],
                [
                    "codigo" => "82",
                    "name" => "Deudoras fiscales",
                    "children" => []
                ],
                [
                    "codigo" => "83",
                    "name" => "Deudoras de control",
                    "children" => [
                        [
                            "codigo" => "8305",
                            "name" => "Bienes recibidos en arrendamiento financiero",
                            "children" => [
                                ["codigo" => "830505", "name" => "Bienes muebles", "children" => []],
                                ["codigo" => "830510", "name" => "Bienes inmuebles", "children" => []],
                                ["codigo" => "830599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8310",
                            "name" => "Títulos de inversión no colocados",
                            "children" => [
                                ["codigo" => "831005", "name" => "Acciones", "children" => []],
                                ["codigo" => "831010", "name" => "Bonos", "children" => []],
                                ["codigo" => "831095", "name" => "Otros", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8315",
                            "name" => "Propiedades, planta y equipo totalmente depreciados, agotados y/o amortizados",
                            "children" => [
                                ["codigo" => "831506", "name" => "Materiales proyectos petroleros", "children" => []],
                                ["codigo" => "831516", "name" => "Construcciones y edificaciones", "children" => []],
                                ["codigo" => "831520", "name" => "Maquinaria y equipo", "children" => []],
                                ["codigo" => "831524", "name" => "Equipo de oficina", "children" => []],
                                ["codigo" => "831528", "name" => "Equipo de computación y comunicación", "children" => []],
                                ["codigo" => "831532", "name" => "Equipo médico-científico", "children" => []],
                                ["codigo" => "831536", "name" => "Equipo de hoteles y restaurantes", "children" => []],
                                ["codigo" => "831540", "name" => "Flota y equipo de transporte", "children" => []],
                                ["codigo" => "831544", "name" => "Flota y equipo fluvial y/o marítimo", "children" => []],
                                ["codigo" => "831548", "name" => "Flota y equipo aéreo", "children" => []],
                                ["codigo" => "831552", "name" => "Flota y equipo férreo", "children" => []],
                                ["codigo" => "831556", "name" => "Acueductos, plantas y redes", "children" => []],
                                ["codigo" => "831560", "name" => "Armamento de vigilancia", "children" => []],
                                ["codigo" => "831562", "name" => "Envases y empaques", "children" => []],
                                ["codigo" => "831564", "name" => "Plantaciones agrícolas y forestales", "children" => []],
                                ["codigo" => "831568", "name" => "Vías de comunicación", "children" => []],
                                ["codigo" => "831572", "name" => "Minas y canteras", "children" => []],
                                ["codigo" => "831576", "name" => "Pozos artesianos", "children" => []],
                                ["codigo" => "831580", "name" => "Yacimientos", "children" => []],
                                ["codigo" => "831584", "name" => "Semovientes", "children" => []],
                                ["codigo" => "831599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8320",
                            "name" => "Créditos a favor no utilizados",
                            "children" => [
                                ["codigo" => "832005", "name" => "País", "children" => []],
                                ["codigo" => "832010", "name" => "Exterior", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8325",
                            "name" => "Activos castigados",
                            "children" => [
                                ["codigo" => "832505", "name" => "Inversiones", "children" => []],
                                ["codigo" => "832510", "name" => "Deudores", "children" => []],
                                ["codigo" => "832595", "name" => "Otros activos", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8330",
                            "name" => "Títulos de inversión amortizados",
                            "children" => [
                                ["codigo" => "833005", "name" => "Bonos", "children" => []],
                                ["codigo" => "833095", "name" => "Otros", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8335",
                            "name" => "Capitalización por revalorización de patrimonio",
                            "children" => [],
                        ],
                        [
                            "codigo" => "8395",
                            "name" => "Otras cuentas deudoras de control",
                            "children" => [
                                ["codigo" => "839505", "name" => "Cheques posfechados", "children" => []],
                                ["codigo" => "839510", "name" => "Certificados de depósito a término", "children" => []],
                                ["codigo" => "839515", "name" => "Cheques devueltos", "children" => []],
                                ["codigo" => "839520", "name" => "Bienes y valores en fideicomiso", "children" => []],
                                ["codigo" => "839525", "name" => "Intereses sobre deudas vencidas", "children" => []],
                                ["codigo" => "839595", "name" => "Diversas", "children" => []],
                                ["codigo" => "839599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "8399",
                            "name" => "Ajustes por inflación activos",
                            "children" => [
                                ["codigo" => "839905", "name" => "Inversiones", "children" => []],
                                ["codigo" => "839910", "name" => "Inventarios", "children" => []],
                                ["codigo" => "839915", "name" => "Propiedades, planta y equipo", "children" => []],
                                ["codigo" => "839920", "name" => "Intangibles", "children" => []],
                                ["codigo" => "839925", "name" => "Cargos diferidos", "children" => []],
                                ["codigo" => "839995", "name" => "Otros activos", "children" => []],
                            ],
                        ],
                    ],
                ],
                [
                    "codigo" => "84",
                    "name" => "Derechos contingentes por contra (CR)",
                    "children" => [],
                ],
                [
                    "codigo" => "85",
                    "name" => "Deudoras fiscales por contra (CR)",
                    "children" => [],
                ],
                [
                    "codigo" => "86",
                    "name" => "Deudoras de control por contra (CR)",
                    "children" => [],
                ]
              ]
          ],
          [
              "codigo" => "9",
              "name" => "Cuentas de orden acreedoras",
              "children" => [
                [
                  "codigo" => "91",
                  "name" => "Responsabilidades contingentes",
                  "children" => [
                      [
                          "codigo" => "9105",
                          "name" => "Bienes y valores recibidos en custodia",
                          "children" => [
                              ["codigo" => "910505", "name" => "Valores mobiliarios", "children" => []],
                              ["codigo" => "910510", "name" => "Bienes muebles", "children" => []],
                              ["codigo" => "910599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "9110",
                          "name" => "Bienes y valores recibidos en garantía",
                          "children" => [
                              ["codigo" => "911005", "name" => "Valores mobiliarios", "children" => []],
                              ["codigo" => "911010", "name" => "Bienes muebles", "children" => []],
                              ["codigo" => "911015", "name" => "Bienes inmuebles", "children" => []],
                              ["codigo" => "911020", "name" => "Contratos de ganado en participación", "children" => []],
                              ["codigo" => "911099", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "9115",
                          "name" => "Bienes y valores recibidos de terceros",
                          "children" => [
                              ["codigo" => "911505", "name" => "En arrendamiento", "children" => []],
                              ["codigo" => "911510", "name" => "En préstamo", "children" => []],
                              ["codigo" => "911515", "name" => "En depósito", "children" => []],
                              ["codigo" => "911520", "name" => "En consignación", "children" => []],
                              ["codigo" => "911525", "name" => "En comodato", "children" => []],
                              ["codigo" => "911599", "name" => "Ajustes por inflación", "children" => []],
                          ],
                      ],
                      [
                          "codigo" => "9120",
                          "name" => "Litigios y/o demandas",
                          "children" => [
                              ["codigo" => "912005", "name" => "Laborales", "children" => []],
                              ["codigo" => "912010", "name" => "Civiles", "children" => []],
                              ["codigo" => "912015", "name" => "Administrativos o arbitrales", "children" => []],
                              ["codigo" => "912020", "name" => "Tributarios", "children" => []],
                          ],
                      ],
                      ["codigo" => "9125", "name" => "Promesas de compraventa", "children" => []],
                      ["codigo" => "9130", "name" => "Contratos de administración delegada", "children" => []],
                      ["codigo" => "9135", "name" => "Cuentas en participación", "children" => []],
                      [
                          "codigo" => "9195",
                          "name" => "Otras responsabilidades contingentes",
                          "children" => [],
                      ],
                  ],
                ],
                [
                    "codigo" => "92",
                    "name" => "Acreedoras fiscales",
                    "children" => [],
                ],
                [
                    "codigo" => "93",
                    "name" => "Acreedoras de control",
                    "children" => [
                        [
                            "codigo" => "9305",
                            "name" => "Contratos de arrendamiento financiero",
                            "children" => [
                                ["codigo" => "930505", "name" => "Bienes muebles", "children" => []],
                                ["codigo" => "930510", "name" => "Bienes inmuebles", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "9395",
                            "name" => "Otras cuentas de orden acreedoras de control",
                            "children" => [
                                ["codigo" => "939505", "name" => "Documentos por cobrar descontados", "children" => []],
                                ["codigo" => "939510", "name" => "Convenios de pago", "children" => []],
                                ["codigo" => "939515", "name" => "Contratos de construcciones e instalaciones por ejecutar", "children" => []],
                                ["codigo" => "939525", "name" => "Adjudicaciones pendientes de legalizar", "children" => []],
                                ["codigo" => "939530", "name" => "Reserva artículo 3º Ley 4ª de 1980", "children" => []],
                                ["codigo" => "939535", "name" => "Reserva costo reposición semovientes", "children" => []],
                                ["codigo" => "939595", "name" => "Diversas", "children" => []],
                                ["codigo" => "939599", "name" => "Ajustes por inflación", "children" => []],
                            ],
                        ],
                        [
                            "codigo" => "9399",
                            "name" => "Ajustes por inflación patrimonio",
                            "children" => [
                                ["codigo" => "939905", "name" => "Capital social", "children" => []],
                                ["codigo" => "939910", "name" => "Superávit de capital", "children" => []],
                                ["codigo" => "939915", "name" => "Reservas", "children" => []],
                                ["codigo" => "939925", "name" => "Dividendos o participaciones decretadas en acciones, cuotas o partes de interés social", "children" => []],
                                ["codigo" => "939930", "name" => "Resultados de ejercicios anteriores", "children" => []],
                            ],
                        ],
                    ],
                ],
                [
                    "codigo" => "94",
                    "name" => "Responsabilidades contingentes por contra (DB)",
                    "children" => [],
                ],
                [
                    "codigo" => "95",
                    "name" => "Acreedoras fiscales por contra (DB)",
                    "children" => [],
                ],
                [
                    "codigo" => "96",
                    "name" => "Acreedoras de control por contra (DB)",
                    "children" => [],
                ],
              ]
          ],
        ];
        $this->saveAccounts($datos);
    }

    private function saveAccounts($accounts, &$codeToIdMap = [], $parentCode = null, $level = 1) {
        foreach ($accounts as $account) {
            $codigo = $account['codigo'];
    
            $clasificacion = $this->getClasificacion($level);
    
            $idParent = $parentCode ? ($codeToIdMap[$parentCode] ?? null) : null;

            $data = [
              'codigo'         => $codigo,
              'nombre'         => $account['name'],
              'descripcion'    => "",
              'naturaleza'     => "credito",
              'clasificacion'  => $clasificacion,
              'estado'         => 0,
              'solo_lectura'   => 1,
              'eliminable'     => 0,
              'type'           => isset($account['children']) && !empty($account['children']) ? 'CMA' : "CMO",
              'comportamiento' => "SIN_USO",
              'id_parent'      => $idParent
            ];
    
            $this->db->table('catalogocuentas')->insert($data);
            $insertedId = $this->db->insertID();
    
            $codeToIdMap[$codigo] = $insertedId;
    
            if (isset($account['children']) && !empty($account['children'])) {
                $this->saveAccounts($account['children'], $codeToIdMap, $codigo, $level + 1);
            }
        }
    }

    public function getClasificacion($level) {
        if ($level === 1) return 'CL'; // Clase
        if ($level == 2) return 'GR'; // Grupo
        if ($level == 3) return 'CU'; // Cuenta
        return 'SC'; // Subcuenta
    }

}
