<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access_keys extends MY_Controller
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
		$this->load->admin_model('access_keys_model');
		$this->load->admin_model('settings_model');
		$this->data['menu'] = $this->site->menuList();
    }	

    function index($action=false){

		//$this->site->webPermission($this->session->userdata('user_id'), 'age', 'index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('access keys')));
        $meta = array('page_title' => lang('access keys'), 'bc' => $bc);

        $this->page_construct('access_keys/index', $meta, $this->data);
    }


    function getAccessKeys(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select("{$this->db->dbprefix('api_keys')}.id as id, {$this->db->dbprefix('api_keys')}.reference_key as key, {$this->db->dbprefix('api_keys')}.status as status")
            ->from("api_keys");

			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}
			
			//$this->datatables->where("is_delete", 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');
			
			//$edit = "<a href='" . admin_url('age/edit_age/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$view = "<a href='" . admin_url('age/view_age/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$delete = "<a href='" . admin_url('age/delete/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			/*$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";*/
			//$this->datatables->add_column("Actions", "<div>".$view."</div>", "id");
		
			//$this->datatables->unset_column('id');
		echo $this->datatables->generate();
		//echo $this->db->last_query();
		
    }


	function get_access_keys() {

		$key = $this->input->post('reference_key');
		$id = $this->input->post('id');
		$data = $this->access_keys_model->get_access_keys($key, $id);

		echo $data;
	}

	function add(){

		//echo '<pre>';
		//print_r($_POST); die;

		$this->site->webPermission($this->session->userdata('user_id'), 'age', 'add_age');

		$this->form_validation->set_rules('access key', lang("reference_key"), 'is_unique[api_keys.reference_key]');
		
        if ($this->form_validation->run() == true) {

            $data = array(
				'reference_key' => $this->input->post('reference_key'),
				'status' => 1,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);

			//print_r($access_array);die;

			//print_r($data); die;
        }
		
		
        if ($this->form_validation->run() == true){
			
			if($this->access_keys_model->add($data)){
			
				$this->session->set_flashdata('message', lang("access_keys_added"));
				admin_redirect('access_keys/index');
			}
			else{

				$this->session->set_flashdata('error', lang("Access key already exists"));
				admin_redirect('access_keys/add');
			}
			
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('access_keys/index'), 'page' => lang('access_keys')), array('link' => '#', 'page' => lang('add_access_keys')));
            $meta = array('page_title' => lang('add_access_keys'), 'bc' => $bc);
			
            $this->page_construct('access_keys/add', $meta, $this->data);			
  
        }
    }
	
	function view_age($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'age', 'view_age');
		$result = $this->age_model->getAgeBy_ID($id);

		$this->data['result'] = $result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('age/index'), 'page' => lang('age')), array('link' => '#', 'page' => lang('view_age')));
		$meta = array('page_title' => lang('view_age'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		$this->page_construct('age/view', $meta, $this->data);
        
    }
	
    function edit_age($id){

		//echo '<pre>';
		//print_r($_POST); die;

		$this->site->webPermission($this->session->userdata('user_id'), 'age', 'edit_age');

		$result = $this->age_model->getAgeBy_ID($id);
		//print_r($result);
		//die;

		if($this->input->post('edit_age')){		

			$this->form_validation->set_rules('name', lang("name"), 'required');

        if ($this->form_validation->run() == true) {

			$data = array(
				'name' => $this->input->post('name'),
				'khmer_name' => $this->input->post('khmer_name'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
			);
			
			} elseif ($this->input->post('edit_age')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("age/edit_age/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->age_model->update_age($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("age_updated"));
            admin_redirect("age/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));		

			//print_r($this->data['reporter']);die;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('age/index'), 'page' => lang('age')), array('link' => '#', 'page' => lang('edit_age')));
			
            $meta = array('page_title' => lang('edit_age'), 'bc' => $bc);
			$this->data['result'] = $result;
            $this->data['id'] = $id;
			$this->page_construct('age/edit', $meta, $this->data);
        }
	}
	
	function status($status, $id){		

		//$this->site->webPermission($this->session->userdata('user_id'), 'age', 'age_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->access_keys_model->update_access_key_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
	}
	

	function delete($id){		

		$this->site->webPermission($this->session->userdata('user_id'), 'age', 'delete');
		$data['is_delete'] = 1;
		
		$this->age_model->delete_update($data,$id);
		$this->session->set_flashdata('message', lang("age_deleted"));
		redirect($_SERVER["HTTP_REFERER"]);
	}

}
