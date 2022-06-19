<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ciudades extends Migration {
	public function up() {
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
			'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
			],
			'id_depto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('id_depto', 'departamentos', 'codigo');
		$this->forge->createTable('ciudades');
	}

	public function down(){
		$this->forge->dropTable('ciudades');
	}
}
