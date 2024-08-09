<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class IngresoMercanciaProductos extends Migration
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
			'id_ingresomercancia' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
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
		$this->forge->addForeignKey('id_ingresomercancia', 'ingresomercancia', 'id');
		$this->forge->addForeignKey('id_producto', 'productos', 'id');
		$this->forge->createTable('ingresomercanciaproductos', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('ingresomercanciaproductos');
	}
}
