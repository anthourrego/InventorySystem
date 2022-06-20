<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductosCampos extends Migration {
    public function up() {
        $fields = [
            'item' => [
                'name'        => 'item',
                'type'        => 'VARCHAR',
				'constraint'  => 255,
                'null'        => true
            ],
        ];
        $this->forge->modifyColumn('productos', $fields);

        $addFields = [
			'cantPaca' => [
				'type'        => 'INT',
				'constraint'  => 11,
				'default'     => 1,
                'null'        => true
            ]
		];
		$this->forge->addColumn('productos', $addFields);
    }

    public function down() {
        $this->forge->dropColumn("productos", "cantPaca");
    }
}
