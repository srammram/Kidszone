<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access_keys_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function get_access_keys($key, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('reference_key')
			->from('api_keys')
			->where('reference_key', $key);
		}
		else
		{
			$this->db->select('reference_key')
			->from('api_keys')
			->where(array('reference_key = ' => $key,'id!=' => $id));
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




	function add($data){

		$this->db->select('reference_key');
		$this->db->from('api_keys');
		$this->db->where('reference_key',$data['reference_key']);		
		$q = $this->db->get();

		if($q->num_rows()>0){
			return false;
		}

		$this->db->insert('api_keys', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
	}

	function update_age($id,$data){		

		$this->db->where('id',$id);
		if($this->db->update('age',$data)){
	    	return true;
		}
		return false;
    }
	
	function getAgeBy_ID($id){
		$this->db->select('d.*');
		$this->db->from('age d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function update_access_key_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('api_keys',$data)){
			return true;
		}
		return false;
    }


	function delete_update($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('age',$data)){

			//print_r($this->db->last_query()); die;
			return true;
		}
		return false;
    }

}
