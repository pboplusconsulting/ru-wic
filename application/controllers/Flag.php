<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flag extends CI_Controller {

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
	    $this->load->model('Flag_model');
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
		$this->load->helper('security');
    }
	public function index()
	{
		$offset=$this->uri->segment(3)?$this->uri->segment(3):0;
		$limit=3;
		$searchterm='';//print_r($_POST);die();
		if(isset($_POST['search']))
		{
			$searchterm=$this->input->post('search_str');
		}	
		
        $search_str =$this->Base_model->searchterm_handler($searchterm);
		//echo $search_str;die();
		if(!empty($search_str))
		{
			$query='SELECT a.*,b.category_name FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.product_category_id IN (1,2,3) AND a.tax_name LIKE "%'.$search_str.'%"';
			$query1='SELECT a.*,b.category_name FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.product_category_id IN (1,2,3) AND a.tax_name LIKE "%'.$search_str.'%" ORDER BY tax_name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}	
		else
		{	
			$query='SELECT a.*,b.category_name FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.product_category_id IN (1,2,3)';
			$query1='SELECT a.*,b.category_name FROM ru_taxes a JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.product_category_id IN (1,2,3) ORDER BY a.tax_name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}	
		//echo $query;die();
		$fCount=$this->Base_model->result_count($query);
		$this->load->library('pagination');

		$config['base_url'] = base_url().'flag/index/';
		$config['total_rows'] = $fCount;
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
				
		$flag_data['taxes']=$this->Flag_model->get_by_result($query1);
		$heading['heading']="Taxes";
		$flag_data['search_str']=$search_str;
		$this->load->view('header',$heading);
		$this->load->view('flags/flag_list.php',$flag_data);
		$this->load->view('footer.php');
	}
	
	public function add_flag()
	{
		if(isset($_POST['add_flag']))
		{
				$flag_name=xss_clean($this->input->post('name'));
				$flag_type=xss_clean($this->input->post('category'));
				$percentage=xss_clean($this->input->post('percentage'));
				//echo $flag_type;die();		
				$flagData=array(
				                'tax_name'=>$flag_name,
								'product_category_id'=>$flag_type,
								'tax_percent'=>$percentage,
								'status'=>1,
								'created'=>date("Y-m-d H:i:s",time()),
								'updated'=>date("Y-m-d H:i:s",time()),
							    );
				$insertId=$this->Flag_model->insert_one_row('ru_taxes',$flagData);//echo $insertId;die();
                if($insertId)
				{	
                   $this->session->set_flashdata('flashSuccess','<b>Success!</b> New tax added successfully.');
				   redirect('flag');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('flag/add_flag');	
                }					
							
		}
        else
		{
			$flag_data['product_categories']=$this->Flag_model->get_by_result("SELECT a.* FROM ru_product_category a WHERE status=1");
			
			$heading['heading']="Add New tax";
			$this->load->view('header',$heading);
			$this->load->view('flags/add_flag.php',$flag_data);
			$this->load->view('footer.php');
		}
	}
	
	
	public function edit_flag()
	{
	    $tax_id=$this->uri->segment(3);
		$flagDetails=$this->Flag_model->get_record_by_id('ru_taxes',array('tax_id'=>$tax_id));
		//print_r($membersDetails);exit;
		
		$flag_data['data']=$flagDetails;
		//print_r($members_data['data']);exit;
	    if(isset($_POST['edit_flag']))
		{
				$flag_name=xss_clean($this->input->post('name'));
				//$flag_type=xss_clean($this->input->post('type'));
				$status=xss_clean($this->input->post('status'));
				$percentage=xss_clean($this->input->post('percentage'));
				
				$flagData=array(
				                'tax_name'=>$flag_name,
								//'flag_type'=>$flag_type,
								'status'=>$status,
								'tax_percent'=>$percentage,
								'updated'=>date("Y-m-d H:i:s",time())
							    );
		    $update = $this->Base_model->update_record_by_id('ru_taxes',$flagData,array('tax_id'=>$tax_id));
		    if($update)
			{	
			   $this->session->set_flashdata('flashSuccess','<b>Success!</b> Tax details updated successfully.');
			   //redirect('flag');
			    if(isset($_SESSION['page_uri']))
					redirect($_SESSION['page_uri']);
				else	
				    redirect('flag');
			}   
			else
			{	
				$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
				redirect('members/edit_flag');	
			}	
		}
		else
		{
			
		    $heading['heading']="Edit Flags";
		   	$this->load->view('header',$heading);
			$this->load->view('flags/edit_flag.php',$flag_data);
			$this->load->view('footer.php');
		}
	}
	 
	public function delete_flag()
	{
	    $id=$this->uri->segment(3);
		//echo $members_id;
		$this->Flag_model->delete_record_by_id('ru_taxes',array('tax_id'=>$id));
		$this->session->set_flashdata('flashSuccess', 'Deleted Succeessfully.');
		redirect('flag');
	} 
}