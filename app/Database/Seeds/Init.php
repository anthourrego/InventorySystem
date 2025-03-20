<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Init extends Seeder {
	public function run() {
		$this->call('PerfilSeeder');
		$this->call('AlmacenSeeder');
		$this->call('UsuarioSeeder');
		$this->call('PermisosSeeder');
		$this->call('PaisesSeeder');
		$this->call('DepartamentosSeeder');
		$this->call('CiudadesSeeder');
		$this->call('EstadosPedidosSeeder');
		$this->call('CatalogoCuentasSeeder');
	}
}
