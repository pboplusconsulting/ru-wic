<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membership_model extends CI_Model
{
	public function get_result_by_query($query)
	{
		$result=$this->db->query($query);
		return $result->result();
	}
	
	
	public function insert_one_row($table,$data)
	{
		$this->db->insert($table,$data);
		//echo $this->db->last_query();die();
		return $this->db->insert_id();
	}
	
	public function member_list($table,$select)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->order_by('id','ASC');
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
	}
	
	public function get_one_row($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	public function get_record_by_id($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		//echo $this->db->last_query();die();
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
	public function result_count($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		return $result->num_rows();
	}
}