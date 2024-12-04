<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Usuarios extends Migration
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
		$this->forge->addForeignKey('perfil', 'perfiles', 'id');
		$this->forge->createTable('usuarios', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('usuarios');
	}
}
