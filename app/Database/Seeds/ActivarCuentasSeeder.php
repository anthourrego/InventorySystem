<?php

namespace App\Database\Seeds;

use App\Models\Contabilidad\mCatalogoCuentas;
use App\Models\Contabilidad\mParametrizacionCuentas;
use CodeIgniter\Database\Seeder;

class ActivarCuentasSeeder extends Seeder
{

    public function run()
    {
        // php spark db:seed ActivarCuentasSeeder
        $accounts = [
            [
                "codigo" => "138020",
                "comportamiento" => "CUENTAS_COBRAR"
            ],
            [
                "codigo" => "529915",
                "comportamiento" => "INVENTARIO"
            ],
            [
                "codigo" => "417595",
                "comportamiento" => "DEVOLUCIONES"
            ],
            [
                "codigo" => "111005",
                "comportamiento" => "TRANSFERENCIAS"
            ],
            [
                "codigo" => "110510",
                "comportamiento" => "CAJA_MENOR"
            ],
            [
                "codigo" => "621095",
                "comportamiento" => "COMPRAS"
            ],
            [
                "codigo" => "590510",
                "comportamiento" => "INVENTARIO_PERDIDO"
            ],
            [
                "codigo" => "590505",
                "comportamiento" => "GANANCIAS"
            ],
            [
                "codigo" => "421040",
                "comportamiento" => "DESCUENTOS"
            ]
        ];

        foreach ($accounts as $item) {
            $this->activarPadres($item['codigo'], $item['comportamiento']);
        }

        $configuracion = [
            ["campo" => "cuentaIngresoCaja", "key" => "CAJA_MENOR"],
            ["campo" => "cuentaIngresoTransferencia", "key" => "TRANSFERENCIAS"],
            ["campo" => "cuentaIngresoCuentaPorCobrar", "key" => "CUENTAS_COBRAR"],
            ["campo" => "cuentaActivosInventario", "key" => "INVENTARIO"],
            ["campo" => "cuentaGastosCompras", "key" => "COMPRAS"],
            ["campo" => "cuentaGastosInventarioPerdido", "key" => "INVENTARIO_PERDIDO"],
            ["campo" => "cuentaPatrimonioGanancias", "key" => "GANANCIAS"],
            ["campo" => "cuentaGastosDescuentos", "key" => "DESCUENTOS"],
        ];
        $mParametrizacionCuentas = new mParametrizacionCuentas();
        $mCatalogoCuentas = new mCatalogoCuentas();

        foreach ($configuracion as $config) {

            $cuenta = $mCatalogoCuentas->asObject()->where('comportamiento', $config['key'])->get()->getRow();
            if ($cuenta) {
                $dataSave = [
                    "campo" => $config["campo"],
                    "valor" => $cuenta->id
                ];
                $mParametrizacionCuentas->save($dataSave);
            }
        }
    }

    private function activarPadres($codigo, $comportamiento) {

        $data = array(
            "estado" => 1,
        );

        if ($comportamiento != '') {
            $data['comportamiento'] = $comportamiento;
        }

        $this->db->table('catalogocuentas')->where('codigo', $codigo)->update($data); 

        $mCatalogoCuentas = new mCatalogoCuentas();
        $current = $mCatalogoCuentas->asObject()->where('codigo', $codigo)->get()->getRow();
        if (isset($current->id_parent) && !is_null($current->id_parent)) {
            $parent = $mCatalogoCuentas->asObject()->where('id', $current->id_parent)->get()->getRow();
            if (isset($parent->id)) {
                $this->activarPadres($parent->codigo, '');
            }
        }
    }

}
