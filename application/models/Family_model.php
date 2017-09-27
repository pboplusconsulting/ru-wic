<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Family_model extends CI_Model
{
	public function get_by_query($query)
	{
		$result=$this->db->query($query);
		return $result->result_array();
	}
	public function get_array_by_one_leftjoin($table,$select,$condition,$joinTable,$joinCondition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->join($joinTable,$joinCondition,'LEFT');
		$this->db->where($condition);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	
	public function get_row_by_one_leftjoin($table,$select,$condition,$joinTable,$joinCondition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->join($joinTable,$joinCondition,'LEFT');
		$this->db->where($condition);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	
	public function get_array_of_object($table,$select,$condition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
	}
	
	public function get_by_order($table,$select,$condition,$column,$order)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$this->db->order_by($column,$order);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
		
	}
	public function insert_one_row($table,$data)
	{
		$this->db->insert($table,$data);
		//echo $this->db->last_query();die();
		return $this->db->insert_id();
	}
	
	public function get_one_row($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	public function update_by_condition($table,$data,$condition)
	{
		$this->db->where($condition);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	public function delete_by_condition($table,$condition)
	{
		$this->db->where($condition);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	
	public function result_count($query)
	{
		$result=$this->db->query($query);
		return $result->num_rows();
	}
}