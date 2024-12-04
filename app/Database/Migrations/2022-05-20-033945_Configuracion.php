<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Configuracion extends Migration
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
			'campo' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'unique'         => true,
			],
			'valor' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
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
		$this->forge->createTable('configuracion', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('configuracion');
	}
}
