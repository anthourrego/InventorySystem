<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaisesSeeder extends Seeder {
  public function run() {
		$datos = [
			[
				"nombre" => "Colombia",
				"estado" => 1,
			]
		];
		$this->db->table('paises')->insertBatch($datos);
  }
}
