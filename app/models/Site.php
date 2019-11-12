<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Model
{

    public function __construct() {
        parent::__construct();
	$this->load->library('ion_auth');
    }

    public function get_total_qty_alerts() {
        $this->db->where('quantity < alert_quantity', NULL, FALSE)->where('track_quantity', 1);
        return $this->db->count_all_results('products');
    }
	
	

	
    public function get_expiring_qty_alerts() {
        $date = date('Y-m-d', strtotime('+3 months'));
        $this->db->select('SUM(quantity_balance) as alert_num')
        ->where('expiry !=', NULL)->where('expiry !=', '0000-00-00')
        ->where('expiry <', $date);
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            $res = $q->row();
            return (INT) $res->alert_num;
        }
        return FALSE;
    }

	
	public function create_notification($notification_array = array()){
	    $this->load->library('socketemitter');
		
		if(!empty($notification_array)){	
		
			$all = $this->db->insert('notiy', $notification_array['insert_array']);	
			$notifyid = $this->db->insert_id();
			if(isset($notification_array['from_role']) && $notification_array['from_role'] != SALE){	
				
				if($notification_array['from_role'] == WAITER){
					$role_form = 'Waiter';
				}elseif($notification_array['from_role'] == KITCHEN){
					$role_form = 'Kitchen';
				}elseif($notification_array['from_role'] == CASHIER){
					$role_form = 'Cashier';					
				}
				
				
				if($notification_array['insert_array']['role_id'] == WAITER){
					$role_to = 'Waiter';
				}elseif($notification_array['insert_array']['role_id'] == KITCHEN){
					$role_to = 'Kitchen';
				}elseif($notification_array['insert_array']['role_id'] == CASHIER){
					$role_to = 'Cashier';					
				}
				
				$notification = array(
					'msg' => $role_form.' to  '.$role_to,
					'type' => $notification_array['insert_array']['type'],
					'user_id' => $notification_array['insert_array']['user_id'],	
					'table_id' => $notification_array['insert_array']['table_id'],	
					'role_id' => SALE,
					'warehouse_id' => $notification_array['insert_array']['warehouse_id'],
					'created_on' => date('Y-m-d H:m:s'),
					'is_read' => 0
				);	
				$s = $this->db->insert('notiy', $notification);	
				
					
			}
			
			
			/*if($notification_array['customer_role'] == CUSTOMER){
				$notification_customer = array(
					'msg' => $notification_array['customer_msg'],
					'type' => $notification_array['customer_type'],
					'user_id' => $notification_array['customer_id'],	
					'table_id' => $notification_array['insert_array']['table_id'],	
					'role_id' => CUSTOMER,
					'warehouse_id' => $notification_array['insert_array']['warehouse_id'],
					'created_on' => date('Y-m-d H:m:s'),
					'is_read' => 0
				);	
								
				$c = $this->db->insert('notiy', $notification_customer);	
			}*/
			$notification_title = $notification_array['insert_array']['type'];
			$notification_message = $notification_array['insert_array']['msg'];
			if($this->isSocketEnabled()){
			    $emit_notification['title'] = $notification_title;
			    $emit_notification['msg'] = $notification_message;
			    $time1 = microtime(true);
			    // echo "step_one:".$time1;
			    $this->socketemitter->setEmit('notification', $emit_notification);
			    $time2 = microtime(true);
			    // echo "step_two:".$time2;
			}
			return $notifyid;
		}
		return false;
	}
	
	public function notification_clear($notification_id){
		
		if(!empty($notification_id)){	
			
			$this->db->where_in('id', explode(',',$notification_id));
			$this->db->update('notiy', array('is_read' => 1));			
			
			return true;
		}
		return false;
	}
	
	
	
	public function notification_count($group_id, $user_id, $warehouse_id){
		$current_date = date('Y-m-d');
		$data = array();
		
		$u = $this->db->select('*')->where('to_user_id', $user_id)->where('warehouse_id', $warehouse_id)->where('is_read', 0)->where('DATE(created_on)', $current_date)->get('notiy');
		if ($u->num_rows() > 0) {
			foreach($u->result() as $uow){
				$user[] = $uow;
			}
		}
		
		/*$r =$this->db->select('*')->where('role_id', $group_id)->where('to_user_id', 0)->where('warehouse_id', $warehouse_id)->where('is_read', 0)->where('DATE(created_on)', $current_date)->get('notiy');
		if ($r->num_rows() > 0) {
			foreach($r->result() as $row){
				$group[] = $row;
			}
		}
		if(!empty($user) && empty($group)){
			$data['list'] = $user;
		}elseif(empty($user) && !empty($group)){
			$data['list'] = $group;
		}elseif(!empty($user) && !empty($group)){
			$data['list'] = array_merge($user, $group);
		}*/

		if(!empty($user)){
			$data['list'] = $user;
		}
		
		if(!empty($data['list'])){
			$data['count'] = count($data['list']);
			return $data;
		}else{
			return false;
		}
				
		
	}
	
	

    public function get_setting() {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	public function get_posSetting()
    {	
        $q = $this->db->get('pos_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }	
	
	
	public function devicesCheck($api_key){
		$q = $this->db->get_where('api_keys', array('key' => $api_key), 1);		
        if ($q->num_rows() == 1) {
			
            return $q->row('devices_key');
        }
		return FALSE;
	}
	
	

    public function getDateFormat($id) {
        $q = $this->db->get_where('date_format', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
    public function getUser($id = NULL) {
        if (!$id) {
            $id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('users', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

   
	
	 public function getAllGroups($pos_user = false) {
		 if($pos_user){
			 $this->db->where_not_in('id', array(1,2,3,4,9));
			 
		 } 
		 $q = $this->db->get('groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCurrencies() {
        $q = $this->db->get('currency');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCurrencyByCode($code) {
        $q = $this->db->get_where('currency', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
	public function defaultCurrencyData($id) {
        $q = $this->db->get_where('currency', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

   	
	public function getCurrencyByID($id) {
        $q = $this->db->get_where('currency', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
	

    public function checkPermissions() {
	//if($this->Settings->module_permission==2){
	   $q = $this->db->get_where('user_permissions', array('user_id' => $this->session->userdata('user_id')), 1);
	//}else {
	    //$q = $this->db->get_where('permissions', array('group_id' => $this->session->userdata('group_id')), 1);
	//}
        
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }
	public function getUserByID($id)
    {
        $q = $this->db->get_where('users', array('id' => $id, 'active' => 1), 1);        
        if ($q->num_rows() > 0) {        	
            return $q->row();
        }
        return FALSE;
    }    
    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
   public function getGroupPermissionsarray($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }    
   public function getGroupPermissionsAlluseraccess($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row('pos-view_allusers_orders');
        }
        return FALSE;
    }

    public function getNotifications() {
    	return 1;
       /* $date = date('Y-m-d H:i:s', time());
        $this->db->where("from_date <=", $date);
        $this->db->where("till_date >=", $date);
        if (!$this->Owner) {
            if ($this->Supplier) {
                $this->db->where('scope', 4);
            } elseif ($this->Customer) {
                $this->db->where('scope', 1)->or_where('scope', 3);
            } elseif (!$this->Customer && !$this->Supplier) {
                $this->db->where('scope', 2)->or_where('scope', 3);
            }
        }
        $q = $this->db->get("notifications");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }*/
    }
	
	

    public function getAddressByID($id) {
        return $this->db->get_where('addresses', ['id' => $id], 1)->row();
    }

    public function checkSlug($slug, $type = NULL) {
        if (!$type) {
            return $this->db->get_where('products', ['slug' => $slug], 1)->row();
        } elseif ($type == 'category') {
            return $this->db->get_where('categories', ['slug' => $slug], 1)->row();
        } elseif ($type == 'brand') {
            return $this->db->get_where('brands', ['slug' => $slug], 1)->row();
        }
        return FALSE;
    }

    

    
    /**** one login at a time ****/
    function isloggeddIn($user){
        
        $q = $this->db
        ->select()
        ->from('user_logins')
        //->where("username ='$user' or email = '$user' ")
	->where("login_type='A' AND (username ='$user' or email = '$user' )")
        ->order_by('id','DESC')
        ->get();
        $data = $q->row_array();
        if($q->num_rows() > 0){
            if($data['status']=="logged_out"){
                return false;
            }else if(time()>strtotime($data['expiry'])){
               return false;
            }/*else if(time()>strtotime($data['last_activity'])+120){
               return false;
            }*/else{
               return true;
            }
        }
       return false;
    }
    function updateLoginStatus($data){
        $session_id = $this->session->userdata('session_id');
        $this->db->where('session_id',$session_id);
        $this->db->update('user_logins',$data);
    }
    function isActiveUser(){
	if($this->router->fetch_method()=="logout"){return true;}
	$session_id = $this->session->userdata('session_id');
	$login_user = $this->session->userdata('username');
        $login_email = $this->session->userdata('email');
        $q = $this->db
        ->select()
        ->from('user_logins')
        ->where("login_type='A' AND (username ='$login_user' or email = '$login_email' )")
	
        ->order_by('id','DESC')
        ->get();
	
	//print_R($q->row());
        if($q->num_rows()>0){
            $row = $q->row();//print_r($row);
	    //echo $session_id.'=='.$row->session_id;exit;
            if($session_id!=$row->session_id) {
		
		/*$data['status'] = "inactive";	*/	
		$this->updateLoginStatus($data);
		$this->session->set_flashdata(lang('someone has logged in'));
		$this->ion_auth->logout();
		admin_redirect('login');
	    }
        }
    }
    /**** one login at a time - End****/
    public function getAllPrinters() {
        $q = $this->db->get('printers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
   
    function setTimeout($fn,$reference,$count){
	$Settings = $this->site->get_setting();
	$timeout = $Settings->notification_time_interval;
	// sleep for $timeout milliseconds.
	sleep($timeout);

	$this->$fn($reference,$count);
    }
    
    public function deviceGET($user_id){
		$this->db->select('users.id, device_detail.device_token');
		$this->db->join('device_detail', 'device_detail.user_id = users.id', 'left');
		$this->db->where('users.id', $user_id);
		$q = $this->db->get('users');
		if ($q->num_rows() > 0) {
							
			foreach($q->result() as $row){
				$data[] = $row->device_token;
			}
			return $data;
			
		}
		return FALSE;
	}
	public function deviceDetails($user_id){
		$this->db->select('users.id, device_detail.device_token,socket_id');
		$this->db->join('device_detail', 'device_detail.user_id = users.id');
		$this->db->where('users.id', $user_id);
		$this->db->group_by('device_detail.user_id,device_detail.devices_key');
		$q = $this->db->get('users');
		
		if ($q->num_rows() > 0) {
							
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
			
		}
		return FALSE;
	}
    
    
    function isSocketEnabled(){
	$data = $this->get_setting();
	return @$data->socket_enable;
    }
    function update_dbbackup_date($data){
	
	$this->db->update('ftp_backup',$data);
    }
    function update_filesbackup_date($data){
	
	$this->db->update('ftp_backup',$data);
    }
    function update_ftpbackup($data){
	
	$this->db->update('ftp_backup',$data);
    }
    function getAutoback_details(){
	$q = $this->db->get('ftp_backup');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

	
    function getPrinters($ids){
	$this->db->select();
	$this->db->from('printers');
	$this->db->where_in('id',$ids);
	$q = $this->db->get();
	if($q->num_rows()>0){
	    return $q->result();
	}
	return false;
    }
    public function amount_to_percentage($value = NULL, $amount = NULL) {
            
            if ($value !='' && $amount !='') {
            	$percentage = ( $value / $amount ) * 100;
            	return $percentage;
            }
        
        return 0;
    }
    
	function generatorcode($form_type){
		$s = 3;
		$n = 3;
		$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$number = '0123456789'; 
		$randomString = ''; 
	  
		for ($i = 0; $i < $s; $i++) { 
			$index = rand(0, strlen($string) - 1); 
			$randomString .= $string[$index]; 
		} 
		
		$randomNumber = ''; 
	  
		for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($number) - 1); 
			$randomNumber .= $number[$index]; 
		} 
		$random = $randomString.$form_type.$randomNumber;
		return $random;
	}
	
	
	
	function refercode($form_type)
	{
		do{
			$refer_code = $this->generatorcode($form_type);
			$q = $this->db->select('id')->where('refer_code', $refer_code)->get('formone');	
		}while($q->num_rows()>0);
		return $refer_code;
		
	}
	

	
	function commoncode($form_type, $table)
	{
		do{
			$refer_code = $this->generatorcode($form_type);
			$q = $this->db->select('id')->where('code', $refer_code)->get($table);	
		}while($q->num_rows()>0);
		return $refer_code;
		
	}
	
	function forgotcode($form_type, $table)
	{
		do{
			$refer_code = $this->generatorcode($form_type);
			$q = $this->db->select('id')->where('forgotten_password_code', $refer_code)->get($table);	
		}while($q->num_rows()>0);
		return $refer_code;
		
	}
	
	function username($form_type)
	{
		do{
			$refer_code = $this->generatorcode($form_type);
			$q = $this->db->select('id')->where('username', $refer_code)->get('users');	
		}while($q->num_rows()>0);
		return $refer_code;
		
	}
	
	
	public function getPetstype($pets_id){

       $this->db->select('*');
        $this->db->from('pets_type');
        
        $this->db->where('pets_id',$pets_id);
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	public function Alldepartment(){

       $this->db->select('*');
        $this->db->from('department');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	public function getVendorID($id){
		
		
       $this->db->select('*');
        $this->db->from('users');
       $this->db->where('id', $id);
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data;
        }
        return FALSE;
    }
    
	public function getVendorAddress($id) {		
		
        $this->db->select('*');
        $this->db->from('user_address');
        $this->db->where('user_id', $id);
        $q = $this->db->get();
        $row = $q->row();

        $this->db->select('name');
        $this->db->where('id', $row->province);
        $this->db->from('province');
        $pro = $this->db->get();
        $pro_row = $pro->row();
        //return $address["province"] = $pro_row->name;

        $this->db->select('name');
        $this->db->where('id', $row->district);
        $this->db->from('district');
        $dis = $this->db->get();
        $dis_row = $dis->row();

        $this->db->select('name');
        $this->db->where('id', $row->commune);
        $this->db->from('commune');
        $com = $this->db->get();
        $com_row = $com->row();

        $this->db->select('name');
        $this->db->where('id', $row->village);
        $this->db->from('village');
        $vil = $this->db->get();
        $vil_row = $vil->row();

        return $pro_row->name.'-'.$dis_row->name.'-'.$com_row->name.'-'.$vil_row->name;
     }

	
	public function getFormoneIDcheckCode($refer_code){
		$this->db->select('id');
        $this->db->from('formone');
        $this->db->where('refer_code', $refer_code);
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            $data = $q->row('id');
            return $data;
        }
        return FALSE;
	}
	
	public function getUserGroup($user_id = false) {
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $group_id = $this->getUserGroupID($user_id);
        $q = $this->db->get_where('groups', array('id' => $group_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	public function getUserGroupIDbyname($group_name = false) {

        $q = $this->db->get_where('groups', array('name' => $group_name), 1);
        if ($q->num_rows() > 0) {
            return $q->row('id');
        }
        return FALSE;
    }
	
    public function getUserGroupID($user_id = false) {
        $user = $this->getUser($user_id);
        return $user->group_id;
    }
	
	public function getALLVendor(){
		
       $this->db->select('*');
        $this->db->from('users');
       $this->db->where('group_id', 4);
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	public function getALLFormtwo(){
		//$this->db->where('group_id', 3);
       $this->db->select('*');
        $this->db->from('formtwo');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	public function getALLFormone() {
		//$this->db->where('group_id', 3);
       $this->db->select('*');
        $this->db->from('formone');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    

    public function getALLBioDigesterFormTwo() {

        $this->db->select('fone.id, fone.refer_code, fone.head_of_family, fone.identification_number, fone.phone_number');
        $this->db->from('formone fone');
        $this->db->join('formtwo ftwo', 'fone.refer_code = ftwo.formone_code','left');
        $this->db->where('fone.status = 1');
        $this->db->where('ftwo.formone_code IS NULL');
        $this->db->order_by("fone.created_on", "DESC");
        $this->db->order_by("ftwo.created_on", "DESC");

        $q = $this->db->get();
        //print_r($this->db->last_query());
        //die;

        if($q->num_rows() > 0){
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }

        return FALSE;
    }
    
    public function getALLBioDigesterFormThree() {

        $this->db->select('ftwo.id, ftwo.refer_code, ftwo.head_of_family, ftwo.identification_number, ftwo.phone_number');
        $this->db->from('formtwo ftwo');
        $this->db->join('formthree fthree', 'ftwo.refer_code = fthree.formtwo_code','left');
        $this->db->where('ftwo.status = 1');
        $this->db->where('fthree.formtwo_code IS NULL');
        $this->db->order_by("ftwo.created_on", "DESC");
        $this->db->order_by("fthree.created_on", "DESC");

        $q = $this->db->get();
        //print_r($this->db->last_query());
        //die;

        if($q->num_rows() > 0){
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }

        return FALSE;
    }


	public function getALLFarmer(){
		$this->db->where('group_id', 3);
       $this->db->select('*');
        $this->db->from('users');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
	public function getALLFarmerActive(){

        $array = array('group_id' => 3, 'active' => 1);
		$this->db->where($array);
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('created_on DESC');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}

	
	public function getALLStaff(){
		$this->db->where('group_id', 5);
       $this->db->select('*');
        $this->db->from('users');
       
        $q = $this->db->get(); 
        // print_r($this->db->last_query());die;
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	function getRole_byuser($department_id, $role_id, $group_id, $location_id){
		
		$this->db->select('up.user_id, up.group_id, up.is_all, up.department_id, up.reporter_id, u.email, u.phone, u.active, u.first_name, u.last_name');		
		$this->db->from('user_access up');
		$this->db->join('users u', 'u.id = up.user_id');
		if($role_id == 'Province'){
			$this->db->where('up.is_all', 1);
		}else{
			$this->db->where('up.is_all', 0);
			$this->db->where('up.department_id', $department_id);
			
			if($role_id == 'Province'){
				$this->db->where('up.province_id', 0);
				$this->db->where('up.district_id', 0);
				$this->db->where('up.commune_id', 0);
				$this->db->where('up.village_id', 0);
				
			}elseif($role_id == 'District'){
				$this->db->where('up.province_id', $location_id);
				$this->db->where('up.district_id', 0);
				$this->db->where('up.commune_id', 0);
				$this->db->where('up.village_id', 0);
			}elseif($role_id == 'Commune'){
				$this->db->where('up.district_id', $location_id);
				$this->db->where('up.commune_id', 0);
				$this->db->where('up.village_id', 0);
			}elseif($role_id == 'Village'){
				$this->db->where('up.commune_id', $location_id);
				$this->db->where('up.village_id', 0);
			}
		}
		
		 $q = $this->db->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
				
				$data[] = $row;
				
            }
			return $data;
		}
		return FALSE;	
	}
    
    function getApp_permission($user_id){
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$q = $this->db->get('app_permission');
		if($q->num_rows()>0){
			return $q->row();	
		}
		return false;	
	}

	public function getPartAlocation($province, $district, $commune, $village){
		$this->db->select('name');
        $this->db->where('id', $province);
        $this->db->from('province');
        $pro = $this->db->get();
        $pro_row = $pro->row();
        //return $address["province"] = $pro_row->name;

        $this->db->select('name');
        $this->db->where('id', $district);
        $this->db->from('district');
        $dis = $this->db->get();
        $dis_row = $dis->row();

        $this->db->select('name');
        $this->db->where('id', $commune);
        $this->db->from('commune');
        $com = $this->db->get();
        $com_row = $com->row();

        $this->db->select('name');
        $this->db->where('id', $village);
        $this->db->from('village');
        $vil = $this->db->get();
        $vil_row = $vil->row();
		
		return $pro_row->name.'-'.$dis_row->name.'-'.$com_row->name.'-'.$vil_row->name;
	}
	public function getStaffDetail($id) {		
		
        $this->db->select('*');
        $this->db->from('user_address');
        $this->db->where('user_id', $id);
        $q = $this->db->get();
        $row = $q->row();

        $this->db->select('name');
        $this->db->where('id', $row->province);
        $this->db->from('province');
        $pro = $this->db->get();
        $pro_row = $pro->row();
        //return $address["province"] = $pro_row->name;

        $this->db->select('name');
        $this->db->where('id', $row->district);
        $this->db->from('district');
        $dis = $this->db->get();
        $dis_row = $dis->row();

        $this->db->select('name');
        $this->db->where('id', $row->commune);
        $this->db->from('commune');
        $com = $this->db->get();
        $com_row = $com->row();

        $this->db->select('name');
        $this->db->where('id', $row->village);
        $this->db->from('village');
        $vil = $this->db->get();
        $vil_row = $vil->row();

        $this->db->select('phone');
        $this->db->from('users');
        $this->db->where('id', $id);
        $uq = $this->db->get();
        $urow = $uq->row();

        return $pro_row->name.'-'.$dis_row->name.'-'.$com_row->name.'-'.$vil_row->name.'###'.$urow->phone;
     }

     public function getFormID($id)
    {
        $q = $this->db->get_where('form_settings', array('form_id' => $id), 1);        
        if ($q->num_rows() > 0) {        	
            return $q->row();
        }
        return FALSE;
    }
    
    
    public function webPermission($userid, $controller, $method)
    {
        $column = $controller.'-'.$method;

        $array = array('user_id' => $userid, $column => '0');
		$this->db->select($column);
		$this->db->where($array);
        $q = $this->db->get('web_permissions');
        //print_r($this->db->last_query()); die;

		if($q->num_rows()>0){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'admin/welcome');
		}else{
			return true;
		}
    }


    public function menuList()
    {
        $array = array('user_id' => $this->session->userdata('user_id'));
		$this->db->select('*');
		$this->db->where($array);
        $q = $this->db->get('web_permissions');
        //print_r($this->db->last_query()); die;

        if ($q->num_rows() > 0) {        	
            return $q->row();
        }
        return FALSE;
    }

}
