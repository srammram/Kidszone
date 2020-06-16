<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Others_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function get_name($name, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('name')
			->from('others')
			->where('name', $name);
		}
		else
		{
			$this->db->select('name')
			->from('others')
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




	function add_others($data){
		
		$this->db->insert('others', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
	}

	function update_others($id,$data){		

		$this->db->where('id',$id);
		if($this->db->update('others',$data)){
	    	return true;
		}
		return false;
    }
	
	function getOthersBy_ID($id){
		$this->db->select('d.*');
		$this->db->from('others d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function update_others_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('others',$data)){
			return true;
		}
		return false;
    }


	function delete_update($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('others',$data)){

			//print_r($this->db->last_query()); die;
			return true;
		}
		return false;
    }

}
