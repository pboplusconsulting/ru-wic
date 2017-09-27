<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chef extends CI_Controller {

	/**
     **Constructor
	 */
	function __construct()
    {
        parent::__construct();
		$this->load->helper('security');
         if(!isset($_SESSION['isLogin']))
        redirect('Login');
	    
	    if(!$this->Base_model->is_user_valid())
		{
			$this->session->sess_destroy();
			//$this->session->set_flashdata('flashError','<b>Force Logout!</b> Your session has been expired.');
			redirect('Login');
		}	
			
	    $this->load->model('Chef_model');
		if($this->session->userdata('userRole')==3 || $this->session->userdata('userRole')==5 || $this->session->userdata('userRole')==6)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}	
    }
	
	
	public function index()
	{//echo "<pre>";print_r($_SESSION);echo "</pre>";
		if(isset($_POST['complete_order_status']))
		{
			$completeOrders=$this->input->post('tableorder');
			if(count($completeOrders))
            {
				$notificationToUsers=$this->Chef_model->get_by_query("SELECT user_id FROM ru_users WHERE role!=4 AND status=1");
				$table_booking_id='';
				foreach($completeOrders as $order_id)
				{
					$query="SELECT a.*,b.waiter_id,c.table_name,d.meal_name FROM ru_table_wise_order a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_tables c ON b.table_booking_no=c.id JOIN ru_meal d ON a.meal_id=d.meal_id WHERE table_order_id=".$order_id;
					$orderData=$this->Chef_model->get_by_query_return_row($query);
			        $updateStatus=$this->Chef_model->update_by_condition('ru_table_wise_order',array('order_status'=>1,'completed_time'=>date('Y-m-d H:i:s'),'modify_time'=>date('Y-m-d H:i:s')),array('table_order_id'=>$order_id));
					if($updateStatus)
					{
						$message="<b>".$orderData->meal_name."</b> is ready to serve on table <b>".$orderData->table_name."</b>";
						//echo $message;die();
						/*****************send notification for refresh each user screen*********************/
						$notificationData1=array(
													'from_user_id'=>$this->session->userdata('userID'),
													'to_user_id'=>0,//Here 0=>every user get refresh notification
													'message'=>$message,
													'module_id'=>$order_id,
													'module_type'=>'ru_table_wise_order',
													'notification_type'=>0,
													'is_read'=>0,
													'created'=>date('Y-m-d H:i:s'),
													'updated'=>date('Y-m-d H:i:s')
													);
						$this->Chef_model->insert_one_row('ru_notifications',$notificationData1);
						/*****************End send notification for refresh each user screen*********************/
						foreach($notificationToUsers as $notificationToUser)
						{
							$notificationData=array(
													'from_user_id'=>$this->session->userdata('userID'),
													'to_user_id'=>$notificationToUser['user_id'],
													'message'=>$message,
													'module_id'=>$order_id,
													'module_type'=>'ru_table_wise_order',
													'notification_type'=>0,
													'is_read'=>0,
													'created'=>date('Y-m-d H:i:s'),
													'updated'=>date('Y-m-d H:i:s')
													);
							$insertid=$this->Chef_model->insert_one_row('ru_notifications',$notificationData);
						}	
						
					}
                    $table_booking_id=	$orderData->table_booking_id;				
				}
				
				if(!empty($table_booking_id))
				{	
				    $pendingOrders=$this->Chef_model->no_of_pending_order($table_booking_id);
					if($pendingOrders==0)
					{	
				         $updateTableStatus=$this->Chef_model->update_by_condition('ru_member_table_booking',array('member_status'=>3,'modify_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id));
					}
				}	
				
			}
            redirect('chef');			
		}
        else
        {			
            $query="SELECT a.*,b.member_name,GROUP_CONCAT(c.table_name) AS table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id  JOIN ru_tables c ON FIND_IN_SET(c.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00-00-00' AND a.booking_time<='".date('Y-m-d')." 23-59-59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC";
			
			
			/***********fetch all member and orders *******************************
			"SELECT a.*,b.member_name,c.table_name,orders.meal_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id LEFT JOIN (SELECT xx.table_booking_id,GROUP_CONCAT(xx.meal_name SEPARATOR ';') AS meal_name FROM (SELECT d.table_booking_id,d.guest_seat_no, GROUP_CONCAT(m.meal_name SEPARATOR ',') AS meal_name FROM ru_table_wise_order d JOIN ru_meal m ON d.meal_id=m.meal_id WHERE d.table_booking_id=9 AND d.order_time>'2017-05-26 00-00-00' GROUP BY d.table_booking_id,d.guest_seat_no) AS xx GROUP BY xx.table_booking_id) AS orders ON orders.table_booking_id=a.table_booking_id WHERE a.booking_time>='2017-05-26 00-00-00' AND a.status=1"
			************************************end*********************************/
			
			$result=$this->Chef_model->get_by_query($query);
			
			//$query2="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.booking_time>'".date('Y-m-d')." 00:00:00' AND b.table_status=1),1,0) AS booking_status,(SELECT COUNT(*) FROM ru_member_table_booking c JOIN ru_table_wise_order d ON c.table_booking_id=d.table_booking_id WHERE a.id=d.table_id AND c.booking_time>'".date('Y-m-d')." 00:00:00' AND c.table_status=1 GROUP BY d.table_booking_id) AS no_of_orders,(SELECT COUNT(*) FROM ru_member_table_booking c JOIN ru_table_wise_order d ON c.table_booking_id=d.table_booking_id AND d.order_status=1 WHERE a.id=d.table_id AND c.booking_time>'".date('Y-m-d')." 00:00:00' AND c.table_status=1 GROUP BY d.table_booking_id) AS complete_orders FROM ru_tables a";
			
			$query2="SELECT a.id,a.table_name,@booking_id:=(SELECT table_booking_id FROM ru_member_table_booking WHERE FIND_IN_SET(a.id,table_booking_no) AND status=1 AND table_status=1) AS booking_id,@no_of_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id) AS no_of_orders,@complete_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id AND order_status=1) AS complete_orders,@cancel_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id AND order_status=3) AS cancel_orders,@unread_order_notification:=(SELECT COUNT(*) FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND a.module_type='ru_table_wise_order' WHERE b.table_booking_id=@booking_id AND a.to_user_id=".$this->session->userdata('userID')." AND a.is_read=0) AS unread_order_notification,IF(@booking_id,1,0) AS booking_status FROM ru_tables a WHERE a.status=1 AND a.table_name!='Parcel'";
			
			$tableStatus=$this->Chef_model->get_by_query($query2);
			//print_r($tableStatus);die();
			$heading['heading']="Dashboard";
			$dashboardData['data']=$result;
			$dashboardData['tableStatus']=$tableStatus;
			$this->load->view('header',$heading);
		    $this->load->view('chef/chef_dashboard',$dashboardData);
		    $this->load->view('footer');
		}	
	}
	
	
	
	
	public function search_member()
	{
		$search_string =$this->input->post('search');
		//$query="SELECT a.*,b.* FROM ru_membership a LEFT JOIN ru_member_table_booking b ON a.id=b.member_id WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1";
		
		/*$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.booking_time>='".date('Y-m-d')." 00:00:00') AS booking_status,(SELECT d.table_name FROM ru_member_table_booking c JOIN ru_tables d ON d.id=c.table_booking_no WHERE c.member_id=a.id AND c.booking_time>='".date('Y-m-d')." 00:00:00') AS table_no FROM ru_membership a WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1 ORDER BY a.member_name";*/
		
		/*$query="SELECT a.*,@booking_status:=(SELECT b.table_booking_id FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.booking_time>='".date('Y-m-d')." 00:00:00' AND b.status=1) AS booking_status FROM ru_membership a LEFT JOIN ru_member_table_booking c ON (c.table_booking_id=@booking_status) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1 ORDER BY a.member_name";*/
		if(!empty($search_string))
		{
			$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.booking_time>='".date('Y-m-d')." 00:00:00' AND b.status=1 AND b.table_status=1) AS booking_status,c.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,c.no_of_guest,c.booking_time,c.member_status,c.remark FROM ru_membership a LEFT JOIN ru_member_table_booking c ON c.member_id=a.id AND c.booking_time>'".date('Y-m-d')." 00:00:00' AND c.status=1 AND c.table_status=1 LEFT JOIN ru_tables r ON FIND_IN_SET(r.id,c.table_booking_no) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1 GROUP BY a.id ORDER BY a.member_name";
		
			$result=$this->Chef_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			//echo "<pre>";print_r($result);echo "</pre>";die();
			//$availableTables=$this->Chef_model->leftjoin_orderby_and_result_array('ru_tables a','a.status=1 AND b.booking_timeb.table_status=0 ','a.id,a.table_name','ru_table_wise_booking b','a.id=b.table_booking_no','table_name','ASC')
			
			//$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.table_booking_no=a.id AND b.table_status=1 AND b.booking_time>'".date('Y-m-d')." 00:00:00' AND b.status=1),1,0) AS table_status from ru_tables a";
			//$availableTables=$this->Chef_model->get_by_query($sql);
			//print_r($availableTables);die();
			$searchData['data']=$result;
			//$searchData['availableTables']=$availableTables;
			$html=$this->load->view('chef/search_html',$searchData,true);
			echo $html;
		}
        else
        {
			$query="SELECT b.*,1 AS booking_status,a.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,a.no_of_guest,a.booking_time,a.member_status,a.remark FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables r ON FIND_IN_SET(r.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00:00:00' AND a.booking_time <='".date('Y-m-d')." 23:59:59' AND a.status=1) OR (a.status=1 AND a.table_status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC";
			
			
			$result=$this->Chef_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";
			$searchData['data']=$result;
			//$searchData['availableTables']=$availableTables;
			$html=$this->load->view('chef/search_html',$searchData,true);
			echo $html;
		}			
	}
	/****************************************end search function*******************************************/
	
	
	
	/*
	
	public function change_order_status()
	{//print_r($_POST);die();
		if(isset($_POST['action']) && $_POST['action']=='order-start')
		{	
			$table_order_id=$this->input->post('table_order_id');
			$orderData=$this->Chef_model->get_by_query_return_row("SELECT * FROM ru_table_wise_order WHERE table_order_id=".$table_order_id);
			if($orderData!=null && $orderData->order_status==0)
			{	
			   $updateStatus=$this->Chef_model->update_by_condition('ru_table_wise_order',array('order_status'=>2,'modify_time'=>date('Y-m-d H:i:s')),array('table_order_id'=>$table_order_id));
			   echo 1;
			}   
			else 
			{
                echo 'invalid request';
			}
		}	
		else
		{
			echo 'invalid request';
		}	
	}
	*/
	
	
	public function order_comment()
	{
		if(isset($_POST['action']) && $_POST['action']=='ordercomment')
		{	
			$table_order_id=$this->input->post('order_id');
			$comment=$this->input->post('comment');
			$query="SELECT a.*,b.waiter_id,c.table_name,d.meal_name FROM ru_table_wise_order a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_tables c ON b.table_booking_no=c.id JOIN ru_meal d ON a.meal_id=d.meal_id WHERE table_order_id=".$table_order_id;
			$orderData=$this->Chef_model->get_by_query_return_row($query);
			
			if($orderData!=null)
			{
				$message=$comment;
				//echo $message;die();
				$notificationToUsers=$this->Chef_model->get_by_query("SELECT user_id FROM ru_users WHERE role!=4 AND status=1");
				foreach($notificationToUsers as $notificationToUser)
				{
					$notificationData=array(
											'from_user_id'=>$this->session->userdata('userID'),
											'to_user_id'=>$notificationToUser['user_id'],
											'message'=>$message,
											'module_id'=>$table_order_id,
											'module_type'=>'ru_table_wise_order',
											'notification_type'=>1,
											'is_read'=>0,
											'created'=>date('Y-m-d H:i:s'),
											'updated'=>date('Y-m-d H:i:s')
											);
					$insertid=$this->Chef_model->insert_one_row('ru_notifications',$notificationData);
				}	
				echo 1;
			}   
			else 
			{
                echo 'invalid request';
			}
		}	
		else
		{
			echo 'invalid request';
		}
	}
	
	public function update_order_status()
	{
		$table_booking_id=$this->input->post('table_booking_id');
		$resultAffected=$this->Chef_model->update_by_condition('ru_table_wise_order',array('is_read'=>1),array('table_booking_id'=>$table_booking_id));
        if($resultAffected>0)
		   echo 1;
	    else
			echo 0;
	}
	
	public function order_cancel(){
		if(isset($_POST['action']) && $_POST['action']=='ordercancel')
		{	
			$table_order_id=$this->input->post('order_id');
			$comment=$this->input->post('comment');
			$query="SELECT a.*,b.waiter_id,c.table_name,d.meal_name FROM ru_table_wise_order a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_tables c ON b.table_booking_no=c.id JOIN ru_meal d ON a.meal_id=d.meal_id WHERE table_order_id=".$table_order_id;
			$orderData=$this->Chef_model->get_by_query_return_row($query);
			
			
			$resultAffected=$this->Chef_model->update_by_condition('ru_table_wise_order',array('order_status'=>3,'cancel_reason'=>$comment,'cancel_time'=>date('Y-m-d H:i:s')),array('table_order_id'=>$table_order_id));
			
			
			
			
			if($orderData!=null)
			{
				$message=$comment;
				//echo $message;die();
				$notificationToUsers=$this->Chef_model->get_by_query("SELECT user_id FROM ru_users WHERE role!=5 AND status=1");
				foreach($notificationToUsers as $notificationToUser)
				{
					$notificationData=array(
											'from_user_id'=>$this->session->userdata('userID'),
											'to_user_id'=>$notificationToUser['user_id'],
											'message'=>$message,
											'module_id'=>$table_order_id,
											'module_type'=>'ru_table_wise_order',
											'notification_type'=>0,
											'is_read'=>0,
											'created'=>date('Y-m-d H:i:s'),
											'updated'=>date('Y-m-d H:i:s')
											);
					$insertid=$this->Chef_model->insert_one_row('ru_notifications',$notificationData);
				}
                $table_booking_id = $orderData->table_booking_id;
				if(!empty($table_booking_id))
				{	
				    $pendingOrders=$this->Chef_model->no_of_pending_order($table_booking_id);
					if($pendingOrders==0)
					{	
				         $updateTableStatus=$this->Chef_model->update_by_condition('ru_member_table_booking',array('member_status'=>3,'modify_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id));
					}
				}
				
				echo 1;
			}   
			else 
			{
                echo 'invalid request';
			}
		}	
		else
		{
			echo 'invalid request';
		}	
	}
}	