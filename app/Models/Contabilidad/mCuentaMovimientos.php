<?php

namespace App\Models\Contabilidad;

use App\Models\Contabilidad\mParametrizacionCuentas;
use App\Models\Contabilidad\mCatalogoCuentas;
use App\Models\mVentas;
use App\Models\mPedidos;
use App\Models\mVentasProductos;
use App\Models\mProductos;
use App\Models\mCompras;
use App\Models\mCompraProductos;
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
		"id_producto",
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
        'id_ingresomercancia'   => "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ingresomercancia.id]",
		'id_producto'		    => "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[productos.id]"
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

	private function buscarNaturaleza($metodo_pago, $desdeCuenta = false) {
		if ($desdeCuenta) {
			$mCatalogoCuentas = new mCatalogoCuentas();
			$cuenta = $mCatalogoCuentas->asObject()->find($metodo_pago);
			return $cuenta->naturaleza;
		} else {
			$naturaleza = "credito";
			foreach (NATURALEZACUENTACONTABILIDAD as $value) {
				if ($value['relation'] == $metodo_pago) {
					$naturaleza = $value['valor'];
					break;
				}
			}
			return $naturaleza;
		}
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

	public function guardarVenta($idVenta, $reiniciarMovimientos = false): string|bool {
		try {
			$mVentas = new mVentas();
			$ventaActual = $mVentas->asObject()->find($idVenta);
			if (!$ventaActual) {
				throw new Exception("La venta no se encontro almacenada");
			}

			if ($reiniciarMovimientos) {
				$this->where("id_venta", $ventaActual->id)->delete();
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

			/* Generamos un movimiento para las ganancias respecto al valor de los productos */
			$mVentasProductos = new mVentasProductos();
			$productos = $mVentasProductos
				->select("
					(ventasproductos.cantidad * ventasproductos.valor_original) AS totalVentaProducto,
					(ventasproductos.cantidad * p.costo) AS totalCostoProducto,
					((ventasproductos.cantidad * ventasproductos.valor) - (ventasproductos.cantidad * p.costo)) AS totalGananciaProducto
				")
				->join("productos p", "ventasproductos.id_producto = p.id", "left")
				->where("ventasproductos.id_venta", $idVenta)
				->findAll();
			
			$totalGanancia = 0;
			foreach ($productos as $value) {
				$totalGanancia += $value->totalGananciaProducto;
			}
			$this->guardarMovimiento("cuentaGananciasAcumuladas", $naturaleza, $totalGanancia, $ventaActual->id, "id_venta");

			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}

	public function guardarPedido($idPedido, $reiniciarMovimientos = false): string|bool {
		try {
			$mPedidos = new mPedidos();
			$pedidoActual = $mPedidos->asObject()->find($idPedido);
			if (!$pedidoActual) {
				throw new Exception("El pedido no se encontro almacenado");
			}

			if ($reiniciarMovimientos) {
				$this->where("id_pedido", $pedidoActual->id)->delete();
			}

			$naturaleza = $this->buscarNaturaleza($pedidoActual->metodo_pago);
			
			/* Guardamos movimiento de total */
			$this->guardarMovimiento("cuentaPedidos", $naturaleza, $pedidoActual->total, $pedidoActual->id, "id_pedido");

			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}

	public function guardarCompra($idCompra, $reiniciarMovimientos = false): string|bool {
		try {
			$mCompras = new mCompras();
			$compraActual = $mCompras->asObject()->find($idCompra);
			if (!$compraActual) {
				throw new Exception("La compra no se encontro almacenada");
			}

			if ($reiniciarMovimientos) {
				$this->where("id_compra", $compraActual->id)->delete();
			}

			$cuenta = $this->obtenerCuentaConfigurada("cuentaCompras");
			if (!$cuenta) {
				throw new Exception("La cuenta no se encontro configurada");
			}

			$naturaleza = $this->buscarNaturaleza($cuenta, true);

			/* Guardamos movimiento de total */
			$this->guardarMovimiento("cuentaCompras", $naturaleza, $compraActual->total, $compraActual->id, "id_compra");
			
			$mCompraProductos = new mCompraProductos();
			$productos = $mCompraProductos
				->select("
					comprasproductos.cantidad,
					comprasproductos.valor_original,
					comprasproductos.costo,
					comprasproductos.id_producto
				")
				->join("productos p", "comprasproductos.id_producto = p.id", "left")
				->where("comprasproductos.id_compra", $idCompra)
				->findAll();
			
			/* Generamos un movimiento por producto respecto al costo * cantidad en la venta */
			foreach ($productos as $value) {
				$this->guardarInventarioProducto($value->id_producto, $value->costo, $value->cantidad);
			}
			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}

	public function guardarInventarioProducto($idProducto, $costoUnitario, $cantidad): string|bool {
		try {
			$mProductos = new mProductos();
			$productoActual = $mProductos->asObject()->find($idProducto);
			if (!$productoActual) {
				throw new Exception("El producto no se encontro almacenado");
			}

			$cuenta = $this->obtenerCuentaConfigurada("cuentaInventario");
			if (!$cuenta) {
				throw new Exception("La cuenta no se encontro configurada");
			}

			$naturaleza = $this->buscarNaturaleza($cuenta, true);
			
			/* Guardamos movimiento de producto */
			$this->guardarMovimiento("cuentaInventario", $naturaleza, $costoUnitario * $cantidad, $productoActual->id, "id_producto");

			return true;
		} catch (Exception $e) {
            log_message('error', 'Register Account Movement: ' . $e->getMessage());
			return $e->getMessage();
        }
	}
	
}
