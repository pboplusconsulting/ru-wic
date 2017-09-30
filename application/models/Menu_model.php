<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model
{
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
	public function get_array_by_one_leftjoin_by_order($table,$select,$condition,$joinTable,$joinCondition,$column,$order)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->join($joinTable,$joinCondition,'LEFT');
		$this->db->where($condition);
		$this->db->order_by($column,$order);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	
	public function get_result_array($table,$select,$condition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	
	public function get_array_of_object($table,$select,$condition,$column,$order)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$this->db->order_by($column,$order);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
	}
	
	public function restaurant_list($table,$select,$condition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$this->db->order_by('restaurant_name','ASC');
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
	
	public function get_one_row_by_join($table,$select,$joinTable,$joinCondition,$condition)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->join($joinTable,$joinCondition,'LEFT');
		$this->db->where($condition);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	public function update_by_condition($table,$data,$condition)
	{
		$this->db->where($condition);
		$this->db->update($table,$data);//echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	public function delete_by_condition($table,$condition)
	{
		$this->db->where($condition);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	public function menu_list()
	{
		$this->db->select('menu_id,CONCAT(UCASE(LEFT(menu_name,1)),LCASE(SUBSTRING(menu_name,2))) as menu_name');
		$this->db->from('ru_menu');
		$this->db->where('menu_id!=0');
		$this->db->order_by('order_no','ASC');
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
	}
	public function sub_menu_list()
	{
		$this->db->select('sub_menu_id,menu_id,CONCAT(UCASE(LEFT(sub_menu_name,1)),LCASE(SUBSTRING(sub_menu_name,2))) as sub_menu_name');
		$this->db->from('ru_sub_menu');
		$this->db->where('sub_menu_id!=0');
		$this->db->order_by('order_no','ASC');
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result();
	}
	
	public function check_unique_excluding_itself($name,$menu_id)
	{
		$this->db->where(array('menu_id !='=>$menu_id,'menu_name'=>$name));
		$result=$this->db->get('ru_menu');
		return $result->num_rows();
	}
	
	public function get_row_by_query($query)
	{
		$result=$this->db->query($query);
		return $result->row();
	}
	public function get_search_meal_query($query)
	{
		$result=$this->db->query($query);
		return $result->result();
	}
	
	public function get_result_by_query($query)
	{
		$result=$this->db->query($query);
		return $result->result_array();
	}
	
	public function result_count($query)
	{
		$result=$this->db->query($query);
		return $result->num_rows();
	}
}