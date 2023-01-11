<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstadosPedidosSeeder extends Seeder {
	public function run() {
		$this->db->table('pedidos')->set("estado", "PE")->where("estado", 0)->update();
		$this->db->table('pedidos')->set("estado", "EP")->where("estado", 1)->update();
		$this->db->table('pedidos')->set("estado", "EM")->where("estado", 2)->update();
		$this->db->table('pedidos')->set("estado", "FA")->where("estado", 3)->update();
	}
}
