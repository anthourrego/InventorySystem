<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class DataTables extends CI_Controller {	
	
	function __construct()
	{
		parent::__construct();
		
		if (!$this->session->userdata("login")){
			redirect(base_url());
		}

		$this->load->model(array('DataTables_model'));
	}

	// DataTables ServerSide
	function dataTableSS() {
		if ($this->input->is_ajax_request()) {
			$tabla = json_decode($this->input->post('table'));
			$column_order = json_decode($this->input->post('column_order'));
			$this->DataTables_model->set_select(json_decode($this->input->post('select')));
			//$this->DataTables_model->set_table(json_decode($this->input->post('table')));
			$this->DataTables_model->set_table($tabla[0]);
			/*if(isset($tabla[1])){
				$this->DataTables_model->set_joins($tabla[1]);
			}*/
			if(isset($tabla[1])){
				$this->DataTables_model->set_where($tabla[1]);
			}
			$this->DataTables_model->set_column_order($column_order);
			$this->DataTables_model->set_column_search(json_decode($this->input->post('column_search')));
			$this->DataTables_model->set_order($this->input->post('orden'));
			$list = $this->DataTables_model->get_datatables();
			$data = array();
			foreach ($list as $cliente) {
				$row = array();

            // Almacena en array las columnas a mostrar
				foreach ($column_order as $columna) {
					$row[] = $cliente->$columna;
				}

				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->DataTables_model->count_all(),
				"recordsFiltered" => $this->DataTables_model->count_filtered(),
				"data" => $data,
				);
        	//output to json format
			echo json_encode($output);			
		}else{
			show_404();
		}
	}

	// DataTables Server Side Full
	function dtSS() {
		if ($this->input->is_ajax_request()) {
			ini_set('max_execution_time', -1);
			ini_set('memory_limit', -1);
			$tabla = json_decode($this->input->post('table'));
			$this->DataTables_model->set_select(json_decode($this->input->post('select')));
			$this->DataTables_model->set_table($tabla[0]);
			if(array_key_exists(1, $tabla)){
				$this->DataTables_model->set_joins($tabla[1]);
			}
			if(array_key_exists(2, $tabla)){
				$this->DataTables_model->set_where($tabla[2]);
			}
			$this->DataTables_model->set_column_order(json_decode($this->input->post('column_order')));
			$this->DataTables_model->set_column_search(json_decode($this->input->post('column_search')));
			$this->DataTables_model->set_order($this->input->post('orden'));
			$this->DataTables_model->set_group_by(json_decode($this->input->post('group_by')));
			$this->DataTables_model->set_having(json_decode($this->input->post('having')));
			$this->DataTables_model->set_or_where(json_decode($this->input->post('or_where')));
			$this->DataTables_model->set_where_in(json_decode($this->input->post('where_in')));
			$list = $this->DataTables_model->get_datatables();
			//echo $this->db->last_query();
			$columnas = json_decode($this->input->post('columnas'));
			$data = array();
			// Foreach para llenado de filas

	        for ($j=0; $j < count($list); $j++) { 
	        	$row = array();
	            // Ingresa en array row las columnas a mostrar
				for ($i=0; $i < count($columnas); $i++) {
					$row[] = $list[$j]->$columnas[$i];
				}
	            $data[] = $row;
	        }

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->DataTables_model->count_all(),
				"recordsFiltered" => $this->DataTables_model->count_filtered(),
				"data" => $data,
			);
			if( ! count($data) > 0){
				$output['recordsTotal'] = 0;
				$output['recordsFiltered'] = 0;
			}
			echo json_encode($output);
		}else{
			show_404();
		}
	}

	function dtSSController($configDTSST, $asociativo = false){
		if ($this->input->is_ajax_request()) {
			ini_set('max_execution_time', -1);
			ini_set('memory_limit', -1);
			ini_set('sqlsrv.ClientBufferMaxKBSize', '524288');
			ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');
			$tabla = $configDTSST['table'];
			$this->DataTables_model->set_select($configDTSST['select']);
			$this->DataTables_model->set_table($tabla[0]);
			if(array_key_exists(1, $tabla)){
				$this->DataTables_model->set_joins($tabla[1]);
			}
			if(array_key_exists(2, $tabla)){
				$this->DataTables_model->set_where($tabla[2]);
			}

			$this->DataTables_model->set_column_order(isset($configDTSST['column_order']) ? $configDTSST['column_order'] : []);
			$this->DataTables_model->set_column_search(isset($configDTSST['column_search']) ? $configDTSST['column_search'] : []);
			$this->DataTables_model->set_order(isset($configDTSST['orden']) ? $configDTSST['orden'] : []);
			$this->DataTables_model->set_group_by(isset($configDTSST['group_by']) ? $configDTSST['group_by'] : []);
			$this->DataTables_model->set_having(isset($configDTSST['having']) ? $configDTSST['having'] : []);
			$this->DataTables_model->set_or_where(isset($configDTSST['or_where']) ? $configDTSST['or_where'] : []);
			$this->DataTables_model->set_where_in(isset($configDTSST['where_in']) ? $configDTSST['where_in'] : []);
			$list = $this->DataTables_model->get_datatables();
			$data = array();
			// Foreach para llenado de filas
			if (!$asociativo) {
				$columnas = $configDTSST['columnas'];
				
				for ($j=0; $j < count($list); $j++) { 
					$row = array();
					// Ingresa en array row las columnas a mostrar
					for ($i=0; $i < count($columnas); $i++) {
						$row[] = $list[$j]->$columnas[$i];
					}
					$data[] = $row;
				}
			} else {
				$data = $list;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->DataTables_model->count_all(),
				"recordsFiltered" => $this->DataTables_model->count_filtered(),
				"data" => $data,
			);
			if( ! count($data) > 0){
				$output['recordsTotal'] = 0;
				$output['recordsFiltered'] = 0;
			}
			echo json_encode($output);
		}else{
			show_404();
		}
	}
}

?>
