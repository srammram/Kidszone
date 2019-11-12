<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formthree_model extends CI_Model
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
	
	function add_formthree($data, $expanse_array){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$expanse_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$expanse_array);
		
		$this->db->insert('formthree', $data);//print_r($this->db->last_query());die;
        if($id = $this->db->insert_id()){
			
			
			if(!empty($expanse_array)){
				foreach($expanse_array as $key => $csm)
				 {
				  $expanse_array[$key]['formthree_id'] = $id;
				 }
				$this->db->insert_batch('formthree_expanse', $expanse_array);
			}
			
			
			
	    	return true;
		}
		return false;
    }
	
	function update_formthree($id,$data, $expanse_array){
		$data = array_map(function($v){return (is_null($v)) ? "" : $v;},$data);
		$expanse_array = array_map(function($v){return (is_null($v)) ? "" : $v;},$expanse_array);
		
		foreach($expanse_array as $key => $csm)
		 {
		  $expanse_array[$key]['formthree_id'] = $id;
		 }
		
		$this->db->delete('formthree_pets', array('formthree_id' => $id));
		$this->db->where('id',$id);
		if($this->db->update('formthree',$data)){
			if(!empty($expanse_array)){
				
				
				$this->db->insert_batch('formthree_expanse', $expanse_array);
			}
			
	    	return true;
		}
		return false;
    }
	
	function update_view_form_three($id, $data){

		$this->db->where('id', $id);
		//$this->db->update('formthree', $data);
		//print_r($this->db->last_query()); die;
		
		if($this->db->update('formthree', $data)){
			
	    	return true;
		}
		return false;
    }

	function getFormthreeby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formthree d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function getFormthree_expanseby_ID($id){
		$this->db->select('d.*');
		$this->db->from('formthree_expanse d');
		$this->db->where('d.formthree_id',$id);
		$q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
	
	function update_formthree_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('formthree',$data)){
			return true;
		}
		return false;
	}
	

	function getTotalCount() {

		$this->db->select('*');
		$this->db->from('formthree');

		$q = $this->db->get();
		return $q->num_rows();
	}
}
