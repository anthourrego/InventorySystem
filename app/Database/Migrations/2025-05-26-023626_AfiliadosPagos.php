<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AfiliadosPagos extends Migration
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
			'terceroid' => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
				'null'           => false,
				'unique'         => true,
			],
			'planid' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'recibocaja' => [
				'type'        => 'VARCHAR',
				'constraint'  => 50,
			],
			'fecha_afiliacion' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'fecha_inicio' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'fecha_pago' => [
				'type'           => 'datetime',
				'null'           => true,
			],
			'dias' => [
				'type'           => 'INT',
				'null'           => true,
			],
			'valor_pagado' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'efectivo' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'tarjeta' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'transferencia' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'cuentasxcobrar' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'nro_pagos' => [
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
		$this->forge->createTable('afiliadospagos', false, ATRIBUTOSDB);
	}

	public function down()
	{
		$this->forge->dropTable('afiliadospagos');
	}
}
