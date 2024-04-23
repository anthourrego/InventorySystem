<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Manifiesto extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    protected $attributes = [
        'id'         => null,
        'nombre'  => null, // In the $attributes, the key is the db column name
        'ruta_archivo' => ''
    ];

}
