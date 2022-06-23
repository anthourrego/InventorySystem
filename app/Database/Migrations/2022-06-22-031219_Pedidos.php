<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pedidos extends Migration {
	public function up() {
		$this->forge->addField([
			'id'   => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'pedido' => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
				'unique'         => true
			],
			'id_cliente' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'id_sucursal' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				"null"           => true
			],
			'id_vendedor' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'observacion' => [
				'type'        => 'TEXT',
				"null"        => true
			],
			'impuesto' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'neto' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'total' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'metodo_pago' => [
				'type'         => 'INT',
				'constraint'   => 11
			],
			'estado' => [
				'type'         => 'INT',
				'constraint'   => 11
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('id_cliente', 'clientes', 'id');
		$this->forge->addForeignKey('id_sucursal', 'sucursales', 'id');
		$this->forge->addForeignKey('id_vendedor', 'usuarios', 'id');
		$this->forge->createTable('pedidos');
	}

	public function down() {
		$this->forge->dropTable('pedidos');
	}
}
