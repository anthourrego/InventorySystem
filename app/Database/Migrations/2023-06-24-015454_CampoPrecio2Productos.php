<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoPrecio2Productos extends Migration
{
    public function up()
    {
        //
        $addFields = [
			'precio_venta_dos' => [
                'type'        => 'DECIMAL',
                'constraint'  => '20,2',
                'default'     => 0
            ]
		];
		$this->forge->addColumn('productos', $addFields);
    }

    public function down()
    {
        //
        $this->forge->dropColumn("productos", "precio_venta_dos");
    }
}
