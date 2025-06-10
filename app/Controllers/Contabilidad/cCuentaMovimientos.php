<?php

namespace App\Controllers\Contabilidad;
use App\Controllers\BaseController;
use App\Models\mAlmacen;
use App\Models\Contabilidad\mCuentaMovimientos;
use App\Models\Contabilidad\mCatalogoCuentas;
use \Hermawan\DataTables\DataTable;

class cCuentaMovimientos extends BaseController {
	
	private $mCuentaMovimientos;
	
	public function index($fechaIni = '', $fechaFin = '') {

		$filters = [
			"fechaIni" => $fechaIni,
			"fechaFin" => $fechaFin
		];

		$mCatalogoCuentas = new mCatalogoCuentas();
		$cuentasContables = $mCatalogoCuentas->getCuentas(1, null, $filters);

		$this->mCuentaMovimientos = new mCuentaMovimientos();

		$this->calcularTotalCuenta($cuentasContables);

		$this->content['cuentasContables'] = $cuentasContables;
		$this->content['filtros'] = $filters;

		$this->content['title'] = "Movimiento de cuentas";
		$this->content['view'] = "Contabilidad/vCuentaMovimientos";

		$this->LMoment();
		$this->Lgijgo();

		$this->content['js_add'][] = [
			'Contabilidad/jsCuentaMovimientos.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	private function calcularTotalCuenta($cuentasContables) {
		foreach ($cuentasContables as $key => &$cuenta) {
			$this->calcularMovimientosCuenta($cuenta);
		}
	}

	private function calcularMovimientosCuenta(&$cuenta) {
		if ($cuenta->children)  {

			$totalCredito = 0;
			$totalDebito = 0;
			foreach ($cuenta->children as $key => &$children) {
				$this->calcularMovimientosCuenta($children);

				$totalCredito += $children->movimientoCredito;
				$totalDebito += $children->movimientoDebito;
			}

			$cuenta->{'movimientoCredito'} = $totalCredito;
			$cuenta->{'movimientoDebito'} = $totalDebito;
			return $cuenta;
		}

		$movimientos = $this->mCuentaMovimientos
			->select('naturaleza, SUM(total) as total')
			->where('id_cuenta', $cuenta->id)
			->where('estado', "AC")
			->groupBy('naturaleza')
			->get()
			->getResult();

		$resultado = [];
		foreach ($movimientos as $mov) {
			$resultado[$mov->naturaleza] = $mov->total;
		}

		$cuenta->{'movimientoCredito'} = $resultado['credito'] ?? 0;
		$cuenta->{'movimientoDebito'} = ($resultado['debito'] ?? 0) + ($resultado['credito'] ?? 0);
		return $cuenta;
	}
}
