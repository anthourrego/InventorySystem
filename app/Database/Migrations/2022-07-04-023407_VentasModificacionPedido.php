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
			],
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
			],
			'CONSTRAINT ventas_sucursales_foreign FOREIGN KEY(`id_sucursal`) REFERENCES `sucursales`(`id`)',
			'CONSTRAINT ventas_pedidos_foreign FOREIGN KEY(`id_pedido`) REFERENCES `pedidos`(`id`)'
		];
		$this->forge->addColumn('ventas', $addFields);
	}

	public function down() {
		$this->forge->dropForeignKey('ventas', 'ventas_sucursales_foreign');
		$this->forge->dropForeignKey('ventas', 'ventas_pedidos_foreign');
		$this->forge->dropColumn("ventas", "id_sucursal");
		$this->forge->dropColumn("ventas", "id_pedido");
	}
}
