<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Pemasok
 */
class pemasok extends MX_Controller {

    private $_title = 'Master Pemasok';
    private $_limit = 10;
    private $_module = 'master/pemasok';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('pemasok_model');
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
        $page_title = 'Tambah Pemasok';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Pemasok';
            $pemasok = $this->pemasok_model->data($id);
            $data['default'] = $pemasok->get()->row();
        }
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->pemasok_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_PEMASOK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('number' => 'center','id_pemasok' => 'center', 'nama_pemasok' => 'center', 'isaktif_pemasok' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Kode Pemasok", 1, 1,
            "Nama Pemasok", 1, 1,
            "Status", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('NAMA_PEMASOK', 'Nama Pemasok', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('KODE_PEMASOK', 'Kode Pemasok', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['KODE_PEMASOK'] = $this->input->post('KODE_PEMASOK');
            $data['NAMA_PEMASOK'] = $this->input->post('NAMA_PEMASOK');
            $data['ISAKTIF_PEMASOK'] = $this->input->post('ISAKTIF_PEMASOK');
            $data['CD_BY_PEMASOK'] = $this->session->userdata('user_name');

            $kd_pemasok=$data['KODE_PEMASOK']; 
            if ($id == '') {
                if ($this->pemasok_model->check_pemasok($kd_pemasok) == FALSE)
                {
                    $message = array(false, 'Proses GAGAL', ' Kode Pemasok '.$kd_pemasok.' Sudah Ada.', '');
                }
                else{
                    $data['CD_PEMASOK'] = date("Y/m/d H:i:s");           
                    if ($this->pemasok_model->save_as_new($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
                }
                
            }else{
                $data_db = $this->pemasok_model->data($id);
                $hasil=$data_db->get()->row();
                $kd=$hasil->KODE_PEMASOK;
                $data['UD_PEMASOK'] = date("Y/m/d H:i:s");
                if($kd==$kd_pemasok){
                    if ($this->pemasok_model->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }else{
                    if ($this->pemasok_model->check_pemasok($kd_pemasok) == FALSE)
                    {
                        $message = array(false, 'Proses GAGAL', ' Kode Pemasok '.$kd_pemasok.' Sudah Ada.', '');
                    }
                    else{           
                        if ($this->pemasok_model->save($data, $id)) {
                            $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                        }
                    }
                }
                    
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->pemasok_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file pemasok.php */
/* Location: ./application/modules/pemasok/controllers/pemasoj.php */
