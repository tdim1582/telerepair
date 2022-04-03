<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Garanti_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    // FUNCTION FOR INSERT
	public function insertData($table, $data) {
		$this -> db -> insert($table, $data);
		return $this -> db -> insert_id();
	}

	// FUNCTION FOR DELETE
	public function deleteData($tableName, $condition)// deletion in user_form table
	{
		foreach ($condition as $k => $v) {
			$this -> db -> where($k, $v);
		}
		$this -> db -> delete($tableName);
		return TRUE;
	}

	//FUNCTION FOR SELECT ALL DATA
	public function selectAllData($tbl, $condition = "", $order_by = "", $limit = "", $min = "", $max = "", $column_name = "",$group_by="") {
		if ($column_name) {
		
			$this -> db -> select($column_name);
		} else {
			$this -> db -> select('*');

		}
		$this -> db -> from($tbl);
		if ($condition) {
			foreach ($condition as $k => $v) {
				$this -> db -> where($k, $v);
			}
		}
		if ($min) {
			$this -> db -> where($column_name . ' >=', $min);
			$this -> db -> where($column_name . ' <=', $max);
		}
		if ($order_by) {
			if(is_array($order_by)){
				$this -> db -> order_by($order_by['column'], $order_by['type']);
			}else{
				$this -> db -> order_by($order_by, 'DESC');
			}
			
		}
		if ($limit) {
			$this -> db -> limit($limit);
		}
		if ($group_by != '') {
			$this -> db -> group_by($group_by);
		}
	  

		$resultdata = $this -> db -> get() -> result_array();
		if (count($resultdata) > 0) {
			return $resultdata;
		} else {
			return FALSE;
		}
    }
    
    // FUNCTION FOR UPDATE
	public function updateData($table, $data, $cond) {
		foreach ($cond as $k => $v) {
			$this -> db -> where($k, $v);
		}
		$this -> db -> update($table, $data);
		return TRUE;
	}


}

// end of model file