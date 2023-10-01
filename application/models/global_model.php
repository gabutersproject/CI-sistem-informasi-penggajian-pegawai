<?php

class Global_model extends CI_Model{
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Find single record by id
	 * @param str $tbl 
	 * @param str $id
	 * @return array
	 */
	function find($tbl, $id) {
		$q = $this->db->get_where($tbl, array('id'=>$id));
		return $q->row_array();
	}
	
	/**
	 * Find single record by condition 
	 * @param str $tbl 
	 * @param multi $condition accept string or array
	 * @param bool $obj TRUE for @return as object
	 * @return array or object
	 */
	function find_by($tbl, $condition, $obj = FALSE) {
		$q = $this->db->get_where($tbl, $condition);
		if($obj){
			return $q->row();
		}else{
			return $q->row_array();
		}
		
	}
	
	/**
	 * Find all records
	 * @param str $tbl 
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @return array
	 */
	function find_all($tbl, $order=null, $limit=null, $offset=null) {
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$order = explode(" ",$order);
			$this->db->order_by($order[0],$order[1]);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}
	
	/**
	 * Find all records by condition
	 * @param str $tbl 
	 * @param multi $condition accept array or string
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @return array
	 */	
	function find_all_by($tbl, $condition, $order=null, $limit=null, $offset=null) {
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		$this->db->where($condition);
		if($order){
			$order = explode(" ",$order);
			$this->db->order_by($order[0],$order[1]);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}
	
	/**
	 * Find single record join one table
	 * @param str $tbl 
	 * @param int $id 
	 * @param str $join table to be joined
	 * @param str $fkey foreign key default='id'
	 * @param str $pkey primary key if null set $tbl._id
	 * @return array
	 */
	function find_join($tbl, $id, $join, $fkey='id', $pkey=null) {
//		$this->db->limit($limit, $offset);
		$pkey = ($pkey)?$pkey:$join."_id";
		$this->db->join($join, $join.".".$fkey."=".$tbl.".".$pkey);
		$this->db->where($tbl.'.id',$id);
		$q = $this->db->get($tbl);
		return $q->row_array();
	}
	
	/**
	 * Find all records join one table with condition if not null
	 * @param str $tbl 
	 * @param str $join 
	 * @param str $fkey 
	 * @param str $pkey 
	 * @param multi $condition 
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @return array
	 */
	function find_all_join($tbl, $join, $fkey='id', $pkey=null, $condition=null, $order=null, $limit=null, $offset=null) {
		$pkey = ($pkey)?$pkey:$join."_id";
		$this->db->join($join, $join.".".$fkey."=".$tbl.".".$pkey);
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($condition){
			$this->db->where($condition);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}
	
	/**
	 * Find all records join many table with condition if not null
	 * @param str $tbl 
	 * @param array $join e.g: array(array1,array2,arrayn)
	 * @param multi $condition accept string or array
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @return array
	 */
	function find_all_join_many($tbl, $join, $condition=null, $order=null, $limit=null, $offset=null) {
		foreach ($join as $j) {
			if(isset($j[3])){
				$this->db->select($tbl.'.*, '.$j[3]);
			}
			$on = preg_match('/\./', $j[2]) ? $j[2] : $tbl.'.'.$j[2];
			$this->db->join($j[0], $j[0].".".$j[1]."=".$on);
		}
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($condition){
			$this->db->where($condition);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}

	/**
	 * Select field join one table with condition if not null
	 * @param str $tbl 
	 * @param str $fields 
	 * @param str $join 
	 * @param str $fkey 
	 * @param str $pkey 
	 * @param multi $condition accept string or array
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @param str $group 
	 * @return array
	 */
	function select_join($tbl, $fields="*", $join, $fkey='id', $pkey=null, $condition=null, $order=null, $limit=null, $offset=null, $group=null) {
		$this->db->_protect_identifiers=false;
		$pkey = ($pkey)?$pkey:$join."_id";
		$this->db->join($join, $join.".".$fkey."=".$tbl.".".$pkey);
		$offset = ($offset) ? $offset : 0;
		$this->db->select($fields);
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($group){
			$this->db->group_by($group);
		}
		if($condition){
			$this->db->where($condition);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}

	/**
	 * Select field join many table
	 * @param str $tbl 
	 * @param str $fields 
	 * @param array $join e.g: array(array1,array2,arrayn)
	 * @param multi $condition accept string or array
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @param str $group 
	 * @return array
	 */
	function select_join_many($tbl, $fields="*", $join, $condition=null, $order="id DESC", $limit=null, $offset=null, $group=null) {
		$this->db->select($fields);
		foreach ($join as $j) {
			$on = preg_match('/\./', $j[2]) ? $j[2] : $tbl.'.'.$j[2];
			$this->db->join($j[0], $j[0].".".$j[1]."=".$on);
		}
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($group){
			$this->db->group_by($group);
		}
		if($condition){
			$this->db->where($condition);
		}
		$q = $this->db->get($tbl);
		return $q->result_array();
	}

	/**
	 * Create new record
	 * @param str $tbl 
	 * @param array $data 
	 * @return int INSERT_ID
	 */
	function create($tbl, $data) {
		$this->db->insert($tbl, $data);
		return $this->db->insert_id();
	}

	/**
	 * Crate new batch records
	 * @param str $tbl 
	 * @param array $data multidimension
	 * @return void
	 */
	function create_batch($tbl, $data) {
		$this->db->insert_batch($tbl, $data);
		return $this->db->insert_id();
	}
	
	/**
	 * Update record by key default=id
	 * @param str $tbl 
	 * @param array $data 
	 * @param str $key 
	 * @return void
	 */
	function update($tbl, $data, $key=array()) {
		if(!is_array($key)){
			$id = $key;
			$this->db->where('id', $id);
		}else{
			$this->db->where($key);
		}
		//$this->db->where($key,$data[$key]);
		$this->db->update($tbl, $data);
	}
	
	/**
	 * Delete record by key
	 * @param str $tbl 
	 * @param multi $key accept array or string
	 * @return void
	 */
	function delete($tbl, $key=array()) {
		if(!is_array($key)){
			$id = $key;
			$this->db->where('id', $id);
		}else{
			$this->db->where($key);
		}
		$this->db->delete($tbl);
	}

	/**
	 * Select all records by fields
	 * @param str $tbl 
	 * @param str $fields 
	 * @param int $limit 
	 * @param int $offset 
	 * @return array
	 */	
	function select($tbl, $fields = "*", $condition = null, $limit = null, $offset = null){
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($condition){
			$this->db->where($condition);
		}
		$this->db->select($fields);
		$q = $this->db->get($tbl, $limit, $offset);
		return $q->result_array();
	}

	/**
	 * Search record by criteria(LIKE function)
	 * @param str $tbl 
	 * @param array $criteria 
	 * @param multi $condition 
	 * @param str $order 
	 * @param int $limit 
	 * @param int $offset 
	 * @param array $notin 
	 * @return type
	 */
	function search($tbl, $criteria, $condition=null, $order = null, $limit=null, $offset=null, $notin=null){
		$offset = ($offset) ? $offset : 0;
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$order = explode(" ",$order);
			$this->db->order_by($order[0],$order[1]);
		}
		if($condition){
			$this->db->where($condition);
		}
		if($notin){
			$this->db->where_not_in($notin[0],$notin[1]);
		}
		$this->db->like($criteria);
		$q = $this->db->get($tbl, $limit, $offset);
		return $q->result_array();
	}

	function search_join($tbl, $join, $fkey='id', $pkey=null, $criteria, $condition=null, $order = null, $limit=null, $offset=null, $notin=null){
		$offset = ($offset) ? $offset : 0;
		$pkey = ($pkey)?$pkey:$join."_id";
		$this->db->join($join, $join.".".$fkey."=".$tbl.".".$pkey);
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$order = explode(" ",$order);
			$this->db->order_by($order[0],$order[1]);
		}
		if($condition){
			$this->db->where($condition);
		}
		if($notin){
			$this->db->where_not_in($notin[0],$notin[1]);
		}
		$this->db->like($criteria);
		$q = $this->db->get($tbl, $limit, $offset);
		return $q->result_array();
	}

	function search_join_many($tbl, $join, $criteria, $condition=null, $order = null, $limit=null, $offset=null, $notin=null){
		$offset = ($offset) ? $offset : 0;
		foreach ($join as $j) {
			if(isset($j[3])){
				$this->db->select($tbl.'.*, '.$j[3]);
			}
			$on = preg_match('/\./', $j[2]) ? $j[2] : $tbl.'.'.$j[2];
			$this->db->join($j[0], $j[0].".".$j[1]."=".$on);
		}
		if($limit){
			$this->db->limit($limit, $offset);
		}
		if($order){
			$order = explode(" ",$order);
			$this->db->order_by($order[0],$order[1]);
		}
		if($condition){
			$this->db->where($condition);
		}
		if($notin){
			$this->db->where_not_in($notin[0],$notin[1]);
		}
		if(is_array($criteria)){
			foreach ($criteria as $key => $val) {
				if(count(explode(" ",$key)) > 1){
					if(substr($key,0,2) == 'or' || substr($key,0,2) == 'OR'){
						$this->db->or_like(substr($key,3), $val);
					}else{
						$this->db->like(substr($key,3), $val);
					}
				}else{
					$this->db->like($key, $val);
				}
			}
		}else{
			$this->db->where($criteria);
		}
		$q = $this->db->get($tbl, $limit, $offset);
		return $q->result_array();
	}

	function query($sql)
	{
		$q = $this->db->query($sql);
		return $q->result_array();
	}

}