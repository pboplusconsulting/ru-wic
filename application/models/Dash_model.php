<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dash_model extends CI_Model
{
	public function return_num_rows($table,$condition)
	{
		$result=$this->db->get_where($table,$condition);
		return $result->num_rows();
	}
	
	public function return_query_num_rows($sql)
	{
		$result=$this->db->query($sql);
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
		$this->db->where(array('a.table_booking_id'=>$table_booking_id));
		$this->db->order_by('a.order_time','DESC');
		$result=$this->db->get();
		return $result->result_array();
	}
	
	/*********************************About Member******************************************/
	public function fevourite_meal($member_id)
	{
        $sql="SELECT b.meal_id,c.meal_name,COUNT(b.meal_id) AS cont FROM ru_member_table_booking a JOIN ru_table_wise_order b ON a.table_booking_id=b.table_booking_id JOIN ru_meal c ON b.meal_id=c.meal_id WHERE a.member_id=".$member_id." GROUP BY b.meal_id ORDER BY cont DESC LIMIT 5";
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	public function last_meal($member_id){
		/*$sql="SELECT DISTINCT(c.meal_id),c.meal_name FROM ru_member_table_booking a JOIN ru_table_wise_order b ON a.table_booking_id=b.table_booking_id JOIN ru_meal c ON b.meal_id=c.meal_id WHERE a.booking_time<'".date('Y-m-d')." 00:00:00' AND a.member_id=".$member_id." ORDER BY b.order_time DESC LIMIT 5";*/
		$sql="SELECT DISTINCT(a.meal_id),c.meal_name FROM ru_table_wise_order a JOIN ru_meal c ON a.meal_id=c.meal_id WHERE table_booking_id=(SELECT b.table_booking_id FROM ru_member_table_booking b WHERE b.member_id=".$member_id." AND b.table_status=0 ORDER BY b.table_booking_id DESC LIMIT 1) LIMIT 5";
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	public function average_billing($member_id)
	{
		$sql="SELECT COUNT(order_bill_id) AS attended,SUM(final_amount) AS total_bill FROM ru_order_bill WHERE member_id=".$member_id;
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	public function last_bill($member_id)
	{
		$sql="SELECT * FROM ru_order_bill a WHERE table_booking_id=(SELECT b.table_booking_id FROM ru_member_table_booking b WHERE b.member_id=".$member_id." AND b.table_status=0 ORDER BY b.table_booking_id DESC LIMIT 1) LIMIT 1";
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	
	public function table_prefered($member_id)
	{
		$sql="SELECT b.id,b.table_name,COUNT(b.id) AS occurence FROM ru_member_table_booking a JOIN ru_tables b ON FIND_IN_SET(b.id,a.table_booking_no) WHERE a.member_id=".$member_id." GROUP BY b.id ORDER BY occurence DESC,b.table_name ASC LIMIT 5";
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	public function preferences($member_id)
	{
		$sql="SELECT c.menu_id,d.menu_name,COUNT(c.menu_id) AS cont FROM ru_member_table_booking a JOIN ru_table_wise_order b ON a.table_booking_id=b.table_booking_id JOIN ru_meal c ON b.meal_id=c.meal_id JOIN ru_menu d ON c.menu_id=d.menu_id WHERE a.member_id=".$member_id." GROUP BY c.menu_id ORDER BY cont DESC LIMIT 5";
		$result=$this->db->query($sql);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	/************************************************end about member****************************************/
	
	
	public function no_of_dalay_order($table_booking_id)
	{
		
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=2 AND UNIX_TIMESTAMP(a.order_time)+(b.meal_prepration_time*60) <".time());
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_unread_oreder($table_booking_id)
	{
		$this->db->where(array('table_booking_id'=>$table_booking_id,'is_read'=>0));
		$result=$this->db->get('ru_table_wise_order');
		return $result->num_rows();
	}
	public function total_orders($table_booking_id)
	{
		$this->db->where(array('table_booking_id'=>$table_booking_id,'status'=>1));
		$result=$this->db->get('ru_table_wise_order');
		return $result->num_rows();
	}
	public function get_last_order_time($table_booking_id)
	{
		return $this->db->select('order_time')
                  ->get_where('ru_table_wise_order', array('table_booking_id'=>$table_booking_id,'status'=>1))
                  ->row();
	}
	public function no_of_complete_order($table_booking_id)
	{
		
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=1");
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_cancel_order($table_booking_id)
	{
		
		$this->db->from('ru_table_wise_order a');
		$this->db->join('ru_meal b','a.meal_id=b.meal_id');
		$this->db->where("a.table_booking_id=".$table_booking_id." AND a.order_status=3");
		$result=$this->db->get();
		return $result->num_rows();
	}
	public function no_of_pending_order($table_booking_id)
	{
				$this->db->where(array('table_booking_id'=>$table_booking_id,'status'=>1,'order_status'=>2));
		$result=$this->db->get('ru_table_wise_order');
		return $result->num_rows();
	}
	public function isBillPaid($table_booking_id)
	{
		$query="SELECT * FROM ru_order_bill WHERE table_booking_id=".$table_booking_id." AND bill_status=1";
		
		$result=$this->db->query($query);
		//echo $this->db->last_query();
		return $result->num_rows();
	}
	
	public function number_of_bills($table_booking_id)
	{
		$query="SELECT c.product_category_id FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id WHERE a.table_booking_id=".$table_booking_id." AND a.order_status!=3 GROUP BY c.product_category_id";
		
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		
		$result=$result->result_array();
		$billCount=0;
		$ifStatus=0;$elseStatus=0;
		foreach($result as $res)
		{
			if($res['product_category_id']==2)
            {	
		        if($ifStatus) continue;
        		$billCount++;
				$ifStatus++;
			}
            else
            {
				if($elseStatus) continue;
				$billCount++;
				$elseStatus++;
			}				
		}
		return $billCount;
	}
	public function check_bill_status($table_booking_id)
	{
		$query="SELECT (SELECT count(order_bill_id) FROM ru_order_bill WHERE table_booking_id=".$table_booking_id." AND product_category_id IN (1,2)) AS generated_bills,(SELECT count(order_bill_id) FROM ru_order_bill WHERE table_booking_id=".$table_booking_id." AND bill_status=0) AS no_of_unpaid";
		
		$result=$this->db->query($query);
		//echo $this->db->last_query();
		return $result->row();
	}
	
	
	public function check_new_alcohol_order_bill($table_booking_id)
	{
		$query="SELECT COUNT(*) AS without_bill_alcohol_order FROM ru_table_wise_order a JOIN ru_order_bill b ON a.table_booking_id=b.table_booking_id JOIN ru_meal c ON a.meal_id=c.meal_id JOIN ru_menu d ON c.menu_id=d.menu_id WHERE a.table_booking_id=".$table_booking_id." AND b.product_category_id=2 AND d.product_category_id =2 AND a.completed_time>=b.bill_generation_time";
		$result=$this->db->query($query);
		return $result->row()->without_bill_alcohol_order;
	}
	public function check_new_meal_order_bill($table_booking_id)
	{
		$query="SELECT COUNT(*) AS without_bill_meal_order FROM ru_table_wise_order a JOIN ru_order_bill b ON a.table_booking_id=b.table_booking_id JOIN ru_meal c ON a.meal_id=c.meal_id JOIN ru_menu d ON c.menu_id=d.menu_id WHERE a.table_booking_id=".$table_booking_id." AND b.product_category_id=1 AND d.product_category_id IN (1,3,4) AND a.completed_time>=b.bill_generation_time";
		$result=$this->db->query($query);
		return $result->row()->without_bill_meal_order;
	}
}