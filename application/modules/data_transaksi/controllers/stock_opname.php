<?php

/**
 * @module STOCK OPNAME
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Wilayah
 */
class stock_opname extends MX_Controller {

    private $_title = 'Stock Opname';
    private $_limit = 10;
    private $_module = 'data_transaksi/stock_opname';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
       $this->load->model('stock_opname_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-custom'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('file-upload'));
        

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
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
            $page_title = 'Edit Stock Opname';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
        $data['parent_options'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['parent_options_pem'] = $this->tbl_get->options_pembangkit();
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
        $table->id = 'ID_STOCKOPNAME';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_STOCKOPNAME' => 'center', 'NO_STOCKOPNAME' => 'center', 'TGL_PENGAKUAN' => 'center', 'NAMA_JNS_BHN_BKR' => 'center', 'LEVEL4' => 'center', 'VOLUME_STOCKOPNAME' => 'center', 'STATUS_APPROVE_STOCKOPNAME' => 'center' , 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
            "No", 1, 1,
            "No Stock Opname", 1, 1,
            "Tgl Stock Opname", 1, 1,
            "Jenis Bahan Bakar", 1, 1,
            "Nama Pembangkit", 1, 1,
            "Total Volume", 1, 1,
            "Detil", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
        
    }

    public function proses() {
        $this->form_validation->set_rules('NO_STOCKOPNAME', 'NO STOCKOPNAME', 'required');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'JENIS BAHAN BAKAR', 'required');
        $this->form_validation->set_rules('TGL_BA_STOCKOPNAME', 'TANGGAL BA STOCKOPNAME', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'TANGGAL PENGAKUAN STOCKOPNAME', 'required');
        $this->form_validation->set_rules('SLOC', 'PEMBANGKIT', 'required');
        $this->form_validation->set_rules('VOLUME_STOCKOPNAME', 'VOLUME STOCKOPNAME', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['NO_STOCKOPNAME'] = $this->input->post('NO_STOCKOPNAME');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['TGL_BA_STOCKOPNAME'] = $this->input->post('TGL_BA_STOCKOPNAME');
            $data['TGL_PENGAKUAN'] = $this->input->post('TGL_PENGAKUAN');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['VOLUME_STOCKOPNAME'] = $this->input->post('VOLUME_STOCKOPNAME');
            $data['STATUS_APPROVE_STOCKOPNAME'] = $this->input->post('0');
            
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

   
 

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
