<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formtwo_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getSuggestions($term, $limit = 20)
    {
		
        $this->db->select("id, (CASE WHEN refer_code = '' THEN head_of_family ELSE CONCAT(refer_code, ' - ', head_of_family, ' ') END) as text", FALSE);
        $this->db->where(" id LIKE '%" . $term . "%' OR head_of_family LIKE '%" . $term . "%' OR refer_code LIKE '%" . $term . "%' ");
        $q = $this->db->get('formone', '', $limit);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }
	
	function checkFormtwo($id){
		$this->db->select('d.*');
		$this->db->from('formtwo d');
		$this->db->join('formthree t', 't.formtwo_code = d.refer_code');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return true;
		}
		return false;
	}
	
	function add_formtwo($data, $pets_array, $hygine_array, $source_of_water_array, $general_hygine_array, $farmer_id, $user){
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
	
	function update_formtwo($id,$data, $pets_array, $hygine_array, $source_of_water_array, $general_hygine_array, $farmer_id, $user){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$pets_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$pets_array);
		$hygine_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$hygine_array);
		$source_of_water_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$source_of_water_array);
		$general_hygine_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$general_hygine_array);
		
		
		foreach($pets_array as $key => $csm)
		 {
		  $pets_array[$key]['formtwo_id'] = $id;
		 }
		 foreach($hygine_array as $key => $csm)
		 {
		  $hygine_array[$key]['formtwo_id'] = $id;
		 }
		 foreach($source_of_water_array as $key => $csm)
		 {
		  $source_of_water_array[$key]['formtwo_id'] = $id;
		 }
		 foreach($general_hygine_array as $key => $csm)
		 {
		  $general_hygine_array[$key]['formtwo_id'] = $id;
		 }
		
		$this->db->delete('formtwo_pets', array('formtwo_id' => $id));
		$this->db->delete('formtwo_hygine', array('formtwo_id' => $id));
		$this->db->delete('formtwo_source_of_water', array('formtwo_id' => $id));
		$this->db->delete('formtwo_general_hygine', array('formtwo_id' => $id));
		$this->db->where('id',$id);
		if($this->db->update('formtwo',$data)){
			if(!empty($pets_array)){
				
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
	
	function getFormtwoby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formtwo d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			$row = $q->row();
			$row->formone_id = $this->site->getFormoneIDcheckCode($row->formone_code);
			return $row;
		}
		return false;
    }
	
	function getFormtwo_petsby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formtwo_pets d');
		$this->db->where('d.formtwo_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
    }
	
	function getFormtwo_source_of_waterby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formtwo_source_of_water d');
		$this->db->where('d.formtwo_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
    }
	
	function getFormtwo_hygineby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formtwo_hygine d');
		$this->db->where('d.formtwo_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
    }
	
	function getFormtwo_general_hygineby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formtwo_general_hygine d');
		$this->db->where('d.formtwo_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
    }

	function update_formtwo_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('formtwo',$data)){
			return true;
		}
		return false;
    }

	function getTotalCount() {

		$this->db->select('*');
		$this->db->from('formtwo');

		$q = $this->db->get();
		return $q->num_rows();
	}
}
