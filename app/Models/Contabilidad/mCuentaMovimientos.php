<?php

namespace App\Models\Contabilidad;

use App\Models\Contabilidad\mParametrizacionCuentas;
use App\Models\mVentas;
use App\Models\mPedidos;
use CodeIgniter\Log\Logger;
use CodeIgniter\Model;
use Exception;

class mCuentaMovimientos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'cuentamovimientos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_cuenta",
		"naturaleza",
        "total",
		"id_venta",
        "id_pedido",
		"id_pedido_observacion",
        "id_compra",
        "id_ingresomercancia",
		"created_at",
		"updated_at",
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'             		=> "permit_empty|is_natural_no_zero",
		'id_cuenta'       		=> "required|numeric|min_length[1]|max_length[11]|is_not_unique[catalogocuentas.id]",
		'naturaleza'  			=> "required|min_length[1]|max_length[10]",
		'total'          		=> "required|decimal|min_length[1]|max_length[20]",
        'id_venta'       		=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ventas.id]",
		'id_pedido'    			=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]",
		'id_pedido_observacion' => "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[observacionproductos.id]",
		'id_compra' 			=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[compras.id]",
        'id_ingresomercancia'   => "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ingresomercancia.id]"
	];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	private function obtenerCuentaConfigurada($llaveBuscar) {
		$mParametrizacionCuentas = new mParametrizacionCuentas();
		$cuentaConfigurada = $mParametrizacionCuentas->where("campo", $llaveBuscar)->asObject()->first();
		if ($cuentaConfigurada) {
			return $cuentaConfigurada->valor;
		}
		return null;
	}

	private function buscarNaturaleza($metodo_pago) {
		$naturaleza = "credito";
		foreach (NATURALEZACUENTACONTABILIDAD as $value) {
			if ($value['relation'] == $metodo_pago) {
				$naturaleza = $value['valor'];
				break;
			}
		}
		return $naturaleza;
	}

	private function guardarMovimiento(string $cuenta, string $naturaleza, $total, int $idRelation, string $keyRelation, array $extraData = []) {

		$cuenta = $this->obtenerCuentaConfigurada($cuenta);
		if (!$cuenta) {
			throw new Exception("La cuenta no se encontro configurada");
		}

		$movement = array(
			"id_cuenta" => $cuenta,
			"naturaleza" => $naturaleza,
			"total" => $total,
			$keyRelation => $idRelation,
		);

		$movement = array_merge($movement, $extraData);

		if ($this->save($movement)) {
			return $this->insertID;
		} else {
			throw new Exception("No se pudo guardar el movimiento. " . listErrors($this->errors()));
		}
	}

	public function guardarVenta($id): string|bool {
		try {
			$mVentas = new mPedidos();
			$ventaActual = $mVentas->find($id);
			if (!$ventaActual) {
				throw new Exception("La venta no se encontro almacenada");
			}

			$naturaleza = $this->buscarNaturaleza($ventaActual->metodo_pago);

			/* Guardamos movimiento de descuento */
			$this->guardarMovimiento("cuentaDescuentoCliente", $naturaleza, $ventaActual->descuento, $ventaActual->id, "id_venta");
			
			/* Guardamos movimiento de total */
			$totalMenosDescuento = $ventaActual->total - ($ventaActual->descuento ?? 0);
			$this->guardarMovimiento("cuentaIngresos", $naturaleza, $totalMenosDescuento, $ventaActual->id, "id_venta");
			
			/* Generamos un movimiento para las cuentas por cobrar cuando es credito */
			if ($naturaleza == 'credito') {
				$this->guardarMovimiento("cuentaPorCobrarClientes", $naturaleza, $totalMenosDescuento, $ventaActual->id, "id_venta");
			}

			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}

	public function guardarPedido($id): string|bool {
		try {
			$mPedidos = new mPedidos();
			$pedidoActual = $mPedidos->find($id);
			if (!$pedidoActual) {
				throw new Exception("La venta no se encontro almacenada");
			}

			$naturaleza = $this->buscarNaturaleza($pedidoActual->metodo_pago);
			
			/* Guardamos movimiento de total */
			$this->guardarMovimiento("cuentaPedidos", $naturaleza, $pedidoActual->total, $pedidoActual->id, "id_venta");

			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}
	
}
