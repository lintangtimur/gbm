<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Login
 * @controller Login
 */
class login extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        // Protection
        hprotection::login(false);
        
        $data['page_content'] = 'login/form';
        $data['form_action'] = base_url('login/run');
        echo Modules::run("template/login", $data);
    }

    public function run() {
        $this->load->model('user_model');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $login_status = false;
        $login_message = '';
        if ($this->form_validation->run($this)) {

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $filter = array();
            $filter['USERNAME`'] = $username;
            $filter['PWD_USER'] = md5($password);//$this->user_model->encrypt($password);
            $data_user = $this->user_model->data($filter)->get();

            if ($data_user->num_rows() > 0) {
                $user = $data_user->row();
				if($user->ISAKTIF_USER=='1'){
                $login_status = true;
                    $info_login = array(
                        'login_status' => TRUE,
                        'user_id' => $user->ID_USER,
                        'roles_id' => $user->ROLES_ID,
                        'user_name' => $user->NAMA_USER,
						'level_user' => $user->LEVEL_USER,
						'kode_level' =>$user->KODE_LEVEL
                    );
                
                $this->session->set_userdata($info_login);
                }else{
                   $login_message = 'Maaf, User tidak aktif, silahkan hubungi administrator!'; 
                }
            } else {
                $login_message = 'Maaf, Username dan Password tidak sesuai.';
            }
        } else {
            $login_message = validation_errors();
        }

        if ($login_status) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('login_message', $login_message);
            redirect('login');
        }
    }

    public function stop() {
        $this->session->sess_destroy();
        redirect('login');
    }

}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */
