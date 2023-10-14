<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CamposFechaConfirmacionCantidadConfirmadaObservacionProducto extends Migration
{
    public function up()
    {
        $addFields = [
			'fecha_confirmacion' => [
				'type'           => 'datetime',
				'null'           => true,
			],
            'cantidad_confirmada' => [
				'type'           => 'INT',
				'constraint'     => 11,
                'default'        => 0
			],
		];
		$this->forge->addColumn('observacionproductos', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("observacionproductos", "fecha_confirmacion");
        $this->forge->dropColumn("observacionproductos", "cantidad_confirmada");
    }
}
