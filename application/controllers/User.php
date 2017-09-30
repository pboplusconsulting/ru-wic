<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
	    //$this->load->model('Base_model');
		$this->load->helper('security');
		if($this->session->userdata('userRole')!=1)// && $this->session->userdata('userRole')!=2)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
    }
	
	/**
	 **default function for User controller
	 **
	 */
	
	public function index()
	{
		$offset=$this->uri->segment(3)?$this->uri->segment(3):0;
		$limit=5;
		$searchterm='';//print_r($_POST);die();
		if(isset($_POST['search']))
		{
			$searchterm=$this->input->post('search_str');
		}	
		
        $search_str =$this->Base_model->searchterm_handler($searchterm);
		//echo $search_str;die();
		if(!empty($search_str))
		{
			$query='SELECT * FROM ru_users WHERE name LIKE "%'.$search_str.'%"';
			$query1='SELECT * FROM ru_users WHERE name LIKE "%'.$search_str.'%" ORDER BY name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}	
		else
		{	
			$query='SELECT * FROM ru_users';
			$query1='SELECT * FROM ru_users ORDER BY name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}
		//$user_count=$this->Base_model->user_count('ru_users','');	
		$user_count=$this->Base_model->result_count($query);
		
	    $this->load->library('pagination');

		$config['base_url'] = base_url().'user/index/';
		$config['total_rows'] = $user_count;
		$config['per_page'] = $limit;
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
        
	    
		$user_data['data']=$this->Base_model->get_by_query($query1);   
	     //$user_data['data']=$this->Base_model->get_pagination_data_simple('ru_users',$config['per_page'],$this->uri->segment(3),'user_id>0','name','ASC');
		$heading['heading']="Users";
		//print_r($user_data);
		//exit;
		$user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
		$user_data['search_str']=$search_str;
		$this->load->view('header',$heading);
		$this->load->view('user/index.php',$user_data);
		$this->load->view('footer.php');
	}
	
	/**
	 **Create new user
	 **
	 */
	public function add_user()
	{
	    if(isset($_POST['add_user']))  
		{
		    $this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('email_id','Email','trim|required|valid_email|is_unique[ru_users.email_id]');
			$this->form_validation->set_rules('contact_no','Contact No','trim|required|is_unique[ru_users.phone_number]');
			$this->form_validation->set_rules('role','Role','trim|required');
			$this->form_validation->set_rules('user_pwd','Password','trim|required|min_length[4]');
			if($this->form_validation->run()==false) {
				
				$user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
				$heading['heading']="Add New User";
			   	$this->load->view('header',$heading);
			    $this->load->view('user/add_user.php',$user_data);
				$this->load->view('footer.php');
			    //echo "form validation failed"; 	
				
			}else {
			
			if(!empty($_FILES['profilePic']['name'])){
 						//echo base_url().'images/users/';exit;
						//file upload configurtion
						$config['upload_path'] = 'images/users/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['overwrite'] = TRUE;
						$config['max_size']     = '3000';
						$config['max_width'] = '500';
						$config['max_height'] = '500';

						$this->load->library('upload', $config);
						if($this->upload->do_upload('profilePic')){
							      $data=array(
										'name'=>xss_clean($this->input->post('name')),
										'email_id'=>xss_clean($this->input->post('email_id')),
										'phone_number'=>xss_clean($this->input->post('contact_no')),
										'role'=>xss_clean($this->input->post('role')),
										'password'=>md5(xss_clean($this->input->post('user_pwd'))),
										'image'=>$this->upload->data()['file_name'],
										'status'=>1,
										'modify_time'=>date("Y-m-d h:i:sa",time()),
										);
							$insertID=$this->Base_model->insert_one_row('ru_users',$data);
							if($insertID)
							{
							    $message="Hello ".$this->input->post('name')."<br><br>Pleased to inform you that your account has been created. Credentials for the same is given below.<br><br><b>Link:</b> ".base_url()."<br><b>Username:</b> ".
								$this->input->post('username')."<br><b>Password:</b> ".$this->input->post('password');
							   
                               $eData=array('user'=>$this->input->post('name'),'username'=>$this->input->post('email_id'),'password'=>$this->input->post('user_pwd'),'url'=>base_url());
							    //$message=$this->load->view('email_templates/user_act_confirmation',$eData,true);
							   //echo $message;exit;
							   
							   $email_data=array(
								                  'email'=>$this->input->post('email_id'),
												  'subject'=>'User Confirmation',
												  'message'=>$message,
												  'attachment'=>''
												  );
							     $email_status=$this->Base_model->send_email($email_data);	
							     			  
							    if($email_status===true)
								    $this->session->set_flashdata('flashSuccess', 'New User Added successfully.'); 
							    else
                                {								
									$this->session->set_flashdata('flashSuccess', 'New user created successfully.');
									$this->session->set_flashdata('flashError', 'Oops! Email sending failed');
                                }	
                             								
							}
							else
							{
								$this->session->set_flashdata('flashError', 'Oops! Some problem to add new user');
								
							}
							redirect('user'); 
							
						}else{
						      $upload_error=$this->upload->display_errors();
							 // echo $upload_error;exit;
							  $this->session->set_flashdata('flashError', 'Oops! '.$upload_error);
							  $heading['heading']="Add New User";
							 
							 	$this->load->view('header',$heading);
								$this->load->view('user/add_user.php');
								$this->load->view('footer.php');
                            
						}
				  }else {
					  
					      $data=array(
										'name'=>xss_clean($this->input->post('name')),
										'email_id'=>xss_clean($this->input->post('email_id')),
										'phone_number'=>xss_clean($this->input->post('contact_no')),
										'role'=>xss_clean($this->input->post('role')),
										'password'=>md5(xss_clean($this->input->post('user_pwd'))),
										//'image'=>$this->upload->data('profilePic'),
										'status'=>1,
										'modify_time'=>date("Y-m-d h:i:sa",time()),
										
										);
							$insertID=$this->Base_model->insert_one_row('ru_users',$data);
							if($insertID)
							{
							    $message="Hello ".$this->input->post('name')."<br><br>Pleased to inform you that your account has been created. Credentials for the same is given below.<br><br><b>Link:</b> ".base_url()."<br><b>Username:</b> ".
								$this->input->post('username')."<br><b>Password:</b> ".$this->input->post('password');
							   
                               $eData=array('user'=>$this->input->post('name'),'username'=>$this->input->post('email_id'),'password'=>$this->input->post('user_pwd'),'url'=>base_url());
							   // $message=$this->load->view('email_templates/user_act_confirmation',$eData,true);
							   //echo $message;exit;
							   
							   $email_data=array(
								                  'email'=>$this->input->post('email_id'),
												  'subject'=>'User Confirmation',
												  'message'=>$message,
												  'attachment'=>''
												  );
							     $email_status=$this->Base_model->send_email($email_data);	
								 
							    if($email_status===true)
								    $this->session->set_flashdata('flashSuccess', 'New User Added successfully.'); 
							    else
                                {								
									$this->session->set_flashdata('flashSuccess', 'New user created successfully.');
									$this->session->set_flashdata('flashError', 'Oops! Email sending failed');
                                }									
							}
							else
							{
								$this->session->set_flashdata('flashError', 'Oops! Some problem to add new user');
							}
							redirect('user');   
					  
				  }	
				
			} 
			
			}
		else
		{
			
			$user_data['roles']=$this->Base_model->get_record_by_order('ru_user_roles','role_name');
			
			//print_r($user_data);
			$heading['heading']="Add new User";
		   	$this->load->view('header',$heading);
			$this->load->view('user/add_user.php',$user_data);
			$this->load->view('footer.php');
		}
	}
	
	
	/**
	 **Edit user
	 **This function will be used to edit details of user
	 */
	public function edit_user()
	{
	    $user_id=$this->uri->segment(3);
		$userDetails=$this->Base_model->get_record_by_id('ru_users',array('user_id'=>$user_id));//print_r($userDetails);exit;
		
		$user_data['data']=$userDetails;
		//print_r($user_data['data']);exit;
	    if(isset($_POST['edit_user']))
		{
		    $this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('email_id','Email','trim|required|valid_email');
			$this->form_validation->set_rules('contact_no','Contact No','trim|required');
			$this->form_validation->set_rules('password', 'Password', 'callback_validate_password');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			
			$this->form_validation->set_rules('email_id','Email','callback_is_unique_excluding_own[email_id]');
			$this->form_validation->set_rules('contact_no','Contact No','callback_is_unique_excluding_own[phone_number]');
						
			$this->form_validation->set_message('validate_password','must have minimum length 4 character');
			$this->form_validation->set_message('is_unique_excluding_own','Field Should be unique');
			
			
			//var_dump($this->form_validation->run());exit;
			if($this->form_validation->run())
			{
				$password=$this->input->post('user_pwd');
				
				//print_r($_FILES);
			   if($_FILES['profilePic']['name']!='')
				{//echo base_url().'images/users/';exit;
						//file upload configurtion
						$config['upload_path'] = 'images/users/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['overwrite'] = TRUE;
						$config['max_size']     = '3000';
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
											'email_id'=>xss_clean($this->input->post('email_id')),
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'role'=>xss_clean($this->input->post('role')),
											'password'=>md5(xss_clean($this->input->post('user_pwd'))),
											'image'=>$this->upload->data()['file_name'],
											'status'=>1,
											);
							}
                            else
                            {
							       $data=array(
											'name'=>xss_clean($this->input->post('name')),
											'email_id'=>xss_clean($this->input->post('email_id')),
											'phone_number'=>xss_clean($this->input->post('contact_no')),
											'role'=>xss_clean($this->input->post('role')),
											'image'=>$this->upload->data()['file_name'],
											'status'=>1,
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											);
							}							
							$this->Base_model->update_record_by_id('ru_users',$data,array('user_id'=>$this->uri->segment(3)));
						//redirect('user/index'); 			
						     if(isset($_SESSION['page_uri']))
						        redirect($_SESSION['page_uri']);
					         else	
				                 redirect('user');
						}
						else
						{
						      $upload_error=$this->upload->display_errors();
							  //echo $upload_error;exit;
							  $this->session->set_flashdata('flashError', 'Oops! '.$upload_error);
							  $user_data['roles']=$this->Base_model->get_record_by_order('ru_roles','role');
							 	$user_data['inactive_users']=$this->Base_model->get_all_record_by_condition('ru_users',array('status'=>0));
								$heading['heading']="Edit User";
								$this->load->view('header',$heading);
								$this->load->view('user/edit_user.php',$user_data);
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
											'status'=>1,
											'modify_time'=>date("Y-m-d h:i:sa",time()),
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
											//'image'=>$this->upload->data()['file_name'],
											'status'=>1,
											'modify_time'=>date("Y-m-d h:i:sa",time()),
											);
						  }
						  
					$this->Base_model->update_record_by_id('ru_users',$data,array('user_id'=>$this->uri->segment(3)));
                                 
				
				
				$this->session->set_flashdata('flashSuccess', 'User details modified successfully.');

				//redirect('user/index');	
				if(isset($_SESSION['page_uri']))
					redirect($_SESSION['page_uri']);
				else	
					redirect('user');
					
				}
               			
			}
			else
			{
				$user_data['inactive_users']=$this->Base_model->get_all_record_by_condition('ru_users',array('status'=>0));
				$user_data['roles']=$this->Base_model->get_record_by_order('ru_uesr_roles','role_name');
				$heading['heading']="Edit User";
			    $this->load->view('header',$heading);
			    $this->load->view('user/edit_user.php',$user_data);
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
			$this->load->view('user/edit_user.php',$user_data);
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
	     $this->db->where($column,$value);
		 $this->db->where('user_id !=',$this->uri->segment(3));
		 $result=$this->db->get('ru_users');
		 //echo $result->num_rows();exit;
		 if($result->num_rows() > 0)
		 return false;
		 else
		 true;
	 }
	 
	 
	 /**
	 **Delete user
	 **This function will delete user
	 */
	public function delete_user()
	{
	    $user_id=$this->uri->segment(3);
		//echo $user_id;
		$this->Base_model->delete_record_by_id('ru_users',array('user_id'=>$user_id));
		$this->session->set_flashdata('flashSuccess', 'One User deleted Succeessfully.');
		redirect('User');
	}
	
	public function change_status()
	{
	    $user_id=$this->uri->segment(3);
		$status=$this->uri->segment(4);
		//echo $user_id;
		$this->Base_model->update_record_by_wherein('ru_users', array('status'=>$status),array('id'=>$user_id));
		$this->session->set_flashdata('flashSuccess', 'User Modified Sucessfully');
		redirect('User');
	}

}