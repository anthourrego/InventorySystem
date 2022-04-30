<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Productos extends Migration {
    public function up() {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_categoria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'referencia' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'unique'         => true,
            ],
            'item' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'unique'         => true,
            ],
            'descripcion' => [
                'type'        => 'TEXT',
                'null'           => true,
            ],

            'imagen' => [
                'type'        => 'TEXT',
                'null'           => true,
            ],
            'stock' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'default'     => 0
            ],
            'precio_venta' => [
                'type'        => 'DECIMAL',
                'constraint'  => '20,2',
                'default'     => 0
            ],
            'ubicacion' => [
                'type'        => 'VARCHAR',
                'constraint'  => 255,
                'null'        => true,
            ],
            'manifiesto' => [
                'type'        => 'VARCHAR',
                'constraint'  => 255,
                'null'        => true,
            ],
            'ventas' => [
                'type'        => 'INT',
                'constraint'  => 11,
                'default'     => 0
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
        $this->forge->addForeignKey('id_categoria', 'categorias', 'id');
        $this->forge->createTable('productos');
    }

    public function down() {
        $this->forge->dropTable('productos');
    }
}
