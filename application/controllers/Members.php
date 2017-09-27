<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

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
	    $this->load->model('Membership_model');
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
    }
	
	/**
	 **default function for members controller
	 **
	 */
	
	
	public function index()
	{
		$member_count=$this->Membership_model->result_count('ru_membership',array('status'=>1));
        $limit=10;
		$offset=$this->uri->segment(3);
		$offset=$offset?$offset:0;
		$this->load->library('pagination');

		$config['base_url'] = base_url().'members/index/';
		$config['total_rows'] = $member_count;
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
		
		$member_data['data']=$this->Membership_model->get_result_by_query("SELECT * FROM ru_membership WHERE status=1 ORDER BY member_name ASC LIMIT ".$config['per_page']." OFFSET ".$offset);
		$heading['heading']="Members";
		$this->load->view('header',$heading);
		$this->load->view('members/member_list.php',$member_data);
		$this->load->view('footer.php');		
	}
	
	/*
	public function add_member()
	{
	    
		if(isset($_POST['add_member']))
		{
				$membership_id=xss_clean($this->input->post('membership_id'));
				$member_name=xss_clean($this->input->post('member_name'));
				$email_id=xss_clean($this->input->post('email_id'));
				$phone_number=xss_clean($this->input->post('phone_number'));
				$membership_type=xss_clean($this->input->post('membership_type'));
				$date_of_birth=xss_clean($this->input->post('date_of_birth'));
				$marital_status=xss_clean($this->input->post('marital_status'));
				$anniversary_date=xss_clean($this->input->post('anniversary_date'));
				if($marital_status==2){$anniversary_date='';}
				//$status=xss_clean($this->input->post('status'));
				$memberData=array(
				                'membership_id'=>$membership_id,
				                'member_name'=>$member_name,
								'email_id'=>$email_id,
								'phone_number'=>$phone_number,
								'membership_type'=>$membership_type,
								'date_of_birth'=>$date_of_birth,
								'marital_status'=>$marital_status,
								'anniversary_date'=>$anniversary_date,
								'status'=>1,
								'modify_time'=>date("Y-m-d h:i:sa",time()),
							    );
				$insertId=$this->Membership_model->insert_one_row('ru_membership',$memberData);
                if($insertId)
				{	
                   $this->session->set_flashdata('flashSuccess','<b>Success!</b> Member added successfully.');
				   redirect('members');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('members/add_member');	
                }					
							
		}
        else
		{
			$heading['heading']="Add New member";
			$this->load->view('header',$heading);
			$this->load->view('members/add_member.php');
			$this->load->view('footer.php');
		}
	
	}*/
	
	/**
	 **Edit members
	 **This function will be used to edit details of members
	 */
	 /*
	public function edit_member()
	{
	    $id=$this->uri->segment(3);
		$membersDetails=$this->Membership_model->get_record_by_id('ru_membership',array('id'=>$id));
		//print_r($membersDetails);exit;
		
		$members_data['data']=$membersDetails;
		//print_r($members_data['data']);exit;
	    if(isset($_POST['edit_member']))
		{
	          $membership_id=xss_clean($this->input->post('membership_id'));
				$member_name=xss_clean($this->input->post('member_name'));
				$email_id=xss_clean($this->input->post('email_id'));
				$phone_number=xss_clean($this->input->post('phone_number'));
				$membership_type=xss_clean($this->input->post('membership_type'));
				$date_of_birth=xss_clean($this->input->post('date_of_birth'));
				$marital_status=xss_clean($this->input->post('marital_status'));
				$anniversary_date=xss_clean($this->input->post('anniversary_date'));
				if($marital_status==2){$anniversary_date='';}
				//$status=xss_clean($this->input->post('status'));
				$memberData=array(
				                'membership_id'=>$membership_id,
				                'member_name'=>$member_name,
								'email_id'=>$email_id,
								'phone_number'=>$phone_number,
								'membership_type'=>$membership_type,
								'date_of_birth'=>$date_of_birth,
								'marital_status'=>$marital_status,
								'anniversary_date'=>$anniversary_date,
								'status'=>1,
								'modify_time'=>date("Y-m-d h:i:sa",time()),
							    );
		  $update = $this->Base_model->update_record_by_id('ru_membership',$memberData,array('id'=>$this->uri->segment(3)));
		   if($update)
				{	
                   $this->session->set_flashdata('flashSuccess','<b>Success!</b> Member updated successfully.');
				   redirect('members');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('members/add_member');	
                }	
		}
		else
		{
			
		    $heading['heading']="Edit members";
		   	$this->load->view('header',$heading);
			$this->load->view('members/edit_member.php',$members_data);
			$this->load->view('footer.php');
		}
	 }
	 
	/**
	 **validate_password
	 **This function is used to custom validate password
	 */ 
	 /*
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
	 */
	/**
	 **is_unique_excluding_own
	 **This function will check whether entered value in a column is unique excluding its own value
	 */ 
	 /*
	public function is_unique_excluding_own($value,$column)
	 {//echo $column.'  '.$value;exit;
	     $this->db->where($column,$value);
		 $this->db->where('members_id !=',$this->uri->segment(3));
		 $result=$this->db->get('ru_membership');
		 //echo $result->num_rows();exit;
		 if($result->num_rows() > 0)
		 return false;
		 else
		 true;
	 }
	 */
	 
	 /**
	 **Delete members
	 **This function will delete members
	 */
	 /*
	public function delete_member()
	{
	    $id=$this->uri->segment(3);
		//echo $members_id;
		$this->Membership_model->delete_record_by_id('ru_membership',array('id'=>$id));
		$this->session->set_flashdata('flashSuccess', 'One member deleted Succeessfully.');
		redirect('members');
	}
	*/
	/*
	public function change_status()
	{
	    $members_id=$this->uri->segment(3);
		 $status=$this->uri->segment(4);
		//echo $members_id;
		$this->Membership_model->update_record_by_wherein('ru_membership', array('status'=>$status),array('id'=>$members_id));
		$this->session->set_flashdata('flashSuccess', 'members Modified Sucessfully');
		redirect('members');
	}
	
	*/

}