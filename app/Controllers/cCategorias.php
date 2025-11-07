<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\mCategorias;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class cCategorias extends BaseController {
	private $applyShop = '0';

	public function initController(
		RequestInterface $request,
		ResponseInterface $response,
		LoggerInterface $logger
	) {
		parent::initController($request, $response, $logger);

		$this->applyShop = (int) (session()->has("applyShop") ? session()->get("applyShop") : '0');
	}

	public function index() {
		$this->content['title'] = "Categorias";
		$this->content['view'] = "vCategorias";

		$this->LDataTables();
		$this->LMoment();
		$this->LJQueryValidation();

		$this->content["campos"] = [
			"applyShop" => $this->applyShop,
 		];

		$this->content['js_add'][] = [
			'jsCategorias.js'
		];

		return view('UI/viewDefault', $this->content);
	}

	public function listaDT(){
		$estado = $this->request->getPost("estado");

		$query = $this->db->table('categorias')
											->select("
													id, 
													nombre, 
													descripcion, 
													estado, 
													CASE 
															WHEN estado = 1 THEN 'Activo' 
															ELSE 'Inactivo' 
													END AS Estadito,
													apply_shop,
													CASE 
															WHEN apply_shop = 1 THEN 'Activo' 
															ELSE 'Inactivo' 
													END AS ApplyShopDesc,
													created_at,
													updated_at
											");

		if($estado != "-1"){
			$query->where("estado", $estado);
		}

		return DataTable::of($query)->toJson(true);
	}

	public function crearEditar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$postData = $this->request->getPost();
		//Creamos los datos para guardar

		$datosSave = array(
			"id" => $postData["id"],
			"nombre" => trim($postData["nombre"]),
			"descripcion" => trim($postData["descripcion"]),
			"apply_shop" => ($this->applyShop == '1' ? (int) $postData["aplicaTienda"] : 0),
		);

		$perfil = new mCategorias();
		if ($perfil->save($datosSave)) {
			$resp["success"] = true;
			$resp["msj"] = "La categoria <b>{$datosSave["nombre"]}</b> se " . (empty($postData['id']) ? 'creo' : 'actualizo') . " correctamente.";
		} else {
			$resp["msj"] = "No puede " . (empty($postData['id']) ? 'crear' : 'actualizar') . " la categoria." . listErrors($perfil->errors());
		}

		return $this->response->setJSON($resp);
	}

	public function eliminar(){
		$resp["success"] = false;
		//Traemos los datos del post
		$id = $this->request->getPost("id");
		$estado = $this->request->getPost("estado");

		$perfil = new mCategorias();
		
		$data = [
			"id" => $id,
			"estado" => $estado
		];

		if($perfil->save($data)) {
			$resp["success"] = true;
				$resp['msj'] = "Categoria actualizada correctamente";
		} else {
			$resp['msj'] = "Error al cambiar el estado";
		}

		return $this->response->setJSON($resp);
	}

	public function getCategoriesShop() {
		$categories = new mCategorias();

		$categories->select('id, nombre As name')->where('estado', 1)->where('apply_shop', 1);

		return $this->response->setJSON($categories->findAll());
	}
}
