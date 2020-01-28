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
            ->select("{$this->db->dbprefix('users')}.id as id, {$this->db->dbprefix('users')}.username as username, {$this->db->dbprefix('users')}.first_name, {$this->db->dbprefix('users')}.last_name, {$this->db->dbprefix('users')}.phone, {$this->db->dbprefix('users')}.email, {$this->db->dbprefix('users')}.active as status")
            ->from("users");

			$this->datatables->where("{$this->db->dbprefix('users')}.group_id", 2);

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
		$id = $this->input->post('id');
		$data = $this->staff_model->get_username($username, $id);

		echo $data;
	}

	
	function add_staff(){

		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'add_staff');

		$this->form_validation->set_rules('phone', lang("phone"), 'is_unique[users.phone]');
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required'); 
		
        if ($this->form_validation->run() == true) {

            $data = array(
                'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'email' => $this->input->post('email'),
				'active' => 1,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'group_id' => 2,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);

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

			//print_r($access_array);die;
        }
		
		
        if ($this->form_validation->run() == true && $this->staff_model->add_staff($data)){
			
            $this->session->set_flashdata('message', lang("staff_added"));
            admin_redirect('staff/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('add_staff')));
            $meta = array('page_title' => lang('add_staff'), 'bc' => $bc);
			
            $this->page_construct('staff/add', $meta, $this->data);			
  
        }
    }
	
	function view_staff($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'view_staff');
		$result = $this->staff_model->getStaffby_ID($id);

		$this->data['result'] = $result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('view_staff')));
		$meta = array('page_title' => lang('view_staff'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('staff/view', $meta, $this->data);
        
    }
	
    function edit_staff($id){

		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'edit_staff');

		$result = $this->staff_model->getStaffby_ID($id);
		//print_r($result);
		//die;

		if($this->input->post('edit_staff')){		

		$this->form_validation->set_rules('username', lang("username"), 'required');				

        if ($this->form_validation->run() == true) {

			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password') ? md5($this->input->post('password')) : $result->password,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'gender' => $this->input->post('gender'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
			);

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
			
			} elseif ($this->input->post('edit_staff')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("staff/edit_staff/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->staff_model->update_staff($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("staff_updated"));
            admin_redirect("staff/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));		

			//print_r($this->data['reporter']);die;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('edit_staff')));
			
            $meta = array('page_title' => lang('edit_staff'), 'bc' => $bc);
			$this->data['result'] = $result;
            $this->data['id'] = $id;
			$this->page_construct('staff/edit', $meta, $this->data);
        }
	}
	
	function app_permission_staff($id) {

		$this->site->webPermission($this->session->userdata('user_id'), 'staff', 'app_permission_staff');
		//$result = $this->staff_model->getStaffby_ID($id);
		//$app_permission = $this->staff_model->getAppPermission($id);
		$web_result = $this->staff_model->getWebPermissionByID($id);		

		if($this->input->post('app_permission_staff')) {

		$this->form_validation->set_rules('user_id', lang("user_id"), 'required');

        if ($this->form_validation->run() == true) {

				$web_data= array(
					'register-index' => (($this->input->post('register-index')!=NULL) ? 1 : 0),
					'register-view_register' => (($this->input->post('register-view_register')!=NULL) ? 1 : 0),
					'register-pdf_view_register' => (($this->input->post('register-pdf_view_register')!=NULL) ? 1 : 0),
					'register-index_pdf' => (($this->input->post('register-index_pdf')!=NULL) ? 1 : 0),
					'register-index_excel' => (($this->input->post('register-index_excel')!=NULL) ? 1 : 0),
					'safety-index' => (($this->input->post('safety-index')!=NULL) ? 1 : 0),
					'safety-safety_edit' => (($this->input->post('safety-safety_edit')!=NULL) ? 1 : 0),
					'staff-index' => (($this->input->post('staff-index')!=NULL) ? 1 : 0),
					'staff-add_staff' => (($this->input->post('staff-add_staff')!=NULL) ? 1 : 0),
					'staff-edit_staff' => (($this->input->post('staff-edit_staff')!=NULL) ? 1 : 0),
					'staff-view_staff' => (($this->input->post('staff-view_staff')!=NULL) ? 1 : 0),
					'staff-delete' => (($this->input->post('staff-delete')!=NULL) ? 1 : 0),
					'staff-staff_status' => (($this->input->post('staff-staff_status')!=NULL) ? 1 : 0),
					'staff-app_permission_staff' => (($this->input->post('staff-app_permission_staff')!=NULL) ? 1 : 0),
					'user_id' => $id
				);

				
			} elseif ($this->input->post('app_permission_staff')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("staff/app_permission/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->staff_model->web_permission_staff($id, $web_data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("staff_app_permission_success"));
            admin_redirect("staff/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			
			//$this->data['result'] = $result;
			//$this->data['app_permission'] = $app_permission;
			$this->data['p'] = $web_result;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('staff/index'), 'page' => lang('staff')), array('link' => '#', 'page' => lang('web_permission')));
            $meta = array('page_title' => lang('web_permission'), 'bc' => $bc);
			
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
