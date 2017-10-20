<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 19:10 AM
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Wilayah
 */
class penerimaan extends MX_Controller {

    private $_title = 'Mutasi Penerimaan';
    private $_limit = 10;
    private $_module = 'data_transaksi/penerimaan';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('penerimaan_model', 'tbl_get');
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
        $data['detail_penerimaan'] = base_url($this->_module . '/load_detail');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Perhitungan';
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

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center','BLTH' => 'center', 'LEVEL4' => 'center','STATUS' => 'center', 'TOTAL_VOLUME' => 'center', 'COUNT' => 'center','AKSI'=>'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "NO", 1, 1,
            "BLTH", 1, 1,
            "LEVEL4", 1, 1,
            "STATUS",1,1,
            "TOTAL_VOLUME", 1, 1,
            "COUNT", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        //$this->form_validation->set_rules('ID_PEMASOK', 'ID_PEMASOK', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['ID_PERHITUNGAN'] = $this->input->post('ID_PERHITUNGAN');
            // $data['NAMA_DEPO'] = $this->input->post('NAMA_DEPO');
            // $data['LAT_DEPO'] = $this->input->post('LAT_DEPO');
            // $data['LOT_DEPO'] = $this->input->post('LOT_DEPO');
            // $data['ALAMAT_DEPO'] = $this->input->post('ALAMAT_DEPO');



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

    public function load_detail($page = 1){
        $data_table = $this->tbl_get->data_table_detail($this->_module, $this->_limit, $page);
//        print_r($data_table);
//        print_r($data_table);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'DETAIL_PENERIMAAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID' => 'center','TGL_PENGAKUAN' => 'center', 'NAMA_PEMASOK' => 'center','NAMA_TRANSPORTIR' => 'center', 'NAMA_JNS_BHN_BKR' => 'center', 'VOL_TERIMA' => 'center','VOL_TERIMA_REAL' => 'center','STATUS'=>'center','AKSI'=>'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "ID", 1, 1,
            "TGL_PENGAKUAN", 1, 1,
            "NAMA_PEMASOK", 1, 1,
            "NAMA_TRANSPORTIR",1,1,
            "NAMA_JNS_BHN_BKR", 1, 1,
            "VOL_TERIMA", 1, 1,
            "VOL_TERIMA_REAL", 1, 1,
            "STATUS", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }
}