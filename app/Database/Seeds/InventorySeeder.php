<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventorySeeder extends Seeder
{
	public function run()
	{
		$products = $this->db->table('productos')->where("stock >", 0)->get();
		$inventorySave = [];

		foreach ($products->getResult() as $product) {	
			$inventorySave[] = [
				"id_producto" => $product->id,
				"cantidad" => $product->stock,
				"tipo" => "I",
				"observacion" => "Inventario Inicial"
			];
		}

		$this->db->table('movimientosinventario')->insertBatch($inventorySave);
	}
}
