<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class MovimientoInventario extends Migration
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
			'tipo' => [
				'type'        => 'CHAR',
				'constraint'  => 1,
				'null'        => true,
			],
			'id_producto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_venta' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_pedido' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_compra' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
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
		$this->forge->addForeignKey('id_producto', 'productos', 'id');
		$this->forge->addForeignKey('id_venta', 'ventas', 'id');
		$this->forge->addForeignKey('id_pedido', 'pedidos', 'id');
		$this->forge->addForeignKey('id_compra', 'compras', 'id');
		$this->forge->createTable('movimientosinventario', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('movimientosinventario');
	}
}
