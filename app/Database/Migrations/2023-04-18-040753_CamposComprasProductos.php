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
			'id_manifiesto' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'		       => true,
				'unsigned'       => true
			]
		];
		$this->forge->addColumn('comprasproductos', $addFields);

		$this->forge->addForeignKey("id_categoria", "categorias", "id", "", "", "categorias_compras_productos_foreign");
		$this->forge->addForeignKey("id_manifiesto", "manifiestos", "id", "", "", "manifiestos_compras_productos_foreign");
		$this->forge->processIndexes('comprasproductos');
	}

	public function down()
	{
		$this->forge->dropForeignKey('comprasproductos', 'categorias_compras_productos_foreign');
		$this->forge->dropForeignKey('comprasproductos', 'manifiestos_compras_productos_foreign');
		$this->forge->dropColumn("comprasproductos", "id_categoria");
		$this->forge->dropColumn("comprasproductos", "id_manifiesto");
	}
}
