<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ObservacionProductos extends Migration
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
			'id_pedido_producto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'motivo' => [
				'type'        => 'INT',
				'constraint'     => 11,
				'default'        => 1
			],
			'observacion' => [
				'type'        => 'TEXT',
				"null"        => true
			],
			'cantidad_anterior' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => 0
			],
			'cantidad_actual' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => 0
			],
			'valor_anterior' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'valor_actual' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
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
		$this->forge->addForeignKey('id_pedido_producto', 'pedidosproductos', 'id');
		$this->forge->createTable('observacionproductos', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('observacionproductos');
	}
}
