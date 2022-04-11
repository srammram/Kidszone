<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->admin_load('auth', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->load->admin_model('auth_model');
        $this->load->library('ion_auth');
    }

    function index()
    {

        if (!$this->loggedIn) {
            admin_redirect('login');
        } else {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    function privacy_policy()
    {
		$this->load->view($this->theme . 'pages/privacy_policy', $this->data);
    }
	
    function terms_conditions()
    {
		$this->load->view($this->theme . 'pages/terms_conditions', $this->data);
    }


}
