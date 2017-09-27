<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bar_tendor_model extends CI_Model
{
	public function return_num_rows($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		return $result->num_rows();
	}
	
	public function get_by_group($table,$condition,$grpClm,$select='*')
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$this->db->group_by($grpClm);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	public function get_by_condition($table,$condition,$select)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		//$this->db->group_by($grpClm);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	public function get_category_data($condition)
	{
		$this->db->where($condition);
		$result=$this->db->get('ru_product_category');
			return $result->row();
	}
	 
	public function get_by_query($query)
	{
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	public function get_by_query_return_row($query)
	{
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	public function order_and_result_array($table,$condition,$select,$column,$order)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($condition);
		$this->db->order_by($column,$order);
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	public function leftjoin_orderby_and_result_array($table,$condition,$select,$joinTable,$joinCondition,$column,$order)
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
	
	public function insert_one_row($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	public function update_by_condition($table,$data,$condition)
	{
		$this->db->where($condition);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	
	public function update_by_wherein($table,$data,$where,$in)
	{
		$this->db->where_in($where,$in);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	
	public function get_order_data($table_booking_id)
	{
		$this->db->select('a.*,b.meal_name,b.meal_image,b.meal_prepration_time');
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where(array('a.table_booking_id'=>$table_booking_id));
		$this->db->order_by('a.order_time','DESC');
		$result=$this->db->get();
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	
	
	
	public function no_of_dalay_order($table_booking_id)
	{   
	    $this->db->from('ru_table_wise_order a');
	    $this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=2 AND UNIX_TIMESTAMP(a.order_time)+(b.meal_prepration_time*60) <".time());
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_unread_oreder($table_booking_id)
	{
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where(array('a.table_booking_id'=>$table_booking_id,'a.is_read'=>0));
		$result=$this->db->get('ru_table_wise_order');
		return $result->num_rows();
	}
	public function total_orders($table_booking_id)
	{
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.status=1");
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function get_last_order_time($table_booking_id)
	{
		$this->db->select('order_time');
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.status=1");
		$result=$this->db->get();
		return $result->row();
	}
	public function no_of_complete_order($table_booking_id)
	{
		
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=1");
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_cancel_order($table_booking_id)
	{
		
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=3");
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_pending_order($table_booking_id)
	{
		$this->db->from('ru_table_wise_order a');
		//$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		//$this->db->join('ru_menu c','b.menu_id=c.menu_id');
		//$this->db->join('ru_product_category d','c.product_category_id=d.product_category_id AND (d.category_name="alcohol" OR d.category_name="beverages")');
		$this->db->where(array('a.table_booking_id'=>$table_booking_id,'a.status'=>1,'a.order_status'=>2));
		$result=$this->db->get();
		return $result->num_rows();
	}
}