<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class dashboard extends MX_Controller {

    private $_title = 'Dashboard';
    private $_module = 'dashboard';
     private $_limit = 5;
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');

        // Protection
        hprotection::login();
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");
         // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','highchart'));
        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );
        $data['sidebar_content']    = 'dashboard/sidebar';
        $data['motivasi']           = array();
        $data['page_title']         = '<i class="icon-home"></i> ' . $this->_title;
        $data['page_content']       = $this->_module .'/main2';
        $data['source_search']      = array();
        $data['sources_ate']        = array();
        $data['sources_taks']       = array();
        $data['sources_k_internal'] = array();
        $data['sources_elibrary']   = array();
        $data['sources_info']       = array();
        
        $data['suggest_elibrary']       = array();
        $data['suggest_elibrary2']       = array();
        $data['suggest_elibrary3']       = array();
        
        $data['suggest_takso1']       = array();
        $data['suggest_takso2']       = array();
		
		$data['picbelumlaporan'] = array();
		$data['picsudahlaporan'] = array();
		$data['belumverifikasi'] = array();

        echo Modules::run("template/admin", $data);
    }
    
}

/* End of file dashboard.php */
/* Location: ./application/modules/meeting_management/controllers/dashboard.php */
