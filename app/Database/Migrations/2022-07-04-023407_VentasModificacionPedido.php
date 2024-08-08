<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VentasModificacionPedido extends Migration {
	public function up() {
		$fields = [
			'codigo' => [
				'name'        => 'codigo',
				'type'        => 'VARCHAR',
				'constraint'  => 20,
				'null'        => false,
			]
		];
		$this->forge->modifyColumn('ventas', $fields);

		$addFields = [
			'id_sucursal' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
			],
			'id_pedido' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'           => true,
			]
		];
		$this->forge->addColumn('ventas', $addFields);

		$this->forge->addForeignKey("id_sucursal", "sucursales", "id", "", "", "ventas_sucursales_foreign");
		$this->forge->addForeignKey("id_pedido", "pedidos", "id", "", "", "ventas_pedidos_foreign");
		$this->forge->processIndexes('ventas');
	}

	public function down() {
		$this->forge->dropForeignKey('ventas', 'ventas_sucursales_foreign');
		$this->forge->dropForeignKey('ventas', 'ventas_pedidos_foreign');
		$this->forge->dropColumn("ventas", "id_sucursal");
		$this->forge->dropColumn("ventas", "id_pedido");
	}
}
