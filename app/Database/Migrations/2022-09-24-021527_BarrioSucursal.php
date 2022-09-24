<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarrioSucursal extends Migration
{
    public function up()
    {
        $addFields = [
			'barrio' => [
                'type'        => 'VARCHAR',
				'constraint'  => 255
			]
		];
		$this->forge->addColumn('sucursales', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("sucursales", "barrio");
    }
}
