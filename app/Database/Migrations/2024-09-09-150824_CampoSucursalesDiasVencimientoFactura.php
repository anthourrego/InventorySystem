<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoSucursalesDiasVencimientoFactura extends Migration
{
    public function up()
    {
        $addFields = [
			'dias_vencimiento_factura' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			]
		];
		$this->forge->addColumn('sucursales', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("sucursales", "dias_vencimiento_factura");
    }
}
