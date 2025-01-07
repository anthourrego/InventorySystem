<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FechaAbono extends Migration
{
	public function up()
	{
		$addFields = [
			'fecha_abono' => [
				'type' => 'date',
				'null'        => true
			],
		];
		$this->forge->addColumn('abonosventas', $addFields);
	}

	public function down()
	{
		$this->forge->dropColumn("abonosventas", "fecha_abono");
	}
}
