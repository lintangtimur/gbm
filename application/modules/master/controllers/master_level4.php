<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level4
 */
class master_level4 extends MX_Controller {

    private $_title = 'Master Level 4';
    private $_limit = 10;
    private $_module = 'master/master_level4';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('master_level4_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $lv1 = '-';
        $lv2 = '-';
        $lv3 = '-';
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
            $lv1 = $data['default']->ID_REGIONAL; 
            $lv2 = $data['default']->COCODE;
            $lv3 = $data['default']->PLANT;
        }
        $data['reg_options'] = $this->tbl_get->options_reg();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $lv1, 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $lv2, 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $lv3, 1);  
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
        $table->id = 'SLOC';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable"; 
        $table->align = array('NO' => 'center', 'LEVEL4' => 'left', 'SLOC' => 'center', 'DESCRIPTION_LVL4' => 'left', 'NAMA_REGIONAL' => 'left', 'LEVEL1' => 'left', 'LEVEL2' => 'left', 'LEVEL3' => 'left', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "No", 1, 1,
            "Level 4", 1, 1,
            "Sloc", 1, 1,
            "Alamat", 1, 1,
            "Regional", 1, 1,
            "Level 1", 1, 1,
            "Level 2", 1, 1,
            "Level 3", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional','required');
        $this->form_validation->set_rules('COCODE', 'Level 1','trim|required|max_length[10]');
        if ($this->input->post('STATUS_LVL4')==0){
            $this->form_validation->set_rules('PLANT', 'Level 2', 'required');
            $this->form_validation->set_rules('STORE_SLOC', 'Level 3', 'required');            
        } 
        $this->form_validation->set_rules('LEVEL4', 'Level 4', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('SLOC', 'Sloc', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['LEVEL4'] = $this->input->post('LEVEL4');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['DESCRIPTION_LVL4'] = $this->input->post('DESCRIPTION_LVL4');
            $data['PLANT'] = $this->input->post('PLANT');
            $data['STORE_SLOC'] = $this->input->post('STORE_SLOC');
            $data['LAT_LVL4'] = $this->input->post('LAT_LVL4');
            $data['LOT_LVL4'] = $this->input->post('LOT_LVL4');
            $data['STATUS_LVL4'] = $this->input->post('STATUS_LVL4');
            $data['STATUS_LVL2'] = $this->input->post('STATUS_LVL2');
            $data['IS_AKTIF_LVL4'] = $this->input->post('IS_AKTIF_LVL4');
            $data['CD_BY_LEVEL4'] = $this->session->userdata('user_name');

            if ($id == '') {
                if ($this->tbl_get->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                if ($this->tbl_get->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
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

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
