<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CampoShopCategorias extends Migration
{
    public function up()
    {
        $addFields = [
			'apply_shop' => [
				'type'        => 'TINYINT',
                'default'     => 0
            ],
		];
		$this->forge->addColumn('categorias', $addFields);
    }

    public function down()
    {
        $this->forge->dropColumn('categorias', 'apply_shop');
    }
}
