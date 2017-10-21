<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module persediaan_bbm
 */
class persediaan_bbm extends MX_Controller {

    private $_title = 'Persediaan BBM';
    private $_limit = 10;
    private $_module = 'laporan/persediaan_bbm';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('persediaan_bbm_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $this->asset->set_plugin(array('bootstrap-rakhmat'));

        // $lv1 = '-';
        $lv2 = '-';
        $lv3 = '-';
        $lv4 = '-';

        $data['lv1_options'] = $this->tbl_get->options_lv1(); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $lv2, 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $lv3, 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $lv4, 1);  
        $data['opsi_bbm'] = $this->tbl_get->option_jenisbbm();  
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();  
        

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        echo Modules::run("template/admin", $data);
    }

    public function get_options_lv1($key=null) {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->tbl_get->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->tbl_get->options_lv4('--Pilih Level 4--', $key, 0);
        echo json_encode($message);
    }
    public function get_options_bbm() {
        $message = $this->tbl_get->options_bhn_bkr('--Pilih Jenis BBM--', $key, 0);
        echo json_encode($message);
    }

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
