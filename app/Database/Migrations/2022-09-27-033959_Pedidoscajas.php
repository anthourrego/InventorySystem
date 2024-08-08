<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Pedidoscajas extends Migration
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
				'id_pedido' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => true
				],
				'numero_caja' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => true
				],
				'id_empacador' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => true
				],
				'inicio_empaque' => [
					'type'           => 'datetime',
					'null'           => true,
				],
					'fin_empaque' => [
					'type'           => 'datetime',
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
			$this->forge->addForeignKey('id_pedido', 'pedidos', 'id');
			$this->forge->addForeignKey('id_empacador', 'usuarios', 'id');
			$this->forge->createTable('pedidoscajas', false, ATRIBUTOSDB);
    }

    public function down()
    {
      $this->forge->dropTable('pedidoscajas');
    }
}
