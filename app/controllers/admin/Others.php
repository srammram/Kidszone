<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Others extends MY_Controller
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
		$this->load->admin_model('others_model');
		$this->load->admin_model('settings_model');
		$this->data['menu'] = $this->site->menuList();
    }
	
	
	/*###### Staff*/
    function index($action=false){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('others')));
        $meta = array('page_title' => lang('others'), 'bc' => $bc);
		
        $this->page_construct('others/index', $meta, $this->data);
    }

    function getOthers(){
		
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		
		
        $this->load->library('datatables');
		
        $this->datatables
            ->select("{$this->db->dbprefix('others')}.id as id, {$this->db->dbprefix('others')}.name as pname, {$this->db->dbprefix('others')}.khmer_name, {$this->db->dbprefix('others')}.status as status")
            ->from("others");

			if(!empty($sdate) && !empty($edate)){
				$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) >=", date("Y-m-d", strtotime(str_replace('/', '-', $sdate))));
       			$this->datatables->where("DATE({$this->db->dbprefix('users')}.created_on) <=", date("Y-m-d", strtotime(str_replace('/', '-', $edate))));
			}
			
			$this->datatables->where("is_delete", 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');
			
			$edit = "<a href='" . admin_url('others/edit_others/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to Edit'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			$view = "<a href='" . admin_url('others/view_others/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Click here to View'  ><i class='fa fa-eye' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			//$delete = "<a href='" . admin_url('others/delete/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			/*$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/users/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";*/
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$view."</div><div>".$delete."</div>", "id");
		
			//$this->datatables->unset_column('id');
		echo $this->datatables->generate();
		//echo $this->db->last_query();
		
    }

	function get_name() {

		$name = $this->input->post('name');
		$id = $this->input->post('id');
		$data = $this->others_model->get_name($name, $id);

		echo $data;
	}


	function add_others(){

		//echo '<pre>';
		//print_r($_POST); die;

		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'add_others');

		$this->form_validation->set_rules('name', lang("name"), 'is_unique[others.name]');
		
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'khmer_name' => $this->input->post('khmer_name'),
				'status' => 1,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);

			//print_r($access_array);die;

			//print_r($data); die;
        }
		
		
        if ($this->form_validation->run() == true && $this->others_model->add_others($data)){
			
            $this->session->set_flashdata('message', lang("others_added"));
            admin_redirect('others/index');
        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('others/index'), 'page' => lang('others')), array('link' => '#', 'page' => lang('add_others')));
            $meta = array('page_title' => lang('add_others'), 'bc' => $bc);
			
            $this->page_construct('others/add', $meta, $this->data);			
  
        }
    }
	
	function view_others($id){
		
		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'view_others');
		$result = $this->others_model->getOthersBy_ID($id);

		$this->data['result'] = $result;
					
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('others/index'), 'page' => lang('others')), array('link' => '#', 'page' => lang('view_others')));
		$meta = array('page_title' => lang('view_others'), 'bc' => $bc);
		
		$this->data['id'] = $id;
		$this->page_construct('others/view', $meta, $this->data);
        
    }
	
    function edit_others($id){

		//echo '<pre>';
		//print_r($_POST); die;

		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'edit_others');

		$result = $this->others_model->getOthersBy_ID($id);
		//print_r($result);
		//die;

		if($this->input->post('edit_others')){		

			$this->form_validation->set_rules('name', lang("name"), 'required');

        if ($this->form_validation->run() == true) {

			$data = array(
				'name' => $this->input->post('name'),
				'khmer_name' => $this->input->post('khmer_name'),
				'updated_on' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->userdata('user_id'),            
			);
			
			} elseif ($this->input->post('edit_others')) {
				$this->session->set_flashdata('error', validation_errors());
				admin_redirect("others/edit_others/".$id);
			}
		}

        if ($this->form_validation->run() == true && $this->others_model->update_others($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("others_updated"));
            admin_redirect("others/index");
        } else {
			
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));		

			//print_r($this->data['reporter']);die;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('others/index'), 'page' => lang('others')), array('link' => '#', 'page' => lang('edit_others')));
			
            $meta = array('page_title' => lang('edit_others'), 'bc' => $bc);
			$this->data['result'] = $result;
            $this->data['id'] = $id;
			$this->page_construct('others/edit', $meta, $this->data);
        }
	}
	
	function others_status($status,$id){		

		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'others_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->others_model->update_others_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
	}
	

	function delete($id){		

		$this->site->webPermission($this->session->userdata('user_id'), 'others', 'delete');
		$data['is_delete'] = 1;
		
		$this->others_model->delete_update($data,$id);
		$this->session->set_flashdata('message', lang("others_deleted"));
		redirect($_SERVER["HTTP_REFERER"]);
	}

}
