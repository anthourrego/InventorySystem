<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clientes extends Migration {
    public function up() {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'documento' => [
                'type'           => 'VARCHAR',
                'constraint'     => '30',
                'null'           => true,
                'unique'         => true,
            ],
            'direccion' => [
                'type'     => 'TEXT',
            ],
            'telefono' => [
                'type'        => 'VARCHAR',
                'constraint'  => '50',
            ],
            'administrador' => [
                'type'        => 'VARCHAR',
                'constraint'     => '255',
                'null'        => true,
            ],
            'cartera' => [
                'type'        => 'VARCHAR',
                'constraint'  => '255',
                'null'        => true,
            ],
            'telefonocart' => [
                'type'        => 'VARCHAR',
                'constraint'  => '50',
                'null'        => true,
            ],
            'compras' => [
                'type'        => 'INT',
                'constraint'  => '11',
                'default'     => 0
            ],
            'ultima_compra' => [
                'type'           => 'datetime',
                'null'           => true,
            ],
            'estado' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 1
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('clientes');
    }

    public function down() {
        $this->forge->dropTable('clientes');
    }
}
