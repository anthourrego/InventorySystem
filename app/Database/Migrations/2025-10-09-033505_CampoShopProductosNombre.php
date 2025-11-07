<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoShopProductosNombre extends Migration
{
    public function up()
    {
        $addFields = [
			'no_apply_shop' => [
				'type'        => 'TINYINT',
                'default'     => 0
            ],
            'nombre_tienda' => [
				'type'        => 'VARCHAR',
				'constraint'  => 255,
				'null'        => true
            ],
		];
		$this->forge->addColumn('productos', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn('productos', 'no_apply_shop');
        $this->forge->dropColumn('productos', 'nombre_tienda');
    }
}
