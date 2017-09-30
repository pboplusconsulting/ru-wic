<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
         if(!isset($_SESSION['isLogin']))
        redirect('Login');
         
        $this->load->model('Reports_model');
		
		//if($this->session->userdata('userRole')!=2)// || $this->session->userdata('userRole')==2)
			if($this->session->userdata('userRole')==3 || $this->session->userdata('userRole')==4)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
		
    }
	public function index()
	{
		if(isset($_POST['dateFilter']))
		{
			$query= "SELECT id,member_name FROM ru_membership WHERE status ='1' ORDER BY member_name ASC";
			$data['members']=$this->Reports_model->get_by_query($query);
			$memberId=$this->input->post('members');			
			$data['memberId']=$memberId;
		    
			$dateRange=$this->input->post('daterange');			
			$data['dateRange']=$dateRange;
		    $heading['heading']="Reports";
		    $this->load->view('header',$heading);
			$this->load->view('reports/ru_mis_report',$data);
			$this->load->view('footer.php');
		}
		else
		{	
            $query= "SELECT id,member_name FROM ru_membership WHERE status ='1' ORDER BY member_name ASC";
			$data['members']=$this->Reports_model->get_by_query($query);						
			$data['dateRange']='';
			$data['memberId']='';
			$heading['heading']="Reports";
		    $this->load->view('header',$heading);
			$this->load->view('reports/ru_mis_report',$data);
			$this->load->view('footer.php');
		}
	}
	
	public function feedback_report()
	{
		if(isset($_POST['dateFilter']))
		{
			$dateRange=$this->input->post('daterange');//echo $dateRange;die();
            $range=explode('-',$dateRange);
            $daterange1=trim($range[0]);
            $daterange2=trim($range[1]);
            $daterange1=date_format(date_create_from_format('d/m/Y',$daterange1),'Y-m-d');
            $daterange2=date_format(date_create_from_format('d/m/Y',$daterange2),'Y-m-d');
			
			$query="SELECT a.*,b.no_of_guest,b.booking_time,b.table_booking_no,c.membership_id,c.member_name,d.name as server FROM ru_feedback a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_membership c ON b.member_id=c.id LEFT JOIN ru_users d ON b.waiter_id=d.user_id WHERE a.feedback_generation_time >='".$daterange1." 00:00:00' AND a.feedback_generation_time <= '".$daterange2." 23:59:59' AND a.cancel_reason='' AND a.status=1 ORDER BY a.modify_time";
			$feedbacks=$this->Reports_model->get_by_query($query);
			//echo "<pre>";print_r($result);echo "</pre>";die();
			$data['feedbacks']=$feedbacks;
			$data['dateRange']=$dateRange;
			$heading['heading']="Reports";
		    $this->load->view('header',$heading);
			$this->load->view('reports/ru_member_feedback_report',$data);
			$this->load->view('footer.php');
		}
        else
        {
			$query="SELECT a.*,b.no_of_guest,b.booking_time,b.table_booking_no,c.membership_id,c.member_name,d.name as server FROM ru_feedback a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_membership c ON b.member_id=c.id LEFT JOIN ru_users d ON b.waiter_id=d.user_id WHERE a.feedback_generation_time >='".date('Y-m-d')." 00:00:00' AND a.feedback_generation_time <= '".date('Y-m-d')." 23:59:59' AND a.cancel_reason='' AND a.status=1";
			$feedbacks=$this->Reports_model->get_by_query($query);
			//echo "<pre>";print_r($result);echo "</pre>";die();
			$data['feedbacks']=$feedbacks;
			$data['dateRange']='';
			$heading['heading']="Reports";
		    $this->load->view('header',$heading);
			$this->load->view('reports/ru_member_feedback_report',$data);
			$this->load->view('footer.php');
		}
	}
	
	
	public function download_feedback_report()
	{
		$dateRange=$this->input->get('daterange');
		$daterange1=date('Y-m-d');
		$daterange2=date('Y-m-d');
		if(!empty($dateRange))
		{
			$range=explode('-',$dateRange);
			$daterange1=trim($range[0]);
			$daterange2=trim($range[1]);
			$daterange1=date_format(date_create_from_format('d/m/Y',$daterange1),'Y-m-d');
			$daterange2=date_format(date_create_from_format('d/m/Y',$daterange2),'Y-m-d');
		}	
		
		$query="SELECT a.*,b.no_of_guest,b.booking_time,b.table_booking_no,c.membership_id,c.member_name,d.name as server FROM ru_feedback a JOIN ru_member_table_booking b ON a.table_booking_id=b.table_booking_id JOIN ru_membership c ON b.member_id=c.id LEFT JOIN ru_users d ON b.waiter_id=d.user_id WHERE a.feedback_generation_time >='".$daterange1." 00:00:00' AND a.feedback_generation_time <= '".$daterange2." 23:59:59' AND a.cancel_reason='' AND a.status=1";
		$feedbacks=$this->Reports_model->get_by_query($query);
		$data['feedbacks']=$feedbacks;
		$data['dateRange']=$dateRange;
					//echo "<pre>";print_r($feedbacks);echo "</pre>";die();
		
		@ob_end_clean();
		ob_start();
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$report=$this->load->view('reports/excel-view/member_feedback_report',$data,true);	
		echo $report;
	}
	
	public function download_mis_report()
	{
		$dateRange=$this->input->get('daterange');
		$data['dateRange']=$dateRange;
		
		$memberId=$this->input->get('memberid');
		$data['memberId']=$memberId;
		
		
		@ob_end_clean();
		ob_start();
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$report=$this->load->view('reports/excel-view/mis_report',$data,true);		
		echo $report;		
	}
}
