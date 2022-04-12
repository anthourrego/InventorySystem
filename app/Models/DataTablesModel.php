<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTablesModel extends Model {

	var $select;
	var $table;
	var $column_order; //set column field database for datatable orderable
	var $column_search; //set column field database for datatable searchable 
	var $order; // default order
	var $join;
	var $where;
	var $group_by;
	var $having;
	var $or_where;
	var $where_in;

	function set_select($select){
		$this->select = $select;
	}

	function set_table($table){
		$this->table = $table;
	}

	function set_column_order($column_order){
		$this->column_order = $column_order;
	}

	function set_column_search($column_search){
		$this->column_search = $column_search;
	}

	function set_order($order){
		$this->order = $order;
	}

	function set_joins($join){
		$this->join = $join;
	}

	function set_where($where){
		$this->where = $where;
	}

	function set_group_by($group_by){
		$this->group_by = $group_by;
	}

	function set_having($having){
		$this->having = $having;
	}

	function set_or_where($or_where){
		$this->or_where = $or_where;
	}

	function set_where_in($where_in){
		$this->where_in = $where_in;
	}

	private function _db_functions()
	{
		// Select codeigniter
		$this->db->select($this->select, false);
		// tabla de donde provienen los datos
		$this->db->from($this->table, false);
		if($this->join != null){
			foreach ($this->join as $join) {
				if (empty($join[2])){
					$this->db->join($join[0], $join[1], null, false);
				}else{
					$this->db->join($join[0], $join[1], $join[2], false);
				}
			}
		}
		if($this->where != null){
			foreach ($this->where as $where) {
				if(!empty($where[1])){
					$this->db->where($where[0], $where[1]);
				}else{
					$this->db->where($where[0]);
				}
			}
		}
		if($this->group_by != null){
			foreach ($this->group_by as $group_by) {
				$this->db->group_by($group_by);
			}
		}
		if($this->having != null){
			foreach ($this->having as $having) {
				$this->db->having($having[0], $having[1]);
			}
		}
		if($this->or_where != null){
			foreach ($this->or_where as $or_where) {
				$this->db->or_where($or_where[0], $or_where[1]);
			}
		}
		if($this->where_in != null){
			foreach ($this->where_in as $where_in) {
				$this->db->where_in($where_in[0], $where_in[1]);
			}
		}
	}

	private function _get_datatables_query()
	{
		$this->_db_functions();
		$i = 0;
	 
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				 
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
 
				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		 
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			foreach ($order as $key => $value) {
				if(gettype($key) == 'integer'){
					$this->db->order_by($order[$key][0], $order[$key][1]);
				}else{
					$this->db->order_by($key, $value);
				}
			}
		}
	}
 
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		return $this->db->get()->result();
	}
 
	function count_filtered()
	{
		$this->_get_datatables_query();
		return $this->db->count_all_results();
	}
 
	public function count_all()
	{
		$this->_db_functions();
		return $this->db->count_all_results();
	}
}

?>