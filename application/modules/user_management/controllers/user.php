<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module User Management (User)
 */
class user extends MX_Controller {

    private $_title = 'User Web';
    private $_module = 'user_management/user';
    private $_limit = 10;

    public function __construct() {
        parent::__construct();

        /* Load Global Model */
        $this->load->model('user_model');
        $this->load->model('role_model');
		$this->load->model('master_level_model');
        // Protection
        hprotection::login();
    }

    public function index() {
		$this->laccess->check();
		$this->laccess->otoritas('view', true);
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'select2'));

		$data['button_group'] = array();
		if ($this->laccess->otoritas('add')) {
			$data['button_group'] = array(
				anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
			);
		}

        $data['role_options'] = $this->role_model->options();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Data';
        $data['id'] = $id;
		$data['role_options'] =$this->role_model->options();
		$data['default'] = array();
		$data['bindlevel'] = array();
		$data['disabled'] = '';
		$data['url_levegroup'] = base_url($this->_module). '/load_levelgroup/';
        if ($id != '') {
            $page_title = 'Edit Data';
            $user = $this->user_model->data($id)->get()->result();
            $data['default'] = $user[0];
			$data['bindlevel'] = array($user[0]->KODE_LEVEL => $user[0]->KODE_LEVEL);
			$data['disabled'] = 'readonly';
        }
        $data['loker_options'] = array();//$this->loker_model->options();
        $data['unit_options'] = array();//$this->unit_model->options();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
		$data['loadlevel'] = base_url($this->_module). '/load_level/';
		
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
		$this->laccess->check();
        $data_table = $this->user_model->data_table($this->_module, $this->_limit, $page);

        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'user_id';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no' => 'center', 'aksi' => 'center', 'user_status' => 'center', 'status_password' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
			"NO", 1,1,
            "Nama", 1, 1,
            "Username", 1, 1,
            "Role", 1, 1,
            "Status", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
		$this->laccess->check();
		if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
			$level = array();
			$role = $this->input->post("level_user");
            $this->form_validation->set_rules('kode_user', 'Kode User', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('nama_user', 'Nama User', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email_user', 'Email User', 'trim|required|max_length[50]|valid_email');
			$this->form_validation->set_rules('level_user', 'Level User', 'required');
			$level = explode("..", $role);
			
			$kodelevel = '0';
			if ($level[1] == "R"){
				$this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
				$kodelevel = $this->input->post("kode_regional");
			}
			else if($level[1] == "1"){
				$this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
				$this->form_validation->set_rules('kode_level1', 'Kode Level l', 'required');
				$kodelevel = $this->input->post("kode_level1");
			}
			else if($level[1] == "2"){
				$this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
				$this->form_validation->set_rules('kode_level1', 'Kode Level l', 'required');
				$this->form_validation->set_rules('kode_level2', 'Kode Level 2', 'required');
				$kodelevel = $this->input->post("kode_level2");
			}
			else if($level[1] == "3"){
				$this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
				$this->form_validation->set_rules('kode_level1', 'Kode Level l', 'required');
				$this->form_validation->set_rules('kode_level2', 'Kode Level 2', 'required');
				$this->form_validation->set_rules('kode_level3', 'Kode Level 3', 'required');
				$kodelevel = $this->input->post("kode_level3");
			}
			else if($level[1] == "4"){
				$this->form_validation->set_rules('kode_regional', 'Kode Regional', 'required');
				$this->form_validation->set_rules('kode_level1', 'Kode Level l', 'required');
				$this->form_validation->set_rules('kode_level2', 'Kode Level 2', 'required');
				$this->form_validation->set_rules('kode_level3', 'Kode Level 3', 'required');
				$this->form_validation->set_rules('kode_level4', 'Kode Level 4', 'required');
				$kodelevel = $this->input->post("kode_level4");
			}
			
			$this->form_validation->set_rules('user_username', 'Username', 'trim|required|max_length[100]');
			// $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('role_id', 'Role User', 'trim|required');
			$this->form_validation->set_rules('user_status', 'Status user', 'trim|required');
			
			$this->load->library('encrypt');
			if ($this->form_validation->run($this)) {
				$id = $this->input->post('id');
				$roleid = $this->input->post("role_id");
				$kduser = $this->input->post("kode_user");
				$nama = $this->input->post("nama_user");
				$username = $this->input->post("user_username");
				$pwd = 'icon123'; //$this->input->post("password");
				$email = $this->input->post("email_user");
				$isaktif = $this->input->post("user_status");

                $kodelevel = trim($kodelevel);
				
				$data = $this->user_model->save_as_new($level[0], $kduser, $nama, $username, $pwd, $email, $level[1], $kodelevel, $isaktif, $id)->row();
				$rc = $data->RCDB;
				if($rc == "RC00"){
					$message = array(false, 'Proses gagal', $data->PESANDB, '');
				}else{
					$message = array(true, 'Proses Berhasil', $data->PESANDB, '#content_table');
				}
			} else {
				$message = array(false, 'Proses gagal', validation_errors(), '');
			}
			echo json_encode($message, true);
		}else{
			$this->laccess->redirect();
		}
    }

    public function delete($id) {
		$this->laccess->check();
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->user_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }
	
	public function nonaktif($id) {
		$this->laccess->check();
        $message = array(false, 'Proses gagal', 'Proses Non Aktif User gagal.', '');

        if ($this->user_model->edit($id, array("ISAKTIF_USER"=> "0"))) {
            $message = array(true, 'Proses Berhasil', 'Proses Non Aktif User berhasil.', '#content_table');
        }
        echo json_encode($message);
    }
	
	public function aktif($id) {
		$this->laccess->check();
        $message = array(false, 'Proses gagal', 'Proses Aktif User gagal.', '');

        if ($this->user_model->edit($id, array("ISAKTIF_USER"=> "1"))) {
            $message = array(true, 'Proses Berhasil', 'Proses Aktif User berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function reset_password($id) {
        $message = array(false, 'Proses gagal', 'Proses reset password gagal.', '');

        $user = $this->user_model->data($id)->get();
        if ($user->num_rows() > 0) {
            $dataUser = $user->row();
            $data = array();
            $data['PWD_USER'] = md5($dataUser->user_username);
            if ($this->user_model->save($data, $id)) {
                $message = array(true, 'Proses Berhasil', 'Proses reset password berhasil.', '#content_table');
            }
        }
        echo json_encode($message);
    }

    public function ganti_password() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $page_title = 'Ubah Password';
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['form_action'] = base_url($this->_module . '/proses_password');
        $data['page_content'] = $this->_module . '/ganti_password';
        echo Modules::run("template/admin", $data);
    }
	
	 public function profil() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $page_title = 'Profil';
        $data['page_title'] = '<i class="icon-user"></i> ' . $this->_title;
        $data['form_action'] = base_url($this->_module . '/proses_profil');
        $data['page_content'] = $this->_module . '/form_profil';
		$data['id'] =$id= $this->session->userdata('user_id');
        $check = array();
            $user = $this->user_model->data($id);
            $data['default'] = $user->get()->row();
        $data_keahlian = array();//$this->user_model->datakeahlian(array('user_id' => $id))->get();
            // foreach ($data_keahlian->result() as $dt_keahlian) {
                // $check[$dt_keahlian->keahlian_id] = array(
                    // 'is_add' => $dt_keahlian->keahlian_id
                // );
            // }
		$data['list_menu'] =  array();//$this->kompetensi_model->array_keahlian();
		$data['cek_menu'] = $check;
        $data['role_options'] =  array();//$this->role_model->options();
        $data['loker_options'] =  array();//$this->loker_model->options();
        $data['unit_options'] =  array();//$this->unit_model->options();
        echo Modules::run("template/admin", $data);
    }

    public function proses_password() {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'trim|required|max_length[30]|callback_password_check_db');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[5]|max_length[30]|matches[konf_password]|callback_password_check[password_lama]');
        $this->form_validation->set_rules('konf_password', 'Konfirmasi Password Baru', 'trim|required|min_length[5]|max_length[30]|');
        $this->form_validation->set_message('matches', 'Kedua Password Baru tidak cocok.');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $passBaru = md5($this->input->post('password_baru'));
            $id = $this->session->userdata('user_id');
            $data_user = array();
            $data_user['PWD_USER'] = $passBaru;
            $data_user['UD_USER'] = date('Y-m-d');
            if ($this->user_model->save($data_user, $id)) {
                $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function password_check($password_lama, $password_baru) {
        $passLama = md5($password_lama);
        $passBaru = md5($password_baru);
        if ($passLama == $passBaru) {
            $this->form_validation->set_message('password_check', '%s dan Password Lama sama.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function password_check_db($password) {
        $pass = md5($password);
        $id = $this->session->userdata('user_id');
        $user = $this->user_model->data($id)->get();
        if ($user->num_rows() > 0) {
            $dataUser = $user->row();
            if ($dataUser->PWD_USER == $pass) {
                return TRUE;
            } else {
                $this->form_validation->set_message('password_check_db', '%s salah.');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('password_check_db', 'Data User Tidak ditemukan.');
        }
    }
	
	public function proses_profil() {
        $this->form_validation->set_rules('user_nama', 'Nama', 'trim|required|min_length[5]|max_length[30]');
        $this->load->library('encrypt');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $user = array();
            $user['nama_user'] = $this->input->post('user_nama');
                if ($this->user_model->save($user, $id)) {
					$this->user_model->logout($this->session->userdata('user_id'));
					$this->session->sess_destroy();
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', base_url());
                }
            
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }
	
	public function load_level($id = '', $kode = ''){
		$data = $this->master_level_model->load_option($id, $kode);
		echo json_encode($data);
	}
	
	public function load_levelgroup($level = '', $id = ''){
		if ($level == "R")
			$data["regional"] = $this->master_level_model->load_regional("R");
		else if ($level == "1"){
			$level1 = $this->master_level_model->load_level1($id);
			$data["level1"] = $level1["list"];
			$data["idregional"] = $level1["idregional"];
			$data["regional"] = $this->master_level_model->load_option("R");
		}
		else if($level == "2"){
			$level2 = $this->master_level_model->load_level2($id);
			$data["level2"] = $level2["list"];
			$data["idlevel1"] = $level2["idlevel1"];
			
			$level1 = $this->master_level_model->load_level1($level2["idlevel1"]);
			$data["level1"] = $level1["list"];
			$data["idregional"] = $level1["idregional"];
			
			$data["regional"] = $this->master_level_model->load_option("R");
		}
		else if($level == "3"){
			$level3 = $this->master_level_model->load_level3($id);
			$data["level3"] = $level3["list"];
			$data["idlevel2"] = $level3["idlevel2"];
			
			$level2 = $this->master_level_model->load_level2($level3["idlevel2"]);
			$data["level2"] = $level2["list"];
			$data["idlevel1"] = $level2["idlevel1"];
			
			$level1 = $this->master_level_model->load_level1($level2["idlevel1"]);
			$data["level1"] = $level1["list"];
			$data["idregional"] = $level1["idregional"];
			
			$data["regional"] = $this->master_level_model->load_option("R");
		}
		else if($level == "4"){
			$level4 = $this->master_level_model->load_level4($id);
			$data["level4"] = $level4["list"];
			$data["idlevel3"] = $level4["idlevel3"];
			
			$level3 = $this->master_level_model->load_level3($level4["idlevel3"]);
			$data["level3"] = $level3["list"];
			$data["idlevel2"] = $level3["idlevel2"];
			
			$level2 = $this->master_level_model->load_level2($level3["idlevel2"]);
			$data["level2"] = $level2["list"];
			$data["idlevel1"] = $level2["idlevel1"];
			
			$level1 = $this->master_level_model->load_level1($level2["idlevel1"]);
			$data["level1"] = $level1["list"];
			$data["idregional"] = $level1["idregional"];
			
			$data["regional"] = $this->master_level_model->load_option("R");
		}
		echo json_encode($data);
	}

    public function get_info_ldap() {
        $ldap_cek = $this->session->userdata('ldap_cek');
        $username = $this->session->userdata('ldap_user');
        $password = $this->session->userdata('ldap_password');
        $domain = $this->session->userdata('ldap_domain');
        $status = false;
        $msg = '';
        $ldap_nik = '';
        $ldap_nama = '';
        $ldap_email = ''; 

        if ($ldap_cek){
            $adServer = "ldap://10.1.8.20";
            $ldap = ldap_connect($adServer);

            $ldaprdn = $domain . "\\" . $username;

            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($ldap, $ldaprdn, $password);
            if ($bind) {
                $ldap_user = $username;

                $filter="(sAMAccountName=$username)";
                $result = ldap_search($ldap,"DC=".$domain.",DC=corp,DC=pln,DC=co,DC=id",$filter);
                $info = ldap_get_entries($ldap, $result);
                // var_dump($info); die;

                //get info ldap add
                $ldap_user_add = $this->input->post('ldap_user');

                $domain_add = strtolower(substr($ldap_user_add, 0, strrpos($ldap_user_add, "\\")));
                $ldap_user_add = substr($ldap_user_add, strrpos($ldap_user_add, "\\") + 1, strlen($ldap_user_add) - strrpos($ldap_user_add, "\\"));

                $filter="(sAMAccountName=$ldap_user_add)";
                $result = ldap_search($ldap,"DC=".$domain_add.",DC=corp,DC=pln,DC=co,DC=id",$filter);
                $info = ldap_get_entries($ldap, $result);
                // var_dump($info); die;
                $msg = 'Get info LDAP gagal';

                for ($i=0; $i<$info["count"]; $i++)
                {
                    if($info['count'] > 1)
                        break;

                    // echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> <br>
                    //     (" . $info[$i]["samaccountname"][0] .") <br>
                    //     email= ".$info[$i]["mail"][0]." <br> 
                    //     nama= ".$info[$i]["cn"][0]." <br>
                    //     NIK= ".$info[$i]["employeenumber"][0]." </p>\n";
                    // echo '<pre>';
                    // var_dump($info);
                    // echo '</pre>'; die;

                    // $userDn = $info[$i]["distinguishedname"][0]; 
                    // $ldap_user = $info[$i]["samaccountname"][0];
                    $ldap_nik = $info[$i]["employeenumber"][0];
                    $ldap_nama = $info[$i]["cn"][0];
                    $ldap_email = $info[$i]["mail"][0]; 
                    $msg = 'Get info LDAP '.$ldap_nama.' sukses';
                    $status = true;
                }
                @ldap_close($ldap);
                //echo 'Authentication Succed';
            } 
        } else {
            $msg = 'Silahkan login dengan user LDAP untuk akses fungsi ini';    
        }

        $output = array(
                        "status" => $status,
                        "msg" => $msg,
                        "ldap_user" => $ldap_user_add,
                        "ldap_nik" => $ldap_nik,
                        "ldap_nama" => $ldap_nama,
                        "ldap_email" => $ldap_email,
                );        

        echo json_encode($output);
    }
	
}

/* End of file user.php */
/* Location: ./application/modules/meeting_management/controllers/user.php */
