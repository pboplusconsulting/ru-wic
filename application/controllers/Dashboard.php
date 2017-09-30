<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
     **Constructor
	 */
	function __construct()
    {
        parent::__construct();
		$this->load->helper('security');
         if(!isset($_SESSION['isLogin']))
        redirect('Login');
	
	    if($this->Base_model->is_user_valid()==false)
		{
			$this->session->sess_destroy();
		    redirect('Login','refresh');
		}
	    $this->load->model('Dash_model');
		if($this->session->userdata('userRole')==4 || $this->session->userdata('userRole')==5)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}//print_r($_SESSION);die();
    }
	public function index()
	{   //print_r($_SESSION);die();
		if(isset($_POST['book_now']))
		{//print_r($_POST);die();
			$member_id=trim($this->input->post('member'));
			$total_guest=trim($this->input->post('total_guest'));
			$guest_comment=$this->input->post('guest_comment');
			$table_number=count($this->input->post('table_number'))>0?$this->input->post('table_number'):array();
			
			if(ceil($total_guest/8) > count($table_number))
			{
				redirect('');
			}	
			//die();
			$tables=implode(',',$table_number);
			//print_r($table_number);die();
			$BookingData=array(
			                   'member_id'=>$member_id,
							   'waiter_id'=>$this->session->userdata('userID'),
							   'table_booking_no'=>$tables,
							   'no_of_guest'=>$total_guest,
							   'guest_comment'=>$guest_comment,
							   'table_status'=>1,
							   'member_status'=>1,
							   'booking_time'=>date('Y-m-d H:i:s'),
							   'status'=>1,
							   'modify_time'=>date('Y-m-d H:i:s')
							   );
			$check_existence=$this->Dash_model->return_num_rows('ru_member_table_booking',array('member_id'=>$member_id,'table_status'=>1,'booking_time >='=>date('Y-m-d').' 00:00:00','booking_time <='=>date('Y-m-d').' 23:59:59','status'=>1));
			
			$insertId=0;
            if($check_existence==0)
            {				
			    $insertId=$this->Dash_model->insert_one_row('ru_member_table_booking',$BookingData);
			}	
			//$tableUpdateId=$this->Dash_model->update_by_condition('ru_tables',array('table_assign_status'=>1),array('id'=>$table_number));
            if($insertId)
			{	/***************send notification for refresh each user screen when table is booked**************/
					$notificationData1=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>0,//Here 0=>every user get refresh notification
												'message'=>'Table booked',
												'module_id'=>$insertId,
												'module_type'=>'ru_member_table_booking',
												'notification_type'=>3,//3 for table booking
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
												);
					$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);
					/*****************End send notification for refresh each user screen*********************/
                redirect('dashboard');
			}
            else
            {
				$this->session->set_flashdata('flashError','Member you are trying to book is already booked.');
				redirect('welcome');
			}				
		}
		else if(isset($_POST['changebooking']))
		{//print_r($_POST);die();
			$table_booking_id=trim($this->input->post('table_booking_id'));
			$total_guest=trim($this->input->post('total_guest'));
			$guest_comment=$this->input->post('guest_comment');
			$table_number=$this->input->post('table_number');
			$table_number=count($table_number)>0?$table_number:array();
			/*
			if(ceil($total_guest/8) > count($table_number))
			{
				redirect('');
			}*/	
			$check_table_detail=$this->Dash_model->get_by_query_return_row("SELECT * FROM ru_member_table_booking WHERE table_booking_id=".$table_booking_id);
			if($check_table_detail!=null)
            {
				$currentBookd=explode(',',$check_table_detail->table_booking_no);
				$changeStatus=1;
				/*foreach($table_number as $tblno)
				{
					if(!in_array($tblno,$currentBookd))
					{
						$changeStatus=1;break;
					}	
				}*/
				if($changeStatus)
				{
					$tables=implode(',',$table_number);
					//print_r($table_number);die();
					$BookingData=array(
								   'table_booking_no'=>$tables,
								   'no_of_guest'=>$total_guest,
								   'guest_comment'=>$guest_comment,
								   'modify_time'=>date('Y-m-d H:i:s')
								   );
				
					
					$tableUpdateId=$this->Dash_model->update_by_condition('ru_member_table_booking',$BookingData,array('table_booking_id'=>$table_booking_id));
					
				
					/***************send notification for refresh each user screen when table is booked**************/
					$notificationData1=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>0,//Here 0=>every user get refresh notification
												'message'=>'Table booking changed',
												'module_id'=>$table_booking_id,
												'module_type'=>'ru_member_table_booking',
												'notification_type'=>3,//3 for table booking
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
											);
					$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);
					/*****************End send notification for refresh each user screen*********************/
				}
				redirect('dashboard');
			}
            else
            {
				$this->session->set_flashdata('flashError','Member you are trying to book is already booked.');
				redirect('welcome');
			}				
		}	
		else
		{
			$query="SELECT a.*,b.member_name,b.membership_id,GROUP_CONCAT(c.table_name) AS table_name,GROUP_CONCAT(c.id) AS table_ids FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id  JOIN ru_tables c ON FIND_IN_SET(c.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00-00-00' AND a.booking_time<='".date('Y-m-d')." 23-59-59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC";
			
			
			/***********fetch all member and orders *******************************
			"SELECT a.*,b.member_name,c.table_name,orders.meal_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id LEFT JOIN (SELECT xx.table_booking_id,GROUP_CONCAT(xx.meal_name SEPARATOR ';') AS meal_name FROM (SELECT d.table_booking_id,d.guest_seat_no, GROUP_CONCAT(m.meal_name SEPARATOR ',') AS meal_name FROM ru_table_wise_order d JOIN ru_meal m ON d.meal_id=m.meal_id WHERE d.table_booking_id=9 AND d.order_time>'2017-05-26 00-00-00' GROUP BY d.table_booking_id,d.guest_seat_no) AS xx GROUP BY xx.table_booking_id) AS orders ON orders.table_booking_id=a.table_booking_id WHERE a.booking_time>='2017-05-26 00-00-00' AND a.status=1"
			************************************end*********************************/
			
			$result=$this->Dash_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			
			//$query1="SELECT a.*,b.meal_name from ru_table_wise_order a JOIN ru_meal b ON b.meal_id=a.meal_id WHERE a.order_time>'".date('Y-m-d')." 00-00-00'";
			//$orders=$this->Dash_model->get_by_query($query1);	
			
			//$query2="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.table_booking_no=a.id AND b.booking_time>'".date('Y-m-d')." 00:00:00' AND b.table_status=1),1,0) AS booking_status FROM ru_tables a";
			
			
			//table wise order status
			/*
			$query2="SELECT a.id,a.table_name,@booking_id:=(SELECT table_booking_id FROM ru_member_table_booking WHERE FIND_IN_SET(a.id,table_booking_no) AND booking_time >='".date('Y-m-d')." 00:00:00' AND booking_time <='".date('Y-m-d')." 23:59:59' AND table_status=1) AS booking_id,@no_of_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id) AS no_of_orders,@complete_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id AND order_status=1) AS complete_orders,@unread_order_notification:=(SELECT COUNT(*) FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND a.module_type='ru_table_wise_order' WHERE b.table_booking_id=@booking_id AND a.to_user_id=".$this->session->userdata('userID')." AND a.is_read=0 AND notification_type=0) AS unread_order_notification,IF(@booking_id,1,0) AS booking_status FROM ru_tables a WHERE a.status=1";*/
			
			$query2="SELECT a.id,a.table_name,@booking_id:=(SELECT table_booking_id FROM ru_member_table_booking WHERE FIND_IN_SET(a.id,table_booking_no) AND status=1 AND table_status=1) OR (SELECT id FROM ru_advance_table_booking WHERE FIND_IN_SET(a.id,table_id) AND booking_status=1 AND booked_for_date='".date('Y-m-d')."') AS booking_id,@no_of_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id) AS no_of_orders,@complete_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id AND order_status=1) AS complete_orders,@cancel_orders:=(SELECT COUNT(*) FROM ru_table_wise_order WHERE table_booking_id=@booking_id AND order_status=3) AS cancel_orders,@unread_order_notification:=(SELECT COUNT(*) FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND a.module_type='ru_table_wise_order' WHERE b.table_booking_id=@booking_id AND a.to_user_id=".$this->session->userdata('userID')." AND a.is_read=0 AND notification_type=0) AS unread_order_notification,IF(@booking_id,1,0) AS booking_status FROM ru_tables a WHERE a.status=1 AND a.table_name!='Parcel'";
			//echo $query;die();
			
			// date('Y-m-d', strtotime('+1 day'))
			$tableStatus=$this->Dash_model->get_by_query($query2);
			
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";
			$availableTables=$this->Dash_model->get_by_query($sql);//print_r($availableTables);die();
			
			//print_r($tableStatus);die();
			$heading['heading']="Dashboard";
			$dashboardData['data']=$result;
			$dashboardData['tableStatus']=$tableStatus;
			$dashboardData['availableTables']=$availableTables;
			$this->load->view('header',$heading);
			$this->load->view('dashboard/dashboard',$dashboardData);
			$this->load->view('footer.php');
		}	
	}
	
	/******************************This function is called to search members at dashboard******************/
	public function search_member()
	{
		$search_string =$this->input->post('search');
		
		if(!empty($search_string))
		{
			$limit=10;
			$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.status=1 AND b.table_status=1) AS booking_status,c.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids ,c.no_of_guest,c.booking_time,c.table_status,c.member_status,c.remark,c.cancel_reason FROM ru_membership a LEFT JOIN ru_member_table_booking c ON c.member_id=a.id AND c.status=1 AND c.table_status=1 LEFT JOIN ru_tables r ON FIND_IN_SET(r.id,c.table_booking_no) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' AND a.status=1 GROUP BY a.id ORDER BY a.member_name";
			$searchCount=$this->Dash_model->return_query_num_rows($query);
			
			$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.status=1 AND b.table_status=1) AS booking_status,c.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids ,c.no_of_guest,c.booking_time,c.table_status,c.member_status,c.remark,c.cancel_reason FROM ru_membership a LEFT JOIN ru_member_table_booking c ON c.member_id=a.id AND c.status=1 AND c.table_status=1 LEFT JOIN ru_tables r ON FIND_IN_SET(r.id,c.table_booking_no) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' AND a.status=1 GROUP BY a.id ORDER BY a.member_name LIMIT ".$limit;
			
			$result=$this->Dash_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";
			$availableTables=$this->Dash_model->get_by_query($sql);//print_r($availableTables);die();
			//print_r($availableTables);die();
			
			$nextPageStatus=$searchCount>$limit?1:0;
			
			$searchData['data']=$result;
			$searchData['availableTables']=$availableTables;
			$searchData['nextPageStatus']=$nextPageStatus;
			$html=$this->load->view('dashboard/search_html',$searchData,true);
			echo $html;
		}
		else
		{
			$limit=20;
			
			$query="SELECT b.*,a.table_booking_id,a.no_of_guest,a.booking_time,a.table_status,a.member_status,1 as booking_status,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids,a.remark,a.cancel_reason FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables r ON FIND_IN_SET(r.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00:00:00' AND a.booking_time <='".date('Y-m-d')." 23:59:59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC";
			
			$searchCount=$this->Dash_model->return_query_num_rows($query);
			
			
			$query="SELECT b.*,a.table_booking_id,a.no_of_guest,a.booking_time,a.table_status,a.member_status,1 as booking_status,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids,a.remark,a.cancel_reason FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables r ON FIND_IN_SET(r.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00:00:00' AND a.booking_time <='".date('Y-m-d')." 23:59:59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC LIMIT ".$limit;
			
			$result=$this->Dash_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			//echo "<pre>";print_r($result);echo "</pre>";die();

			/*
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.booking_time>'".date('Y-m-d')." 00:00:00' AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";*/
			
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";
			$availableTables=$this->Dash_model->get_by_query($sql);//print_r($availableTables);die();
			//print_r($availableTables);die();
			
			$nextPageStatus=$searchCount>$limit?1:0;
			
			$searchData['data']=$result;
			$searchData['availableTables']=$availableTables;
			$searchData['nextPageStatus']=$nextPageStatus;
			$html=$this->load->view('dashboard/search_html',$searchData,true);
			echo $html;
		}	
	}
	
	public function load_pagination_data()
    {
        $search_string =$this->input->post('search');
		$pageNumber =$this->input->post('pageNumber');
		
		if(!empty($search_string))
		{
			$limit=10;
			$offset=$limit*$pageNumber;
			$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.status=1 AND b.table_status=1) AS booking_status,c.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids ,c.no_of_guest,c.booking_time,c.table_status,c.member_status,c.remark FROM ru_membership a LEFT JOIN ru_member_table_booking c ON c.member_id=a.id AND c.status=1 AND c.table_status=1 LEFT JOIN ru_tables r ON FIND_IN_SET(r.id,c.table_booking_no) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1 GROUP BY a.id ORDER BY a.member_name";
			$searchCount=$this->Dash_model->return_query_num_rows($query);
			
			$query="SELECT a.*,(SELECT COUNT(*) FROM ru_member_table_booking b WHERE b.member_id=a.id AND b.status=1 AND b.table_status=1) AS booking_status,c.table_booking_id,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids ,c.no_of_guest,c.booking_time,c.table_status,c.member_status,c.remark FROM ru_membership a LEFT JOIN ru_member_table_booking c ON c.member_id=a.id AND c.status=1 AND c.table_status=1 LEFT JOIN ru_tables r ON FIND_IN_SET(r.id,c.table_booking_no) WHERE a.membership_id LIKE '%".$search_string."%' OR a.member_name LIKE '%".$search_string."%' OR a.email_id LIKE '%".$search_string."%' OR a.phone_number LIKE '%".$search_string."%' AND a.status=1 GROUP BY a.id ORDER BY a.member_name LIMIT ".$limit.' OFFSET '.$offset;
			
			$result=$this->Dash_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";
			$availableTables=$this->Dash_model->get_by_query($sql);//print_r($availableTables);die();
			//print_r($availableTables);die();
			
			$nextPageStatus=$searchCount>($offset+$limit)?$pageNumber+1:0;
			
			$searchData['data']=$result;
			$searchData['availableTables']=$availableTables;
			$searchData['nextPageStatus']=$nextPageStatus;
			$html=$this->load->view('dashboard/search_html',$searchData,true);
			echo $html;
		}
		else
		{
			$limit=20;
			$offset=$limit*$pageNumber;
			$query="SELECT b.*,a.table_booking_id,a.no_of_guest,a.booking_time,a.table_status,a.member_status,1 as booking_status,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids,a.remark FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables r ON FIND_IN_SET(r.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00:00:00' AND a.booking_time <='".date('Y-m-d')." 23:59:59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC";
			
			$searchCount=$this->Dash_model->return_query_num_rows($query);
			
			
			$query="SELECT b.*,a.table_booking_id,a.no_of_guest,a.booking_time,a.table_status,a.member_status,1 as booking_status,GROUP_CONCAT(r.table_name) AS table_name,GROUP_CONCAT(r.id) AS table_ids,a.remark FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables r ON FIND_IN_SET(r.id,a.table_booking_no) WHERE (a.booking_time>='".date('Y-m-d')." 00:00:00' AND a.booking_time <='".date('Y-m-d')." 23:59:59' AND a.status=1) OR (a.table_status=1 AND a.status=1) GROUP BY a.table_booking_id ORDER BY a.booking_time DESC,b.member_name ASC LIMIT ".$limit.' OFFSET '.$offset;
			
			$result=$this->Dash_model->get_by_query($query);//echo "<pre>";print_r($result);echo "</pre>";die();
			//echo "<pre>";print_r($result);echo "</pre>";die();

			/*
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.booking_time>'".date('Y-m-d')." 00:00:00' AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";*/
			
			$sql="SELECT a.id,a.table_name,IF((SELECT COUNT(*) FROM ru_member_table_booking b WHERE FIND_IN_SET(a.id,b.table_booking_no) AND b.table_status=1 AND b.status=1),1,0) AS table_status,IF((SELECT count(*) FROM ru_advance_table_booking c WHERE c.table_id=a.id AND c.booked_for_date='".date('Y-m-d')."' AND c.booking_status=1),1,0) AS Advance_booking_status from ru_tables a";
			$availableTables=$this->Dash_model->get_by_query($sql);//print_r($availableTables);die();
			//print_r($availableTables);die();
			
			$nextPageStatus=$searchCount>($offset+$limit)?$pageNumber+1:0;
			
			$searchData['data']=$result;
			$searchData['availableTables']=$availableTables;
			$searchData['nextPageStatus']=$nextPageStatus;
			$html=$this->load->view('dashboard/search_html',$searchData,true);
			echo $html;
		}
	}
	/****************************************end search function*******************************************/
 	
	
	/********************************************About User tab********************************************/
	public function generate_bill()
	{
		if(isset($_POST['action']) && $_POST['action']=='generate_bill')
		{
			$bill_type=$this->input->post('bill_type');
			$table_booking_id=$_POST['table_booking_id'];
            $tableBookingData=$this->Dash_model->get_by_query_return_row('SELECT table_status FROM ru_member_table_booking WHERE table_booking_id='.$table_booking_id);
			$product_category_data=$this->Dash_model->get_category_data(array('category_name'=>'alcohol'));
			$product_category_id=$product_category_data==null?'-1':$product_category_data->product_category_id;			
			if($bill_type=='meal_bill')
			{
				
				$tableBill=$this->Dash_model->get_by_query('SELECT * FROM ru_order_bill_history WHERE table_booking_id='.$table_booking_id." AND product_category_id!=".$product_category_id." ORDER BY order_bill_id DESC");
				
				$query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id!=".$product_category_id." WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id;
			    $orderData=$this->Dash_model->get_by_query($query1);
			   
                $query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=1 WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotal, (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=3 WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotalbeverage";
			    
				$billingData=$this->Dash_model->get_by_query_return_row($query2);
                //var_dump($billingData);//die();
			    
				
				// $query3="SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND b.category_name='meal' WHERE a.status=1 ORDER BY a.tax_name ASC";
				
				$query3 = "SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND(";
                
				if ( $billingData->subtotal !="" ){
				$query3 .= " b.category_name='meal'"; // Meal 
				}
				if ( $billingData->subtotal !="" AND $billingData->subtotalbeverage !="" ){
					
				$query3 .= " OR"; // Get Both
				}
					
				if ( $billingData->subtotalbeverage !="" ){
				$query3 .= " b.category_name='beverages'"; // Beverages 
				}

                $query3 .=") WHERE a.status=1 ORDER BY a.tax_name DESC";				
				
			    $flagData=$this->Dash_model->get_by_query($query3);
							
				$billData['orderData']=$orderData;
				$billData['billingData']=$billingData;
				$billData['flagData']=$flagData;
				$billData['table_booking_id']=$table_booking_id;
				$billData['bill_type']=$bill_type;
				$billData['last_bills']=$tableBill;
				$billData['billcategory']='meal';
				$billData['tableBookingData']=$tableBookingData;
				$billHtml=$this->load->view('dashboard/bill_bm_html',$billData,true);
				echo $billHtml;
			}	
			else if($bill_type=='alcohol_bill')
            {

				
				$tableBill=$this->Dash_model->get_by_query('SELECT * FROM ru_order_bill_history WHERE table_booking_id='.$table_booking_id." AND product_category_id=".$product_category_id." ORDER BY order_bill_id DESC");
				
			    $query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=".$product_category_id." WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id;
			    $orderData=$this->Dash_model->get_by_query($query1);
			

                $query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=".$product_category_id." WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotal";
			    $billingData=$this->Dash_model->get_by_query_return_row($query2);
                //var_dump($billingData);die();
			    $query3="SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND b.category_name='alcohol' WHERE a.status=1 ORDER BY a.tax_name ASC";
			    $flagData=$this->Dash_model->get_by_query($query3);
			    //print_r($flagData);die();
			    
				$billData['orderData']=$orderData;
				$billData['billingData']=$billingData;
				$billData['flagData']=$flagData;
				$billData['table_booking_id']=$table_booking_id;
				$billData['bill_type']=$bill_type;
			    $billData['last_bills']=$tableBill;
				$billData['billcategory']='alcohol';
				$billData['tableBookingData']=$tableBookingData;
				$billHtml=$this->load->view('dashboard/bill_html',$billData,true);
				echo $billHtml;
			}				
		}
		/*
		if(isset($_POST['action']) && $_POST['action']=='generate_bill_html')
		{
			$table_booking_id=$_POST['table_booking_id'];
			//echo $table_booking_id;die();
			$tableBill=$this->Dash_model->get_by_query_return_row('SELECT order_bill_id,discount FROM ru_order_bill WHERE table_booking_id='.$table_booking_id);
			
			$query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.table_booking_id=".$table_booking_id;
			$orderData=$this->Dash_model->get_by_query($query1);
			

            $query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.table_booking_id=".$table_booking_id.") AS subtotal";
			$billingData=$this->Dash_model->get_by_query_return_row($query2);
            //var_dump($billingData);die();
			$query3="SELECT a.id,a.flag_name,a.flag_type,a.percentage FROM ru_flags a WHERE a.status=1 ORDER BY a.flag_type ASC";
			$flagData=$this->Dash_model->get_by_query($query3);
			
			$totalTax=0;
			$discount='';
			
			if($tableBill!=null)
			{
				$discount=$tableBill->discount;
			}	
			
			if($billingData->subtotal!=null)
            {
				foreach($flagData as $fdata)
				{
					if($fdata['flag_type']==0)
					{
						$totalTax=$totalTax+($billingData->subtotal*$fdata['percentage'])/100;
					}	
				}	
            }			
		    $billData['orderData']=$orderData;
            $billData['billingData']=$billingData;
			$billData['flagData']=$flagData;
			$billData['table_booking_id']=$table_booking_id;
			$billData['discount']=$discount;
			$billHtml=$this->load->view('dashboard/bill_html',$billData,true);
            echo $billHtml;
		}*/
        else if(isset($_POST['action']) && $_POST['action']=='save_print')
        {
			$bill_category=$this->input->post('bill_category');
			
			$product_category_data=$this->Dash_model->get_category_data(array('category_name'=>'alcohol'));
			$product_category_id=$product_category_data==null?'-1':$product_category_data->product_category_id;
			//echo $product_category_id;die();
			
			$discount=$this->input->post('discount');
			$comment=$this->input->post('comment');
			$table_booking_id=$this->input->post('table_booking_id');
			//echo 'hello'.$table_booking_id;die();
			//echo $bill_category;die();
			if($bill_category=='alcohol')
			{
				$tableBill=$this->Dash_model->get_by_query_return_row('SELECT order_bill_id FROM ru_order_bill WHERE table_booking_id='.$table_booking_id.' AND product_category_id='.$product_category_id);
				
				$query="SELECT a.*,b.member_name,b.membership_id,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id LEFT JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
				$memberData=$this->Dash_model->get_by_query_return_row($query);
				
				$query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=".$product_category_id."  WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id;
				$orderData=$this->Dash_model->get_by_query($query1);
				//print_r($orderData);die();

				$query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=".$product_category_id." WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotal";
				$billingData=$this->Dash_model->get_by_query_return_row($query2);

				/*$query3="SELECT a.id,a.flag_name,a.flag_type,a.percentage FROM ru_flags a WHERE a.status=1 ORDER BY a.flag_type ASC";
				$flagData=$this->Dash_model->get_by_query($query3);*/
				$query3="SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND b.category_name='alcohol' WHERE a.status=1 ORDER BY a.tax_name ASC";
				$flagData=$this->Dash_model->get_by_query($query3);
				//echo "<pre>";var_dump($billingData);echo "</pre>";die();
				//die();	
$billInsId='';
			$totalTax=0;
			$total_amount=$billingData->subtotal-$discount;
			foreach($flagData as $fdata)
			{
				$totalTax=$totalTax+($total_amount*$fdata['tax_percent'])/100;
			}
			$round_off=$total_amount+$totalTax;
			$final_amount=round($total_amount+$totalTax);
			$saveBillData=array(
								'member_id'=>$memberData->member_id,
								'table_booking_id'=>$table_booking_id,
								'amount'=>$billingData->subtotal,
								'discount'=>$discount,
								'comment'=>$comment,
								'tax'=>$totalTax,
								'final_amount'=>$final_amount,
								'round_off'=>$round_off,
								'bill_generation_time'=>date('Y-m-d H:i:s'),
								'bill_status'=>0,
								'product_category_id'=>($bill_category=='alcohol'?2:1),
								'modify_time'=>date('Y-m-d H:i:s')
								);
			if($tableBill==null)
			{	
				$billInsId=$this->Dash_model->insert_one_row('ru_order_bill',$saveBillData);
			}
			else
			{
				$this->Dash_model->update_by_condition('ru_order_bill',$saveBillData,array('order_bill_id'=>$tableBill->order_bill_id));
				$billInsId=$tableBill->order_bill_id;
			}
			
			
			$saveBillHistoryData=array(
								'member_id'=>$memberData->member_id,
								'table_booking_id'=>$table_booking_id,
								'amount'=>$billingData->subtotal,
								'discount'=>$discount,
								'comment'=>$comment,
								'tax'=>$totalTax,
								'final_amount'=>$final_amount,
								'round_off'=>$round_off,
								'bill_generation_time'=>date('Y-m-d H:i:s'),
								'status'=>1,
								'product_category_id'=>($bill_category=='alcohol'?2:1),
								'modify_time'=>date('Y-m-d H:i:s')
								);
			$this->Dash_model->insert_one_row('ru_order_bill_history',$saveBillHistoryData);
			
			$billHtml='';
			$billData['billId']=$billInsId;//this field will be bill id
			$billData['memberData']=$memberData;
			$billData['orderData']=$orderData;
            $billData['billingData']=$billingData;
			$billData['flagData']=$flagData;
			$billData['discount']=$discount;
			
			$billHtml=$this->load->view('dashboard/bill_pdf_new',$billData,true);
		    
			
			/*************************************set Dompdf for page count**************************/
			$this->load->library('Pdf','','pdf1');
			$this->pdf1->set_paper(array(0,0,226,227),'portrait');
            //$this->pdf->set_option('dpi', 72);
		    $this->pdf1->load_view('dashboard/bill_pdf_new',$billData,true);
		    $this->pdf1->render();		
			/*******************************************end****************************************/
            $page_count = $this->pdf1->get_canvas()->get_page_number();//echo $page_count;die();				
			//$this->pdf=null;
            
			/*************************************Generate PDF*************************************/
			$this->load->library('Pdf','','pdf2');
			$this->pdf2->set_paper(array(0,0,226,227 * $page_count),'portrait');
            //$this->pdf->set_option('dpi', 72);
		    $this->pdf2->load_view('dashboard/bill_pdf_new',$billData,true);
		    $this->pdf2->render();
			/*******************************************end****************************************/
			
		    $file_name="bill-".$bill_category.'-'.$table_booking_id.".pdf";
            $pdf=$this->pdf2->output();
            if(file_put_contents('uploads/pdf/member_bill/'.$file_name,$pdf))
            {
				$saveBillData1['bill_pdf']='uploads/pdf/member_bill/'.$file_name;
                $this->Dash_model->update_by_condition('ru_order_bill',$saveBillData1,array('order_bill_id'=>$billInsId));
            }
			echo 'uploads/pdf/member_bill/'.$file_name;
			//echo $billHtml;				
					
		    }
            else 
            {
				$tableBill=$this->Dash_model->get_by_query_return_row('SELECT order_bill_id FROM ru_order_bill WHERE table_booking_id='.$table_booking_id.' AND product_category_id!='.$product_category_id);
				
				$query="SELECT a.*,b.member_name,b.membership_id,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id LEFT JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
				$memberData=$this->Dash_model->get_by_query_return_row($query);
				
				$query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id!=".$product_category_id."  WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id;
				$orderData=$this->Dash_model->get_by_query($query1);
				//print_r($orderData);die();

				$query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=1 WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotal, (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id JOIN ru_menu c ON b.menu_id=c.menu_id AND c.product_category_id=3 WHERE a.order_status!=3 AND a.table_booking_id=".$table_booking_id.") AS subtotalbeverage";
				
				
				$billingData=$this->Dash_model->get_by_query_return_row($query2);
				

				/*$query3="SELECT a.id,a.flag_name,a.flag_type,a.percentage FROM ru_flags a WHERE a.status=1 ORDER BY a.flag_type ASC";
				$flagData=$this->Dash_model->get_by_query($query3);*/
				// $query3="SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND b.category_name='meal' WHERE a.status=1 ORDER BY a.tax_name ASC";
				$query3 = "SELECT a.* FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id AND(";
                
				if ( $billingData->subtotal !="" ){
				$query3 .= " b.category_name='meal'"; // Meal 
				}
				if ( $billingData->subtotal !="" AND $billingData->subtotalbeverage !="" ){
					
				$query3 .= " OR"; // Get Both
				}
					
				if ( $billingData->subtotalbeverage !="" ){
				$query3 .= " b.category_name='beverages'"; // Beverages 
				}

                $query3 .=") WHERE a.status=1 ORDER BY a.tax_name DESC";				

				$flagData=$this->Dash_model->get_by_query($query3);
				
				$billInsId='';
			$totalTax=0;
			$totalTaxBev=0;
			$total_amount=0;
			$total_amount_beverage=0;
			if($billingData->subtotal!=''){
			$total_amount=$billingData->subtotal-$discount;
			}
			if($billingData->subtotalbeverage!=''){
			$total_amount_beverage=$billingData->subtotalbeverage-$discount;
			}
			//print($total_amount.$total_amount_beverage."Discount".$discount);
			foreach($flagData as $fdata)
			{
				// $totalTax=$totalTax+($total_amount*$fdata['tax_percent'])/100;
				
				if($fdata['tax_name']=='SGST' || $fdata['tax_name']=='CGST'){
				$totalTax=$totalTax+($total_amount*$fdata['tax_percent'])/100;
				}
				if($fdata['tax_name']=='CESS'){
				$totalTaxBev=$totalTaxBev+($total_amount_beverage*$fdata['tax_percent'])/100;
				}
										
			}
			//print("Meal".$totalTax."Bev".$totalTaxBev);
			$round_off=$total_amount+$total_amount_beverage+$totalTax+$totalTaxBev;
			$final_amount=round($total_amount+$total_amount_beverage+$totalTax+$totalTaxBev);
			// print($round_off."Final".$final_amount);
			$saveBillData=array(
								'member_id'=>$memberData->member_id,
								'table_booking_id'=>$table_booking_id,
								'amount'=>$billingData->subtotal+$billingData->subtotalbeverage,
								'discount'=>$discount,
								'comment'=>$comment,
								'tax'=>$totalTax+$totalTaxBev,
								'final_amount'=>$final_amount,
								'round_off'=>$round_off,
								'bill_generation_time'=>date('Y-m-d H:i:s'),
								'bill_status'=>0,
								'product_category_id'=>($bill_category=='alcohol'?2:1),
								'modify_time'=>date('Y-m-d H:i:s')
								);
			if($tableBill==null)
			{	
				$billInsId=$this->Dash_model->insert_one_row('ru_order_bill',$saveBillData);
			}
			else
			{
				$this->Dash_model->update_by_condition('ru_order_bill',$saveBillData,array('order_bill_id'=>$tableBill->order_bill_id));
				$billInsId=$tableBill->order_bill_id;
			}
			
			
			$saveBillHistoryData=array(
								'member_id'=>$memberData->member_id,
								'table_booking_id'=>$table_booking_id,
								'amount'=>$billingData->subtotal+$billingData->subtotalbeverage,
								'discount'=>$discount,
								'comment'=>$comment,
								'tax'=>$totalTax+$totalTaxBev,
								'final_amount'=>$final_amount,
								'round_off'=>$round_off,
								'bill_generation_time'=>date('Y-m-d H:i:s'),
								'status'=>1,
								'product_category_id'=>($bill_category=='alcohol'?2:1),
								'modify_time'=>date('Y-m-d H:i:s')
								);
			$this->Dash_model->insert_one_row('ru_order_bill_history',$saveBillHistoryData);
			
			$billHtml='';
			$billData['billId']=$billInsId;//this field will be bill id
			$billData['memberData']=$memberData;
			$billData['orderData']=$orderData;
            $billData['billingData']=$billingData;
			$billData['flagData']=$flagData;
			$billData['discount']=$discount;
			
			$billHtml=$this->load->view('dashboard/bill_pdf_bm_new',$billData,true);
		    
			
			/*************************************set Dompdf for page count**************************/
			$this->load->library('Pdf','','pdf1');
			$this->pdf1->set_paper(array(0,0,226,227),'portrait');
            //$this->pdf->set_option('dpi', 72);
		    $this->pdf1->load_view('dashboard/bill_pdf_bm_new',$billData,true);
		    $this->pdf1->render();		
			/*******************************************end****************************************/
            $page_count = $this->pdf1->get_canvas()->get_page_number();//echo $page_count;die();				
			//$this->pdf=null;
            
			/*************************************Generate PDF*************************************/
			$this->load->library('Pdf','','pdf2');
			$this->pdf2->set_paper(array(0,0,226,227 * $page_count),'portrait');
            //$this->pdf->set_option('dpi', 72);
		    $this->pdf2->load_view('dashboard/bill_pdf_bm_new',$billData,true);
		    $this->pdf2->render();
			/*******************************************end****************************************/
			
		    $file_name="bill-".$bill_category.'-'.$table_booking_id.".pdf";
            $pdf=$this->pdf2->output();
            if(file_put_contents('uploads/pdf/member_bill/'.$file_name,$pdf))
            {
				$saveBillData1['bill_pdf']='uploads/pdf/member_bill/'.$file_name;
                $this->Dash_model->update_by_condition('ru_order_bill',$saveBillData1,array('order_bill_id'=>$billInsId));
            }
			echo 'uploads/pdf/member_bill/'.$file_name;
			//echo $billHtml;
			}
            /*			
            if($billingData->subtotal==null)
			{
				die();
			}
*/			
			//echo $discount;die();			
			
		}			
        		
	}
	/********************************************end about user *******************************************/
	
	
	public function download_bill()
	{
		$table_booking_id=$this->uri->segment(3);
		//echo $table_booking_id;die();
		$tableBill=$this->Dash_model->get_by_query_return_row('SELECT order_bill_id FROM ru_order_bill WHERE table_booking_id='.$table_booking_id);
		
		$query="SELECT a.*,b.member_name,b.membership_id,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
		$memberData=$this->Dash_model->get_by_query_return_row($query);
		
		$query1="SELECT a.*,b.meal_name,b.meal_price,a.quantity*b.meal_price as amount FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.table_booking_id=".$table_booking_id;
		$orderData=$this->Dash_model->get_by_query($query1);
		//print_r($orderData);die();

		$query2="SELECT (SELECT SUM(a.quantity*b.meal_price) FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.table_booking_id=".$table_booking_id.") AS subtotal";
		$billingData=$this->Dash_model->get_by_query_return_row($query2);

		$query3="SELECT a.id,a.flag_name,a.flag_type,a.percentage FROM ru_flags a WHERE a.status=1 ORDER BY a.flag_type ASC";
		$flagData=$this->Dash_model->get_by_query($query3);
		
		$billInsId=$tableBill->order_bill_id;
		$billData['billId']=$billInsId;//this field will be bill id
		$billData['memberData']=$memberData;
		$billData['orderData']=$orderData;
		$billData['billingData']=$billingData;
		$billData['flagData']=$flagData;
		
		/***************************generate html to pdf*************************************/
		$this->load->library('Pdf');
		$this->pdf->load_view('dashboard/bill_pdf',$billData,true);
		$this->pdf->render();
		$file_name="bill-".$table_booking_id.".pdf";
        /*$pdf=$this->pdf->output();
        file_put_contents('uploads/pdf/member_bill/'.$file_name,$pdf);*/

        $this->pdf->stream("bill-".$table_booking_id.".pdf");
		/*************************************end ******************************************/
		
	}
    
    public function pay_bill()
    {
		if(isset($_POST['action']) && $_POST['action']=='make_payment')
		{
			$table_booking_id=$this->input->post('table_booking_id');
			$this->Dash_model->update_by_condition('ru_order_bill',array('bill_status'=>1),array('table_booking_id'=>$table_booking_id));
			$this->Dash_model->update_by_condition('ru_member_table_booking',array('member_status'=>4,'table_status'=>0,'table_relieved_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id));
			
			/*
            $query="SELECT a.*,b.member_name,b.membership_id,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
		    $memberData['memberData']=$this->Dash_model->get_by_query_return_row($query);
			$modelhtml=$this->load->view('dashboard/feedback_model',$memberData,true);
			echo $modelhtml;
			*/
			//redirect('dashboard');
			echo 1;
		}
        else
        {
			echo 0;
		}		
    }
	
	
	public function cancel_order()
	{
		$table_booking_id=$this->uri->segment(3);
		$cancel_reason=$this->input->post('booking_cancel_reason');
		//echo $table_booking_id;
		$this->Dash_model->update_by_condition('ru_member_table_booking',array('member_status'=>0,'table_status'=>0,'table_relieved_time'=>date('Y-m-d H:i:s'),'cancel_reason'=>$cancel_reason),array('table_booking_id'=>$table_booking_id));
		
		/*****************send notification for refresh each user screen*********************/
		$notificationData1=array(
									'from_user_id'=>$this->session->userdata('userID'),
									'to_user_id'=>0,//Here 0=>every user get refresh notification
									'message'=>'Booking Cancel',
									'module_id'=>$table_booking_id,
									'module_type'=>'ru_member_table_booking',
									'notification_type'=>3,//3 for booking related notification 
									'is_read'=>0,
									'created'=>date('Y-m-d H:i:s'),
									'updated'=>date('Y-m-d H:i:s')
									);
		$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);
		/*****************End send notification for refresh each user screen*********************/
		
		redirect('dashboard');
	}


	public function feedback()
	{
		if(isset($_POST['save_feedback']))
		{//print_r($_POST);die();
			$member_id=$this->uri->segment(3);
			$table_booking_id=$this->uri->segment(4);
			
			$radio1=$this->input->post('radio1');
			$radio2=$this->input->post('radio2');
			$radio3=$this->input->post('radio3');
			$textbox1=$this->input->post('textbox1');
            $textbox2=$this->input->post('textbox2');
			
			$radio11=$this->input->post('radio11');
			$radio12=$this->input->post('radio12');
			$radio13=$this->input->post('radio13');
			$radio14=$this->input->post('radio14');
			$radio15=$this->input->post('radio15');
			$radio16=$this->input->post('radio16');
			$radio17=$this->input->post('radio17');
			$radio18=$this->input->post('radio18');
			$radio19=$this->input->post('radio19');
			$radio20=$this->input->post('radio20');
			
			$box11=$this->input->post('box11');
			$box12=$this->input->post('box12');
			$box13=$this->input->post('box13');
			$box14=$this->input->post('box14');
			$box15=$this->input->post('box15');
			$box16=$this->input->post('box16');
			$box17=$this->input->post('box17');
			$box18=$this->input->post('box18');
			$box19=$this->input->post('box19');
			$box20=$this->input->post('box20');
            
			$feedbackData=array(
			                    'member_id'=>$member_id,
								'table_booking_id'=>$table_booking_id,
								'q_1'=>$this->check_null($radio1),
								'q_2'=>$this->check_null($radio2),
								'mobile_no'=>$this->check_null($textbox1),
								'email_id'=>$this->check_null($textbox2),
								'q_3'=>$this->check_null($radio3),
								'feedback_1'=>$this->check_null($radio11),
								'text_feed_1'=>$this->check_null($box11),
								'feedback_2'=>$this->check_null($radio12),
								'text_feed_2'=>$this->check_null($box12),
								'feedback_3'=>$this->check_null($radio13),
								'text_feed_3'=>$this->check_null($box13),
								'feedback_4'=>$this->check_null($radio14),
								'text_feed_4'=>$this->check_null($box14),
								'feedback_5'=>$this->check_null($radio15),
								'text_feed_5'=>$this->check_null($box15),
								'feedback_6'=>$this->check_null($radio16),
								'text_feed_6'=>$this->check_null($box16),
								'feedback_7'=>$this->check_null($radio17),
								'text_feed_7'=>$this->check_null($box17),
								'feedback_8'=>$this->check_null($radio18),
								'text_feed_8'=>$this->check_null($box18),
								'feedback_9'=>$this->check_null($radio19),
								'text_feed_9'=>$this->check_null($box19),
								'feedback_10'=>$this->check_null($radio20),
								'text_feed_10'=>$this->check_null($box20),
								'feedback_generation_time'=>date('Y-m-d H:i:s A'),
								'modify_time'=>date('Y-m-d H:i:s A')
								);
			//feedback submitted and member has been discharged , so free the allocated table
			//$this->Dash_model->update_by_condition('ru_member_table_booking',array('member_status'=>4,'table_status'=>0,'table_relieved_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id,'member_status!='=>0));
			$this->Dash_model->insert_one_row('ru_feedback',$feedbackData);
			
			/*****************send notification for refresh each user screen*********************/
					/*$notificationData1=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>0,//Here 0=>every user get refresh notification
												'message'=>'Table relieved',
												'module_id'=>$table_booking_id,
												'module_type'=>'ru_member_table_booking',
												'notification_type'=>3,//table booking allocation related notitfication
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
												);
					$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);*/
					/*****************End send notification for refresh each user screen*********************/
			$heading['heading']="Member Feedback";
			$this->load->view('header',$heading);
			$this->load->view('dashboard/thankuPage');
			$this->load->view('footer.php');
			//redirect('dashboard');	
		}
        else if(isset($_POST['action']) && $_POST['action']=='member-feedback')
		{
			//generate feedback popup
			$table_booking_id=$this->input->post('table_booking_id');
			$query="SELECT a.*,b.member_name,b.membership_id,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
		    $memberData['memberData']=$this->Dash_model->get_by_query_return_row($query);
			$modelhtml=$this->load->view('dashboard/feedback_model',$memberData,true);
			echo $modelhtml;
		}
        else
        {
			$table_booking_id=$this->uri->segment(3);
			
			$query="SELECT a.*,b.member_name,b.membership_id,b.email_id,b.phone_number,c.table_name FROM ru_member_table_booking a JOIN ru_membership b ON a.member_id=b.id JOIN ru_tables c ON a.table_booking_no=c.id WHERE a.table_booking_id=".$table_booking_id;
		    $memberData['memberData']=$this->Dash_model->get_by_query_return_row($query);
			$heading['heading']="Member Feedback";
			$this->load->view('header',$heading);
			$this->load->view('dashboard/feedback_form',$memberData);
			$this->load->view('footer.php');
		}			
	}
	public function check_null($value)
	{
		if($value==null)
			$value='';
		return $value;
	}
	
	public function decline_feedback()
	{//echo 'declined';die();
	    $table_booking_id=$this->uri->segment(3);
		//$this->Dash_model->update_by_condition('ru_member_table_booking',array('status'=>0,'table_status'=>0),array('table_booking_id'=>$table_booking_id));
		redirect('dashboard');
	}
	
	public function order_comment()
	{
		if(isset($_POST['action']) && $_POST['action']=='view_commnt')
		{	
			$table_order_id=$this->input->post('order_id');

			//$query="SELECT a.*,b.waiter_id,c.table_name,d.meal_name FROM ru_table_wise_order a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_tables c ON b.table_booking_no=c.id JOIN ru_meal d ON a.meal_id=d.meal_id WHERE table_order_id=".$table_order_id;
			//$orderData=$this->Dash_model->get_by_query_return_row($query);
			$query="SELECT a.*,b.name FROM ru_notifications a JOIN ru_users b ON a.from_user_id=b.user_id WHERE module_id=".$table_order_id." AND module_type='ru_table_wise_order' AND notification_type=1 AND to_user_id=".$this->session->userdata('userID')." ORDER BY a.created DESC LIMIT 5";
			$orderCommentData=$this->Dash_model->get_by_query($query);
			$this->Dash_model->update_by_condition('ru_notifications',array('is_read'=>1),array('module_id'=>$table_order_id,'notification_type'=>1));
			echo json_encode($orderCommentData);
		}	
		else
		{
			echo 'invalid request';
		}
	}
	
	
	public function cancel_reason(){
	
			$member_id=$this->uri->segment(3);
			$table_booking_id=$this->uri->segment(4);
			           
			$feedbackData=array(
			                    'member_id'=>$member_id,
								'table_booking_id'=>$table_booking_id,
								'cancel_reason'=>xss_clean($this->input->post('cancel_reason')),
								'feedback_generation_time'=>date('Y-m-d H:i:s A'),
								'modify_time'=>date('Y-m-d H:i:s A')
								);
			//feedback submitted and member has been discharged , so free the allocated table
			// $this->Dash_model->update_by_condition('ru_member_table_booking',array('member_status'=>4,'table_status'=>0,'table_relieved_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id,'member_status!='=>0));
			$this->Dash_model->insert_one_row('ru_feedback',$feedbackData);
			
			/*****************send notification for refresh each user screen*********************/
		/*
					$notificationData1=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>0,//Here 0=>every user get refresh notification
												'message'=>'Table relieved',
												'module_id'=>$table_booking_id,
												'module_type'=>'ru_member_table_booking',
												'notification_type'=>3,//table booking allocation related notitfication
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
												);
					$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);
					*/
					/*****************End send notification for refresh each user screen*********************/
			
			redirect('dashboard');	
		
      
	}
	
	public function save_payment_status()
	{
		$table_booking_id=$this->uri->segment(3);
		
		$data=array('bill_status'=>xss_clean($this->input->post('payment_status1')),'payment_amount'=>xss_clean($this->input->post('payment_amount')),'payment_method'=>xss_clean($this->input->post('payment_method')));
		
		$this->Dash_model->update_by_condition('ru_order_bill',$data,array('table_booking_id'=>$table_booking_id));
		
		$this->Dash_model->update_by_condition('ru_member_table_booking',array('member_status'=>4,'table_status'=>0,'table_relieved_time'=>date('Y-m-d H:i:s')),array('table_booking_id'=>$table_booking_id,'member_status!='=>0));
		
		    /*****************send notification for refresh each user screen*********************/
				$notificationData1=array(
											'from_user_id'=>$this->session->userdata('userID'),
											'to_user_id'=>0,//Here 0=>every user get refresh notification
											'message'=>'Table relieved',
											'module_id'=>$table_booking_id,
											'module_type'=>'ru_member_table_booking',
											'notification_type'=>3,//table booking allocation related notitfication
											'is_read'=>0,
											'created'=>date('Y-m-d H:i:s'),
											'updated'=>date('Y-m-d H:i:s')
											);
				$this->Dash_model->insert_one_row('ru_notifications',$notificationData1);
			/*****************End send notification for refresh each user screen*********************/
			
		redirect('dashboard');
	}
}	