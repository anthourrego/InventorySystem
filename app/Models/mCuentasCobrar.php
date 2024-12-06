<?php

namespace App\Models;

use CodeIgniter\Model;

class mCuentasCobrar extends Model {

	protected $DBGroup          = 'default';
	protected $table            = 'abonosventas';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"codigo",
		"valor",
		"estado",
		"observacion",
		"id_venta",
		"id_usuario",
		"tipo_abono",
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
		'codigo'       => 'required|string|min_length[1]|max_length[20]|is_unique[abonosventas.codigo, id, {id}]',
		'valor'        => 'required|decimal|min_length[1]|max_length[20]',
		'estado'       => 'required|string|min_length[1]|max_length[2]',
		'observacion'  => 'permit_empty|string|min_length[1]|max_length[500]',
		'id_venta'     => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[ventas.id]',
		'id_usuario'   => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'tipo_abono'   => 'required|numeric|min_length[1]|max_length[11]',
	];
	protected $validationMessages   = [
		"codigo" => [
			'is_unique' => 'El codigo <b>{value}</b>, ya se encuentra en uso, intente con otro código.',
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

	public function cargarAbono($id) {
		return $this->db->table("abonosventas AS AV")
			->select("
				AV.id,
				AV.codigo,
				AV.id_usuario,
				AV.observacion,
				AV.valor,
				AV.estado,
				AV.created_at,
				U.usuario AS Usuario,
				V.codigo,
				AV.tipo_abono
			")->join("usuarios AS U", "AV.id_usuario = U.id", "left")
			->join('ventas AS V', 'AV.id_venta = V.id', 'left')
			->where("AV.id", $id)
			->get()->getResultObject();
	}

	public function getOutstandingBalance() {

		$balancePaid = $this->select("SUM(valor) AS total")
			->where("estado", "CO")
			->get() ->getRow("total");

		$balancePaid = is_null($balancePaid) ? 0 : (float) $balancePaid;

		$totalInvoiced = $this->db->table("ventas")
			->select("SUM(total) AS total")
			->where("fecha_vencimiento IS NOT NULL")
			->get()->getRow("total");

		$totalInvoiced = is_null($totalInvoiced) ? 0 :(float) $totalInvoiced;

		return ($totalInvoiced - $balancePaid);
	}
}
