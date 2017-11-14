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
 * @module STOCK OPNAME
 */
class stock_opname extends MX_Controller {

    private $_title = 'Stock Opname';
    private $_limit = 10;
    private $_module = 'data_transaksi/stock_opname';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('stock_opname_model', 'tbl_get');
        $this->load->model('laporan/persediaan_bbm_model','tbl_get_combo');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-column','format_number'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('file-upload'));
        

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data = $this->get_level_user(); 


        $data['opsi_bbm'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun(); 

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

     public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data = $this->get_level_user(); 
        $data['id'] = $id;
        $data['id_dok'] = '';

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        if ($level_user==2){
            $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
            if ($data_lv){
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $data['lv3_options'] = $option_lv3;
                $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1);
            }
        }  
        $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        if ($id != '') {
            $page_title = 'Edit Stock Opname';
            $get_tbl = $this->tbl_get->dataToUpdate($id);
            $data['default'] = $get_tbl->get()->row();
            $level_user = $this->session->userdata('level_user');
            if($level_user==0){
                $data['lv1_options'] = $this->tbl_get->options_lv1_view();;
                $data['lv2_options'] = $this->tbl_get->options_lv2_view();
                $data['lv3_options'] = $this->tbl_get->options_lv3_view();
                $data['lv4_options'] = $this->tbl_get->options_lv4_view();
            }
            $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        }
        
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

     public function edit($id) {
        $this->add($id);
    }

    public function loadApprove($id = '') {
        $page_title = 'Approve '.$this->_title;
        $data = $this->get_level_user(); 
        $data['id'] = $id;

        $get_tbl = $this->tbl_get->dataToUpdate($id);
        $data['default'] = $get_tbl->get()->row();
        $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['lv4_options'] = $this->tbl_get->options_lv4_view();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/prosesApprove');
        $this->load->view($this->_module . '/form_approve', $data);
    }

    public function loadView($id = '') {
        $page_title = 'View '.$this->_title;
        $data = $this->get_level_user(); 
        $data['id'] = $id;

        $get_tbl = $this->tbl_get->dataToUpdate($id);
        $data['default'] = $get_tbl->get()->row();
        $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['lv4_options'] = $this->tbl_get->options_lv4_view();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/prosesApprove');
        $this->load->view($this->_module . '/form_approve', $data);
    }

      public function prosesApprove(){
       $cek=$this->input->post('setuju');
       $id =$this->input->post('id');
       if($cek==2){
            $this->approveAction($id);
       }else{
            $this->tolakAction($id);
       }     
    }
    
