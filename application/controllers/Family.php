<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

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
	    $this->load->model('Family_model');
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
    }
	public function index()
	{
		$limit=2;
		$offset=$this->uri->segment(3);
		$offset=$offset?$offset:0;
		$fmember_count=$this->Family_model->result_count('SELECT * FROM ru_member_family_member a JOIN ru_membership b ON a.member_id=b.id WHERE a.status=1');	
		
	    $this->load->library('pagination');

		$config['base_url'] = base_url().'family/index/';
		$config['total_rows'] = $fmember_count;
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
		
		$query='SELECT * FROM ru_member_family_member a JOIN ru_membership b ON a.member_id=b.id WHERE a.status=1 LIMIT '.$limit.' OFFSET '.$offset;
		$familyMemberData['data']=$this->Family_model->get_by_query($query);
		$heading['heading']="Family Members";
		$this->load->view('header',$heading);
		$this->load->view('family/backend/family_member_list',$familyMemberData);
		$this->load->view('footer.php');
	}
	
	
	/*********************************Add new Family Member***************************************/
	public function add_member()
	{
		$members['members']=$this->Family_model->get_array_of_object('ru_membership','id,member_name',array('id!='=>0));
		if(isset($_POST['add_new_member']))
		{
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('member','Member','trim|required');
			$this->form_validation->set_rules('relation','Relation','trim|required');
			$this->form_validation->set_rules('email','Email Id','trim');
			$this->form_validation->set_rules('contact','Contact No','trim');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Add New Member";
				$this->load->view('header',$heading);
				$this->load->view('family/backend/add_member',$members);
				$this->load->view('footer.php');
			}
            else
            {
				$personName=xss_clean($this->input->post('name'));
				$member=xss_clean($this->input->post('member'));
				$relation=xss_clean($this->input->post('relation'));
				$email=xss_clean($this->input->post('email'));
				$contact=xss_clean($this->input->post('contact'));
				//$status=xss_clean($this->input->post('status'));
				
				$memberData=array(
				                'person_name'=>$personName,
				                'member_id'=>$member,
								'relation'=>$relation,
								'email_id'=>$email,
								'phone_number'=>$contact,
								'status'=>1,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$insertId=$this->Family_model->insert_one_row('ru_member_family_member',$memberData);
                if($insertId)
				{
					$this->session->set_flashdata('flashSuccess','<b>Success!</b> New Family member added successfully.');
				    redirect('family');
				}
                else
				{
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
				    redirect('family/add_member');
				}
            }				
			/*****/
		}
        else
        {
			$heading['heading']="Add New Family Member";
			$this->load->view('header',$heading);
			$this->load->view('family/backend/add_member',$members);
			$this->load->view('footer.php');
		}			
	}
	/***********************************end*******************************************************/
	
	
	/***************************************Edit Family member Details*****************************/
	public function edit_member()
	{
		$member_id=$this->uri->segment(3);
		$familyMemberData['data']=$this->Family_model->get_one_row('ru_member_family_member',array('family_member_id'=>$member_id));
		$familyMemberData['members']=$this->Family_model->get_array_of_object('ru_membership','id,member_name',array('id!='=>0));
		if(isset($_POST['edit_member_detail']))
		{
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('member','Member','trim|required');
			$this->form_validation->set_rules('relation','Relation','trim|required');
			$this->form_validation->set_rules('email','Email Id','trim');
			$this->form_validation->set_rules('contact','Contact No','trim');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Edit Member Datails";
				$this->load->view('header',$heading);
				$this->load->view('family/backend/edit_member',$familyMemberData);
				$this->load->view('footer.php');
			}
            else
            {
				$personName=xss_clean($this->input->post('name'));
				$member=xss_clean($this->input->post('member'));
				$relation=xss_clean($this->input->post('relation'));
				$email=xss_clean($this->input->post('email'));
				$contact=xss_clean($this->input->post('contact'));
				//$status=xss_clean($this->input->post('status'));
				
				$memberData=array(
				                'person_name'=>$personName,
				                'member_id'=>$member,
								'relation'=>$relation,
								'email_id'=>$email,
								'phone_number'=>$contact,
								'status'=>1,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$updateId=$this->Family_model->update_by_condition('ru_member_family_member',$memberData,array('family_member_id'=>$member_id));
                if($updateId)
				{
					$this->session->set_flashdata('flashSuccess','<b>Success!</b> Family member details updated successfully.');
				    redirect('family');
				}
                else
				{
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
				    redirect('family/edit_member/'.$member_id);
				}				
			}
		}
		else
		{
			$heading['heading']="Edit Family Member details";
			$this->load->view('header',$heading);
			$this->load->view('family/backend/edit_member',$familyMemberData);
			$this->load->view('footer.php');
		}	
	}
    /***************************************End Edit**********************************************/	
	
	
	/***************************************Delete member******************************************/
	public function delete_member()
	{
		$member_id=$this->uri->segment(3);
		//echo $menu_id;
		$deleteStatus=$this->Family_model->delete_by_condition('ru_member_family_member',array('family_member_id'=>$member_id));
		if($deleteStatus)
		{
			$this->session->set_flashdata('flashSuccess','<b>Success!</b> Member has been deleted successfully.');
		}
        else
        {
			$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
		}
        redirect('family');		
	}
	
}