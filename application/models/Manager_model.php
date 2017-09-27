<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manager_model extends CI_Model
{
	public function get_by_query($query)
	{
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	public function insert_one_row($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
}