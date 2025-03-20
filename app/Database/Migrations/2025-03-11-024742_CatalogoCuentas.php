<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CatalogoCuentas extends Migration
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
			'codigo' => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
				'unique'         => true
			],
			'nombre' => [
				'type'        => 'VARCHAR',
				'constraint'  => 255,
			],
            'clasificacion' => [ // CL -> Clase, GR -> Grupo, CU -> Cuenta, SC -> SubCuenta
				'type'        => 'CHAR',
				'constraint'  => 2,
				'null'        => false,
			],
            'estado' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'default'        => 1
			],
            'type' => [ // CMO -> Cuenta movimiento, CMA -> Cuenta Mayor
				'type'           => 'CHAR',
				'constraint'     => 3,
				'null'           => false,
			],
            'id_parent' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
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

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('id_parent', 'catalogocuentas', 'id');
		$this->forge->createTable('catalogocuentas', false, ATRIBUTOSDB);
    }

    public function down()
    {
        $this->forge->dropTable('catalogocuentas');
    }
}
