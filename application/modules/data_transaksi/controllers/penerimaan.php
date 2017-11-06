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
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('penerimaan_model', 'tbl_get');
        $this->load->model('pemakaian_model', 'tbl_get_combo');
    }

    public function index()
    {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));
        // Memanggil Level User
        $data = $this->get_level_user();

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

    public function add($id = '')
    {
        $page_title = 'Tambah Penerimaan';
        $data = $this->get_level_user();
        $data['id'] = $id;

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        if ($level_user==2){
            $data_lv = $this->tbl_get_combo->get_level($level_user+3,$kode_level);
            if ($data_lv){
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $data['lv3_options'] = $option_lv3;
                $data['lv4_options'] = $this->tbl_get_combo->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
            }
        }    

        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
        }

        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit_view($id = '')
    {
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Detail Penerimaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
        }

        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_edit', $data);
    }

    public function edit($id)
    {
        $this->add($id);
    }

    public function load($page = 1)
    {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('NO' => 'center', 'BLTH' => 'center', 'LEVEL4' => 'center', 'STATUS' => 'center', 'TOTAL_VOLUME' => 'right', 'COUNT' => 'center', 'AKSI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "NO", 1, 1,
            "BLTH", 1, 1,
            "LEVEL4", 1, 1,
//            "STATUS", 1, 1,
            "TOTAL_VOLUME (L)", 1, 1,
            "COUNT", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }


    public function proses()
    {
        $data = array();
        $data['TGL_PENERIMAAN'] = str_replace('-', '', $this->input->post('TGL_PENERIMAAN'));
        $data['TGL_MUTASI'] = date("dmY");
        $data['TGL_PENGAKUAN'] = str_replace('-', '', $this->input->post('TGL_PENGAKUAN'));
        $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
        $data['ID_TRANSPORTIR'] = $this->input->post('ID_TRANSPORTIR');
        $data['SLOC'] = $this->input->post('SLOC');
        $data['VALUE_SETTING'] = $this->input->post('VALUE_SETTING');
        $data['NO_PENERIMAAN'] = $this->input->post('NO_PENERIMAAN');
        $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
        $data['VOL_PENERIMAAN'] =  str_replace(".","",$this->input->post('VOL_PENERIMAAN'));
        $data['VOL_PENERIMAAN_REAL'] = str_replace(".","",$this->input->post('VOL_PENERIMAAN_REAL')); ;
        $data['CREATE_BY'] = $this->session->userdata('user_name');

        $id = $this->input->post('id');

        if ($id!=null || $id!="") {
            $level_user = $this->session->userdata('level_user');
            $kode_level = $this->session->userdata('kode_level');

            $data['ID_PENERIMAAN']=$id;
            $data['LEVEL_USER']=$level_user;
            $data['KODE_LEVEL']=$kode_level;
            $data['STATUS'] = $this->input->post('STATUS_MUTASI_TERIMA');
            $simpan_data = $this->tbl_get->save_edit($data);
            if ($simpan_data[0]->RCDB == 'RC00') {
                $message = array(true, 'Proses Update Berhasil', $simpan_data[0]->PESANDB, '#content_table');
            } else {
                $message = array(false, 'Proses Update Gagal', $simpan_data[0]->PESANDB, '');
            }
        } else {
            $simpan_data = $this->tbl_get->save($data);
            if ($simpan_data[0]->RCDB == 'RC00') {
                $message = array(true, 'Proses Simpan Berhasil', $simpan_data[0]->PESANDB, '#content_table');
            } else {
                $message = array(false, 'Proses Simpan Gagal', $simpan_data[0]->PESANDB, '');
            }
        }
        echo json_encode($message, true);
    }

    public function getDataDetail()
    {
        echo json_encode($this->tbl_get->getTableViewDetail());
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
                if ($statusKirim == 'kirim') {
                    $s = $s . "1" . "#";
                } else if ($statusKirim == 'approve') {
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
        $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan, $level_user, $kode_level, $user_name, $jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function get_level_user()
    {
        $data['lv1_options'] = $this->tbl_get_combo->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get_combo->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get_combo->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get_combo->options_lv4('--Pilih Level 4--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get_combo->get_level($level_user, $kode_level);

        if ($level_user == 4) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $option_lv4;
        } else if ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get_combo->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get_combo->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get_combo->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get_combo->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get_combo->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bulan'] = $this->tbl_get_combo->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get_combo->options_tahun();

        return $data;
    }
}