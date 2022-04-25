<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model {
  protected $table = 'usuarios';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  
  protected $allowedFields = [
    'usuario', 
    'password',
    'nombre',
    'perfil',
    'foto',
    'estado',
    'ultimo_login',
    'fecha'
  ];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  protected $validationRules    = [
    'usuario'       => 'required|alpha_dash|min_length[3]|max_length[255]|is_unique[usuarios.usuario, id, {id}]',
    'nombre'        => 'required|string|min_length[3]|max_length[255]',
    'perfil'        => 'permit_empty|min_length[1]|numeric',
    'foto'          => 'permit_empty',
    'password'      => 'required|min_length[8]',
    'ultimo_login'  => 'permit_empty|valid_date[Y-m-d H:i:s]',
    
  ];
  protected $validationMessages = [
    "usuario" => [
      'is_unique' => 'El usuario <b>{value}</b>, ya se encuentra creado, intente con otro nombre.',
    ]
  ];
  
  public function get($id = null) {
    if ($id === null) {
      return $this->findAll();
    } 

    return $this->asObject()
              ->where(['id' => $id])
              ->first();
  }

  public function validarUsuario(){
    $valid = $this->asObject()
              ->where([
                'usuario' => $this->usuario
                ,"estado" => 1
              ])->first();
    if (!is_null($valid)) {
      if(password_verify($this->password, $valid->password)){
        $this->id = $valid->id;
        $this->nombre = $valid->nombre;
        $this->perfil = $valid->perfil;
        $this->foto = $valid->foto;
        $this->created_at = $valid->created_at;
        return true;
      } else {
        return false; 
      }
    } else {
      return false; 
    }
  }
}