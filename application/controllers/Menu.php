<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

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
	    $this->load->model('Menu_model');
		
    }
	public function index()
	{
		redirect('welcome');
	}
	
	
	/*****************************************filtered meal**************************************************/
	public function make_order()
	{
		$table_booking_id=$this->uri->segment(3);
		$seat_id=$this->uri->segment(4);
		
		// print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Table Booking ID :".$table_booking_id."<br/>";
		// print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Seat ID :".$seat_id."<br/>";
     
        if(isset($_POST['order']))
        {//echo "<pre>";print_r($_POST);echo "</pre>";die();
			$newOrder=0;
			$orderStatus=0;
			$orderTime=date('Y-m-d H:i:s');
			if($_POST['order']=='save_order')
			{
				$orderStatus=2;
			}
			if(isset($_POST['meal']) && isset($_POST['quantity']))
			{
                $notificationToUsers=$this->Menu_model->get_result_array('ru_users','user_id',array('role!='=>3,'status'=>1));				
				$meal_id=$this->input->post('meal');
				$quantity=$this->input->post('quantity');
				$comment=$this->input->post('comment');
				$guest=$this->input->post('guest');
				$remark=$this->input->post('remark');
                //echo "<pre>";var_dump($gredients);echo "</pre>";die();
				$bookedTables=$this->Menu_model->get_row_by_query('SELECT table_booking_no FROM ru_member_table_booking WHERE table_booking_id='.$table_booking_id);
                if($bookedTables !=null)
				{
					$bookedTables=explode(',',$bookedTables->table_booking_no);
				}
				foreach($meal_id as $key=>$mealid)
				{
					$tempnum=$guest[$key];
					
					$gredients=$this->input->post('gredients'.$mealid);
					//print_r($gredients);
					//exit;
					$gredients=$gredients==null?'':implode(',',$gredients);
					$index=0;
					if($tempnum>8)
					{
						if($tempnum%8==0)
							$index=$tempnum/8-1;
						else
							$index=floor($tempnum/8);
					}	    
					$orderData=array(
									'table_booking_id'=>$table_booking_id,
									'meal_id'=>$meal_id[$key],
									'quantity'=>$quantity[$key],
									'table_id'=>$bookedTables[$index],
									'guest_seat_no'=>$guest[$key],
									'comment'=>$comment[$key],
									'gredients'=>$gredients,
									'order_status'=>$orderStatus,
									'order_time'=>$orderTime,
									'modify_time'=>date('Y-m-d H:i:s'),
									'status'=>1
									);
					$insertId=$this->Menu_model->insert_one_row('ru_table_wise_order',$orderData);
					
					/********************notification on order confirmation**************************/
				
					
					$tableData=$this->Menu_model->get_row_by_query('SELECT table_name FROM ru_tables WHERE id='.$bookedTables[$index]);
					$message="A new Order Received for table <b>".$tableData->table_name."</b>.";
					/*****************send notification for refresh each user screen*********************/
					$notificationData1=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>0,//Here 0=>every user get refresh notification
												'message'=>$message,
												'module_id'=>$insertId,
												'module_type'=>'ru_table_wise_order',
												'notification_type'=>0,
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
												);
					$this->Menu_model->insert_one_row('ru_notifications',$notificationData1);
					/*****************End send notification for refresh each user screen*********************/
					foreach($notificationToUsers as $notificationToUser)
					{				
						$notificationData=array(
												'from_user_id'=>$this->session->userdata('userID'),
												'to_user_id'=>$notificationToUser['user_id'],
												'message'=>$message,
												'module_id'=>$insertId,
												'module_type'=>'ru_table_wise_order',
												'notification_type'=>0,
												'is_read'=>0,
												'created'=>date('Y-m-d H:i:s'),
												'updated'=>date('Y-m-d H:i:s')
												);
						$this->Menu_model->insert_one_row('ru_notifications',$notificationData);
					}
					/************************************End Notification**************************************/
			
				    
				}
				$affectedRows=$this->Menu_model->update_by_condition('ru_member_table_booking',array('member_status'=>2,'remark'=>$remark),array('table_booking_id'=>$table_booking_id));
				$bllrows=$this->Menu_model->update_by_condition('ru_order_bill',array('bill_status'=>0),array('table_booking_id'=>$table_booking_id));
				
			}
			redirect('dashboard');
								
        }
		else
		{

			$select='a.*,b.member_name';
			$joinCondition='a.member_id=b.id';
			$condition=array('table_booking_id'=>$table_booking_id);
			
			$bookTableData=$this->Menu_model->get_one_row_by_join('ru_member_table_booking a',$select,'ru_membership b',$joinCondition,$condition);
			
			$cartData=$this->Menu_model->get_result_by_query('SELECT a.*,b.meal_name FROM ru_table_wise_order a JOIN ru_meal b ON a.meal_id=b.meal_id WHERE a.table_booking_id='.$table_booking_id.' ORDER BY a.table_order_id DESC');
			
			$mealData['bookTableData']=$bookTableData;
			$mealData['cartData']=$cartData;
			$mealData['seat_id']=$seat_id;
			$mealData['menu_list']=$this->Menu_model->menu_list();
			$mealData['sub_menu_list']=$this->Menu_model->sub_menu_list();
			$mealData['meals']=$this->Menu_model->get_array_of_object('ru_meal','*',array('status'=>1),'order_no','ASC');
			//print_r($menuData['menu']);die();
			$heading['heading']="Menu";	
			// $this->output->cache(1);			
			$this->load->view('header',$heading);
			$this->load->view('menu/menu.php',$mealData);
			$this->load->view('footer.php');
			// $this->output->enable_profiler(TRUE);

		}	
	}
	/*****************************************end ***********************************************************/
	
	
	
	
	/****************************List out Menu*************************************/
	public function menu_list()
	{
		$offset=$this->uri->segment(3)?$this->uri->segment(3):0;
		$limit=10;
		$searchterm='';//print_r($_POST);die();
		if(isset($_POST['search']))
		{
			$searchterm=$this->input->post('search_str');
		}	
		
        $search_str =$this->Base_model->searchterm_handler($searchterm);
		//echo $search_str;die();
		if(!empty($search_str))
		{
			$query='SELECT a.*,b.category_name FROM ru_menu a LEFT JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.menu_name LIKE "%'.$search_str.'%"';
			
			$query1='SELECT a.*,b.category_name FROM ru_menu a LEFT JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.menu_name LIKE "%'.$search_str.'%" ORDER BY menu_name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}	
		else
		{	
			$query='SELECT a.*,b.category_name FROM ru_menu a LEFT JOIN ru_product_category b ON a.product_category_id=b.product_category_id';
			
			$query1='SELECT a.*,b.category_name FROM ru_menu a LEFT JOIN ru_product_category b ON a.product_category_id=b.product_category_id WHERE a.status=1 ORDER BY menu_name ASC LIMIT '.$limit.' OFFSET '.$offset;
		}
		
        $menu_count=$this->Menu_model->result_count($query);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'menu/menu_list/';
		$config['total_rows'] = $menu_count;
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
  		
		
		$menuData['data']=$this->Menu_model->get_result_by_query($query1);
		$menuData['search_str']=$search_str;
		$heading['heading']="Menu";
		$this->load->view('header',$heading);
		$this->load->view('menu/backend/menu_list',$menuData);
		$this->load->view('footer.php');
	}
	
	
	public function add_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		//$menuData['restaurants']=$this->Menu_model->restaurant_list('ru_restaurants','restaurant_id,restaurant_name','restaurant_id!=0');
		$menuData=array();
		if(isset($_POST['add_menu']))
		{
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]|is_unique[ru_menu.menu_name]');
			$this->form_validation->set_rules('mealAll','Meal Alcohol','trim|required');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Add New Menu";
				$this->load->view('header',$heading);
				$this->load->view('menu/backend/add_menu',$menuData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$product_category_id=xss_clean($this->input->post('mealAll'));
				$ordernumber=xss_clean($this->input->post('ordernumber'));
				$menuData=array(
				                'menu_name'=>$name,
								'product_category_id'=>$product_category_id,
								'order_no'=>$ordernumber,
								'status'=>1,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$insertId=$this->Menu_model->insert_one_row('ru_menu',$menuData);
                if($insertId)
				{	
                   $this->session->set_flashdata('flashSuccess','<b>Success!</b> Menu added successfully.');
				   redirect('menu/menu_list');
				}   
                else
				{	
					$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
					redirect('menu/add_menu');	
                }					
			}				
		}
        else
		{
			$heading['heading']="Add New Menu";
			$this->load->view('header',$heading);
			$this->load->view('menu/backend/add_menu.php',$menuData);
			$this->load->view('footer.php');
		}	
	}
	
	public function edit_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		$menu_id=$this->uri->segment(3);
		$menuData['data']=$this->Menu_model->get_one_row('ru_menu','menu_id='.$menu_id);
		//$menuData['restaurants']=$this->Menu_model->restaurant_list('ru_restaurants','restaurant_id,restaurant_name','restaurant_id!=0');
		//print_r($_POST);die();
		if(isset($_POST['edit_menu']))
		{
		    $this->form_validation->set_rules('name','Name','trim|required|min_length[2]|callback_unique_excluding_itself');
			$this->form_validation->set_rules('mealAll','Meal Alcohol','trim|required');
			//$this->form_validation->set_rules('status','Status','trim|required');
			if($this->form_validation->run()==false)
			{
				$heading['heading']="Edit Menu Datails";
				$this->load->view('header',$heading);
				$this->load->view('menu/backend/edit_menu.php',$menuData);
				$this->load->view('footer.php');
			}
            else
            {
				$name=xss_clean($this->input->post('name'));
				$product_category_id=xss_clean($this->input->post('mealAll'));
				$ordernumber=xss_clean($this->input->post('ordernumber'));
				$menuData=array(
				                'menu_name'=>$name,
								'product_category_id'=>$product_category_id,
								'order_no'=>$ordernumber,
								'modify_time'=>date('Y-m-d H:i:s')
							    );
				$updatedId=$this->Menu_model->update_by_condition('ru_menu',$menuData,array('menu_id'=>$menu_id));
				//echo $updateId;die();
                if($updatedId)
				{					
    			    $this->session->set_flashdata('flashSuccess','<b>Success!</b> Menu details updated successfully.');
                    if(isset($_SESSION['page_uri']))
						redirect($_SESSION['page_uri']);
					else	
				    redirect('menu/menu_list');					
                }
                else
				{					
    			    $this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
	     		    redirect('menu/edit_menu/'.$menu_id);        
                }				
			}	
		}
        else
        {
			$heading['heading']="Edit Menu detail";
			$this->load->view('header',$heading);
			$this->load->view('menu/backend/edit_menu.php',$menuData);
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
	
	public function delete_menu()
	{
		if($this->session->userdata('userRole')!=1)
		{	
	        $this->session->set_flashdata('flashError','<b>Sorry!</b> You are not authorized to access the content.');
			redirect('welcome');
		}
		$menu_id=$this->uri->segment(3);
		//echo $menu_id;
		$deleteStatus=$this->Menu_model->delete_by_condition('ru_menu',array('menu_id'=>$menu_id));
		if($deleteStatus)
		{
			$this->session->set_flashdata('flashSuccess','<b>Success!</b> Menu has been deleted successfully.');
		}
        else
        {
			$this->session->set_flashdata('flashError','<b>Oops!</b> Something went wrong. Please try again.');
		}
        redirect('menu/menu_list');		
	}
	
	public function delete_order()
	{
		$order_id=$this->input->post('order_id');
		if(!empty($order_id))
		{
			$orderData=$this->Menu_model->get_one_row('ru_table_wise_order',array('table_order_id'=>$order_id));
			if($orderData!=null && $orderData->order_status==0)
			{	
				$affceted=$this->Menu_model->delete_by_condition('ru_table_wise_order',array('table_order_id'=>$order_id));
				echo 1;die();
			}	
		}
        echo 0;		
	}
	
	public function ingredient_list()
	{
		$ingredient_list=$this->config->item('ingredients');
		echo json_encode($ingredient_list);
	}
	
	public function meal_data()
	{
		if(isset($_POST['meal_id']))
		{
			$meal_id=$_POST['meal_id'];
			$mealData=$this->Menu_model->get_one_row('ru_meal',array('meal_id'=>$meal_id));
			echo json_encode($mealData);
			
		}	 
	}
	public function search_meal(){
		if(isset($_POST['srch_meal']))
		{
		$srch_meal=$_POST['srch_meal'];
		$all_meals=$this->Menu_model->get_search_meal_query("SELECT * FROM `ru_meal` WHERE meal_name like '%".$srch_meal."%'");
		if($all_meals){
		  echo json_encode($all_meals);
		}else{
		  echo "Not Found";
		}
	  }
	}
	
}	