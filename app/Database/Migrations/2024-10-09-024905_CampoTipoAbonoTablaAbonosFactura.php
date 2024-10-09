<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoTipoAbonoTablaAbonosFactura extends Migration
{
    public function up()
    {
        $addFields = [
			'tipo_abono' => [
				'type'        => 'int',
                'default'     => 1
            ],
		];
		$this->forge->addColumn('abonosventas', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("abonosventas", "tipo_abono");
    }
}
