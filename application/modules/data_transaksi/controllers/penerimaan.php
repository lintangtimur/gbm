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
 * @module Transaksi
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
		$data['option_komponen'] = array();
        if ($level_user==2){
            $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
            if ($data_lv){
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $data['lv3_options'] = $option_lv3;
                $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1); 
            }
        }    

        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }
			
            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
        }
		$data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
		$data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
		if ($id != '')
			$data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
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

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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
            }

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
        if ($id != '')
        $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
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
            "PEMBANGKIT", 1, 1,
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


    public function proses(){
        $this->form_validation->set_rules('TGL_PENERIMAAN', 'Tanggal Penerimaan (DO/TUG)', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'Tanggal Pengakuan Fisik', 'required');
        $this->form_validation->set_rules('ID_PEMASOK', 'Pemasok', 'required');
        $this->form_validation->set_rules('ID_TRANSPORTIR', 'Transportir', 'required');
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional', 'required');
        $this->form_validation->set_rules('COCODE', 'Level l', 'required');
        $this->form_validation->set_rules('PLANT', 'Level 2', 'required');
        $this->form_validation->set_rules('STORE_SLOC', 'Level 3', 'required');
        $this->form_validation->set_rules('SLOC', 'Pembangkit', 'required');
        $this->form_validation->set_rules('VALUE_SETTING', 'Jenis Penerimaan', 'required');
        $this->form_validation->set_rules('NO_PENERIMAAN', 'No Penerimaan', 'required|max_length[30]');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('VOL_PENERIMAAN', 'Volume DO/TUG', 'required|max_length[16]');
        $this->form_validation->set_rules('VOL_PENERIMAAN_REAL', 'Volume Penerimaan', 'required|max_length[16]');
		
		$ismix = $this->input->post('ismix');
		if ($ismix == '1')
			$this->form_validation->set_rules('KOMPONEN', 'Komponen Jenis BBm', 'required');

        if ($this->form_validation->run($this)) {

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
            $data['VOL_PENERIMAAN'] =  str_replace(",",".",$data['VOL_PENERIMAAN']);
            $data['VOL_PENERIMAAN_REAL'] = str_replace(".","",$this->input->post('VOL_PENERIMAAN_REAL'));
            $data['VOL_PENERIMAAN_REAL'] = str_replace(",",".",$data['VOL_PENERIMAAN_REAL']);
            $data['CREATE_BY'] = $this->session->userdata('user_name');
			$data['IS_MIX'] = $this->input->post("ismix");
			$data['ID_KOMPONEN'] = $this->input->post("KOMPONEN");
            $data['KET_MUTASI_TERIMA'] = $this->input->post("KET_MUTASI_TERIMA");   

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
        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function getDataDetail()
    {
        echo json_encode($this->tbl_get->getTableViewDetail());
    }

    public function saveKiriman($statusKirim)
    {
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        // for ($i = 0; $i < count($idPenerimaan); $i++) {
        //     if (isset($pilihan[$i])) {
        //         $p = $p . $pilihan[$i] . "#";
        //         if ($statusKirim == 'kirim') {
        //             $s = $s . "1" . "#";
        //         } else if ($statusKirim == 'approve') {
        //             $s = $s . "2" . "#";
        //         } else {
        //             $s = $s . "3" . "#";
        //         }
        //     }
        // }

        $jumlah=1;
        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $pilihan[$i];
                if ($statusKirim == 'kirim') {
                    $s = "1";
                } else if ($statusKirim == 'approve') {
                    $s = "2";
                } else {
                    $s = "3";
                }
                
                $simpan = $this->tbl_get->saveDetailPenerimaan($p, $s, $level_user, $kode_level, $user_name, $jumlah);
            }
        }

        // print_r($simpan); die;

        // $idPenerimaan = substr($p, 0, strlen($p) - 1);
        // $statusPenerimaan = substr($s, 0, strlen($s) - 1);
        // $jumlah = count($pilihan);

        // $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan, $level_user, $kode_level, $user_name, $jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function saveKirimanClossing($statusKirim)
    {
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        $sloc = $this->input->post('vSLOC'); 
        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $p . $pilihan[$i] . "#";
                if ($statusKirim == 'kirim') {
                    $s = $s . "5" . "#";
                } else if ($statusKirim == 'approve') {
                    $s = $s . "6" . "#";
                } else {
                    $s = "7". "#";
                }
            }
        }

        $idPenerimaan = substr($p, 0, strlen($p) - 1);
        $statusPenerimaan = substr($s, 0, strlen($s) - 1);
        $jumlah = count($pilihan);

        // print_r('p_sloc='.$sloc.' p_id='.$idPenerimaan.' p_lvl_user='.$level_user.' p_status='.$statusPenerimaan.' p_kode_lvl='.$kode_level.' p_by_user='.$user_name.' p_totalcheck='.$jumlah); die;

        $simpan = $this->tbl_get->saveDetailClossing($sloc,$idPenerimaan,$level_user,$statusPenerimaan,$kode_level,$user_name,$jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function get_level_user()
    {
        $data['options_order'] = $this->tbl_get->options_order();
        $data['options_asc'] = $this->tbl_get->options_asc();
        $data['options_order_d'] = $this->tbl_get->options_order_d();
        $data['options_asc_d'] = $this->tbl_get->options_asc();
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

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
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
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

    public function get_sum_detail() {
        $message = $this->tbl_get->get_sum_detail();
        echo json_encode($message);
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
        $message = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

	public function load_jenisbbm($idsloc = ''){
		$this->load->model('stock_opname_model');
		$message = $this->stock_opname_model->options_jns_bhn_bkr('--Pilih Jenis BBM--', $idsloc);
		echo json_encode($message);
	}
	
	public function load_komponen($id = ''){
		$message = $this->tbl_get->option_komponen($id);
		echo json_encode($message);
	}
}