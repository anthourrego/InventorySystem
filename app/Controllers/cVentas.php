<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\mVentas;
use App\Models\mProductos;
use App\Models\mUsuarios;
use App\Models\mClientes;
use App\Models\mVentasProductos;

class cVentas extends BaseController {
	public function index() {
		$this->content['title'] = "Administador Ventas";
		$this->content['view'] = "Ventas/vAdministador";

		$this->LDataTables();
		$this->LMoment();

		$this->content['js_add'][] = [
			'Ventas/jsAdministrador.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function crear() {
		$this->content['title'] = "Crear venta";
		$this->content['view'] = "Ventas/vCrear";

		$this->LDataTables();
		$this->LMoment();
		$this->LSelect2();
		$this->LInputMask();
		$this->LJQueryValidation();
		$this->LFancybox();

		$ventaModel = new mVentas();
		$codigo = $ventaModel->asObject()->orderBy('id', 'desc')->first();

		$mClientes = new mClientes();
		$this->content["cantidadClientes"] = $mClientes->where("estado", 1)->countAllResults();

		$this->content["nroVenta"] = is_null($codigo) ? 1 : ($codigo->codigo + 1);

		$this->content["inventario_negativo"] = (session()->has("inventarioNegativo") ? session()->get("inventarioNegativo") : '0');

		$this->content["cantidadVendedores"] = $this->cantidadVendedores();

		$this->content['js_add'][] = [
			'Ventas/jsCrear.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function Editar($id) {
		$ventaModel = new mVentas();
		$venta = $ventaModel->cargarVenta($id);

		if (count($venta) != 1) {
			return redirect()->route('Ventas/Administrar');
		}

		$venta = $venta[0];
        
		$this->content["venta"] = $venta;

		$this->content["nroVenta"] = $venta->codigo;

		$this->content['title'] = "Editar venta Nro " . $venta->codigo;
		$this->content['view'] = "Ventas/vCrear";

		$this->LDataTables();
		$this->LMoment();
		$this->LSelect2();
		$this->LInputMask();
		$this->LJQueryValidation();
		$this->LFancybox();

		$this->content['js_add'][] = [
			'Ventas/jsCrear.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$query = $this->db->table('ventas AS V')
											->select("
												V.id,
												V.codigo,
												V.id_cliente,
												C.nombre AS NombreCliente,
												V.id_vendedor,
												U.nombre AS NombreVendedor,
												V.impuesto,
												V.neto,
												V.total,
												CASE 
													WHEN V.metodo_pago = 1 THEN 'Contado' 
													ELSE 'Credito'
												END AS metodo_pago,
												V.created_at,
												V.updated_at
											")->join('clientes AS C', 'V.id_cliente = C.id', 'left')
											->join('usuarios AS U', 'V.id_vendedor = U.id', 'left');

		return DataTable::of($query)->toJson(true);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$data = (object) $this->request->getPost();
        
		$ventas = new mVentas();

		if ($ventas->delete($data->id)) { 
			$resp["success"] = true;
			$resp['msj'] = "Venta eliminada correctamente";
		} else {
			$resp['msj'] = "Error al eliminar la venta";
		}

		return $this->response->setJSON($resp);
	}

	public function crearEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$dataPost = (object) $this->request->getPost();
		//var_dump($dataPost);
		$valorTotal = 0;
		$prod = json_decode($dataPost->productos);
        
		$productoModel = new mProductos();
		$ventaModel = new mVentas();
		$mVentasProductos = new mVentasProductos();

    $codigo = $ventaModel->asObject()->orderBy('id', 'desc')->first();
		$codigo = is_null($codigo) ? 1 : ($codigo->codigo + 1);

		if (count($prod) > 0) {
			$this->db->transBegin();

			$dataSave = array(
				"codigo" => $codigo,
				"id_cliente" => $dataPost->idCliente,
				"id_vendedor" => $dataPost->idUsuario,
				"impuesto" => 0,
				"neto" => 0,
				"total" => 0,
				"metodo_pago" => $dataPost->metodoPago,
				"observacion" => $dataPost->observacion
			);

			if($ventaModel->save($dataSave)){
				$dataSave["id"] = $ventaModel->getInsertID();
				foreach ($prod as $it) {
					$dataProductoVenta = [
						"id_venta" => $dataSave["id"],
						"id_producto" => $it->id,
						"cantidad" => $it->cantidad,
						"valor" => $it->valorUnitario,
						"valor_original" => $it->precio_venta
					];

					$valorTotal = $valorTotal + ($it->cantidad * $it->valorUnitario);

					$product = $productoModel->find($it->id);
					$product["stock"] = $product["stock"] - $it->cantidad;

					if (!$mVentasProductos->save($dataProductoVenta)) {
						$resp["msj"] = "Ha ocurrido un error al guardar los productos." . listErrors($ventaModel->errors());
						break;
					}

					if(!$productoModel->save($product)){
						$resp["msj"] = "Error al guardar al actualizar el producto. " . listErrors($ventaModel->errors());
						break;
					}
				}

				if ($this->db->transStatus() !== false) {
					$dataSave["total"] = $valorTotal;
					$dataSave["neto"] = $valorTotal;

					if ($ventaModel->save($dataSave)) {
						$resp["success"] = true;
						$resp["msj"] = $dataSave;
					} else {
						$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($ventaModel->errors());
					}
				}
			} else{
				$resp["msj"] = "Ha ocurrido un error al guardar la venta." . listErrors($ventaModel->errors());
			}

			if($resp["success"] == false || $this->db->transStatus() === false) {
				$this->db->transRollback();
			} else {
				$this->db->transCommit();
			}

		} else {
			$resp['msj'] = "No se puede generar la venta si no hay productos seleccionados";
		}

		return $this->response->setJSON($resp);
	}

	public function cantidadVendedores(){
		$mUsuarios = new mUsuarios();

		$vendedores = $mUsuarios->join("(
											SELECT 
												usuarioId,
												perfilId, 
												COUNT(*) AS Vendedor 
											FROM permisosusuarioperfil 
											WHERE permiso = '61' 
											GROUP BY usuarioId, perfilId) AS pup", 
											"(CASE WHEN usuarios.perfil IS NULL THEN usuarios.id = pup.usuarioId ELSE usuarios.perfil = pup.perfilId END)", "inner", 
											false)
											->where("usuarios.estado", 1)
											->countAllResults();
		
		return $vendedores;
	}

	private function cargarVenta(){

	}
}
