<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Transportir
 */
class grafik extends MX_Controller {

    private $_title = 'GRAFIK';
    private $_limit = 10;
    private $_module = 'dashboard/grafik';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('grafik_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));

        $data = $this->get_level_user(); 

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['report'] = $this->tbl_get->report();
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }
    public function getDataBio()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getVolBio($data);
        echo json_encode($data);
    }
    public function getDataHsd()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getVolHsd($data);
        echo json_encode($data);
    }
    public function getDataMfo()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getVolMfo($data);
        echo json_encode($data);
    }
    public function getDataHsdBio()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getVolHsdBio($data);
        echo json_encode($data);
    }
    public function getDataIdo()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getVolIdo($data);
        echo json_encode($data);
    }

    public function getTableHsdBio()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getTableHsdBio($data);
        echo json_encode($data);
    }
    public function getTableBio()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getTableBio($data);
        echo json_encode($data);
    }

    public function getTableHsd()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getTableHsd($data);
        echo json_encode($data);
    }

    public function getTableMfo()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getTableMfo($data);
        echo json_encode($data);
    }

    public function getTableIdo()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE'] = $this->input->post('COCODE');
        $data['PLANT'] = $this->input->post('PLANT');
        $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['BULAN'] = $this->input->post('BULAN');
        $data['TAHUN'] = $this->input->post('TAHUN');

        $data = $this->tbl_get->getTableIdo($data);
        echo json_encode($data);
    }
    
    
    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', '-', 1);  

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user,$kode_level);

        if ($level_user==4){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $option_lv4;
        } else if ($level_user==3){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);  
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get->options_reg(); 
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();  

        return $data;
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

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
