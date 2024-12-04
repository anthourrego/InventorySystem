<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EstadoQRFactura extends Migration
{
	public function up()
	{
		$addFields = [
			'leidoQR' => [
				'type'          => 'TINYINT',
				'constraint'    => 1,
				'default'       => 0
			],
		];
		$this->forge->addColumn('ventas', $addFields);
	}

	public function down()
	{
		$this->forge->dropColumn("ventas", "leidoQR");
	}
}
