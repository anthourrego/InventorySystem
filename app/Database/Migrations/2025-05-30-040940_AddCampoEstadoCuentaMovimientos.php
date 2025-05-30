<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampoEstadoCuentaMovimientos extends Migration
{
    public function up()
    {
        $addFields = [
			'estado' => [
				'type'           => "ENUM('AN','AC','PE')",
				'default'        => 'AC',
				'null'        	 => false,
			],
		];
		$this->forge->addColumn('cuentamovimientos', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("cuentamovimientos", "estado");
    }
}
