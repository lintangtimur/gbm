<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Transportir
 */
class jenis_bahan_bakar extends MX_Controller {

    private $_title = 'Master Jenis Bahan Bakar';
    private $_limit = 10;
    private $_module = 'master/jenis_bahan_bakar';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('jenis_bahan_bakar_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

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
        $page_title = 'Tambah Jenis Bahan Bakar';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Jenis Bahan Bakar';
            $bhn_bakar = $this->jenis_bahan_bakar_model->data($id);
            $data['default'] = $bhn_bakar->get()->row();
        }
        $data['parent_options'] = $this->jenis_bahan_bakar_model->options();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->jenis_bahan_bakar_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_JNS_BHN_BKR';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no' => 'center','kode_bhn_bkr' => 'center', 'nama_bhn_bkr' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Kode Bahan Bakar", 1, 1,
            "Jenis Bahan Bakar", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('KODE_JNS_BHN_BKR', 'Kode Bahan Bakar', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('NAMA_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['KODE_JNS_BHN_BKR'] = $this->input->post('KODE_JNS_BHN_BKR');
            $data['NAMA_JNS_BHN_BKR'] = $this->input->post('NAMA_JNS_BHN_BKR');

            if ($id == '') {
                if ($this->jenis_bahan_bakar_model->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                if ($this->jenis_bahan_bakar_model->save($data, $id)) {
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

        if ($this->jenis_bahan_bakar_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file transportir.php */
/* Location: ./application/modules/transportir/controllers/pemasoj.php */
