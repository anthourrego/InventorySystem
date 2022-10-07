<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PedidosCajasProductos extends Migration
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
            'id_caja' => [
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
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_caja', 'pedidoscajas', 'id');
        $this->forge->addForeignKey('id_producto', 'productos', 'id');
        $this->forge->createTable('pedidoscajasproductos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidoscajasproductos');
    }
}
