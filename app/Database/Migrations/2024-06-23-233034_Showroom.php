<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Showroom extends Migration
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
				'null'           => false,
			],
			'descripcion' => [
				'type'     => 'TEXT',
				'null'     => true,
			],
			'fechaInicio' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'leerQR' => [
				'type'          => 'TINYINT',
				'constraint'    => 1,
				'default'       => 0
			],
			'muestraValor' => [
				'type'          => 'TINYINT',
				'constraint'    => 1,
				'default'       => 1
			],
			'inventarioNegativo' => [
				'type'          => 'TINYINT',
				'constraint'    => 1,
				'default'       => 0
			],
			'estado' => [
				'type'        => 'CHAR',
				'constraint'  => 2,
				'default'     => 'PE',
				'null'        => false,
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
		$this->forge->createTable('showrooms', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('showrooms');
	}
}
