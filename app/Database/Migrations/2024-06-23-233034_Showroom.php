<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

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
			'nombre' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => false,
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
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('showroom');
		
	}

	public function down()
	{
		$this->forge->dropTable('showroom');
	}
}
