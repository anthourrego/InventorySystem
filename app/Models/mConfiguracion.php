<?php

namespace App\Models;

use CodeIgniter\Model;

class mConfiguracion extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'configuracion';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"campo",
		"valor"
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'     => "permit_empty|is_natural_no_zero",
		"campo"  => "required|alpha_numeric_space|min_length[1]|max_length[100]|is_unique[configuracion.campo, id, {id}]",
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
