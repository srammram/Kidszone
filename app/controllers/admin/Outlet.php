<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends MY_Controller
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
		$this->load->admin_model('outlet_model');
		$this->load->admin_model('settings_model');
		$this->data['menu'] = $this->site->menuList();
    }
	
	
	/*###### Staff*/
    function index($action=false){
		
		//$this->site->webPermission($this->session->userdata('user_id'), 'outlet', 'index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('outlet')));
        $meta = array('page_title' => lang('outlet'), 'bc' => $bc);
		
        $this->page_construct('outlet/index', $meta, $this->data);
    }
	
    function getOutlet(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select("{$this->db->dbprefix('outlet')}.id as id, {$this->db->dbprefix('outlet')}.code, {$this->db->dbprefix('outlet')}.name as oname, {$this->db->dbprefix('outlet')}.device_ip, {$this->db->dbprefix('outlet')}.lat, {$this->db->dbprefix('outlet')}.lng, {$this->db->dbprefix('outlet')}.status as status")
            ->from("outlet");

			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}
			
            $this->datatables->edit_column('status', '$1__$2', 'id, status');
			
			$edit = "<a href='" . admin_url('outlet/edit_outlet/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			$view = "<a href='" . admin_url('outlet/view_outlet/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$delete = "<a href='" . admin_url('welcome/delete/users/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			/*$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";*/
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
		echo $this->datatables->generate();
		//echo $this->db->last_query();
		
    }


	function get_code() {

		$code = $this->input->post('code');
		$id = $this->input->post('id');
		$data = $this->outlet_model->get_code($code, $id);

		echo $data;
	}

	
	function get_latitude() {

		$lat = $this->input->post('lat');
		$id = $this->input->post('id');
		$data = $this->outlet_model->get_latitude($lat, $id);

		echo $data;
	}


	function get_longitude() {

		$lng = $this->input->post('lng');
		$id = $this->input->post('id');
		$data = $this->outlet_model->get_longitude($lng, $id);

		echo $data;
	}



	function add_outlet(){

		//echo '<pre>';
		//print_r($_POST); die;

		//$this->site->webPermission($this->session->userdata('user_id'), 'outlet', 'add_outlet');

		$this->form_validation->set_rules('name', lang("name"), 'required');
		$this->form_validation->set_rules('code', lang("code"), 'is_unique[outlet.code]');
		$this->form_validation->set_rules('lat', lang("latitude"), 'required');
		$this->form_validation->set_rules('lng', lang("longitude"), 'required');

		//$this->form_validation->set_rules('lat', lang("latitude"), 'is_unique[outet.lat]');
		//$this->form_validation->set_rules('lng', lang("longitude"), 'is_unique[outet.lng]');
		
        if ($this->form_validation->run() == true) {

            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'lat' => $this->input->post('lat'),
				'lng' => $this->input->post('lng'),
				'device_ip' => $this->input->post('device_ip'),
				'active' => 1,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);

			//print_r($access_array);die;

			//print_r($data); die;
        }
		
		
        if ($this->form_validation->run() == true && $this->outlet_model->add_outlet($data)){
			
            $this->session->set_flashdata('message', lang("outlet_added"));
            admin_redirect('outlet/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('outlet/index'), 'page' => lang('outlet')), array('link' => '#', 'page' => lang('add_outlet')));
            $meta = array('page_title' => lang('add_outlet'), 'bc' => $bc);
			
            $this->page_construct('outlet/add', $meta, $this->data);			
  
        }
    }
	
	function view_outlet($id){
		
		//$this->site->webPermission($this->session->userdata('user_id'), 'outlet', 'view_outlet');
		$result = $this->outlet_model->getOutLetBy_ID($id);

		$this->data['result'] = $result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('outlet/index'), 'page' => lang('outlet')), array('link' => '#', 'page' => lang('view_outlet')));
		$meta = array('page_title' => lang('view_outlet'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		$this->page_construct('outlet/view', $meta, $this->data);
        
    }
	
    function edit_outlet($id){

		//echo '<pre>';
		//print_r($_POST); die;

		//$this->site->webPermission($this->session->userdata('user_id'), 'outlet', 'edit_outlet');

		$result = $this->outlet_model->getOutLetBy_ID($id);
		//print_r($result);
		//die;

		if($this->input->post('edit_outlet')){		

			$this->form_validation->set_rules('name', lang("name"), 'required');
			//$this->form_validation->set_rules('code', lang("code"), 'is_unique[outlet.code]');
			$this->form_validation->set_rules('lat', lang("latitude"), 'required');
			$this->form_validation->set_rules('lng', lang("longitude"), 'required');

        if ($this->form_validation->run() == true) {

			$data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'lat' => $this->input->post('lat'),
				'lng' => $this->input->post('lng'),
				'device_ip' => $this->input->post('device_ip'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
			);
			
			} elseif ($this->input->post('edit_outlet')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("outlet/edit_outlet/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->outlet_model->update_outlet($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("outlet_updated"));
            admin_redirect("outlet/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));		

			//print_r($this->data['reporter']);die;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('outlet/index'), 'page' => lang('outlet')), array('link' => '#', 'page' => lang('edit_outlet')));
			
            $meta = array('page_title' => lang('edit_outlet'), 'bc' => $bc);
			$this->data['result'] = $result;
            $this->data['id'] = $id;
			$this->page_construct('outlet/edit', $meta, $this->data);
        }
	}
	
	function outlet_status($status,$id){		

		//$this->site->webPermission($this->session->userdata('user_id'), 'outlet', 'outlet_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->outlet_model->update_outlet_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
}
