<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PedidosProductos extends Migration {
	public function up() {
		$this->forge->addField([
			'id'   => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'id_pedido' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'pedido' => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'id_producto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'cantidad' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => 0
			],
			'valor' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'valor_original' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('id_pedido', 'pedidos', 'id');
		$this->forge->addForeignKey('id_producto', 'productos', 'id');
		$this->forge->createTable('pedidosproductos');
	}

	public function down() {
		$this->forge->dropTable('pedidosproductos');
	}
}
