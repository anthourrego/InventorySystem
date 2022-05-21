<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configuracion extends Migration {
	public function up() {
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
			'created_at datetime default current_timestamp',
			'updated_at datetime default current_timestamp on update current_timestamp'
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('configuracion');
	}

	public function down(){
		$this->forge->dropTable('configuracion');
	}
}
