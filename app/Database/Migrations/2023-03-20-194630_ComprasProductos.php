<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ComprasProductos extends Migration
{
    public function up() {
		$this->forge->addField([
			'id'   => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'id_compra' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'id_producto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'cantidad' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => 0
			],
			'valor' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'valor_original' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'cantPaca' => [
				'type'        => 'INT',
				'constraint'  => 11,
				'default'     => 1,
				'null'        => true
			],
			'creado_compra' => [
				'type'          => 'TINYINT',
				'constraint'    => 1,
        'default'       => 0
			],
			'costo' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
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
		$this->forge->addForeignKey('id_compra', 'compras', 'id');
		$this->forge->addForeignKey('id_producto', 'productos', 'id');
		$this->forge->createTable('comprasproductos', false, ATRIBUTOSDB);
	}

	public function down() {
		$this->forge->dropTable('comprasproductos');
	}
}
