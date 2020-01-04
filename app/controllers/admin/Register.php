<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
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
		$this->load->admin_model('register_model');
		$this->load->admin_model('settings_model');
		$this->load->admin_model('db_model');
		$this->data['menu'] = $this->site->menuList();
    }
	
	

    function index($action=false){

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;		

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('register')));
        $meta = array('page_title' => lang('register'), 'bc' => $bc);
		
        $this->page_construct('register/index', $meta, $this->data);
	}
	
    function pdf($action=false){

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;		

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('register')));
        $meta = array('page_title' => lang('register'), 'bc' => $bc);
		
        $this->page_construct('register/pdf', $meta, $this->data);
    }

	
    function getRegister(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
			->select("
			{$this->db->dbprefix('register')}.id as id, 
			{$this->db->dbprefix('register')}.parent_type, 
			{$this->db->dbprefix('register')}.father_name, 
			{$this->db->dbprefix('register')}.mother_name, 
			{$this->db->dbprefix('register')}.others_name, 
			{$this->db->dbprefix('register')}.teacher_name, 
			{$this->db->dbprefix('register')}.phone_number, 
			{$this->db->dbprefix('register')}.email, 
			{$this->db->dbprefix('register')}.kid_name1, 
			{$this->db->dbprefix('register')}.kid_name2, 
			{$this->db->dbprefix('register')}.kid_name3, 
			{$this->db->dbprefix('register')}.kid_name4, 
			{$this->db->dbprefix('register')}.kid_name5, 
			{$this->db->dbprefix('register')}.kid_name6, 			
			{$this->db->dbprefix('register')}.no_of_kids, 
			date_format({$this->db->dbprefix('register')}.created_on,'%d/%m/%Y %T')			
			")
            ->from("register");

			$this->db->order_by("{$this->db->dbprefix('register')}.created_on",'DESC');

			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('register')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('register')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}

			
            //$this->datatables->edit_column('status', '$1__$2', 'id, status');

			//$edit = "<a href='" . admin_url('register/edit_register/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";

			$view = "<a href='" . admin_url('register/view_register/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";			

			/*$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";*/
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
		echo $this->datatables->generate();
		//echo $this->db->last_query();
		
    }
	
	function add_register() {


		/*echo '<pre>';
		print_r($_POST);
		print_r($_FILES);
		die;*/

		//$this->sma->re_direct_url($this->data["link_permission"]->add_farmer);

		$this->site->webPermission($this->session->userdata('user_id'), 'farmer', 'add_farmer');
		$this->form_validation->set_rules('phone', lang("phone"), 'is_unique[users.phone]');
		$this->form_validation->set_rules('identification_number', lang("identification_number"), 'is_unique[users.email]'); 
		 
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
		
        if ($this->form_validation->run() == true) {
			
			
			$oauth_token = get_random_key(32,'users','oauth_token',$type='alnum');
		    $mobile_otp = random_string('numeric', 6);
						
            $data = array(
                'username' => $this->input->post('username'),
				'oauth_token' => $oauth_token,
				'password' => md5($this->input->post('password')),
				'email' => $this->input->post('email'),
				'identification_number' => $this->input->post('identification_number'),
				'active' => 1,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
				'occupation' => $this->input->post('occupation'),
				'wife_name' => $this->input->post('wife_name'),
				'wife_identification_number' => $this->input->post('wife_identification_number'),
				'wife_occupation' => $this->input->post('wife_occupation'),
				'no_of_adult' => $this->input->post('no_of_adult'),
				'no_of_children' => $this->input->post('no_of_children'),
				'total_family_members' => $this->input->post('total_family_members'),
				'gender' => $this->input->post('gender'),
				'group_id' => 3,
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
				//$avatar = $this->upload->file_name;
				//$data['avatar'] = $avatar;
				//$config = NULL;

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

        if ($this->form_validation->run() == true && $this->farmer_model->add_farmer($data, $address_array)){
			
            $this->session->set_flashdata('message', lang("farmer_added"));
            admin_redirect('farmer/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('farmer/index'), 'page' => lang('farmer')), array('link' => '#', 'page' => lang('add_farmer')));
            $meta = array('page_title' => lang('add_farmer'), 'bc' => $bc);
			$this->data['occupations'] = $this->settings_model->getALLOccupations();
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['department'] = $this->site->Alldepartment();
			
            $this->page_construct('register/add', $meta, $this->data);
			
  
        }
    }
	
	function view_register($id){
		

		$result = $this->register_model->getRegisterByID($id);

		$this->data['result'] = $result;
		$this->data['safety_message'] = $this->register_model->getAllSafetyMessage();
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('register/index'), 'page' => lang('register')), array('link' => '#', 'page' => lang('view_register')));
		$meta = array('page_title' => lang('view_register'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('register/view', $meta, $this->data);
        
	}
	
	function pdf_view_register($id){
		

		$result = $this->register_model->getRegisterByID($id);

		$this->data['result'] = $result;
		$this->data['safety_message'] = $this->register_model->getAllSafetyMessage();
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('register/index'), 'page' => lang('register')), array('link' => '#', 'page' => lang('view_register')));
		$meta = array('page_title' => lang('view_register'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('register/view', $meta, $this->data);

		 $this->data['id'] = $id;
		 $html = $this->load->view($this->theme . 'register/view', $this->data, true);
		 //echo $html; die;
		 $name = 'register_'.$result->refer_code.'_' . date('Y_m_d_H_i_s');
		 $this->sma->generate_pdf($html, $name.'.pdf');
        
    }

	
    function edit_farmer($id){

		$this->site->webPermission($this->session->userdata('user_id'), 'farmer', 'edit_farmer');

		$result = $this->farmer_model->getFarmerby_ID($id);
		//$access_result = $this->farmer_model->getFarmer_accessby_ID($id);
		$address_result = $this->farmer_model->getFarmer_addressby_ID($id);
		
		if($this->input->post('edit_farmer')){
		
			$this->form_validation->set_rules('identification_number', lang("identification_number"), 'is_unique[users.email]'); 
		$this->form_validation->set_rules('first_name', lang("first_name"), 'required');  
				
		
        if ($this->form_validation->run() == true) {
			
			$data = array(
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password') ? md5($this->input->post('password')) : $result->password,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'identification_number' => $this->input->post('identification_number'),
				'phone' => $this->input->post('phone'),
				'occupation' => $this->input->post('occupation'),
				'wife_name' => $this->input->post('wife_name'),
				'wife_identification_number' => $this->input->post('wife_identification_number'),
				'wife_occupation' => $this->input->post('wife_occupation'),
				'no_of_adult' => $this->input->post('no_of_adult'),
				'no_of_children' => $this->input->post('no_of_children'),
				'total_family_members' => $this->input->post('total_family_members'),
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
			
			
			} elseif ($this->input->post('edit_farmer')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("farmer/edit_farmer/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->farmer_model->update_farmer($id, $data, $address_array)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("farmer_updated"));
            admin_redirect("farmer/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['occupations'] = $this->settings_model->getALLOccupations();
			$this->data['province'] = $this->settings_model->getALLProvince();
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
			
			$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
			
			$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
			$this->data['department'] = $this->site->Alldepartment();
			$this->data['result'] = $result;
			//$this->data['access_result'] = $access_result;
			$this->data['address_result'] = $address_result;
						
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('farmer/index'), 'page' => lang('farmer')), array('link' => '#', 'page' => lang('edit_farmer')));
            $meta = array('page_title' => lang('edit_farmer'), 'bc' => $bc);
			
            $this->data['id'] = $id;
			 $this->page_construct('farmer/edit', $meta, $this->data);
        }
    }
	function farmer_status($status,$id){

		$this->site->webPermission($this->session->userdata('user_id'), 'farmer', 'farmer_status');

        $data['active'] = 0;
        if($status=='active'){
            $data['active'] = 1;
        }
        $this->farmer_model->update_farmer_status($data,$id);
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
	

    function register_actions()
    {

        if (!$this->Owner && !$this->GP['bulk_actions']) { 
           // $this->session->set_flashdata('warning', lang('access_denied'));
           // redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            /*if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $this->sma->checkPermissions('delete');
                    $error = false;
                    foreach ($_POST['val'] as $id) {
                        if (!$this->companies_model->deleteBiller($id)) {
                            $error = true;
                        }
                    }
                    if ($error) {
                        $this->session->set_flashdata('warning', lang('billers_x_deleted_have_sales'));
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line("billers_deleted"));
                    }
                    redirect($_SERVER["HTTP_REFERER"]);
                }*/

                if ($this->input->post('form_action') == 'export_excel') {$this->sma->checkPermissions('excel');

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setTitle(lang('register'));
					$this->excel->getActiveSheet()->SetCellValue('A1', lang('parent_type'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('father_name'));
					$this->excel->getActiveSheet()->SetCellValue('C1', lang('mother_name'));
					$this->excel->getActiveSheet()->SetCellValue('D1', lang('others_name'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('phone_number'));
					$this->excel->getActiveSheet()->SetCellValue('F1', lang('email'));
					$this->excel->getActiveSheet()->SetCellValue('G1', lang('kid_name1'));
					$this->excel->getActiveSheet()->SetCellValue('H1', lang('kid_name2'));
					$this->excel->getActiveSheet()->SetCellValue('I1', lang('kid_name3'));
					$this->excel->getActiveSheet()->SetCellValue('J1', lang('kid_name4'));
					$this->excel->getActiveSheet()->SetCellValue('K1', lang('kid_name5'));
					$this->excel->getActiveSheet()->SetCellValue('L1', lang('kid_name6'));
					$this->excel->getActiveSheet()->SetCellValue('M1', lang('teacher_name'));
					$this->excel->getActiveSheet()->SetCellValue('N1', lang('no_of_kids'));
					$this->excel->getActiveSheet()->SetCellValue('O1', lang('reg_date'));
					$this->excel->getActiveSheet()->SetCellValue('P1', lang('reg_time'));
					$this->excel->getActiveSheet()->SetCellValue('Q1', lang('accept'));

                    $row = 2;
                    //foreach ($_POST['val'] as $id) {
						$val = $this->register_model->getALLRegisterExcel();
						foreach ($val as $result) 
						{
							if($result->parent_type==1){
								$parent_type = 'Father Name';
							}
							else if($result->parent_type==2){
								$parent_type = 'Mother Name';
							}
							else if($result->parent_type==3){
								$parent_type = 'Others';
							}

							$this->excel->getActiveSheet()->SetCellValue('A' . $row, $parent_type);
							$this->excel->getActiveSheet()->SetCellValue('B' . $row, $result->father_name);
							$this->excel->getActiveSheet()->SetCellValue('C' . $row, $result->mother_name);
							$this->excel->getActiveSheet()->SetCellValue('D' . $row, $result->phone_number);
							$this->excel->getActiveSheet()->SetCellValue('E' . $row, $result->phone_number);
							$this->excel->getActiveSheet()->SetCellValue('F' . $row, $result->email);
							$this->excel->getActiveSheet()->SetCellValue('G' . $row, $result->kid_name1);
							$this->excel->getActiveSheet()->SetCellValue('H' . $row, $result->kid_name2);
							$this->excel->getActiveSheet()->SetCellValue('I' . $row, $result->kid_name3);
							$this->excel->getActiveSheet()->SetCellValue('J' . $row, $result->kid_name4);
							$this->excel->getActiveSheet()->SetCellValue('K' . $row, $result->kid_name5);
							$this->excel->getActiveSheet()->SetCellValue('L' . $row, $result->kid_name6);
							$this->excel->getActiveSheet()->SetCellValue('M' . $row, $result->teacher_name);
							$this->excel->getActiveSheet()->SetCellValue('N' . $row, $result->no_of_kids);
							$this->excel->getActiveSheet()->SetCellValue('O' . $row, date('d-m-Y', strtotime($result->reg_date)));
							$this->excel->getActiveSheet()->SetCellValue('P' . $row, date('h:i', strtotime($result->reg_date)));
							$this->excel->getActiveSheet()->SetCellValue('Q' . $row, ($result->accept==1) ? 'YES': 'NO');

							$row++;
						}
                    //}

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'register_' . date('Y_m_d_H_i_s');
                    $this->load->helper('excel');
                    create_excel($this->excel, $filename);
                }
            /*} else {
                $this->session->set_flashdata('error', $this->lang->line("No Register Selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }*/
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
}
