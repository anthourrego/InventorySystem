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
			],
			'CONSTRAINT usuarios_observaciones_foreign FOREIGN KEY(`id_usuario`) REFERENCES `usuarios`(`id`)'
		];
		$this->forge->addColumn('observacionproductos', $addFields);
    }

    public function down()
    {
        //
        $this->forge->dropForeignKey('observacionproductos', 'usuarios_observaciones_foreign');
		$this->forge->dropColumn("observacionproductos", "id_usuario");
    }
}
