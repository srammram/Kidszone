<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Farmer_model extends CI_Model
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
	
	function getFarmerby_ID($id){
		$this->db->select('d.*');
		$this->db->from('users d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
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


}
