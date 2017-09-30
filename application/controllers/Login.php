<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
     **Constructor
	 */
	function __construct()
    {
        parent::__construct();
		if($this->session->userdata('isLogin')==true)
		{
			if($this->session->userdata('userRole')==4)
		        redirect('chef');
			else if($this->session->userdata('userRole')==5)
				redirect('bar_tendor');
			else if($this->session->userdata('userRole')==6)
				redirect('bistro');
		    
		    else
			    redirect('dashboard');
        }
		$this->load->helper('security');//print_r($_SESSION);die();
    }
	public function index()
	{
		
		//print_r(session_id()); echo "<pre>";print_r($this->Base_model->get_record_by_id('ru_users',array('email_id'=>'deepak.tyagi@logzerotechnologies.com')));echo "</pre>";die;
	    if(isset($_POST['login'])) //if login form is submited then goes here
		{
			
		    $this->form_validation->set_rules('ru_username','Email','trim|required');
			$this->form_validation->set_rules('ru_pwd','Password','trim|required');
			if($this->form_validation->run()==false)
			{
				//echo "sss";die;	
			   $this->load->view('login/login.php');
			}
			else
			{
			   $user_name=xss_clean($this->input->post('ru_username'));
			   $password=xss_clean($this->input->post('ru_pwd'));
			  // echo $user_name.'  '.$password;
			   $user_data=$this->Base_model->get_login_data('ru_users',$user_name,$password);
			 	//print_r($user_data);die;
			   if($user_data) {//print_r($user_data);exit;
			   //var_dump($user_data->session_id);echo "<br>";var_dump($this->session->userdata('my_session_id'));die();
			        if($user_data->status==0)
					{
						$this->session->set_flashdata('flashError', 'Your account is deactivated. Please contact to your admin.');
						$this->load->view('login/login.php');		
					}
			   		else if($user_data->is_logged_in==1 && $this->session->userdata('my_session_id')==null) {
						//if($user_data->session_id != $this->session->userdata('my_session_id'))
						//{					
							$this->session->set_flashdata('flashError', 'You are already loggedin in another browser or system.');
							$_SESSION['logout_usr_id']=$user_data->user_id;
						//}
						redirect('login');	
					}
					else{
					$uniqueId = session_id();//uniqid($this->CI->input->ip_address(), TRUE);
			        $session_data=array(
				                        'userID'=>$user_data->user_id,
										'userName'=>$user_data->email_id,
										'userRole'=>$user_data->role,
										'name'=>$user_data->name,
										'loginTime'=>date('Y-m-d H:i:s'),
										'my_session_id'=>$uniqueId,
										'isLogin'=>true
				                         );//print_r($session_data);
					$this->session->set_userdata($session_data);
					$this->Base_model->update_record_by_id('ru_users',array('is_logged_in'=>1,'session_id'=>$uniqueId),array('user_id'=>$user_data->user_id));
					redirect('login');
					}
			   }
			   else
			   {
			        $this->session->set_flashdata('flashError', 'Email or password is wrong');
					$this->load->view('login/login.php');
			   }
			   
			}
		}
		elseif(isset($_POST['force_logout'])) //if login form is submited then goes here
		{
			   if($_SESSION['logout_usr_id']) {
                    $uid = $_SESSION['logout_usr_id'];
					$this->Base_model->update_record_by_id('ru_users',array('is_logged_in'=>0,'session_id'=>''),array('user_id'=>$uid));
					$_SESSION['logout_usr_id']=0;
					redirect('login');	
			   }
			   else
			   {
			        $this->session->set_flashdata('flashError', 'Email or password is wrong');
					$this->load->view('login/login.php');
			   }
			   
			
		}
		else    //normal login page load
		{
		   $this->load->view('login/login.php');
		}
	}
	
	/**
	**Forgot password
	**This function will use to retrieve forgotton password
	**/
     public function forgot_password()
	{
	    if(isset($_POST['forgot_pass']))
		{//print_r($_POST);die();
		    $this->form_validation->set_rules('email','Email','trim|required|valid_email');
		  
		    if($this->form_validation->run()==false)
		    {
		        $this->load->view('login/forgot_password.php');
		    }
		    else
		    {
		        $email=xss_clean($this->input->post('email'));
			    $isUserExist=$this->Base_model->get_record_by_id('ru_users',array('email_id'=>$email));
			    //var_dump($isExist !=NULL);exit;
			    if($isUserExist !== NULL)
			    {
			        if($isUserExist->status == 0)
				    {
				        $this->session->set_flashdata('flashError', 'This account is deactivated. Please contact to your admin');
						redirect('login/forgot_password');
				    }
				    else
				    {
					    $user_id=$isUserExist->user_id; 
						$userData=$this->Base_model->get_record_by_id('ru_users',array('user_id'=>$user_id));
					    $random_code=rand(1000,9999);
					   
						$eData=array('user'=>$userData->name,'otp'=>$random_code);
						$message=$this->load->view('email_templates/forgot_pass',$eData,true);
						
					    //echo $message;exit;
					    $email_data=array(
										  'email'=>$email,
										  'subject'=>'Reset Password',
										  'message'=>$message,
										  'attachment'=>''
										  );
						$email_status=$this->Base_model->send_email($email_data);
                        //$email_status=true;
                                 								
						if(1)
						{
							$this->Base_model->update_record_by_id('ru_users',array('password_reset_code'=>$random_code),array('user_id'=>$user_id));
							$this->session->set_flashdata('flashSuccess', 'Please Check your mail for OTP.'); 
							redirect('login/reset_password/'.$user_id);
						}	
						else
						{								
							$this->session->set_flashdata('flashError', 'Oops! Email sending failed');
							redirect('login/forgot_password');
						}
				    }
			    }
			    else
			    {
			   	    $this->session->set_flashdata('flashError', 'Oops! Email You entered is not exist');
					redirect('login/forgot_password');
			    }
				
		    }
		}
		else
		{
		   $this->load->view('login/forgot_password.php');
		}
	}
	
	
	public function reset_password()
	{
	    $user_id=$this->uri->segment(3);
	    if(isset($_POST['reset_pass']))
	    {
	        $this->form_validation->set_rules('otp','One Time Password','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
			$this->form_validation->set_rules('conf_password','Confirm Password','trim|required|matches[password]');
			if($this->form_validation->run()==false)
			{
			    $this->load->view('login/reset_password');
			}
			else
			{
			    $otp=xss_clean($this->input->post('otp'));
				$password=xss_clean($this->input->post('password'));
				$user=$this->Base_model->get_record_by_id('ru_users',array('user_id'=>$user_id,'password_reset_code'=>$otp));
				//var_dump($user);exit;
				if($user !== NULL)
				{
				    $this->Base_model->update_record_by_id('ru_users',array('password'=>md5($password)),array('user_id'=>$user_id));
				}
				else
				{
                    $this->session->set_flashdata('flashError', 'Oops! Invalid OTP, Please try again later.');	
                    redirect('Login/forgot_password');					
				}
				$this->session->set_flashdata('flashError', 'Your password has been updated successfully.');
				redirect('Login');
			}
	    }
	    else
	    {
			$this->load->view('login/reset_password');
	    }
	} 
}
