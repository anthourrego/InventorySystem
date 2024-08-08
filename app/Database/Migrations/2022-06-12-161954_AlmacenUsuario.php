<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlmacenUsuario extends Migration
{
	public function up()
	{
		$addFields = [
			'id_almacen' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		       => true,
				'unsigned'       => true
			],
		];
		$this->forge->addColumn('usuarios', $addFields);
		$this->forge->addForeignKey("id_almacen", "almacenes", "id", "", "", "usuarios_almacenes_foreign");
		$this->forge->processIndexes('usuarios');
	}

	public function down()
	{
		$this->forge->dropForeignKey('usuarios', 'usuarios_almacenes_foreign');
		$this->forge->dropColumn("usuarios", "id_almacen");
	}
}
