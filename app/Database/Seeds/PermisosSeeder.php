<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermisosSeeder extends Seeder
{
	public function run()
	{
		$permisos = [1, 11, 12, 13, 14, 15, 2, 21, 22, 23, 24, 3, 31, 32, 33, 4, 41, 42, 43, 44, 441, 442, 443, 5, 51, 52, 53, 6, 61, 7, 71, 8, 81, 82, 83, 84, 85, 86, 87, 88];
		$datos = [];
		foreach ($permisos as $key => $value) {
			$datos[] = [
				"usuarioId" => 1,
				"perfilId" => 1,
				"permiso" => $value
			];
		}
		$this->db->table('permisosusuarioperfil')->insertBatch($datos);
	}
}
