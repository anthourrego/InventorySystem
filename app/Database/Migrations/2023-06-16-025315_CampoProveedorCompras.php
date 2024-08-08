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
		];
		$this->forge->addColumn('compras', $addFields);

		$this->forge->addForeignKey("id_proveedor", "proveedores", "id", "", "", "compra_proveedor_foreign");
		$this->forge->processIndexes('compras');
	}

	public function down()
	{
		$this->forge->dropForeignKey('compras', 'compra_proveedor_foreign');
		$this->forge->dropColumn("compras", "id_proveedor");
	}
}
