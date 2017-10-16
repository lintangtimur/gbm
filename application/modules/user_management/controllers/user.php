<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module User Management (User)
 */
class user extends MX_Controller {

    private $_title = 'User Web Admin';
    private $_module = 'user_management/user';
    private $_limit = 10;

    public function __construct() {
        parent::__construct();

        /* Load Global Model */
        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('loker_model');
        $this->load->model('unit_model');
        $this->load->model('user_model');
		// $this->load->model('kms_master/kompetensi_model');
        // Protection
        hprotection::login();
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $data['role_options'] = $this->role_model->options();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Data';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Data';
            $user = $this->user_model->data($id);
            $data['default'] = $user->get()->row();
        }
        $data['role_options'] = $this->role_model->options();
        $data['loker_options'] = $this->loker_model->options();
        $data['unit_options'] = $this->unit_model->options();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');

        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
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
        $this->form_validation->set_rules('user_nama', 'Name', 'trim|required|min_length[5]|max_length[30]');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
        $this->form_validation->set_rules('loker_id', 'Loker Kerja', 'trim|required');
        $this->form_validation->set_rules('unit_id', 'Unit Kerja', 'trim|required');
        
        $temp_username = $this->input->post('temp_user_username');
        $new_username = $this->input->post('user_username');
        
        if ($temp_username != $new_username) {
            $this->form_validation->set_rules('user_username', 'Username', 'trim|required|min_length[5]|max_length[30]|is_unique[user.user_username]');
        } else {
            $this->form_validation->set_rules('user_username', 'Username', 'trim|required|min_length[5]|max_length[30]');
        }
        
        $this->load->library('encrypt');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $user = array();
            $user['user_nama'] = $this->input->post('user_nama');
            $user['user_nip'] = $this->input->post('user_nip');
            $user['user_username'] = $this->input->post('user_username');
            $user['loker_id'] = $this->input->post('loker_id');
            $user['unit_id'] = $this->input->post('unit_id');
            $user['roles_id'] = $this->input->post('role_id');
            $user['user_status'] = $this->input->post('user_status');
            
            if ($id == '') {
                $user['user_password'] = md5($this->input->post('user_username'));
                if ($this->user_model->save_as_new($user)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                if ($this->user_model->save($user, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->user_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function reset_password($id) {
        $message = array(false, 'Proses gagal', 'Proses reset password gagal.', '');

        $user = $this->user_model->data($id)->get();
        if ($user->num_rows() > 0) {
            $dataUser = $user->row();
            $data = array();
            $data['user_password'] = md5($dataUser->user_username);
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
        $data_keahlian = $this->user_model->datakeahlian(array('user_id' => $id))->get();
            foreach ($data_keahlian->result() as $dt_keahlian) {
                $check[$dt_keahlian->keahlian_id] = array(
                    'is_add' => $dt_keahlian->keahlian_id
                );
            }
		$data['list_menu'] = $this->kompetensi_model->array_keahlian();
		$data['cek_menu'] = $check;
        $data['role_options'] = $this->role_model->options();
        $data['loker_options'] = $this->loker_model->options();
        $data['unit_options'] = $this->unit_model->options();
        echo Modules::run("template/admin", $data);
    }

    public function proses_password() {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'trim|required|min_length[5]|max_length[30]|callback_password_check_db');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'trim|required|min_length[5]|max_length[30]|matches[konf_password]|callback_password_check[password_lama]');
        $this->form_validation->set_rules('konf_password', 'Konfirmasi Password Baru', 'trim|required|min_length[5]|max_length[30]|');
        $this->form_validation->set_message('matches', 'Kedua Password Baru tidak cocok.');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $passBaru = md5($this->input->post('password_baru'));
            $id = $this->session->userdata('user_id');
            $data_user = array();
            $data_user['user_password'] = $passBaru;
            $data_user['user_last_password_update'] = date('Y-m-d');
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
            if ($dataUser->user_password == $pass) {
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
        $this->form_validation->set_rules('user_nama', 'Name', 'trim|required|min_length[5]|max_length[30]');
      
        $this->form_validation->set_rules('loker_id', 'Loker Kerja', 'trim|required');
        $this->form_validation->set_rules('unit_id', 'Unit Kerja', 'trim|required');
        
		
		$temp_usernip = $this->input->post('temp_user_nip');
        $new_usernip = $this->input->post('user_nip');
        
        if ($temp_usernip != $new_usernip) {
            $this->form_validation->set_rules('user_nip', 'NIP', 'trim|required|max_length[30]|is_unique[user.user_nip]');
        } else {
            $this->form_validation->set_rules('user_nip', 'NIP', 'trim|required|max_length[30]');
        }
		
        $this->load->library('encrypt');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $user = array();
            $user['user_nama'] = $this->input->post('user_nama');
            $user['user_nip'] = $this->input->post('user_nip');
            $user['loker_id'] = $this->input->post('loker_id');
            $user['unit_id'] = $this->input->post('unit_id');
            
            
                if ($this->user_model->save($user, $id)) {
					$this->user_model->delete_mapping($id);
					foreach($this->input->post('is_add') as $value)
					{
						$data2=array(
							'keahlian_id' => $value,
							'user_id'=> $id
						);						
						$this->user_model->save_mapping($data2);
					}
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', base_url());
                }
            
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }
	
	
	
}

/* End of file user.php */
/* Location: ./application/modules/meeting_management/controllers/user.php */
