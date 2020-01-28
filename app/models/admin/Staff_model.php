<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
	
	
	function get_username_old($username) {

		$this->db->select('username')->from('users')->where('username', $username);
		
		$q = $this->db->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0) {
			//return true;
			return json_encode(array(
				'valid' => false,
			));
		}
		else {
			//return false;
			return json_encode(array(
				'valid' => true,
			));
		}

		//return $this->db->last_query();

	}

	function get_username($un, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('username')
			->from('users')
			->where('username', $un);
		}
		else
		{
			$this->db->select('username')
			->from('users')
			->where(array('username = ' => $un,'id!=' => $id));
		}

		$q = $this->db->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0) {
			//return true;
			return json_encode(array(
				'valid' => false,
			));
		}
		else {
			//return false;
			return json_encode(array(
				'valid' => true,
			));
		}

		//return $this->db->last_query();

	}

	
	function add_staff($data){
		
		$this->db->insert('users', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
	}

	function getAppPermission($id){
		$this->db->select('*');
		$this->db->where('user_id', $id);
		$q = $this->db->get('app_permission');
		if($q->num_rows()>0){
			return $q->row();	
		}
		return false;	
	}

	function getWebPermissionByID($id){
		$this->db->select('d.*');
		$this->db->from('web_permissions d');
		$this->db->where('d.user_id',$id);
		$q = $this->db->get();

		//print_r($this->db->last_query()); die;
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }


	function web_permission_staff($id, $web_data){

		$this->db->select('*');
		$this->db->where('user_id', $id);
		$q = $this->db->get('web_permissions');

		if($q->num_rows()>0) {

			$this->db->where('user_id', $id);
			$this->db->update('web_permissions', $web_data);
			return true;

		}else{
			$data['user_id'] = $id;
			$this->db->insert('web_permissions', $web_data);

			return true;
		}
		return false;
    }
	

	function insert_web_permission($data, $result){

		if(empty($result)){

			if($this->db->insert('web_permissions', $data)){
				//print_r($this->db->last_query());
				//die();
				return true;
			}
		}
		else{
			$this->db->where('user_id', $data['user_id']);
			if($this->db->update('web_permissions', $data)){
				//print_r($this->db->last_query());
				//die();
				return true;
			}
		}
		return false;
    }


	function update_staff($id,$data, $address_array, $access_array){
		
		$this->db->delete('user_access', array('user_id' => $id));
		$this->db->delete('user_address', array('user_id' => $id));
		$this->db->where('id',$id);
		if($this->db->update('users',$data)){
			
			$address_array['user_id'] = $id;
			$access_array['user_id'] = $id;
			$this->db->insert('user_access', $access_array);
			$this->db->insert('user_address', $address_array);
	    	return true;
		}
		return false;
    }
	
	function getStaffby_ID($id){
		$this->db->select('d.*');
		$this->db->from('users d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function getStaff_accessby_ID($id){
		$this->db->select('d.*');
		$this->db->from('user_access d');
		$this->db->where('d.user_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function getStaff_addressby_ID($id){
		$this->db->select('d.*');
		$this->db->from('user_address d');
		$this->db->where('d.user_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}
	
	function update_staff_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('users',$data)){
			return true;
		}
		return false;
    }
	
	function getRoleLocation($id){
		$this->db->select('d.*');
		$this->db->from('role d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}

}
