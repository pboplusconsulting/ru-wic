<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analysis extends CI_Controller {

	function __construct()
    {
        parent::__construct();
         if(!isset($_SESSION['isLogin']))
        redirect('Login');
         
        $this->load->model('Analysis_model');
		
		if($this->session->userdata('userRole')!=1 && $this->session->userdata('userRole')!=2)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
    }
	public function index()
	{
		if(isset($_POST['dateFilter']))
		{
            $dateRange=$this->input->post('daterange');
            $range=explode('-',$dateRange);
            $daterange1=trim($range[0]);
            $daterange2=trim($range[1]);
            $daterange1=date_format(date_create_from_format('d/m/Y',$daterange1),'Y-m-d');
            $daterange2=date_format(date_create_from_format('d/m/Y',$daterange2),'Y-m-d');

			$min_max_billing=$this->Analysis_model->min_max_billing($daterange1,$daterange2);
			$average_billing=$this->Analysis_model->average_billing($daterange1,$daterange2);
			$today_billing=$this->Analysis_model->today_billing();
			$menu=$this->Analysis_model->menu($daterange1,$daterange2);
			$hot_selling_dishes=$this->Analysis_model->hot_selling_dishes($daterange1,$daterange2);
			//$average_serve_time_per_dish=$this->Analysis_model->average_serve_time_per_dish($daterange1,$daterange2);
			$average_serve_time=$this->Analysis_model->average_serve_time($daterange1,$daterange2);
			//print_r($average_serve_time);die();
			$feedback=$this->Analysis_model->feedback($daterange1,$daterange2);//var_dump($feedback);die();
			$staff=$this->Analysis_model->staff();
			$noOfGuestServed=$this->Analysis_model->no_of_guest_served($daterange1,$daterange2);
			$relevantOccupancy=$this->Analysis_model->relevant_occupancy();
			
			$viewData['min_max_billing']=$min_max_billing;
			$viewData['average_billing']=$average_billing;
			$viewData['today_billing']=$today_billing;
			$viewData['menu']=$menu;
			$viewData['hot_selling_dishes']=$hot_selling_dishes;
			//$viewData['average_serve_time_per_dish']=$average_serve_time_per_dish;
			$viewData['average_serve_time']=$average_serve_time;
			
			$viewData['feedback']=$feedback;
			$viewData['staff']=$staff;
			$viewData['noOfGuestServed']=$noOfGuestServed;
			$viewData['relevantOccupancy']=$relevantOccupancy;
			
			$heading['heading']="Analysis";
			$heading['dateRange']=$dateRange;
			$this->load->view('header',$heading);
			$this->load->view('analysis/analysis',$viewData);
			$this->load->view('analysis/analysis_footer');
		}	
		else
		{	
			$min_max_billing=$this->Analysis_model->min_max_billing();
			$average_billing=$this->Analysis_model->average_billing();
			$today_billing=$this->Analysis_model->today_billing();
			$menu=$this->Analysis_model->menu();
			$hot_selling_dishes=$this->Analysis_model->hot_selling_dishes();
			//$average_serve_time_per_dish=$this->Analysis_model->average_serve_time_per_dish();
			$average_serve_time=$this->Analysis_model->average_serve_time();
			
			$feedback=$this->Analysis_model->feedback();//print_r($feedback);
			$staff=$this->Analysis_model->staff();
			$noOfGuestServed=$this->Analysis_model->no_of_guest_served();
			$relevantOccupancy=$this->Analysis_model->relevant_occupancy();
			
			$viewData['min_max_billing']=$min_max_billing;
			$viewData['average_billing']=$average_billing;
			$viewData['today_billing']=$today_billing;
			$viewData['menu']=$menu;
			$viewData['hot_selling_dishes']=$hot_selling_dishes;
			//$viewData['average_serve_time_per_dish']=$average_serve_time_per_dish;
			$viewData['average_serve_time']=$average_serve_time;
			
			$viewData['feedback']=$feedback;
			$viewData['staff']=$staff;
			$viewData['noOfGuestServed']=$noOfGuestServed;
			$viewData['relevantOccupancy']=$relevantOccupancy;
			
			$heading['heading']="Analysis";
			$heading['dateRange']='';
			$this->load->view('header',$heading);
			$this->load->view('analysis/analysis',$viewData);
			$this->load->view('analysis/analysis_footer');
		}
	}
}
