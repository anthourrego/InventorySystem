<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        $datos = [
			[
                "codigo" => 5,
                "nombre" => 'ANTIOQUIA',
                "id_pais" => 1
            ],
            [
                "codigo" => 8,
                "nombre" => 'ATLÁNTICO',
                "id_pais" => 1
            ],
            [
                "codigo" => 11,
                "nombre" => 'BOGOTÁ, D.C.',
                "id_pais" => 1
            ],
            [
                "codigo" => 13,
                "nombre" => 'BOLÍVAR',
                "id_pais" => 1
            ],
            [
                "codigo" => 15,
                "nombre" => 'BOYACÁ',
                "id_pais" => 1
            ],
            [
                "codigo" => 17,
                "nombre" => 'CALDAS',
                "id_pais" => 1
            ],
            [
                "codigo" => 18,
                "nombre" => 'CAQUETÁ',
                "id_pais" => 1
            ],
            [
                "codigo" => 19,
                "nombre" => 'CAUCA',
                "id_pais" => 1
            ],
            [
                "codigo" => 20,
                "nombre" => 'CESAR',
                "id_pais" => 1
            ],
            [
                "codigo" => 23,
                "nombre" => 'CÓRDOBA',
                "id_pais" => 1
            ],
            [
                "codigo" => 25,
                "nombre" => 'CUNDINAMARCA',
                "id_pais" => 1
            ],
            [
                "codigo" => 27,
                "nombre" => 'CHOCÓ',
                "id_pais" => 1
            ],
            [
                "codigo" => 41,
                "nombre" => 'HUILA',
                "id_pais" => 1
            ],
            [
                "codigo" => 44,
                "nombre" => 'LA GUAJIRA',
                "id_pais" => 1
            ],
            [
                "codigo" => 47,
                "nombre" => 'MAGDALENA',
                "id_pais" => 1
            ],
            [
                "codigo" => 50,
                "nombre" => 'META',
                "id_pais" => 1
            ],
            [
                "codigo" => 52,
                "nombre" => 'NARIÑO',
                "id_pais" => 1
            ],
            [
                "codigo" => 54,
                "nombre" => 'NORTE DE SANTANDER',
                "id_pais" => 1
            ],
            [
                "codigo" => 63,
                "nombre" => 'QUINDIO',
                "id_pais" => 1
            ],
            [
                "codigo" => 66,
                "nombre" => 'RISARALDA',
                "id_pais" => 1
            ],
            [
                "codigo" => 68,
                "nombre" => 'SANTANDER',
                "id_pais" => 1
            ],
            [
                "codigo" => 70,
                "nombre" => 'SUCRE',
                "id_pais" => 1
            ],
            [
                "codigo" => 73,
                "nombre" => 'TOLIMA',
                "id_pais" => 1
            ],
            [
                "codigo" => 76,
                "nombre" => 'VALLE DEL CAUCA',
                "id_pais" => 1
            ],
            [
                "codigo" => 81,
                "nombre" => 'ARAUCA',
                "id_pais" => 1
            ],
            [
                "codigo" => 85,
                "nombre" => 'CASANARE',
                "id_pais" => 1
            ],
            [
                "codigo" => 86,
                "nombre" => 'PUTUMAYO',
                "id_pais" => 1
            ],
            [
                "codigo" => 88,
                "nombre" => 'ARCHIPIÉLAGO DE SAN ANDRÉS, PROVIDENCIA Y SANTA CATALINA',
                "id_pais" => 1
            ],
            [
                "codigo" => 91,
                "nombre" => 'AMAZONAS',
                "id_pais" => 1
            ],
            [
                "codigo" => 94,
                "nombre" => 'GUAINÍA',
                "id_pais" => 1
            ],
            [
                "codigo" => 95,
                "nombre" => 'GUAVIARE',
                "id_pais" => 1
            ],
            [
                "codigo" => 97,
                "nombre" => 'VAUPÉS',
                "id_pais" => 1
            ],
            [
                "codigo" => 99,
                "nombre" => 'VICHADA',
                "id_pais" => 1
            ]
		];
        $this->db->table('departamentos')->insertBatch($datos);
    }
}
