<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

	function update_groups($id,$data){

		$this->db->where('id',$id);
		if($this->db->update('groups',$data)){
			return true;
		}
		return false;
    }	

	function insert_groups_permission($data, $result){

		if(empty($result)){
			if($this->db->insert('group_permission', $data)){
				//print_r($this->db->last_query());
				//die();
				return true;
			}
		}
		else{
			$this->db->where('group_id', $data['group_id']);
			if($this->db->update('group_permission',$data)){
				//print_r($this->db->last_query());
				//die();
				return true;
			}
		}
		return false;
    }

	function getGroupByID($id){
		$this->db->select('d.*');
		$this->db->from('groups d');
		$this->db->where('d.id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	
	function getGroupPermissionByID($id){
		$this->db->select('d.*');
		$this->db->from('group_permission d');
		$this->db->where('d.group_id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }

	function getALLPages() {

		$this->db->select('d.*');
		$this->db->from('group_permission d');
		$q = $this->db->get();

		if($q->num_rows()>0) {

			/*foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;*/

			return $q->row();
		}
		else{

			$fields = $this->db->list_fields('group_permission');
			foreach($result as $field)
			{
				$fields[] = $field;
				return $fields;
			}
		}
		return false;
	}
	

	function get_field()
	{
		$result = $this->db->list_fields('srambiogas_group_permission');
		foreach($result as $field)
		{
			$fields[] = $field;
			return $fields;
		}
	}

	function update_groups_status($data,$id){
		$this->db->where('id', $id);
		
		if($this->db->update('groups',$data)){
			return true;
		}
		return false;
    }

}
