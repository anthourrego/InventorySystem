<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoVentasFechaVencimientoDescuento extends Migration
{
    public function up()
    {
        $addFields = [
			'fecha_vencimiento' => [
				'type'        => 'datetime',
                'null'        => true
            ],
            'descuento' => [
                'type'           => 'DECIMAL',
                'constraint'     => '20,2',
                'default'       => 0
            ]
		];
		$this->forge->addColumn('ventas', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("ventas", "fecha_vencimiento");
        $this->forge->dropColumn("ventas", "descuento");
    }
}
