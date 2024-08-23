<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoIdUsuarioMovimientoInventario extends Migration
{
    public function up()
    {
        $addFields = [
			'id_usuario' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		     => true,
				'unsigned'       => true
			]
		];
		$this->forge->addColumn('movimientosinventario', $addFields);

		$this->forge->addForeignKey("id_usuario", "usuarios", "id", "", "", "usuarios_movimientos_inventario_foreign");
		$this->forge->processIndexes('movimientosinventario');
    }

    public function down()
    {
        $this->forge->dropColumn("movimientosinventario", "id_usuario");
    }
}
