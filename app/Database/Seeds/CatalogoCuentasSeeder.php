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
				"codigo" => '1',
				"nombre" => "Activo",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
            ],
            [
				"codigo" => '2',
				"nombre" => "Pasivo",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '3',
				"nombre" => "Patrimonio",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '4',
				"nombre" => "Ingresos",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '5',
				"nombre" => "Gastos",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '6',
				"nombre" => "Costos de venta",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '7',
				"nombre" => "Costos de producción o de operación",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '8',
				"nombre" => "Cuentas de orden deudoras",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			],
            [
				"codigo" => '9',
				"nombre" => "Cuentas de orden acreedoras",
				"clasificacion" => 'CL',
                "estado" => 1,
                "type" => "CMA",
                "id_parent" => null
			]
		];
		$this->db->table('catalogocuentas')->insertBatch($datos);
    }
}
