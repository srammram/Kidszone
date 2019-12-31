<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Safety_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function safety_add($data){
		
		$this->db->insert('safety_message', $data); 
		//print_r($this->db->last_query());die;
        if($this->db->insert_id()) {
	    	return true;
		}
		return false;
    }
	
	function update_safety($id, $data) {

		$this->db->where('id',$id);

		if($this->db->update('safety_message',$data)){			

	    	return true;
		}
		return false;
	}
	

	function getSafetyByID($id){
		$this->db->select('d.*');
		$this->db->from('safety_message d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			
			return $q->row();
		}
		return false;
    }


}
