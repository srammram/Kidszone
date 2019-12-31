<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;



class Kidsapi extends REST_Controller {
	
	function __construct() {

		//header('Access-Control-Allow-Origin: *');
		//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		parent::__construct();
		
		$this->load->api_model('kids_api');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		$this->upload_path = 'assets/uploads/';
        $this->image_types = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp';
		$this->allowed_file_size = '9048000';
		
	}
	
	public function demo_post(){
		
		//$this->form_validation->set_rules('photo', $this->lang->line("photo"), 'required');
		
		//if ($this->form_validation->run() == true) {
			$data = array();
		if ($_FILES['photo']['size'] > 0) {
			$config['upload_path'] = $this->upload_path;
			$config['allowed_types'] = $this->image_types;
			$config['overwrite'] = FALSE;
			$config['max_filename'] = 255;
			$config['max_size'] = $this->allowed_file_size;
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('photo')) {
				$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
			}
			$photo = $this->upload->file_name;
			$data['photo'] = $photo;
			$config = NULL;
		}
		echo $_FILES['photo']['size'];
		echo filesize($_FILES['photo']['size']) . ' bytes';  
		print_r($data);
		die;
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		
		$this->response($result);
	}
	
	public function check_exist_staff($string,$token){
		
		if(!empty($string)){
			$column=$token;
			$where = array(
			  $column => $string
			);
			
			$this->db->select('id');
			$this->db->from('users');
			$this->db->where($where);
			//$this->db->where('group_id', 5);
			$q = $this->db->get();
			if($q->num_rows()>0){			
			  return true;
			}else{
				$this->form_validation->set_message('check_exist', 'The %s value is mismatch.');
			  return false;
			  
			}
		 }
	}
	
	
	public function formone_list_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getFormone();
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function formtwo_list_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getFormtwo();
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function formone_get(){
		$form_id = 1;
		$data = $this->site->getFormID($form_id);
		$permission[] = json_decode($data->permission);
		if(!empty($permission)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $permission);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	public function formtwo_get(){
		$form_id = 2;
		$data = $this->site->getFormID($form_id);
		$permission[] = json_decode($data->permission);
		if(!empty($permission)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $permission);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}

	public function farmer_get(){
		$group_id = 3;
		$data = $this->staff_api->getUsers($group_id);
		
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	public function vendor_get(){
		$group_id = 4;
		$data = $this->staff_api->getUsers($group_id);
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	public function staff_get(){
		$group_id = 5;
		$data = $this->staff_api->getUsers($group_id);
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function equipment_get(){
		
		$data = $this->staff_api->getEquipment();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function expanse_get(){
		
		$data = $this->staff_api->getExpanse();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function general_hygine_get(){
		
		$data = $this->staff_api->getGeneral_hygine();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function hygine_get(){
		
		$data = $this->staff_api->getHygine();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function occupations_get(){
		
		$data = $this->staff_api->getOccupations();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function pets_get(){
		
		$data = $this->staff_api->getPets();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	public function source_of_water_get(){
		
		$data = $this->staff_api->getSource_of_water();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	
	
	public function province_get(){
		
		$data = $this->staff_api->getProvince();
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}
		$this->response($result);
	}
	
	
	
	public function substaff_post(){
		$reporter_id = $this->input->post('reporter_id');
		$group_id = 5;
		$this->form_validation->set_rules('reporter_id', $this->lang->line("reporter_id"), 'required');
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getUsers($group_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function district_post(){
		$province_id = $this->input->post('province_id');
		
		$this->form_validation->set_rules('province_id', $this->lang->line("province_id"), 'required');
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getDistrict($province_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function commune_post(){
		$district_id = $this->input->post('district_id');
		
		$this->form_validation->set_rules('district_id', $this->lang->line("district_id"), 'required');
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getCommune($district_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function village_post(){
		$commune_id = $this->input->post('commune_id');
		
		$this->form_validation->set_rules('commune_id', $this->lang->line("commune_id"), 'required');
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getVillage($commune_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
		
	public function pets_type_post(){
		$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('pets_id', $this->lang->line("pets_id"), 'required');
		if ($this->form_validation->run() == true) {
			$data = $this->staff_api->getPets_type($pets_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	

	/**** Kids */

	public function register_post(){

		/*$this->form_validation->set_rules('parent_type', $this->lang->line("parent_type"), 'required');
		$this->form_validation->set_rules('father_name', $this->lang->line("father_name"), 'required');
		$this->form_validation->set_rules('phone_number', $this->lang->line("phone_number"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email"), 'required');*/
		
		//if ($this->form_validation->run() == true) {

				$data = array(
					'parent_type' => $this->input->post('parent_type'),
					'father_name' => $this->input->post('father_name'),
					'mother_name' => $this->input->post('mother_name'),
					'others_name' => $this->input->post('others_name'),
					'phone_number' => $this->input->post('phone_number'),
					'email' => $this->input->post('email'),
					'kid_name1' => $this->input->post('kid_name1'),
					'kid_name2' => $this->input->post('kid_name2'),
					'kid_name3' => $this->input->post('kid_name3'),
					'kid_name4' => $this->input->post('kid_name4'),
					'kid_name5' => $this->input->post('kid_name5'),
					'kid_name6' => $this->input->post('kid_name6'),
					'teacher_name' => $this->input->post('teacher_name'),
					'no_of_kids' => $this->input->post('no_of_kids'),
					'reg_date' => date('Y-m-d H:i:s', strtotime($this->input->post('reg_date'))),
					'accept' => $this->input->post('accept') ? 1 : 0,
					'status' => 1,
					'created_on' => date('Y-m-d H:i:s'),
				);

				if ($_FILES['signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 25;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}

					$photo = $this->upload->file_name;
					$data['signature'] = $photo;
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

				if ($_FILES['photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 25;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
	
					$photo = $this->upload->file_name;
					$data['photo'] = $photo;
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

				$res = $this->kids_api->insertRegister($data);
				if($res == TRUE){
					$result = array( 'status'=> 1, 'message'=> 'Register Success');
				}else{
					$result = array( 'status'=> 0, 'message'=> 'Not Register');
				}
		/*} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}*/
		$this->response($result);

	}

	public function register_post2(){

		$this->form_validation->set_rules('father_name', lang("father_name"), 'required');
		$this->form_validation->set_rules('mother_name', lang("mother_name"), 'required');  
		$this->form_validation->set_rules('phone_number', lang("phone_number"), 'required');  
		$this->form_validation->set_rules('email', lang("email"), 'required');  
		$this->form_validation->set_rules('reg_date', lang("reg_date"), 'required');  
		$this->form_validation->set_rules('accept', lang("accept"), 'required');  
		
		if ($this->form_validation->run() == true) {

            	$data = array(
					'parent_type' => $this->input->post('parent_type'),
					'father_name' => $this->input->post('father_name'),
					'mother_name' => $this->input->post('mother_name'),
					'phone_number' => $this->input->post('phone_number'),
					'email' => $this->input->post('email'),
					'kid_name1' => $this->input->post('kid_name1'),
					'kid_name2' => $this->input->post('kid_name2'),
					'kid_name3' => $this->input->post('kid_name3'),
					'kid_name4' => $this->input->post('kid_name4'),
					'kid_name5' => $this->input->post('kid_name5'),
					'kid_name6' => $this->input->post('kid_name6'),
					'reg_date' => date('Y-m-d H:i:s', strtotime($this->input->post('reg_date'))),
					'accept' => $this->input->post('accept') ? 1 : 0,
					'status' => 1,
					'created_on' => date('Y-m-d H:i:s'),
				);

				$res = $this->kids_api->insertRegister($data);
				if($res == TRUE){
					$result = array( 'status'=> 1, 'message'=> 'Register Success');
				}else{
					$result = array( 'status'=> 0, 'message'=> 'Not Register');
				}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function login_post(){

		$this->form_validation->set_rules('username', $this->lang->line("user name"), 'required');
		$this->form_validation->set_rules('password', $this->lang->line("password"), 'required');
		
		if ($this->form_validation->run() == true) {
			
			$res = $this->kids_api->loginReg($this->input->post('username'), $this->input->post('password'));
		
			
			if($res->status == 1){
				$result = array( 'status'=> 1, 'message'=> 'Login Success', 'data' => $res);
			}elseif($res->status == 2){
				$result = array( 'status'=> 0, 'message'=> 'Email or Phone invaild');			
			}elseif($res->status == 3){
				$result = array( 'status'=> 0, 'message'=> 'Your account has been deactive. please contact admin.');			
			}elseif($res->status == 4){
				$result = array( 'status'=> 0, 'message'=> 'Password invaild');	
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Invalid credientials');
			}
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}

	public function register_list_get(){

		$data = $this->kids_api->getRegisterList();
		
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}

		$this->response($result);
	}


	public function safety_message_get(){

		$data = $this->kids_api->getSafetyMessageList();
		
		if(!empty($data)){
			$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
		}else{
			$result = array( 'status'=> 0, 'message'=> 'Empty data');
		}

		$this->response($result);
	}

	/**** Kids */


	public function forgot_post(){
		$this->load->library('email');
		$this->form_validation->set_rules('email', $this->lang->line("email"), 'required');
		
		if ($this->form_validation->run() == true) {
			
			$res = $this->staff_api->checkForgot($this->input->post('email'), 5);
			
			if($res->status == 1){
				$this->email->from('kannan@srammram.com', 'Srammram Groups');
				$this->email->to($this->input->post('email'));
				$this->email->subject('NBG Forgot');
				$this->email->message('Hi '.$res->first_name.', Your OTP Code: '.$res->forgotten_password_code.'.');
				$this->email->send();
				
				$result = array( 'status'=> 1, 'message'=> 'Forgot Success', 'data' => $res->forgotten_password_code);					
			}elseif($res->status == 2){
				$result = array( 'status'=> 0, 'message'=> 'Your account has been deactive. please contact admin.');			
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Email Invaild');
			}
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function forgototp_post(){
		
		$this->form_validation->set_rules('otp', $this->lang->line("otp"), 'required');
		
		if ($this->form_validation->run() == true) {
			
			$res = $this->staff_api->checkOTP($this->input->post('otp'), 5);
			
			if($res->status == 1){
				$result = array( 'status'=> 1, 'message'=> 'OTP Success', 'data' => $res);					
			}elseif($res->status == 2){
				$result = array( 'status'=> 0, 'message'=> 'Your account has been deactive. please contact admin.');			
			}else{
				$result = array( 'status'=> 0, 'message'=> 'OTP Invaild');
			}
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function resetpassword_post(){
		
		$this->form_validation->set_rules('user_id', $this->lang->line("user_id"), 'required');
		$this->form_validation->set_rules('password', $this->lang->line("password"), 'required');
		
		
		if ($this->form_validation->run() == true) {
			
			$res = $this->staff_api->resetPassword($this->input->post('user_id'), $this->input->post('password'), 5);
			
			if($res->status == 1){
				$result = array( 'status'=> 1, 'message'=> 'Reset Password Success', 'data' => $res);					
			}elseif($res->status == 2){
				$result = array( 'status'=> 0, 'message'=> 'Your account has been deactive. please contact admin.');	
			}elseif($res->status == 3){
				$result = array( 'status'=> 0, 'message'=> 'Same Password. please change different password.');		
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Your account not added. please singup...');
			}
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function formonepets_post(){
		
	 
		$this->form_validation->set_rules('formone_id', lang("formone"), 'required');  
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			
			//$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			
			$res = $this->staff_api->getFormonePetsID($this->input->post('formone_id'));
			
			if(!empty($res)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $res);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Formone Not Added ');
			}
			
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function addformone_post(){
		
		//$this->form_validation->set_rules('phone_number', lang("phone_number"), 'required');  
		$this->form_validation->set_rules('head_of_family', lang("head_of_family"), 'required');  
		//$this->form_validation->set_rules('identification_number', lang("identification_number"), 'required');  
		$this->form_validation->set_rules('head_occupation', lang("head_occupation"), 'required');  
		//$this->form_validation->set_rules('wife_name', lang("wife_name"), 'required');  
		//$this->form_validation->set_rules('wife_identification_number', lang("wife_identification_number"), 'required');  
		//$this->form_validation->set_rules('wife_occupation', lang("wife_occupation"), 'required');  
		$this->form_validation->set_rules('no_of_adult', lang("no_of_adult"), 'required');  
		$this->form_validation->set_rules('no_of_children', lang("no_of_children"), 'required');  
		$this->form_validation->set_rules('province', lang("province"), 'required');  
		$this->form_validation->set_rules('commune', lang("commune"), 'required');  
		$this->form_validation->set_rules('district', lang("district"), 'required');  
		$this->form_validation->set_rules('village', lang("village"), 'required');  
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			
			$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			
			if($this->input->post('farmer_id') == 0){
				$check_phone = $this->staff_api->checkPhone($this->input->post('phone_number'));
				$check_identification_number = $this->staff_api->checkIdentification_number($this->input->post('identification_number'));
			}else{
				$check_phone = 0;
				$check_identification_number = 0;					
			}
			
			if($check_phone == 1){
				$result = array( 'status'=> 0, 'message'=> 'Already exit phone. please change');
			}elseif($check_identification_number == 1){
				$result = array( 'status'=> 0, 'message'=> 'Already exit identification number. please change');
			}else{
				$refer_code = $this->site->refercode('F1');
				$username = $this->site->refercode('SF');
				$oauth_token = get_random_key(32,'users','oauth_token',$type='alnum');
				$mobile_otp = random_string('numeric', 6);
				
				/*$pets = $this->staff_api->getPetsValue();
				foreach($pets as $row){
					
					foreach($_POST['pets_type_value'][$row->id] as $key => $value){
						$pets_array[] = array(
							'pets_id' => $row->id,
							'pets_type_id' => $key,
							'no_of_pets' => $value,
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}*/
				$pets_type_value = json_decode($_POST['pets_type_value']);
				foreach($pets_type_value as $row){
					foreach($row->type as  $res){
						$pets_array[] = array(
							'pets_id' => $row->id,
							'pets_type_id' => $res->id,
							'no_of_pets' => $res->value,
						);
					}
				}
				//print_r($pets_array);
				//print_r($_POST);
				//die;
				
				$data = array(
					'refer_code' => $refer_code,
					'farmer_id' => $this->input->post('farmer_id') ? $this->input->post('farmer_id') : 0,
					'head_of_family' => $this->input->post('head_of_family'),
					'identification_number' => $this->input->post('identification_number'),
					'head_occupation' => $this->input->post('head_occupation'),
					'phone_number' => $this->input->post('phone_number'),
					//'wife_name' => $this->input->post('wife_name'),
					//'wife_identification_number' => $this->input->post('wife_identification_number'),
					//'wife_occupation' => $this->input->post('wife_occupation'),
					'no_of_adult' => $this->input->post('no_of_adult'),
					'no_of_children' => $this->input->post('no_of_children'),
					'total_family_members' => $this->input->post('total_family_members'),
					'province' => $this->input->post('province'),
					'commune' => $this->input->post('commune'),
					'district' => $this->input->post('district'),
					'village' => $this->input->post('village'),
					'need_loan' => $this->input->post('need_loan'),
					'lat' => $this->input->post('lat'),
					'lng' => $this->input->post('lng'),
					'loan_date' => date('d/m/Y'),	
					'survey_date' => date('d-m-Y'),			
					'status' => 1,
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $user_data->user_id,            
				);
				
				if(empty($this->input->post('farmer_id'))){
					$user_data = array(
						'username' => $username,
						'oauth_token' => $oauth_token,
						'password' => md5(123456),
						'phone' => $this->input->post('phone_number'),
						'active' => 1,
						'first_name' => $this->input->post('head_of_family'),
						'group_id' => 3,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),            
					);
					$address_array = array(
						'province' => $this->input->post('province'),
						'district' => $this->input->post('district'),
						'commune' => $this->input->post('commune'),
						'village' => $this->input->post('village'),
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				
				//echo $_FILES['signature']['size'];
				//echo $_FILES['signature']['name'];
				if ($_FILES['signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = FALSE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$signature = $this->upload->file_name;
					$data['signature'] = $signature;
					$config = NULL;
				}
				//echo $_FILES['photo']['size'];
				//echo $_FILES['photo']['name'];
				if ($_FILES['photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = FALSE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$photo = $this->upload->file_name;
					$data['photo'] = $photo;
					$config = NULL;
				}
				//print_r($data);	
				//echo filesize($_FILES['signature']['size']) . ' bytes';  
				//echo filesize($_FILES['photo']['size']) . ' bytes';  die;
				$res = $this->staff_api->insertFormone($data, $pets_array, $user_data, $address_array, $this->input->post('farmer_id'));
				
				if($res == TRUE){
					$result = array( 'status'=> 1, 'message'=> 'Formone Success');
				}else{
					$result = array( 'status'=> 0, 'message'=> 'Formone Not Added ');
				}
			}
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function addformtwo_post(){
		
		//$this->form_validation->set_rules('phone_number', lang("phone_number"), 'required');  
		$this->form_validation->set_rules('head_of_family', lang("head_of_family"), 'required');  
		//$this->form_validation->set_rules('identification_number', lang("identification_number"), 'required');  
		$this->form_validation->set_rules('head_occupation', lang("head_occupation"), 'required');  
		//$this->form_validation->set_rules('wife_name', lang("wife_name"), 'required');  
		//$this->form_validation->set_rules('wife_identification_number', lang("wife_identification_number"), 'required');  
		//$this->form_validation->set_rules('wife_occupation', lang("wife_occupation"), 'required');  
		$this->form_validation->set_rules('no_of_adult', lang("no_of_adult"), 'required');  
		$this->form_validation->set_rules('no_of_children', lang("no_of_children"), 'required');  
		$this->form_validation->set_rules('province', lang("province"), 'required');  
		$this->form_validation->set_rules('commune', lang("commune"), 'required');  
		$this->form_validation->set_rules('district', lang("district"), 'required');  
		$this->form_validation->set_rules('village', lang("village"), 'required');  
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			
				$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
				$refer_code = $this->site->refercode('F2');
				
				$hygine_value = json_decode($_POST['hygine_value']);
				foreach($hygine_value as  $res){
					$hygine_array[] = array(
						'hygine_id' => $res->id,
						'hygine_value' => $res->value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				//print_r($hygine_array);
				//die;
				$source_of_water_value = json_decode($_POST['source_of_water_value']);
				foreach($source_of_water_value as  $res){
					$source_of_water_array[] = array(
						'source_of_water_id' => $res->id,
						'source_of_water_value' => $res->value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				$general_hygine_value = json_decode($_POST['general_hygine_value']);
				foreach($general_hygine_value as  $res){
					$general_hygine_array[] = array(
						'general_hygine_id' => $res->id,
						'general_hygine_value' => $res->value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				
				/*foreach($_POST['hygine_value'] as $key => $value){
					$hygine_array[] = array(
						'hygine_id' => $key,
						'hygine_value' => $value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				foreach($_POST['source_of_water_value'] as $key => $value){
					$source_of_water_array[] = array(
						'source_of_water_id' => $key,
						'source_of_water_value' => $value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}
				foreach($_POST['general_hygine_value'] as $key => $value){
					$general_hygine_array[] = array(
						'general_hygine_id' => $key,
						'general_hygine_value' => $value,
						'created_on' => date('Y-m-d H:i:s')
					);
				}*/
				
				/*$pets = $this->staff_api->getPetsValue();
				foreach($pets as $row){
					
					foreach($_POST['pets_type_value'][$row->id] as $key => $value){
						$pets_array[] = array(
							'pets_id' => $row->id,
							'pets_type_id' => $key,
							'no_of_pets' => $value,
							'created_on' => date('Y-m-d H:i:s')
						);
					}
				}*/
				
				$pets_type_value = json_decode($_POST['pets_type_value']);
				foreach($pets_type_value as $row){
					foreach($row->type as  $res){
						$pets_array[] = array(
							'pets_id' => $row->id,
							'pets_type_id' => $res->id,
							'no_of_pets' => $res->value,
						);
					}
				}
				
				$user = array(
					'occupation' => $this->input->post('head_occupation'),
					'no_of_adult' => $this->input->post('no_of_adult'),
					'no_of_children' => $this->input->post('no_of_children'),
					'total_family_members' => $this->input->post('total_family_members'),
					'wife_name' => $this->input->post('wife_name'),
					'wife_identification_number' => $this->input->post('wife_identification_number'),
					'wife_occupation' => $this->input->post('wife_occupation'),
				);
				
				$formone_data = $this->staff_api->getFormoneData($this->input->post('formone_code'));
				$data = array(
					'refer_code' => $refer_code,
					'farmer_id' => $formone_data !='' ? $formone_data->farmer_id : '',
					'formone_code' => $this->input->post('formone_code'),
					'formone_date' => $formone_data !='' ? $formone_data->loan_date : '',
					//'passport_number' => $this->input->post('passport_number'),
					'head_of_family' => $this->input->post('head_of_family'),
					'identification_number' => $this->input->post('identification_number'),
					'head_occupation' => $this->input->post('head_occupation'),
					'phone_number' => $this->input->post('phone_number'),
					'lat' => $this->input->post('lat'),
					'lng' => $this->input->post('lng'),
					'wife_name' => $this->input->post('wife_name'),
					'wife_identification_number' => $this->input->post('wife_identification_number'),
					'wife_occupation' => $this->input->post('wife_occupation'),
					'daily_amount_of_stool' => $this->input->post('daily_amount_of_stool'),
					'no_of_adult' => $this->input->post('no_of_adult'),
					'no_of_children' => $this->input->post('no_of_children'),
					'total_family_members' => $this->input->post('total_family_members'),
					'province' => $this->input->post('province'),
					'commune' => $this->input->post('commune'),
					'district' => $this->input->post('district'),
					'village' => $this->input->post('village'),
					'underground_water_level_during_dry_season' => $this->input->post('underground_water_level_during_dry_season'),
					'total_land_size' => $this->input->post('total_land_size'),	
					'total_land_size_for_building_oven' => $this->input->post('total_land_size_for_building_oven'),	
					'raining_season' => $this->input->post('raining_season'),	
					'budget_source' => json_encode($this->input->post('budget_source')),	
					'loan_size' => $this->input->post('loan_size'),	
					'currency_type' => $this->input->post('currency_type'),	
					'bank_use' => $this->input->post('bank_use'),	
					'bank_amount' => $this->input->post('bank_amount'),				
					'status' => 1,
					'survey_date' => date('d-m-Y'),
					'loan_date' => date('Y-m-d'),
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $user_data->user_id,            
				);
					
					
				if ($_FILES['signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$signature = $this->upload->file_name;
					$data['signature'] = $signature;
					$config = NULL;
				}
				
				if ($_FILES['photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$photo = $this->upload->file_name;
					$data['photo'] = $photo;
					$config = NULL;
				}
				
				$res = $this->staff_api->insertFormtwo($data, $pets_array, $hygine_array, $source_of_water_array, $general_hygine_array, $formone_data->farmer_id, $user);
				
				if($res == TRUE){
					$result = array( 'status'=> 1, 'message'=> 'Formtwo Success');
				}else{
					$result = array( 'status'=> 0, 'message'=> 'Formtwo Not Added ');
				}
			
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function addformthree_post(){
		
		$this->form_validation->set_rules('phone_number', lang("phone_number"), 'required');  
		$this->form_validation->set_rules('head_of_family', lang("head_of_family"), 'required');  
		$this->form_validation->set_rules('identification_number', lang("identification_number"), 'required');  
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			
				$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
				$refer_code = $this->site->refercode('F3');
				
				/*for($i=0; $i<count($_POST['expanse_id']); $i++){
					$expanse_array[] = array(
						'expanse_id' => $_POST['expanse_id'][$i],
						'expanse_amount' => $_POST['expanse_amount'][$_POST['expanse_id'][$i]],
						'expanse_price_per_unit' => $_POST['expanse_price_per_unit'][$_POST['expanse_id'][$i]],
						'expanse_total' => $_POST['expanse_total'][$_POST['expanse_id'][$i]],
						'created_on' => date('Y-m-d H:i:s'),
					);	
				}*/
				
				$expanse_value = json_decode($_POST['expanse_value']);
				foreach($expanse_value as  $res){
					$expanse_array[] = array(
						'expanse_id' => $res->id,
						'expanse_amount' => $res->amount,
						'expanse_price_per_unit' => $res->price_per_unit,
						'expanse_total' => $res->total_expanse,
						'created_on' => date('Y-m-d H:i:s')
					);
				}

				$formtwo_data = $this->staff_api->getFormtwoData($this->input->post('formtwo_code'));
				
				
				$data = array(
					'refer_code' => $refer_code,
					'formtwo_code' => $this->input->post('formtwo_code'),
					'formtwo_date' => $formtwo_data->survey_date,
					'farmer_id' => $formtwo_data->farmer_id,
					'staff_id' => $formtwo_data->staff_id,
					'head_of_family' => $this->input->post('head_of_family'),
					'identification_number' => $this->input->post('identification_number'),
					'head_occupation' => $this->input->post('head_occupation'),
					'phone_number' => $this->input->post('phone_number'),
					'program_office_name' => $this->input->post('program_office_name'),
					'program_office_address' => $this->input->post('program_office_address'),
					'program_office_phone' => $this->input->post('program_office_phone'),
					'controller_name' => $this->input->post('controller_name'),
					'vendor_id' => $this->input->post('vendor'),
					'builder_name' => $this->input->post('builder_name'),
					'builder_address' => $this->input->post('builder_address'),
					'builder_phone' => $this->input->post('builder_phone'),
					'builder_identification_number' => $this->input->post('builder_identification_number'),
					'costs_expanse' => $this->input->post('working_size_usd'),
					'working_size' => $this->input->post('working_size'),
					'lat' => $this->input->post('lat'),
					'lng' => $this->input->post('lng'),
					'construction_begin_date' => $this->input->post('construction_begin_date'),
					'construction_end_date' => $this->input->post('construction_end_date'),	
					'survey_date' => date('d-m-Y'),
					'provincial_bio_digester_program' => $this->input->post('provincial_bio_digester_program'),
					'address' => $this->input->post('address'),
					'party_a_name' => $this->input->post('party_a_name'),	
					'party_a_surname' => $this->input->post('party_a_surname'),	
					'party_b_name' => $this->input->post('party_b_name'),	
					'party_a_surname' => $this->input->post('party_a_surname'),	
					'party_c_name' => $this->input->post('party_c_name'),	
					'party_c_surname' => $this->input->post('party_c_surname'),
					
					'status' => 1,
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $user_data->user_id,            
				);
					
				if ($_FILES['signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$signature = $this->upload->file_name;
					$data['signature'] = $signature;
					$config = NULL;
				}
				
				if ($_FILES['photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$photo = $this->upload->file_name;
					$data['photo'] = $photo;
					$config = NULL;
				}
				
				if ($_FILES['vendor_signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('vendor_signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$vendor_signature = $this->upload->file_name;
					$data['vendor_signature'] = $vendor_signature;
					$config = NULL;
				}
				
				if ($_FILES['vendor_photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('vendor_photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$vendor_photo = $this->upload->file_name;
					$data['vendor_photo'] = $vendor_photo;
					$config = NULL;
				}
				
				if ($_FILES['farmer_signature']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('farmer_signature')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$farmer_signature = $this->upload->file_name;
					$data['farmer_signature'] = $farmer_signature;
					$config = NULL;
				}
				
				if ($_FILES['farmer_photo']['size'] > 0) {
					$config['upload_path'] = $this->upload_path;
					$config['allowed_types'] = $this->image_types;
					$config['overwrite'] = FALSE;
					$config['max_filename'] = 255;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('farmer_photo')) {
						$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
					}
					$farmer_photo = $this->upload->file_name;
					$data['farmer_photo'] = $farmer_photo;
					$config = NULL;
				}
				
				$res = $this->staff_api->insertFormthree($data, $expanse_array);
				
				if($res == TRUE){
					$result = array( 'status'=> 1, 'message'=> 'Formthree Success');
				}else{
					$result = array( 'status'=> 0, 'message'=> 'Formthree Not Added ');
				}
			
			
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function farmer_verify_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			if($this->input->post('farmer_accept_all') == 0){
				$farmer_accept_data = $this->input->post('farmer_accept_data');
			}else{
				$farmer_accept_data = "";
			}
			$data = array(
				'farmer_verify' => $this->input->post('farmer_verify'),
				'farmer_accept_all' => $this->input->post('farmer_accept_all'),
				'farmer_accept_data' => $farmer_accept_data,
				'farmer_verify_date' => date('d/m/Y')
			);
			if ($_FILES['farmer_signature']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 255;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('farmer_signature')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$farmer_signature = $this->upload->file_name;
				$data['farmer_signature'] = $farmer_signature;
				$config = NULL;
			}
			
			if ($_FILES['farmer_photo']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 255;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('farmer_photo')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$farmer_photo = $this->upload->file_name;
				$data['farmer_photo'] = $farmer_photo;
				$config = NULL;
			}
			//$data = $this->staff_api->getFormthree($user_data->group_id, $user_data->user_id);
			$res = $this->staff_api->formthreeverifyFarmer($data,$this->input->post('formthree_id'), $user_data->user_id);
				
			if($res == TRUE){
				$result = array( 'status'=> 1, 'message'=> 'Formthree Success');
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Formthree Not Update ');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function vendor_verify_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			if($this->input->post('vendor_accept_all') == 0){
				$vendor_accept_data = $this->input->post('vendor_accept_data');
			}else{
				$vendor_accept_data = "";
			}
			$data = array(
				'vendor_verify' => $this->input->post('vendor_verify'),
				'vendor_accept_all' => $this->input->post('vendor_accept_all'),
				'vendor_accept_data' => $vendor_accept_data,
				'vendor_verify_date' => date('d/m/Y')
			);
			if ($_FILES['vendor_signature']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 255;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('vendor_signature')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$farmer_signature = $this->upload->file_name;
				$data['vendor_signature'] = $farmer_signature;
				$config = NULL;
			}
			
			if ($_FILES['vendor_photo']['size'] > 0) {
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = $this->image_types;
				$config['overwrite'] = FALSE;
				$config['max_filename'] = 255;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('vendor_photo')) {
					$result = array( 'status'=> false , 'message'=> 'image not uploaded.');
				}
				$farmer_photo = $this->upload->file_name;
				$data['vendor_photo'] = $farmer_photo;
				$config = NULL;
			}
			//$data = $this->staff_api->getFormthree($user_data->group_id, $user_data->user_id);
			$res = $this->staff_api->formthreeverifyVendor($data,$this->input->post('formthree_id'), $user_data->user_id);
				
			if($res == TRUE){
				$result = array( 'status'=> 1, 'message'=> 'Formthree Success');
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Formthree Not Update ');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function formthree_list_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		
		if ($this->form_validation->run() == true) {
			$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			
			$data = $this->staff_api->getFormthree($user_data->group_id, $user_data->user_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'count' => count($data), 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	public function formthree_view_post(){
		//$pets_id = $this->input->post('pets_id');
		
		$this->form_validation->set_rules('oauth_token', $this->lang->line("oauth_token"), 'required|callback_check_exist_staff[oauth_token]');
		$this->form_validation->set_rules('formthree_id', $this->lang->line("formthree_id"), 'required');
		
		if ($this->form_validation->run() == true) {
			$user_data = $this->staff_api->getUserToken($this->input->post('oauth_token'));
			
			$data = $this->staff_api->getFormthreeview($this->input->post('formthree_id'), $user_data->group_id, $user_data->user_id);
			if(!empty($data)){
				$result = array( 'status'=> 1, 'message'=> 'Success', 'data' => $data);
			}else{
				$result = array( 'status'=> 0, 'message'=> 'Empty data');
			}
		} else {
			$error = $this->form_validation->error_array();
			 foreach($error as $key => $val){
				 $errors[] = $val;
			 }
			 $result = array( 'status'=> 0 , 'message' => $errors[0]);
		}
		$this->response($result);
	}
	
	
}
