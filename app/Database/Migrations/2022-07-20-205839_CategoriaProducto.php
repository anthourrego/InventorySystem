<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoriaProducto extends Migration {
	public function up() {
		$fields = [
			'id_categoria' => [
				'name'           => 'id_categoria',
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => true
			],
		];
		$this->forge->modifyColumn('productos', $fields);
	}

	public function down() {
			//
	}
}
