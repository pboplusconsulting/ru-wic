<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Analysis_model extends CI_Model
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


     /*************************** Min and Max billing *******************************/
    public function min_max_billing($dateRange1='',$dateRange2='')
    { 
	    $range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		/*
		if($dateRange1 && $dateRange2)
		{	
	        $range1=$dateRange1;
		    $range2=$dateRange2;
		    $sql="SELECT MAX(a.final_amount) as max_billing, MIN(a.final_amount) as min_billing FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id AND b.table_relieved_time BETWEEN '".$range1." 00:00:00' AND '".$range2." 23:59:59' ";
		}
        else
        {
			 $sql="SELECT MAX(a.final_amount) as max_billing, MIN(a.final_amount) as min_billing FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id AND b.member_status=4";
		}	*/
        if($dateRange1 && $dateRange2)
		{	
	        $range1=$dateRange1;
		    $range2=$dateRange2;
		    $sql="SELECT MAX(result.final_amount) as max_billing, MIN(result.final_amount) as min_billing FROM (SELECT SUM(a.final_amount) AS final_amount FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id WHERE b.table_relieved_time BETWEEN '".$range1." 00:00:00' AND '".$range2." 23:59:59' GROUP BY a.table_booking_id) AS result";
		}
        else
        {
			 $sql="SELECT MAX(result.final_amount) as max_billing, MIN(result.final_amount) as min_billing FROM (SELECT SUM(a.final_amount) AS final_amount FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id WHERE b.member_status=4 GROUP BY a.table_booking_id) AS result";
		}		
        $result=$this->db->query($sql);
        return $result->row();
    }

    /***************************** Average billing ************************************/
    public function average_billing($dateRange1='',$dateRange2='')
    {
		//$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		//$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		
		if($dateRange1 && $dateRange2)
		{	
	        $range1=$dateRange1;
		    $range2=$dateRange2;
		    $sql="SELECT SUM(result.final_amount)/COUNT(result.table_booking_id) as average FROM (SELECT a.table_booking_id,SUM(a.final_amount) AS final_amount FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id WHERE b.table_relieved_time BETWEEN '".$range1." 00:00:00' AND '".$range2." 23:59:59' GROUP BY a.table_booking_id) AS result";
		}
		else
		{
			$sql="SELECT SUM(result.final_amount)/COUNT(result.table_booking_id) as average FROM (SELECT a.table_booking_id,SUM(a.final_amount) AS final_amount FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id WHERE b.member_status=4 GROUP BY a.table_booking_id) AS result";
		}	
        $result=$this->db->query($sql);
        return $result->row();
    }

    /***************************** Todays Billing ************************************/
    public function today_billing()
    {
       $sql="SELECT SUM(a.final_amount) as todays_billing FROM ru_order_bill a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id WHERE DATE(b.table_relieved_time) = CURDATE()";
       $result=$this->db->query($sql);
        return $result->row();
    }


    /**************************************** Menu ************************************/
    public function menu($dateRange1='',$dateRange2='')
    {
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
        $sql="SELECT a.menu_name,a.menu_id,IFNULL((SELECT SUM(quantity) AS quantity FROM ru_table_wise_order b JOIN ru_meal c ON b.meal_id=c.meal_id JOIN ru_member_table_booking d ON b.table_booking_id=d.table_booking_id WHERE c.menu_id=a.menu_id AND d.table_relieved_time>='".$range1." 00:00:00' AND d.table_relieved_time<='".$range2." 23:59:59' GROUP BY c.menu_id),0) AS sold_meal_count FROM ru_menu a";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
  
    /************************************ Hot Selling Dishes of Day ****************************/
    public function hot_selling_dishes($dateRange1='',$dateRange2='')
    {
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
        $sql="SELECT o.meal_id as Meal, m.meal_name as MealName, SUM(o.quantity) as total_quantity,(SUM(o.quantity)* m.meal_price) as total_price,menu.menu_name AS menuName FROM `ru_table_wise_order` o INNER JOIN `ru_meal` m ON m.meal_id=o.meal_id INNER JOIN ru_menu menu on menu.menu_id=m.menu_id JOIN ru_member_table_booking d ON o.table_booking_id=d.table_booking_id WHERE d.table_relieved_time>='".$range1." 00:00:00' AND d.table_relieved_time<='".$range2." 23:59:59' GROUP BY o.meal_id ORDER BY total_quantity DESC,total_price DESC LIMIT 0,4";
        $result=$this->db->query($sql);
        //echo $this->db->last_query();die();
        return $result->result_array();
    }
  
    /************************************ Average Serve Time Per Dish *******************************/
	/*
    public function average_serve_time_per_dish($dateRange1='',$dateRange2='')
    {
		$range1=empty($dateRange1)?date('Y-m-d').' 00:00:00':$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d').' 23:59:59':$dateRange2;
        $sql="SELECT COUNT(o.meal_id) as total_meals, o.order_time, o.completed_time ,m.meal_prepration_time,SUM( TIMESTAMPDIFF(MINUTE, o.order_time, o.completed_time) ) as completion_time,m.meal_name,m.meal_id,IFNULL(SUM( TIMESTAMPDIFF(MINUTE, o.order_time, o.completed_time) )/COUNT(o.meal_id),0) as average FROM `ru_table_wise_order` o INNER JOIN ru_meal m ON m.meal_id=o.meal_id WHERE o.order_time>='".$range1."' AND o.order_time<='".$range2."' AND o.order_status=1 GROUP BY o.meal_id ORDER BY `m`.`meal_name` ASC";
        $result=$this->db->query($sql);
        return $result->result_array();
    } */
	public function average_serve_time($range1='',$range2='')
	{
		$dateRange1=empty($range1)?date('Y-m-d'):date('Y-m-d',strtotime($range1));
		$dateRange2=empty($range2)?date('Y-m-d'):date('Y-m-d',strtotime($range2));
		$serveTime=array();$i=0;
		if($range1 && $range2)
		{
            while($dateRange1 <= $dateRange2)
            {				
			   $sql="SELECT (SUM(IFNULL(TIMESTAMPDIFF(SECOND, o.order_time, o.completed_time),0))/COUNT(o.table_order_id))/60 as average FROM ru_table_wise_order o JOIN ru_member_table_booking d ON o.table_booking_id=d.table_booking_id WHERE d.table_relieved_time>='".$dateRange1." 00:00:00' AND d.table_relieved_time<='".$dateRange2." 23:59:59' AND o.order_status=1";
			   $result=$this->db->query($sql)->row();
			   
			   	$serveTime[$i]['date']=$dateRange1;
                $serveTime[$i]['average']=$result!=null?$result->average:0;
				$i++;
				$dateRange1=date('Y-m-d',strtotime($dateRange1.'+1 day'));
			}
        }
        else
        {
			 $sql="SELECT (SUM(IFNULL(TIMESTAMPDIFF(SECOND, o.order_time, o.completed_time),0))/COUNT(o.table_order_id))/60 as average FROM ru_table_wise_order o JOIN ru_member_table_booking d ON o.table_booking_id=d.table_booking_id WHERE d.table_relieved_time>='".$dateRange2." 00:00:00' AND d.table_relieved_time<='".$dateRange2." 23:59:59' AND o.order_status=1";
			$result=$this->db->query($sql)->row();
			$serveTime[$i]['date']=$dateRange1;
            $serveTime[$i]['average']=$result!=null?$result->average:0;
		}			
		return $serveTime;
	}
  
    public function feedback($dateRange1='',$dateRange2='')
	{
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		$sql="SELECT (SUM(feedback_1)/COUNT(*)) AS avg1,(SUM(feedback_2)/COUNT(*)) AS avg2,(SUM(feedback_3)/COUNT(*)) AS avg3,(SUM(feedback_4)/COUNT(*)) AS avg4,(SUM(feedback_5)/COUNT(*)) AS avg5,(SUM(feedback_6)/COUNT(*)) AS avg6,(SUM(feedback_7)/COUNT(*)) AS avg7,(SUM(feedback_8)/COUNT(*)) AS avg8,(SUM(feedback_9)/COUNT(*)) AS avg9,(SUM(feedback_10)/COUNT(*)) AS avg10 FROM ru_feedback WHERE cancel_reason='' AND feedback_generation_time>='".$range1." 00:00:00' AND feedback_generation_time<='".$range2." 23:59:59'";
        $result=$this->db->query($sql);
        return $result->row();
	}
	
	public function staff()
	{
		$sql="SELECT (SELECT COUNT(*) FROM ru_users WHERE status=1) AS total_staff,(SELECT COUNT(*) FROM ru_users WHERE status=1 AND is_logged_in=1) AS available_staff";
		 $result=$this->db->query($sql);
        return $result->row();
	}
    /*
	public function no_of_guest_served($dateRange1='',$dateRange2='')
	{
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		$sql="(SELECT COUNT(DISTINCT(a.table_booking_id)) AS no_of_guest_served FROM ru_member_table_booking a JOIN ru_table_wise_order b ON a.table_booking_id=b.table_booking_id AND b.completed_time>='".$range1." 00:00:00' AND b.completed_time<='".$range2." 23:59:59') UNION (SELECT COUNT(*) AS no_of_guest_served FROM ru_member_table_booking WHERE table_relieved_time>='".$range1." 00:00:00' AND table_relieved_time<='".$range2." 23:59:59')";
		$result=$this->db->query($sql);
        return $result->row();
	}*/

	public function no_of_guest_served($dateRange1='',$dateRange2='')
	{
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		$sql="SELECT COUNT(DISTINCT(table_booking_id)) AS no_of_guest_served FROM ru_member_table_booking WHERE table_relieved_time>='".$range1." 00:00:00' AND table_relieved_time<='".$range2." 23:59:59'";
		$result=$this->db->query($sql);
        return $result->row();
	}
	
	
	public function relevant_occupancy($dateRange1='',$dateRange2='')
	{
		$range1=empty($dateRange1)?date('Y-m-d'):$dateRange1;
		$range2=empty($dateRange2)?date('Y-m-d'):$dateRange2;
		$sql="SELECT (((SELECT SUM(no_of_guest) AS no_of_guest FROM ru_member_table_booking WHERE member_status!=4 AND table_status=1)/52)*100) AS relevant_occupancy";
		 $result=$this->db->query($sql);
        return $result->row();
	}
  
}