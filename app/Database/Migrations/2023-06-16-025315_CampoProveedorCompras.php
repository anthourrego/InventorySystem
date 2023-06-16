<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoProveedorCompras extends Migration
{
    public function up()
    {
        //
        $addFields = [
			'id_proveedor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'CONSTRAINT compra_proveedor_foreign FOREIGN KEY(`id_proveedor`) REFERENCES `proveedores`(`id`)'
		];
		$this->forge->addColumn('compras', $addFields);
    }

    public function down()
    {
        //
        $this->forge->dropForeignKey('compras', 'compra_proveedor_foreign');
		$this->forge->dropColumn("compras", "id_proveedor");
    }
}
