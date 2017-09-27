<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	/**
     **Constructor
	 */
	function __construct()
    {
        parent::__construct();
       /* if(!isset($_SESSION['isLogin']))
        redirect('Login');
	
	    if(!$this->Base_model->is_user_valid())
		{
			$this->session->sess_destroy();
		    redirect('Login','refresh');
		}*/
		$this->load->helper('security');
    }
	
	/**
	 **default function for  controller
	 **
	 */
	
	public function index()
	{
		$notf_count=$this->Base_model->countrows('ru_notifications',array('to_user_id'=>$this->session->userdata('userID'),'notification_type !='=>1));
		//echo $notf_count;die();
	    $this->load->library('pagination');

		$config['base_url'] = base_url().'notification/index/';
		$config['total_rows'] = $notf_count;
		$config['per_page'] = 10;
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        
		
	    $condition=array('to_user_id'=>$this->session->userdata('userID'),'notification_type !='=>1);
	    $notifications=$this->Base_model->get_pagination_data('ru_notifications a','ru_users b','a.from_user_id=b.user_id',$config['per_page'],$this->uri->segment(3),$condition,'created','DESC');
		$this->Base_model->update_record_by_id('ru_notifications',array('is_read'=>1),array('to_user_id'=>$this->session->userdata('userID')));
		$user_data['heading']="Notification";
		$user_data['notifications']=$notifications;
		$this->load->view('header.php');
		$this->load->view('notification/view_notification',$user_data);
		$this->load->view('footer.php');
	}
	
	
	public function single_notification_view()
    {
		$notification_id=$this->uri->segment(3);
		$query="SELECT a.*,b.name FROM ru_notifications a JOIN ru_users b ON a.from_user_id=b.user_id WHERE a.id=".$notification_id;
		$notificationData=$this->Base_model->get_by_query_return_row($query);
		$updateStatus=$this->Base_model->update_record_by_id('ru_notifications',array('is_read'=>1),array('id'=>$notification_id));
		
		//print_r($notificationData);die();
		$user_data['heading']="Notification";
		$user_data['notificationData']=$notificationData;
		$this->load->view('header.php');
		$this->load->view('notification/single_notification_view',$user_data);
		$this->load->view('footer.php');
	}	
	
	public function count_notifications()
	{	
		if(isset($_POST['action']) && $_POST['action']=='unread_count')
		{
			$refreshEventCount=$this->Base_model->get_by_query("(SELECT a.id FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id JOIN ru_member_table_booking c ON b.table_booking_id=c.table_booking_id AND c.table_status=1 WHERE a.to_user_id=0 and a.from_user_id!=".$this->session->userdata('userID')." AND a.notification_type=0) UNION (SELECT a.id FROM ru_notifications a JOIN ru_member_table_booking b ON a.module_id=b.table_booking_id AND b.booking_time >= '".date('Y-m-d')." 00:00:00' WHERE a.to_user_id=0 and a.from_user_id!=".$this->session->userdata('userID')." AND a.notification_type=3) ORDER BY id DESC LIMIT 1");
			$notificationCount['refreshEventCount']=$refreshEventCount;
			
			$query="SELECT a.* FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id JOIN ru_member_table_booking c ON b.table_booking_id=c.table_booking_id AND c.table_status=1 WHERE a.to_user_id=".$this->session->userdata('userID')." AND a.is_read=0";	
		    $notifications=$this->Base_model->get_by_query($query);
			$notificationCount['totalUnreadNotifications']=count($notifications);
			
			$query="SELECT a.id,@booking_id:=(SELECT table_booking_id FROM ru_member_table_booking WHERE FIND_IN_SET(a.id,table_booking_no) AND table_status=1) AS booking_id,@unread_order_notification:=(SELECT COUNT(*) FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND a.module_type='ru_table_wise_order' WHERE b.table_booking_id=@booking_id AND a.to_user_id=".$this->session->userdata('userID')." AND a.is_read=0) AS unread_order_notification FROM ru_tables a WHERE a.status=1 AND a.table_name!='Parcel'";//echo $query;die();
		    //echo count($notificationCount);
			$tableNotifications=$this->Base_model->get_by_query($query);
			//echo "<pre>";print_r($tableNotifications);echo "<pre>";die();
			
		   	$notificationCount['tableNotifications']=$tableNotifications; 
            
			$query2="SELECT a.table_booking_id,count(a.table_booking_id) AS unread_count FROM ru_table_wise_order a WHERE is_read=0 AND order_time='".date('Y-m-d')." 00:00:00'";
			$order_read_status=$this->Base_model->get_by_query($query);
			
			$notificationCount['order_read_status']=$order_read_status;
			
			$query3="SELECT a.module_id AS table_order_id,COUNT(a.module_id) AS order_msg,b.table_booking_id FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND b.order_time > '".date('Y-m-d')." 00:00:00' WHERE a.to_user_id=".$this->session->userdata('userID')." AND a.notification_type=1 AND a.is_read=0 GROUP BY a.module_id";
			$order_messages=$this->Base_model->get_by_query($query3);
			$notificationCount['order_messages']=$order_messages;
			
			$query4="SELECT b.table_booking_id,COUNT(b.table_booking_id) AS bkng_msg_cont FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND b.order_time > '".date('Y-m-d')." 00:00:00' WHERE a.to_user_id=".$this->session->userdata('userID')." AND a.notification_type=1 AND a.is_read=0 GROUP BY b.table_booking_id";
			$bkng_wise_msg_cont=$this->Base_model->get_by_query($query4);
			
			$notificationCount['bkng_wise_msg_cont']=$bkng_wise_msg_cont;
			
			echo json_encode($notificationCount);			
		
		}
        else if(isset($_POST['action']) && $_POST['action']=='total_count')
        {
			//return count($notificationCount);
		}			
	}
	
	public function notification_list()
	{
		$query="SELECT a.*,b.name FROM ru_notifications a JOIN ru_users b ON a.from_user_id=b.user_id WHERE to_user_id=".$this->session->userdata('userID')." ORDER BY created DESC LIMIT 5";
		$result=$this->Base_model->get_by_query($query);
		echo json_encode($result);
	}
	
	public function table_notification()
	{
		
		
		if(isset($_POST['action']) && $_POST['action']=='table_notification')
		{	$table_id=$this->input->post('table_id');
			$tableBookingData=$this->Base_model->get_by_query_return_row('SELECT table_booking_id FROM ru_member_table_booking WHERE FIND_IN_SET('.$table_id.',table_booking_no) AND table_status=1');
			
			if($tableBookingData == null)
			{
				return 0;
			}
			else
			{
				echo $tableBookingData->table_booking_id;
			}	
		}	
        else
        {
			$table_booking_id=$this->uri->segment(3);
			//echo "SELECT * FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND b.table_booking_id=".$table_booking_id." WHERE to_user_id=".$this->session->userdata('userID')." AND notification_type= 0";die();
			
			$notf_count=count($this->Base_model->get_by_query("SELECT * FROM ru_notifications a JOIN ru_table_wise_order b ON (a.module_id=b.table_order_id AND b.table_booking_id=".$table_booking_id.") WHERE a.to_user_id=".$this->session->userdata('userID')." AND a.notification_type= 0 AND a.is_read=0"));
			//echo $notf_count;die();
			$this->load->library('pagination');

			$config['base_url'] = base_url().'notification/table_notification/'.$table_booking_id.'/';
			$config['total_rows'] = $notf_count;
			$config['per_page'] = 10;
            $config["uri_segment"] = 4;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

			$this->pagination->initialize($config);		
			$query="SELECT a.*,c.name FROM ru_notifications a JOIN ru_table_wise_order b ON a.module_id=b.table_order_id AND b.table_booking_id=".$table_booking_id." JOIN ru_users c ON a.from_user_id=c.user_id WHERE to_user_id=".$this->session->userdata('userID')." AND notification_type= 0 AND a.is_read=0 ORDER BY a.created DESC LIMIT ".$config['per_page']." OFFSET ".($this->uri->segment(4)?$this->uri->segment(4):0);
			//echo $query;die();
			$notifications=$this->Base_model->get_by_query($query);
			//$notifications=$this->Base_model->get_pagination_data('ru_notifications a','ru_users b','a.from_user_id=b.user_id',$config['per_page'],$this->uri->segment(4),$condition,'created','DESC');
			
			foreach($notifications as $notification)
			{
			  $this->Base_model->update_record_by_id('ru_notifications',array('is_read'=>1),array('id'=>$notification['id']));
			} 
			
			$user_data['heading']="Notification";
			$user_data['notifications']=$notifications;
			$this->load->view('header.php');
			$this->load->view('notification/view_notification',$user_data);
			$this->load->view('footer.php');
		}			
	}
	
	public function order_status()
	{
		if(isset($_POST['action']) && $_POST['action']=='order_status')
		{
			$query="SELECT a.table_booking_id,COUNT(a.table_booking_id) AS delay FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE (a.order_status!=1 AND a.order_status!=0) AND UNIX_TIMESTAMP(a.order_time)+(a.quantity*b.meal_prepration_time*60) <".time()." AND a.order_time > '".date('Y-m-d')." 00:00:00' GROUP BY a.table_booking_id";
			//echo $query;die();
			$result=$this->Base_model->get_by_query($query);
			
			echo json_encode($result);
		}	
	}
	
    public function get_date()
    {
		echo time();
	}	
}