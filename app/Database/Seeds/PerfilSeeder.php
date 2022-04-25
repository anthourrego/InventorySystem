<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PerfilSeeder extends Seeder {
    public function run() {
        $datos = [
            [
                "nombre" => "Administrador",
                "descripcion" => "",
            ],
            [
                "nombre" => "Especial",
                "descripcion" => "",
            ],
            [
                "nombre" => "Vendedor",
                "descripcion" => "",
            ]
        ];
        $this->db->table('perfiles')->insertBatch($datos);
    }
}
