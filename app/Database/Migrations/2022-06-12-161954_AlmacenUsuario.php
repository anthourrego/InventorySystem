<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlmacenUsuario extends Migration {
	public function up() {
		$addFields = [
			'id_almacen' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		       => true,
				'unsigned'       => true
			],
			'CONSTRAINT usuarios_almacenes_foreign FOREIGN KEY(`id_almacen`) REFERENCES `almacenes`(`id`)'
		];
		$this->forge->addColumn('usuarios', $addFields);
	}

	public function down() {
		$this->forge->dropForeignKey('usuarios', 'usuarios_almacenes_foreign');
		$this->forge->dropColumn("usuarios", "id_almacen");
	}
}
