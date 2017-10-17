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

        /* Load Global Model */
        $this->load->model('master_level4_model','tbl_get');
        $this->load->model('master_level3_model','tbl_get_level3');
        $this->load->model('master_level2_model','tbl_get_level2');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }
        $data['lv2_options'] = $this->tbl_get_level2->options();
        $data['lv3_options'] = $this->tbl_get_level3->options();
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
        $table->align = array('NO' => 'center', 'LEVEL4' => 'left', 'SLOC' => 'center', 'DESCRIPTION_LVL4' => 'left', 'LEVEL2' => 'left', 'LEVEL3' => 'left','aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 6;
        $table->header[] = array(
            "No", 1, 1,
            "Level 4", 1, 1,
            "Sloc", 1, 1,
            "Alamat", 1, 1,
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

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */