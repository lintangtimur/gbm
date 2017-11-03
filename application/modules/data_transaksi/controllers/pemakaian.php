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
 *
 */
class pemakaian extends MX_Controller
{

    private $_title = 'Mutasi Pemakaian';
    private $_limit = 10;
    private $_module = 'data_transaksi/pemakaian';

    public function __construct()
    {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        
        /* Load Global Model */
        $this->load->model('pemakaian_model', 'tbl_get');
    }

    public function index()
    {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));

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

    public function edit($id) {
        $this->add($id);
    }    

    public function add($id = '')
    {
        $page_title = 'Tambah Pemakaian';
        $data = $this->get_level_user();
        $data['id'] = $id;


        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        if ($level_user==2){
            $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        }        

        if ($id != '') {
            $page_title = 'Edit Pemakaian';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();
            $lv1 = $data['default']->ID_REGIONAL; 
            $lv2 = $data['default']->COCODE;
            $lv3 = $data['default']->PLANT;
            $lv4 = $data['default']->STORE_SLOC;
            $tgl_catat = new DateTime($data['default']->TGL_PENCATATAN);
            $tgl_mutasi = new DateTime($data['default']->TGL_MUTASI_PENGAKUAN);
        }

        $data['option_jenis_pemakaian'] = $this->tbl_get->options_jenis_pemakaian();
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
            $page_title = 'Detail Pemakaian';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();
            $lv1 = $data['default']->ID_REGIONAL; 
            $lv2 = $data['default']->COCODE;
            $lv3 = $data['default']->PLANT;
            $lv4 = $data['default']->STORE_SLOC;
            $tgl_catat = new DateTime($data['default']->TGL_PENCATATAN);
            $tgl_mutasi = new DateTime($data['default']->TGL_MUTASI_PENGAKUAN);

            $data['default']->TGL_PENCATATAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_MUTASI_PENGAKUAN = $tgl_mutasi->format('d-m-Y');
    
            // print_r($data['default']); die;
        }
        $data['option_jenis_pemakaian'] = $this->tbl_get->options_jenis_pemakaian();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_edit', $data);
    }

    public function load_level($id = '', $kode = ''){
        $data = $this->tbl_get->load_optionJSON($id, $kode);
        echo json_encode($data);
    }

    public function load($page = 1)
    {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN';
        $table->drildown = true;
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'BLTH' => 'center', 'LEVEL4' => 'center', 'TOTAL_VOLUME' => 'right', 'COUNT' => 'right', 'AKSI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 6;
        $table->header[] = array(
            "NO", 1, 1,
            "BLTH", 1, 1,
            "LEVEL4", 1, 1,
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
        // $this->form_validation->set_rules('NO_PEMAKAIAN', 'No Pemakaian', 'trim|required|max_length[40]');
        $this->form_validation->set_rules('TGL_CATAT', 'Tgl Catat', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'Tgl Pengakuan', 'required');
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional', 'required');
        $this->form_validation->set_rules('COCODE', 'Level l', 'required');
        $this->form_validation->set_rules('PLANT', 'Level 2', 'required');
        $this->form_validation->set_rules('STORE_SLOC', 'Level 3', 'required');
        $this->form_validation->set_rules('SLOC', 'Level 4', 'required');
        $this->form_validation->set_rules('VALUE_SETTING', 'Jenis Pemakaian', 'required');
        $this->form_validation->set_rules('NO_TUG', 'No TUG', 'required');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('VOL_PEMAKAIAN', 'Vol. Pakai', 'required|max_length[25]');

        $kodelevel = $this->input->post("SLOC");
        $data = array();
        $data['TGL_CATAT'] = str_replace('-', '', $this->input->post('TGL_CATAT'));
        $data['TGL_MUTASI'] = date("dmY");
        $data['TGL_PENGAKUAN'] = str_replace('-', '', $this->input->post('TGL_PENGAKUAN'));
        $data['SLOC'] = $kodelevel;
        $data['VALUE_SETTING'] = $this->input->post('VALUE_SETTING');
        $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
        $data['NO_TUG'] = $this->input->post('NO_TUG');
        $data['VOL_PEMAKAIAN'] = str_replace(".","",$this->input->post('VOL_PEMAKAIAN'));
        $data['CREATE_BY'] = $this->session->userdata('user_name');
        $data['KETERANGAN'] = $this->input->post('KETERANGAN');
        $data['NO_PEMAKAIAN'] = $this->input->post('NO_PEMAKAIAN');

        $id = $this->input->post('id');
        $this->load->library('encrypt');
        if ($this->form_validation->run($this)) {

            if ($id == '') {
                $simpan_data = $this->tbl_get->save($data);
                if ($simpan_data[0]->RCDB == 'RC00') {
                    $message = array(true, 'Proses Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', $simpan_data[0]->PESANDB, '');
                }
            } else {
                $data['ID_PEMAKAIAN'] = $id;
                $data['UD_BY_MUTASI_PEMAKAIAN'] = $this->session->userdata('user_name');
                $simpan_data = $this->tbl_get->update($data);
                if ($simpan_data[0]->RCDB == 'RC00') {
                    $message = array(true, 'Proses Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', $simpan_data[0]->PESANDB, '');
                }
            }
        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function getDataDetail($tanggal=null)
    {
        // echo json_encode($this->tbl_get->getTableViewDetail($tanggal));
        echo json_encode($this->tbl_get->getTableViewDetail());
    }

    /**
     * Fungsi akan melakukan pengambilan di table bila checkbok dipilih
     *
     * procedure : PROSES_PEMAKAIAN2
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

        // print_r('idPenerimaan='.$idPenerimaan.' statusPenerimaan='.$statusPenerimaan.' level_user='.$level_user.' user_name='. $user_name.' jumlah='. $jumlah); die;

        $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan, $level_user, $user_name, $jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function proses_lama()
    {
        
        $this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
        $this->form_validation->set_rules('kode_level1', 'Kode Level l', 'required');
        $this->form_validation->set_rules('kode_level2', 'Kode Level 2', 'required');
        $this->form_validation->set_rules('kode_level3', 'Kode Level 3', 'required');
        $this->form_validation->set_rules('kode_level4', 'Kode Level 4', 'required');
        
        $kodelevel = $this->input->post("kode_level4");
        $data = array();
        $data['TGL_CATAT'] = str_replace('-', '', $this->input->post('TGL_CATAT'));
        $data['TGL_MUTASI'] = date("dmY");
        $data['TGL_PENGAKUAN'] = str_replace('-', '', $this->input->post('TGL_PENGAKUAN'));
        $data['SLOC'] = $kodelevel;
        $data['VALUE_SETTING'] = $this->input->post('VALUE_SETTING');
        $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
        $data['NO_TUG'] = $this->input->post('NO_TUG');
        $data['VOL_PEMAKAIAN'] = $this->input->post('VOL_PEMAKAIAN');
        $data['CREATE_BY'] = $this->session->userdata('user_name');
        $data['KETERANGAN'] = $this->input->post('KETERANGAN');
        $data['NO_PEMAKAIAN'] = $this->input->post('NO_PEMAKAIAN');
        $this->load->library('encrypt');
        if ($this->form_validation->run($this)) {
            $simpan_data = $this->tbl_get->save($data);
            if ($simpan_data[0]->RCDB == 'RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
            } else {
                $message = array(false, 'Proses Gagal', 'Proses penyimpanan data gagal.', '');
            }
        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function add_lama($id = '')
    {
        $page_title = 'Tambah Pemakaian';
        $data['id'] = $id;
        
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        //$data['option_level'] = $this->tbl_get->options_level($level_user, $kode_level);
        $data['read'] = array("display:none;","display:none;","display:none;","display:none;");
        $data['option_regional'] = array();
        $data['option_level1'] = array();
        $data['option_level2'] = array();
        $data['option_level3'] = array();
        $data['option_level4'] = array();
        $data['loadlevel'] = base_url($this->_module). '/load_level/';
        if ($level_user === "0"){ /* PUSAT */
            $data['read'] = array("","","","","");
            $data['option_regional'] = $this->tbl_get->load_option("R");
        }else if($level_user === "R"){
            $data['read'] = array("display:none;","","","","");
            $data['option_level1'] = $this->tbl_get->load_option("1", $kode_level);
        }else if($level_user === "1"){
            $data['read'] = array("display:none;","display:none;","","","");
            $data['option_level2'] = $this->tbl_get->load_option("2", $kode_level);
        }else if($level_user === "2"){
            $data['read'] = array("display:none;","display:none;","display:none;","","");
            $data['option_level3'] = $this->tbl_get->load_option("3", $kode_level);
        }else if($level_user === "3"){
            $data['read'] = array("display:none;","display:none;","display:none;","display:none;","");
            $data['option_level3'] = $this->tbl_get->load_option("4", $kode_level);
            $data['option_level4'] = array('--Pilih Level 4--', array_values($data['option_level3'])[0]);
        }else{
            $data['read'] = array("display:none;","display:none;","display:none;","display:none;","");
            $data['option_level4'] = array($kode_level, $kode_level);
        }
        // print_debug($data);
        if ($id != '') {
            $page_title = 'Edit Pemakaian';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
        $data['option_jenis_pemakaian'] = $this->tbl_get->options_jenis_pemakaian();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', '-', 1);  

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user,$kode_level);

        if ($level_user==4){
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
        } else if ($level_user==3){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);  
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get->options_reg(); 
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();  

        return $data;
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
}