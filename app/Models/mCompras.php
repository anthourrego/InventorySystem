<?php

namespace App\Models;

use CodeIgniter\Model;

class mCompras extends Model {

	protected $DBGroup          = 'default';
	protected $table            = 'compras';
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
		"impuesto",
		"neto",
		"total",
		"estado",
		"id_proveedor"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules = [
		'codigo' => 'required|string|min_length[1]|max_length[20]|is_unique[compras.codigo, id, {id}]',
		'id_usuario' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'observacion' => 'permit_empty|string|min_length[1]|max_length[500]',
		'impuesto' => 'required|decimal|min_length[1]|max_length[20]',
		'neto' => 'required|decimal|min_length[1]|max_length[20]',
		'total' => 'required|decimal|min_length[1]|max_length[20]'
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

	function cargarCompra($id) {
		$compra = $this->db->table("compras AS C")
			->select("
				C.id,
				C.codigo,
				C.id_usuario,
				C.observacion,
				C.impuesto,
				C.neto,
				C.total,
				C.estado,
				C.created_at,
				U.usuario AS Usuario,
				C.id_proveedor,
				P.nombre AS Proveedor,
				CONCAT(P.nit, ' | ', P.nombre, ' | ', IF(CP.nombre IS NULL, '', CP.nombre)) AS textSelectCompra
			")->join("usuarios AS U", "C.id_usuario = U.id", "left")
			->join('proveedores AS P', 'C.id_proveedor = P.id', 'left')
			->join("ciudades AS CP", "P.id_ciudad = CP.id", "left")
			->where("C.id", $id)
			->get()->getResultObject();

		return $compra;
	}
}
