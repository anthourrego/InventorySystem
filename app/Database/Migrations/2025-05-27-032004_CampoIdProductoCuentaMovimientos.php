<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoIdProductoCuentaMovimientos extends Migration
{
    public function up()
	{
		//
		$addFields = [
			'id_producto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
		];
		$this->forge->addColumn('cuentamovimientos', $addFields);

		$this->forge->addForeignKey("id_producto", "productos", "id", "", "", "cuentamovimientos_productos_foreign");
		$this->forge->processIndexes('cuentamovimientos');
	}

	public function down()
	{
		$this->forge->dropForeignKey('cuentamovimientos', 'cuentamovimientos_productos_foreign');
		$this->forge->dropColumn("cuentamovimientos", "id_producto");
	}
}
