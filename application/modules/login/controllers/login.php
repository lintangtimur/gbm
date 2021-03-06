<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package Login
 * @controller Login
 */
class login extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
    }

    public function index()
    {
        hprotection::login(false);
        $this->load->module('template/asset');
        $this->asset->set_plugin(array('crud'));
        $data['page_content'] = 'login/form';
        $data['form_action']  = base_url('login/run');
        $data['form_reset']   = base_url('login/reset_session');
        echo Modules::run('template/login', $data);
    }

    public function run()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $login_status  = false;
        $login_message = '';
        $ldap_cek      = false;
        $ldap_user     = '';
        if ($this->form_validation->run($this)) {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $domain   = strtolower(substr($username, 0, strrpos($username, '\\')));
                $username = substr($username, strrpos($username, '\\') + 1, strlen($username) - strrpos($username, '\\'));

                $adServer = 'ldap://10.1.8.20';
                $ldap     = ldap_connect($adServer);

                // $ldaprdn = 'pusat' . "\\" . $username;
                $ldaprdn = $domain . '\\' . $username;

                ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

                $bind = @ldap_bind($ldap, $ldaprdn, $password);
                if ($bind) {
                    $ldap_user = $username;
                    $ldap_cek  = true;
                    $filter    ="(sAMAccountName=$username)";
                    // $filter = "(&(objectCategory=person)(sAMAccountName=*))";

                    $result = ldap_search($ldap, 'DC=' . $domain . ',DC=corp,DC=pln,DC=co,DC=id', $filter);
                    // ldap_sort($ldap,$result,"sn");
                    $info = ldap_get_entries($ldap, $result);
                    // var_dump($info); die;

                    for ($i=0; $i < $info['count']; $i++) {
                        // if($info['count'] > 1)
                        //     break;

                        // echo "<p>".$i." You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .") email= ".$info[$i]["mail"][0]."  NIK= ".$info[$i]["employeenumber"][0]." </p>\n";
                        // echo '<pre>';
                        // // var_dump($info);
                        // echo '</pre>';
                        // echo '<br><br>';

                        $userDn     = $info[$i]['distinguishedname'][0];
                        $ldap_user  = $info[$i]['samaccountname'][0];
                        $ldap_nik   = $info[$i]['employeenumber'][0];
                        $ldap_email = $info[$i]['mail'][0];
                    }
                    // echo '<br><br> TOTAL : '.$i;
                    @ldap_close($ldap);
                    // die;
                    //echo 'Authentication Succed';
                    if (!$ldap_user) {
                        $ldap_user = $username;
                    }
                    $data_user = $this->user_model->dataldap($ldap_user, $ldap_email);
                } else {
                    $username  = $this->input->post('username');
                    $password  = $this->input->post('password');
                    $data_user = $this->user_model->data($username, $password);
                    $ldap_user ='';
                    //echo 'Authentication Failed';
                }
            }

            if ($data_user->num_rows() > 0) {
                $user = $data_user->row();
                if ($user->RCDB == 'RC01') {
                    $login_status = true;
                    $info_login   = array(
                        'login_status'  => true,
                        'user_id'       => $user->ID_USER,
                        'roles_id'      => $user->ROLES_ID,
                        'user_name'     => $user->NAMA_USER,
                        'level_user'    => $user->LEVEL_USER,
                        'kode_level'    => $user->KODE_LEVEL,
                        'ldap_cek'      => $ldap_cek,
                        'ldap_user'     => $ldap_user,
                        'ldap_domain'   => $domain,
                        'ldap_password' => $password
                    );
                    $this->session->set_userdata($info_login);
                } else {
                    $login_message = $user->PESANDB;
                }
            } else {
                if ($ldap_user) {
                    $login_message = 'Maaf, Username anda tidak terdaftar di sistem GBM, silahkan hubungi helpdesk untuk info lebih lanjut';
                } else {
                    $login_message = 'Maaf, Username dan Password tidak sesuai.';
                }
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

    public function stop()
    {
        $this->user_model->logout($this->session->userdata('user_id'));
        $this->session->sess_destroy();
        redirect('login');
    }

    public function reset_session()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run($this)) {
            $email     = $this->input->post('email');
            $data_user = $this->user_model->reset($email);
            if ($data_user[0]->RCDB == 'RC00') {
                $message = array(false, 'Proses Gagal', $data_user[0]->PESANDB, '');
            } else {
                $message = array(true, 'Proses Berhasil', $data_user[0]->PESANDB, '');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }
}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */
