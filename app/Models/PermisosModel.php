<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosModel extends Model {
    protected $DBGroup          = 'default';
    protected $table            = 'permisosusuarioperfil';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
			"usuarioId",    
			"perfilId",
			"permiso",
			"created_at",
			"updated_at"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
			'usuarioId' => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
			'perfilId' => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[perfiles.id]',
			'permiso' => 'required|numeric|min_length[1]|max_length[11]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function lista() {
			$permisos = [
				[
					"id" => 1,
					"text" => "Usuarios",
					"children" => [
						[
							"id" => 11,
							"text" => "Crear"
						],
						[
							"id" => 12,
							"text" => "Editar"
						],
						[
							"id" => 13,
							"text" => "Cambiar contraseña"
						],
						[
							"id" => 14,
							"text" => "Activar/Inactivar"
						],
						[
							"id" => 15,
							"text" => "Permisos"
						]
					]
				],
				[
					"id" => 2,
					"text" => "Perfiles",
					"children" => [
						[
							"id" => 21,
							"text" => "Crear"
						],
						[
							"id" => 22,
							"text" => "Editar"
						],
						[
							"id" => 23,
							"text" => "Permisos"
						],
						[
							"id" => 24,
							"text" => "Activar/Inactivar"
						]
					]
				],
				[
					"id" => 3,
					"text" => "Categorias",
					"children" => [
						[
							"id" => 31,
							"text" => "Crear"
						],
						[
							"id" => 32,
							"text" => "Editar"
						],
						[
							"id" => 33,
							"text" => "Activar/Inactivar"
						]
					]
				],
				[
					"id" => 4,
					"text" => "Clientes",
					"children" => [
						[
							"id" => 41,
							"text" => "Crear"
						],
						[
							"id" => 42,
							"text" => "Editar"
						],
						[
							"id" => 43,
							"text" => "Activar/Inactivar"
						]
					]
				],
				[
					"id" => 5,
					"text" => "Productos",
					"children" => [
						[
							"id" => 51,
							"text" => "Crear"
						],
						[
							"id" => 52,
							"text" => "Editar"
						],
						[
							"id" => 53,
							"text" => "Activar/Inactivar"
						]
					]
				],
				[
					"id" => 6,
					"text" => "Ventas"
				]

			];

			return $permisos;
    }
}
