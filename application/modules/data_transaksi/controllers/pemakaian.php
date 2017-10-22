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

    public function add($id = '')
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


    public function proses()
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

    public function getDataDetail($tanggal)
    {
        echo json_encode($this->tbl_get->getTableViewDetail($tanggal));
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
        $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan, $level_user, $user_name, $jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }
}