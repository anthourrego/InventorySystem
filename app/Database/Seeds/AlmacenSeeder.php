<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlmacenSeeder extends Seeder {
	public function run() {
		$datos = [
			[
				"nombre" => "General",
				"estado" => 1,
			]
		];
		$this->db->table('almacenes')->insertBatch($datos);
	}
}
