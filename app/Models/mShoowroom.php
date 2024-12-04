<?php

namespace App\Models;

use CodeIgniter\Model;

class mShoowroom extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'showrooms';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"nombre",
		"descripcion",
		"fechaInicio",
		"leerQR",
		"muestraValor",
		"inventarioNegativo",
		"estado"
	];

	protected bool $allowEmptyInserts = false;
	protected bool $updateOnlyChanged = true;

	protected array $casts = [];
	protected array $castHandlers = [];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'           				=> "permit_empty|is_natural_no_zero",
		'nombre'    	 				=> 'required|string|min_length[1]|max_length[255]|is_unique[showrooms.nombre, id, {id}]',
		'descripcion'  				=> 'permit_empty|min_length[1]|max_length[500]',
		'leerQR'    					=> 'required|integer',
		'muestraValor' 				=> 'required|integer',
		'inventarioNegativo' 	=> 'required|integer',
		'estado' 							=> 'required|string|min_length[2]|max_length[2]',
		
	];
	protected $validationMessages   = [
		"nombre" => [
			'is_unique' => 'El nombre <b>{value}</b>, ya se encuentra en uso, intente con otro nombre para el showroom.',
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

	protected $statusDescription = [
		"BR" => "Borrador",
		"PE" => "Pendiente",
  	"AC" => "Activo",
  	"FI" => "Finalizado"
	];

	public function caseStatusDescription() {
		$case = "CASE {$this->table}.estado ";

		foreach ($this->statusDescription as $key => $status) {
			$case .= "WHEN '{$key}' THEN '{$status}' ";
		}

		$case .= "ELSE 'N/A' END";
		return $case;
	}

	/**
	 * Summary of getStatusDescription
	 * @return mixed
	 */
	public function getStatusDescription() {
		return $this->statusDescription;
	}

	/**
	 * Summary of getTable
	 * @return mixed
	 */
	public function getTable() {
		return $this->table;
	}
}
