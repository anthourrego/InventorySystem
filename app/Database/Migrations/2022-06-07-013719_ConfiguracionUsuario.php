<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConfiguracionUsuario extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'   => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
            'usuarioId' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => true,
			],
			'config' => [
				'type'           => 'TEXT',
				'null'           => true,
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('usuarioId', 'usuarios', 'id');
		$this->forge->createTable('configuracionusuario');
    }

    public function down()
    {
        $this->forge->dropTable('configuracionusuario');
    }
}
