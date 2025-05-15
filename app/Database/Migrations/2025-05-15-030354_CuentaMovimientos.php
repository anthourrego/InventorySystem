<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CuentaMovimientos extends Migration
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
			'id_cuenta' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true
			],
			'total' => [
				'type'        => 'DECIMAL',
				'constraint'  => '20,2',
				'default'     => 0
			],
			'id_venta' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_pedido' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_pedido_observacion' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_compra' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
			],
			'id_ingresomercancia' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'        	 => true
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
		$this->forge->addForeignKey('id_cuenta', 'catalogocuentas', 'id');
		$this->forge->addForeignKey('id_venta', 'ventas', 'id');
		$this->forge->addForeignKey('id_pedido', 'pedidos', 'id');
		$this->forge->addForeignKey('id_pedido_observacion', 'observacionproductos', 'id');
		$this->forge->addForeignKey('id_compra', 'compras', 'id');
		$this->forge->addForeignKey('id_ingresomercancia', 'ingresomercancia', 'id');
		$this->forge->createTable('cuentamovimientos', false, ATRIBUTOSDB);
    }

    public function down()
    {
        $this->forge->dropTable('cuentamovimientos');
    }
}
