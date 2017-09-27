<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Controller {

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
	    $this->load->model('Meal_model');
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> Unauthorize access.');
			redirect('welcome');
		}
    }
	public function index()
	{/*
		$menuData['menu_list']=$this->Menu_model->menu_list();
		//print_r($menuData['menu']);die();
        $heading['heading']="Menu";
	   	$this->load->view('header',$heading);
		$this->load->view('menu/menu.php',$menuData);
		$this->load->view('footer.php');*/
	}
	
	/****************************List out Menu*************************************/
	/*
	public function meal_list()
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
			$query='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id WHERE a.menu_id='.$menu_filter;
		}	
		else
		{	
			$query='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id';
		}	
		//echo $query;die();
		$mealCount=$this->Meal_model->result_count($query);
		$this->load->library('pagination');

		$config['base_url'] = base_url().'meal/meal_list/'.$menu_filter.'/';
		$config['total_rows'] = $mealCount;
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
			$query1='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id WHERE a.menu_id='.$menu_filter.' ORDER BY meal_name ASC LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		else
		{	
			$query1='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id ORDER BY meal_name ASC LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		$mealData['data']=$this->Meal_model->get_result_array_by_query($query1);
			$mealData['menus']=$this->Meal_model->get_by_order('ru_menu','menu_id,menu_name',array('status'=>1),'menu_name','ASC');
			$mealData['filter']=$menu_filter;
			$heading['heading']="Meal";
			$this->load->view('header',$heading);
			$this->load->view('meal/backend/meal_list.php',$mealData);
			$this->load->view('footer.php');
				
	}*/
	
	
	public function meal_list()
	{
		$offset=$this->uri->segment(3)?$this->uri->segment(3):0;
		$searchterm='';//print_r($_POST);die();
		if(isset($_POST['search']))
		{
			$searchterm=$this->input->post('search_str');
		}	
		
        $search_str =$this->Base_model->searchterm_handler($searchterm);
		//echo $search_str;die();
		if(!empty($search_str))
		{
			$query='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id WHERE a.meal_name LIKE "%'.$search_str.'%"';
		}	
		else
		{	
			$query='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id';
		}	
		//echo $query;die();
		$mealCount=$this->Meal_model->result_count($query);
		$this->load->library('pagination');

		$config['base_url'] = base_url().'meal/meal_list/';
		$config['total_rows'] = $mealCount;
		$config['per_page'] = 5;
		$config['uri_segment'] = 3;
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
		if(!empty($search_str))
		{
			$query1='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id WHERE a.meal_name LIKE "%'.$search_str.'%" ORDER BY meal_name ASC LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		else
		{	
			$query1='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.sub_menu_id=c.sub_menu_id ORDER BY meal_name ASC LIMIT '.$config['per_page'].' OFFSET '.$offset;
		}
		$mealData['data']=$this->Meal_model->get_result_array_by_query($query1);
		$mealData['menus']=$this->Meal_model->get_by_order('ru_menu','menu_id,menu_name',array('status'=>1),'menu_name','ASC');
		$mealData['search_str']=$search_str;
		$heading['heading']="Meal";
		$this->load->view('header',$heading);
		$this->load->view('meal/backend/meal_list.php',$mealData);
		$this->load->view('footer.php');
				
	}
	
	public function add_meal()
	{
		$mealData['menus']=$this->Meal_model->get_by_order('ru_menu','menu_id,menu_name','menu_id!=0','menu_name','ASC');
		if(isset($_POST['add_meal']))
		{//echo "submitted";die();
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('menu','Menu','trim|required');
			$this->form_validation->set_rules('price','Price','trim|required');
			$this->form_validation->set_rules('prepration_time','Prepration Time','trim|required');
			$this->form_validation->set_rules('description','Description','trim');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Add New Meal";
				$this->load->view('header',$heading);
				$this->load->view('meal/backend/add_meal',$mealData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$menu=xss_clean($this->input->post('menu'));
				$sub_menu=xss_clean($this->input->post('smenu'));//var_dump($sub_menu);die();
				$price=xss_clean($this->input->post('price'));
				$prepration_time=xss_clean($this->input->post('prepration_time'));
				$description=xss_clean($this->input->post('description'));
				$order_number=xss_clean($this->input->post('ordernumber'));
				$mealImage=$_FILES['meal_image'];
				$mealVideo=$_FILES['meal_video'];
				//print_r($mealImage);die();
				$mealData=array(
				                'meal_name'=>$name,
				                'menu_id'=>$menu,
								'sub_menu_id'=>$sub_menu,
								'meal_price'=>$price,
								'meal_prepration_time'=>$prepration_time,
								'meal_description'=>$description,
								'order_no'=>$order_number,
								'status'=>1,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$insertId=$this->Meal_model->insert_one_row('ru_meal',$mealData);
                if($insertId)
				{
                    if($mealImage['error']==0)
					{
						$flData=array_reverse(explode('.',$mealImage['name']));
						$fileType='image';
						$filename='meal_image_'.time().'.'.$flData[0];
						$html_element_name='meal_image';
                        //echo $filename;die();
					    $imgStatus=$this->upload_files($fileType,$filename,$html_element_name);
						if($imgStatus['status']==1)
						{
							$updateStatus=$this->Meal_model->update_by_condition('ru_meal',array('meal_image'=>'uploads/images/'.$filename),array('meal_id'=>$insertId));
						}
                        else
                        {
							$this->session->set_flashdata('flashError','<b>Oops!</b> '.$imgStatus['msg']);
						}							
					}
                    if($mealVideo['error']==0)
					{
						$flData=array_reverse(explode('.',$mealVideo['name']));
						$fileType='video';
						$filename='meal_video_'.time().'.'.$flData[0];
						$html_element_name='meal_video';
						$videoStatus=$this->upload_files($fileType,$filename,$html_element_name);
						if($videoStatus['status']==1)
						{
							$updateStatus=$this->Meal_model->update_by_condition('ru_meal',array('meal_video'=>'uploads/videos/'.$filename),array('meal_id'=>$insertId));
						}
                        else
                        {
							$this->session->set_flashdata('flashError','<b>Oops!</b> '.$videoStatus['msg']);
						}
					}							
                    $this->session->set_flashdata('flashSuccess','<b>Success!</b> New Meal added successfully.');
				    redirect('meal/meal_list');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('meal/add_meal');	
                }					
			}				
		}
        else
		{//echo "default";die();
			$heading['heading']="Add New Meal";
			$this->load->view('header',$heading);
			$this->load->view('meal/backend/add_meal',$mealData);
			$this->load->view('footer.php');
		}	
	}
	
	
	
	public function edit_meal()
	{
		$meal_id=$this->uri->segment(3);
		
		$query='SELECT a.*,b.menu_name,c.sub_menu_name FROM ru_meal a LEFT JOIN ru_menu b ON a.menu_id=b.menu_id LEFT JOIN ru_sub_menu c ON a.menu_id=c.menu_id WHERE a.meal_id='.$meal_id;
		$mealData['mealData']=$this->Meal_model->get_row_by_query($query);
		
		$mealData['menus']=$this->Meal_model->get_by_order('ru_menu','menu_id,menu_name','menu_id!=0','menu_name','ASC');
		
		$mealData['submenus']=$this->Meal_model->get_by_order('ru_sub_menu','sub_menu_id,sub_menu_name',array('menu_id'=>$mealData["mealData"]->menu_id),'sub_menu_name','ASC');
		
		//echo "<pre>";print_r($mealData);echo "</pre>";die();
		
		$heading['heading']="Edit Meal Details";
		//print_r($mealData);die();
		if(isset($_POST['edit_meal']))
		{
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('menu','Menu','trim|required');
			$this->form_validation->set_rules('price','Price','trim|required');
			$this->form_validation->set_rules('prepration_time','Prepration Time','trim|required');
			$this->form_validation->set_rules('description','Description','trim');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$this->load->view('header',$heading);
				$this->load->view('meal/backend/edit_meal',$mealData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$menu=xss_clean($this->input->post('menu'));
				$sub_menu=xss_clean($this->input->post('smenu'));//var_dump($sub_menu);die();
				$price=xss_clean($this->input->post('price'));
				$prepration_time=xss_clean($this->input->post('prepration_time'));
				$description=xss_clean($this->input->post('description'));
				$order_number=xss_clean($this->input->post('ordernumber'));
				$mealImage=$_FILES['meal_image'];
				$mealVideo=$_FILES['meal_video'];
				//print_r($mealImage);die();
				$meal_data=array(
				                'meal_name'=>$name,
				                'menu_id'=>$menu,
								'sub_menu_id'=>$sub_menu,
								'meal_price'=>$price,
								'meal_prepration_time'=>$prepration_time,
								'meal_description'=>$description,
								'order_no'=>$order_number,
								'status'=>1,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$updateId=$this->Meal_model->update_by_condition('ru_meal',$meal_data,array('meal_id'=>$meal_id));
                if($updateId)
				{
                    if($mealImage['error']==0)
					{
						$flData=array_reverse(explode('.',$mealImage['name']));
						$fileType='image';
						$filename='meal_image_'.time().'.'.$flData[0];
						$html_element_name='meal_image';
                        //echo $filename;die();
					    $imgStatus=$this->upload_files($fileType,$filename,$html_element_name);
						if($imgStatus['status']==1)
						{
							$updateStatus=$this->Meal_model->update_by_condition('ru_meal',array('meal_image'=>'uploads/images/'.$filename),array('meal_id'=>$meal_id));
						}
                        else
                        {
							$this->session->set_flashdata('flashError','<b>Oops!</b> '.$imgStatus['msg']);
						}							
					}
                    if($mealVideo['error']==0)
					{
						$flData=array_reverse(explode('.',$mealVideo['name']));
						$fileType='video';
						$filename='meal_video_'.time().'.'.$flData[0];
						$html_element_name='meal_video';
						$videoStatus=$this->upload_files($fileType,$filename,$html_element_name);
						if($videoStatus['status']==1)
						{
							$updateStatus=$this->Meal_model->update_by_condition('ru_meal',array('meal_video'=>'uploads/videos/'.$filename),array('meal_id'=>$meal_id));
						}
                        else
                        {
							$this->session->set_flashdata('flashError','<b>Oops!</b> '.$videoStatus['msg']);
						}
					}							
                    $this->session->set_flashdata('flashSuccess','<b>Success!</b> Meal Details updated successfully.');
					if(isset($_SESSION['page_uri']))
						redirect($_SESSION['page_uri']);
					else	
				    redirect('meal/meal_list');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('meal/edit_meal/'.$meal_id);	
                }					
			}
			
		}	
		else
		{	
			$this->load->view('header',$heading);
			$this->load->view('meal/backend/edit_meal',$mealData);
			$this->load->view('footer.php');
		}	
	}
	
	public function delete_meal()
	{
		$meal_id=$this->uri->segment(3);
		//echo $menu_id;
		$deleteStatus=$this->Meal_model->delete_by_condition('ru_meal',array('meal_id'=>$meal_id));
		if($deleteStatus)
		{
			$this->session->set_flashdata('flashSuccess','<b>Success!</b> Meal has been deleted successfully.');
		}
        else
        {
			$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
		}
        redirect('meal/meal_list');		
	}
	
	public function delete_files()
	{
		$meal_id=$this->uri->segment(3);
		$fileType=$this->uri->segment(4);
		$mealData=$this->Meal_model->get_one_row('ru_meal',array('meal_id'=>$meal_id));
		$dltStatus=0;
		if($fileType=='image')
		{	//echo $fileType;die();
		   if(file_exists('././'.$mealData->meal_image))
		   {
			   unlink('././'.$mealData->meal_image);
			   $updateStats=$this->Meal_model->update_by_condition('ru_meal',array('meal_image'=>''),array('meal_id'=>$meal_id));
			   $dltStatus=1;
			   
		   }	   
		   
		}
        else if($fileType=='video')
		{//echo $fileType;die();
		    if(file_exists('././'.$mealData->meal_video))
			{
				unlink('././'.$mealData->meal_video);
				$updateStats=$this->Meal_model->update_by_condition('ru_meal',array('meal_video'=>''),array('meal_id'=>$meal_id));
				$dltStatus=1;
			}		
		}
		redirect('Meal/edit_meal/'.$meal_id);
        /*if($dltStatus)
           echo 1;
        else
           echo 0;*/	
	}
	
	public function upload_files($fileType,$filename,$html_element_name)
	{
		$config=array();
		switch($fileType)
		{
			case 'image':
			{	//echo "img";die();
			    $config['upload_path']          = '././uploads/images/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['file_name']             = $filename;
				$config['max_size']             = 5*1024;
				//$config['max_width']            = 1024;
				//$config['max_height']           = 768;
				break;
			}
            case 'video':
			{
				$config['upload_path']          = '././uploads/videos/';
				$config['allowed_types']        = 'mp4|3gpp|3gp|mov|wmv|avi';
				$config['file_name']             = $filename;
				$config['max_size']             = 50*1024;
				//print_r($config);die();
				break;
			}			
		}
        //print_r($config['upload_path']);die();
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($html_element_name))
		{
			$returnData=array('status'=>0,'msg'=>$this->upload->display_errors());
			return $returnData;
		}
		else
		{
			$returnData=array('status'=>1,'msg'=>$this->upload->data());
			return $returnData; 
		}
	}
	
	
	public function sub_menu_list()
	{
		$menu_id=$this->input->post('menu_id');
		$query="SELECT sub_menu_id,sub_menu_name FROM ru_sub_menu WHERE menu_id=".$menu_id;
		$submenus=$this->Meal_model->get_result_array_by_query($query);
		$resultHtml="<option value=''>select</option>";
		$status=0;
		foreach($submenus as $submenu)
		{
			$resultHtml.="<option value='".$submenu['sub_menu_id']."'>".$submenu['sub_menu_name']."</option>";
			$status++;
		}
		if($status)
		  echo $resultHtml;
	    else echo $status;
	}
}	