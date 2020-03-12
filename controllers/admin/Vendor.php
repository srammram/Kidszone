<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
		//$this->lang->admin_load('system_settings', $this->Settings->user_language);
		//$this->lang->admin_load('common', $this->Settings->user_language);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		$this->upload_path = 'assets/uploads/';
		$this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|png|jpeg|pdf';
		$this->allowed_file_size = '1024';
		$this->load->admin_model('vendor_model');
		$this->load->admin_model('settings_model');
		$this->data['menu'] = $this->site->menuList();
    }
	
	
	/*###### Vendor*/
    function index($action=false){
		
		
		$this->site->webPermission($this->session->userdata('user_id'), 'vendor', 'index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('builders')));
        $meta = array('page_title' => lang('builders'), 'bc' => $bc);
        $this->page_construct('vendor/index', $meta, $this->data);
    }
	
    function getVendor(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select(" {$this->db->dbprefix('users')}.id as id, {$this->db->dbprefix('users')}.username as username,  {$this->db->dbprefix('users')}.first_name, {$this->db->dbprefix('users')}.identification_number, {$this->db->dbprefix('users')}.phone, {$this->db->dbprefix('users')}.email, date_format({$this->db->dbprefix('users')}.created_on,'%d/%m/%Y'), {$this->db->dbprefix('users')}.active as status")
            ->from("users");
			$this->datatables->where('group_id', 4);
			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}
			
            $this->datatables->edit_column('status', '$1__$2', 'id, status');
			
			$edit = "<a href='" . admin_url('vendor/edit_vendor/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			$view = "<a href='" . admin_url('vendor/view_vendor/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$delete = "<a href='" . admin_url('welcome/delete/users/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
        echo $this->datatables->generate();
		
    }
	
	function add_vendor(){
		

		$this->site->webPermission($this->session->userdata('user_id'), 'vendor', 'add_vendor');

		$this->form_validation->set_rules('phone', lang("phone"), 'is_unique[users.phone]'); 
		$this->form_validation->set_rules('identification_number', lang("identification_number"), 'is_unique[users.identification_number]'); 
		 
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
		
        if ($this->form_validation->run() == true) {
			
			
			$oauth_token = get_random_key(32,'users','oauth_token',$type='alnum');
		    $mobile_otp = random_string('numeric', 6);
						
            $data = array(
                'username' => $this->input->post('username'),
				'oauth_token' => $oauth_token,
				'password' => md5($this->input->post('password')),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
				'active' => 1,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'identification_number' => $this->input->post('identification_number'),
				'group_id' => 4,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),            
				);
				
			/*if ($_FILES['avatar']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->photo_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 25;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('avatar')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$avatar = $this->upload->file_name;
				$data['avatar'] = $avatar;
				$config = NULL;
			}*/

			if ($_FILES['avatar']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 25;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('avatar')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}

                $photo = $this->upload->file_name;
                $data['avatar'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 150;
                $config['height'] = 150;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                    $error = $this->image_lib->display_errors();
                    $response['error'] = $error;
                    echo json_encode($response);exit;
                }


			}
			
			$address_array = array(
				'province' => $this->input->post('province'),
				'district' => $this->input->post('district'),
				'commune' => $this->input->post('commune'),
				'village' => $this->input->post('village'),
				'created_on' => date('Y-m-d H:i:s')
			);
			
			
						
        }
		
		
        if ($this->form_validation->run() == true && $this->vendor_model->add_vendor($data, $address_array)){
			
            $this->session->set_flashdata('message', lang("builders_added"));
            admin_redirect('vendor/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('vendor/index'), 'page' => lang('builders')), array('link' => '#', 'page' => lang('add_builders')));
            $meta = array('page_title' => lang('add_builders'), 'bc' => $bc);
			
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['department'] = $this->site->Alldepartment();
			
            $this->page_construct('vendor/add', $meta, $this->data);
			
  
        }
    }
	
	function view_vendor($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'vendor', 'view_vendor');
		$result = $this->vendor_model->getVendorby_ID($id);
		//$access_result = $this->vendor_model->getVendor_accessby_ID($id);
		$address_result = $this->vendor_model->getVendor_addressby_ID($id);
		
		$this->data['province'] = $this->settings_model->getALLProvince();
		$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
		
		$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
		
		$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
		$this->data['department'] = $this->site->Alldepartment();
		$this->data['result'] = $result;
		//$this->data['access_result'] = $access_result;
		$this->data['address_result'] = $address_result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('vendor/index'), 'page' => lang('builders')), array('link' => '#', 'page' => lang('view_builders')));
		$meta = array('page_title' => lang('view_builders'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('vendor/view', $meta, $this->data);
        
    }
	
    function edit_vendor($id){

		$this->site->webPermission($this->session->userdata('user_id'), 'vendor', 'edit_vendor');

		$result = $this->vendor_model->getVendorby_ID($id);
		//$access_result = $this->vendor_model->getVendor_accessby_ID($id);
		$address_result = $this->vendor_model->getVendor_addressby_ID($id);
		
		if($this->input->post('edit_vendor')){
		
		
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
				
		
        if ($this->form_validation->run() == true) {
			
			$data = array(
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password') ? md5($this->input->post('password')) : $result->password,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'identification_number' => $this->input->post('identification_number'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
				);
				
			/*if ($_FILES['avatar']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->photo_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 25;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('avatar')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$avatar = $this->upload->file_name;
				$data['avatar'] = $avatar;
				$config = NULL;
			}*/

			if ($_FILES['avatar']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 25;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('avatar')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}

                $photo = $this->upload->file_name;
                $data['avatar'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 150;
                $config['height'] = 150;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                    $error = $this->image_lib->display_errors();
                    $response['error'] = $error;
                    echo json_encode($response);exit;
                }
			}
			
			$address_array = array(
				'province' => $this->input->post('province'),
				'district' => $this->input->post('district'),
				'commune' => $this->input->post('commune'),
				'village' => $this->input->post('village'),
				'created_on' => date('Y-m-d H:i:s')
			);
			
			
			} elseif ($this->input->post('edit_vendor')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("vendor/edit_vendor/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->vendor_model->update_vendor($id, $data, $address_array)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("vendor_updated"));
            admin_redirect("vendor/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
			
			$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
			
			$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
			$this->data['department'] = $this->site->Alldepartment();
			$this->data['result'] = $result;
			//$this->data['access_result'] = $access_result;
			$this->data['address_result'] = $address_result;
						
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('vendor/index'), 'page' => lang('builders')), array('link' => '#', 'page' => lang('edit_builders')));
            $meta = array('page_title' => lang('edit_builders'), 'bc' => $bc);
			
            $this->data['id'] = $id;
			 $this->page_construct('vendor/edit', $meta, $this->data);
        }
    }
	function vendor_status($status,$id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'vendor', 'vendor_status');
        $data['active'] = 0;
        if($status=='active'){
            $data['active'] = 1;
        }
        $this->vendor_model->update_vendor_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	function getdistrict_byprovince_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		
		$province_id = $this->input->post('province_id');
		$location_id = $this->input->post('province_id');
		$group_id = 3;
		if($department_id == 1){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getdistrict_byprovince($province_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
	
	function getcommune_bydistrict_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$district_id = $this->input->post('district_id');
		$location_id = $this->input->post('district_id');
		$group_id = 3;
		if($department_id == 2){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getcommune_bydistrict($district_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
	
	
	function getvillage_bycommune_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$commune_id = $this->input->post('commune_id');
		$location_id = $this->input->post('commune_id');
		$group_id = 3;
		if($department_id == 3){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getvillage_bycommune($commune_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
}
