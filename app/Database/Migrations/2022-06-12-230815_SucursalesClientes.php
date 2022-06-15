<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SucursalesClientes extends Migration {
	public function up() {
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nombre' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'direccion' => [
				'type'     => 'TEXT',
			],
			'administrador' => [
				'type'        => 'VARCHAR',
				'constraint'     => 255,
				'null'        => true,
			],
			'cartera' => [
				'type'        => 'VARCHAR',
				'constraint'  => 255,
				'null'        => true,
			],
			'telefonocart' => [
				'type'        => 'VARCHAR',
				'constraint'  => 50,
				'null'        => true,
			],
			'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
			],
			'id_cliente' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('id_cliente', 'clientes', 'id');
		$this->forge->createTable('sucursales');
	}

	public function down() {
		$this->forge->dropTable('sucursales');
	}
}
