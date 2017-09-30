<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	/**
     **Constructor
	 */
	function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['isLogin']))
        redirect('Login');
	    if(!$this->Base_model->is_user_valid())
		{
			$this->session->sess_destroy();
			//$this->session->set_flashdata('flashError','<b>Force Logout!</b> Your session has been expired.');
			redirect('Login');
		}
		$this->load->helper('security');
    }
	
	/**
	 **default function for User controller
	 **
	 */
	
		public function edit_profile(){
		 error_reporting(0);
				$user_id = $this->session->userdata['userID'];
				$userDetails=$this->Base_model->get_record_by_id('ru_users',array('user_id'=>$user_id));//print_r($userDetails);exit;
		
		$user_data['data']=$userDetails;
		//print_r($user_data['data']);exit;
	    if(isset($_POST['edit_profile']))
		{
		    $this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('email_id','email_id','trim|required|valid_email');
			$this->form_validation->set_rules('contact_no','Contact No','trim|required');
			$this->form_validation->set_rules('password', 'Password', 'callback_validate_password');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			
			$this->form_validation->set_rules('email_id','email_id','callback_is_unique_excluding_own[email_id]');
			$this->form_validation->set_rules('contact_no','Contact No','callback_is_unique_excluding_own[phone_number]');
						
			$this->form_validation->set_message('validate_password','must have minimum length 4 character');
			$this->form_validation->set_message('is_unique_excluding_own','Field Should be unique');
			
			$inactive_users=xss_clean($this->input->post('inactive_users'));
			
			//var_dump($this->form_validation->run());exit;
			if($this->form_validation->run())
			{
				$password=$this->input->post('user_pwd');
			   if(!empty($_FILES['profilePic']['name']))
				{//echo base_url().'images/users/';exit;
						//file upload configurtion
						$config['upload_path'] = 'images/users/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['overwrite'] = TRUE;
						$config['max_size']     = '1000';
						$config['max_width'] = '500';
						$config['max_height'] = '500';

						$this->load->library('upload', $config);
						if($this->upload->do_upload('profilePic'))
						{//print_r( $this->upload->data());exit;
						    $data=array();
							if(empty($password))
							{
								
								$data=array(
											'name'=>xss_clean($this->input->post('name')),
											
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'role'=>xss_clean($this->input->post('role')),
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											'status'=>xss_clean($this->input->post('status')),
											'image'=>$this->upload->data()['file_name'],
											);
							}
                            else
                            {
							
										
										$data=array(
											'name'=>xss_clean($this->input->post('name')),
											
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'password'=>md5(xss_clean($this->input->post('user_pwd'))),
											'role'=>xss_clean($this->input->post('role')),
											'image'=>$this->upload->data()['file_name'],
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											'status'=>xss_clean($this->input->post('status')),
											);
							}							
							$this->Base_model->update_record_by_id('ru_users',$data,array('user_id'=>$user_id));
				     $this->session->set_flashdata('flashSuccess', 'User details modified successfully.');
						redirect('profile/edit_profile'); 			
						}
						else
						{
						      $upload_error=$this->upload->display_errors();
							  //echo $upload_error;exit;
							  $this->session->set_flashdata('flashError', 'Oops! '.$upload_error);
			                  $user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
							 	$user_data['inactive_users']=$this->Base_model->get_all_record_by_condition('ru_users',array('status'=>0));
								$heading['heading']="Edit User";
								$this->load->view('header',$heading);
								$this->load->view('profile/edit_profile.php',$user_data);
								$this->load->view('footer.php');
						}
				}else{
					
					$data =array();
						  if(empty($password))
						  {
							 $data=array(
											'name'=>xss_clean($this->input->post('name')),
											'email_id'=>xss_clean($this->input->post('email_id')),
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'role'=>xss_clean($this->input->post('role')),
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											'status'=>xss_clean($this->input->post('status')),
											);
						  }
						  else
						  {
							   $data=array(
											'name'=>xss_clean($this->input->post('name')),
											'email_id'=>xss_clean($this->input->post('email_id')),
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'password'=>md5(xss_clean($this->input->post('user_pwd'))),
											'role'=>xss_clean($this->input->post('role')),
											//'image'=>$this->upload->data('profilePic'),
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											'status'=>xss_clean($this->input->post('status')),
											);
						  }
						  
						  
					$this->Base_model->update_record_by_id('ru_users',$data,array('user_id'=>$user_id));
                                 
				
				if($userDetails->name != $this->input->post('name') || $userDetails->phone_no != $this->input->post('phone'))
                {/* 
					$eData=array('user'=>$this->input->post('name'),'username'=>$this->input->post('email_id'),'password'=>$this->input->post('user_pwd'),'url'=>base_url());
					$message=$this->load->view('email_templates/user_update',$eData,true);
					//echo $message;exit;
							   
				    $email_data=array(
									  'email_id'=>$this->input->post('email_id'),
									  'subject'=>'User update',
									  'message'=>$message,
									  'attachment'=>''
									  );
					$email_status=$this->Base_model->send_email($email_data); */
					//echo "User profile changed";exit;
				}
                else if($userDetails->email != $this->input->post('email_id') || $userDetails->password != md5($this->input->post('user_pwd')))
                {
					
					/* $eData=array('user'=>$this->input->post('name'),'username'=>$this->input->post('email_id'),'password'=>$this->input->post('user_pwd'),'url'=>base_url(),'static');
					$message=$this->load->view('email_templates/user_update2',$eData,true);
					//echo $message;exit;
							   
					$email_data=array(
									  'email_id'=>$this->input->post('email_id'),
									  'subject'=>'User update',
									  'message'=>$message,
									  'attachment'=>''
									  );
					$email_status=$this->Base_model->send_email($email_data);
					//echo "User credentials changed";exit; */
				}
				$this->session->set_flashdata('flashSuccess', 'User details modified successfully.');

				redirect('profile/edit_profile'); 	
					
				}
               			
			}
			else
			{
				$user_data['inactive_users']=$this->Base_model->get_all_record_by_condition('ru_users',array('status'=>0));
			    $user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
				$heading['heading']="Edit User";
			    $this->load->view('header',$heading);
			    $this->load->view('profile/edit_profile.php',$user_data);
				$this->load->view('footer.php');
			    //echo "form validation failed"; 
			}
			
		}
		else
		{
			$user_data['inactive_users']=$this->Base_model->get_all_record_by_condition('ru_users',array('status'=>0));
			$userDetails=$this->Base_model->get_record_by_id('ru_users',array('user_id'=>$user_id));
			$user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
		    $heading['heading']="Edit User";
		   	$this->load->view('header',$heading);
			$this->load->view('profile/edit_profile.php',$user_data);
			$this->load->view('footer.php');
		}
		} 
	 /**
	 **validate_password
	 **This function is used to custom validate password
	 */ 
	 
	 public function validate_password($str)
	 {
	     $str=trim($str);
	     if(empty($str))
		 return true;
		 else if(strlen($str)<4)
		 return false;
		 else
		 return true;
	 }
	 
	/**
	 **is_unique_excluding_own
	 **This function will check whether entered value in a column is unique excluding its own value
	 */ 
	public function is_unique_excluding_own($value,$column)
	 {//echo $column.'  '.$value;exit;
		  $user_id = $this->session->userdata['userID'];
	     $this->db->where($column,$value);
		 $this->db->where('user_id !=',$user_id);
		 $result=$this->db->get('ru_users');
		 //echo $result->num_rows();exit;
		 if($result->num_rows() > 0)
		 return false;
		 else
		 true;
	 }
		
	}