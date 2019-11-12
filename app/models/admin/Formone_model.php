<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formone_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function getFarmerID($id){
		$q = $this->db->select('*')->where('id', $id)->get('users');
		if($q->num_rows()>0){
			
			return $q->row();
		}
		return false;
	}

	function getFarmerAddressID($id){
		$q = $this->db->select('*')->where('user_id', $id)->get('user_address');
		//print_r($this->db->last_query()); die;
		if($q->num_rows()>0){
			
			//return $q->row();
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
		}
		return false;




	}

	function add_formone($data, $pets_array, $user_data, $address_array, $farmer_id){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$pets_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$pets_array);
		$user_data = array_map(function($v){return (is_null($v)) ? "" : $v;},$user_data);
		$address_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$address_array);
		
		
		if(!empty($farmer_id)){
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
	
	function update_formone($id,$data, $pets_array){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$pets_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$pets_array);
		foreach($pets_array as $key => $csm)
		 {
		  $pets_array[$key]['formone_id'] = $id;
		 }
		
		$this->db->delete('formone_pets', array('formone_id' => $id));
		$this->db->where('id',$id);
		if($this->db->update('formone',$data)){
			if(!empty($pets_array)){
				foreach($pets_array as $key => $csm)
				 {
				  $pets_array[$key]['formone_id'] = $id;
				 }
				
				$this->db->insert_batch('formone_pets', $pets_array);
			}
			
	    	return true;
		}
		return false;
    }
	
	function getFormoneby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formone d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			
			return $q->row();
		}
		return false;
    }
	function checkFormone($id){
		$this->db->select('d.*');
		$this->db->from('formone d');
		$this->db->join('formtwo t', 't.formone_code = d.refer_code');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return true;
		}
		return false;
	}
	
	function getFormone_petsby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formone_pets d');
		$this->db->where('d.formone_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
    }
	
	function update_formone_status($data,$id){
		
		$this->db->where('id', $id);
		
		if($this->db->update('formone',$data)){
			return true;
		}
		return false;
	}
	

	function get_identification_number($in, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('identification_number')
			->from('users')
			->where('identification_number', $in);
		}
		else
		{
			$this->db->select('identification_number')
			->from('users')
			->where(array('identification_number = ' => $in,'id!=' => $id));
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


	function get_phone_number($in, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('phone')
			->from('users')
			->where('phone', $in);
		}
		else
		{
			$this->db->select('phone')
			->from('users')
			->where(array('phone = ' => $in,'id!=' => $id));
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


	function getTotalCount() {

		$this->db->select('*');
		$this->db->from('formone');
		$this->db->join('formtwo', 'formone.refer_code = formtwo.formone_code', 'left');

		$q = $this->db->get();
		return $q->num_rows();
	}

}
