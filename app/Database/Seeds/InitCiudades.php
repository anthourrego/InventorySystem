<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitCiudades extends Seeder {
	public function run() {
		$this->call('PaisesSeeder');
		$this->call('DepartamentosSeeder');
		$this->call('CiudadesSeeder');
	}
}
