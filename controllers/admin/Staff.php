<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends MY_Controller
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
		$this->load->admin_model('staff_model');
		$this->load->admin_model('settings_model');
		$this->data['menu'] = $this->site->menuList();
    }
	
	
	/*###### Staff*/
    function index($action=false){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('staff')));
        $meta = array('page_title' => lang('staff'), 'bc' => $bc);
		
        $this->page_construct('staff/index', $meta, $this->data);
    }
	
    function getStaff(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select("{$this->db->dbprefix('users')}.id as id, {$this->db->dbprefix('users')}.username as username, {$this->db->dbprefix('users')}.first_name, {$this->db->dbprefix('users')}.last_name, {$this->db->dbprefix('users')}.phone, {$this->db->dbprefix('users')}.email, r.position, date_format({$this->db->dbprefix('users')}.created_on,'%d/%m/%Y'), {$this->db->dbprefix('users')}.active as status")
            ->from("users");
			$this->datatables->join('user_access ua', "ua.user_id = {$this->db->dbprefix('users')}.id", 'left');
			$this->datatables->join('role r', 'r.access_location = ua.role_id', 'left');
			$this->datatables->where("{$this->db->dbprefix('users')}.group_id", 5);
			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}
			
            $this->datatables->edit_column('status', '$1__$2', 'id, status');
			
			$edit = "<a href='" . admin_url('staff/edit_staff/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			$view = "<a href='" . admin_url('staff/view_staff/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			$permission = "<a href='" . admin_url('staff/app_permission_staff/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Permission'  ><i class='fa fa-lock' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$delete = "<a href='" . admin_url('welcome/delete/users/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$permission."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
        echo $this->datatables->generate();
		
    }
	
	function get_username() {

		$username = $this->input->post('username');
		$data = $this->staff_model->get_username($username);
		echo $data;
	}
	
	function add_staff(){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'add_staff');
		$this->form_validation->set_rules('phone', lang("phone"), 'is_unique[users.phone]'); 
		//$this->form_validation->set_rules('email', lang("email"), 'required|is_unique[users.email]'); 
		 
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
		$this->form_validation->set_rules('reporter_id[]', lang("reporter"), 'required');  
		
        if ($this->form_validation->run() == true) {
			
			
			$oauth_token = get_random_key(32,'users','oauth_token',$type='alnum');
		    $mobile_otp = random_string('numeric', 6);
						
            $data = array(
                'username' => $this->input->post('username'),
				'oauth_token' => $oauth_token,
				'password' => md5($this->input->post('password')),
				'email' => $this->input->post('email'),
				'active' => 1,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'group_id' => 5,
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
			
			$access_array = array(
				'group_id' => 5,
				'department_id' => $_POST['department_id'][0] ? $_POST['department_id'][0] : 0,
				'role_id' => $_POST['role_id'][0] ? $_POST['role_id'][0] : 0,
				'province_id' => $_POST['province_id'][0] ? $_POST['province_id'][0] : 0,
				'district_id' => $_POST['district_id'][0] ? $_POST['district_id'][0] : 0,
				'commune_id' => $_POST['commune_id'][0] ? $_POST['commune_id'][0] : 0,
				'village_id' => $_POST['village_id'][0] ? $_POST['village_id'][0] : 0,
				'reporter_id' => $_POST['reporter_id'][0] ? $_POST['reporter_id'][0] : 0,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			);
			
			//print_r($access_array);die;
						
        }
		
		
        if ($this->form_validation->run() == true && $this->staff_model->add_staff($data, $address_array, $access_array)){
			
            $this->session->set_flashdata('message', lang("staff_added"));
            admin_redirect('staff/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('add_staff')));
            $meta = array('page_title' => lang('add_staff'), 'bc' => $bc);
			
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['department'] = $this->settings_model->getALLDepartment();
			$this->data['role'] = $this->settings_model->getALLRole();
			
            $this->page_construct('staff/add', $meta, $this->data);
			
  
        }
    }
	
	function view_staff($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'view_staff');
		$result = $this->staff_model->getStaffby_ID($id);
		$access_result = $this->staff_model->getStaff_accessby_ID($id);
		$address_result = $this->staff_model->getStaff_addressby_ID($id);
		
		$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['department'] = $this->settings_model->getALLDepartment();
			$this->data['role'] = $this->settings_model->getALLRole();
			
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
			
			$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
			
			$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
			//$this->data['department'] = $this->site->Alldepartment();
			$this->data['result'] = $result;
			$this->data['access_result'] = $access_result;
			$this->data['address_result'] = $address_result;
			
			$this->data['adistrict'] = $this->settings_model->getdistrict_byprovince($access_result->province_id);
			$this->data['acommune'] = $this->settings_model->getcommune_bydistrict($access_result->district_id);
			$this->data['avillage'] = $this->settings_model->getvillage_bycommune($access_result->commune_id);
			
			if($access_result->role_id == 'Village'){
				$location_id = $access_result->commune_id;
			}elseif($access_result->role_id == 'Commune'){
				$location_id = $access_result->district_id;
			}elseif($access_result->role_id == 'District'){
				$location_id = $access_result->province_id;
			}else{
				$location_id = 0;	
			}
			$this->data['reporter'] = $this->site->getRole_byuser($access_result->department_id, $access_result->role_id, 3, $location_id);		
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('view_staff')));
		$meta = array('page_title' => lang('view_staff'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('staff/view', $meta, $this->data);
        
    }
	
    function edit_staff($id){

		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'edit_staff');

		$result = $this->staff_model->getStaffby_ID($id);
		$access_result = $this->staff_model->getStaff_accessby_ID($id);
		//print_r($access_result);
		//die;
		$address_result = $this->staff_model->getStaff_addressby_ID($id);
		
		if($this->input->post('edit_staff')){
		
		
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
		$this->form_validation->set_rules('reporter_id', lang("reporter"), 'required');  
				
		
        if ($this->form_validation->run() == true) {
			
			$data = array(
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password') ? md5($this->input->post('password')) : $result->password,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
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
			
			$access_array = array(
				'group_id' => 5,
				'department_id' => $_POST['department_id'][0] ? $_POST['department_id'][0] : 0,
				'role_id' => $_POST['role_id'][0] ? $_POST['role_id'][0] : 0,
				'province_id' => $_POST['province_id'][0] ? $_POST['province_id'][0] : 0,
				'district_id' => $_POST['district_id'][0] ? $_POST['district_id'][0] : 0,
				'commune_id' => $_POST['commune_id'][0] ? $_POST['commune_id'][0] : 0,
				'village_id' => $_POST['village_id'][0] ? $_POST['village_id'][0] : 0,
				'reporter_id' => $_POST['reporter_id'][0] ? $_POST['reporter_id'][0] : 0,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			);
			
			} elseif ($this->input->post('edit_staff')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("staff/edit_staff/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->staff_model->update_staff($id, $data, $address_array, $access_array)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("staff_updated"));
            admin_redirect("staff/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['department'] = $this->settings_model->getALLDepartment();
			$this->data['role'] = $this->settings_model->getALLRole();
			
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
			
			$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
			
			$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
			//$this->data['department'] = $this->site->Alldepartment();
			$this->data['result'] = $result;
			$this->data['access_result'] = $access_result;
			$this->data['address_result'] = $address_result;
			
			$this->data['adistrict'] = $this->settings_model->getdistrict_byprovince($access_result->province_id);
			$this->data['acommune'] = $this->settings_model->getcommune_bydistrict($access_result->district_id);
			$this->data['avillage'] = $this->settings_model->getvillage_bycommune($access_result->commune_id);
			
			if($access_result->role_id == 'Village'){
				$location_id = $access_result->commune_id;
			}elseif($access_result->role_id == 'Commune'){
				$location_id = $access_result->district_id;
			}elseif($access_result->role_id == 'District'){
				$location_id = $access_result->province_id;
			}else{
				$location_id = 0;	
			}
			$this->data['reporter'] = $this->site->getRole_byuser($access_result->department_id, $access_result->role_id, 3, $location_id);	
			//print_r($this->data['reporter']);die;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('edit_staff')));
			
			
			
            $meta = array('page_title' => lang('edit_staff'), 'bc' => $bc);
			
            $this->data['id'] = $id;
			 $this->page_construct('staff/edit', $meta, $this->data);
        }
	}
	
	function app_permission_staff($id){
		$result = $this->staff_model->getStaffby_ID($id);
		$app_permission = $this->staff_model->getAppPermission($id);
		$web_result = $this->staff_model->getWebPermissionByID($id);
		
		
		if($this->input->post('app_permission_staff')){
		
		
		$this->form_validation->set_rules('user_id', lang("user_id"), 'required');  
				
		
        if ($this->form_validation->run() == true) {
			
			$data = array(
				'formone_enable' => $this->input->post('formone_enable') ? $this->input->post('formone_enable') : 0,
				'formtwo_enable' => $this->input->post('formtwo_enable') ? $this->input->post('formtwo_enable') : 0,
				'formthree_enable' => $this->input->post('formthree_enable') ? $this->input->post('formthree_enable') : 0,
				'formfour_enable' => $this->input->post('formfour_enable') ? $this->input->post('formfour_enable') : 0,
				'formfive_enable' => $this->input->post('formfive_enable') ? $this->input->post('formfive_enable') : 0,
				'formsix_enable' => $this->input->post('formsix_enable') ? $this->input->post('formsix_enable') : 0,
				'formseven_enable' => $this->input->post('formseven_enable') ? $this->input->post('formseven_enable') : 0,
				'formeight_enable' => $this->input->post('formeight_enable') ? $this->input->post('formeight_enable') : 0,
				'formnine_enable' => $this->input->post('formnine_enable') ? $this->input->post('formnine_enable') : 0,
				'formone_edit_enable' => $this->input->post('formone_edit_enable') ? $this->input->post('formone_edit_enable') : 0,
				'formtwo_edit_enable' => $this->input->post('formtwo_edit_enable') ? $this->input->post('formtwo_enable') : 0,
				'formthree_edit_enable' => $this->input->post('formthree_edit_enable') ? $this->input->post('formthree_edit_enable') : 0,
				'formfour_edit_enable' => $this->input->post('formfour_edit_enable') ? $this->input->post('formfour_edit_enable') : 0,
				'formfive_edit_enable' => $this->input->post('formfive_edit_enable') ? $this->input->post('formfive_edit_enable') : 0,
				'formsix_edit_enable' => $this->input->post('formsix_edit_enable') ? $this->input->post('formsix_edit_enable') : 0,
				'formseven_edit_enable' => $this->input->post('formseven_edit_enable') ? $this->input->post('formseven_edit_enable') : 0,
				'formeight_edit_enable' => $this->input->post('formeight_edit_enable') ? $this->input->post('formeight_edit_enable') : 0,
				'formnine_edit_enable' => $this->input->post('formnine_edit_enable') ? $this->input->post('formnine_edit_enable') : 0,
				'created_on' => date('Y-m-d H:i:s'),
				          
				);



				$web_data= array(
					'formone-index' => (($this->input->post('formone-index')!=NULL) ? 1 : 0),
					'formone-add_formone' => (($this->input->post('formone-add_formone')!=NULL) ? 1 : 0),
					'formone-edit_formone' => (($this->input->post('formone-edit_formone')!=NULL) ? 1 : 0),
					'formone-delete' => (($this->input->post('formone-delete')!=NULL) ? 1 : 0),
					'formone-view_formone' => (($this->input->post('formone-view_formone')!=NULL) ? 1 : 0),
					'formone-delete' => (($this->input->post('formone-delete')!=NULL) ? 1 : 0),
					'formone-formone_status' => (($this->input->post('formone-formone_status')!=NULL) ? 1 : 0),
					'formtwo-index' => (($this->input->post('formtwo-index')!=NULL) ? 1 : 0),
					'formtwo-add_formtwo' => (($this->input->post('formtwo-add_formtwo')!=NULL) ? 1 : 0),
					'formtwo-edit_formtwo' => (($this->input->post('formtwo-edit_formtwo')!=NULL) ? 1 : 0),
					'formtwo-edit_formtwo' => (($this->input->post('formtwo-edit_formtwo')!=NULL) ? 1 : 0),
					'formtwo-delete' => (($this->input->post('formtwo-delete')!=NULL) ? 1 : 0),
					'formtwo-formtwo_status' => (($this->input->post('formtwo-formtwo_status')!=NULL) ? 1 : 0),
					'formthree-index' => (($this->input->post('formthree-index')!=NULL) ? 1 : 0),
					'formthree-add_formthree' => (($this->input->post('formthree-add_formthree')!=NULL) ? 1 : 0),
					'formthree-edit_formthree' => (($this->input->post('formthree-edit_formthree')!=NULL) ? 1 : 0),
					'formthree-view_formthree' => (($this->input->post('formthree-view_formthree')!=NULL) ? 1 : 0),
					'formthree-delete' => (($this->input->post('formthree-delete')!=NULL) ? 1 : 0),
					'formthree-formthree_status' => (($this->input->post('formthree-formthree_status')!=NULL) ? 1 : 0),
					'farmer-index' => (($this->input->post('farmer-index')!=NULL) ? 1 : 0),
					'farmer-add_farmer' => (($this->input->post('farmer-add_farmer')!=NULL) ? 1 : 0),
					'farmer-edit_farmer' => (($this->input->post('farmer-edit_farmer')!=NULL) ? 1 : 0),
					'farmer-view_farmer' => (($this->input->post('farmer-view_farmer')!=NULL) ? 1 : 0),
					'farmer-delete' => (($this->input->post('farmer-delete')!=NULL) ? 1 : 0),
					'farmer-farmer_status' => (($this->input->post('farmer-farmer_status')!=NULL) ? 1 : 0),
					'vendor-index' => (($this->input->post('vendor-index')!=NULL) ? 1 : 0),
					'vendor-add_vendor' => (($this->input->post('vendor-add_vendor')!=NULL) ? 1 : 0),
					'vendor-edit_vendor' => (($this->input->post('vendor-edit_vendor')!=NULL) ? 1 : 0),
					'vendor-view_vendor' => (($this->input->post('vendor-view_vendor')!=NULL) ? 1 : 0),
					'vendor-delete' => (($this->input->post('vendor-delete')!=NULL) ? 1 : 0),
					'vendor-vendor_status' => (($this->input->post('vendor-vendor_status')!=NULL) ? 1 : 0),
					'staff-index' => (($this->input->post('staff-index')!=NULL) ? 1 : 0),
					'staff-add_staff' => (($this->input->post('staff-add_staff')!=NULL) ? 1 : 0),
					'staff-edit_staff' => (($this->input->post('staff-edit_staff')!=NULL) ? 1 : 0),
					'staff-view_staff' => (($this->input->post('staff-view_staff')!=NULL) ? 1 : 0),
					'staff-delete' => (($this->input->post('staff-delete')!=NULL) ? 1 : 0),
					'staff-staff_status' => (($this->input->post('staff-staff_status')!=NULL) ? 1 : 0),
					'system_settings-index' => (($this->input->post('system_settings-index')!=NULL) ? 1 : 0),
					'system_settings-form' => (($this->input->post('system_settings-form')!=NULL) ? 1 : 0),
					'system_settings-form_settings' => (($this->input->post('system_settings-form_settings')!=NULL) ? 1 : 0),
					'system_settings-province' => (($this->input->post('system_settings-province')!=NULL) ? 1 : 0),
					'system_settings-add_province' => (($this->input->post('system_settings-add_province')!=NULL) ? 1 : 0),
					'system_settings-edit_province' => (($this->input->post('system_settings-edit_province')!=NULL) ? 1 : 0),
					'system_settings-delete_province' => (($this->input->post('system_settings-delete_province')!=NULL) ? 1 : 0),
					'system_settings-province_status' => (($this->input->post('system_settings-province_status')!=NULL) ? 1 : 0),
					'system_settings-district' => (($this->input->post('system_settings-district')!=NULL) ? 1 : 0),
					'system_settings-add_district' => (($this->input->post('system_settings-add_district')!=NULL) ? 1 : 0),
					'system_settings-edit_district' => (($this->input->post('system_settings-edit_district')!=NULL) ? 1 : 0),
					'system_settings-delete_district' => (($this->input->post('system_settings-delete_district')!=NULL) ? 1 : 0),
					'system_settings-district_status' => (($this->input->post('system_settings-district_status')!=NULL) ? 1 : 0),
					'formtwo-view_formtwo' => (($this->input->post('formtwo-view_formtwo')!=NULL) ? 1 : 0),
					'system_settings-commune' => (($this->input->post('system_settings-commune')!=NULL) ? 1 : 0),
					'system_settings-add_commune' => (($this->input->post('system_settings-add_commune')!=NULL) ? 1 : 0),
					'system_settings-edit_commune' => (($this->input->post('system_settings-edit_commune')!=NULL) ? 1 : 0),
					'system_settings-delete_commune' => (($this->input->post('system_settings-delete_commune')!=NULL) ? 1 : 0),
					'system_settings-commune_status' => (($this->input->post('system_settings-commune_status')!=NULL) ? 1 : 0),
					'system_settings-village' => (($this->input->post('system_settings-village')!=NULL) ? 1 : 0),
					'system_settings-add_village' => (($this->input->post('system_settings-add_village')!=NULL) ? 1 : 0),
					'system_settings-edit_village' => (($this->input->post('system_settings-edit_village')!=NULL) ? 1 : 0),
					'system_settings-delete_village' => (($this->input->post('system_settings-delete_village')!=NULL) ? 1 : 0),
					'system_settings-village_status' => (($this->input->post('system_settings-village_status')!=NULL) ? 1 : 0),
					'system_settings-pets' => (($this->input->post('system_settings-pets')!=NULL) ? 1 : 0),
					'system_settings-add_pets' => (($this->input->post('system_settings-add_pets')!=NULL) ? 1 : 0),
					'system_settings-edit_pets' => (($this->input->post('system_settings-edit_pets')!=NULL) ? 1 : 0),
					'system_settings-delete_pets' => (($this->input->post('system_settings-delete_pets')!=NULL) ? 1 : 0),
					'system_settings-pets_status' => (($this->input->post('system_settings-pets_status')!=NULL) ? 1 : 0),
					'system_settings-pets_type' => (($this->input->post('system_settings-pets_type')!=NULL) ? 1 : 0),
					'system_settings-add_pets_type' => (($this->input->post('system_settings-add_pets_type')!=NULL) ? 1 : 0),
					'system_settings-edit_pets_type' => (($this->input->post('system_settings-edit_pets_type')!=NULL) ? 1 : 0),
					'system_settings-delete_pets_type' => (($this->input->post('system_settings-delete_pets_type')!=NULL) ? 1 : 0),
					'system_settings-pets_type_status' => (($this->input->post('system_settings-pets_type_status')!=NULL) ? 1 : 0),
					'system_settings-hygine' => (($this->input->post('system_settings-hygine')!=NULL) ? 1 : 0),
					'system_settings-add_hygine' => (($this->input->post('system_settings-add_hygine')!=NULL) ? 1 : 0),
					'system_settings-edit_hygine' => (($this->input->post('system_settings-edit_hygine')!=NULL) ? 1 : 0),
					'system_settings-delete_hygine' => (($this->input->post('system_settings-delete_hygine')!=NULL) ? 1 : 0),
					'system_settings-hygine_status' => (($this->input->post('system_settings-hygine_status')!=NULL) ? 1 : 0),
					'system_settings-general_hygine' => (($this->input->post('system_settings-general_hygine')!=NULL) ? 1 : 0),
					'system_settings-add_general_hygine' => (($this->input->post('system_settings-add_general_hygine')!=NULL) ? 1 : 0),
					'system_settings-edit_general_hygine' => (($this->input->post('system_settings-edit_general_hygine')!=NULL) ? 1 : 0),
					'system_settings-delete_general_hygine' => (($this->input->post('system_settings-delete_general_hygine')!=NULL) ? 1 : 0),
					'system_settings-general_hygine_status' => (($this->input->post('system_settings-general_hygine_status')!=NULL) ? 1 : 0),
					'system_settings-source_of_water' => (($this->input->post('system_settings-source_of_water')!=NULL) ? 1 : 0),
					'system_settings-add_source_of_water' => (($this->input->post('system_settings-add_source_of_water')!=NULL) ? 1 : 0),
					'system_settings-edit_source_of_water' => (($this->input->post('system_settings-edit_source_of_water')!=NULL) ? 1 : 0),
					'system_settings-delete_source_of_water' => (($this->input->post('system_settings-delete_source_of_water')!=NULL) ? 1 : 0),
					'system_settings-source_of_water_status' => (($this->input->post('system_settings-source_of_water_status')!=NULL) ? 1 : 0),
					'system_settings-currency' => (($this->input->post('system_settings-currency')!=NULL) ? 1 : 0),
					'system_settings-add_currency' => (($this->input->post('system_settings-add_currency')!=NULL) ? 1 : 0),
					'system_settings-edit_currency' => (($this->input->post('system_settings-edit_currency')!=NULL) ? 1 : 0),
					'system_settings-delete_currency' => (($this->input->post('system_settings-delete_currency')!=NULL) ? 1 : 0),
					'system_settings-currency_status' => (($this->input->post('system_settings-currency_status')!=NULL) ? 1 : 0),
					'system_settings-equipment' => (($this->input->post('system_settings-equipment')!=NULL) ? 1 : 0),
					'system_settings-add_equipment' => (($this->input->post('system_settings-add_equipment')!=NULL) ? 1 : 0),
					'system_settings-edit_equipment' => (($this->input->post('system_settings-edit_equipment')!=NULL) ? 1 : 0),
					'system_settings-delete_equipment' => (($this->input->post('system_settings-delete_equipment')!=NULL) ? 1 : 0),
					'system_settings-equipment_status' => (($this->input->post('system_settings-equipment_status')!=NULL) ? 1 : 0),
					'system_settings-expanse' => (($this->input->post('system_settings-expanse')!=NULL) ? 1 : 0),
					'system_settings-add_expanse' => (($this->input->post('system_settings-add_expanse')!=NULL) ? 1 : 0),
					'system_settings-edit_expanse' => (($this->input->post('system_settings-edit_expanse')!=NULL) ? 1 : 0),
					'system_settings-delete_expanse' => (($this->input->post('system_settings-delete_expanse')!=NULL) ? 1 : 0),
					'system_settings-expanse_status' => (($this->input->post('system_settings-expanse_status')!=NULL) ? 1 : 0),
					'system_settings-occupations' => (($this->input->post('system_settings-occupations')!=NULL) ? 1 : 0),
					'system_settings-add_occupations' => (($this->input->post('system_settings-add_occupations')!=NULL) ? 1 : 0),
					'system_settings-edit_occupations' => (($this->input->post('system_settings-edit_occupations')!=NULL) ? 1 : 0),
					'system_settings-delete_occupations' => (($this->input->post('system_settings-delete_occupations')!=NULL) ? 1 : 0),
					'system_settings-occupations_status' => (($this->input->post('system_settings-occupations_status')!=NULL) ? 1 : 0),
					'system_settings-department' => (($this->input->post('system_settings-department')!=NULL) ? 1 : 0),
					'system_settings-add_department' => (($this->input->post('system_settings-add_department')!=NULL) ? 1 : 0),
					'system_settings-edit_department' => (($this->input->post('system_settings-edit_department')!=NULL) ? 1 : 0),
					'system_settings-delete_department' => (($this->input->post('system_settings-delete_department')!=NULL) ? 1 : 0),
					'system_settings-department_status' => (($this->input->post('system_settings-department_status')!=NULL) ? 1 : 0),
					'system_settings-role' => (($this->input->post('system_settings-role')!=NULL) ? 1 : 0),
					'system_settings-add_role' => (($this->input->post('system_settings-add_role')!=NULL) ? 1 : 0),
					'system_settings-delete_role' => (($this->input->post('system_settings-delete_role')!=NULL) ? 1 : 0),
					'system_settings-role_status' => (($this->input->post('system_settings-role_status')!=NULL) ? 1 : 0),
					'user_id' => $id
				);

				
			} elseif ($this->input->post('app_permission_staff')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("staff/app_permission/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->staff_model->app_permission_staff($id, $data, $web_data, $web_result)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("staff_app_permission_success"));
            admin_redirect("staff/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			
			$this->data['result'] = $result;
			$this->data['app_permission'] = $app_permission;
			$this->data['p'] = $web_result;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('app_permission_staff')));
            $meta = array('page_title' => lang('app_permission'), 'bc' => $bc);
			
            $this->data['id'] = $id;
			 $this->page_construct('staff/app_permission', $meta, $this->data);
        }
    }
	function staff_status($status,$id){		

		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'staff_status');
        $data['active'] = 0;
        if($status=='active'){
            $data['active'] = 1;
        }
        $this->staff_model->update_staff_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	
	function getRoleLocation(){
		$role_id = $this->input->post('role_id');
		$data = $this->staff_model->getRoleLocation($role_id);
		echo json_encode($data);exit;
	}
	
	function getdistrict_byprovince_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$role_id = $this->input->post('role_id');
		
		$province_id = $this->input->post('province_id');
		$location_id = $this->input->post('province_id');
		$group_id = 3;
		if($role_id == 'Province'){
			$checkRole = $this->site->getRole_byuser($department_id, $role_id, $group_id, $location_id);
			
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
		$role_id = $this->input->post('role_id');
		
		$district_id = $this->input->post('district_id');
		
		$group_id = 3;
		if($role_id == 'District'){
			$location = $this->settings_model->getDistrictby_ID($this->input->post('district_id'));
			$location_id = $location->province_id;
			$checkRole = $this->site->getRole_byuser($department_id, $role_id, $group_id, $location_id);
			
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
		$role_id = $this->input->post('role_id');
		
		$commune_id = $this->input->post('commune_id');
		
		$group_id = 3;
		if($role_id == 'Commune'){
			$location = $this->settings_model->getCommuneby_ID($this->input->post('commune_id'));
			$location_id = $location->district_id;
			
			$checkRole = $this->site->getRole_byuser($department_id, $role_id, $group_id, $location_id);
			
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
	
	function getreport_byvillage(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$role_id = $this->input->post('role_id');
		
		$village_id = $this->input->post('village_id');
		
		$group_id = 3;
		if($role_id == 'Village'){
			$location = $this->settings_model->getVillageby_ID($this->input->post('village_id'));
			$location_id = $location->commune_id;
			
			$checkRole = $this->site->getRole_byuser($department_id, $role_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		
		
		echo json_encode($options);exit;
	}
}
