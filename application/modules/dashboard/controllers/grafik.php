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
        $this->asset->set_plugin(array('bootstrap-rakhmat'));
        $this->asset->set_plugin(array('font-awesome'));

        //print_r($this->asset); die;

        // $data['button_group'] = array(
        //     anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        // );
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['report'] = $this->tbl_get->report();
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    // public function add($id = '') {
    //     $page_title = 'Tambah'.$this->_title;
    //     $data['id'] = $id;
    //     if ($id != '') {
    //         $page_title = 'Edit Transportir';
    //         $get_tbl = $this->tbl_get->data($id);
    //         $data['default'] = $get_tbl->get()->row();
    //     }
        
    //     $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
    //     $data['form_action'] = base_url($this->_module . '/proses');
    //     $this->load->view($this->_module . '/form', $data);
    // }

    // public function edit($id) {
    //     $this->add($id);
    // }

    // public function load($page = 1) {
    //     $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
    //     $this->load->library("ltable");
    //     $table = new stdClass();
    //     $table->id = 'ID_TRANSPORTIR';
    //     $table->style = "table table-striped table-bordered table-hover datatable dataTable";
    //     $table->align = array('ID_TRANSPORTIR' => 'center', 'KD_TRANSPORTIR' => 'center', 'NAMA_TRANSPORTIR' => 'center', 'KET_TRANSPORTIR' => 'center', 'aksi' => 'center');
    //     $table->page = $page;
    //     $table->limit = $this->_limit;
    //     $table->jumlah_kolom = 5;
    //     $table->header[] = array(
    //         "No", 1, 1,
    //         "Kode Transportir", 1, 1,
    //         "Nama Transportir", 1, 1,
    //         "Ket Transportir", 1, 1,
    //         "Aksi", 1, 1
    //     );
    //     $table->total = $data_table['total'];
    //     $table->content = $data_table['rows'];
    //     $data = $this->ltable->generate($table, 'js', true);
    //     echo $data;
    // }

    // public function proses() {
    //     $this->form_validation->set_rules('KD_TRANSPORTIR', 'Kode Transportir', 'trim|required|max_length[50]');
    //     $this->form_validation->set_rules('NAMA_TRANSPORTIR', 'Nama Transportir', 'required');
    //     if ($this->form_validation->run($this)) {
    //         $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
    //         $id = $this->input->post('id');

    //         $data = array();
    //         $data['KD_TRANSPORTIR'] = $this->input->post('KD_TRANSPORTIR');
    //         $data['NAMA_TRANSPORTIR'] = $this->input->post('NAMA_TRANSPORTIR');
    //         $data['KET_TRANSPORTIR'] = $this->input->post('KET_TRANSPORTIR');

    //         if ($id == '') {
    //             if ($this->tbl_get->save_as_new($data)) {
    //                 $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
    //             }
    //         } else {
    //             if ($this->tbl_get->save($data, $id)) {
    //                 $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
    //             }
    //         }
    //     } else {
    //         $message = array(false, 'Proses gagal', validation_errors(), '');
    //     }
    //     echo json_encode($message, true);
    // }

    // public function delete($id) {
    //     $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

    //     if ($this->tbl_get->delete($id)) {
    //         $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
    //     }
    //     echo json_encode($message);
    // }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
