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
class depo extends MX_Controller {

    private $_title = 'Master Depo / Depot';
    private $_limit = 10;
    private $_module = 'master/depo';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login(); 
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('depo_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','gembul'));
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
        if ($id != '') {
            $page_title = 'Edit Depo / Depot';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
        $data['parent_options'] = $this->tbl_get->options_pemasok();
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
        $table->id = 'ID_DEPO';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_DEPO' => 'center', 'NAMA_PEMASOK' => 'center','KD_DEPO' => 'center', 'NAMA_DEPO' => 'center', 'LAT_DEPO' => 'center', 'LOT_DEPO' => 'center', 'ALAMAT_DEPO' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
            "No", 1, 1,
            "Nama Pemasok", 1, 1,
            "Kode DEPO", 1, 1,
            "Nama Depo", 1, 1,
            "LAT", 1, 1,
            "LONG", 1, 1,
            "Alamat", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('ID_PEMASOK', 'NAMA PEMASOK', 'required');
        $this->form_validation->set_rules('KD_DEPO', 'KODE DEPO', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['NAMA_DEPO'] = $this->input->post('NAMA_DEPO');
            $data['KD_DEPO'] = $this->input->post('KD_DEPO');
            $data['LAT_DEPO'] = $this->input->post('LAT_DEPO');
            $data['LOT_DEPO'] = $this->input->post('LOT_DEPO');
            $data['ALAMAT_DEPO'] = $this->input->post('ALAMAT_DEPO');
            


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

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
