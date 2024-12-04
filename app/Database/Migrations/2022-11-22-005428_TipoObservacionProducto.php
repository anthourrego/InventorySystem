<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TipoObservacionProducto extends Migration
{
	public function up()
	{
		$addFields = [
			'tipo' => [
				'type'           => 'char',
				'null'           => true,
			],
		];
		$this->forge->addColumn('observacionproductos', $addFields);
	}

	public function down()
	{
		$this->forge->dropColumn("observacionproductos", "tipo");
	}
}
