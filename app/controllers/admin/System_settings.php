<?php defined('BASEPATH') OR exit('No direct script access allowed');

class system_settings extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }

        if (!$this->Owner) {
            //$this->session->set_flashdata('warning', lang('access_denied'));
            //redirect('admin');
        }
        $this->lang->admin_load('settings', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->admin_model('settings_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
        $this->data['menu'] = $this->site->menuList();
    }

    function index()
    {
        $this->load->library('gst');
        $this->form_validation->set_rules('site_name', lang('site_name'), 'trim|required');
        $this->form_validation->set_rules('dateformat', lang('dateformat'), 'trim|required');
        $this->form_validation->set_rules('timezone', lang('timezone'), 'trim|required');
        $this->form_validation->set_rules('mmode', lang('maintenance_mode'), 'trim|required');
        //$this->form_validation->set_rules('logo', lang('logo'), 'trim');
        $this->form_validation->set_rules('iwidth', lang('image_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('iheight', lang('image_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('twidth', lang('thumbnail_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('theight', lang('thumbnail_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('display_all_products', lang('display_all_products'), 'trim|numeric|required');
        $this->form_validation->set_rules('watermark', lang('watermark'), 'trim|required');
        $this->form_validation->set_rules('currency', lang('default_currency'), 'trim|required');
        $this->form_validation->set_rules('email', lang('default_email'), 'trim|required');
        $this->form_validation->set_rules('language', lang('language'), 'trim|required');
        $this->form_validation->set_rules('warehouse', lang('default_warehouse'), 'trim|required');
        $this->form_validation->set_rules('biller', lang('default_biller'), 'trim|required');
        $this->form_validation->set_rules('tax_rate', lang('product_tax'), 'trim|required');
        $this->form_validation->set_rules('tax_rate2', lang('invoice_tax'), 'trim|required');
        $this->form_validation->set_rules('sales_prefix', lang('sales_prefix'), 'trim');
        $this->form_validation->set_rules('quote_prefix', lang('quote_prefix'), 'trim');
        $this->form_validation->set_rules('purchase_prefix', lang('purchase_prefix'), 'trim');
        $this->form_validation->set_rules('transfer_prefix', lang('transfer_prefix'), 'trim');
        $this->form_validation->set_rules('delivery_prefix', lang('delivery_prefix'), 'trim');
        $this->form_validation->set_rules('payment_prefix', lang('payment_prefix'), 'trim');
        $this->form_validation->set_rules('return_prefix', lang('return_prefix'), 'trim');
        $this->form_validation->set_rules('expense_prefix', lang('expense_prefix'), 'trim');
        $this->form_validation->set_rules('detect_barcode', lang('detect_barcode'), 'trim|required');
        $this->form_validation->set_rules('theme', lang('theme'), 'trim|required');
        $this->form_validation->set_rules('rows_per_page', lang('rows_per_page'), 'trim|required|greater_than[9]|less_than[501]');
        $this->form_validation->set_rules('accounting_method', lang('accounting_method'), 'trim|required');
        $this->form_validation->set_rules('product_serial', lang('product_serial'), 'trim|required');
        $this->form_validation->set_rules('product_discount', lang('product_discount'), 'trim|required');
        $this->form_validation->set_rules('bc_fix', lang('bc_fix'), 'trim|numeric|required');
        $this->form_validation->set_rules('protocol', lang('email_protocol'), 'trim|required');
	$this->form_validation->set_rules('backup_path', lang('backup_path'), 'trim|required');
        if ($this->input->post('protocol') == 'smtp') {
            $this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
            $this->form_validation->set_rules('smtp_user', lang('smtp_user'), 'required');
            $this->form_validation->set_rules('smtp_pass', lang('smtp_pass'), 'required');
            $this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
        }
        if ($this->input->post('protocol') == 'sendmail') {
            $this->form_validation->set_rules('mailpath', lang('mailpath'), 'required');
        }
        $this->form_validation->set_rules('decimals', lang('decimals'), 'trim|required');
        $this->form_validation->set_rules('decimals_sep', lang('decimals_sep'), 'trim|required');
        $this->form_validation->set_rules('thousands_sep', lang('thousands_sep'), 'trim|required');
        if ($this->Settings->indian_gst) {
            $this->form_validation->set_rules('state', lang('state'), 'trim|required');
        }

        if ($this->form_validation->run() == true) {

            $language = $this->input->post('language');

            if ((file_exists(APPPATH.'language'.DIRECTORY_SEPARATOR.$language.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'sma_lang.php') && is_dir(APPPATH.DIRECTORY_SEPARATOR.'language'.DIRECTORY_SEPARATOR.$language)) || $language == 'english') {
                $lang = $language;
            } else {
                $this->session->set_flashdata('error', lang('language_x_found'));
                admin_redirect("system_settings");
                $lang = 'english';
            }

            $tax1 = ($this->input->post('tax_rate') != 0) ? 1 : 0;
            $tax2 = ($this->input->post('tax_rate2') != 0) ? 1 : 0;
			
			$timezone = explode(',', $this->input->post('timezone'));
			
            $data = array('site_name' => DEMO ? 'SRAM POS' : $this->input->post('site_name'),
				'qsr' => $this->input->post('qsr') ? $this->input->post('qsr') : 0,
                'rows_per_page' => $this->input->post('rows_per_page'),
                'dateformat' => $this->input->post('dateformat'),
                'time_format' => $this->input->post('time_format'),
                'timezone' => DEMO ? 'Asia/Kuala_Lumpur' : $timezone[0],
				 'timezone_gmt' => DEMO ? 'GMT+08:00' : $timezone[1],
                'mmode' => trim($this->input->post('mmode')),
                'iwidth' => $this->input->post('iwidth'),
                'iheight' => $this->input->post('iheight'),
                'twidth' => $this->input->post('twidth'),
                'theight' => $this->input->post('theight'),
                'watermark' => $this->input->post('watermark'),
                'procurment' => $this->input->post('procurment'),
                // 'allow_reg' => $this->input->post('allow_reg'),
                // 'reg_notification' => $this->input->post('reg_notification'),
                'accounting_method' => $this->input->post('accounting_method'),
                'default_email' => DEMO ? 'info@srampos.com' : $this->input->post('email'),
                'language' => $lang,
                'default_warehouse' => $this->input->post('warehouse'),
                'default_tax_rate' => $this->input->post('tax_rate'),
                'default_tax_rate2' => $this->input->post('tax_rate2'),
                'sales_prefix' => $this->input->post('sales_prefix'),
                'quote_prefix' => $this->input->post('quote_prefix'),
                'purchase_prefix' => $this->input->post('purchase_prefix'),
                'transfer_prefix' => $this->input->post('transfer_prefix'),
                'delivery_prefix' => $this->input->post('delivery_prefix'),
                'payment_prefix' => $this->input->post('payment_prefix'),
                'ppayment_prefix' => $this->input->post('ppayment_prefix'),
                'qa_prefix' => $this->input->post('qa_prefix'),
                'return_prefix' => $this->input->post('return_prefix'),
                'returnp_prefix' => $this->input->post('returnp_prefix'),
                'expense_prefix' => $this->input->post('expense_prefix'),
                'auto_detect_barcode' => trim($this->input->post('detect_barcode')),
                'theme' => trim($this->input->post('theme')),
                'product_serial' => $this->input->post('product_serial'),
                'customer_group' => $this->input->post('customer_group'),
                'product_expiry' => $this->input->post('product_expiry'),
                'product_discount' => $this->input->post('product_discount'),
                'default_currency' => $this->input->post('currency'),
                'bc_fix' => $this->input->post('bc_fix'),
                'tax1' => $tax1,
                'tax2' => $tax2,
                'overselling' => $this->input->post('restrict_sale'),
                'reference_format' => $this->input->post('reference_format'),
                'racks' => $this->input->post('racks'),
                'attributes' => $this->input->post('attributes'),
                'restrict_calendar' => $this->input->post('restrict_calendar'),
                'captcha' => $this->input->post('captcha'),
                'item_addition' => $this->input->post('item_addition'),
                'protocol' => DEMO ? 'mail' : $this->input->post('protocol'),
                'mailpath' => $this->input->post('mailpath'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_port' => $this->input->post('smtp_port'),
                'smtp_crypto' => $this->input->post('smtp_crypto') ? $this->input->post('smtp_crypto') : NULL,
                'decimals' => $this->input->post('decimals'),
                'exchange_decimals' => $this->input->post('exchange_decimals'),
                'decimals_sep' => $this->input->post('decimals_sep'),
                'thousands_sep' => $this->input->post('thousands_sep'),
                'default_biller' => $this->input->post('biller'),
                'invoice_view' => $this->input->post('invoice_view'),
                'rtl' => $this->input->post('rtl'),
                'each_spent' => $this->input->post('each_spent') ? $this->input->post('each_spent') : NULL,
                'ca_point' => $this->input->post('ca_point') ? $this->input->post('ca_point') : NULL,
                'each_sale' => $this->input->post('each_sale') ? $this->input->post('each_sale') : NULL,
                'sa_point' => $this->input->post('sa_point') ? $this->input->post('sa_point') : NULL,
                'sac' => $this->input->post('sac'),
                'qty_decimals' => $this->input->post('qty_decimals'),
                'display_all_products' => $this->input->post('display_all_products'),
                'display_symbol' => $this->input->post('display_symbol'),
                'symbol' => $this->input->post('symbol'),
                'remove_expired' => $this->input->post('remove_expired'),
                'barcode_separator' => $this->input->post('barcode_separator'),
                'set_focus' => $this->input->post('set_focus'),
                'disable_editing' => $this->input->post('disable_editing'),
                'price_group' => $this->input->post('price_group'),
                'barcode_img' => $this->input->post('barcode_renderer'),
                'update_cost' => $this->input->post('update_cost'),
                'apis' => $this->input->post('apis'),
                'pdf_lib' => $this->input->post('pdf_lib'),
                'dine_in' => $this->input->post('dine_in'),
                'take_away' => $this->input->post('take_away'),
                'door_delivery' => $this->input->post('door_delivery'),
				'first_level' => $this->input->post('first_level'),
				'second_level' => $this->input->post('second_level'),
                'state' => $this->input->post('state'),
                'customer_discount_request' => $this->input->post('customer_discount_request'),
                'nagative_stock_production' => $this->input->post('nagative_stock_production'),
                'nagative_stock_sale' => $this->input->post('nagative_stock_sale'),
                'excel_header_color' => $this->input->post('excel_header_color'),
                'excel_footer_color' => $this->input->post('excel_footer_color'),
                'billnumber_reset' => $this->input->post('billnumber_reset'),
                'recipe_time_management' => $this->input->post('recipe_time_management'),
                'default_preparation_time' => $this->input->post('default_preparation_time'),
                'night_audit_rights' => $this->input->post('night_audit_rights'),
		'bill_number_start_from' => $this->input->post('bill_number_start_from'),
		'enable_qrcode' => $this->input->post('enable_qrcode'),
		'enable_barcode' => $this->input->post('enable_barcode'),
        'customer_discount' => $this->input->post('customer_discount'),
		'manual_item_discount' => $this->input->post('manual_item_discount'),
		'bbq_enable' => $this->input->post('bbq_enable'),
		'bbq_discount' => $this->input->post('bbq_discount'),
		'bbq_adult_price' => $this->input->post('bbq_enable') ? $this->input->post('bbq_adult_price') : '0',
		'bbq_child_price' => $this->input->post('bbq_enable') ? $this->input->post('bbq_child_price') : '0',
		'bbq_kids_price' => $this->input->post('bbq_enable') ? $this->input->post('bbq_kids_price') : '0',
		'bbq_display_items' => $this->input->post('bbq_display_items') ? $this->input->post('bbq_display_items') : '0',
		'order_request_stewardapp' => $this->input->post('order_request_stewardapp') ? $this->input->post('order_request_stewardapp') : 0,
        'discount_request_customer_app' => $this->input->post('discount_request_customer_app') ? $this->input->post('discount_request_customer_app') : 0,
		
		'fb_app_id' => $this->input->post('fb_app_id') ? $this->input->post('fb_app_id') : '0',
		'fb_secret_token' => $this->input->post('fb_secret_token') ? $this->input->post('fb_secret_token') : '0',
		'fb_page_access_token' => $this->input->post('fb_page_access_token') ? $this->input->post('fb_page_access_token') : '0',
		'fb_page_id' => $this->input->post('fb_page_id') ? $this->input->post('fb_page_id') : '0',
		'recipe_time_management' => $this->input->post('recipe_time_management'),
                'notification_time_interval' => $this->input->post('notification_time_interval'),
		'socket_port' => $this->input->post('socket_port'),
		'socket_host' => $this->input->post('socket_host'),
		'socket_enable' => $this->input->post('socket_enable'),
		'backup_path' => $this->input->post('backup_path'),
		'bbq_covers_limit' => $this->input->post('bbq_covers_limit'),
		'ftp_instance_name'=>$this->input->post('ftp_instance_name'),
		'ftp_autobackup_enable' => $this->input->post('ftp_autobackup_enable'),
		'bbq_notify_no_of_times' => $this->input->post('bbq_notify_no_of_times'),
		'bbq_return_notify_no_of_times' => $this->input->post('bbq_return_notify_no_of_times'),
		'bill_request_notify_no_of_times' => $this->input->post('bill_request_notify_no_of_times'),
		'financial_yr_from'=>$this->input->post('financial_yr_from'),
		'financial_yr_to' => $this->input->post('financial_yr_to'),
                'supply_chain' => $this->input->post('supply_chain'),
		'transaction_date' => $this->input->post('transaction_date'),
        'special_item_enable' => $this->input->post('special_item_enable'),
	'store_type' => $this->input->post('store_type'),
	
	'login_warehouse_required' => $this->input->post('login_warehouse_required'),
	'login_group_required' => $this->input->post('login_group_required'),
	'rough_tender' => $this->input->post('rough_tender')
		
		);
            file_put_contents('themes\default\admin\assets\js\socket\socket_configuration.js','var socket_port='.$data['socket_port'].';var socket_host="'.$data['socket_host'].'";var socket_enable="'.$data['socket_enable'].'";');
            if ($this->input->post('smtp_pass')) {
                $data['smtp_pass'] = $this->input->post('smtp_pass');
            }
	  
	    $this->site->update_cur_transaction_date($_POST['today_transaction_date']);
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateSetting($data)) {
	    
	    $ftp_data['ftp_db_backup_path'] = 'srampos/'.$this->input->post('ftp_instance_name').'/database';
	    $ftp_data['ftp_files_backup_path'] = 'srampos/'.$this->input->post('ftp_instance_name').'/files';
	    $this->site->update_ftpbackup($ftp_data);
            if ( ! DEMO && TIMEZONE != $data['timezone']) {
                if ( ! $this->write_index($data['timezone'])) {
                    $this->session->set_flashdata('error', lang('setting_updated_timezone_failed'));
                    admin_redirect('system_settings');
                }
            }

            $this->session->set_flashdata('message', lang('setting_updated'));
            admin_redirect("system_settings");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('system_settings')));
            $meta = array('page_title' => lang('system_settings'), 'bc' => $bc);
            $this->page_construct('settings/index', $meta, $this->data);
        }
    }
	
	
    public function write_index($timezone)
    {

        $template_path = './assets/config_dumps/index.php';
        $output_path = SELF;
        $index_file = file_get_contents($template_path);
        $new = str_replace("%TIMEZONE%", $timezone, $index_file);
        $handle = fopen($output_path, 'w+');
        @chmod($output_path, 0777);

        if (is_writable($output_path)) {
            if (fwrite($handle, $new)) {
                @chmod($output_path, 0644);
                return true;
            } else {
                @chmod($output_path, 0644);
                return false;
            }
        } else {
            @chmod($output_path, 0644);
            return false;
        }
    }

    function updates()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            admin_redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('srampos_username', lang("srampos_username"), 'required');
        if ($this->form_validation->run() == true) {
            $this->db->update('settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'srampos_username' => $this->input->post('srampos_username', TRUE)), array('setting_id' => 1));
            admin_redirect('system_settings/updates');
        } else {
            $fields = array('version' => $this->Settings->version, 'code' => $this->Settings->purchase_code, 'username' => $this->Settings->srampos_username, 'site' => base_url());
            $this->load->helper('update');
            $protocol = is_https() ? 'https://' : 'http://';
            $updates = get_remote_contents($protocol.'api.srampos.com/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('updates')));
            $meta = array('page_title' => lang('updates'), 'bc' => $bc);
            $this->page_construct('settings/updates', $meta, $this->data);
        }
    }

    function install_update($file, $m_version, $version)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            admin_redirect("welcome");
        }
        $this->load->helper('update');
        save_remote_file($file . '.zip');
        $this->sma->unzip('./files/updates/' . $file . '.zip');
        if ($m_version) {
            $this->load->library('migration');
            if (!$this->migration->latest()) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                admin_redirect("system_settings/updates");
            }
        }
        $this->db->update('settings', array('version' => $version, 'update' => 0), array('setting_id' => 1));
        unlink('./files/updates/' . $file . '.zip');
        $this->session->set_flashdata('success', lang('update_done'));
        admin_redirect("system_settings/updates");
    }

    function backups()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
		$this->sma->checkPermissions();
        
        $this->data['files'] = glob('./files/backups/*.zip', GLOB_BRACE);
        $this->data['dbs'] = glob('./files/backups/*.txt', GLOB_BRACE);
        krsort($this->data['files']); krsort($this->data['dbs']);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('backups')));
        $meta = array('page_title' => lang('backups'), 'bc' => $bc);
        $this->page_construct('settings/backups', $meta, $this->data);
    }

    function backup_database()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
	$this->sma->checkPermissions();
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt',
            'filename' => 'sma_db_backup.sql'
        );
        $back = $this->dbutil->backup($prefs);
        $backup =& $back;
        $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s") . '.txt';
        $save = './files/backups/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->session->set_flashdata('messgae', lang('db_saved'));
        admin_redirect("system_settings/backups");
    }

    function backup_files()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
	$this->sma->checkPermissions();
        $name = 'file-backup-' . date("Y-m-d-H-i-s");
        $this->sma->zip("./", './files/backups/', $name);
        $this->session->set_flashdata('messgae', lang('backup_saved'));
        admin_redirect("system_settings/backups");
        exit();
    }

    function restore_database($dbfile)
    {
	$this->sma->checkPermissions();
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
	$this->sma->checkPermissions();
        $file = file_get_contents('./files/backups/' . $dbfile . '.txt');
        // $this->db->conn_id->multi_query($file);
        mysqli_multi_query($this->db->conn_id, $file);
        $this->db->conn_id->close();
        admin_redirect('logout/db');
    }

    function download_database($dbfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
           // $this->session->set_flashdata('error', lang('access_denied'));
           // admin_redirect("welcome");
        }
	$this->sma->checkPermissions();
        $this->load->library('zip');
        $this->zip->read_file('./files/backups/' . $dbfile . '.txt');
        $name = $dbfile . '.zip';
        $this->zip->download($name);
        exit();
    }

    function download_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
	$this->sma->checkPermissions();
        $this->load->helper('download');
        force_download('./files/backups/' . $zipfile . '.zip', NULL);
        exit();
    }

    function restore_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            admin_redirect("welcome");
        }
        $file = './files/backups/' . $zipfile . '.zip';
        $this->sma->unzip($file, './');
        $this->session->set_flashdata('success', lang('files_restored'));
        admin_redirect("system_settings/backups");
        exit();
    }

    function delete_database($dbfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            //$this->session->set_flashdata('error', lang('access_denied'));
            //admin_redirect("welcome");
        }
		$this->sma->checkPermissions();
        unlink('./files/backups/' . $dbfile . '.txt');
        $this->session->set_flashdata('messgae', lang('db_deleted'));
        admin_redirect("system_settings/backups");
    }

    function delete_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            admin_redirect("welcome");
        }
        unlink('./files/backups/' . $zipfile . '.zip');
        $this->session->set_flashdata('messgae', lang('backup_deleted'));
        admin_redirect("system_settings/backups");
    }

    function email_templates($template = "credentials")
    {
		$this->sma->checkPermissions();
        $this->form_validation->set_rules('mail_body', lang('mail_message'), 'trim|required');
        $this->load->helper('file');
        $temp_path = is_dir('./themes/' . $this->theme . 'email_templates/');
        $theme = $temp_path ? $this->theme : 'default';
        if ($this->form_validation->run() == true) {
            $data = $_POST["mail_body"];
            if (write_file('./themes/' . $this->theme . 'email_templates/' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', lang('message_successfully_saved'));
                admin_redirect('system_settings/email_templates#' . $template);
            } else {
                $this->session->set_flashdata('error', lang('failed_to_save_message'));
                admin_redirect('system_settings/email_templates#' . $template);
            }
        } else {

            $this->data['credentials'] = file_get_contents('./themes/' . $this->theme . 'email_templates/credentials.html');
            $this->data['sale'] = file_get_contents('./themes/' . $this->theme . 'email_templates/sale.html');
            $this->data['quote'] = file_get_contents('./themes/' . $this->theme . 'email_templates/quote.html');
            $this->data['purchase'] = file_get_contents('./themes/' . $this->theme . 'email_templates/purchase.html');
            $this->data['transfer'] = file_get_contents('./themes/' . $this->theme . 'email_templates/transfer.html');
            $this->data['payment'] = file_get_contents('./themes/' . $this->theme . 'email_templates/payment.html');
            $this->data['forgot_password'] = file_get_contents('./themes/' . $this->theme . 'email_templates/forgot_password.html');
            $this->data['activate_email'] = file_get_contents('./themes/' . $this->theme . 'email_templates/activate_email.html');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('email_templates')));
            $meta = array('page_title' => lang('email_templates'), 'bc' => $bc);
            $this->page_construct('settings/email_templates', $meta, $this->data);
        }
    }

    
    function permissions($id = NULL,$user_id =null)
    {
        
        $this->form_validation->set_rules('group', lang("group"), 'is_natural_no_zero');
        if ($this->form_validation->run() == true) {

            $data = array(
                'products-index' => $this->input->post('products-index'),
                'products-edit' => $this->input->post('products-edit'),
                'products-add' => $this->input->post('products-add'),
                'products-delete' => $this->input->post('products-delete'),
                'products-cost' => $this->input->post('products-cost'),
                'products-price' => $this->input->post('products-price'),
                'customers-index' => $this->input->post('customers-index'),
                'customers-edit' => $this->input->post('customers-edit'),
                'customers-add' => $this->input->post('customers-add'),
                'customers-delete' => $this->input->post('customers-delete'),
                'suppliers-index' => $this->input->post('suppliers-index'),
                'suppliers-edit' => $this->input->post('suppliers-edit'),
                'suppliers-add' => $this->input->post('suppliers-add'),
                'suppliers-delete' => $this->input->post('suppliers-delete'),
                'sales-index' => $this->input->post('sales-index'),
                'sales-edit' => $this->input->post('sales-edit'),
                'sales-add' => $this->input->post('sales-add'),
                'sales-delete' => $this->input->post('sales-delete'),
                'sales-email' => $this->input->post('sales-email'),
                'sales-pdf' => $this->input->post('sales-pdf'),
                'sales-deliveries' => $this->input->post('sales-deliveries'),
                'sales-edit_delivery' => $this->input->post('sales-edit_delivery'),
                'sales-add_delivery' => $this->input->post('sales-add_delivery'),
                'sales-delete_delivery' => $this->input->post('sales-delete_delivery'),
                'sales-email_delivery' => $this->input->post('sales-email_delivery'),
                'sales-pdf_delivery' => $this->input->post('sales-pdf_delivery'),
                'sales-gift_cards' => $this->input->post('sales-gift_cards'),
                'sales-edit_gift_card' => $this->input->post('sales-edit_gift_card'),
                'sales-add_gift_card' => $this->input->post('sales-add_gift_card'),
                'sales-delete_gift_card' => $this->input->post('sales-delete_gift_card'),
                'quotes-index' => $this->input->post('quotes-index'),
                'quotes-edit' => $this->input->post('quotes-edit'),
                'quotes-add' => $this->input->post('quotes-add'),
                'quotes-delete' => $this->input->post('quotes-delete'),
                'quotes-email' => $this->input->post('quotes-email'),
                'quotes-pdf' => $this->input->post('quotes-pdf'),
                'purchases-index' => $this->input->post('purchases-index'),
                'purchases-edit' => $this->input->post('purchases-edit'),
                'purchases-add' => $this->input->post('purchases-add'),
                'purchases-delete' => $this->input->post('purchases-delete'),
                'purchases-email' => $this->input->post('purchases-email'),
                'purchases-pdf' => $this->input->post('purchases-pdf'),
				
				'purchases_order-index' => $this->input->post('purchases_order-index'),
                'purchases_order-edit' => $this->input->post('purchases_order-edit'),
                'purchases_order-add' => $this->input->post('purchases_order-add'),
                'purchases_order-delete' => $this->input->post('purchases_order-delete'),
                'purchases_order-email' => $this->input->post('hases_order-email'),
                'purchases_order-pdf' => $this->input->post('purchases_order-pdf'),
				
                'transfers-index' => $this->input->post('transfers-index'),
                'transfers-edit' => $this->input->post('transfers-edit'),
                'transfers-add' => $this->input->post('transfers-add'),
                'transfers-delete' => $this->input->post('transfers-delete'),
                'transfers-email' => $this->input->post('transfers-email'),
                'transfers-pdf' => $this->input->post('transfers-pdf'),
                'sales-return_sales' => $this->input->post('sales-return_sales'),
                
                'sales-payments' => $this->input->post('sales-payments'),
                'purchases-payments' => $this->input->post('purchases-payments'),
                'purchases-expenses' => $this->input->post('purchases-expenses'),
				
				'purchases-order-payments' => $this->input->post('purchases-order-payments'),
                'purchases-order-expenses' => $this->input->post('purchases-order-expenses'),
				
                'products-adjustments' => $this->input->post('products-adjustments'),
                'bulk_actions' => $this->input->post('bulk_actions'),
                'customers-deposits' => $this->input->post('customers-deposits'),
                'customers-delete_deposit' => $this->input->post('customers-delete_deposit'),
                'products-barcode' => $this->input->post('products-barcode'),
                'purchases-return_purchases' => $this->input->post('purchases-return_purchases'),
				
				'purchases-order-return' => $this->input->post('purchases-order-return'),
				
                
                'products-stock_count' => $this->input->post('products-stock_count'),
                'edit_price' => $this->input->post('edit_price'),
				
				 'pos-dinein' => $this->input->post('pos-dinein'),
				 'pos-takeaway' => $this->input->post('pos-takeaway'),
				 'pos-door_delivery' => $this->input->post('pos-door_delivery'),
				 'pos-orders' => $this->input->post('pos-orders'),
				 'pos-kitchens' => $this->input->post('pos-kitchens'),
				 'pos-billing' => $this->input->post('pos-billing'),
				 'pos-table_view' => $this->input->post('pos-table_view'),
				 'pos-table_add' => $this->input->post('pos-table_add'),
				 'pos-table_edit' => $this->input->post('pos-table_edit'),
				 'pos-quantity_edit' => $this->input->post('pos-quantity_edit'),
				 'pos-orders_cancel' => $this->input->post('pos-orders_cancel'),
				 'pos-sendtokitchen' => $this->input->post('pos-sendtokitchen'),
				 'pos-dinein_orders' => $this->input->post('pos-dinein_orders'),
				 'pos-takeaway_orders' => $this->input->post('pos-takeaway_orders'),
				 'pos-door_delivery_orders' => $this->input->post('pos-door_delivery_orders'),
				 'pos-change_single_status' => $this->input->post('pos-change_single_status'),
				 'pos-change_multiple_status' => $this->input->post('pos-change_multiple_status'),
				 'pos-cancel_order_items' => $this->input->post('pos-cancel_order_items'),
				 'pos-new_order_create' => $this->input->post('pos-new_order_create'),
				 'pos-new_split_create' => $this->input->post('pos-new_split_create'),
				 'pos-bil_generator' => $this->input->post('pos-bil_generator'),
                 'pos-app_bil_generator' => $this->input->post('pos-app_bil_generator'),                 
				 'pos-auto_bil' => $this->input->post('pos-auto_bil'),
				 'pos-no_discount' => $this->input->post('pos-no_discount'),
				 'pos-no_tax' => $this->input->post('pos-no_tax'),
				 'pos-kitchen_view' => $this->input->post('pos-kitchen_view'),
				 'pos-kitchen_change_single_status' => $this->input->post('pos-kitchen_change_single_status'),
				 'pos-kitchen_change_multiple_status' => $this->input->post('pos-kitchen_change_multiple_status'),
				 'pos-kitchen_cancel_order_items' => $this->input->post('pos-kitchen_cancel_order_items'),
				 'pos-kot_print' => $this->input->post('pos-kot_print'),
				 'pos-dinein_bils' => $this->input->post('pos-dinein_bils'),
				 'pos-takeaway_bils' => $this->input->post('pos-takeaway_bils'),
				 'pos-door_delivery_bils' => $this->input->post('pos-door_delivery_bils'),
				 'pos-bil_cancel' => $this->input->post('pos-bil_cancel'),
				 'pos-bil_payment' => $this->input->post('pos-bil_payment'),
				 'pos-bil_print' => $this->input->post('pos-bil_print'),
				 'pos-report_view' => $this->input->post('pos-report_view'),
				 'pos-today_item_report' => $this->input->post('pos-today_item_report'),
				 'pos-daywise_report' => $this->input->post('pos-daywise_report'),
				 'pos-cashierwise_report' => $this->input->post('pos-cashierwise_report'),
                 'pos-shifttime_report' => $this->input->post('pos-shifttime_report'),
                 'pos-open_sale_register' => $this->input->post('pos-open_sale_register'),

                 'pos-reprint' => $this->input->post('pos-reprint'),
                 'pos-hold_sales' => $this->input->post('pos-hold_sales'),
                 'pos-cancel_sales' => $this->input->post('pos-cancel_sales'),
                 'pos-resettle_sales' => $this->input->post('pos-resettle_sales'),
                 'pos-qsr_bill_print' => $this->input->post('pos-qsr_bill_print'),
				/*'pos-waiter' => $this->input->post('pos-waiter'),
				'pos-kitchen' => $this->input->post('pos-kitchen'),
				'pos-cashier' => $this->input->post('pos-cashier'),
				'pos-report' => $this->input->post('pos-report'),*/
                'nightaudit-index' => $this->input->post('nightaudit-index'),
                'nightaudit-edit' => $this->input->post('nightaudit-edit'),
                'nightaudit-add' => $this->input->post('nightaudit-add'),
                'nightaudit-delete' => $this->input->post('nightaudit-delete'),
                'nightaudit-pdf' => $this->input->post('nightaudit-pdf'),
                'blind_night_audit' => $this->input->post('blind_night_audit'),
               
                'recipe-index' => $this->input->post('recipe-index'),
                'recipe-edit' => $this->input->post('recipe-edit'),
                'recipe-add' => $this->input->post('recipe-add'),
                'recipe-delete' => $this->input->post('recipe-delete'),
                'recipe-csv' => $this->input->post('recipe-csv'),
                
                'reports-warehouse_stock' => $this->input->post('reports-warehouse_stock'),
                'reports-quantity_alerts' => $this->input->post('reports-quantity_alerts'),
                'reports-expiry_alerts' => $this->input->post('reports-expiry_alerts'),
                'reports-products' => $this->input->post('reports-products'),
                'reports-daily_sales' => $this->input->post('reports-daily_sales'),
                'reports-monthly_sales' => $this->input->post('reports-monthly_sales'),
                'reports-sales' => $this->input->post('reports-sales'),
                'reports-payments' => $this->input->post('reports-payments'),
                'reports-expenses' => $this->input->post('reports-expenses'),
                'reports-daily_purchases' => $this->input->post('reports-daily_purchases'),
                'reports-monthly_purchases' => $this->input->post('reports-monthly_purchases'),
                'reports-purchases' => $this->input->post('reports-purchases'),	
                'reports-customers' => $this->input->post('reports-customers'),
                'reports-suppliers' => $this->input->post('reports-suppliers'),
                'reports-users' => $this->input->post('reports-users'),
                'reports-profit_loss' => $this->input->post('reports-profit_loss'),
		        'reports-brands' => $this->input->post('reports-brands'),
                'reports-categories' => $this->input->post('reports-categories'),
                'reports-adjustments' => $this->input->post('reports-adjustments'),
                'reports-stock_audit' => $this->input->post('reports-stock_audit'),
                'reports-cover_analysis' => $this->input->post('reports-cover_analysis'),
                
                
                'reports-tax_reports' => $this->input->post('reports-tax_reports'),
                'reports-best_sellers' => $this->input->post('reports-best_sellers'),
                'reports-recipe' => $this->input->post('reports-recipe'),
                'reports-pos_settlement' => $this->input->post('reports-pos_settlement'),
                'reports-kot_details' => $this->input->post('reports-kot_details'),
                'reports-user_reports' => $this->input->post('reports-user_reports'),
                'reports-home_delivery' => $this->input->post('reports-home_delivery'),
                'reports-take_away' => $this->input->post('reports-take_away'),
                'reports-bill_details' => $this->input->post('reports-bill_details'),
                
                'reports-hourly_wise' => $this->input->post('reports-hourly_wise'),
                'reports-discount_summary' => $this->input->post('reports-discount_summary'),
                'reports-void_bills' => $this->input->post('reports-void_bills'),
                'reports-popular_analysis' => $this->input->post('reports-popular_analysis'),
                
		        'reports-purchases-order' => $this->input->post('reports-purchases-order'),   
                'reports-postpaid_bills' => $this->input->post('reports-postpaid_bills'), 

                'reports-modify_bills' => $this->input->post('reports-modify_bills'), 
                'reports-restore_bills' => $this->input->post('reports-restore_bills'), 
                'reports-auto_modify_bills' => $this->input->post('reports-auto_modify_bills'), 
                'reports-items_mapping_for_modify_bills' => $this->input->post('reports-items_mapping_for_modify_bills'), 
                'reports-monthly_reports' => $this->input->post('reports-monthly_reports'), 
                
                'products-import_csv' => $this->input->post('products-import_csv'),
                
                
                'production-index' => $this->input->post('production-index'),
                'production-add' => $this->input->post('production-add'),
                'production-edit' => $this->input->post('production-edit'),
                'production-delete' => $this->input->post('production-delete'),
                'production-balance' => $this->input->post('production-balance'),
                'production-balance_edit' => $this->input->post('production-balance_edit'),
                
                
                'saleitem_to_purchasesitem-index' => $this->input->post('saleitem_to_purchasesitem-index'),
                
                'tables-index' => $this->input->post('tables-index'),
                'tables-add' => $this->input->post('tables-add'),
                'tables-edit' => $this->input->post('tables-edit'),
                'tables-delete' => $this->input->post('tables-delete'),
                
                'tables-kitchens' => $this->input->post('tables-kitchens'),
                'tables-add_kitchen' => $this->input->post('tables-add_kitchen'),
                'tables-edit_kitchen' => $this->input->post('tables-edit_kitchen'),
                'tables-delete_kitchen' => $this->input->post('tables-delete_kitchen'),
                
                'tables-areas' => $this->input->post('tables-areas'),
                'tables-add_area' => $this->input->post('tables-add_area'),
                'tables-edit_area' => $this->input->post('tables-edit_area'),
                'tables-delete_area' => $this->input->post('tables-delete_area'),
                
                'system_settings-warehouses' => $this->input->post('system_settings-warehouses'),
                'system_settings-add_warehouse' => $this->input->post('system_settings-add_warehouse'),
                'system_settings-edit_warehouse' => $this->input->post('system_settings-edit_warehouse'),
                'system_settings-delete_warehouse' => $this->input->post('system_settings-delete_warehouse'),

                'system_settings_categories' => $this->input->post('system_settings_categories'),
                'system_settings_categories_add' => $this->input->post('system_settings_categories_add'),
                'system_settings_categories_edit' => $this->input->post('system_settings_categories_edit'),
                'system_settings_categories_delete' => $this->input->post('system_settings_categories_delete'),
                
                'material_request-index' => $this->input->post('material_request-index'),
                'material_request-add' => $this->input->post('material_request-add'),
                'material_request-edit' => $this->input->post('material_request-edit'),
                'material_request-delete' => $this->input->post('material_request-delete'),

                'system_settings-bbq_menu' => $this->input->post('system_settings-bbq_menu'),
                'system_settings-add_bbq_menu' => $this->input->post('system_settings-add_bbq_menu'),
                'system_settings-edit_bbq_menu' => $this->input->post('system_settings-edit_bbq_menu'),
                'system_settings-delete_bbq_menu' => $this->input->post('system_settings-delete_bbq_menu'),
                
                'auth-users' => $this->input->post('auth-users'),
                'auth-create_user' => $this->input->post('auth-create_user'),
                'auth-profile' => $this->input->post('auth-profile'),
                'auth-delete' => $this->input->post('auth-delete'),
                'auth-excel' => $this->input->post('auth-excel'),
                
                'billers-index' => $this->input->post('billers-index'),
                'billers-add' => $this->input->post('billers-add'),
                'billers-edit' => $this->input->post('billers-edit'),
                'billers-delete' => $this->input->post('billers-delete'),
                'billers-excel' => $this->input->post('billers-excel'),
                'pos-cancel_order_remarks' => $this->input->post('pos-cancel_order_remarks'),
                'pos-view_allusers_orders' => $this->input->post('pos-view_allusers_orders'),
                'pos-add_printer'=>$this->input->post('pos-add_printer'),
		'pos-edit_printer'=>$this->input->post('pos-edit_printer'),
		'pos-printers'=>$this->input->post('pos-printers'),
		'pos-delete_printer'=>$this->input->post('pos-delete_printer'),
		
		
		'system_settings-payment_methods'=>$this->input->post('system_settings-payment_methods'),
		'system_settings-add_payment_method'=>$this->input->post('system_settings-add_payment_method'),
		'system_settings-tender_type_status'=>$this->input->post('system_settings-tender_type_status'),
		'system_settings-customfeedback'=>$this->input->post('system_settings-customfeedback'),
		'system_settings-add_customfeedback'=>$this->input->post('system_settings-add_customfeedback'),
		'system_settings-edit_customfeedback'=>$this->input->post('system_settings-edit_customfeedback'),
		'system_settings-delete_customfeedback'=>$this->input->post('system_settings-delete_customfeedback'),
		'system_settings-change_logo'=>$this->input->post('system_settings-change_logo'),
		
		'system_settings-currencies'=>$this->input->post('system_settings-currencies'),
		'system_settings-add_currency'=>$this->input->post('system_settings-add_currency'),
		'system_settings-edit_currency'=>$this->input->post('system_settings-edit_currency'),
		'system_settings-delete_currency'=>$this->input->post('system_settings-delete_currency'),
		
		'system_settings-customer_groups'=>$this->input->post('system_settings-customer_groups'),
		'system_settings-add_customer_group'=>$this->input->post('system_settings-add_customer_group'),
		'system_settings-edit_customer_group'=>$this->input->post('system_settings-edit_customer_group'),
		'system_settings-delete_customer_group'=>$this->input->post('system_settings-delete_customer_group'),
		
		'system_settings-categories'=>$this->input->post('system_settings-categories'),
		'system_settings-add_category'=>$this->input->post('system_settings-add_category'),
		'system_settings-edit_category'=>$this->input->post('system_settings-edit_category'),
		'system_settings-delete_category'=>$this->input->post('system_settings-delete_category'),
		//'products-barcode'=>$this->input->post('products-barcode'),
		
		'system_settings-recipecategories'=>$this->input->post('system_settings-recipecategories'),
		'system_settings-add_recipecategory'=>$this->input->post('system_settings-add_recipecategory'),
		'system_settings-edit_recipecategory'=>$this->input->post('system_settings-edit_recipecategory'),
		'system_settings-delete_recipecategory'=>$this->input->post('system_settings-delete_recipecategory'),
		
		'system_settings-expense_categories'=>$this->input->post('system_settings-expense_categories'),
		'system_settings-add_expense_category'=>$this->input->post('system_settings-add_expense_category'),
		'system_settings-edit_expense_category'=>$this->input->post('system_settings-edit_expense_category'),
		'system_settings-delete_expense_category'=>$this->input->post('system_settings-delete_expense_category'),
		
		'system_settings-units'=>$this->input->post('system_settings-units'),
		'system_settings-add_unit'=>$this->input->post('system_settings-add_unit'),
		'system_settings-edit_unit'=>$this->input->post('system_settings-edit_unit'),
		'system_settings-delete_unit'=>$this->input->post('system_settings-delete_unit'),
		
		'system_settings-brands'=>$this->input->post('system_settings-brands'),
		'system_settings-add_brand'=>$this->input->post('system_settings-add_brand'),
		'system_settings-edit_brand'=>$this->input->post('system_settings-edit_brand'),
		'system_settings-delete_brand'=>$this->input->post('system_settings-delete_brand'),
		
		'system_settings-sales_type'=>$this->input->post('system_settings-sales_type'),
		'system_settings-add_sales_type'=>$this->input->post('system_settings-add_sales_type'),
		'system_settings-edit_sales_type'=>$this->input->post('system_settings-edit_sales_type'),
		'system_settings-delete_sales_type'=>$this->input->post('system_settings-delete_sales_type'),
		
		'system_settings-tax_rates'=>$this->input->post('system_settings-tax_rates'),
		'system_settings-add_tax_rate'=>$this->input->post('system_settings-add_tax_rate'),
		'system_settings-edit_tax_rate'=>$this->input->post('system_settings-edit_tax_rate'),
		'system_settings-delete_tax_rate'=>$this->input->post('system_settings-delete_tax_rate'),
		
		'system_settings-discounts'=>$this->input->post('system_settings-discounts'),
		'system_settings-add_discount'=>$this->input->post('system_settings-add_discount'),
		'system_settings-delete_discount'=>$this->input->post('system_settings-delete_discount'),
		
		'system_settings-customer_discounts'=>$this->input->post('system_settings-customer_discounts'),
		'system_settings-add_customer_discounts'=>$this->input->post('system_settings-add_customer_discounts'),
		'system_settings-edit_customer_discount'=>$this->input->post('system_settings-edit_customer_discount'),
		'system_settings-delete_customer_discount'=>$this->input->post('system_settings-delete_customer_discount'),
		'system_settings-cus_dis_status'=>$this->input->post('system_settings-cus_dis_status'),
		
		
		'system_settings-buy_get'=>$this->input->post('system_settings-buy_get'),
		'system_settings-add_buy'=>$this->input->post('system_settings-add_buy'),
		'system_settings-edit_buy'=>$this->input->post('system_settings-edit_buy'),
		'system_settings-delete_buy'=>$this->input->post('system_settings-delete_buy'),
		
		'system_settings-email_templates'=>$this->input->post('system_settings-email_templates'),
		
		'system_settings-backups'=>$this->input->post('system_settings-backups'),
		'system_settings-backup_database'=>$this->input->post('system_settings-backup_database'),
		'system_settings-download_database'=>$this->input->post('system_settings-download_database'),
		'system_settings-restore_database'=>$this->input->post('system_settings-restore_database'),
		'system_settings-delete_database'=>$this->input->post('system_settings-delete_database'),
        'system_settings-group_permissions'=>$this->input->post('system_settings-group_permissions'),

		'reports-feedback' => $this->input->post('reports-feedback'),
		'store_request-index'=>$this->input->post('store_request-index'),
		'store_request-add'=>$this->input->post('store_request-add'),
		'store_request-edit'=>$this->input->post('store_request-edit'),
		'store_request-view'=>$this->input->post('store_request-view'),
		'store_request-delete'=>$this->input->post('store_request-delete'),
		'store_request-approved'=>$this->input->post('store_request-approved'),
		'request-index'=>$this->input->post('request-index'),
		'request-add'=>$this->input->post('request-add'),
		'request-edit'=>$this->input->post('request-edit'),
		'request-view'=>$this->input->post('request-view'),
		'request-delete'=>$this->input->post('request-delete'),
		'request-approved'=>$this->input->post('request-approved'),
		'quotes-index'=>$this->input->post('quotes-index'),
		'quotes-add'=>$this->input->post('quotes-add'),
		'quotes-edit'=>$this->input->post('quotes-edit'),
		'quotes-view'=>$this->input->post('quotes-view'),
		'quotes-delete'=>$this->input->post('quotes-delete'),
		'quotes-approved'=>$this->input->post('quotes-approved'),
		'purchase_orders-index'=>$this->input->post('purchase_orders-index'),
		'purchase_orders-add'=>$this->input->post('purchase_orders-add'),
		'purchase_orders-edit'=>$this->input->post('purchase_orders-edit'),
		'purchase_orders-view'=>$this->input->post('purchase_orders-view'),
		'purchase_orders-delete'=>$this->input->post('purchase_orders-delete'),
		'purchase_orders-approved'=>$this->input->post('purchase_orders-approved'),
		'purchase_invoices-index'=>$this->input->post('purchase_invoices-index'),
		'purchase_invoices-add'=>$this->input->post('purchase_invoices-add'),
		'purchase_invoices-edit'=>$this->input->post('purchase_invoices-edit'),
		'purchase_invoices-view'=>$this->input->post('purchase_invoices-view'),
		'purchase_invoices-delete'=>$this->input->post('purchase_invoices-delete'),
		'purchase_invoices-approved'=>$this->input->post('purchase_invoices-approved'),
		
		'purchase_returns-index'=>$this->input->post('purchase_returns-index'),
		'purchase_returns-add'=>$this->input->post('purchase_returns-add'),
		'purchase_returns-edit'=>$this->input->post('purchase_returns-edit'),
		'purchase_returns-view'=>$this->input->post('purchase_returns-view'),
		'purchase_returns-delete'=>$this->input->post('purchase_returns-delete'),
		'purchase_returns-approved'=>$this->input->post('purchase_returns-approved'),
		
		
		'store_transfers-index'=>$this->input->post('store_transfers-index'),
		'store_transfers-add'=>$this->input->post('store_transfers-add'),
		'store_transfers-edit'=>$this->input->post('store_transfers-edit'),
		'store_transfers-view'=>$this->input->post('store_transfers-view'),
		'store_transfers-delete'=>$this->input->post('store_transfers-delete'),
		'store_transfers-approved'=>$this->input->post('store_transfers-approved'),
		'store_receivers-index'=>$this->input->post('store_receivers-index'),
		'store_receivers-add'=>$this->input->post('store_receivers-add'),
		'store_receivers-edit'=>$this->input->post('store_receivers-edit'),
		'store_receivers-view'=>$this->input->post('store_receivers-view'),
		'store_receivers-delete'=>$this->input->post('store_receivers-delete'),
		'store_receivers-approved'=>$this->input->post('store_receivers-approved'),
		'store_returns-index'=>$this->input->post('store_returns-index'),
		'store_returns-add'=>$this->input->post('store_returns-add'),
		'store_returns-edit'=>$this->input->post('store_returns-edit'),
		'store_returns-view'=>$this->input->post('store_returns-view'),
		'store_returns-delete'=>$this->input->post('store_returns-delete'),
		'store_returns-approved'=>$this->input->post('store_returns-approved'),
		'store_return_receivers-index'=>$this->input->post('store_return_receivers-index'),
		'store_return_receivers-add'=>$this->input->post('store_return_receivers-add'),
		'store_return_receivers-edit'=>$this->input->post('store_return_receivers-edit'),
		'store_return_receivers-view'=>$this->input->post('store_return_receivers-view'),
		'store_return_receivers-delete'=>$this->input->post('store_return_receivers-delete'),
		'store_return_receivers-approved'=>$this->input->post('store_return_receivers-approved'),		
		
        'production-index' => $this->input->post('production-index'),
        'production-add' => $this->input->post('production-add'),
        'production-edit' => $this->input->post('production-edit'),
        'production-delete' => $this->input->post('production-delete'),
        'production-view' => $this->input->post('production-view'),
        'production-approved' => $this->input->post('production-approved'),

        'include_reports_view_access' => $this->input->post('include_reports_view_access'),
        'exclude_reports_view_access' => $this->input->post('exclude_reports_view_access'),
        'bbq_daywise_discount_edit_permission' => $this->input->post('bbq_daywise_discount_edit_permission'),
            );

            if (POS) {
                $data['pos-index'] = $this->input->post('pos-index');
            }

            //$this->sma->print_arrays($data);
			
        }

	if($user_id){
	    if ($this->form_validation->run() == true && $this->settings_model->updateUserPermissions($user_id, $data)) {
            
		$this->session->set_flashdata('message', lang("user_permissions_updated"));
		redirect($_SERVER["HTTP_REFERER"]);
	    } else {
		 
    
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    
		$this->data['id'] = $id;
		$this->data['p'] = $this->settings_model->getUserPermissions($user_id);
		$this->data['group'] = $this->settings_model->getUserByID($user_id);
		$this->data['group']->name = $this->data['group']->first_name;
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('users'), 'page' => lang('users')), array('link' => '#', 'page' => lang('user_permissions')));
		$meta = array('page_title' => lang('user_permissions'), 'bc' => $bc);
		$this->data['page_title'] = $meta['page_title'];
		$this->data['edit_link'] = 'system_settings/permissions/' . $id.'/'.$user_id;
		$this->page_construct('settings/permissions', $meta, $this->data);
	    }
	}else{
	    if ($this->form_validation->run() == true && $this->settings_model->updatePermissions($id, $data)) {
            
		$this->session->set_flashdata('message', lang("group_permissions_updated"));
		redirect($_SERVER["HTTP_REFERER"]);
	    } else {
		 
    
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    
		$this->data['id'] = $id;
		$this->data['p'] = $this->settings_model->getGroupPermissions($id);
		$this->data['group'] = $this->settings_model->getGroupByID($id);
    
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('group_permissions')));
		$meta = array('page_title' => lang('group_permissions'), 'bc' => $bc);
		$this->data['page_title'] = $meta['page_title'];
		$this->data['edit_link'] = 'system_settings/permissions/' . $id;
		$this->page_construct('settings/permissions', $meta, $this->data);
	    }
	}
        
    }

    function user_groups()
    {

        /*$this->sma->checkPermissions();
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang("access_denied"));
            admin_redirect('auth');
        }*/
        if (!$this->Owner) {
            if(!empty($this->sma->actionPermissions('group_permissions,system_settings'))){
                $this->session->set_flashdata('error', lang("access_denied"));
                admin_redirect('auth');
            }
        }

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $this->data['groups'] = $this->settings_model->getGroups();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('groups')));
        $meta = array('page_title' => lang('groups'), 'bc' => $bc);
        $this->page_construct('settings/user_groups', $meta, $this->data);
    }

    function delete_group($id = NULL)
    {

        if ($this->settings_model->checkGroupUsers($id)) {
            $this->session->set_flashdata('error', lang("group_x_b_deleted"));
            admin_redirect("system_settings/user_groups");
        }

        if ($this->settings_model->deleteGroup($id)) {
            $this->session->set_flashdata('message', lang("group_deleted"));
            admin_redirect("system_settings/user_groups");
        }
    }


	/*###### Age*/
    function age($action=false){
		
        //$this->site->wbPermission($this->session->userdata('user_id'), 'system_settings', 'age');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('province')));
        $meta = array('page_title' => lang('province'), 'bc' => $bc);
        //$this->data['menu'] = $this->site->menuList();
        $this->page_construct('settings/age', $meta, $this->data);
    }
    function getAge(){
        
        //$this->data['menu'] = $this->site->menuList();
        $this->load->library('datatables');
        $this->datatables
            ->select("id,name,status")
            ->from("age")
			->where('age.is_delete', 0);
            //$this->datatables->order_by('province.id', 'DESC');
            $this->datatables->edit_column('status', '$1__$2', 'id, status');


            if($this->data['menu']->{'system_settings-edit_age'}==1 || $this->data['menu']->{'system_settings-edit_age'}=="") {

            $edit = "<a href='" . admin_url('system_settings/edit_age/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";

            }
			
			//$delete = "<a href='" . admin_url('welcome/delete/province/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/age/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

    function add_age(){
        
        //$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_age');
        $this->form_validation->set_rules('name', lang("name"), 'required|is_unique[age.name]');   
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_age')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/age");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_age($data)){
			
            $this->session->set_flashdata('message', lang("age_added"));
            admin_redirect('system_settings/age');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/age_add', $this->data);
        }
    }
    function edit_age($id){
        
        //$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_age');
		$result = $this->settings_model->getAgeby_ID($id);
		$this->form_validation->set_rules('name', lang("name"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("name"), 'is_unique[age.name]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name')
            );
        } elseif ($this->input->post('edit_age')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/age");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_age($id, $data)) { 
            $this->session->set_flashdata('message', lang("age_updated"));
            admin_redirect("system_settings/age");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/age_edit', $this->data);
        }
    }
    function age_status($status,$id){
        
        //$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'age_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_age_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }


	/*###### Province*/
    function province($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'province');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('province')));
        $meta = array('page_title' => lang('province'), 'bc' => $bc);
        //$this->data['menu'] = $this->site->menuList();
        $this->page_construct('settings/province', $meta, $this->data);
    }
    function getProvince(){
        
        //$this->data['menu'] = $this->site->menuList();
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,code,name,status")
            ->from("province")
			->where('province.is_delete', 0);
            //$this->datatables->order_by('province.id', 'DESC');
            $this->datatables->edit_column('status', '$1__$2', 'id, status');


            if($this->data['menu']->{'system_settings-edit_province'}==1 || $this->data['menu']->{'system_settings-edit_province'}=="") {

            $edit = "<a href='" . admin_url('system_settings/edit_province/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";

            }
			
			//$delete = "<a href='" . admin_url('welcome/delete/province/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/province/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_province(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_province');
        $this->form_validation->set_rules('name', lang("province_name"), 'required|is_unique[province.name]');    
		$this->form_validation->set_rules('code', lang("province_code"), 'required|is_unique[province.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_province')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/province");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_province($data)){
			
            $this->session->set_flashdata('message', lang("province_added"));
            admin_redirect('system_settings/province');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/province_add', $this->data);
        }
    }
    function edit_province($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_province');
		$result = $this->settings_model->getProvinceby_ID($id);
		$this->form_validation->set_rules('name', lang("province_name"), 'required');    
		$this->form_validation->set_rules('code', lang("province_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("province_name"), 'is_unique[province.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("province_code"), 'is_unique[province.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_province')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/province");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_province($id, $data)) { 
            $this->session->set_flashdata('message', lang("province_updated"));
            admin_redirect("system_settings/province");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/province_edit', $this->data);
        }
    }
    function province_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'province_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_province_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### District*/
    function district($action=false){

        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'district');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('district')));
        $meta = array('page_title' => lang('district'), 'bc' => $bc);
        $this->page_construct('settings/district', $meta, $this->data);
    }
    function getDistrict(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" {$this->db->dbprefix('district')}.id as id, {$this->db->dbprefix('district')}.code, {$this->db->dbprefix('district')}.name, p.name as parent_name, {$this->db->dbprefix('district')}.status as status")
            ->from("district")
			->join("province p", "p.id = district.province_id ")
            ->where('district.is_delete', 0);
            
            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_district'}==1 || $this->data['menu']->{'system_settings-edit_district'}=="") {
            $edit = "<a href='" . admin_url('system_settings/edit_district/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' data-backdrop='static' data-keyboard='false' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }

			//$delete = "<a href='" . admin_url('welcome/delete/district/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/district/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
        //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_district(){
		
		$this->form_validation->set_rules('code', lang("district_code"), 'required|is_unique[district.code]');    
        $this->form_validation->set_rules('name', lang("district_name"), 'required');    
		$this->form_validation->set_rules('province_id', lang("province"), 'required');    
		
        if ($this->form_validation->run() == true) {
			
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
                'status' => 1,
            );
			
        }elseif ($this->input->post('add_district')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/district");
        }
		
        if ($this->form_validation->run() == true && $this->settings_model->add_district($data)){
			
            $this->session->set_flashdata('message', lang("district_added"));
            admin_redirect('system_settings/district');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
            $this->load->view($this->theme . 'settings/district_add', $this->data);
			
        }
    }
    function edit_district($id){
		
		$result = $this->settings_model->getdistrictby_ID($id);
		$this->form_validation->set_rules('name', lang("district_name"), 'required');  
		$this->form_validation->set_rules('code', lang("district_code"), 'required');  
		$this->form_validation->set_rules('province_id', lang("province"), 'required');      
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("district_name"), 'is_unique[district.name]');
			
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("district_code"), 'is_unique[district.code]');
			
        }
        if ($this->form_validation->run() == true) {
			
            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
            );
			
        } elseif ($this->input->post('edit_district')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/district");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_district($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("district_updated"));
            admin_redirect("system_settings/district");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
			$this->data['result'] = $result;
			
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/district_edit', $this->data);
        }
    }
    function district_status($status,$id){

        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'district_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_district_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Commune*/
    function commune($action=false){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'commune');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('commune')));
        $meta = array('page_title' => lang('commune'), 'bc' => $bc);
        $this->page_construct('settings/commune', $meta, $this->data);
    }
    function getCommune(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" {$this->db->dbprefix('commune')}.id as id, {$this->db->dbprefix('commune')}.code, {$this->db->dbprefix('commune')}.name,
            d.name as d_name, p.name as parent_name, {$this->db->dbprefix('commune')}.status as status")
            ->from("commune")
			->join("province p", "p.id = commune.province_id ")
			->join("district d", "d.id = commune.district_id ")
            ->where('commune.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_commune'}==1 || $this->data['menu']->{'system_settings-edit_commune'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_commune/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/commune/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/commune/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
        //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_commune(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_commune');
		$this->form_validation->set_rules('code', lang("commune_name"), 'required|is_unique[commune.code]');    
        $this->form_validation->set_rules('name', lang("commune_code"), 'required|is_unique[commune.name]');    
		$this->form_validation->set_rules('province_id', lang("province"), 'required');    
		$this->form_validation->set_rules('district_id', lang("district"), 'required');    
		
        if ($this->form_validation->run() == true) {
			
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
				'district_id' => $this->input->post('district_id'),
                'status' => 1,
            );
			
        }elseif ($this->input->post('add_commune')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/commune");
        }
		
        if ($this->form_validation->run() == true && $this->settings_model->add_commune($data)){
			
            $this->session->set_flashdata('message', lang("commune_added"));
            admin_redirect('system_settings/commune');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
            $this->load->view($this->theme . 'settings/commune_add', $this->data);
			
        }
    }
    function edit_commune($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_commune');
		$result = $this->settings_model->getcommuneby_ID($id);
		$this->form_validation->set_rules('name', lang("commune_name"), 'required');  
		$this->form_validation->set_rules('code', lang("commune_code"), 'required');  
		$this->form_validation->set_rules('province_id', lang("province"), 'required');    
		$this->form_validation->set_rules('district_id', lang("district"), 'required');  
		     
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("commune_name"), 'is_unique[commune.name]');
			
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("commune_code"), 'is_unique[commune.code]');
			
        }
        if ($this->form_validation->run() == true) {
			
            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
				'district_id' => $this->input->post('district_id'),
            );
			
        } elseif ($this->input->post('edit_commune')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/commune");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_commune($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("commune_updated"));
            admin_redirect("system_settings/commune");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($result->province_id);
			$this->data['result'] = $result;
			
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/commune_edit', $this->data);
        }
    }
    function commune_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'commune_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_commune_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Village*/
    function village($action=false){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'village');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('village')));
        $meta = array('page_title' => lang('village'), 'bc' => $bc);
        $this->page_construct('settings/village', $meta, $this->data);
    }
    function getVillage(){
        
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" {$this->db->dbprefix('village')}.id as id, {$this->db->dbprefix('village')}.code, {$this->db->dbprefix('village')}.name, c.name as c_name,  d.name as d_name, p.name as parent_name, {$this->db->dbprefix('village')}.status as status")
            ->from("village")
			->join("province p", "p.id = village.province_id ")
			->join("commune c", "c.id = village.commune_id ")
			->join("district d", "d.id = village.district_id ")
            ->where('village.is_delete', 0);
            
            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_village'}==1 || $this->data['menu']->{'system_settings-edit_village'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_village/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/village/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/village/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
        //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_village(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_village');
		$this->form_validation->set_rules('code', lang("village_name"), 'required|is_unique[village.code]');    
        $this->form_validation->set_rules('name', lang("village_code"), 'required|is_unique[village.name]');    
		$this->form_validation->set_rules('province_id', lang("province"), 'required');
		$this->form_validation->set_rules('commune_id', lang("commune"), 'required');    
		$this->form_validation->set_rules('district_id', lang("district"), 'required');    
		
        if ($this->form_validation->run() == true) {
			
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
				'commune_id' => $this->input->post('commune_id'),
				'district_id' => $this->input->post('district_id'),
                'status' => 1,
            );
			
        }elseif ($this->input->post('add_village')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/village");
        }
		
        if ($this->form_validation->run() == true && $this->settings_model->add_village($data)){
			
            $this->session->set_flashdata('message', lang("village_added"));
            admin_redirect('system_settings/village');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
            $this->load->view($this->theme . 'settings/village_add', $this->data);
			
        }
    }
    function edit_village($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_village');
		$result = $this->settings_model->getvillageby_ID($id);
		$this->form_validation->set_rules('name', lang("village_name"), 'required');  
		$this->form_validation->set_rules('code', lang("village_code"), 'required');  
		$this->form_validation->set_rules('province_id', lang("province"), 'required');    
		$this->form_validation->set_rules('commune_id', lang("commune"), 'required');    
		$this->form_validation->set_rules('district_id', lang("district"), 'required');   
		
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("village_name"), 'is_unique[village.name]');
			
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("village_code"), 'is_unique[village.code]');
			
        }
        if ($this->form_validation->run() == true) {
			
            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'province_id' => $this->input->post('province_id'),
				'commune_id' => $this->input->post('commune_id'),
				'district_id' => $this->input->post('district_id'),
            );
			
        } elseif ($this->input->post('edit_district')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/village");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_village($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("village_updated"));
            admin_redirect("system_settings/village");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLProvince();
			$this->data['district'] = $this->settings_model->getdistrict_byprovince($result->province_id);
			$this->data['commune'] = $this->settings_model->getcommune_bydistrict($result->district_id);
			
			$this->data['result'] = $result;
			
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/village_edit', $this->data);
        }
    }
    function village_status($status,$id){

        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'village_status');
		
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_village_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Currency*/
    function currency($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'currency');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('currency')));
        $meta = array('page_title' => lang('currency'), 'bc' => $bc);
        $this->page_construct('settings/currency', $meta, $this->data);
    }
    function getCurrency(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,code,name,status")
            ->from("currency")
			->where('currency.is_delete', 0);

            if($this->data['menu']->{'system_settings-edit_currency'}==1 || $this->data['menu']->{'system_settings-edit_currency'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_currency/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
            $this->datatables->edit_column('status', '$1__$2', 'id, status');

			//$delete = "<a href='" . admin_url('welcome/delete/currency/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/currency/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_currency(){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_currency');
		$this->form_validation->set_rules('code', lang("currency_code"), 'required|is_unique[currency.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_currency')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/currency");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_currency($data)){
			
            $this->session->set_flashdata('message', lang("currency_added"));
            admin_redirect('system_settings/currency');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/currency_add', $this->data);
        }
    }
    function edit_currency($id){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_currency');
		$result = $this->settings_model->getCurrencyby_ID($id);
		$this->form_validation->set_rules('name', lang("currency_name"), 'required');    
		$this->form_validation->set_rules('code', lang("currency_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("currency_name"), 'is_unique[currency.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("currency_code"), 'is_unique[currency.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_currency')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/currency");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_currency($id, $data)) { 
            $this->session->set_flashdata('message', lang("currency_updated"));
            admin_redirect("system_settings/currency");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/currency_edit', $this->data);
        }
    }
    function currency_status($status,$id){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'currency_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_currency_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Pets*/
    function pets($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'pets');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('pets')));
        $meta = array('page_title' => lang('pets'), 'bc' => $bc);
        $this->page_construct('settings/pets', $meta, $this->data);
    }
    function getPets(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,name, status")
            ->from("pets")
			->where('pets.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_pets'}==1 || $this->data['menu']->{'system_settings-edit_pets'}=="") {
            $edit = "<a href='" . admin_url('system_settings/edit_pets/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/pets/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/pets/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_pets(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_pets');
		$this->form_validation->set_rules('code', lang("pets_code"), 'required|is_unique[pets.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_pets')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/pets");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_pets($data)){
			
            $this->session->set_flashdata('message', lang("pets_added"));
            admin_redirect('system_settings/pets');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/pets_add', $this->data);
        }
    }
    function edit_pets($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_pets');
		$result = $this->settings_model->getPetsby_ID($id);
		$this->form_validation->set_rules('name', lang("pets_name"), 'required');    
		$this->form_validation->set_rules('code', lang("pets_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("pets_name"), 'is_unique[pets.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("pets_code"), 'is_unique[pets.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_pets')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/pets");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_pets($id, $data)) { 
            $this->session->set_flashdata('message', lang("pets_updated"));
            admin_redirect("system_settings/pets");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/pets_edit', $this->data);
        }
    }
    function pets_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'pets_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_pets_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Pets_type*/
    function pets_type($action=false){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'pets_type');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('pets_type')));
        $meta = array('page_title' => lang('pets_type'), 'bc' => $bc);
        $this->page_construct('settings/pets_type', $meta, $this->data);
    }
    function getpets_type(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('pets_type')}.id as id, {$this->db->dbprefix('pets_type')}.code, {$this->db->dbprefix('pets_type')}.name, p.name as parent_name, {$this->db->dbprefix('pets_type')}.status as status")
            ->from("pets_type")
			->join("pets p", "p.id = pets_type.pets_id ")
            ->where('pets_type.is_delete', 0);
            
            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_pets_type'}==1 || $this->data['menu']->{'system_settings-edit_pets_type'}=="") {
            $edit = "<a href='" . admin_url('system_settings/edit_pets_type/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/pets_type/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/pets_type/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
        //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_pets_type(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_pets_type');
		$this->form_validation->set_rules('code', lang("pets_type_name"), 'required|is_unique[pets_type.code]');    
		$this->form_validation->set_rules('pets_id', lang("pets"), 'required');    
		
        if ($this->form_validation->run() == true) {
			
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'pets_id' => $this->input->post('pets_id'),
                'status' => 1,
            );
			
        }elseif ($this->input->post('add_pets_type')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/pets_type");
        }
		
        if ($this->form_validation->run() == true && $this->settings_model->add_pets_type($data)){
			
            $this->session->set_flashdata('message', lang("pets_type_added"));
            admin_redirect('system_settings/pets_type');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLPetsMaster();
            $this->load->view($this->theme . 'settings/pets_type_add', $this->data);
			
        }
    }
    function edit_pets_type($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_pets_type');
		$result = $this->settings_model->getPets_typeby_ID($id);
		$this->form_validation->set_rules('name', lang("pets_type_name"), 'required');  
		$this->form_validation->set_rules('code', lang("pets_type_code"), 'required');  
		$this->form_validation->set_rules('pets_id', lang("pets"), 'required');      
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("pets_type_name"), 'is_unique[pets_type.name]');
			
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("pets_type_name"), 'is_unique[pets_type.code]');
			
        }
        if ($this->form_validation->run() == true) {
			
            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'pets_id' => $this->input->post('pets_id'),
            );
			
        } elseif ($this->input->post('edit_pets_type')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/pets_type");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_pets_type($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("pets_type_updated"));
            admin_redirect("system_settings/pets_type");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['parent'] = $this->settings_model->getALLPetsMaster();
			$this->data['result'] = $result;
			
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/pets_type_edit', $this->data);
        }
    }
    function pets_type_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'pets_type_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_pets_type_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	
	
	/*###### Hygine*/
    function hygine($action=false){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'hygine');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('hygine')));
        $meta = array('page_title' => lang('hygine'), 'bc' => $bc);
        $this->page_construct('settings/hygine', $meta, $this->data);
    }
    function getHygine(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,code,name,status")
            ->from("hygine")
			->where('hygine.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_hygine'}==1 || $this->data['menu']->{'system_settings-edit_hygine'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_hygine/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  data-backdrop='static' data-keyboard='false' ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/hygine/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/hygine/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_hygine(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_hygine');
		$this->form_validation->set_rules('code', lang("hygine_code"), 'required|is_unique[hygine.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_hygine')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/hygine");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_hygine($data)){
			
            $this->session->set_flashdata('message', lang("hygine_added"));
            admin_redirect('system_settings/hygine');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/hygine_add', $this->data);
        }
    }
    function edit_hygine($id){
		
		$result = $this->settings_model->getHygineby_ID($id);
		$this->form_validation->set_rules('name', lang("pets_name"), 'required');    
		$this->form_validation->set_rules('code', lang("pets_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("hygine_name"), 'is_unique[hygine.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("hygine_code"), 'is_unique[hygine.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_hygine')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/hygine");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_hygine($id, $data)) { 
            $this->session->set_flashdata('message', lang("hygine_updated"));
            admin_redirect("system_settings/hygine");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/hygine_edit', $this->data);
        }
    }
    function hygine_status($status,$id){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'hygine_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_hygine_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	
	/*###### Expanse*/
    function expanse($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'expanse');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('expanse')));
        $meta = array('page_title' => lang('expanse'), 'bc' => $bc);
        $this->page_construct('settings/expanse', $meta, $this->data);
    }
    function getExpanse(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,name,status")
            ->from("expanse")
			->where('expanse.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_expanse'}==1 || $this->data['menu']->{'system_settings-edit_expanse'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_expanse/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details' data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/expanse/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/expanse/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_expanse(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_expanse');
		$this->form_validation->set_rules('code', lang("expanse_code"), 'required|is_unique[expanse.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_hygine')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/expanse");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_expanse($data)){
			
            $this->session->set_flashdata('message', lang("expanse_added"));
            admin_redirect('system_settings/expanse');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/expanse_add', $this->data);
        }
    }
    function edit_expanse($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_expanse');
		$result = $this->settings_model->getExpanseby_ID($id);
		$this->form_validation->set_rules('name', lang("expanse_name"), 'required');    
		$this->form_validation->set_rules('code', lang("expanse_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("expanse_name"), 'is_unique[expanse.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("expanse_code"), 'is_unique[expanse.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_expanse')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/expanse");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_expanse($id, $data)) { 
            $this->session->set_flashdata('message', lang("expanse_updated"));
            admin_redirect("system_settings/expanse");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/expanse_edit', $this->data);
        }
    }
    function expanse_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'expanse_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_expanse_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	/*###### Equipment*/
    function equipment($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'equipment');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('equipment')));
        $meta = array('page_title' => lang('equipment'), 'bc' => $bc);
        $this->page_construct('settings/equipment', $meta, $this->data);
    }
    function getEquipment(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,code,name, price, status")
            ->from("equipment")
			->where('equipment.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_equipment'}==1 || $this->data['menu']->{'system_settings-edit_equipment'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_equipment/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/equipment/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/equipment/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
      // $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_equipment(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_equipment');
		$this->form_validation->set_rules('code', lang("equipment_code"), 'required|is_unique[equipment.code]');    
		$this->form_validation->set_rules('price', lang("price"), 'required'); 
		$this->form_validation->set_rules('price', lang("price"), 'required'); 
		
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'price' => $this->input->post('price'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_equipment')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/equipment");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_equipment($data)){
			
            $this->session->set_flashdata('message', lang("equipment_added"));
            admin_redirect('system_settings/equipment');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/equipment_add', $this->data);
        }
    }
    function edit_equipment($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_equipment');
		$result = $this->settings_model->getEquipmentby_ID($id);
		$this->form_validation->set_rules('name', lang("equipment_name"), 'required');    
		$this->form_validation->set_rules('code', lang("equipment_code"), 'required'); 
		$this->form_validation->set_rules('price', lang("price"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("equipment_name"), 'is_unique[equipment.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("equipment_code"), 'is_unique[equipment.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
				'price' => $this->input->post('price'),
            );
        } elseif ($this->input->post('edit_equipment')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/equipment");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_equipment($id, $data)) { 
            $this->session->set_flashdata('message', lang("equipment_updated"));
            admin_redirect("system_settings/equipment");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/equipment_edit', $this->data);
        }
    }
    function equipment_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'equipment_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_equipment_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### General_hygine*/
    function general_hygine($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'general_hygine');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('general_hygine')));
        $meta = array('page_title' => lang('general_hygine'), 'bc' => $bc);
        $this->page_construct('settings/general_hygine', $meta, $this->data);
    }
    function getGeneral_hygine(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,name,status")
            ->from("general_hygine")
			->where('general_hygine.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_general_hygine'}==1 || $this->data['menu']->{'system_settings-edit_general_hygine'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_general_hygine/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  data-backdrop='static' data-keyboard='false'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/general_hygine/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/general_hygine/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_general_hygine(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_general_hygine');
		$this->form_validation->set_rules('code', lang("general_hygine_code"), 'required|is_unique[general_hygine.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_general_hygine')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/general_hygine");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_general_hygine($data)){
			
            $this->session->set_flashdata('message', lang("general_hygine_added"));
            admin_redirect('system_settings/general_hygine');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/general_hygine_add', $this->data);
        }
    }
    function edit_general_hygine($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_general_hygine');
		$result = $this->settings_model->getGeneral_hygineby_ID($id);
		$this->form_validation->set_rules('name', lang("pets_name"), 'required');    
		$this->form_validation->set_rules('code', lang("pets_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("general_hygine_name"), 'is_unique[general_hygine.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("general_hygine_code"), 'is_unique[general_hygine.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_general_hygine')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/general_hygine");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_general_hygine($id, $data)) { 
            $this->session->set_flashdata('message', lang("general_hygine_updated"));
            admin_redirect("system_settings/general_hygine");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/general_hygine_edit', $this->data);
        }
    }
    function general_hygine_status($status,$id){
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'general_hygine_status');
        
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_general_hygine_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Source_of_water*/
    function source_of_water($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'source_of_water');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('source_of_water')));
        $meta = array('page_title' => lang('source_of_water'), 'bc' => $bc);
        $this->page_construct('settings/source_of_water', $meta, $this->data);
    }
    function getSource_of_water(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,code,name,status")
            ->from("source_of_water")
			->where('source_of_water.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_source_of_water'}==1 || $this->data['menu']->{'system_settings-edit_source_of_water'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_source_of_water/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  data-backdrop='static' data-keyboard='false'><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/source_of_water/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/source_of_water/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
      // $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_source_of_water(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_source_of_water');
		$this->form_validation->set_rules('code', lang("source_of_water_code"), 'required|is_unique[source_of_water.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_source_of_water')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/source_of_water");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_source_of_water($data)){
			
            $this->session->set_flashdata('message', lang("source_of_water_added"));
            admin_redirect('system_settings/source_of_water');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/source_of_water_add', $this->data);
        }
    }
    function edit_source_of_water($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_source_of_water');
		$result = $this->settings_model->getSource_of_waterby_ID($id);
		$this->form_validation->set_rules('name', lang("pets_name"), 'required');    
		$this->form_validation->set_rules('code', lang("pets_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("source_of_water_name"), 'is_unique[source_of_water.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("source_of_water_code"), 'is_unique[source_of_water.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_source_of_water')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/source_of_water");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_source_of_water($id, $data)) { 
            $this->session->set_flashdata('message', lang("source_of_water_updated"));
            admin_redirect("system_settings/source_of_water");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/source_of_water_edit', $this->data);
        }
    }
    function source_of_water_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'source_of_water_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_source_of_water_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	function getdistrict_byprovince(){
		
        $province_id = $this->input->post('province_id');
        $data = $this->settings_model->getdistrict_byprovince($province_id);
        $options = array();
        if($data){
            foreach($data as $k => $row){
                $options[$k]['id'] = $row->id;
                $options[$k]['text'] = $row->name;
            }
        }
        echo json_encode($options);exit;
    }
	function getcommune_bydistrict(){
		
        $district_id = $this->input->post('district_id');
        $data = $this->settings_model->getcommune_bydistrict($district_id);
        $options = array();
        if($data){
            foreach($data as $k => $row){
                $options[$k]['id'] = $row->id;
                $options[$k]['text'] = $row->name;
            }
        }
        echo json_encode($options);exit;
    }
	
	function getvillage_bycommune(){
		
        $commune_id = $this->input->post('commune_id');
        $data = $this->settings_model->getvillage_bycommune($commune_id);
        $options = array();
        if($data){
            foreach($data as $k => $row){
                $options[$k]['id'] = $row->id;
                $options[$k]['text'] = $row->name;
            }
        }
        echo json_encode($options);exit;
    }
    
	
	/*###### Occupations*/
    function occupations($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'occupations');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('occupations')));
        $meta = array('page_title' => lang('occupations'), 'bc' => $bc);
        $this->page_construct('settings/occupations', $meta, $this->data);
    }
    function getOccupations(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,name,status")
            ->from("occupations")
			->where('occupations.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_occupations'}==1 || $this->data['menu']->{'system_settings-edit_occupations'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_occupations/$1') . "' data-toggle='modal' data-target='#myModal' data-backdrop='static' data-keyboard='false' data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/hygine/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/occupations/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
      // $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_occupations(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_occupations');
		$this->form_validation->set_rules('code', lang("occupations_code"), 'required|is_unique[occupations.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_occupations')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/occupations");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_occupations($data)){
			
            $this->session->set_flashdata('message', lang("occupations_added"));
            admin_redirect('system_settings/occupations');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/occupations_add', $this->data);
        }
    }
    function edit_occupations($id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_occupations');
		$result = $this->settings_model->getOccupationsby_ID($id);
		$this->form_validation->set_rules('name', lang("occupations_name"), 'required');    
		$this->form_validation->set_rules('code', lang("occupations_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("occupations_name"), 'is_unique[occupations.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("occupations_code"), 'is_unique[occupations.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_occupations')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/occupations");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_occupations($id, $data)) { 
            $this->session->set_flashdata('message', lang("occupations_updated"));
            admin_redirect("system_settings/occupations");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/occupations_edit', $this->data);
        }
    }
    function occupations_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'occupations_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_occupations_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }


	function get_occupation(){
		
        //$head_occupation = $this->input->post('head_occupation');
        $data = $this->settings_model->get_occupation();
        $options = array();
        if($data){
            foreach($data as $k => $row){
                $options[$k]['id'] = $row->id;
                $options[$k]['text'] = $row->name;
            }
        }
        echo json_encode($options);exit;
    }


	function check_duplicate($table, $id=NULL) {

        //print_r($table); 
        //print_r($id); 
        //die;
		$name = $this->input->post('name');
        $id = $id;
        //$id = $this->input->post('id');
		$data = $this->settings_model->check_duplicate($name, $id, $table);

		echo $data;
	} 


	function check_duplicate_district() {

        //print_r($_POST); die;
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $province_id = $this->input->post('province_id');

		$data = $this->settings_model->check_duplicate_district($id, $name, $province_id);

		echo $data;
	} 


    function form($action=false){
		

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('form')));
        $meta = array('page_title' => lang('form'), 'bc' => $bc);
        $this->page_construct('settings/form', $meta, $this->data);
    }
    function getForm(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select(" id,name,")
            ->from("form");

            

			$edit = "<a href='" . admin_url('system_settings/form_settings/$1') . "'  title='Click here to full details'  ><i class='fa fa-lock' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			
			
			
			$this->datatables->add_column("Actions", "<div>".$edit."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    function form_settings($id){
		
		$result = $this->settings_model->getform_settingsby_ID($id);
		$this->form_validation->set_rules('form_id', lang("form_id"), 'required');    
		
        
        if ($this->form_validation->run() == true) {
            
            if($id == 1){
            $permission = array(
               
                'head_of_family_enable' => $this->input->post('head_of_family_enable') ? $this->input->post('head_of_family_enable') : 0,
                'identification_number_enable' => $this->input->post('identification_number_enable') ? $this->input->post('identification_number_enable') : 0,
                'phone_number_enable' => $this->input->post('phone_number_enable') ? $this->input->post('phone_number_enable') : 0,
                'head_occupation_enable' => $this->input->post('head_occupation_enable') ? $this->input->post('head_occupation_enable') : 0,
                'member_of_family_enable' => $this->input->post('member_of_family_enable') ? $this->input->post('member_of_family_enable') : 0,
                'address_enable' => $this->input->post('address_enable') ? $this->input->post('address_enable') : 0,
                'number_of_pets_enable' => $this->input->post('number_of_pets_enable') ? $this->input->post('number_of_pets_enable') : 0,
                'loan_enable' => $this->input->post('loan_enable') ? $this->input->post('loan_enable') : 0
            );
            }elseif($id == 2){
                $permission = array(
                    
                    'head_of_family_enable' => $this->input->post('head_of_family_enable') ? $this->input->post('head_of_family_enable') : 0,
                    'identification_number_enable' => $this->input->post('identification_number_enable') ? $this->input->post('identification_number_enable') : 0,
                    'phone_number_enable' => $this->input->post('phone_number_enable') ? $this->input->post('phone_number_enable') : 0,
                    'head_occupation_enable' => $this->input->post('head_occupation_enable') ? $this->input->post('head_occupation_enable') : 0,
                    'member_of_family_enable' => $this->input->post('member_of_family_enable') ? $this->input->post('member_of_family_enable') : 0,
                    'address_enable' => $this->input->post('address_enable') ? $this->input->post('address_enable') : 0,
                    'number_of_pets_enable' => $this->input->post('number_of_pets_enable') ? $this->input->post('number_of_pets_enable') : 0,
                    'wife_name_enable' => $this->input->post('wife_name_enable') ? $this->input->post('wife_name_enable') : 0,
                    'wife_identification_number_enable' => $this->input->post('wife_identification_number_enable') ? $this->input->post('wife_identification_number_enable') : 0,
                    'wife_occupation_enable' => $this->input->post('wife_occupation_enable') ? $this->input->post('wife_occupation_enable') : 0,
                    'total_land_size_enable' => $this->input->post('total_land_size_enable') ? $this->input->post('total_land_size_enable') : 0,
                    'total_land_size_for_building_oven_enable' => $this->input->post('total_land_size_for_building_oven_enable') ? $this->input->post('total_land_size_for_building_oven_enable') : 0,
                    'underground_water_level_during_dry_season_enable' => $this->input->post('underground_water_level_during_dry_season_enable') ? $this->input->post('underground_water_level_during_dry_season_enable') : 0,
                    'raining_season_enable' => $this->input->post('raining_season_enable') ? $this->input->post('raining_season_enable') : 0,
                    'hygine_enable' => $this->input->post('hygine_enable') ? $this->input->post('hygine_enable') : 0,
                    'general_hygine_enable' => $this->input->post('general_hygine_enable') ? $this->input->post('general_hygine_enable') : 0,
                    'source_of_water_enable' => $this->input->post('source_of_water_enable') ? $this->input->post('source_of_water_enable') : 0,
                    'budget_source_enable' => $this->input->post('budget_source_enable') ? $this->input->post('budget_source_enable') : 0
                );
            }
            
            $res = array(
				'form_id' => $this->input->post('form_id'),
                'permission' => json_encode($permission),
                'created_on' => date('Y-m-d H:i:s')
            );
        } elseif ($this->input->post('form_settings')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/form_settings/".$id);
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateFormsetting($id, $res)) { 
            $this->session->set_flashdata('message', lang("form_settings_updated"));
            admin_redirect("system_settings/form_settings/".$id);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['result'] = $result;
            $this->data['form_result'] = $this->settings_model->getformby_ID($id);
            $this->data['id'] = $id;
           
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('form')));
            $meta = array('page_title' => lang('form_settings'), 'bc' => $bc);
            $this->page_construct('settings/form_settings', $meta, $this->data);
        }
    }
	
	/*###### Department*/
    function department($action=false){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'department');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('department')));
        $meta = array('page_title' => lang('department'), 'bc' => $bc);
        $this->page_construct('settings/department', $meta, $this->data);
    }
    function getDepartment(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,name, status")
            ->from("department")
			->where('department.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

            if($this->data['menu']->{'system_settings-edit_department'}==1 || $this->data['menu']->{'system_settings-edit_department'}=="") { 
            $edit = "<a href='" . admin_url('system_settings/edit_department/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
            }
			//$delete = "<a href='" . admin_url('welcome/delete/pets/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/department/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$edit."</div><div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_department(){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_department');
		$this->form_validation->set_rules('name', lang("department_name"), 'required|is_unique[department.name]');   
		$this->form_validation->set_rules('code', lang("department_code"), 'required|is_unique[department.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_department')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/department");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_department($data)){
			
            $this->session->set_flashdata('message', lang("department_added"));
            admin_redirect('system_settings/department');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/department_add', $this->data);
        }
    }
    function edit_department($id){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'edit_department');
		$result = $this->settings_model->getDepartmentby_ID($id);
		$this->form_validation->set_rules('name', lang("department_name"), 'required');    
		$this->form_validation->set_rules('code', lang("department_code"), 'required'); 
        
        if ($this->input->post('name') != $result->name) {
            $this->form_validation->set_rules('name', lang("department_name"), 'is_unique[department.name]');
        }
		if ($this->input->post('code') != $result->code) {
            $this->form_validation->set_rules('code', lang("department_code"), 'is_unique[department.code]');
        }
        
        if ($this->form_validation->run() == true) {

            $data = array(
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code'),
            );
        } elseif ($this->input->post('edit_department')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/department");
        }

        if ($this->form_validation->run() == true && $this->settings_model->update_department($id, $data)) { 
            $this->session->set_flashdata('message', lang("department_updated"));
            admin_redirect("system_settings/department");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/department_edit', $this->data);
        }
    }
    function department_status($status,$id){
		$this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'department_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_department_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }
	
	/*###### Role*/
    function role($action=false){
		
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'role');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('role')));
        $meta = array('page_title' => lang('role'), 'bc' => $bc);
        $this->page_construct('settings/role', $meta, $this->data);
    }
    function getRole(){
		
        $this->load->library('datatables');
        $this->datatables
            ->select("id,code,position,access_location, status")
            ->from("role")
			->where('role.is_delete', 0);

            $this->datatables->edit_column('status', '$1__$2', 'id, status');

			//$edit = "<a href='" . admin_url('system_settings/edit_role/$1') . "' data-toggle='modal' data-target='#myModal'  data-original-title='' aria-describedby='tooltip' title='Click here to full details'  ><i class='fa fa-pencil-square-o' aria-hidden='true'  style='color:#656464; font-size:18px'></i></a>";
			//$delete = "<a href='" . admin_url('welcome/delete/pets/$1') . "' data-toggle='tooltip'  data-original-title='' aria-describedby='tooltip' title='Delete'  ><i class='fa fa-trash' style='color:#656464; font-size:18px'></i></a>";
			$delete = "<a href='#' class='tip po'  data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger' id='a__$1' href='" . admin_url('welcome/delete/role/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> </a>";
			$this->datatables->add_column("Actions", "<div>".$delete."</div>", "id");
			
       //$this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    function add_role(){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'add_role');
		$this->form_validation->set_rules('position', lang("role_position"), 'required|is_unique[role.position]');   
		$this->form_validation->set_rules('code', lang("role_code"), 'required|is_unique[role.code]');    
        if ($this->form_validation->run() == true) {
            $data = array(
                'position' => $this->input->post('position'),
				'access_location' => $this->input->post('access_location'),
				'code' => $this->input->post('code'),
                'status' => 1,
            );
        }elseif ($this->input->post('add_role')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("system_settings/role");
        }
        if ($this->form_validation->run() == true && $this->settings_model->add_role($data)){
			
            $this->session->set_flashdata('message', lang("role_added"));
            admin_redirect('system_settings/role');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'settings/role_add', $this->data);
        }
    }
   
    function role_status($status,$id){
        
        $this->site->webPermission($this->session->userdata('user_id'), 'system_settings', 'role_status');
        $data['status'] = 0;
        if($status=='active'){
            $data['status'] = 1;
        }
        $this->settings_model->update_role_status($data,$id);
		redirect($_SERVER["HTTP_REFERER"]);
    }

    function check_duplicate_value($table, $fieldName, $id=NULL, $wFieldName=NULL) {


		$value = $this->input->post($fieldName);
        $id = $id;
        //$id = $this->input->post('id');
		$data = $this->settings_model->check_duplicate_value($id, $value, $fieldName, $wFieldName, $table);

		echo $data;
	}

}
