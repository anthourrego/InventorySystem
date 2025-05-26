<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Afiliados extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'terceroid' => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
				'null'           => false,
				'unique'         => true,
			],
			'nombre' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => false,
			],
			'telefono' => [
				'type'        => 'VARCHAR',
				'constraint'  => 50,
				'null'        => false,
			],
			'correo' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => true,
			],
			'fecha_afiliacion' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'fecha_inicio' => [
				'type'           => 'datetime',
				'null'           => true,
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

		$this->forge->addKey('terceroid', true);
		$this->forge->createTable('afiliados', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('afiliados');
	}
}
