<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class User extends Entity
{
	protected $attributes = [
		'id' => null,
		'usuario' => null, // In the $attributes, the key is the db column name
		'nombre' => null,
		'password' => null,
		'perfil' => null,
		'foto' => null,
		'estado' => 1,
		'ultimo_login' => null,
		'created_at' => null,
		'updated_at' => null,
		'id_almacen' => null,
		'imageProd' => 0
	];

	protected $datamap = [];
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'ultimo_login'
	];

	protected $casts = [
		'id' => 'integer',
		'estado' => 'boolean',
		'id_almacen' => 'integer',
		'imageProd' => 'integer'
	];

	// Setters personalizados
	public function setPassword(string $password)
	{
			$this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
			return $this;
	}

	// Getters personalizados
	public function getFullName()
	{
			return $this->attributes['nombre'];
	}

	// Método para verificar password
	public function verifyPassword(string $password)
	{
			return password_verify($password, $this->attributes['password']);
	}

	// Actualizar último login
	public function updateLastLogin()
	{
			$this->attributes['ultimo_login'] = new Time('now');
			return $this;
	}

	// Verificar si el usuario está activo
	public function isActive(): bool 
	{
			return (bool)$this->attributes['estado'] === true;
	}

	// Método para la foto de perfil
	public function getProfileImage(): string
	{
			return $this->attributes['foto'] ?? 'default.jpg';
	}
	
}
