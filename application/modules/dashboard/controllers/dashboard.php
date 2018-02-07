<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class dashboard extends MX_Controller
{
    private $_title  = 'Dashboard';
    private $_module = 'dashboard';
    private $_limit  = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');

        // Protection
        hprotection::login();
    }

    public function index()
    {
        // Load Modules
        $this->load->module('template/asset');
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(['crud', 'highchart']);
        $data['button_group'] = [
            anchor(null, '<i class="icon-plus"></i> Tambah Data', ['class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')])
        ];
        $data['sidebar_content']    = 'dashboard/sidebar';
        $data['motivasi']           = [];
        $data['page_title']         = '<i class="icon-home"></i> ' . $this->_title;
        $data['page_content']       = $this->_module . '/main2';
        $data['source_search']      = [];
        $data['sources_ate']        = [];
        $data['sources_taks']       = [];
        $data['sources_k_internal'] = [];
        $data['sources_elibrary']   = [];
        $data['sources_info']       = [];

        $data['suggest_elibrary']    = [];
        $data['suggest_elibrary2']   = [];
        $data['suggest_elibrary3']   = [];

        $data['suggest_takso1']       = [];
        $data['suggest_takso2']       = [];

        $data['picbelumlaporan'] = [];
        $data['picsudahlaporan'] = [];
        $data['belumverifikasi'] = [];

        echo Modules::run('template/admin', $data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/modules/meeting_management/controllers/dashboard.php */
