<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EliminarCampoPedidosProductos extends Migration
{
	public function up()
	{
		$this->forge->dropColumn("pedidosproductos", "pedido");
	}

	public function down()
	{
		//
	}
}
