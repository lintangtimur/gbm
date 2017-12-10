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
 * @module Master Wilayah
 */
class tutup_mutasi_persediaan extends MX_Controller {

    private $_title = 'Tutup Mutasi Persediaan';
    private $_limit = 10;
    private $_module = 'data_transaksi/tutup_mutasi_persediaan';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login(); 
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('tutup_mutasi_persediaan_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
        $data['button_group_buka'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data Buka Mutasi', array('class' => 'btn yellow', 'id' => 'button-add-buka', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add_buka')))
             );
        $data['button_group_tutup'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data Tutup Mutasi', array('class' => 'btn yellow', 'id' => 'button-add-tutup', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        }
        $data['reg_options'] = $this->tbl_get->options_reg(); 
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); ; 
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['data_sources_buka_mutasi'] = base_url($this->_module . '/load_buka');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
       
        $data['parent_options'] = $this->tbl_get->options_status_mutasi(); 


        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_MUTASI';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_MUTASI' => 'center', 'TGL_TUTUP' => 'center', 'BLTH' => 'center', 'NAME_SETTING' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 4;
        $table->header[] = array(
            "No", 1, 1,
            "Tanggal Tutup", 1, 1,
            "BLTH", 1, 1,
            "STATUS", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }


    public function load_buka($page = 1) {
        $data_table = $this->tbl_get->data_table_buka($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_BUKA_MUTASI';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_BUKA_MUTASI' => 'center', 'STATUS' => 'center', 'PLANT' => 'center','LEVEL2' => 'center', 'LEVEL1' => 'center', 'NAMA_REGIONAL' => 'center', 'TGL_BUKA' => 'center', 'TGL_TUTUP' => 'center','BLTH' => 'center','aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "No", 1, 1,
            "Status", 1, 1,
            "PLANT", 1, 1,
            "LEVEL 2", 1, 1,
            "LEVEL 1", 1, 1,
            "REGIONAL", 1, 1,
            "Tanggal Buka", 1, 1,
            "Tanggal Tutup", 1, 1,
            "BLTH", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function add_buka($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $lv1 = '-';
        $lv2 = '-';
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_tbl = $this->tbl_get->data_buka($id);
            $data['default'] = $get_tbl->get()->row();
            $lv1 = $data['default']->ID_REGIONAL; 
            $lv2 = $data['default']->COCODE;
        }
        $data['parent_options_buka'] = $this->tbl_get->options_status_mutasi_buka(); 
        $data['reg_options'] = $this->tbl_get->options_reg(); 
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $lv1, 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $lv2, 1); 

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_buka');
        $this->load->view($this->_module . '/form_buka', $data);
    }

    public function edit_buka($id) {
        $this->add_buka($id);
    }


    public function proses() {
        $this->form_validation->set_rules('TGL_TUTUP', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['TGL_TUTUP'] = $this->input->post('TGL_TUTUP');
            $tanggal = new DateTime($data['TGL_TUTUP']);
            $tahun = $tanggal->format('Y');
            $bulan = $tanggal->format('m');
            if($bulan==1){
                $bulan=12;
            }else{
                $bulan=$bulan-1;
            }

            if($bulan<10){
                $bulan='0'.$bulan;
            }
            $data['BLTH']=$tahun.$bulan;
            $data['PLANT']='0'; 
           
            if ($id == '') {
                    $data['STATUS'] = "1";     
                    if ($this->tbl_get->save_as_new($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
            }else{
                $data['TGL_UPDATE']=date("Y/m/d H:i:s");
                $data['UPDATE_BY']=$this->session->userdata('user_name');
                    if ($this->tbl_get->save($data, $id)) {
                        $data['ID_MUTASI'] =$id;
                        $data['TGL_LOG']=date("Y/m/d H:i:s");
                        $data['STATUS'] ='1';
                        if ($this->tbl_get->save_as_new_log($data)) {
                            $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                        }
                    }     
            }

        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function proses_buka() {
        $this->form_validation->set_rules('PLANT', 'required');
        $this->form_validation->set_rules('TGL_BUKA', 'required');
        $this->form_validation->set_rules('TGL_TUTUP', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['PLANT'] = $this->input->post('PLANT');
            $data['TGL_BUKA'] = $this->input->post('TGL_BUKA');
            $data['TGL_TUTUP'] = $this->input->post('TGL_TUTUP');
            $tanggal = new DateTime($data['TGL_TUTUP']);
            $tahun = $tanggal->format('Y');
            $bulan = $tanggal->format('m');
            if($bulan==1){
                $bulan=12;
            }else{
                $bulan=$bulan-1;
            }

            if($bulan<10){
                $bulan='0'.$bulan;
            }
            $data['BLTH']=$tahun.$bulan;
           
            if ($id == '') {      
                    if ($this->tbl_get->save_as_new_buka($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table_buka');
                    }
            }else{
                $data['UPDATE_DATE']=date("Y/m/d H:i:s");
                $data['UPDATE_BY']=$this->session->userdata('user_name');
                    if ($this->tbl_get->save_buka($data, $id)) {
                        $data['ID_BUKA_MUTASI'] =$id;
                        $data['TGL_LOG']=date("Y/m/d H:i:s");
                        if ($this->tbl_get->save_as_new_buka_log($data)) {
                            $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table_buka');
                        }
                    }     
            }

        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function get_options_lv1($key=null) {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }


}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
