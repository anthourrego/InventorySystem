<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ventas extends Migration {
    public function up() {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'codigo' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unique'         => true
            ],
            'id_cliente' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'id_vendedor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'productos' => [
                'type'        => 'TEXT',
            ],

            'impuesto' => [
                'type'        => 'DECIMAL',
                'constraint'  => '20,2',
                'default'     => 0
            ],
            'neto' => [
                'type'        => 'DECIMAL',
                'constraint'  => '20,2',
                'default'     => 0
            ],
            'total' => [
                'type'        => 'DECIMAL',
                'constraint'  => '20,2',
                'default'     => 0
            ],
            'metodo_pago' => [
                'type'        => 'VARCHAR',
                'constraint'  => 50,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_cliente', 'clientes', 'id');
        $this->forge->addForeignKey('id_vendedor', 'usuarios', 'id');
        $this->forge->createTable('ventas');
    }

    public function down() {
        $this->forge->dropTable('ventas');
    }
}
