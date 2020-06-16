<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Age_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function get_name($name, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('name')
			->from('age')
			->where('name', $name);
		}
		else
		{
			$this->db->select('name')
			->from('age')
			->where(array('name = ' => $name,'id!=' => $id));
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




	function add_age($data){
		
		$this->db->insert('age', $data);//print_r($this->db->last_query());die;
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
	
	function update_age_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('age',$data)){
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
