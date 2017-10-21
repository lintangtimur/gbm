<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module persediaan_bbm
 */
class persediaan_bbm extends MX_Controller {

    private $_title = 'Persediaan BBM';
    private $_limit = 10;
    private $_module = 'laporan/persediaan_bbm';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('persediaan_bbm_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        // $this->asset->set_plugin(array('bootstrap-rakhmat'));

        // $lv1 = '-';
        $lv2 = '-';
        $lv3 = '-';
        $lv4 = '-';

        $data['lv1_options'] = $this->tbl_get->options_lv1(); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $lv2, 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $lv3, 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $lv4, 1);  
        $data['opsi_bbm'] = $this->tbl_get->option_jenisbbm();  
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();  

        // $get_data = $this->tbl_get->data();
        // $data = $get_data->get()->row();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        
        echo Modules::run("template/admin", $data);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);

        // echo json_encode($message, true); die;

        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_MUTASI_PERSDIAAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'LEVEL1' => 'left', 'COCODE' => 'center', 'NAMA_REGIONAL' => 'left', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 18;
        $table->header[] = array(
            "No", 1, 1,
            "Wilayah", 1, 1,
            "Area", 1, 1,
            "Rayon", 1, 1,
            "Pembangkit", 1, 1,
            "Bahan Bakar", 1, 1,
            "Tgl Mutasi Persediaan", 1, 1,
            "Stock Awal", 1, 1,
            "Penerimaan Real", 1, 1,
            "Pemakaian Sendiri", 1, 1,
            "KIRIM", 1, 1,
            "VOLUME OPNAME", 1, 1,
            "DEAD STOCK", 1, 1,
            "STOCK AKHIR REAL", 1, 1,
            "STOCK AKHIR EFEKTIF", 1, 1,
            "STOCK AKHIR KOREKSI", 1, 1,
            "SHO", 1, 1,
            "REV", 1, 1,
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function get_options_lv1($key=null) {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->tbl_get->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->tbl_get->options_lv4('--Pilih Level 4--', $key, 0);
        echo json_encode($message);
    }
    public function get_options_bbm() {
        $message = $this->tbl_get->options_bhn_bkr('--Pilih Jenis BBM--', $key, 0);
        echo json_encode($message);
    }

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
