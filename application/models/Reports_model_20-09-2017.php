<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_model extends CI_Model
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

    public function relieved_table_booking_id($dateRange1='',$dateRange2='',$memeber_id='')
	{
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		
		$query="SELECT table_booking_id FROM ru_member_table_booking WHERE table_relieved_time BETWEEN '".$range1." 00:00:00' AND '".$range2." 23:59:59'";
		
		if ( $memeber_id !="" ){
            $query .= " AND member_id ='$memeber_id'";
         }
		// print_r($query);
		$result=$this->db->query($query);
		$relieved_arr=array();
		foreach($result->result_array() as $res)
		{
			$relieved_arr[]=$res['table_booking_id'];
		}
		//print_r($relieved_arr);
		return $relieved_arr;
	}
	
	public function average_service_time($relieved_arr)
    {
		$sql="SELECT (SUM(IFNULL(TIMESTAMPDIFF(SECOND, o.order_time, o.completed_time),0))/COUNT(o.table_order_id))/60 as average FROM `ru_table_wise_order` o WHERE o.table_booking_id IN (".$relieved_arr.") AND o.order_status=1";
        
        $result=$this->db->query($sql);
        //echo $this->db->last_query();die();
		if($result->num_rows()>0)
         return $result->row()->average;
	    else return 0;
    }
  
	  
	  /* Cash Query */
	  
	public function get_cash_total_amount($relieved_arr)
	{
			$sql="SELECT sum(final_amount) as amount FROM ru_order_bill WHERE (payment_method='Cash' or payment_method='') AND bill_status='1' AND table_booking_id IN (".$relieved_arr.")";	
			$res=$this->db->query($sql);
			return $res->row()->amount;
	}
		
		  /* Card Query */
	  
	public function get_card_total_amount($relieved_arr)
	{
			$sql="SELECT sum(final_amount) as amount FROM ru_order_bill WHERE payment_method='Card' AND bill_status='1' AND table_booking_id IN (".$relieved_arr.")";	
			$res=$this->db->query($sql);
			return $res->row()->amount;
		
	}
	  
	public function get_credit_total_amount($relieved_arr)
	{
			$sql="SELECT sum(final_amount) as amount FROM ru_order_bill WHERE payment_method='Credit' AND bill_status='1' AND table_booking_id IN (".$relieved_arr.")";	
			$res=$this->db->query($sql);
			return $res->row()->amount;
		
	} 
	  
	  	  /* Alcohol Query */
	  
	  public function get_alchol_total_amount($relieved_arr){
	  
			$sql="SELECT sum(final_amount) as amount FROM ru_order_bill WHERE product_category_id='2' AND bill_status='1' AND table_booking_id IN (".$relieved_arr.")";	
			$res=$this->db->query($sql);
			return $res->row()->amount;
		}
	  
	  /* Food total amount */
	   public function get_food_total_amount($relieved_arr)
	   {
			$sql="SELECT sum(final_amount) as amount FROM ru_order_bill WHERE product_category_id='1' AND bill_status='1' AND table_booking_id IN (".$relieved_arr.")";	
			$res=$this->db->query($sql);
			return $res->row()->amount;
		}
	  
	  
	    /* NUmber of tables booked */
	  
	    public function get_total_tables_booked($dateRange1='',$dateRange2='',$memeber_id=''){
	  
			if($dateRange1=='' || $dateRange2==''){
				$dateRange1=date('Y-m-d').' 00:00:00';
				$dateRange2=date('Y-m-d').' 23:59:59';
				$sql="SELECT IFNULL(SUM((CHAR_LENGTH(table_booking_no) - CHAR_LENGTH(REPLACE(table_booking_no, ',', '')) + 1)),0) as total_table FROM `ru_member_table_booking` WHERE (table_relieved_time BETWEEN '".$dateRange1."' AND '".$dateRange2."')";
				
				if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		
				$res=$this->db->query($sql);
			}
			else
			{
				$sql="SELECT IFNULL(SUM((CHAR_LENGTH(table_booking_no) - CHAR_LENGTH(REPLACE(table_booking_no, ',', '')) + 1)),0) as total_table FROM `ru_member_table_booking` WHERE table_relieved_time BETWEEN '".$dateRange1." 00:00:00' AND '".$dateRange2." 23:59:59'";
				
				if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		
				$res=$this->db->query($sql);
						
			}
			//echo $this->db->last_query();die();
			return $res->row()->total_table;
		}
	  
	  /* NUmber of guests */
	  
	   public function get_total_quests($dateRange1='',$dateRange2='',$memeber_id='')
	   {

		
		if($dateRange1=='' || $dateRange2==''){
				$range1=date('Y-m-d').' 00:00:00';
				$range2=date('Y-m-d').' 23:59:59';
			$sql="SELECT COUNT(DISTINCT(table_booking_id)) AS total FROM ru_member_table_booking WHERE table_relieved_time>='".$range1."' AND table_relieved_time<='".$range2."'";
			if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		
			$res=$this->db->query($sql);
			return $res->row()->total;
		}
		else
		{

			$sql="SELECT COUNT(DISTINCT(table_booking_id)) AS total FROM ru_member_table_booking WHERE table_relieved_time>='".$dateRange1." 00:00:00' AND table_relieved_time<='".$dateRange2." 23:59:59'";
			$res=$this->db->query($sql);
			if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		     $res=$this->db->query($sql);
			return $res->row()->total;		
		}
	  
	   }
	   
	   /* NUmber of guests */
	  
	   public function get_total_tables($dateRange1='',$dateRange2='',$memeber_id=''){
	  
		if($dateRange1=='' || $dateRange2==''){
				$range1=date('Y-m-d').' 00:00:00';
				$range2=date('Y-m-d').' 23:59:59';
			$sql="SELECT SUM(no_of_guest) as total FROM `ru_member_table_booking` WHERE booking_time BETWEEN '".$range1."' AND '".$range2."'";
			if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		
			$res=$this->db->query($sql);
			return $res->row()->total;
		}else{
			$sql="SELECT SUM(no_of_guest) as total FROM `ru_member_table_booking` WHERE booking_time  BETWEEN '".$dateRange1." 00:00:00' AND '".$dateRange2." 23:59:59'";
			$res=$this->db->query($sql);
			if ( $memeber_id !="" ){
				$sql .= " AND member_id ='$memeber_id'";
				}
		
			return $res->row()->total;		
		}
	  
	   }
	   
	   /* FeebbACK */
	   
	   
	    public function get_overall_feedback($relieved_arr,$type){
	  
			    $sql=" SELECT count(*) as total FROM ru_feedback WHERE feedback_10='".$type."' AND cancel_reason='' AND table_booking_id IN (".$relieved_arr.")";
			    $res=$this->db->query($sql);
			    return $res->row()->total;
	   }
	   
	   /*Service Delay Cases*/
	    public function get_delay_cases($relieved_arr){
			
			$sql="SELECT COUNT(*) AS num_of_delay FROM ru_table_wise_order o INNER JOIN ru_meal m ON m.meal_id=o.meal_id WHERE o.order_status=1 AND o.table_booking_id IN (".$relieved_arr.") AND IFNULL(TIMESTAMPDIFF(Minute, o.order_time, o.completed_time),0) > m.meal_prepration_time";
			$result=$this->db->query($sql);
			//echo $this->db->last_query();die();
			return $result->row()->num_of_delay;
		
		}
		 
		 
		 /* All members query*/
		 public function get_member_orders($dateRange1='',$dateRange2='',$memeber_id=''){
			 
			if($dateRange1=='' || $dateRange2==''){
			
				$range1=date('Y-m-d').' 00:00:00';
				$range2=date('Y-m-d').' 23:59:59';
				$sql="SELECT m.id,m.membership_id,m.member_name,u.name as waiter_name,mt.no_of_guest,mt.booking_time,mt.table_booking_id,mt.cancel_reason,mt.member_status,fd.feedback_10,fd.text_feed_10,fd.cancel_reason AS feedback_cancel_reason,IFNULL(TIMESTAMPDIFF(MINUTE, mt.booking_time, mt.table_relieved_time),0) AS time_spent FROM `ru_member_table_booking` mt  INNER JOIN  `ru_membership` m ON m.id=mt.member_id INNER JOIN ru_users u ON u.user_id=mt.waiter_id LEFT JOIN ru_feedback fd ON mt.table_booking_id=fd.table_booking_id WHERE table_relieved_time BETWEEN '".$range1."' AND '".$range2."'";
				
				if ( $memeber_id !="" )
				{
				$sql .= " AND id ='$memeber_id'";
				}
				
				$sql .=" GROUP BY table_booking_id ORDER BY table_relieved_time ASC";
		
				//print($sql);
				$res=$this->db->query($sql);

			}
			else
			{
				$sql="SELECT m.id,m.membership_id,m.member_name,u.name as waiter_name,mt.no_of_guest,mt.booking_time,mt.table_booking_id,mt.cancel_reason,mt.member_status,fd.feedback_10,fd.text_feed_10,fd.cancel_reason AS feedback_cancel_reason,IFNULL(TIMESTAMPDIFF(MINUTE, mt.booking_time, mt.table_relieved_time),0) AS time_spent FROM `ru_member_table_booking` mt  INNER JOIN  `ru_membership` m ON m.id=mt.member_id INNER JOIN ru_users u ON u.user_id=mt.waiter_id LEFT JOIN ru_feedback fd ON mt.table_booking_id=fd.table_booking_id  WHERE table_relieved_time BETWEEN '".$dateRange1." 00:00:00' AND '".$dateRange2." 23:59:59'";

                if ( $memeber_id !="" )
				{
				$sql .= " AND id ='$memeber_id'";
				}
				
				$sql .=" GROUP BY table_booking_id ORDER BY table_relieved_time ASC";
				//print($sql);
		
				$res=$this->db->query($sql);
			    
			}
			//echo $sql;die();
            return $res->result();
		 }
		 
		 /*  Main Menu Query*/
		 
		public function get_member_mainmenu($dateRange1='',$dateRange2='',$table_booking_id)
		{
		    
			$sql="SELECT * FROM `ru_menu` menu INNER JOIN ru_meal meal ON meal.menu_id=menu.menu_id INNER JOIN ru_table_wise_order o ON o.meal_id=meal.meal_id AND o.table_booking_id='".$table_booking_id."' GROUP BY menu.menu_id"; 
		    $res=$this->db->query($sql);
		    return $res->result();
		}
		
	    public function get_member_submenu($dateRange1='',$dateRange2='',$table_booking_id,$main_menu_id)
		{
			$sql="SELECT * FROM ru_meal meal INNER JOIN ru_table_wise_order o ON o.meal_id=meal.meal_id AND o.table_booking_id='".$table_booking_id."' AND meal.menu_id='".$main_menu_id."'";
			$res=$this->db->query($sql);
		    return $res->result();
		}
		
		public function get_feedback_order($dateRange1='',$dateRange2='',$table_booking_id) 
		{	  
	 		$sql="SELECT feedback_10 FROM ru_feedback WHERE table_booking_id='".$table_booking_id."'";
			
			$res=$this->db->query($sql);
			if($res->row()->feedback_10==0){
				return '';	
			}
			if($res->row()->feedback_10==1){
				return '';		
			}
			if($res->row()->feedback_10==2){
				return '';		
			}
		}
		
		public function get_bill_data($dateRange1='',$dateRange2='',$table_booking_id)
		{
			$sql="SELECT SUM(amount) as amount,SUM(discount) as discount,SUM(tax) as tax,SUM(final_amount) as final_amount FROM ru_order_bill a WHERE a.table_booking_id=".$table_booking_id;
			  
            $res=$this->db->query($sql);
		    return $res->row();
		}
}