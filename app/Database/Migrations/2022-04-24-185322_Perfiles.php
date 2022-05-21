<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perfiles extends Migration {
	public function up() {
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
				'unique'         => true,
			],
			'descripcion' => [
				'type'     => 'TEXT',
				'null'     => true,
			],
			'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('perfiles');
	}

	public function down() {
		$this->forge->dropTable('perfiles');
	}
}
