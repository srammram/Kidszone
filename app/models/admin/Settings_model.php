<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function updateLogo($photo)
    {
        $logo = array('logo' => $photo);
        if ($this->db->update('settings', $logo)) {
            return true;
        }
        return false;
    }

    public function updateLoginLogo($photo)
    {
        $logo = array('logo2' => $photo);
        if ($this->db->update('settings', $logo)) {
            return true;
        }
        return false;
    }
	
	
    public function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getDateFormats()
    {
        $q = $this->db->get('date_format');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function updateSetting($data)
    {
        $this->db->where('setting_id', '1');
        if ($this->db->update('settings', $data)) {
            return true;
        }
        return false;
    }


    public function getGroups()
    {
        $this->db->where('id >', 4);
        $q = $this->db->get('groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getGroupByID($id)
    {
        $q = $this->db->get_where('groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function getUserByID($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);        
        if ($q->num_rows() > 0) {        	
            return $q->row();
        }
        return FALSE;
    }  
    public function getUserPermissions($id)
    {
        $q = $this->db->get_where('user_permissions', array('user_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }else{
	    $data['user_id'] = $id;
	    $this->db->insert('user_permissions',$data);
	    $q = $this->db->get_where('user_permissions', array('user_id' => $id), 1);
	    return $q->row();
	}
        return FALSE;
    }
    public function GroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function updatePermissions($id, $data = array())
    {
		
        if ($this->db->update('permissions', $data, array('group_id' => $id)) && $this->db->update('users', array('show_price' => $data['products-price'], 'show_cost' => $data['products-cost']), array('group_id' => $id))) {
			
            return true;
        }
        return false;
    }
    public function updateUserPermissions($id, $data = array())
    {
	
	if(!$this->getUserByID($id)){
	    $data['user_id'] = $id;
	    $this->db->insert('user_permissions',$data);
	    return $this->db->insert_id();
	}else{
	  if ($this->db->update('user_permissions', $data, array('user_id' => $id))) {
			
            return true;
	    }  
	}	
        
        return false;
    }

    public function addGroup($data)
    {
        if ($this->db->insert("groups", $data)) {
            $gid = $this->db->insert_id();
            $this->db->insert('permissions', array('group_id' => $gid));
            return $gid;
        }
        return false;
    }



    public function updateGroup($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update("groups", $data)) {
            return true;
        }
        return false;
    }


	/*### Province*/
	function add_province($data){
		
		$this->db->insert('province', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_province($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('province',$data)){
	    	return true;
		}
		return false;
    }
    function getProvinceby_ID($id){
		$this->db->select('*');
		$this->db->from('province');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLProvince(){

		$this->db->where('status', 1);
		$q = $this->db->get('province');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_province_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('province',$data)){
			return true;
		}
		return false;
	}
	

	/*### Age*/
	function add_age($data){
		
		$this->db->insert('age', $data);
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
    function getAgeby_ID($id){
		$this->db->select('*');
		$this->db->from('age');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLAge(){

		$this->db->where('status', 1);
		$q = $this->db->get('age');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_age_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('age',$data)){
			return true;
		}
		return false;
    }

	
	/*### Commune*/
	function add_commune($data){
		
		$this->db->insert('commune', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_commune($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('commune',$data)){
	    	return true;
		}
		return false;
    }
    function getCommuneby_ID($id){
		$this->db->select('*');
		$this->db->from('commune');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLCommune(){
		$this->db->where('status', 1);
		$q = $this->db->get('commune');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_commune_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('commune',$data)){
			return true;
		}
		return false;
    }
	
	/*### District*/
	function add_district($data){
		
		$this->db->insert('district', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_district($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('district',$data)){
	    	return true;
		}
		return false;
    }
    function getDistrictby_ID($id){
		$this->db->select('*');
		$this->db->from('district');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLDistrict(){
		$this->db->where('status', 1);
		$q = $this->db->get('district');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_district_status($data,$id){

		$this->db->where('id',$id);
		
		if($this->db->update('district',$data)){
			return true;
		}
		return false;
    }
	/*### Village*/
	function add_village($data){
		
		$this->db->insert('village', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_village($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('village',$data)){
	    	return true;
		}
		return false;
    }
    function getVillageby_ID($id){
		$this->db->select('*');
		$this->db->from('village');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLVillage(){
		$this->db->where('status', 1);
		$q = $this->db->get('village');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
    function update_village_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('village',$data)){
			return true;
		}
		return false;
    }
	/*### Currency*/
	function add_currency($data){
		
		$this->db->insert('currency', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_currency($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('currency',$data)){
	    	return true;
		}
		return false;
    }
    function getCurrencyby_ID($id){
		$this->db->select('*');
		$this->db->from('currency');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLCurrency(){
		$this->db->where('status', 1);
		$q = $this->db->get('currency');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_currency_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('currency',$data)){
			return true;
		}
		return false;
    }
	/*### Pets*/
	function add_pets($data){
		
		$this->db->insert('pets', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_pets($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('pets',$data)){
	    	return true;
		}
		return false;
    }
    function getPetsby_ID($id){
		$this->db->select('*');
		$this->db->from('pets');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLPetss(){
		$this->db->where('status', 1);
		$q = $this->db->get('pets');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}

	function getALLPets(){
		//$this->db->where('status', 1);
		//$q = $this->db->get('pets');

		$this->db->select('pets.id, pets.name');
		$this->db->from('pets');
		$this->db->join('pets_type t2', 'pets.id = t2.pets_id', 'inner');
		$this->db->where('pets.status', 1);
		$this->db->group_by('pets.id');
		$q = $this->db->get();

		//print_r($this->db->last_query()); die;

		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}

	function getALLPetsMaster(){
		$this->db->where('status', 1);
		$q = $this->db->get('pets');

		

		//print_r($this->db->last_query()); die;

		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}

    function update_pets_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('pets',$data)){
			return true;
		}
		return false;
    }
	
	/*### Pets_type*/
	function add_pets_type($data){
		
		$this->db->insert('pets_type', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_pets_type($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('pets_type',$data)){
	    	return true;
		}
		return false;
    }
    function getPets_typeby_ID($id){
		$this->db->select('*');
		$this->db->from('pets_type');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLPets_type(){
		$this->db->where('status', 1);
		$q = $this->db->get('pets_type');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_pets_type_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('pets_type',$data)){
			return true;
		}
		return false;
    }
	
	function getdistrict_byprovince($province_id){
		//$this->db->where('province_id', $province_id);
		//$this->db->where('status', 1);
		$array = array(
			'province_id' => $province_id,
			'status' => 1
		);

		$this->db->where($array);
		$q = $this->db->get('district');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
	function getcommune_bydistrict($district_id){

		$array = array(
			'district_id' => $district_id,
			'status' => 1
		);

		$this->db->where($array);
		$q = $this->db->get('commune');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
	function getvillage_bycommune($commune_id){

		$array = array(
			'commune_id' => $commune_id,
			'status' => 1
		);

		$this->db->where($array);
		$q = $this->db->get('village');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
	
	/*### Equipment*/
	function add_equipment($data){
		
		$this->db->insert('equipment', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_equipment($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('equipment',$data)){
	    	return true;
		}
		return false;
    }
    function getEquipmentby_ID($id){
		$this->db->select('*');
		$this->db->from('equipment');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLEquipment(){
		$this->db->where('status', 1);
		$q = $this->db->get('equipment');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_equipment_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('equipment',$data)){
			return true;
		}
		return false;
    }
	
	/*### Hygine*/
	function add_hygine($data){
		
		$this->db->insert('hygine', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_hygine($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('hygine',$data)){
	    	return true;
		}
		return false;
    }
    function getHygineby_ID($id){
		$this->db->select('*');
		$this->db->from('hygine');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLHygine(){
		

		$this->db->where('status', 1);

		$q = $this->db->get('hygine');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_hygine_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('hygine',$data)){
			return true;
		}
		return false;
    }
	
	
	/*### Expanse*/
	function add_expanse($data){
		
		$this->db->insert('expanse', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_expanse($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('expanse',$data)){
	    	return true;
		}
		return false;
    }
    function getExpanseby_ID($id){
		$this->db->select('*');
		$this->db->from('expanse');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLExpanse(){
		$this->db->where('status', 1);
		$q = $this->db->get('expanse');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_expanse_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('expanse',$data)){
			return true;
		}
		return false;
    }
	
	/*### General_hygine*/
	function add_general_hygine($data){
		
		$this->db->insert('general_hygine', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_general_hygine($id,$data){
		$this->db->where('id',$id);

		
		if($this->db->update('general_hygine',$data)){
	    	return true;
		}
		return false;
    }
    function getGeneral_hygineby_ID($id){
		$this->db->select('*');
		$this->db->from('general_hygine');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLGeneral_hygine(){
		

		$this->db->where('status',1);
		$q = $this->db->get('general_hygine');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_general_hygine_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('general_hygine',$data)){
			return true;
		}
		return false;
    }
	
	/*### Source_of_water*/
	function add_source_of_water($data){
		
		$this->db->insert('source_of_water', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_source_of_water($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('source_of_water',$data)){
	    	return true;
		}
		return false;
    }
    function getSource_of_waterby_ID($id){
		$this->db->select('*');
		$this->db->from('source_of_water');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLSource_of_water(){
		
		$this->db->where('status', 1);
		$q = $this->db->get('source_of_water');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_source_of_water_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('source_of_water',$data)){
			return true;
		}
		return false;
    }

	/*### Occupations*/
	function add_occupations($data){
		
		$this->db->insert('occupations', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_occupations($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('occupations',$data)){
	    	return true;
		}
		return false;
    }
    function getOccupationsby_ID($id){
		$this->db->select('*');
		$this->db->from('occupations');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLOccupations(){
		$this->db->where('status', 1);
		$q = $this->db->get('occupations');
	
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_occupations_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('occupations',$data)){
			return true;
		}
		return false;
	}
	
	function check_duplicate($name, $id=NULL, $table) {

		//return $id;

		if(!$id) {
			$this->db->select('name')
			->from($table)
			->where('name', $name);
		}
		else
		{
			$this->db->select('name')
			->from($table)
			->where(array('name = ' => $name,'id!=' => $id));
		}

		$q = $this->db->get();
		//print_r($this->db->last_query());
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


	function check_duplicate_district($id=NULL, $name, $province_id) {

		//return $id;

		if(!$id) {
			$this->db->select('name')
			->from('district')
			->where(array('name = ' => $name,'province_id=' => $province_id));
		}
		else
		{
			$this->db->select('name')
			->from('district')
			->where(array('name = ' => $name, 'province_id=' => $province_id, 'id!=' => $id));
		}

		$q = $this->db->get();
		//print_r($this->db->last_query());
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


	function getform_settingsby_ID($form_id){
		$q = $this->db->select('fs.*, f.name')->from('form_settings fs')->join('form f', 'f.id = fs.form_id')->where('fs.form_id', $form_id)->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}

	function getformby_ID($form_id){
		$q = $this->db->select('f.name')->from('form f')->where('f.id', $form_id)->get();
		//print_r($this->db->last_query());die;
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
	}


	function updateFormsetting($id, $data){
		$q = $this->db->delete('form_settings', array('form_id' => $id));
		if($q){
			$this->db->insert('form_settings', $data);
			
			return true;
		}else{
			$this->db->insert('form_settings', $data);
			die;
			return true;
		}
	}
	
	/*### Department*/
	function add_department($data){
		
		$this->db->insert('department', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_department($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('department',$data)){
	    	return true;
		}
		return false;
    }
    function getDepartmentby_ID($id){
		$this->db->select('*');
		$this->db->from('department');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLDepartment(){
		$this->db->where('status', 1);
		$q = $this->db->get('department');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_department_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('department',$data)){
			return true;
		}
		return false;
    }
	/*### Role*/
	function add_role($data){
		
		$this->db->insert('role', $data);
        if($id = $this->db->insert_id()){
	    	return true;
		}
		return false;
    }
	function update_role($id,$data){
		$this->db->where('id',$id);
		
		if($this->db->update('role',$data)){
	    	return true;
		}
		return false;
    }
    function getRoleby_ID($id){
		$this->db->select('*');
		$this->db->from('role');
		$this->db->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row();
		}
		return false;
    }
	function getALLRole(){
		$this->db->where('status', 1);
		$q = $this->db->get('role');
		if($q->num_rows()>0){
			foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			return $data;
		}
		return false;
	}
    function update_role_status($data,$id){
		$this->db->where('id',$id);
		
		if($this->db->update('role',$data)){
			return true;
		}
		return false;
	}
	

	function check_duplicate_value($id=NULL, $value, $fieldName, $wFieldName=NULL, $table) {

		//return $id;

		if(!$id) {
			$this->db->select($fieldName)
			->from($table)
			->where($fieldName, $value);
		}
		else
		{
			$this->db->select($fieldName)
			->from($table)
			->where(array($fieldName.' = ' => $value, $wFieldName.'!=' => $id));
		}

		$q = $this->db->get();
		//print_r($this->db->last_query());
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
}
