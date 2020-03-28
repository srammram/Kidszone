<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function get_code($code, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('code')
			->from('outlet')
			->where('code', $code);
		}
		else
		{
			$this->db->select('code')
			->from('outlet')
			->where(array('code = ' => $code,'id!=' => $id));
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


	function get_latitude($lat, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('lat')
			->from('outlet')
			->where('lat', $lat);
		}
		else
		{
			$this->db->select('lat')
			->from('outlet')
			->where(array('lat = ' => $lat,'id!=' => $id));
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

	
	function get_longitude($lng, $id=NULL) {

		//return $id;

		if(!$id) {
			$this->db->select('lng')
			->from('outlet')
			->where('lng', $lng);
		}
		else
		{
			$this->db->select('lng')
			->from('outlet')
			->where(array('lng = ' => $lat,'id!=' => $id));
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


	function add_outlet($data){
		
		$this->db->insert('outlet', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
	}

	function update_outlet($id,$data){		
;
		$this->db->where('id',$id);
		if($this->db->update('outlet',$data)){
	    	return true;
		}
		return false;
    }
	
	function getOutLetBy_ID($id){
		$this->db->select('d.*');
		$this->db->from('outlet d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function update_outlet_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('outlet',$data)){
			return true;
		}
		return false;
    }


	function delete_update($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('outlet',$data)){

			//print_r($this->db->last_query()); die;
			return true;
		}
		return false;
    }

}
