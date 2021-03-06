<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level1
 */
class lap_persediaan extends MX_Controller {

    private $_title = 'Laporan Persediaan';
    private $_limit = 10;
    private $_module = 'laporan/lap_persediaan';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('lap_persediaan_model','tbl_get');
    }

    public function index() {
        $get_data = $this->tbl_get->data();
        $data = $get_data->get()->row();
        echo json_encode($data, true);
    }

    
    // public function index() {
        // Load Modules
        // $this->load->module("template/asset");

        // // Memanggil plugin JS Crud
        // $this->asset->set_plugin(array('crud'));

        // $data['button_group'] = array();
        // if ($this->laccess->otoritas('add')) {
        //     $data['button_group'] = array(
        //         anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        //     );
        // }

        // $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        // $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/load');
        // echo Modules::run("template/admin", $data);
    // }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }
        $data['reg_options'] = $this->tbl_get->options_reg();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);

        echo json_encode($message, true); die;

        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'COCODE';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'LEVEL1' => 'left', 'COCODE' => 'center', 'NAMA_REGIONAL' => 'left', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Level 1", 1, 1,
            "Company Code", 1, 1,
            "Regional ", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional','required');
        $this->form_validation->set_rules('LEVEL1', 'Level 1', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('COCODE', 'Company Code', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
            $data['LEVEL1'] = $this->input->post('LEVEL1');
            $data['COCODE'] = $this->input->post('COCODE');

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
