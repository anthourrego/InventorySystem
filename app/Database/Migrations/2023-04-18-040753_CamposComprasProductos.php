<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CamposComprasProductos extends Migration
{
    public function up()
    {
        //
        $addFields = [
			'ubicacion' => [
                'type'        => 'VARCHAR',
                'constraint'  => 255,
                'null'        => true,
            ],
            'id_categoria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
			'CONSTRAINT categorias_compras_productos_foreign FOREIGN KEY(`id_categoria`) REFERENCES `categorias`(`id`)'
		];
		$this->forge->addColumn('comprasproductos', $addFields);

        $addFields = [
			'id_manifiesto' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'		       => true,
                'unsigned'       => true
            ],
			'CONSTRAINT manifiestos_compras_productos_foreign FOREIGN KEY(`id_manifiesto`) REFERENCES `manifiestos`(`id`)'
		];
		$this->forge->addColumn('comprasproductos', $addFields);
    }

    public function down()
    {
        //
        $this->forge->dropForeignKey('comprasproductos', 'categorias_compras_productos_foreign');
		$this->forge->dropColumn("comprasproductos", "id_categoria");
        $this->forge->dropForeignKey('comprasproductos', 'manifiestos_compras_productos_foreign');
		$this->forge->dropColumn("comprasproductos", "id_manifiesto");
    }
}
