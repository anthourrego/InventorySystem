<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class IngresoMercancia extends Migration
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
			'codigo' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unique'         => true
			],
			'id_usuario' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'observacion' => [
				'type'        => 'TEXT',
				"null"        => true
			],
			'estado' => [
				'type'        => 'CHAR',
				'constraint'  => 2,
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
		$this->forge->addForeignKey('id_usuario', 'usuarios', 'id');
		$this->forge->createTable('ingresomercancia', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('ingresomercancia');
	}
}
