<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Safety extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
		//$this->lang->admin_load('system_settings', $this->Settings->user_language);
		//$this->lang->admin_load('common', $this->Settings->user_language);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		$this->upload_path = 'assets/uploads/';
		$this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|png|jpeg|pdf';
		$this->allowed_file_size = '1024';
		$this->load->admin_model('safety_model');
		$this->load->admin_model('settings_model');
		$this->load->admin_model('db_model');
		$this->data["link_permission"] = $this->db_model->link_permission(); // Added****		
		$this->data['menu'] = $this->site->menuList();
    }

    function index($action=false){

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('safety')));
        $meta = array('page_title' => lang('safety'), 'bc' => $bc);
		
        $this->page_construct('safety/index', $meta, $this->data);
    }
	


    function getSafety() {
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select("{$this->db->dbprefix('safety_message')}.id as id, {$this->db->dbprefix('safety_message')}.lang, {$this->db->dbprefix('safety_message')}.title")
            ->from("safety_message");
			
            //$this->datatables->edit_column('status', '$1__$2', 'id, status');

			$edit = "<a href='" . admin_url('safety/safety_edit/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";

			//$view = "<a href='" . admin_url('safety/safety_view/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";			

			/*$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";*/
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
		echo $this->datatables->generate();
		//echo $this->db->last_query();
		
    }

	function safety_add(){

		//echo '<pre>';
		//print_r($_POST);
		//die;

		//$this->form_validation->set_rules('title', lang("title"), 'is_unique[safety_message.title]');
		$this->form_validation->set_rules('title', lang("title"), 'required');
		$this->form_validation->set_rules('desc_msg', lang("description"), 'required');

        if ($this->form_validation->run() == true) {

            $data = array(
                'title' => $this->input->post('title'),
				'desc_msg' => $this->input->post('desc_msg'),
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),            
				);
			
        }

        if ($this->form_validation->run() == true && $this->safety_model->safety_add($data)){
            $this->session->set_flashdata('message', lang("safety_added"));
            admin_redirect('safety/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('safety/index'), 'page' => lang('safety')), array('link' => '#', 'page' => lang('safety_add')));
            $meta = array('page_title' => lang('safety_add'), 'bc' => $bc);

            $this->page_construct('safety/add', $meta, $this->data);
			
  
        }
    }
	
	function view_farmer($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'farmer', 'view_farmer');
		$result = $this->farmer_model->getFarmerby_ID($id);
		//$access_result = $this->farmer_model->getFarmer_accessby_ID($id);
		$address_result = $this->farmer_model->getFarmer_addressby_ID($id);
		
		$this->data['province'] = $this->settings_model->getALLProvince();
		$this->data['district'] = $this->settings_model->getdistrict_byprovince($address_result->province);
		
		$this->data['commune'] = $this->settings_model->getcommune_bydistrict($address_result->district);
		
		$this->data['village'] = $this->settings_model->getvillage_bycommune($address_result->commune);
		$this->data['department'] = $this->site->Alldepartment();
		$this->data['result'] = $result;
		$this->data['occupations'] = $this->settings_model->getALLOccupations();
		//$this->data['access_result'] = $access_result;
		$this->data['address_result'] = $address_result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('farmer/index'), 'page' => lang('farmer')), array('link' => '#', 'page' => lang('view_farmer')));
		$meta = array('page_title' => lang('view_farmer'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		 $this->page_construct('farmer/view', $meta, $this->data);
        
    }
	
    function safety_edit($id){

		$result = $this->safety_model->getSafetyByID($id);

		if($this->input->post('safety_edit')){

		$this->form_validation->set_rules('title', lang("title"), 'required');
		$this->form_validation->set_rules('desc_msg', lang("description"), 'required');
		
        if ($this->form_validation->run() == true) {
			
			$data = array(
                'title' => $this->input->post('title'),
				'desc_msg' => $this->input->post('desc_msg'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
				);
			
			} elseif ($this->input->post('safety_edit')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("safety/safety_edit/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->safety_model->update_safety($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("safety_updated"));
            admin_redirect("safety/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

			$this->data['result'] = $result;
						
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('safety/index'), 'page' => lang('safety')), array('link' => '#', 'page' => lang('safety_edit')));
            $meta = array('page_title' => lang('safety_edit'), 'bc' => $bc);
			
            $this->data['id'] = $id;
			 $this->page_construct('safety/edit', $meta, $this->data);
        }
    }
	function farmer_status($status,$id){

		$this->site->webPermission($this->session->userdata('user_id'), 'farmer', 'farmer_status');

        $data['active'] = 0;
        if($status=='active'){
            $data['active'] = 1;
        }
        $this->farmer_model->update_farmer_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	function getdistrict_byprovince_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		
		$province_id = $this->input->post('province_id');
		$location_id = $this->input->post('province_id');
		$group_id = 3;
		if($department_id == 1){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getdistrict_byprovince($province_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
	
	function getcommune_bydistrict_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$district_id = $this->input->post('district_id');
		$location_id = $this->input->post('district_id');
		$group_id = 3;
		if($department_id == 2){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getcommune_bydistrict($district_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
	
	
	function getvillage_bycommune_rep(){
		$options['rep'] = array();
		$options['loc'] = array();
		$department_id = $this->input->post('department_id');
		$commune_id = $this->input->post('commune_id');
		$location_id = $this->input->post('commune_id');
		$group_id = 3;
		if($department_id == 3){
			$checkRole = $this->site->getRole_byuser($department_id, $group_id, $location_id);
			
			if($checkRole){
				foreach($checkRole as $c => $cow){
					$options['rep'][$c]['id'] = $cow->user_id;
					$options['rep'][$c]['text'] = $cow->first_name;
				}
			}
		}
		$data = $this->settings_model->getvillage_bycommune($commune_id);
        
        if($data){
            foreach($data as $k => $row){
                $options['loc'][$k]['id'] = $row->id;
                $options['loc'][$k]['text'] = $row->name;
            }
        }
		
		echo json_encode($options);exit;
	}
	
}
