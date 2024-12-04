<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SucursalesClientes extends Migration
{
	public function up()
	{
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
			'id_depto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'id_ciudad' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
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
		$this->forge->addForeignKey('id_cliente', 'clientes', 'id');
		$this->forge->addForeignKey('id_depto', 'departamentos', 'id');
		$this->forge->addForeignKey('id_ciudad', 'ciudades', 'id');
		$this->forge->createTable('sucursales', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('sucursales');
	}
}
