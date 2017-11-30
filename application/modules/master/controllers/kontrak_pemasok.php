<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level1
 */
class kontrak_pemasok extends MX_Controller {

    private $_title = 'Data Kontrak Pemasok';
    private $_limit = 10;
    private $_module = 'master/kontrak_pemasok';
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
        $this->load->model('kontrak_pemasok_model','tbl_get');
        $this->load->model('kontrak_pemasok_adendum_model','tbl_get_adendum');
        $this->load->model('pemasok_model','tbl_get_pemasok');
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

    public function adendum($id = '') {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));
        $this->session->set_userdata('ID_KONTRAK_PEMASOK', $id);

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

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $data['id_dok'] = '';
        $data['pemasok_options'] = $this->tbl_get->options_pemasok();
        $data['jns_kontrak_options'] = $this->tbl_get->options_jns_kontrak();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
		$data["url_getfile"] = $this->_urlgetfile;

        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
            $data['id_dok'] = $data['default']->PATH_DOC_PEMASOK; 
            $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
            // $this->load->view($this->_module . '/form_edit', $data);
        } 

        $this->load->view($this->_module . '/form', $data);

    }

    public function add_adendum($id = '') {
        $page_title = 'Tambah ' . $this->_title.' (Adendum)';
        $data['id'] = '';
		$data['id_dok'] = '';
		
		$data["url_getfile"] = $this->_urlgetfile;
        $get_data = $this->tbl_get_adendum->data_awal($id);
        $data['default'] = $get_data->get()->row();

        $data['pemasok_options'] = $this->tbl_get->options_pemasok();
        $data['jns_kontrak_options'] = $this->tbl_get->options_jns_kontrak();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_adendum');
        $this->load->view($this->_module . '/form_adendum', $data);
    }

    public function edit_adendum($id = '') {
        $page_title = 'Edit ' . $this->_title.' (Adendum)';
        $data['id'] = $id;
		$data["url_getfile"] = $this->_urlgetfile;
        $get_data = $this->tbl_get_adendum->data($id);
        $data['default'] = $get_data->get()->row();
		$data['id_dok'] =$data['default']->PATH_DOC_PEMASOK; 

        // print_r($data['default']); die;

        $data['pemasok_options'] = $this->tbl_get->options_pemasok();
        $data['jns_kontrak_options'] = $this->tbl_get->options_jns_kontrak();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_adendum');
        $this->load->view($this->_module . '/form_adendum', $data);
    }


    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KONTRAK_PEMASOK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'NAMA_PEMASOK' => 'left', 'NOPJBBM_KONTRAK_PEMASOK' => 'left', 'TGL_KONTRAK_PEMASOK' => 'center', 'JUDUL_KONTRAK_PEMASOK' => 'left', 'PERIODE_AWAL_KONTRAK_PEMASOK' => 'center', 'PERIODE_AKHIR_KONTRAK_PEMASOK' => 'center', 'PERUBAHAN' => 'center', 
            // 'JENIS_KONTRAK_PEMASOK' => 'left', 
            // 'VOLUME_KONTRAK_PEMASOK' => 'left', 'ALPHA_KONTRAK_PEMASOK' => 'left', 'RUPIAH_KONTRAK_PEMASOK' => 'left', 'PENJAMIN_KONTRAK_PEMASOK' => 'left', 'NO_PENJAMIN_KONTRAK_PEMASOK' => 'left', 'NOMINAL_JAMINAN_KONTRAK' => 'left', 'TGL_BERAKHIR_JAMINAN_KONTRAK' => 'left', 'KET_KONTRAK_PEMASOK' => 'left', 
            'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "No", 1, 1,
            "Pemasok", 1, 1,
            "No PJBBBM", 1, 1,
            "Tgl Kontrak", 1, 1,
            "Judul Kontrak", 1, 1,
            "Periode Awal", 1, 1,
            "Periode Akhir", 1, 1,
            "Perubahan", 1, 1,
            // "Jenis Kontrak", 1, 1,
            // "Volume", 1, 1,
            // "Alpha", 1, 1,
            // "Rupiah Kontrak", 1, 1,
            // "Penjamin Kontrak", 1, 1,
            // "No Penjamin", 1, 1,
            // "Nominal Jaminan", 1, 1,
            // "Tgl Akhir Jaminan", 1, 1,
            // "Keterangan", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function load_adendum($page = 1) {
        $data_table = $this->tbl_get_adendum->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_ADENDUM_PEMASOK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'NO_ADENDUM_PEMASOK' => 'center', 'TGL_ADENDUM_PEMASOK' => 'center', 'KET_ADENDUM_PEMASOK' => 'left', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "No Adendum", 1, 1,
            "Tgl Adendum", 1, 1,
            "Keterangan", 1, 1,
            "Aksi", 1, 1
        );

        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }
   
    public function proses() {
        $this->form_validation->set_rules('ID_PEMASOK', 'Pemasok', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('NOPJBBM_KONTRAK_PEMASOK', 'No PJBBM', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('TGL_KONTRAK_PEMASOK', 'Tgl Kontrak', 'required');
        $this->form_validation->set_rules('JUDUL_KONTRAK_PEMASOK', 'Judul Kontrak', 'required');
        $id = $this->input->post('id');
        if ($id == '') {
            if (empty($_FILES['ID_DOC_PEMASOK']['name'])){
                $this->form_validation->set_rules('ID_DOC_PEMASOK', 'Upload Dokumen', 'required');
            }
        }
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['NOPJBBM_KONTRAK_PEMASOK'] = $this->input->post('NOPJBBM_KONTRAK_PEMASOK');
            $data['TGL_KONTRAK_PEMASOK'] = $this->input->post('TGL_KONTRAK_PEMASOK');
            $data['JUDUL_KONTRAK_PEMASOK'] = $this->input->post('JUDUL_KONTRAK_PEMASOK');
            $data['PERIODE_AWAL_KONTRAK_PEMASOK'] = $this->input->post('PERIODE_AWAL_KONTRAK_PEMASOK');
            $data['PERIODE_AKHIR_KONTRAK_PEMASOK'] = $this->input->post('PERIODE_AKHIR_KONTRAK_PEMASOK');
            $data['JENIS_KONTRAK_PEMASOK'] = $this->input->post('JENIS_KONTRAK_PEMASOK');
            $data['VOLUME_KONTRAK_PEMASOK'] = str_replace(".","",$this->input->post('VOLUME_KONTRAK_PEMASOK'));
            $data['ALPHA_KONTRAK_PEMASOK'] = str_replace(".","",$this->input->post('ALPHA_KONTRAK_PEMASOK')); 
            $data['RUPIAH_KONTRAK_PEMASOK'] = str_replace(".","",$this->input->post('RUPIAH_KONTRAK_PEMASOK'));
            $data['PENJAMIN_KONTRAK_PEMASOK'] = $this->input->post('PENJAMIN_KONTRAK_PEMASOK');
            $data['NO_PENJAMIN_KONTRAK_PEMASOK'] = $this->input->post('NO_PENJAMIN_KONTRAK_PEMASOK');
            $data['NOMINAL_JAMINAN_KONTRAK'] = str_replace(".","",$this->input->post('NOMINAL_JAMINAN_KONTRAK'));
            $data['TGL_BERAKHIR_JAMINAN_KONTRAK'] = $this->input->post('TGL_BERAKHIR_JAMINAN_KONTRAK');
            $data['KET_KONTRAK_PEMASOK'] = $this->input->post('KET_KONTRAK_PEMASOK');
            // $data['ISAKTIF_KONTRAK_PEMASOK'] = $this->input->post('ID_REGIONAL');

            if ($id == '') {
                $data['CD_BY_KONTRAK_PEMASOK'] = $this->session->userdata('user_name');
                $data['CD_KONTRAK_PEMASOK'] = date('Y-m-d');

                $new_name = str_replace(".","",$data['NOPJBBM_KONTRAK_PEMASOK']).'_'.date("YmdHis");
                $new_name = str_replace(" ","_",$new_name);
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 4; 
                // $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('ID_DOC_PEMASOK')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $nama_file= $res['file_name'];
                        if ($this->tbl_get->save_as_new($data,$nama_file)) {
                            $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');

                            // // koding versi prod
							// //extract data from the post
							// //set POST variables
							// $url = $this->_url_movefile;
							// $fields = array(
							// 	'filename' => urlencode($nama_file),
							// 	'modul' => urlencode('KONTRAKPEMASOK')
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
                $data['UD_KONTRAK_PEMASOK'] = date('Y-m-d');
                $nama_file='';

                if (!empty($_FILES['ID_DOC_PEMASOK']['name'])){
                    $new_name = str_replace(".","",$data['NOPJBBM_KONTRAK_PEMASOK']).'_'.date("YmdHis");
                    $new_name = str_replace(" ","_",$new_name);
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 10; 
                    // $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('ID_DOC_PEMASOK')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    } else {
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];

                                // //extract data from the post
                                // //set POST variables
                                // $url = $this->_url_movefile;
                                // $fields = array(
                                //     'filename' => urlencode($nama_file),
                                //     'modul' => urlencode('KONTRAKPEMASOK')
                                // );
                                // $fields_string = '';
                                // //url-ify the data for the POST
                                // foreach($fields as $key=>$value) {
                                //     $fields_string .= $key.'='.$value.'&'; 
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
                
                if ($this->tbl_get->save($data, $id)) {
                    if ($nama_file){
                        $data_file['ID_KONTRAK_PEMASOK'] = $id;
                        $data_file['PATH_DOC_PEMASOK'] = $nama_file;
                        $data_file['CD_DOC_PEMASOK'] = $data['CD_KONTRAK_PEMASOK'];
                        $data_file['CD_BY_DOC_PEMASOK'] = $data['CD_BY_KONTRAK_PEMASOK'];
                        $this->tbl_get->save_as_new_file($data_file);
                    }
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function proses_adendum() {
        $this->form_validation->set_rules('NO_ADENDUM_PEMASOK', 'No Adendum', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('KET_ADENDUM_PEMASOK', 'Keterangan Adendum', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('TGL_ADENDUM_PEMASOK', 'Tanggal Kontrak', 'required');
        $this->form_validation->set_rules('JUDUL_ADENDUM_PEMASOK', 'Judul Kontrak', 'trim|required|max_length[100]');
        $id = $this->input->post('id');
        if ($id == '') {
            if (empty($_FILES['PATH_DOC']['name'])){
                $this->form_validation->set_rules('PATH_DOC', 'Upload Dokumen', 'required');
            }
        }
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $data['ID_KONTRAK_PEMASOK'] = $this->input->post('ID_KONTRAK_PEMASOK');
            $data['NO_ADENDUM_PEMASOK'] = $this->input->post('NO_ADENDUM_PEMASOK');
            $data['TGL_ADENDUM_PEMASOK'] = $this->input->post('TGL_ADENDUM_PEMASOK');
            $data['JUDUL_ADENDUM_PEMASOK'] = $this->input->post('JUDUL_ADENDUM_PEMASOK');
            $data['PERIODE_AWAL_ADENDUM_PEMASOK'] = $this->input->post('PERIODE_AWAL_ADENDUM_PEMASOK');
            $data['PERIODE_AKHIR_ADENMDUM_PEMASOK'] = $this->input->post('PERIODE_AKHIR_ADENMDUM_PEMASOK');
            $data['JENIS_AKHIR_ADENDUM_PEMASOK'] = $this->input->post('JENIS_AKHIR_ADENDUM_PEMASOK');
            $data['VOL_AKHIR_ADENDUM_PEMASOK'] = str_replace(".","",$this->input->post('VOL_AKHIR_ADENDUM_PEMASOK'));
            $data['ALPHA_ADENDUM_PEMASOK'] = str_replace(".","",$this->input->post('ALPHA_ADENDUM_PEMASOK'));
            $data['RP_ADENDUM_PEMASOK'] = str_replace(".","",$this->input->post('RP_ADENDUM_PEMASOK')); 
            $data['PENJAMIN_ADENDUM_PEMASOK'] = $this->input->post('PENJAMIN_ADENDUM_PEMASOK');
            $data['NO_PENJAMIN_ADENDUM_PEMASOK'] = $this->input->post('NO_PENJAMIN_ADENDUM_PEMASOK');
            $data['NOMINAL_ADENDUM_PEMASOK'] = str_replace(".","",$this->input->post('NOMINAL_ADENDUM_PEMASOK'));
            $data['TGL_AKHIR_ADENDUM_PEMASOK'] = $this->input->post('TGL_AKHIR_ADENDUM_PEMASOK');
            $data['KET_ADENDUM_PEMASOK'] = $this->input->post('KET_ADENDUM_PEMASOK');
            // $data['ISAKTIF_KONTRAK_PEMASOK'] = $this->input->post('ID_REGIONAL');

            if ($id == '') {
                $data['CD_BY_ADENDUM_PEMASOK'] = $this->session->userdata('user_name');
                $data['CD_ADENDUM_PEMASOK'] = date('Y-m-d');

                if (!empty($_FILES['PATH_DOC']['name'])){
                    $new_name = str_replace(".","",$data['NO_ADENDUM_PEMASOK']).'_'.date("YmdHis");
                    $new_name = str_replace(" ","_",$new_name);
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 10; 
                    // $config['encrypt_name'] = TRUE;
                    $data['PATH_DOC'] = $new_name;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('PATH_DOC')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    } else {
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];
                            if ($this->tbl_get_adendum->save_as_new($data,$nama_file)) {
                                $message = array(true, 'Proses Berhasil ', 'Proses penyimpanan data berhasil.', '#content_table');

                                // koding versi prod

								// //extract data from the post
								// //set POST variables
								// $url = $this->_url_movefile;
								// $fields = array(
								// 	'filename' => urlencode($nama_file),
								// 	'modul' => urlencode('KONTRAKPEMASOK')
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
                // if ($this->tbl_get_adendum->save_as_new($data)) {
                //     $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                // }
            } else {
                if (!empty($_FILES['PATH_DOC']['name'])){
                    $new_name = str_replace(".","",$data['NO_ADENDUM_PEMASOK']).'_'.date("YmdHis");
                    $new_name = str_replace(" ","_",$new_name);
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 10; 
                    // $config['encrypt_name'] = TRUE;
                    $data['PATH_DOC'] = $new_name;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('PATH_DOC')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                    } else {
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];
                            
                        }
                    }                   


                }

                $data['UD_ADENDUM_PEMASOK'] = date('Y-m-d');
                if ($this->tbl_get_adendum->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');

                    // koding versi prod

					// //extract data from the post
					// //set POST variables
					// $url = $this->_url_movefile;
					// $fields = array(
					// 	'filename' => urlencode($nama_file),
					// 	'modul' => urlencode('KONTRAKPEMASOK')
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
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {

        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->deleteDocumen($id)) {
            if ($this->tbl_get->delete($id)) {
                $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
            }
        }
        echo json_encode($message);
    }

    public function delete_adendum($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get_adendum->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }
  
}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
