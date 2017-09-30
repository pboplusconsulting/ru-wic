<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_menu extends CI_Controller {

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
		if($this->session->userdata('userRole')!=1)// && $this->session->userdata('userRole')!=2)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
		
	    $this->load->model('Menu_model');
		
    }
	public function index()
	{	
	    $menu_filter='';
        $offset='';//	print_r($_POST);die();
	    if(isset($_POST['menu_filter']))
		{
			$menu_filter=$this->input->post('menu');
			$offset=0;//var_dump($menu_filter);var_dump($offset);die();
		}
		else
		{
			$menu_filter=$this->uri->segment(3);
            $offset=$this->uri->segment(4);	
		    $offset=isset($offset)?$offset:0;	
		}	
		$menu_filter=(isset($menu_filter) &&$menu_filter > 0)?$menu_filter:0;
		
		if($menu_filter)
		{
			$query='SELECT a.*,b.menu_name FROM ru_sub_menu a JOIN ru_menu b ON a.menu_id=b.menu_id WHERE a.menu_id='.$menu_filter;
		}	
		else
		{	
			$query='SELECT a.*,b.menu_name FROM ru_sub_menu a JOIN ru_menu b ON a.menu_id=b.menu_id';
		}	
		//echo $query;die();
		$subMenus=$this->Menu_model->get_result_by_query($query);
		$this->load->library('pagination');

		$config['base_url'] = base_url().'sub_menu/index/'.$menu_filter.'/';
		$config['total_rows'] = count($subMenus);
		$config['per_page'] = 5;
		$config['uri_segment'] = 4;
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
		//var_dump($menu_filter);die();
		if($menu_filter)
		{
			$query1='SELECT a.*,b.menu_name FROM ru_sub_menu a JOIN ru_menu b ON a.menu_id=b.menu_id WHERE a.menu_id='.$menu_filter.' LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		else
		{	
			$query1='SELECT a.*,b.menu_name FROM ru_sub_menu a JOIN ru_menu b ON a.menu_id=b.menu_id LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		//echo $query1;die();
		$subMenuData['data']=$this->Menu_model->get_result_by_query($query1);
		$subMenuData['menus']=$this->Menu_model->get_by_order('ru_menu','menu_id,menu_name',array('status'=>1),'menu_name','ASC');
		$subMenuData['filter']=$menu_filter;
		$heading['heading']="Sub Menu";
		$this->load->view('header',$heading);
		$this->load->view('sub_menu/sub_menu_list',$subMenuData);
		$this->load->view('footer.php');
			
	}
	
	
	public function add_sub_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		$menuData['menus']=$this->Menu_model->menu_list();
		if(isset($_POST['add_sub_menu']))
		{
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('menu','Menu','trim|required');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Add Sub Menu";
				$this->load->view('header',$heading);
				$this->load->view('sub_menu/add_sub_menu',$menuData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$menu=xss_clean($this->input->post('menu'));
				$order_number=xss_clean($this->input->post('ordernumber'));
				$mData=array(
				                'sub_menu_name'=>$name,
								'menu_id'=>$menu,
								'status'=>1,
								'order_no'=>$order_number,
								'created'=>date('Y-m-d H:i:s'),
						        'updated'=>date('Y-m-d H:i:s')
							    );
				$insertId=$this->Menu_model->insert_one_row('ru_sub_menu',$mData);
                if($insertId)
				{	
                   $this->session->set_flashdata('flashSuccess','<b>Success!</b> Sub Menu added successfully.');
				   redirect('sub_menu');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('sub_menu/add_sub_menu');	
                }					
			}				
		}
        else
		{
			$heading['heading']="Add Sub Menu";
			$this->load->view('header',$heading);
			$this->load->view('sub_menu/add_sub_menu',$menuData);
			$this->load->view('footer.php');
		}	
	}
	
	public function edit_sub_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		$sub_menu_id=$this->uri->segment(3);
		$subMenuData['data']=$this->Menu_model->get_one_row('ru_sub_menu','sub_menu_id='.$sub_menu_id);
		$subMenuData['menus']=$this->Menu_model->menu_list('ru_menu','menu_id,menu_name','menu_id!=0');
		//print_r($_POST);die();
		if(isset($_POST['edit_sub_menu']))
		{
		    $this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('menu','Menu','trim|required');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Edit Sub Menu";
				$this->load->view('header',$heading);
				$this->load->view('sub_menu/edit_sub_menu',$subMenuData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$menu=xss_clean($this->input->post('menu'));
				$order_number=xss_clean($this->input->post('ordernumber'));
				$mData=array(
				                'sub_menu_name'=>$name,
								'menu_id'=>$menu,
								'order_no'=>$order_number,
								'updated'=>date('Y-m-d H:i:s')
							    );
				$updatedId=$this->Menu_model->update_by_condition('ru_sub_menu',$mData,array('sub_menu_id'=>$sub_menu_id));
				
				//echo $updateId;die();
                if($updatedId)
				{	
                     $this->Menu_model->update_by_condition('ru_meal',array('menu_id'=>$menu),array('sub_menu_id'=>$sub_menu_id));			
    			    $this->session->set_flashdata('flashSuccess','<b>Success!</b> Sub Menu details updated successfully.');
	     		    redirect('sub_menu');        
                }
                else
				{					
    			    $this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
	     		    redirect('sub_menu/edit_sub_menu/'.$sub_menu_id);        
                }				
			}	
		}
        else
        {
			$heading['heading']="Edit Sub Menu";
			$this->load->view('header',$heading);
			$this->load->view('sub_menu/edit_sub_menu',$subMenuData);
			$this->load->view('footer.php');
		}			
	}
	
	
	public function unique_excluding_itself()
	{
		$menu_id=$this->uri->segment(3);
		$name=$this->input->post('name');
		$status=$this->Menu_model->check_unique_excluding_itself($name,$menu_id);
		if($status)
		{	
	        $this->form_validation->set_message('unique_excluding_itself','Menu name is already exist.Please enter another name.');
			return false;
		}	
		else
		{
			return true;
		}	
	}
	
	public function delete_sub_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		$sub_menu_id=$this->uri->segment(3);
		//echo $menu_id;
		$deleteStatus=$this->Menu_model->delete_by_condition('ru_sub_menu',array('sub_menu_id'=>$sub_menu_id));
		if($deleteStatus)
		{
			$this->session->set_flashdata('flashSuccess','<b>Success!</b> Sub menu has been deleted successfully.');
		}
        else
        {
			$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
		}
        redirect('sub_menu');		
	}
}	