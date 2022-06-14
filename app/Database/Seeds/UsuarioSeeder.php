<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {
	public function run() {
		$datos = array(
			"usuario" => "admin",
			"nombre" => "Administrador",
			"perfil" => 1,
			"id_almacen" => 1,
			"password" => password_hash("123456", PASSWORD_DEFAULT, array("cost" => 15))
		);
		$this->db->table('usuarios')->insert($datos);
	}
}
