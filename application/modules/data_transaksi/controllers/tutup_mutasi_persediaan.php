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
        $table->align = array('ID_MUTASI' => 'center', 'TGL_TUTUP' => 'center', 'NAME_SETTING' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 4;
        $table->header[] = array(
            "No", 1, 1,
            "Tanggal Tutup", 1, 1,
            "STATUS", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('TGL_TUTUP', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['TGL_TUTUP'] = $this->input->post('TGL_TUTUP');
            $bulantahun = new DateTime($data['TGL_TUTUP']);
            $data['BLTH'] = $bulantahun->format('Y-m');
            $data['TGL_TUTUP'] = $this->input->post('TGL_TUTUP');
            $data['PLANT']='0';
           
            if ($id == '') {
                    $data['STATUS'] = $this->input->post('VALUE_SETTING');           
                    if ($this->tbl_get->save_as_new($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
            }else{
                $data['TGL_UPDATE']=date("Y/m/d H:i:s");
                $data['UPDATE_BY']=$this->session->userdata('user_name');
                    if ($this->tbl_get->save($data, $id)) {
                        $data['ID_MUTASI'] =$id;
                        $data['TGL_LOG']=date("Y/m/d H:i:s");
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
