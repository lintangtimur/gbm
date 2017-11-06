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
 * @module Dashboard Peta Jalur Pasokan
 */
class peta_jalur extends MX_Controller {

    private $_title = 'PETA JALUR';
    private $_limit = 10;
    private $_module = 'dashboard/peta_jalur';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('peta_jalur_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS 
        $this->asset->set_plugin(array('map_osm', 'font-awesome'));


        $data['page_title'] = '<i class="icon-map"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function get_peta() {
        $rest = $this->peta_jalur_model->get_peta();
        echo json_encode($rest);
    }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
