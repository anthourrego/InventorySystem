<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsuarioTablaObservacionProducto extends Migration
{
	public function up()
	{
		//
		$addFields = [
			'id_usuario' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		     => true,
				'unsigned'       => true
			]
		];
		$this->forge->addColumn('observacionproductos', $addFields);

		$this->forge->addForeignKey("id_usuario", "usuarios", "id", "", "", "usuarios_observaciones_foreign");
		$this->forge->processIndexes('observacionproductos');
	}

	public function down()
	{
		$this->forge->dropForeignKey('observacionproductos', 'usuarios_observaciones_foreign');
		$this->forge->dropColumn("observacionproductos", "id_usuario");
	}
}
