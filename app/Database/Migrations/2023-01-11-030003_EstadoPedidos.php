<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EstadoPedidos extends Migration {
	public function up() {
		$fields = [
			'estado' => [
				'name'        => 'estado',
				'type'        => 'CHAR',
				'constraint'  => 2,
				'null'        => false,
			],
		];
		$this->forge->modifyColumn('pedidos', $fields);
	}

	public function down() {
		//
	}
}
