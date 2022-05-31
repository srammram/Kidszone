<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kids_api extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
	
	

	function insertStaff($data, $device_imei){
		$this->db->insert('users', $data);
		if($user_id = $this->db->insert_id()){
			$this->db->insert('user_devices', array('device_imei' => $device_imei, 'user_id' => $user_id));
			return true;
		}
		return false;	
	}
	
	function loginStaff($username, $password, $device_imei){
		
		$row = array();
		$myQuery = "SELECT u.id as user_id, u.oauth_token, u.password, IFNULL(u.email, '') as email, IFNULL(u.first_name, '') as first_name, IFNULL(u.last_name, '') as last_name, IFNULL(u.phone, '') as phone, IFNULL(u.gender, '') as gender, u.active, g.name as group_name, 'status' FROM ".$this->db->dbprefix('users')." AS u LEFT JOIN  ".$this->db->dbprefix('groups')." AS g ON g.id = u.group_id LEFT JOIN  ".$this->db->dbprefix('user_access')." AS ua ON ua.user_id = u.id   WHERE email = '".$username."' OR phone = '".$username."' ";
		
		$q = $this->db->query($myQuery);
		if ($q->num_rows() > 0) {
			$row = $q->row();
			
			if($row->password == md5($password)){
				if($row->active == 1){
					$permission = $this->site->getApp_permission($row->user_id);
					
					$row->status = 1;
					
					$row->formone_enable = $permission->formone_enable;
					$row->formtwo_enable =  $permission->formtwo_enable;
					$row->formthree_enable =  $permission->formthree_enable;

					$row->formone_edit_enable = $permission->formone_edit_enable;
					$row->formtwo_edit_enable =  $permission->formtwo_edit_enable;
					$row->formthree_edit_enable =  $permission->formthree_edit_enable;
			
					$check = $this->db->select('id')->where('user_id', $row->user_id)->get('user_devices');
					if ($check->num_rows() > 0) {
						$this->db->where('user_id', $row->user_id);
						$this->db->update('user_devices', array('device_imei' => $device_imei));
					}else{
						$this->db->insert('user_devices', array('user_id' => $row->user_id, 'device_imei' => $device_imei));
					}
					return $row;	
				}else{
					$row->status = 3;
					return $row;	
				}
			}else{
				$row->status = 4;
				return $row;
			}
		}
		
		return 0;
		
	}
	
	function checkPhone($phone){
		$q = $this->db->select('id')->where('phone', $phone)->where('active', 1)->get('users');
		if($q->num_rows()>0){
			return true;	
		}
		return false;
	}
	
	function checkIdentification_number($identification_number){
		$q = $this->db->select('id')->where('identification_number', $identification_number)->where('active', 1)->get('users');
		if($q->num_rows()>0){
			return true;	
		}
		return false;
	}
	
	function checkEmail($email){
		$q = $this->db->select('id')->where('email', $email)->where('active', 1)->get('users');
		if($q->num_rows()>0){
			return true;	
		}
		return false;
	}
	
	function getUserToken($oauth_token){
		$q = $this->db->select('id as user_id, group_id, oauth_token, IFNULL(email, "") as email, IFNULL(first_name, "") as first_name, IFNULL(last_name, "") as last_name, IFNULL(company, "") as company, IFNULL(phone, "") as phone, IFNULL(gender, "") as gender, IFNULL(identification_number, "") as identification_number')->where('active', 1)->where('oauth_token', $oauth_token)->get('users');
		if($q->num_rows()>0){
			
			return $q->row();	
		}
		return false;
	}
	
	function checkForgot($email, $group_id){
		$row = array();
		$forgotten_password_code = $this->site->forgotcode('FPC', 'users');
		$q  = $this->db->select('id, first_name, email, active')->where('email', $email)->where('group_id', $group_id)->get('users');
		if($q->num_rows()>0){
			$row = $q->row();
			if($row->active == 1){
				$row->status = 1;
				$row->forgotten_password_code = $forgotten_password_code;
				$this->db->update('users', array('forgotten_password_code' => $forgotten_password_code), array('email' => $email, 'group_id' => $group_id));
				return $row;
			}else{
				$row->status = 2;
				return $row;
			}
		}	
		return 0;
	}
	
	function checkOTP($otp, $group_id){
		$row = array();
		$q  = $this->db->select('id, email, active')->where('forgotten_password_code', $otp)->where('group_id', $group_id)->get('users');
		if($q->num_rows()>0){
			$row = $q->row();
			if($row->active == 1){
				$row->status = 1;
				
				$this->db->update('users', array('forgotten_password_code' => '', 'forgotten_active' => 1), array('forgotten_password_code' => $otp, 'group_id' => $group_id));
				return $row;
			}else{
				$row->status = 2;
				return $row;
			}
		}	
		return 0;
	}
	function resetPassword($user_id, $password, $group_id){
		$row = array();
		$q  = $this->db->select("id, oauth_token, password, IFNULL(email, '') as email, IFNULL(first_name, '') as first_name, IFNULL(last_name, '') as last_name, IFNULL(phone, '') as phone, IFNULL(gender, '') as gender, active")->where('id', $user_id)->where('forgotten_active', 1)->where('group_id', $group_id)->get('users');
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			$row = $q->row();
			if($row->active == 1){
				$row->status = 1;
				if($row->password != md5($password)){
					$this->db->update('users', array('password' => md5($password), 'forgotten_active' => 0), array('id' => $user_id, 'forgotten_active' => 1, 'group_id' => $group_id));
					return $row;
				}else{
					$row->status = 3;
					return $row;
				}
			}else{
				$row->status = 2;
				return $row;
			}
		}	
		return 0;
	}
	
	
	
	function getUsers($group_id){
		$q = $this->db->select('u.id as id,  u.oauth_token, IFNULL(u.email, "") as email, IFNULL(u.first_name, "") as first_name, IFNULL(u.last_name, "") as last_name, IFNULL(u.company, "") as company, IFNULL(u.phone, "") as phone, IFNULL(u.gender, "") as gender, IFNULL(u.identification_number, "") as identification_number, IFNULL(CONCAT(v.name,", ", c.name,", ", d.name,", ", p.name), "") as address')->from('users u')->join('user_address ud', 'ud.user_id = u.id', 'left')->join('village v', 'v.id = ud.village', 'left')->join('commune c', 'c.id = ud.commune', 'left')->join('district d', 'd.id = ud.district', 'left')->join('province p', 'p.id = ud.province', 'left')->where('active', 1)->where('group_id', $group_id)->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			
			return $q->result();	
		}
		return false;
	}
	
	
	function getEquipment(){
		$q = $this->db->select('id, name')->where('status', 1)->get('equipment');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	function getExpanse(){
		$q = $this->db->select('id, name')->where('status', 1)->get('expanse');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getGeneral_hygine(){
		$q = $this->db->select('id, name')->where('status', 1)->get('general_hygine');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getHygine(){
		$q = $this->db->select('id, name')->where('status', 1)->get('hygine');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getOccupations(){
		$q = $this->db->select('id, name')->where('status', 1)->get('occupations');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getPetsIDvalue($id){
		$q = $this->db->select('pets_id')->where('id', $id)->get('pets_type');
		if($q->num_rows()>0){
			return $q->row('pets_id');	
		}
		return 0;
	}
	
	function getFormoneData($refer_code){
		$q = $this->db->select('f.*, IFNULL(u.wife_name, "") as wife_name, IFNULL(u.wife_identification_number, "") as wife_identification_number, IFNULL(u.wife_occupation, "") as wife_occupation, ')->from('formone f')->join('users u', 'u.id = f.farmer_id', 'left')->where('refer_code', $refer_code)->get();
		if($q->num_rows()>0){
			return $q->row();	
		}
		return false;
	}
	
	function getFormtwoData($refer_code){
		$q = $this->db->select('*')->where('refer_code', $refer_code)->get('formtwo');
		if($q->num_rows()>0){
			$row = $q->row();
			return $row;	
		}
		return false;
	}
	
	
	function getPetsValue(){
		$q = $this->db->select('id')->where('status', 1)->get('pets');
		if($q->num_rows()>0){
				
			foreach($q->result() as $row){
				//$row->type = $this->getPets_type($row->id);
				
				$data[] = $row;
			}
			return $data;	
		}
		return false;
	}
	
	function getPets(){
		$q = $this->db->select('id, name, "type"')->where('status', 1)->get('pets');
		if($q->num_rows()>0){
				
			foreach($q->result() as $row){
				$row->type = [];
				$row->type = $this->getPets_type($row->id);
				
				if(!empty($row->type)){
					$data[] = $row;
				}
			}
			return $data;	
		}
		return false;
	}
	
	function getFormonePetsID($formone_id){
		$q = $this->db->select('p.id, p.name, "type"')->from('pets p')->join('formone_pets fp', 'fp.formone_id = '.$formone_id.' AND fp.pets_id = p.id', 'left')->where('p.status', 1)->group_by('p.id')->get();
		if($q->num_rows()>0){
				
			foreach($q->result() as $row){
				$row->type = [];
				$pt = $this->db->select('pt.id, pt.name, IFNULL(fp.no_of_pets, "0") as value')->from('pets_type pt')->join('formone_pets fp', 'fp.formone_id = '.$formone_id.' AND fp.pets_type_id = pt.id', 'left')->where('pt.status', 1)->where('pt.pets_id', $row->id)->get();
				if($pt->num_rows()>0){
					$row->type = $pt->result();	
				}
				//$row->type = $this->getPets_type($row->id);
				if(!empty($row->type)){
					$data[] = $row;
				}
			}
			//print_r($data);
			//die;
			return $data;	
		}
		return false;
	}
	
	
	
	function getFormonePets($formone_id){
		$q = $this->db->select('id, pets_id, pets_type_id, no_of_pets')->where('formone_id', $formone_id)->get('formone_pets');
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;	
		}
		return false;
	}
	
	function getFormone(){
		$q = $this->db->select('f.id, f.refer_code, f.farmer_id, f.head_of_family, f.phone_number, f.identification_number, f.head_occupation, 
		f.no_of_adult, f.no_of_children, f.total_family_members, IFNULL(p.name, "") as province, IFNULL(c.name, "") as commune, IFNULL(d.name, "") as district, IFNULL(v.name, "") as village, "pets"')->from('formone f')->join('formtwo t', 't.formone_code = f.refer_code', 'left')->join('village v', 'v.id = f.village', 'left')->join('commune c', 'c.id = f.commune', 'left')->join('district d', 'd.id = f.district', 'left')->join('province p', 'p.id = f.province', 'left')->where('t.id', NULL)->where('f.status', 1)->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				
				$row->pets = $this->getFormonePetsID($row->id);
				
				$data[] = $row;
			}
			return $data;		
		}
		return false;
	}
	
	
	
	function getFormtwo(){
		$q = $this->db->select('f.id, f.refer_code, f.farmer_id, f.formone_code, f.formone_date, f.phone_number,  f.passport_number, f.head_of_family, f.identification_number, f.head_occupation, CONCAT(v.name, " - ", c.name, " - ", d.name, " - ", p.name) as address')->from('formtwo f')->join('formthree t', 't.formtwo_code = f.refer_code', 'left')->join('village v', 'v.id = f.village', 'left')->join('commune c', 'c.id = f.commune', 'left')->join('district d', 'd.id = f.district', 'left')->join('province p', 'p.id = f.province', 'left')->where('t.id', NULL)->where('f.status', 1)->get();
		
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getSource_of_water(){
		$q = $this->db->select('id, name')->where('status', 1)->get('source_of_water');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	
	function getProvince(){
		$q = $this->db->select('id, name')->where('status', 1)->get('province');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getDistrict($province_id){
		$q = $this->db->select('id, name')->where('status', 1)->where('province_id', $province_id)->get('district');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getCommune($district_id){
		$q = $this->db->select('id, name')->where('status', 1)->where('district_id', $district_id)->get('commune');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getVillage($commune_id){
		$q = $this->db->select('id, name')->where('status', 1)->where('commune_id', $commune_id)->get('village');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function getPets_type($pets_id){
		$q = $this->db->select('id, name')->where('status', 1)->where('pets_id', $pets_id)->get('pets_type');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}
	
	function insertFormone($data, $pets_array, $user_data, $address_array, $farmer_id){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$pets_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$pets_array);
		$user_data = array_map(function($v){return (is_null($v)) ? "" : $v;},$user_data);
		$address_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$address_array);
		
		if($farmer_id != 0){
			$data['farmer_id'] = $farmer_id;
			$this->db->insert('formone', $data);//print_r($this->db->last_query());die;
			if($id = $this->db->insert_id()){
				if(!empty($pets_array)){
				foreach($pets_array as $key => $csm)
				 {
				  $pets_array[$key]['formone_id'] = $id;
				 }
				$this->db->insert_batch('formone_pets', $pets_array);
				}
				return true;
			}
		}else{
			
			$this->db->insert('users', $user_data);
			
			if($id = $this->db->insert_id()){
				$address_array['user_id'] = $id;
				$this->db->insert('user_address', $address_array);
				$data['farmer_id'] = $id;
				$this->db->insert('formone', $data);
				if($formone_id = $this->db->insert_id()){
					if(!empty($pets_array)){
					foreach($pets_array as $key => $csm)
					 {
					  $pets_array[$key]['formone_id'] = $formone_id;
					 }
					$this->db->insert_batch('formone_pets', $pets_array);
					
					}
				}
				return true;	
			}
		}
		
		return false;
    }
	
	function insertFormtwo($data, $pets_array, $hygine_array, $source_of_water_array, $general_hygine_array, $farmer_id, $user){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$pets_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$pets_array);
		$hygine_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$hygine_array);
		$source_of_water_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$source_of_water_array);
		$general_hygine_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$general_hygine_array);
		
		
		$this->db->insert('formtwo', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
			if(!empty($pets_array)){
				foreach($pets_array as $key => $csm)
				 {
				  $pets_array[$key]['formtwo_id'] = $id;
				 }
				$this->db->insert_batch('formtwo_pets', $pets_array);
			}
			
			if(!empty($hygine_array)){
				foreach($hygine_array as $key => $csm)
				 {
				  $hygine_array[$key]['formtwo_id'] = $id;
				 }
				$this->db->insert_batch('formtwo_hygine', $hygine_array);
			}
			
			if(!empty($source_of_water_array)){
				foreach($source_of_water_array as $key => $csm)
				 {
				  $source_of_water_array[$key]['formtwo_id'] = $id;
				 }
				$this->db->insert_batch('formtwo_source_of_water', $source_of_water_array);
			}
			
			if(!empty($general_hygine_array)){
				foreach($general_hygine_array as $key => $csm)
				 {
				  $general_hygine_array[$key]['formtwo_id'] = $id;
				 }
				$this->db->insert_batch('formtwo_general_hygine', $general_hygine_array);
			}
			if(!empty($farmer_id)){
				$this->db->where('id', $farmer_id);
				$this->db->update('users', $user);
			}
	    	return true;
		}
		return false;
    }
	
	function insertFormthree($data, $expanse_array){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$expanse_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$expanse_array);
		
		$this->db->insert('formthree', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
			
			
			if(!empty($expanse_array)){
				foreach($expanse_array as $key => $csm)
				 {
				  $expanse_array[$key]['formthree_id'] = $id;
				 }
				$this->db->insert_batch('formthree_expanse', $expanse_array);
			}
			
			
			
	    	return true;
		}
		return false;
    }
	
	function getFormthree($group_id, $user_id){
		$image_url = base_url('assets/uploads/');
		$this->db->select('ft.*, "expanse"');
		$this->db->from('formthree ft');
		
		if($group_id == 3){
			$this->db->where('ft.farmer_id', $user_id);
		}elseif($group_id == 4){
			$this->db->where('ft.vendor_id', $user_id);
		}else{
			$this->db->where('ft.created_by', $user_id);	
		}
		$this->db->where('ft.is_delete', 0);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				
				
				
				$this->db->select('e.expanse_amount as amount, e.id, ex.name, e.expanse_price_per_unit as price_per_unit, e.expanse_total as total_expanse');
				$this->db->from('formthree_expanse e');
				$this->db->join('expanse ex', 'ex.id = e.expanse_id');
				$this->db->where('e.formthree_id', $row->id);
				$e = $this->db->get();
				if($e->num_rows()>0){
					$row->expanse = $e->result();	
				}else{
					$row->expanse = array();
				}
				
				if($row->farmer_signature != ''){
					$row->farmer_signature = $image_url.$row->farmer_signature;
				}else{
					$row->farmer_signature = $image_url.'no_image.jpg';
				}
				if($row->farmer_thumb != ''){
					$row->farmer_thumb = $image_url.$row->farmer_thumb;
				}else{
					$row->farmer_thumb = $image_url.'no_image.jpg';
				}
				if($row->farmer_photo != ''){
					$row->farmer_photo = $image_url.$row->farmer_photo;
				}else{
					$row->farmer_photo = $image_url.'no_image.jpg';
				}
				
				if($row->vendor_signature != ''){
					$row->vendor_signature = $image_url.$row->vendor_signature;
				}else{
					$row->vendor_signature = $image_url.'no_image.jpg';
				}
				if($row->vendor_thumb != ''){
					$row->vendor_thumb = $image_url.$row->vendor_thumb;
				}else{
					$row->vendor_thumb = $image_url.'no_image.jpg';
				}
				if($row->vendor_photo != ''){
					$row->vendor_photo = $image_url.$row->vendor_photo;
				}else{
					$row->vendor_photo = $image_url.'no_image.jpg';
				}
				
				
				if($row->signature != ''){
					$row->signature = $image_url.$row->signature;
				}else{
					$row->signature = $image_url.'no_image.jpg';
				}
				if($row->photo != ''){
					$row->photo = $image_url.$row->photo;
				}else{
					$row->photo = $image_url.'no_image.jpg';
				}
				
				if($group_id == 3){
					if(!empty($row->farmer_accept_data)){
					
					}else{
						$head_of_family_check = "0";
						$identification_number_check = "0";
						$head_occupation_check = "0";
						$phone_number_check = "0";
						$program_office_name_check = "0";
						$program_office_address_check = "0";
						$program_office_phone_check = "0";
						$controller_name_check = "0";
						$builder_name_check = "0";
						$builder_address_check = "0";
						$builder_phone_check = "0";
						$builder_identification_number_check = "0";
						$working_size_check = "0";
						$costs_expanse_check = "0";
						$construction_begin_date_check = "0";
						$construction_end_date_check = "0";
						$farmer_signature_check = "0";
						$farmer_photo_check = "0";
						$i=0;
						foreach($row->expanse as $key => $value){
							$row->expanse[$i]->check = "0";
							$i++;
						}
					}
					$farmer = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'head_of_family_check' => $head_of_family_check,
						'identification_number' => $row->identification_number,
						'identification_number_check' => $identification_number_check,
						'head_occupation' => $row->head_occupation,
						'head_occupation' => $head_occupation_check,
						'phone_number' => $row->phone_number,
						'phone_number_check' => $phone_number_check,
						'program_office_name' => $row->program_office_name,
						'program_office_name_check' => $program_office_name_check,
						'program_office_address' => $row->program_office_address,
						'program_office_address_check' => $program_office_address_check, 
						'program_office_phone' => $row->program_office_phone,
						'program_office_phone_check' => $program_office_phone_check,
						'controller_name' => $row->controller_name,
						'controller_name_check' => $controller_name_check,
						'builder_name' => $row->builder_name, 
						'builder_name_check' => $builder_name_check,
						'builder_address' => $row->builder_address,
						'builder_address_check' => $builder_address_check,
						'builder_phone' => $row->builder_phone,
						'builder_phone_check' => $builder_phone_check,
						'builder_identification_number' => $row->builder_identification_number,
						'builder_identification_number_check' => $builder_identification_number_check,
						'working_size' => $row->working_size,
						'working_size_check' => $working_size_check,
						'costs_expanse' => $row->costs_expanse,
						'costs_expanse_check' => $costs_expanse_check,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_begin_date_check' => $construction_begin_date_check,
						'construction_end_date' => $row->construction_end_date,
						'construction_end_date_check' => $construction_end_date_check,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_signature_check' => $farmer_signature_check,
						'farmer_photo' => $row->farmer_photo,
						'farmer_photo_check' => $farmer_photo_check,
						'vendor_signature' => $row->vendor_signature,
						'vendor_photo' => $row->vendor_photo,
						'farmer_verify' => $row->farmer_verify,
						'farmer_accept_data' => $row->farmer_accept_data,
						'farmer_accept_all' => $row->farmer_accept_all,
						'expanse' => $row->expanse
					);	
					$data[] = $farmer;
				}elseif($group_id == 4){
					if(!empty($row->farmer_accept_data)){
					
					}else{
						$head_of_family_check = "0";
						$identification_number_check = "0";
						$head_occupation_check = "0";
						$phone_number_check = "0";
						$program_office_name_check = "0";
						$program_office_address_check = "0";
						$program_office_phone_check = "0";
						$controller_name_check = "0";
						$builder_name_check = "0";
						$builder_address_check = "0";
						$builder_phone_check = "0";
						$builder_identification_number_check = "0";
						$working_size_check = "0";
						$costs_expanse_check = "0";
						$construction_begin_date_check = "0";
						$construction_end_date_check = "0";
						$vendor_signature_check = "0";
						$vendor_photo_check = "0";
						$j=0;
						foreach($row->expanse as $key => $value){
							$row->expanse[$j]->check = "0";
							$j++;
						}
					}
					$vendor = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'head_of_family_check' => $head_of_family_check,
						'identification_number' => $row->identification_number,
						'identification_number_check' => $identification_number_check,
						'head_occupation' => $row->head_occupation,
						'head_occupation' => $head_occupation_check,
						'phone_number' => $row->phone_number,
						'phone_number_check' => $phone_number_check,
						'program_office_name' => $row->program_office_name,
						'program_office_name_check' => $program_office_name_check,
						'program_office_address' => $row->program_office_address,
						'program_office_address_check' => $program_office_address_check, 
						'program_office_phone' => $row->program_office_phone,
						'program_office_phone_check' => $program_office_phone_check,
						'controller_name' => $row->controller_name,
						'controller_name_check' => $controller_name_check,
						'builder_name' => $row->builder_name, 
						'builder_name_check' => $builder_name_check,
						'builder_address' => $row->builder_address,
						'builder_address_check' => $builder_address_check,
						'builder_phone' => $row->builder_phone,
						'builder_phone_check' => $builder_phone_check,
						'builder_identification_number' => $row->builder_identification_number,
						'builder_identification_number_check' => $builder_identification_number_check,
						'working_size' => $row->working_size,
						'working_size_check' => $working_size_check,
						'costs_expanse' => $row->costs_expanse,
						'costs_expanse_check' => $costs_expanse_check,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_begin_date_check' => $construction_begin_date_check,
						'construction_end_date' => $row->construction_end_date,
						'construction_end_date_check' => $construction_end_date_check,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_photo' => $row->farmer_photo,
						'vendor_signature' => $row->vendor_signature,
						'vendor_signature_check' => $vendor_signature_check,
						'vendor_photo' => $row->vendor_photo,
						'vendor_photo_check' => $vendor_photo_check,
						'vendor_verify' => $row->vendor_verify,
						'vendor_accept_all' => $row->vendor_accept_all,
						'vendor_accept_data' => $row->vendor_accept_data,
						'expanse' => $row->expanse
					);	
					$data[] = $vendor;
				}else{
					
					$staff = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'identification_number' => $row->identification_number,
						'head_occupation' => $row->head_occupation,
						'phone_number' => $row->phone_number,
						'program_office_name' => $row->program_office_name,
						'program_office_address' => $row->program_office_address,
						'program_office_phone' => $row->program_office_phone,
						'controller_name' => $row->controller_name,
						'builder_name' => $row->builder_name, 
						'builder_address' => $row->builder_address,
						'builder_phone' => $row->builder_phone,
						'builder_identification_number' => $row->builder_identification_number,
						'working_size' => $row->working_size,
						'costs_expanse' => $row->costs_expanse,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_end_date' => $row->construction_end_date,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_photo' => $row->farmer_photo,
						'vendor_signature' => $row->vendor_signature,
						'vendor_photo' => $row->vendor_photo,
						'vendor_verify' => $row->vendor_verify,
						'vendor_accept_all' => $row->vendor_accept_all,
						'vendor_accept_data' => $row->vendor_accept_data,
						'farmer_verify' => $row->farmer_verify,
						'farmer_accept_data' => $row->farmer_accept_data,
						'farmer_accept_all' => $row->farmer_accept_all,
						'expanse' => $row->expanse
					);	
					$data[] = $staff;
				}
				
			}
			return $data;	
		}
		return false;
	}
	
	function getFormthreeview($formthree_id, $group_id, $user_id){
		$image_url = base_url('assets/uploads/');
		$this->db->select('ft.*, "expanse"');
		$this->db->from('formthree ft');
		
		if($group_id == 3){
			$this->db->where('ft.farmer_id', $user_id);
		}elseif($group_id == 4){
			$this->db->where('ft.vendor_id', $user_id);
		}else{
			$this->db->where('ft.created_by', $user_id);	
		}
		$this->db->where('ft.is_delete', 0);
		$this->db->where('ft.id', $formthree_id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			$row = $q->row();
			//foreach($q->result() as $row){
				
				
				
				$this->db->select('e.expanse_amount as amount, e.id, ex.name, e.expanse_price_per_unit as price_per_unit, e.expanse_total as total_expanse');
				$this->db->from('formthree_expanse e');
				$this->db->join('expanse ex', 'ex.id = e.expanse_id');
				$this->db->where('e.formthree_id', $row->id);
				$e = $this->db->get();
				if($e->num_rows()>0){
					$row->expanse = $e->result();	
				}else{
					$row->expanse = array();
				}
				
				if($row->farmer_signature != ''){
					$row->farmer_signature = $image_url.$row->farmer_signature;
				}else{
					$row->farmer_signature = $image_url.'no_image.jpg';
				}
				if($row->farmer_thumb != ''){
					$row->farmer_thumb = $image_url.$row->farmer_thumb;
				}else{
					$row->farmer_thumb = $image_url.'no_image.jpg';
				}
				if($row->farmer_photo != ''){
					$row->farmer_photo = $image_url.$row->farmer_photo;
				}else{
					$row->farmer_photo = $image_url.'no_image.jpg';
				}
				
				if($row->vendor_signature != ''){
					$row->vendor_signature = $image_url.$row->vendor_signature;
				}else{
					$row->vendor_signature = $image_url.'no_image.jpg';
				}
				if($row->vendor_thumb != ''){
					$row->vendor_thumb = $image_url.$row->vendor_thumb;
				}else{
					$row->vendor_thumb = $image_url.'no_image.jpg';
				}
				if($row->vendor_photo != ''){
					$row->vendor_photo = $image_url.$row->vendor_photo;
				}else{
					$row->vendor_photo = $image_url.'no_image.jpg';
				}
				
				
				if($row->signature != ''){
					$row->signature = $image_url.$row->signature;
				}else{
					$row->signature = $image_url.'no_image.jpg';
				}
				if($row->photo != ''){
					$row->photo = $image_url.$row->photo;
				}else{
					$row->photo = $image_url.'no_image.jpg';
				}
				
				if($group_id == 3){
					if(!empty($row->farmer_accept_data)){
					
					}else{
						$head_of_family_check = "0";
						$identification_number_check = "0";
						$head_occupation_check = "0";
						$phone_number_check = "0";
						$program_office_name_check = "0";
						$program_office_address_check = "0";
						$program_office_phone_check = "0";
						$controller_name_check = "0";
						$builder_name_check = "0";
						$builder_address_check = "0";
						$builder_phone_check = "0";
						$builder_identification_number_check = "0";
						$working_size_check = "0";
						$costs_expanse_check = "0";
						$construction_begin_date_check = "0";
						$construction_end_date_check = "0";
						$farmer_signature_check = "0";
						$farmer_photo_check = "0";
						
						$address_check = "0";
						$party_a_name_check = "0";
						$party_a_surname_check = "0";
						$party_b_name_check = "0";
						$party_b_surname_check = "0";
						$party_c_name_check = "0";
						$party_c_surname_check = "0";
						
						$i=0;
						foreach($row->expanse as $key => $value){
							$row->expanse[$i]->check = "0";
							$i++;
						}
					}
					$farmer = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'head_of_family_check' => $head_of_family_check,
						'identification_number' => $row->identification_number,
						'identification_number_check' => $identification_number_check,
						'head_occupation' => $row->head_occupation,
						'head_occupation' => $head_occupation_check,
						'phone_number' => $row->phone_number,
						'phone_number_check' => $phone_number_check,
						'address' => $row->address,
						'address_check' => $address_check,
						
						'program_office_name' => $row->program_office_name,
						'program_office_name_check' => $program_office_name_check,
						'program_office_address' => $row->program_office_address,
						'program_office_address_check' => $program_office_address_check, 
						'program_office_phone' => $row->program_office_phone,
						'program_office_phone_check' => $program_office_phone_check,
						'controller_name' => $row->controller_name,
						'controller_name_check' => $controller_name_check,
						'builder_name' => $row->builder_name, 
						'builder_name_check' => $builder_name_check,
						'builder_address' => $row->builder_address,
						'builder_address_check' => $builder_address_check,
						'builder_phone' => $row->builder_phone,
						'builder_phone_check' => $builder_phone_check,
						'builder_identification_number' => $row->builder_identification_number,
						'builder_identification_number_check' => $builder_identification_number_check,
						'working_size' => $row->working_size,
						'working_size_check' => $working_size_check,
						'costs_expanse' => $row->costs_expanse,
						'costs_expanse_check' => $costs_expanse_check,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_begin_date_check' => $construction_begin_date_check,
						'construction_end_date' => $row->construction_end_date,
						'construction_end_date_check' => $construction_end_date_check,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_signature_check' => $farmer_signature_check,
						'farmer_photo' => $row->farmer_photo,
						'farmer_photo_check' => $farmer_photo_check,
						'vendor_signature' => $row->vendor_signature,
						'vendor_photo' => $row->vendor_photo,
						'farmer_verify' => $row->farmer_verify,
						'farmer_accept_data' => $row->farmer_accept_data,
						'farmer_accept_all' => $row->farmer_accept_all,
						'expanse' => $row->expanse,
						
						'party_a_name' => $row->party_a_name,
						'party_a_name_check' => $party_a_name_check,
						'party_a_surname' => $row->party_a_surname,
						'party_a_surname_check' => $party_a_surname_check,
						
						'party_b_name' => $row->party_b_name,
						'party_b_name_check' => $party_b_name_check,
						'party_b_surname' => $row->party_b_surname,
						'party_b_surname_check' => $party_b_surname_check,
						
						'party_c_name' => $row->party_c_name,
						'party_c_name_check' => $party_c_name_check,
						'party_c_surname' => $row->party_c_surname,
						'party_c_surname_check' => $party_c_surname_check,
						
					);	
					$data[] = $farmer;
				}elseif($group_id == 4){
					if(!empty($row->farmer_accept_data)){
					
					}else{
						$head_of_family_check = "0";
						$identification_number_check = "0";
						$head_occupation_check = "0";
						$phone_number_check = "0";
						$program_office_name_check = "0";
						$program_office_address_check = "0";
						$program_office_phone_check = "0";
						$controller_name_check = "0";
						$builder_name_check = "0";
						$builder_address_check = "0";
						$builder_phone_check = "0";
						$builder_identification_number_check = "0";
						$working_size_check = "0";
						$costs_expanse_check = "0";
						$construction_begin_date_check = "0";
						$construction_end_date_check = "0";
						$vendor_signature_check = "0";
						$vendor_photo_check = "0";
						
						$address_check = "0";
						$party_a_name_check = "0";
						$party_a_surname_check = "0";
						$party_b_name_check = "0";
						$party_b_surname_check = "0";
						$party_c_name_check = "0";
						$party_c_surname_check = "0";
						
						$j=0;
						foreach($row->expanse as $key => $value){
							$row->expanse[$j]->check = "0";
							$j++;
						}
					}
					$vendor = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'head_of_family_check' => $head_of_family_check,
						'identification_number' => $row->identification_number,
						'identification_number_check' => $identification_number_check,
						'head_occupation' => $row->head_occupation,
						'head_occupation' => $head_occupation_check,
						'phone_number' => $row->phone_number,
						'phone_number_check' => $phone_number_check,
						'address' => $row->address,
						'address_check' => $address_check,
						
						'program_office_name' => $row->program_office_name,
						'program_office_name_check' => $program_office_name_check,
						'program_office_address' => $row->program_office_address,
						'program_office_address_check' => $program_office_address_check, 
						'program_office_phone' => $row->program_office_phone,
						'program_office_phone_check' => $program_office_phone_check,
						'controller_name' => $row->controller_name,
						'controller_name_check' => $controller_name_check,
						'builder_name' => $row->builder_name, 
						'builder_name_check' => $builder_name_check,
						'builder_address' => $row->builder_address,
						'builder_address_check' => $builder_address_check,
						'builder_phone' => $row->builder_phone,
						'builder_phone_check' => $builder_phone_check,
						'builder_identification_number' => $row->builder_identification_number,
						'builder_identification_number_check' => $builder_identification_number_check,

						'working_size' => $row->working_size,
						'working_size_check' => $working_size_check,
						'costs_expanse' => $row->costs_expanse,
						'costs_expanse_check' => $costs_expanse_check,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_begin_date_check' => $construction_begin_date_check,
						'construction_end_date' => $row->construction_end_date,
						'construction_end_date_check' => $construction_end_date_check,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_photo' => $row->farmer_photo,
						'vendor_signature' => $row->vendor_signature,
						'vendor_signature_check' => $vendor_signature_check,
						'vendor_photo' => $row->vendor_photo,
						'vendor_photo_check' => $vendor_photo_check,
						'vendor_verify' => $row->vendor_verify,
						'vendor_accept_all' => $row->vendor_accept_all,
						'vendor_accept_data' => $row->vendor_accept_data,
						
						'party_a_name' => $row->party_a_name,
						'party_a_name_check' => $party_a_name_check,
						'party_a_surname' => $row->party_a_surname,
						'party_a_surname_check' => $party_a_surname_check,
						
						'party_b_name' => $row->party_b_name,
						'party_b_name_check' => $party_b_name_check,
						'party_b_surname' => $row->party_b_surname,
						'party_b_surname_check' => $party_b_surname_check,
						
						'party_c_name' => $row->party_c_name,
						'party_c_name_check' => $party_c_name_check,
						'party_c_surname' => $row->party_c_surname,
						'party_c_surname_check' => $party_c_surname_check,
						
						
						'expanse' => $row->expanse
					);	
					$data[] = $vendor;
				}else{
					
					$staff = array(
						'formthree_id' => $row->id,
						'head_of_family' => $row->head_of_family,
						'identification_number' => $row->identification_number,
						'head_occupation' => $row->head_occupation,
						'phone_number' => $row->phone_number,
						'program_office_name' => $row->program_office_name,
						'program_office_address' => $row->program_office_address,
						'program_office_phone' => $row->program_office_phone,
						'controller_name' => $row->controller_name,
						'builder_name' => $row->builder_name, 
						'builder_address' => $row->builder_address,
						'builder_phone' => $row->builder_phone,
						'builder_identification_number' => $row->builder_identification_number,
						'working_size' => $row->working_size,
						'costs_expanse' => $row->costs_expanse,
						'construction_begin_date' => $row->construction_begin_date,
						'construction_end_date' => $row->construction_end_date,
						'photo' => $row->photo,
						'signature' => $row->signature,
						'farmer_signature' => $row->farmer_signature,
						'farmer_photo' => $row->farmer_photo,
						'vendor_signature' => $row->vendor_signature,
						'vendor_photo' => $row->vendor_photo,
						'vendor_verify' => $row->vendor_verify,
						'vendor_accept_all' => $row->vendor_accept_all,
						'vendor_accept_data' => $row->vendor_accept_data,
						'farmer_verify' => $row->farmer_verify,
						'farmer_accept_data' => $row->farmer_accept_data,
						'farmer_accept_all' => $row->farmer_accept_all,
						'expanse' => $row->expanse
					);	
					$data[] = $staff;
				}
				
			//}
			return $data;	
		}
		return false;
	}
	
	function formthreeverifyFarmer($data, $formthree_id, $user_id){
		$this->db->where('farmer_id', $user_id);
		$this->db->where('id', $formthree_id);
		$q = $this->db->update('formthree', $data);
		if($q){
			return true;
		}
		return false;
	}
	
	function formthreeverifyVendor($data, $formthree_id, $user_id){
		$this->db->where('vendor_id', $user_id);
		$this->db->where('id', $formthree_id);
		$q = $this->db->update('formthree', $data);
		if($q){
			return true;
		}
		return false;
	}
	

	// Kids

	function getRegisterList(){

		$q = $this->db->select('*')->get('register');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}

	function getSafetyMessageList1(){

		$q = $this->db->select('*')->get('safety_message');
		if($q->num_rows()>0){
			return $q->result();	
		}
		return false;
	}


	/*function getSafetyMessageList() {

		$q = $this->db->select('*')->group_by('lang')->get('safety_message');

		foreach($q->result() as $k => $row) {

			$abc = $this->db->select('*')->where('lang', $row->lang)->get('safety_message');

			//$data['lang'] = $row->lang;

			foreach($abc->result() as $row1) {

				$data[$row->lang][] = array(
					'title' => $row1->title,
					'desc_msg' => $row1->desc_msg
				);

			}
		}

		if($data) {
			return $data;
		}

		return false;
	}*/

	function getSafetyMessageList($lang) {

		if($lang=="en")
		{
			$lang = 1;
		}
		else if($lang=="km"){
			$lang = 2;
		}

		$q = $this->db->select('*')->where('lang', $lang)->get('safety_message');

		foreach($q->result() as $row) {

			$data[] = array(
				'title' => $row->title,
				'desc_msg' => $row->desc_msg
			);

		}

		if($data) {
			return $data;
		}
//print_r($this->db->last_query());
		return false;
	}



	function getAgeList($lang) {

		$q = $this->db->select('*')->where('status', 1)->where('is_delete', 0)->get('age');

		foreach($q->result() as $row) {

			$data[] = array(
				'id' => $row->id,
				'name' => $lang=="en" ? $row->name : $row->khmer_name
			);

		}

		if($data) {
			return $data;
		}
//print_r($this->db->last_query());
		return false;
	}

	function getOthersList($lang) {

		$q = $this->db->select('*')->where('status', 1)->where('is_delete', 0)->get('others');

		foreach($q->result() as $row) {

			$data[] = array(
				'id' => $row->id,
				'name' => $lang=="en" ? $row->name : $row->khmer_name
			);

		}

		if($data) {
			return $data;
		}
//print_r($this->db->last_query());
		return false;
	}

	function getNationalityList($lang) {

		$q = $this->db->select('*')->where('status', 1)->where('is_delete', 0)->order_by('sort', 'ASC')->get('nationality');

		foreach($q->result() as $row) {

			$data[] = array(
				'id' => $row->id,
				'name' => $lang=="en" ? $row->name : $row->khmer_name
			);

		}

		if($data) {
			return $data;
		}
//print_r($this->db->last_query());
		return false;
	}


	function insertRegister($data){

		//$this->db->insert('register', $data);
		//$this->db->last_query(); die;

		//if ( ! $this->db->insert('register', $data)) {
			//$error = $this->db->error(); // Has keys 'code' and 'message'
		//}

		//echo '<pre>';
		//print_r($error);
		//echo '<pre>';
		//print_r($data);
		//die;
		if($this->db->insert('register', $data)){
			return true;
		}
		return false;	
	}

	function loginReg($username, $password){
		
		$row = array();
		$myQuery = "SELECT * FROM ".$this->db->dbprefix('users')." WHERE username = '".$username."' ";
		
		$q = $this->db->query($myQuery);
		if ($q->num_rows() > 0) {
			$row = $q->row();
			
			if($row->password == md5($password)){
				if($row->active == 1){

					$row->status = 1;					

					return $row;	
				}else{
					$row->status = 3;
					return $row;	
				}
			}else{
				$row->status = 4;
				return $row;
			}
		}
		
		return 0;
		
	}


	function getOutLet($lat, $lng, $device_ip){

		// 3959 in meters is 6371393

		if(!empty($device_ip)){
			//$where = 'WHERE device_ip = "'.$device_ip.'"';
		}

		$query = $this->db->query('SELECT
		id, (
			6371393 * acos (
			cos ( radians('.$lat.') )
			* cos( radians( lat ) )
			* cos( radians( lng ) - radians('.$lng.') )
			+ sin ( radians('.$lat.') )
			* sin( radians( lat ) )
		  )
		) AS distance 
	  	FROM kidzooona_outlet '.$where.'
	  	HAVING distance < 500 
	  	ORDER BY distance 
	  	LIMIT 0 , 1');

		//print_r($this->db->last_query()); die;

		$row = $query->row();

		if (isset($row)) {

			return $row->id;
		}
		return false;
	}
	
	public function checkApiKeys($api_key, $devices_key){

		$q = $this->db->get_where('api_keys', array('reference_key' => $api_key), 1);

        if ($q->num_rows() == 1) {

			if(empty($q->row('devices_key'))){

				$this->db->where('reference_key', $api_key);
				$this->db->update('api_keys', array('devices_key' => $devices_key));
			}

			$w = $this->db->get_where('api_keys', array('reference_key' => $api_key), 1);
			if ($w->num_rows() == 1) {
				
				$result = array(
							'devices_key' => $w->row('devices_key'),
							'status' => $w->row('status')
				);
			}

            return $result;
        }
		return FALSE;
	}
	
	
	public function checkApiKeyReg($api_key){

		$q = $this->db->get_where('api_keys', array('reference_key' => $api_key), 1);

        if ($q->num_rows()>0) {
            return true;
        }
		return FALSE;
	}
	
}
