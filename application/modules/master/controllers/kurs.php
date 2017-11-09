<?php

 /**
* @module KURS
* @author  RAKHMAT WIJAYANTO
* @created at 07 NOVEMBER 2017
* @modified at 07 OKTOBER 2017
*/

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module KURS
 */
class kurs extends MX_Controller {

    private $_title = 'KURS';
    private $_limit = 10;
    private $_module = 'master/kurs';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('kurs_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

 


    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KURS';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_KURS' => 'center', 'TGL_KURS' => 'center', 'NOMINAL' => 'center', 'JUAL' => 'center', 'KTBI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Tanggal", 1, 1,
            "Kurs Beli", 1, 1,
            "Kurs Jual", 1, 1,
            "KTBI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
?>