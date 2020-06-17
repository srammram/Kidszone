<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function add_farmer($data, $address_array){
		
		$this->db->insert('users', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
			$address_array['user_id'] = $id;
			//$access_array['user_id'] = $id;
			//$this->db->insert('user_access', $access_array);
			$this->db->insert('user_address', $address_array);
	    	return true;
		}
		return false;
    }
	//function addsm($data1 ){
		
		//$this->db->insert('sm1', $data1);//print_r($this->db->last_query());die;
       
		//return false;
    //}
	
	function update_farmer($id,$data, $address_array){		

		//$this->db->delete('user_access', array('user_id' => $id));
		$this->db->delete('user_address', array('user_id' => $id));
		$this->db->where('id',$id);
		//$this->db->update('users',$data);

		if($this->db->update('users',$data)){
			
			$address_array['user_id'] = $id;
			//$access_array['user_id'] = $id;
			//$this->db->insert('user_access', $access_array);
			$this->db->insert('user_address', $address_array);
			//print_r($this->db->last_query());die;
	    	return true;
		}
		return false;
    }
	
	function getRegisterByID($id){
		$this->db->select('d.*');
		$this->db->from('register d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}

	function getOutLetByID($id){
		$this->db->select('d.*');
		$this->db->from('outlet d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}	

	function getNationalityByID($id){
		$this->db->select('d.*');
		$this->db->from('nationality d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}

	function getOthersByID($id){
		$this->db->select('d.*');
		$this->db->from('others d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}


	function getKidsAgeByID($id){
		$this->db->select('d.*');
		$this->db->from('age d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}




	function getALLRegisterExcel(){

		//$this->db->where('province.is_delete', 0);
		$q = $this->db->get('register');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
	
	function getFarmer_addressby_ID($id){
		$this->db->select('d.*');
		$this->db->from('user_address d');
		$this->db->where('d.user_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}
	
	function update_farmer_status($data,$id){

		$this->db->where('id', $id);
		
		if($this->db->update('users',$data)){
			return true;
		}
		return false;
    }



	
	function getSafetyMessageEnglish(){

		$this->db->limit(3);
		$q = $this->db->get('safety_message');

		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}

	function getSafetyMessageKhmer(){

		$this->db->limit(6,3);
		$q = $this->db->get('safety_message');

		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}

	function getsm($id){
		//$id = $this->db->insert_id();
		
		$this->db->select('sm1');
		$this->db->from('register');
		$this->db->where('id',$id);
		$q = $this->db->get();
		//print_r($this->db->last_query());
		
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}

	public function getALLOutlet() {

		$this->db->select('*');
		$this->db->from('outlet');
		$this->db->where('status', 1);
		$this->db->where('is_delete', 0);
		$this->db->order_by('name', 'asc');
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


	 public function getALLOutletCount() {

		$this->db->select('name, count(*) AS cnt');
		$this->db->from('register');
		$this->db->join('outlet', 'outlet.id = register.outlet_id');
		$this->db->group_by("register.outlet_id");
		$this->db->order_by('name', 'asc');
		$q = $this->db->get();

		//print_r($this->db->last_query());die;
		if ($q->num_rows() > 0) {
		 foreach (($q->result()) as $row) {
			 $data[] = $row;
		 }
			 return $data;
		}
		 return FALSE;
	 }


	 

}
