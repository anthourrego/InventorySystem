<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MovimientoInventarioEntity extends Entity
{
	protected $attributes = [
		'id'       							=> null,
		'id_producto'  					=> null, // In the $attributes, the key is the db column name
		'tipo'     	 						=> 'I',
		'cantidad'      				=> 0,
		'observacion'   				=> null,
		'id_venta' 							=> null,
		'id_pedido' 						=> null,
		'id_pedido_observacion' => null,
		'id_compra' 						=> null,
		'id_ingresomercancia' 	=> null
	];
	
	protected $datamap = [
		
	];
	protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
	protected $casts   = [];
}
