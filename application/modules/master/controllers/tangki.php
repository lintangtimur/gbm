<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master tangki
 */
class tangki extends MX_Controller {

    private $_title = 'Master Tangki';
    private $_limit = 10;
    private $_module = 'master/tangki';
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
        $this->load->model('tangki_model');
    }

    public function index() {
        $data = $this->get_level_user(); 
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
        $page_title = 'Tambah Tangki';
        $data = $this->get_level_user();
        $data['id_dok'] = $id;
        $data['id'] = $id;
		$data['id_dok'] = '';
		$data["url_getfile"] = $this->_urlgetfile;

        if ($id != '') {
            $page_title = 'Edit Tangki';
            $tangki = $this->tangki_model->data(array("a.ID_TANGKI = '$id'" => null));
            $data['default'] = $tangki->get()->row();

            if ($data['default']->SLOC){
                $data_lv = $this->tangki_model->get_level('4',$data['default']->SLOC);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                $level_user = $this->session->userdata('level_user');
                $kode_level = $this->session->userdata('kode_level');

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
                    $data['reg_options'] = $option_reg; 
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

			// print_debug($data['default']);
            // $trans = $this->tangki_model->get_detail($id);
            // $data['data_detail'] = $trans->get()->row();
            // $data['id_dok'] = $data['default']->PATH_DET_TERA;

        }
       
        // $data['unit_pembangkit'] = $this->tangki_model->option_pembangkit_all('--Pilih Unit Pembangkit--', array('master_tangki.SLOC' => NULL));
        $data['option_jenis_bbm'] = $this->tangki_model->option_jenisbbm('--Pilih Jenis BBM--', array('master_tangki.ID_JNS_BHN_BKR' => NULL));
        $data['tera'] = $this->tangki_model->option_tera();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tangki_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_VENDOR';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('number' => 'center','unit_pembangkit' => 'center','jenis_bbm' => 'center','kapasitas' => 'right','deadstock' => 'right','stockefektif' => 'right','aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "No", 1, 1,
            "Pembangkit", 1, 1,
            "Jenis BBM", 1, 1,
            "Volume (L)", 1, 1,
            "Dead Stok (L)", 1, 1,
            "Kapasitas Efektif (L)", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('SLOC', 'Pembangkit', 'trim|required');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'trim|required');
        $this->form_validation->set_rules('JML_TANGKI', 'Jumlah Tangki', 'trim|required');
        // $this->form_validation->set_rules('VOLUME_TANGKI', 'Kapasitas', 'trim|required');
        // $this->form_validation->set_rules('DEAD_STOCK', 'Dead Stok', 'trim|required');
        // $this->form_validation->set_rules('STOCK_EFEKTIF', 'Kapasitas Efektif', 'trim|required');
        // $id = $this->input->post('id');
        //  if ($id == '') {
        //     if (empty($_FILES['FILE_UPLOAD']['name'])){
        //         $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
        //     }
        // }

        $x = $this->input->post('JML_TANGKI');

        if ($x>0){
            if ($x>30){
                $x=30;
            }
            for ($i=1; $i<=$x; $i++) {
                $this->form_validation->set_rules('NAMA_TANGKI'.$i, 'Nama Tangki ke '.$i, 'required');
                $this->form_validation->set_rules('VOLUME_TANGKI'.$i, 'Kapasitas Terpasang (L) ke '.$i, 'required');
            }
        }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['SLOC'] = $this->input->post('SLOC');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            // $data['NAMA_TANGKI'] = $this->input->post('NAMA_TANGKI');
            $data['VOLUME_TANGKI'] = str_replace(".","",$this->input->post('VOLUME_TANGKI'));
            $data['VOLUME_TANGKI'] = str_replace(",",".",$data['VOLUME_TANGKI']);
            $data['DEADSTOCK_TANGKI'] = str_replace(".","",$this->input->post('DEADSTOCK_TANGKI'));
            $data['DEADSTOCK_TANGKI'] = str_replace(",",".",$data['DEADSTOCK_TANGKI']);
            $data['STOCKEFEKTIF_TANGKI'] = str_replace(".","",$this->input->post('STOCKEFEKTIF_TANGKI'));
            $data['STOCKEFEKTIF_TANGKI'] = str_replace(",",".",$data['STOCKEFEKTIF_TANGKI']);

            $data_detail = array();
            $data_detail_nama = array();
            $berhasil=0;
            $gagal=0;
            $err='';

            for ($i=1; $i<=$x; $i++)
            {
                $VOLUME_TANGKI = $this->input->post('VOLUME_TANGKI'.$i);
                $VOLUME_TANGKI = str_replace(".","",$VOLUME_TANGKI);
                $VOLUME_TANGKI = str_replace(",",".",$VOLUME_TANGKI);

                $DEADSTOCK_TANGKI = $this->input->post('DEADSTOCK_TANGKI'.$i);
                $DEADSTOCK_TANGKI = str_replace(".","",$DEADSTOCK_TANGKI);
                $DEADSTOCK_TANGKI = str_replace(",",".",$DEADSTOCK_TANGKI);

                $STOCKEFEKTIF_TANGKI = $this->input->post('STOCKEFEKTIF_TANGKI'.$i);
                $STOCKEFEKTIF_TANGKI = str_replace(".","",$STOCKEFEKTIF_TANGKI);
                $STOCKEFEKTIF_TANGKI = str_replace(",",".",$STOCKEFEKTIF_TANGKI);

                $new_name = $this->input->post('SLOC').'_'.$this->input->post('NAMA_TANGKI'.$i);
                $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $new_name);
                $new_name = $new_name.'_'.date("YmdHis").'_'.rand(1000,9999);

                if (!empty($_FILES['PATH_DET_TERA'.$i]['name'])){

                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/tangki';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 4; 
                    $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                    $this->load->library('upload', $config);                            
                    $this->upload->initialize($config);

                    $nama_file = '';
                    if (!$this->upload->do_upload('PATH_DET_TERA'.$i)){
                        $gagal++;
                        $err = $this->upload->display_errors('', '');
                        // $message = array(false, 'Proses gagal', $err, '');
                    } else {
                        $berhasil++;
                        //$final_files_data[] = $this->upload->data();

                        $res = $this->upload->data();
                        // if ($res){
                        $nama_file = $res['file_name'];
                    }
                }

                $data_detail[$i] = array(
                    'NAMA_TANGKI' => $this->input->post('NAMA_TANGKI'.$i),
                    'ID_TANGKI' => $id,
                    'ID_JNS_BHN_BKR' => $this->input->post('ID_JNS_BHN_BKR'),
                    'SLOC' => $this->input->post('SLOC'),
                    'ID_TERA' => '-',
                    'DITERA_OLEH' => $this->input->post('DITERA_OLEH'.$i),
                    'PATH_DET_TERA' => $nama_file,  //$this->input->post('PATH_DET_TERA'.$i),
                    'TGL_AWAL_TERA' => $this->input->post('TGL_AWAL_TERA'.$i),
                    'TGL_AKHIR_TERA' => $this->input->post('TGL_AKHIR_TERA'.$i),
                    'VOLUME_TANGKI' => $VOLUME_TANGKI,
                    'DEADSTOCK_TANGKI' => $DEADSTOCK_TANGKI,
                    'STOCKEFEKTIF_TANGKI' => $STOCKEFEKTIF_TANGKI,
                    'CREATE_DATE' => date('Y-m-d'),
                    'CREATE_BY' => $this->session->userdata('user_name'),
                    'AKTIF' => $this->input->post('AKTIF'.$i),
                );
            }
           
            if ($id == '') {
                $data['CD_TANGKI'] = date("Y/m/d");
                $data['UD_BY_TANGKI'] = $this->session->userdata('user_name');

                $nama_file='';
                if ($this->tangki_model->save_as_new($data, $nama_file, $data_detail)) {
                    
                    // for ($i=1; $i<=$x; $i++){

                    //     if (!empty($_FILES['PATH_DET_TERA'.$i]['name'])){
                    //         // $new_name = $this->input->post('SLOC').'_'.$this->input->post('NAMA_TANGKI'.$i);
                    //         // $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $new_name);
                    //         // $new_name = $new_name.'_'.date("YmdHis");
                    //         // $nama_file = $data_detail[$i]['PATH_DET_TERA'];

                    //         $config['file_name'] = $data_detail_nama[$i];
                    //         $config['upload_path'] = 'assets/upload/tangki';
                    //         $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    //         $config['max_size'] = 1024 * 4; 
                    //         // $config['overwrite'] = 1; 
                    //         // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                    //         $this->load->library('upload', $config);                            
 
                    //         // $config['encrypt_name'] = TRUE;

                    //         $this->upload->initialize($config);


                    //         if (!$this->upload->do_upload('PATH_DET_TERA'.$i)){
                    //             $gagal++;
                    //             $err = $this->upload->display_errors('', '');
                    //             // $message = array(false, 'Proses gagal', $err, '');
                    //         } else {
                    //             $berhasil++;
                    //             //$final_files_data[] = $this->upload->data();

                    //             // $res = $this->upload->data();
                    //             // if ($res){
                    //         }
                    //     }

                    // }

                    $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil. 
                        <br>
                        Upload File :
                        <br> 
                        - Berhasil ['.$berhasil. '] 
                        <br>
                        - Gagal ['.$gagal.'] <br> '.$err, '#content_table');
                }

        //         $new_name = str_replace(".","",$data['NAMA_TANGKI']).'_'.date("YmdHis");
        //         $new_name = str_replace(" ","_",$new_name);
        //         $config['file_name'] = $new_name;
        //         $config['upload_path'] = 'assets/upload/tangki/';
        //         $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        //         $config['max_size'] = 1024 * 4; 

        //         // print_r($config);

        //         $this->load->library('upload', $config);

        //             if (!$this->upload->do_upload('FILE_UPLOAD')){
        //                 $err = $this->upload->display_errors('', '');
        //                 $message = array(false, 'Proses gagal', $err, '');
        //             } else {
        //                 $res = $this->upload->data();
        //                 if ($res){
        //                     $nama_file= $res['file_name'];
        //                     if ($this->tangki_model->save_as_new($data, $nama_file, $data_detail)) {
        //                         $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');

        //                         // koding versi prod

								// // //extract data from the post
								// // //set POST variables
								// // $url = $this->_url_movefile;
								// // $fields = array(
								// // 	'filename' => urlencode($nama_file),
								// // 	'modul' => urlencode('TANGKI')
								// // );
								// // $fields_string = '';
								// // //url-ify the data for the POST
								// // foreach($fields as $key=>$value) {
								// // 	$fields_string .= $key.'='.$value.'&'; 
								// // }
								// // rtrim($fields_string, '&');

								// // //open connection
								// // $ch = curl_init();

								// // //set the url, number of POST vars, POST data
								// // curl_setopt($ch,CURLOPT_URL, $url);
								// // curl_setopt($ch,CURLOPT_POST, count($fields));
								// // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

								// // //execute post
								// // $result = curl_exec($ch);

								// // //close connection
								// // curl_close($ch);
        //                     }
        //             }
        //         }
            } else {
                $nama_file='';
                $data['UD_TANGKI'] = date("Y/m/d");
                if ($this->tangki_model->save($data, $id, $nama_file)) {

                    $simpan_data_detail = $this->tangki_model->delete_detail($id);
                    if ($x>0){
                        $simpan_data_detail = $this->tangki_model->save_detail($data_detail);    
                    }  

                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses gagal','', '');
                }

                echo json_encode($message, true);
                exit();                 




                    $dataa = $this->tangki_model->dataEdit($id);
                    $hasil=$dataa->get()->row();
                    $file_name=$hasil->PATH_DET_TERA;
                    $target='assets/upload_tangki/'.$file_name;

                if (empty($_FILES['FILE_UPLOAD']['name'])){
                    $nama_file = $file_name;
                    $data['UD_TANGKI'] = date('Y-m-d');
                    if ($this->tangki_model->save($data, $id, $nama_file)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }
                else{
                                    
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
                            
                    $tera['TGL_TERA'] = $this->input->post('TGL_TERA');
                    $new_name = $tera['TGL_TERA'].'_'.date("YmdHis");
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/tangki/';
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
                            if ($this->tangki_model->save($data, $id, $nama_file)) {
                                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                                    
                                    // koding versi prod

									// //extract data from the post
									// //set POST variables
									// $url = $this->_url_movefile;
									// $fields = array(
									// 	'filename' => urlencode($nama_file),
									// 	'modul' => urlencode('TANGKI')
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
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tangki_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function get_detail_kirim() {
        $key = $this->input->post('idx');
        $message = $this->tangki_model->get_detail_kirim($key);
        echo json_encode($message);
    }
    
    public function cekLevelUser(){

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tangki_model->get_level($level_user,$kode_level);

        if ($level_user==3|| $level_user==4){
            $data['unit_pembangkit'] = $this->tangki_model->option_pembangkit_filter('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        } else{
            $data['unit_pembangkit'] = $this->tangki_model->option_pembangkit_all(); 

        } 

        return $data;
    }

    public function get_level_user(){
        // $data['option_pembangkit'] = $this->tangki_model->getPembangkitByLv(); 
        $data['lv1_options'] = $this->tangki_model->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tangki_model->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tangki_model->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tangki_model->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tangki_model->get_level($level_user, $kode_level);

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
            $data['lv4_options'] = $this->tangki_model->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tangki_model->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tangki_model->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tangki_model->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tangki_model->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function get_options_lv1($key=null) {
        $message = $this->tangki_model->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->tangki_model->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->tangki_model->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->tangki_model->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

}

/* End of file tangki.php */
/* Location: ./application/modules/tangki/controllers/pemasoj.php */
