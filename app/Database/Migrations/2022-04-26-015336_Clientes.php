<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Clientes extends Migration
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
			'nombre' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'documento' => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
				'null'           => true,
				'unique'         => true,
			],
			'direccion' => [
				'type'     => 'TEXT',
			],
			'telefono' => [
				'type'        => 'VARCHAR',
				'constraint'  => 50,
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
			'compras' => [
				'type'        => 'INT',
				'constraint'  => 11,
				'default'     => 0
			],
			'ultima_compra' => [
				'type'           => 'datetime',
				'null'           => true,
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
		$this->forge->createTable('clientes', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('clientes');
	}
}
