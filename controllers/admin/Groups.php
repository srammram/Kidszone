<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MY_Controller
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
        $this->image_types = 'gif|jpg|png|jpeg|pdf';
		$this->allowed_file_size = '1024';
		$this->load->admin_model('groups_model');
		$this->load->admin_model('settings_model');
		
    }
	
	
	/*###### Groups */
    function index($action=false) {

		//$this->sma->checkPermissions();



        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('roles')));
        $meta = array('page_title' => lang('roles'), 'bc' => $bc);
		$this->page_construct('groups/index', $meta, $this->data);

    }
	
    function getGroups(){

		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];

        $this->load->library('datatables');

        $this->datatables
            ->select("{$this->db->dbprefix('groups')}.id as id, {$this->db->dbprefix('groups')}.name, {$this->db->dbprefix('groups')}.status as status")
            ->from("groups");

			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('groups')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('groups')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}

        	$this->datatables->edit_column('status', '$1__$2', 'id, status');

			$edit = "<a href='" . admin_url('groups/edit/$1') . "' data-toggle='tooltip' data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true' style='color:#656464; font-size:18px'></i></a>";

			//$view = "<a href='" . admin_url('groups/view_groups/$1') . "' data-toggle='tooltip' data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true' style='color:#656464; font-size:18px'></i></a>";

			//$delete = "<a href='" . admin_url('welcome/delete/formone/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");

			$this->datatables->unset_column('id');
            echo $this->datatables->generate();
    }	

    function edit($id) {

		
		$result = $this->groups_model->getGroupPermissionByID($id);
		//echo '<pre>';
		//print_r($_POST);

		$data= array(
			'formone' => (($this->input->post('formone')!=NULL) ? 1 : FALSE),
			'add_formone' => (($this->input->post('add_formone')!=NULL) ? 1 : FALSE),
			'edit_formone' => (($this->input->post('edit_formone')!=NULL) ? 1 : FALSE),
			'delete_formone' => (($this->input->post('delete_formone')!=NULL) ? 1 : FALSE),
			'formtwo' => (($this->input->post('formtwo')!=NULL) ? 1 : FALSE),
			'add_formtwo' => (($this->input->post('add_formtwo')!=NULL) ? 1 : FALSE),
			'edit_formtwo' => (($this->input->post('edit_formtwo')!=NULL) ? 1 : FALSE),
			'delete_formtwo' => (($this->input->post('delete_formtwo')!=NULL) ? 1 : FALSE),
			'formthree' => (($this->input->post('formthree')!=NULL) ? 1 : FALSE),
			'add_formthree' => (($this->input->post('add_formthree')!=NULL) ? 1 : FALSE),
			'edit_formthree' => (($this->input->post('edit_formthree')!=NULL) ? 1 : FALSE),
			'delete_formthree' => (($this->input->post('delete_formthree')!=NULL) ? 1 : FALSE),
			'farmer' => (($this->input->post('farmer')!=NULL) ? 1 : FALSE),
			'add_farmer' => (($this->input->post('add_farmer')!=NULL) ? 1 : FALSE),
			'edit_farmer' => (($this->input->post('edit_farmer')!=NULL) ? 1 : FALSE),
			'delete_farmer' => (($this->input->post('delete_farmer')!=NULL) ? 1 : FALSE),
			'vendor' => (($this->input->post('vendor')!=NULL) ? 1 : FALSE),
			'add_vendor' => (($this->input->post('add_vendor')!=NULL) ? 1 : FALSE),
			'edit_vendor' => (($this->input->post('edit_vendor')!=NULL) ? 1 : FALSE),
			'delete_vendor' => (($this->input->post('delete_vendor')!=NULL) ? 1 : FALSE),
			'group_id' => $id
		);

		if ($this->input->post('insert_permission') && $this->groups_model->insert_groups_permission($data, $result)) { //check to see if we are updateing the customer

            $this->session->set_flashdata('message', lang("groups_updated"));
			admin_redirect("groups/index");

        } else {

			$this->data['pages'] = $this->groups_model->getALLPages();
			$this->data['p'] = $result;

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('groups/index'), 'page' => lang('groups')), array('link' => '#', 'page' => lang('edit_groups')));
            $meta = array('page_title' => lang('edit_groups'), 'bc' => $bc);

			$this->data['group_id'] = $id;

			$this->page_construct('groups/edit', $meta, $this->data);
		}

	}

	function groups_status($status,$id){
		
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->groups_model->update_groups_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
}
