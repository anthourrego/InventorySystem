<?php

namespace App\Models;

use CodeIgniter\Model;

class mManifiesto extends Model {
  protected $table = 'manifiestos';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  
  protected $allowedFields = [
    'nombre',
    'ruta_archivo',
    'estado'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  protected $validationRules    = [
    'nombre' => 'required|string|min_length[3]|max_length[255]|is_unique[manifiestos.nombre, id, {id}]',
    'foto'   => 'permit_empty'
  ];
  protected $validationMessages   = [
		"nombre" => [
			'is_unique' => 'El manifiesto <b>{value}</b>, ya se encuentra creado, intente con otro nombre.',
		]
	];
  
  public function get($id = null) {
    if ($id === null) {
      return $this->findAll();
    }

    return $this->asObject()->where(['id' => $id])->first();
  }

}