<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FechasEmpaquePedido extends Migration
{
    public function up()
    {
        $addFields = [
			'inicio_empaque' => [
				'type'           => 'datetime',
				'null'           => true,
			],
            'fin_empaque' => [
				'type'           => 'datetime',
				'null'           => true,
			],
		];
		$this->forge->addColumn('pedidos', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn("pedidos", "inicio_empaque");
        $this->forge->dropColumn("pedidos", "fin_empaque");
    }
}
