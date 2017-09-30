<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_model extends CI_Model
{
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function __construct()
    {
        parent::__construct();
		$this->db->query("SET time_zone='+05:30'");
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function check_existent($table, $where)
    {
        $query = $this->db->get_where($table, $where);
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function result_count($query)
	{
		$result=$this->db->query($query);
		return $result->num_rows();
	}
	
	public function is_user_valid(){
		$this->db->where('user_id='.$this->session->userdata('userID').' AND is_logged_in=1 AND session_id="'.$this->session->userdata('my_session_id').'"');
		$result=$this->db->get('ru_users');
		if($result->num_rows()>0)
			return true;
		else
			return false;
	}
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function record_count($table)
    {
        return $this->db->count_all($table);
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function record_count2($table, $category)
    {
        if ($category != 0) {
            $this->db->where('category_id_fk', $category);
        }
        return $this->db->count_all($table);
    }
    
    
    
    
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
     
    public function insert_one_row($table, $data)
    {
        $query = $this->db->insert($table, $data);
		
       // echo $this->db->last_query();die();
        return $this->db->insert_id();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function insert_multiple_row($table, $data)
    {
        return $this->db->insert_batch($table, $data);
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_max_record_withalias($table, $columname, $alias)
    {
        $this->db->select_max($columname, $alias);
        $query = $this->db->get($table);
        return $query->row();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_record_by_id($table, $data)
    {
        $query = $this->db->get_where($table, $data);//print_r($query->row());exit;
       //echo $this->db->last_query();      
        return $query->row();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_all_record_by_condition($table, $data)
    {
		
        $query = $this->db->get_where($table, $data);
       //echo $this->db->last_query(); die(); 
        return $query->result();
    }
	
	public function get_by_query($query)
	{
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		return $result->result_array();
	}
	public function get_by_row($table,$where)
	{
		$this->db->where($where);
		$result=$this->db->get($table);
		//echo $this->db->last_query();die();
		return $result->row();
	}
	public function get_by_query_return_row($query)
	{
		$result=$this->db->query($query);
		//echo $this->db->last_query();die();
		return $result->row();
	}
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_record_result_array($table, $data)
    {//echo "fgg";exit;
        $query = $this->db->get_where($table, $data);
        //echo $this->db->last_query(); die(); 
        return $query->result_array();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_login_data($table, $username, $password)
    {
		
	     $this->db->select('*');
		 $this->db->from($table);
		 $this->db->where('email_id',$username);
		 $this->db->where('password',md5($password));
		 //$this->db->where('status',1);
		 //$this->db->where('is_active',1);
		 $result= $this->db->get();
		 //echo $this->db->last_query(); die();
        return $result->row();
    }
    
    public function allRecord($table){
	$query = $this->db->query("SELECT * FROM $table WHERE 1");
        //echo $this->db->last_query(); die();
         return $query->result_array();	
		
		
	}
    
    
    
    public function validateUserName($name){
		  $query = $this->db->query("SELECT  username FROM `wc_users` WHERE `username`='".$name."'");
		 // echo $this->db->last_query(); die();
		   return $query->row();
		
	}
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function is_expired($table, $login, $password)
    {
        $expiry_date = date('Y-m-d H:i:s', time());
        $res         = $this->db->query("SELECT * FROM $table WHERE email ='" . $login . "' and user_password='" . $password . "' and expiry_date >= '" . $expiry_date . "' ");
        $getRec      = $res->num_rows();
        if ($getRec < 1) {
            $where = array(
                'email ' => $login,
                'user_password' => $password
            );
            $this->update_record_by_id($table, array(
                'is_active' => 'N'
            ), $where);
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_all_record_by_id($table, $where, $column_name = null, $ordery_by = null)
    {
       if (!empty($column_name) && !empty($ordery_by)) {
            $this->db->order_by($column_name,$ordery_by);
        }
         $query = $this->db->get_where($table, $where);
         //echo $this->db->last_query(); die();
        return $query->result();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_last_insert_id()
    {
        return $this->db->insert_id();
    }
	
	public function get_user_profile($id){
		$this->db->select('u.username,u.primary_email,u.contact_no,u.password,f.address,f.job_summary,f.`size_of_project,f.hashtag,f.about_company,f.first_name,f.last_name,u.password,f.address,f.city,f.state,f.years_business');
		$this->db->from('cons_user u');
		 $this->db->join('cons_user_profile f', 'u.user_id_pk=f.user_id_fk');
		 $this->db->where('u.user_id_pk = ',$id);
		 $query = $this->db->get();
		//print $this->db->last_query();exit;
		
		return $query->result();
	
	
	}
	
	public function get_user_profile_index(){
		$this->db->select('u.username,u.primary_email,u.contact_no,u.user_id_pk, u.password,f.address,f.job_summary,f.size_of_project,f.hashtag,f.about_company,r.role,f.first_name,f.last_name');
		$this->db->from('cons_user u');
		 $this->db->join('cons_user_profile f', 'u.user_id_pk=f.user_id_fk');
		 $this->db->join('cons_user_role r', 'u.role_id_fk = r.role_id_pk');
		 $where = array('u.report '=> 1, 'u.user_id_pk != '=> 1);
		 $this->db->where($where);
		 $query = $this->db->get();
		//print $this->db->last_query();exit;
		
		return $query->result();
	
	
	}
    
    /**
     * Update data to passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function update_record_by_id($table, $data, $where)
    {
		$this->db->where($where);
        $query = $this->db->update($table, $data);
        //echo $this->db->last_query();exit;
        return 1;
    }
	 
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function update_record_by_wherein($table, $data, $wherein)
    {  //echo  $wherein;exit;
        //$this->db->where_in('file_id', $wherein);
        $this->db->where_in('id', $wherein);
        $this->db->update($table, $data);
        //echo $this->db->last_query();die;
        return $this->db->affected_rows();
    }
     /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function update_record_by_wherein1($table, $data, $wherein, $column)
    {  //echo  $wherein;exit;
        //$this->db->where_in('file_id', $wherein);
        $this->db->where_in($column, $wherein);
        $this->db->update($table, $data);
        //echo $this->db->last_query();die;
        return $this->db->affected_rows();
    }
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function countrow($table)
    {
        //$this->db->where_in('usertype','user');
        //$this->db->where_in('usertype','c_admin');
        return $this->db->count_all($table);
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function countrows($table, $where)
    {
        $this->db->where($where);
        $result= $this->db->get($table);
		return $result->num_rows();
    }
	
	
	public function user_count($table,$where)
	{
		$name=$this->input->post('name');
		$userrole=$this->input->post('userrole');
		$statusfilter=$this->input->post('statusfilter');
		if($name){
			
			$this->db->group_start();
			$this->db->or_like(array('name'=>$name,'email_id'=>$name));	
			$this->db->group_end();
		}
		
		if($userrole){
			$this->db->where('role',$userrole);
		}
		
		if(is_numeric($statusfilter)){
			$this->db->where('status',$statusfilter);
		}else {
			$this->db->where('status',1);			
		}
			
		if($where){
	    $this->db->where($where);
		}
		
		
		$result=$this->db->get($table);
		return $result->num_rows();
	}
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function countusers($table, $column, $userType)
    {
        $countResult = $this->db->query("SELECT COUNT( * ) AS count_user FROM $table WHERE $column = '" . $userType . "' ");
        // echo $this->db->last_query(); die();
        return $countResult->row();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function count_new_users($table, $column, $userType)
    {
        $countResult = $this->db->query("SELECT COUNT( * ) AS count_user FROM $table WHERE $column >= '" . $userType . "' ");
        // echo $this->db->last_query(); die();
        return $countResult->row();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function count_row_by_ids($table, $param)
    {
        $query = $this->db->count_all($table, $param);
        //echo $this->db->last_query(); die();
        return $query;
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function count_row_by_id($table, $where_column)
    {
        $res = $this->db->query("SELECT COUNT( * ) AS count_task FROM  $table WHERE $where_column");
        $tot = $res->result();
        return $tot->count_task;
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function count_join_row_by_id($user_id = null)
    {
        $res = $this->db->query("SELECT COUNT( * ) AS replied_count FROM nsf_support_ticket WHERE user_id_fk = $user_id AND is_replied = 'Y' AND is_read = 'N' ");
        if ($res) {
            return $res->result();
        } else {
            return false;
        }
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function count_rows_by_id($uid)
    {
        $res = $this->db->query("SELECT COUNT( * ) AS member_count FROM ff_user_mst WHERE parent_id = $uid");
        if ($res) {
            return $res->result();
        } else {
            return false;
        }
    }
    
    /**$this->base_model->all_records('wc_health_answers');
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_pagination_data($table,$joinTable,$joinCondition, $limit, $offset = 0,$where,$orderColumn,$orderby)
    {
		$this->db->from($table);
		$this->db->join($joinTable,$joinCondition);
	    $this->db->where($where);
		$this->db->order_by($orderColumn, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
        $result= $this->db->get();
		return $result->result_array();
		//echo $this->db->last_query();
    }
	public function get_pagination_data_simple($table, $limit, $offset = 0,$where,$orderColumn,$orderby)
    {
		$this->db->from($table);
	    $this->db->where($where);
		$this->db->order_by($orderColumn, $orderby);
		$this->db->limit($limit);
		$this->db->offset($offset);
        $result= $this->db->get();
		return $result->result_array();
		//echo $this->db->last_query();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_pagination_datas_for_all_users($table, $limit = '10', $offset = '0')
    {
        $this->db->where('usertype', 'user');
        $this->db->or_where('usertype', 'c_admin');
        return $this->db->get($table, $limit, $offset);
        //return $res->result();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function all_records($mytable)
    {
        $query = $this->db->get($mytable);
        //echo $this->db->last_query();die();
        return $query->result();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_all_record_by_in($table, $colum, $wherein)
    {
        $this->db->where_in($colum, $wherein);
        $res = $this->db->get($table);
        return $res->result();
    }

   
    
    /**
     * Delete data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function delete_record_by_id($table, $where)
    {
        $query = $this->db->delete($table,$where);
		//echo $this->db->last_query();die();
        //return $query;
        return $this->db->affected_rows();
    }
     
	
		
     /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     * @param array  $column
     *
     * @return array
     */
    public function row_delete($table,$where,$column)
    {
       $this->db->where($column, $where);
       $query =  $this->db->delete($table); 
       return $query;
    }
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function get_record_by_order($table, $orderBy)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($orderBy, 'ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function delete_record_by_id1($table, $where, $managerid1)
    {
        $this->db->where_in('userid', $where);
        $this->db->where('managerid', $managerid1);
        $this->db->delete($table);
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function employee_list_model()
    {
        $this->db->select('u.user_id_pk,u.first_name,u.last_name,u.primary_email,u.mobile,u.image,r.role_name,e.department,e.designation');
        $this->db->from('pms_users u');
        $this->db->join('users_role r', 'u.usre_role=r.role_id_pk', 'left');
        $this->db->join('pms_employee_detail e', 'u.user_id_pk=e.user_id', 'left');
        $this->db->order_by('u.user_id_pk', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        }
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function employee_filter_modal($where)
    {
        $this->db->select('u.user_id_pk,u.first_name,u.last_name,u.primary_email,u.mobile,u.image,r.role_name,e.department,e.designation');
        $this->db->from('pms_users u');
        $this->db->join('users_role r', 'u.usre_role=r.role_id_pk', 'left');
        $this->db->join('pms_employee_detail e', 'u.user_id_pk=e.user_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result();
    }
    
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function all_user()
    {
        $this->db->select('u.user_id_pk,u.first_name,u.last_name,u.primary_email,u.mobile,u.image,r.role_name,e.department,e.designation');
        $this->db->from('pms_users u');
        $this->db->join('users_role r', 'u.usre_role=r.role_id_pk', 'left');
        $this->db->join('pms_employee_detail e', 'u.user_id_pk=e.user_id', 'left');
        //$this->db->where($where);       
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result();
    }
    /**
     * Get data from passed table name with given where condition
     *
     * @param string $table
     * @param array  $where
     *
     * @return array
     */
    public function update_record_not_in($table,$column,$data,$wherein)
    {
        $this->db->where_not_in($column, $wherein);
        $this->db->update($table, $data);
       //echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }
	
	public function get_select_not_in($table,$column,$data,$wherein){
		
		$this->db->select("*");
  		$this->db->from($table);
		$this->db->where($wherein);
  		$this->db->where_not_in($column, $data);
		
		
		 $query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result(); 
	
	}
	
	
	 public function days($id)
    {
	   //echo $id;exit;
       $this->db->select('d.day_name');
        $this->db->from('wc_batch_days ds');
       // $this->db->join('users_role r', 'u.usre_role=r.role_id_pk', 'left');
        $this->db->join('wc_days_mst d', 'd.day_id_pk=ds.days_id_fk', 'left');
		$this->db->where('ds.batch_id_fk', $id);
       $query = $this->db->get();
       //echo $this->db->last_query();die;
        return $query->result();
    }
  

   public function is_exist($table,$data)
   {
	   $this->db->select('email');
	   $result = $this->db->get_where($table,$data);
	   if($result->num_rows() > 0)
	     return $result->row();
	   else
	      return 0;  
	}

	public function signup($data,$id,$table)
	{
		$this->db->insert($table,$data);
	}
	
	//return device tokens for a user
	function get_deviceToken($userID)
	{
		$this->db->from('user_device');
		$this->db->where('uid', $userID);		
		$query = $this->db->get();		
		return $query->result();		
		//return $deviceList;
	}
	
	
	public function is_unique_value($table,$condition)
	{
		$query = $this->db->get_where($table,$condition);
		if($query->num_rows() > 0)
		   return false;
		else
		   return true;   
	}
	
	
	
	public function is_condition_exist($table,$data)
	{
		$this->db->where($data);
		$result = $this->db->get($table);
		return $result->num_rows();
	}
	
	
	/*
	*@ email sending function
	*/	 
	    public function send_email($data)
	   {
		  //works on staging server without password  
              $config = Array( 
                			  'protocol'  => 'sendmail',
                              'mailpath'   => '/usr/sbin/sendmail',
                              'mailtype'   => 'html',
                              'charset'    => 'iso-8859-1',
                              'wordwrap'   => TRUE
                              );
               // print_r($data);					
                
               $this->load->library('email', $config);
               $this->email->set_newline("\r\n");
               $this->email->from('mail@survey.irbureau.com'); // change it to yours
               $this->email->to($data['email']);
               $this->email->subject($data['subject']);
               $this->email->message($data['message']);
               $this->email->attach($data['attachment']);
               if($this->email->send())
               {
				   
				   return true;
                   
               }
              
              else
              {
                    return $this->email->print_debugger();
                     
                    
              }
		}	
		
		
		
		//This function generate random password of 8 characters
		public function generate_password()
		{
			$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 4; $i++) 
            {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
                 }
            return $randomString;
			
		  }
		  
	
	
	
	public function formatRemindetText($reminderText)
	{
		$str = $reminderText;
        $strlen = strlen( $str );
		$occurence=0;
		$reminder_text='';
        for( $i = 0; $i <= $strlen; $i++ ) 
		{
            $char = substr( $str, $i, 1 );
		    if($char==='#')
			{
				$occurence++;
				if($occurence%2==0)
				$reminder_text.="</span>";
                else
				$reminder_text.="<span class='reminderText'>";						
			}
            else
			{
				$reminder_text.=$char;
			}			
		}
		return $reminder_text;
	}

	public function searchterm_handler($searchterm)
	{
		if($searchterm)
		{//echo "if";die();
			$this->session->set_userdata('searchterm', $searchterm);
			$this->session->set_userdata('page_uri', $this->uri->uri_string());
			$this->session->set_userdata('module', $this->uri->segment(1));
			return $searchterm;
		}
		elseif($this->session->userdata('searchterm'))
		{//echo "elseif";die();
		    if($this->session->userdata('module')!= $this->uri->segment(1))
			{
				$this->session->unset_userdata('searchterm');
				$this->session->unset_userdata('page_uri');
			    $this->session->unset_userdata('module');
				$this->session->set_userdata('page_uri', $this->uri->uri_string());
			    $searchterm ="";
			}	
		    else if(isset($_POST['search']) && $_POST['search_str']=='')
			{
				$this->session->unset_userdata('searchterm');
				$this->session->unset_userdata('page_uri');
				$this->session->set_userdata('page_uri', $this->uri->uri_string());
			    $searchterm ="";
			    return $searchterm;
			}
            else
            {				
			    $searchterm = $this->session->userdata('searchterm');
				$this->session->set_userdata('page_uri', $this->uri->uri_string());
			    return $searchterm;
			}	
		}
		else
		{//echo "else";die();
			$this->session->unset_userdata('searchterm');
			$this->session->unset_userdata('page_uri');
			$this->session->set_userdata('page_uri', $this->uri->uri_string());
			$searchterm ="";
			return $searchterm;
		}
	}
	
}
