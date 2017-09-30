<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
    {
        parent::__construct();
         if(!isset($_SESSION['isLogin']))
        redirect('Login');
    }
	public function index()
	{
		    $heading['heading']="Dashboard";
			$this->load->view('header',$heading);
            $this->load->view('welcome_message');
			$this->load->view('footer.php');
		
	}
	
	/**
	**logout function
	**
	**/
	public function logout()
	{
		
		$this->Base_model->update_record_by_id('ru_users',array('is_logged_in'=>0,'session_id'=>''),array('user_id'=>$_SESSION['userID']));
		//print_r($_SESSION);exit;	
	     $this->session->sess_destroy();
		 //print_r($_SESSION);exit;
		 redirect('Login','refresh');
	}
}
