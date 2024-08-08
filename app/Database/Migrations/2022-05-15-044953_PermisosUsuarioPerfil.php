<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PermisosUsuarioPerfil extends Migration
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
			'perfilId' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => true,
			],
			'permiso' => [
				'type'           => 'INT',
				'constraint'     => 11
			],
			'created_at' => [
				'type'    => 'datetime',
				'default' => new RawSql('CURRENT_TIMESTAMP'),
			],
			'updated_at' => [
				'type'    => 'datetime',
				'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('usuarioId', 'usuarios', 'id');
		$this->forge->addForeignKey('perfilId', 'perfiles', 'id');
		$this->forge->createTable('permisosusuarioperfil', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('permisosusuarioperfil');
	}
}
