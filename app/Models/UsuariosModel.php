<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model {
  protected $table = 'usuarios';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'usuario', 
    'password',
    'perfil',
    'foto',
    'estado',
    'ultimo_login',
    'fecha'
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
        $this->perfil = $valid->perfil;
        $this->foto = $valid->foto;
        $this->fecha = $valid->fecha;
        return true;
      } else {
        return false; 
      }
    } else {
      return false; 
    }
  }
}