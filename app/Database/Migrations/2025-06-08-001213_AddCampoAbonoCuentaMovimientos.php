<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCampoAbonoCuentaMovimientos extends Migration
{
    public function up()
    {
        $addFields = [
			'id_abono' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
		];
		$this->forge->addColumn('cuentamovimientos', $addFields);

        $this->forge->addForeignKey("id_abono", "abonosventas", "id", "", "", "cuentamovimientos_abonosventas_foreign");
		$this->forge->processIndexes('cuentamovimientos');
    }

    public function down()
    {
        $this->forge->dropColumn("cuentamovimientos", "id_abono");
    }
}
