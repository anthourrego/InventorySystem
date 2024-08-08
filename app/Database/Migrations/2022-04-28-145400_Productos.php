<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Productos extends Migration
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
			'id_categoria' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'referencia' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'unique'         => true,
			],
			'item' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'descripcion' => [
				'type'        => 'TEXT',
				'null'           => true,
			],

			'imagen' => [
				'type'        => 'TEXT',
				'null'           => true,
			],
			'stock' => [
				'type'        => 'INT',
				'constraint'  => 11,
				'default'     => 0
			],
			'precio_venta' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'costo' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'ubicacion' => [
				'type'        => 'VARCHAR',
				'constraint'  => 255,
				'null'        => true,
			],
			'id_manifiesto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		       => true,
				'unsigned'       => true
			],
			'ventas' => [
				'type'        => 'INT',
				'constraint'  => 11,
				'default'     => 0
			],
			'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
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
		$this->forge->addForeignKey('id_categoria', 'categorias', 'id');
		$this->forge->addForeignKey('id_manifiesto', 'manifiestos', 'id');
		$this->forge->createTable('productos', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('productos');
	}
}