     public function sendAction($id=''){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="1";

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses kirim data berhasil.', '#content_table');
            }else{
                $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
            }
        }
        echo json_encode($message);
     }
     public function approveAction($id){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses Appove data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="2";

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses approve data berhasil.', '#content_table');
            }else{
                $message = array(false, 'Proses gagal', 'Proses approve data gagal.', '');
            }
        }
        echo json_encode($message);
     }
     public function tolakAction($id){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses tolak data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="3";

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses tolak data berhasil.', '#content_table');
            }else{
                $message = array(false, 'Proses gagal', 'Proses tolak data gagal.', '');
            }
        }
        echo json_encode($message);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_STOCKOPNAME';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_STOCKOPNAME' => 'center', 'NO_STOCKOPNAME' => 'center', 'TGL_PENGAKUAN' => 'center', 'NAMA_JNS_BHN_BKR' => 'center', 'LEVEL4' => 'center', 'VOLUME_STOCKOPNAME' => 'right', 'STATUS_APPROVE_STOCKOPNAME' => 'center' , 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
            "No", 1, 1,
            "No Stok Opname", 1, 1,
            "Tgl Stok Opname", 1, 1,
            "Jenis Bahan Bakar", 1, 1,
            "Nama Pembangkit", 1, 1,
            "Total Volume (L)", 1, 1,
            "Status", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
        
    }


    public function proses() {
        $this->form_validation->set_rules('NO_STOCKOPNAME', 'NO STOCKOPNAME', 'trim|required|max_length[25]');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'JENIS BAHAN BAKAR', 'required');
        $this->form_validation->set_rules('TGL_BA_STOCKOPNAME', 'TANGGAL BA STOCKOPNAME', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'TANGGAL PENGAKUAN STOCKOPNAME', 'required');
        $this->form_validation->set_rules('SLOC', 'PEMBANGKIT', 'required');
        $this->form_validation->set_rules('VOLUME_STOCKOPNAME', 'VOLUME STOCKOPNAME', 'required');

        $id = $this->input->post('id');

        if ($id == '') {
            if (empty($_FILES['FILE_UPLOAD']['name'])){
                $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
            }
        }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['NO_STOCKOPNAME'] = $this->input->post('NO_STOCKOPNAME');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['TGL_BA_STOCKOPNAME'] = $this->input->post('TGL_BA_STOCKOPNAME');
            $data['TGL_PENGAKUAN'] = $this->input->post('TGL_PENGAKUAN');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['VOLUME_STOCKOPNAME'] = str_replace(".","",$this->input->post('VOLUME_STOCKOPNAME'));
            $data['STATUS_APPROVE_STOCKOPNAME'] = $this->input->post('0');

            if ($id == '') {
                $new_name = $data['NO_STOCKOPNAME'].'_'.date("YmdHis");
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload_stock_opname/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 4; 
                $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
    
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('FILE_UPLOAD')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                } 
                else {
                    $res = $this->upload->data();
                    if ($res){
                        $nama_file= $res['file_name'];
                        $data['PATH_STOCKOPNAME'] = $nama_file;
                        $data['CD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                        $data['CD_DATE_STOKOPNAME'] = date('Y-m-d');
                        if ($this->tbl_get->save_as_new($data)) {
                             $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                        }
                    }
                }
            } 
            else {
                if (empty($_FILES['FILE_UPLOAD']['name'])){
                    $data['UD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                    $data['UD_DATE_STOKOPNAME'] = date('Y-m-d');
                    if ($this->tbl_get->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }
                else{
                    $dataa = $this->tbl_get->dataToUpdate($id);
                    $hasil=$dataa->get()->row();
                    $file_name=$hasil->PATH_STOCKOPNAME;
                    $target='assets/upload_stock_opname/'.$file_name;
                                    
                    if ($file_name == '') {
                        if (empty($_FILES['FILE_UPLOAD']['name'])){
                            $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
                            }
                    }
                            
                    if($_FILES['FILE_UPLOAD']['name']!= $file_name || $_FILES['FILE_UPLOAD']['size']!= filesize($target)){
                        if(file_exists($target)){
                            unlink($target);
                            }
                    }
                            
                    $new_name = $data['NO_STOCKOPNAME'].'_'.date("YmdHis");
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload_stock_opname/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 4; 
                    $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('FILE_UPLOAD')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    }
                    else{
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];
                            $data['PATH_STOCKOPNAME'] = $nama_file;
                            $data['UD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                            $data['UD_DATE_STOKOPNAME'] = date('Y-m-d');
                            if ($this->tbl_get->save($data, $id)) {
                                $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                                }
                            }
                        }
            
                    }
                }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }
    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
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
        $message = $this->tbl_get->options_lv4('--Pilih Level 4--', $key, 0);
        echo json_encode($message);
    }
    public function get_options_bbm() {
        $message = $this->tbl_get->options_bhn_bkr('--Pilih Jenis BBM--', $key, 0);
        echo json_encode($message);
    }

    public function get_level_user(){
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get_combo->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get_combo->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options'] = $this->tbl_get_combo->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options'] = $this->tbl_get_combo->options_lv4('--Pilih Level 4--', '-', 1);  

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get_combo->get_level($level_user,$kode_level);

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
            $data['lv4_options'] = $this->tbl_get_combo->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get_combo->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);  
           
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get_combo->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get_combo->options_reg(); 
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get_combo->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function get_sum_detail() {
        $message = $this->tbl_get->get_sum_detail();
        echo json_encode($message);
    }
  
	public function load_jenisbbm($idsloc = ''){
		$this->load->model('stock_opname_model');
		$message = $this->stock_opname_model->options_jns_bhn_bkr('--Pilih Jenis BBM--', $idsloc);
		echo json_encode($message);
	}
  
}

/* End of file stockopname.php */

