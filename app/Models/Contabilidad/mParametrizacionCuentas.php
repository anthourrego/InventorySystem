<?php

namespace App\Models\Contabilidad;

use CodeIgniter\Model;

class mParametrizacionCuentas extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'parametrizacioncuentas';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"campo",
        "valor",
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'     => "permit_empty|is_natural_no_zero",
		"campo"  => "required|alpha_numeric_space|min_length[1]|max_length[100]|is_unique[parametrizacioncuentas.campo, id, {id}]",
		"valor"  => "required|min_length[1]|max_length[100]"
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
}
