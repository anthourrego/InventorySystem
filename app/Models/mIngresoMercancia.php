<?php

namespace App\Models;

use CodeIgniter\Model;

class mIngresoMercancia extends Model {

	protected $DBGroup          = 'default';
	protected $table            = 'ingresomercancia';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"codigo",
		"id_usuario",
		"observacion",
		"estado"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules = [
		'id'           => "permit_empty|is_natural_no_zero",
		'codigo'       => 'required|numeric|min_length[1]|max_length[11]|is_unique[ingresomercancia.codigo, id, {id}]',
		'id_usuario'   => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'observacion'  => 'permit_empty|string|min_length[1]|max_length[500]'
	];
	protected $validationMessages   = [
		"codigo" => [
			'is_unique' => 'El codigo <b>{value}</b>, ya se encuentra en uso, intente con otro codigo.',
		]
	];
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

	public function cargarIngreso($id) {
		return $this->db->table("ingresomercancia AS IM")
			->select("
				IM.id,
				IM.codigo,
				IM.id_usuario,
				IM.observacion,
				IM.estado,
				IM.created_at,
				U.usuario AS Usuario,
			")->join("usuarios AS U", "IM.id_usuario = U.id", "left")
			->where("IM.id", $id)
			->get()->getResultObject();
	}
}
