<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master tangki
 */
class tangki extends MX_Controller {

    private $_title = 'Master Tangki';
    private $_limit = 10;
    private $_module = 'master/tangki';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('tangki_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        }
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Tangki';
        $data['id_dok'] = $id;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Tangki';
            $tangki = $this->tangki_model->dataEdit($id);
            $data['default'] = $tangki->get()->row();
            // $trans = $this->tangki_model->get_detail($id);
            // $data['data_detail'] = $trans->get()->row();
            $data['id_dok'] = $data['default']->PATH_DET_TERA;


             
        }
        $data['unit_pembangkit'] = $this->tangki_model->option_pembangkit('--Pilih Unit Pembangkit--', array('master_tangki.SLOC' => NULL));
        $data['jenis_bbm'] = $this->tangki_model->option_jenisbbm('--Pilih Jenis BBM--', array('master_tangki.ID_JNS_BHN_BKR' => NULL));
        $data['tera'] = $this->tangki_model->option_tera();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tangki_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_VENDOR';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('number' => 'center','unit_pembangkit' => 'center','jenis_bbm' => 'center','kapasitas' => 'center','deadstock' => 'center','stockefektif' => 'center','aksi' => 'center');
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
        $this->form_validation->set_rules('unit_pembangkit', 'Unit Pembangkit', 'trim|required');
        $this->form_validation->set_rules('jenis_bbm', 'Jenis Bahan Bakar', 'trim|required');
        // $this->form_validation->set_rules('TERA', 'Tera', 'trim|required');
        $this->form_validation->set_rules('KAPASITAS', 'Kapasitas', 'trim|required|numeric');
        $this->form_validation->set_rules('DEAD_STOCK', 'Dead Stok', 'trim|required|numeric');
        $this->form_validation->set_rules('STOCK_EFEKTIF', 'Stock Efektif', 'trim|required|numeric');
        $id = $this->input->post('id');
         if ($id == '') {
            if (empty($_FILES['FILE_UPLOAD']['name'])){
                $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
            }
        }
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['SLOC'] = $this->input->post('unit_pembangkit');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('jenis_bbm');
            $data['NAMA_TANGKI'] = $this->input->post('NAMA_TANGKI');
            $data['VOLUME_TANGKI'] = $this->input->post('KAPASITAS');
            $data['DEADSTOCK_TANGKI'] = $this->input->post('DEAD_STOCK');
            $data['STOCKEFEKTIF_TANGKI'] = $this->input->post('STOCK_EFEKTIF');
            $data['UD_BY_TANGKI'] = $this->session->userdata('user_name');
            $tera['TGL_DET_TERA'] = $this->input->post('TGL_TERA');
           
            if ($id == '') {
                $data['CD_TANGKI'] = date("Y/m/d");
                $data['UD_TANGKI'] = date("Y/m/d");

                $new_name = date('Ymd').'_'.$_FILES["FILE_UPLOAD"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload_tangki/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 4; 

                // print_r($config);

                $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('FILE_UPLOAD')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    } else {
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];
                            if ($this->tangki_model->save_as_new($data,$nama_file)) {
                                $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');
                            }
                    }
                }
            } else {
                $data['UD_TANGKI'] = date('Y-m-d');
                if ($this->tangki_model->save($data, $id)) {
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

        if ($this->tangki_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file tangki.php */
/* Location: ./application/modules/tangki/controllers/pemasoj.php */
