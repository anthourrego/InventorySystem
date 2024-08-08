<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

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
		$this->forge->addForeignKey('id_depto', 'departamentos', 'codigo');
		$this->forge->createTable('ciudades', false, ATRIBUTOSDB);
	}

	public function down(){
		$this->forge->dropTable('ciudades');
	}
}
