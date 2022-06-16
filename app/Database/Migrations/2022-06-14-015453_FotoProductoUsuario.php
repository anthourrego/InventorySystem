<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FotoProductoUsuario extends Migration {
	public function up(){
		$addFields = [
			'imageProd' => [
				'type'           => 'BOOLEAN',
				'null'		     => true
			]
		];
		$this->forge->addColumn('usuarios', $addFields);
	}

	public function down(){
		$this->forge->dropColumn("usuarios", "imageProd");
	}
}
