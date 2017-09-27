<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flag_model extends CI_Model
{
	
	
	public function insert_one_row($table,$data)
	{
		$this->db->insert($table,$data);
		//echo $this->db->last_query();die();
		return $this->db->insert_id();
	}
	
	public function get_by_result($query)
	{
		$result=$this->db->query($query);
		return $result->result();
	}
	
	
	
	public function get_record_by_id($table,$condition)
	{
		$this->db->where($condition);
		$result=$this->db->get($table);
		return $result->row();
	}
	
	public function update_record_by_id($table,$data,$condition)
	{
		$this->db->where($condition);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	
	public function delete_record_by_id($table,$condition)
	{
		$this->db->where($condition);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	
	public function check_existence($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		if($result->num_rows() > 0)
			return true;
		else 
			return false;
	}
}	