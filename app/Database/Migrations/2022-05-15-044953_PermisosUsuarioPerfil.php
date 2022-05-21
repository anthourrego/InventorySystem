<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PermisosUsuarioPerfil extends Migration {
	public function up() {
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
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('usuarioId', 'usuarios', 'id');
		$this->forge->addForeignKey('perfilId', 'perfiles', 'id');
		$this->forge->createTable('permisosusuarioperfil');
	}

	public function down() {
		$this->forge->dropTable('permisosusuarioperfil');
	}
}
