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
class penerimaan extends MX_Controller
{

    private $_title = 'Mutasi Penerimaan';
    private $_limit = 10;
    private $_module = 'data_transaksi/penerimaan';

    public function __construct()
    {
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('penerimaan_model', 'tbl_get');
    }

    public function index()
    {
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
        $page_title = 'Tambah Penerimaan';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
        $data['option_pemasok'] = $this->tbl_get->options_data('MASTER_PEMASOK');
        $data['option_transportir'] = $this->tbl_get->options_data('MASTER_TRANSPORTIR');
//        $data['option_level'] = $this->tbl_get->options_data('MASTER_LEVEL4');
//        $data['option_jenis_penerimaan'] = $this->tbl_get->options_data('JENIS_PENERIMAAN');
        $data['option_jenis_bbm'] = $this->tbl_get->options_data('M_JNS_BHN_BKR');
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }


    public function load($page = 1)
    {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'BLTH' => 'center', 'LEVEL4' => 'center', 'STATUS' => 'center', 'TOTAL_VOLUME' => 'center', 'COUNT' => 'center', 'AKSI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "NO", 1, 1,
            "BLTH", 1, 1,
            "LEVEL4", 1, 1,
            "STATUS", 1, 1,
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
//        $this->form_validation->set_rules('NO_KONTRAK', 'Nomor Kontrak Transportir', 'trim|required');
//        $this->form_validation->set_rules('NILAI_KONTRAK', 'Nilai Kontrak Transportir', 'trim|required|currency');
//        if ($this->form_validation->run($this)) {
//            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
//            $id = $this->input->post('id');
//
//            $data = array();
//            $data['KD_KONTRAK_TRANS'] = $this->input->post('NO_KONTRAK');
//            $data['ID_TRANSPORTIR'] = $this->input->post('TRANSPORTIR');
//            $data['TGL_KONTRAK_TRANS'] = $this->input->post('TGLKONTRAK');
//            $data['NILAI_KONTRAK_TRANS'] = $this->input->post('NILAI_KONTRAK');
//            $data['KET_KONTRAK_TRANS'] = $this->input->post('KETERANGAN');
//            $data['PATH_KONTRAK_TRANS'] = $this->input->post('FILE_UPLOAD');
//
//            if ($id == '') {
//                if ($this->kontrak_transportir_model->save_as_new($data)) {
//                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
//                }
//            } else {
//                if ($this->kontrak_transportir_model->save($data, $id)) {
//                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
//                }
//            }
//        } else {
//            $message = array(false, 'Proses gagal', validation_errors(), '');
//        }
//        echo json_encode($message, true);
    }

    public function getDataDetail($tanggal)
    {
        echo json_encode($this->tbl_get->getTableViewDetail($tanggal));
    }

    /**
     * Fungsi akan melakukan pengambilan di table bila checkbok dipilih
     *
     * procedure : PROSES_PENERIMAAN_V2
     * @param $idPenerimaan format idPenerimaan1#idPenerimaan2#idPenerimaan3
     * @param $status format status1#status2#status3
     * @param $level_user dari session
     * @param $kode_level dari session
     * @param $user_name dari session
     * @param $jumlah jumlah data yang di inputkan
     */
    public function saveKiriman($statusKirim)
    {
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $p . $pilihan[$i] . "#";
                if ($statusKirim =='kirim') {
                    $s = $s . "1" . "#";
                } else if ($statusKirim == 'approve'){
                    $s = $s . "2" . "#";
                } else {
                    $s = $s . "3" . "#";
                }
            }
        }
        $idPenerimaan = substr($p, 0, strlen($p) - 1);
        $statusPenerimaan = substr($s, 0, strlen($s) - 1);
        $jumlah = count($pilihan);
//        echo "call PROSES_PENERIMAAN_V2('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user_name."',".$jumlah.")";
//        echo "<br/>";
        $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$kode_level,$user_name,$jumlah);

        if ($simpan[0]->RCDB == "RC00"){
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table' );
        } else{
            $message = array(false, 'Proses Gagal',  $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }
}