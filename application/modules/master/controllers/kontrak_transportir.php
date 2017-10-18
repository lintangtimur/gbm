<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master kontrak_transportir
 */
class kontrak_transportir extends MX_Controller {

    private $_title = 'Master Data Kontrak Transportir';
    private $_limit = 10;
    private $_module = 'master/kontrak_transportir';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('kontrak_transportir_model');
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
        $page_title = 'Tambah Tangki';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Tangki';
            $tangki = $this->kontrak_transportir_model->data($id);
            $data['default'] = $tangki->get()->row();
        }
        $data['option_transportir'] = $this->kontrak_transportir_model->options();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->kontrak_transportir_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_VENDOR';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_VENDOR' => 'center','KODE_VENDOR' => 'center', 'NAMA_VENDOR' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "No", 1, 1,
            "Pembangkit", 1, 1,
            "Jenis BBM", 1, 1,
            "Kapasitas", 1, 1,
            "Dead Stock", 1, 1,
            "Stock Efektif", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('NAMA_VENDOR', 'Nama kontrak_transportir', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['NO_KONTRAK'] = $this->input->post('NO_KONTRAK');
            $data['KODE_VENDOR'] = $this->input->post('parent_id');
            $data['KODE_VENDOR'] = $this->input->post('tglkontrak');
            $data['KODE_VENDOR'] = $this->input->post('JML_PASOKAN');
            $data['KODE_VENDOR'] = $this->input->post('NILAI_KONTRAK');
            $data['KODE_VENDOR'] = $this->input->post('KETERANGAN');
            $data['KODE_VENDOR'] = $this->input->post('FILE_UPLOAD');

            if ($id == '') {
                if ($this->kontrak_transportir_model->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                if ($this->kontrak_transportir_model->save($data, $id)) {
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

        if ($this->kontrak_transportir_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file kontrak_transportir.php */
/* Location: ./application/modules/kontrak_transportir/controllers/pemasoj.php */
