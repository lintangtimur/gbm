<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master kontrak_transportir
 */
class kontrak_transportir extends MX_Controller {

    private $_title = 'Master Data Kontrak Transportir';
    private $_limit = 10;
    private $_module = 'master/kontrak_transportir';
	private $_urlgetfile = "";
	private $_url_movefile = "";

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
		$this->_url_movefile = $this->laccess->url_serverfile()."move";
		$this->_urlgetfile = $this->laccess->url_serverfile()."geturl";

        /* Load Global Model */
        $this->load->model('kontrak_transportir_model');
        $this->load->model('kontrak_transportir_adendum_model','tbl_get_adendum');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));
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
        $page_title = 'Tambah Kontrak';
        $data = $this->cekLevelUser();
        $data['id'] = $id;
		$data['id_dok'] = '';
		$data["url_getfile"] = $this->_urlgetfile;
        if ($id != '') {
            $page_title = 'Edit Kontrak';
            $trans = $this->kontrak_transportir_model->data($id);
            $data['default'] = $trans->get()->row();
            $data['id_dok'] = $data['default']->PATH_KONTRAK_TRANS; 
            // $trans = $this->kontrak_transportir_model->dataEdit($id);
            // $data['detail'] = $trans->get()->result();
        }
        $data['option_transportir'] = $this->kontrak_transportir_model->options('--Pilih Transportir--', array('master_transportir.ID_TRANSPORTIR' => NULL));
        $data['option_depo'] = $this->kontrak_transportir_model->getDepo();
        $data['option_jalur'] = $this->kontrak_transportir_model->getJalur();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->kontrak_transportir_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KONTRAK_TRANS';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no_kontrak' => 'center','nama_transportir' => 'center','periode' => 'center','nilai_kontrak' => 'right','keterangan' => 'center', 'perubahan' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 6;
        $table->header[] = array(
            "No Kontrak", 1, 1,
            "Transportir", 1, 1,
            "Periode", 1, 1,
            "Harga", 1, 1,
            "Keterangan", 1, 1,
            "Perubahan", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('KD_KONTRAK_TRANS', 'Nomor Kontrak Transportir', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('ID_TRANSPORTIR', 'Transportir', 'trim|required');
        $this->form_validation->set_rules('NILAI_KONTRAK', 'Nilai Kontrak Transportir', 'trim|required|');
        $this->form_validation->set_rules('JML_PASOKAN', 'Pasokan', 'trim|required|');
        $pasokan = $this->input->post('JML_PASOKAN');

        $id = $this->input->post('id');
         if ($id == '') {
            if (empty($_FILES['FILE_UPLOAD']['name'])){
                $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
            }
        }

        $x = $this->input->post('JML_PASOKAN');

        if ($x>0){
            if ($x>20){
                $x=20;
            }
            for ($i=1; $i<=$x; $i++) {
                $this->form_validation->set_rules('depo_ke'.$i, 'Depo ke '.$i, 'required');
                $this->form_validation->set_rules('pembangkit_ke'.$i, 'Pembangkit ke '.$i, 'required');

                $this->form_validation->set_rules('jalur_ke'.$i, 'Jalur ke '.$i, 'required');
                $this->form_validation->set_rules('harga_ke'.$i, 'Harga ke '.$i, 'required');
                $this->form_validation->set_rules('jarak_ke'.$i, 'Jarak ke '.$i, 'required');
            }
        }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            // $data['KD_KONTRAK_TRANS'] = $this->input->post('NO_KONTRAK');
            $data['ID_TRANSPORTIR'] = $this->input->post('ID_TRANSPORTIR');
            $data['TGL_KONTRAK_TRANS'] = $this->input->post('TGL_KONTRAK_TRANS');
            $data['NILAI_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('NILAI_KONTRAK'));
            $data['KET_KONTRAK_TRANS'] = $this->input->post('KETERANGAN');
            $data['KD_KONTRAK_TRANS'] = $this->input->post('KD_KONTRAK_TRANS');
            $data['CD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['CD_BY_DET_KONTRAK_TRANS'] = $this->session->userdata('user_name');
            
            $level_user = $this->session->userdata('level_user');
            $kode_level = $this->session->userdata('kode_level');
               
            $data_lv = $this->kontrak_transportir_model->get_level($level_user,$kode_level);

            if ($data_lv){
                $data['PLANT'] = $data_lv[0]->PLANT;    
            } else {
                $data['PLANT'] = '';
            }
            

            $data_detail = array();
            for ($i=1; $i<=$x; $i++)
            {
                $depo_ke = $this->input->post('depo_ke'.$i);
                $pembangkit_ke = $this->input->post('pembangkit_ke'.$i);
                $jalur_ke = $this->input->post('jalur_ke'.$i);
                $harga_ke = $this->input->post('harga_ke'.$i);
                $harga_ke = str_replace(".","",$harga_ke);
                $jarak_ke = $this->input->post('jarak_ke'.$i);
                $jarak_ke = str_replace(".","",$jarak_ke);
                $data_detail[$i] = array(
                    'KD_KONTRAK_TRANS' => $this->input->post('KD_KONTRAK_TRANS'),
                    'ID_DEPO' => $depo_ke,
                    'SLOC' => $pembangkit_ke,
                    'TYPE_KONTRAK_TRANS' => $jalur_ke,
                    'HARGA_KONTRAK_TRANS' => $harga_ke,
                    'JARAK_DET_KONTRAK_TRANS' => $jarak_ke,
                    'CD_DET_KONTRAK_TRANS' => $data['CD_DET_KONTRAK_TRANS'],
                    'CD_BY_DET_KONTRAK_TRANS' => $data['CD_BY_DET_KONTRAK_TRANS'],
                );
            }

            if (!empty($_FILES['FILE_UPLOAD']['name'])){
                $new_name = str_replace(".","",$data['KD_KONTRAK_TRANS']).'_'.date("YmdHis");
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                $this->load->library('upload', $config);
            }

            if ($id == '') {
                if (!$this->upload->do_upload('FILE_UPLOAD')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $nama_file= $res['file_name'];
                        $data['PATH_KONTRAK_TRANS'] = $nama_file;
                        if ($this->kontrak_transportir_model->save_as_new($data)) {

                            if ($x>0){
                                $simpan_data_detail = $this->kontrak_transportir_model->save_detail($data_detail);    
                            }

                            $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');

                            // koding versi prod

							// //extract data from the post
							// //set POST variables
							// $url = $this->_url_movefile;
							// $fields = array(
							// 	'filename' => urlencode($nama_file),
							// 	'modul' => urlencode('KONTRAKTRANSPORTIR')
							// );
							// $fields_string = '';
							// //url-ify the data for the POST
							// foreach($fields as $key=>$value) {
							// 	$fields_string .= $key.'='.$value.'&'; 
							// }
							// rtrim($fields_string, '&');

							// //open connection
							// $ch = curl_init();

							// //set the url, number of POST vars, POST data
							// curl_setopt($ch,CURLOPT_URL, $url);
							// curl_setopt($ch,CURLOPT_POST, count($fields));
							// curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

							// //execute post
							// $result = curl_exec($ch);

							// //close connection
							// curl_close($ch);
                        }
                    }
                }
            } else {

                if (empty($_FILES['FILE_UPLOAD']['name'])){
                    if ($this->kontrak_transportir_model->save($data, $id)) {

                        $simpan_data_detail = $this->kontrak_transportir_model->delete_detail($data['KD_KONTRAK_TRANS']);
                        if ($x>0){
                            $simpan_data_detail = $this->kontrak_transportir_model->save_detail($data_detail);    
                        }                        
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }
                else{
                    $dataa = $this->kontrak_transportir_model->dataEdit($id);
                    $hasil=$dataa->get()->row();
                    $file_name=$hasil->PATH_KONTRAK_TRANS;
                    $target='assets/upload/kontrak_transportir/'.$file_name;
                  
                                    
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
                            
                   
                    if (!$this->upload->do_upload('FILE_UPLOAD')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    }
                    else{
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];  
                            $data['PATH_KONTRAK_TRANS'] = $nama_file;
                            
                            if ($this->kontrak_transportir_model->save($data, $id)) {
                               
                                $simpan_data_detail = $this->kontrak_transportir_model->delete_detail($data['KD_KONTRAK_TRANS']); 
                                if ($x>0){
                                    $simpan_data_detail = $this->kontrak_transportir_model->save_detail($data_detail);    
                                }
                                    
                                $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table'); 

                                // koding versi prod

								//extract data from the post
								//set POST variables
								// $url = $this->_url_movefile;
								// $fields = array(
								// 	'filename' => urlencode($nama_file),
								// 	'modul' => urlencode('KONTRAKTRANSPORTIR')
								// );
								// $fields_string = '';
								// //url-ify the data for the POST
								// foreach($fields as $key=>$value) {
								// 	$fields_string .= $key.'='.$value.'&'; 
								// }
								// rtrim($fields_string, '&');

								// //open connection
								// $ch = curl_init();

								// //set the url, number of POST vars, POST data
								// curl_setopt($ch,CURLOPT_URL, $url);
								// curl_setopt($ch,CURLOPT_POST, count($fields));
								// curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

								// //execute post
								// $result = curl_exec($ch);

								// //close connection
								// curl_close($ch);
                                }
                            }
                        }
            
                    }
                // if ($this->kontrak_transportir_model->save($data, $id)) {
                //     $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                // }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->kontrak_transportir_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function loadKontrakOriginal($id = ''){
        $page_title = 'View Kontrak';
        $data = $this->cekLevelUser();
        $data['id_dok'] = '';
        $data['id'] = $id;
		$data["url_getfile"] = $this->_urlgetfile;

        $trans = $this->kontrak_transportir_model->data($id);
        $data['default'] = $trans->get()->row();
        $data['id_dok'] = $data['default']->PATH_KONTRAK_TRANS; 
           
        $data['option_transportir'] = $this->kontrak_transportir_model->options('--Pilih Transportir--', array('master_transportir.ID_TRANSPORTIR' => NULL));
        $data['option_depo'] = $this->kontrak_transportir_model->getDepo();
        $data['option_jalur'] = $this->kontrak_transportir_model->getJalur();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function loadKontrakAdendum($id = ''){
        $page_title = 'View Kontrak';
        $data = $this->cekLevelUser();
        $data['id_dok'] = '';
        $data['id'] = $id;

        $trans = $this->tbl_get_adendum->data($id);
        $data['default'] = $trans->get()->row();
        $data['id_dok'] = $data['default']->PATH_KONTRAK_TRANS; 


        $data['option_transportir'] = $this->kontrak_transportir_model->options('--Pilih Transportir--', array('master_transportir.ID_TRANSPORTIR' => NULL));
        $data['option_depo'] = $this->kontrak_transportir_model->getDepo();
        $data['option_jalur'] = $this->kontrak_transportir_model->getJalur();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function adendum($id = '') {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));
        $this->session->set_userdata('ID_KONTRAK_TRANS', $id);

        $page_title = 'Tambah '.$this->_title.' (Adendum)';


        $data['button_group'] = array();
        if ($this->laccess->otoritas('edit')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-ad2', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add_adendum/'.$id))),
                anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back2', 'class' => 'btn', 'onclick' => 'close_form(this.id)'))
            );
        } else {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back2', 'class' => 'btn', 'onclick' => 'close_form(this.id)'))
            );            
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title.' (Adendum)';
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources2'] = base_url($this->_module . '/load_adendum');
        $this->load->view($this->_module . '/main_adendum', $data);
    }

    public function load_adendum($page = 1) {
        $data_table = $this->tbl_get_adendum->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_ADENDUM_TRANSPORTIR';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'NO_ADENDUM_TRANSPORTIR' => 'center', 'TGL_ADENDUM_TRANSPORTIR' => 'center', 'KET_ADENDUM_TRANSPORTIR' => 'left', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "No Kontrak", 1, 1,
            "Tgl Kontrak", 1, 1,
            "Keterangan", 1, 1,
            "Aksi", 1, 1
        );

        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function add_adendum($id = '') {
        $page_title = 'Tambah Adendum';
        $data = $this->cekLevelUser();
        $data['id_dok'] = '';
        $data['id'] = $id;
       
        $trans = $this->kontrak_transportir_model->data($id);
        $data['default'] = $trans->get()->row();
        $data['id_dok'] = $data['default']->PATH_KONTRAK_TRANS; 

        
        $data['option_transportir'] = $this->kontrak_transportir_model->options('--Pilih Transportir--', array('master_transportir.ID_TRANSPORTIR' => NULL));
        $data['option_depo'] = $this->kontrak_transportir_model->getDepo();
        $data['option_jalur'] = $this->kontrak_transportir_model->getJalur();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_adendum');
        $this->load->view($this->_module . '/form_adendum', $data);
    }

    public function proses_adendum() {
        $this->form_validation->set_rules('NO_KONTRAK', 'Nomor Adendum Kontrak Transportir', 'trim|required');
        $this->form_validation->set_rules('TRANSPORTIR', 'Transportir', 'trim|required');
        $this->form_validation->set_rules('NILAI_KONTRAK', 'Nilai Kontrak Transportir', 'trim|required|');
        $this->form_validation->set_rules('JML_PASOKAN', 'Pasokan', 'trim|required|');
        $pasokan = $this->input->post('JML_PASOKAN');
        if ($pasokan == 1) {
            $this->form_validation->set_rules('option_depo1', 'Depo', 'trim|required');
            $this->form_validation->set_rules('option_pembangkit1', 'Pembangkit', 'trim|required');
            $this->form_validation->set_rules('option_jalur1', 'Jalur Transportir', 'trim|required|');
            $this->form_validation->set_rules('HARGA1', 'Harga', 'trim|required|');
            $this->form_validation->set_rules('JARAK1', 'Jarak', 'trim|required|');
        } 

        // $id = $this->input->post('id');
        //  if ($id == '') {
            if (empty($_FILES['FILE_UPLOAD']['name'])){
                $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
            }
        // }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['ID_KONTRAK_TRANS'] = $this->input->post('ID_KONTRAK_TRANS');
            $data['KD_KONTRAK_TRANS'] = $this->input->post('NO_KONTRAK');
            $data['ID_TRANSPORTIR'] = $this->input->post('TRANSPORTIR');
            $data['TGL_KONTRAK_TRANS'] = $this->input->post('TGL_KONTRAK_TRANS');
            $data['NILAI_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('NILAI_KONTRAK'));
            $data['KET_KONTRAK_TRANS'] = $this->input->post('KETERANGAN');

            // if ($id == '') {

            $new_name = str_replace(".","",$data['KD_KONTRAK_TRANS']).'_'.date("YmdHis");
            $config['file_name'] = $new_name;
            $config['upload_path'] = 'assets/upload/kontrak_transportir/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
            $config['max_size'] = 1024 * 4; 

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('FILE_UPLOAD')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $nama_file= $res['file_name'];
                        $data['PATH_KONTRAK_TRANS'] = $nama_file;
                        if ($this->tbl_get_adendum->save_as_new($data)) {
                            $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');

                            // koding versi prod

							// $url = $this->_url_movefile;
							// $fields = array(
							// 	'filename' => urlencode($nama_file),
							// 	'modul' => urlencode('KONTRAKTRANSPORTIR')
       //                      );
                            
							// $fields_string = '';
							// //url-ify the data for the POST
							// foreach($fields as $key=>$value) {
							// 	$fields_string .= $key.'='.$value.'&'; 
							// }
							// rtrim($fields_string, '&');

							// //open connection
							// $ch = curl_init();

							// //set the url, number of POST vars, POST data
							// curl_setopt($ch,CURLOPT_URL, $url);
							// curl_setopt($ch,CURLOPT_POST, count($fields));
							// curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

							// //execute post
							// $result = curl_exec($ch);

							// //close connection
							// curl_close($ch);
                        }
                    }
                }
            // } 
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete_adendum($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get_adendum->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function get_detail_kirim($key=null) {
        $key = str_replace("~","/",$key);
        $message = $this->kontrak_transportir_model->get_detail_kirim($key);
        echo json_encode($message);
    }

    public function cekLevelUser(){
        
     $level_user = $this->session->userdata('level_user');
     $kode_level = $this->session->userdata('kode_level');
        
     $data_lv = $this->kontrak_transportir_model->get_level($level_user,$kode_level);
            
        if ($level_user==2){
            $data['option_pembangkit'] = $this->kontrak_transportir_model->getPembangkitFilter( $data_lv[0]->PLANT, 1); 
        } else{
            $data['option_pembangkit'] = $this->kontrak_transportir_model->getPembangkitAll(); 
                    
        } 
        
     return $data;
    }


}

/* End of file kontrak_transportir.php */
/* Location: ./application/modules/kontrak_transportir/controllers/pemasoj.php */
