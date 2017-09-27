<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

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
	    $this->load->model('Manager_model');
		if($this->session->userdata('userRole')!=2)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}	
    }
	
	
	public function index()
	{
		if(isset($_POST['orderFilter']))
		{
			$range1=$this->input->post('daterange1');
			$range2=$this->input->post('daterange2');
			
			$daterange1=date_format(date_create_from_format('d/m/Y',$range1),'Y-m-d').' 00:00:00';
			$daterange2=date_format(date_create_from_format('d/m/Y',$range2),'Y-m-d').' 23:59:59';
			
			$query="SELECT a.*,b.member_name,d.table_name FROM ru_order_bill a LEFT JOIN ru_membership b ON a.member_id=b.id LEFT JOIN ru_member_table_booking c ON a.table_booking_id=c.table_booking_id LEFT JOIN ru_tables d ON c.table_booking_no=d.id WHERE a.bill_generation_time>='".$daterange1."' AND a.bill_generation_time<='".$daterange2."'";	
			
			$orderReport['data']=$this->Manager_model->get_by_query($query);
			$orderReport['daterange1']=	$range1;
            $orderReport['daterange2']=	$range2;			
			$this->load->view('header.php');
			$this->load->view('manager/order_report',$orderReport);
			$this->load->view('footer.php');
		}
	    else
		{
			$daterange1=date('Y-m-d').' 00:00:00';
			$daterange2=date('Y-m-d').' 23:59:59';
            $query="SELECT a.*,b.member_name,d.table_name FROM ru_order_bill a LEFT JOIN ru_membership b ON a.member_id=b.id LEFT JOIN ru_member_table_booking c ON a.table_booking_id=c.table_booking_id LEFT JOIN ru_tables d ON c.table_booking_no=d.id WHERE a.bill_generation_time>='".$daterange1."' AND a.bill_generation_time<='".$daterange2."'";	
			$orderReport['data']=$this->Manager_model->get_by_query($query);
            $orderReport['daterange1']=	'';
            $orderReport['daterange2']=	'';		
			$this->load->view('header.php');
			$this->load->view('manager/order_report',$orderReport);
			$this->load->view('footer.php');
		}	
	}
	
	
	public function occupancy()
	{
		if(isset($_POST['occupancyFilter']))
		{
			$range1=$this->input->post('daterange1');
			$range2=$this->input->post('daterange2');
			
			$daterange1=date_format(date_create_from_format('d/m/Y',$range1),'Y-m-d').' 00:00:00';
			$daterange2=date_format(date_create_from_format('d/m/Y',$range2),'Y-m-d').' 23:59:59';
			
			$query="";	
			
			//$orderReport['data']=$this->Manager_model->get_by_query($query);
			$orderReport['daterange1']=	$range1;
            $orderReport['daterange2']=	$range2;			
			$this->load->view('header.php');
			$this->load->view('manager/occupancy_report',$orderReport);
			$this->load->view('footer.php');
		}
	    else
		{
			$daterange1=date('Y-m-d').' 00:00:00';
			$daterange2=date('Y-m-d').' 23:59:59';
            $query="";	
			//$orderReport['data']=$this->Manager_model->get_by_query($query);
            $orderReport['daterange1']=	'';
            $orderReport['daterange2']=	'';		
			$this->load->view('header.php');
			$this->load->view('manager/occupancy_report',$orderReport);
			$this->load->view('footer.php');
		}
	}
	
	public function advance_table_booking()
	{
		
		
		if(isset($_POST['save_advance_table_booking']))
		{
			$this->form_validation->set_rules('bookingdate','Date','trim|required');
			$this->form_validation->set_rules('table','Table','trim|required');
			if($this->form_validation->run()==false)
			{
				$this->load->view('header.php');
				$this->load->view('manager/advance_table_booking');
				$this->load->view('footer.php');
			}
            else
            {
				$bookingDate=$this->input->post('bookingdate');
				$table_id=$this->input->post('table');
				$bookingDate=date_format(date_create_from_format('d/m/Y',$bookingDate),'Y-m-d');
				$boodingTable=array(
				                    'table_id'=>$table_id,
									'booked_for_date'=>$bookingDate,
									'booked_by_user'=>$this->session->userdata('userID'),
									'booking_status'=>1,
									'created'=>date('Y-m-d H:i:s'),
									'updated'=>date('Y-m-d H:i:s')
									);
				$bookingId=$this->Manager_model->insert_one_row('ru_advance_table_booking',$boodingTable);
				if($bookingId)
				{
				    $this->session->set_flashdata('flashSuccess','<b>Success! </b>Your advance booking confirmed.');
				}
                else
                {
				    $this->session->set_flashdata('flashError','<b>Oops! </b>Something went wrong. Please try again.');					
				}					
				redirect('manager/advance_table_booking');
			}				
		}	
		else
		{
			$this->load->view('header.php');
		    $this->load->view('manager/advance_table_booking');
		    $this->load->view('footer.php');
		}	
	}
	
	public function table_availability_on_date()
	{
		$inutDate=$this->input->post('inputDate');
		$inutDate=date_format(date_create_from_format('d/m/Y',$inutDate),'Y-m-d');
		
		$query="SELECT a.id,a.table_name,IF((SELECT count(*) FROM ru_advance_table_booking b WHERE b.table_id=a.id AND b.booked_for_date='".$inutDate."' AND b.booking_status=1),1,0) AS Adv_book_sts,IF((SELECT COUNT(*) FROM ru_member_table_booking c WHERE FIND_IN_SET(a.id,c.table_booking_no) AND c.booking_time>'".$inutDate." 00:00:00' AND c.booking_time<='".$inutDate." 23:59:59' AND c.table_status=1),1,0) AS booking_status FROM ru_tables a WHERE a.status=1";
		$tables=$this->Manager_model->get_by_query($query);
		echo json_encode($tables);
	}
	
	public function share_notification()
	{
		if(isset($_POST['send_notification']))
		{
            $this->form_validation->set_rules('message','Message','trim|required');
			if($this->form_validation->run()==false)
			{
				$this->load->view('header.php');
				$this->load->view('manager/share_notification');
				$this->load->view('footer.php');
			}
            else
            {
				$message=$this->input->post('message');
				$allUsers=$this->Manager_model->get_by_query("SELECT user_id,name FROM ru_users WHERE status=1");
				$notification=0;
				foreach($allUsers as $user)
				{
					$notificationData=array(
										'from_user_id'=>$this->session->userdata('userID'),
										'to_user_id'=>$user['user_id'],
										'message'=>$message,
										'module_id'=>0,
										'module_type'=>'',
										'notification_type'=>2,
										'is_read'=>0,
										'created'=>date('Y-m-d H:i:s'),
										'updated'=>date('Y-m-d H:i:s')
										);
				    $notification+=$this->Manager_model->insert_one_row('ru_notifications',$notificationData);
				}
				if($notification)
				{
				    $this->session->set_flashdata('flashSuccess','<b>Success! </b>Your message has been shared to all employees.');
				}
                else
                {
				    $this->session->set_flashdata('flashError','<b>Oops! </b>Something went wrong. Please try again.');					
				}					
				redirect('manager/share_notification');
			}
		}	
		else
		{
			$this->load->view('header.php');
		    $this->load->view('manager/share_notification');
		    $this->load->view('footer.php');
		}	
	}
	
	
	public function member_list()
	{
		$query="SELECT a.* FROM ru_membership a WHERE a.status=1";
		$member_data['data']=$this->Manager_model->get_by_query($query);
		$heading['heading']="Members";
		$this->load->view('header',$heading);
		$this->load->view('manager/member_list.php',$member_data);
		$this->load->view('footer.php');
	}
	
	
	public function available_man_power()
	{
		$query="SELECT a.* FROM ru_users a WHERE a.status=1 AND a.is_logged_in=1 AND (a.role=3 OR a.role=4)";
		$member_data['data']=$this->Manager_model->get_by_query($query);
		$heading['heading']="Available Man Power";
		$this->load->view('header',$heading);
		$this->load->view('manager/available_man_power.php',$member_data);
		$this->load->view('footer.php');
	}
	
	
	public function best_selling_dish()
	{
		if(isset($_POST['dishFilter']))
		{
			$range1=$this->input->post('daterange1');
			$range2=$this->input->post('daterange2');
			
			$daterange1=date_format(date_create_from_format('d/m/Y',$range1),'Y-m-d').' 00:00:00';
			$daterange2=date_format(date_create_from_format('d/m/Y',$range2),'Y-m-d').' 23:59:59';
			
			$query="SELECT a.meal_id,b.meal_name,SUM(a.quantity) as total_quantity FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.order_time>='".$daterange1."' AND a.order_time<='".$daterange2."' Group By a.meal_id ORDER BY total_quantity DESC LIMIT 10";
			
			$member_data['data']=$this->Manager_model->get_by_query($query);
			
			$member_data['daterange1']=	$range1;
            $member_data['daterange2']=	$range2;			
			$heading['heading']="Best Selling Dish";
			$this->load->view('header.php',$heading);
			$this->load->view('manager/best_selling_dish',$member_data);
			$this->load->view('footer.php');
        }
        else
        {
            //$daterange1=date('Y-m-d').' 00:00:00';
			//$daterange2=date('Y-m-d').' 23:59:59';			
			$query="SELECT a.meal_id,b.meal_name,SUM(a.quantity) as total_quantity FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id Group By a.meal_id ORDER BY total_quantity DESC LIMIT 10";
			$member_data['data']=$this->Manager_model->get_by_query($query);
			
			$member_data['daterange1']=	'';
            $member_data['daterange2']=	'';
			$heading['heading']="Best Selling Dish";
			$this->load->view('header',$heading);
			$this->load->view('manager/best_selling_dish.php',$member_data);
			$this->load->view('footer.php');
		}	
	}
	
	public function download_file($name=NULL)
	{
	    //echo $name;die();	
		if($name)
		{
			$filepath='uploads/pdf/member_bill/'.$name;//echo $filepath;die();
			if(file_exists($filepath))
			{//echo $filepath;die();
				$this->load->helper('download');
				$data=file_get_contents($filepath);
				force_download($name,$data);
			}	echo 'outside';die();
		}
		redirect('manager');
	}	
}	