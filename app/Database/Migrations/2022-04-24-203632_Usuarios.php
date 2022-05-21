<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration {
	public function up() {
		$this->forge->addField([
			'id'   => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'usuario' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'unique'         => true,
				'null'           => false,
			],
			'nombre' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'password' => [
				'type'           => 'TEXT',
			],
			'perfil' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'           => true,
				'unsigned'       => true
			],
			'foto' => [
				'type'           => 'TEXT',
				'null'           => true,
			],
			'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
			],
			'ultimo_login' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('perfil', 'perfiles', 'id');
		$this->forge->createTable('usuarios');
	}

	public function down() {
		$this->forge->dropTable('usuarios');
	}
}
