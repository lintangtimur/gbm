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
            // $username = $this->input->post('username');
            // $password = $this->input->post('password');
            if(isset($_POST['username']) && isset($_POST['password'])){
                
                $username = $_POST['username'];
                $password = $_POST['password'];

                $domain = strtolower(substr($username, 0, strrpos($username, "\\")));
                $username = substr($username, strrpos($username, "\\") + 1, strlen($username) - strrpos($username, "\\"));

                $adServer = "ldap://10.1.8.20";
                $ldap = ldap_connect($adServer);

                // $ldaprdn = 'pusat' . "\\" . $username;
                $ldaprdn = $domain . "\\" . $username;

                ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

                $bind = @ldap_bind($ldap, $ldaprdn, $password);

                if ($bind) {
                    $filter="(sAMAccountName=$username)";
                    $result = ldap_search($ldap,"DC=".$domain.",DC=corp,DC=pln,DC=co,DC=id",$filter);
                    // ldap_sort($ldap,$result,"sn");
                    $info = ldap_get_entries($ldap, $result);
                    for ($i=0; $i<$info["count"]; $i++)
                    {
                        if($info['count'] > 1)
                            break;
                        // echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .") email= ".$info[$i]["userprincipalname"][0]."  NIK= ".$info[$i]["employeenumber"][0]." </p>\n";
                        // echo '<pre>';
                        // var_dump($info);
                        // echo '</pre>';
                        $userDn = $info[$i]["distinguishedname"][0]; 
                        $ldap_user = $info[$i]["samaccountname"][0];
                        $ldap_nik = $info[$i]["employeenumber"][0];
                        $ldap_email = $info[$i]["mail"][0]; 
                    }
                    @ldap_close($ldap);
                    //echo 'Authentication Succed';
                } 
                else {
                    $ldap_user ='';
                    //echo 'Authentication Failed';
                }
            }

            $filter = array();
            $filter['USERNAME'] = $ldap_user;
            $filter['EMAIL_USER'] = $ldap_email;
            // $filter['USERNAME`'] = $username;
            // $filter['PWD_USER'] = md5($password);//$this->user_model->encrypt($password);
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
                if ($ldap_user){
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

    public function stop() {
        $this->session->sess_destroy();
        redirect('login');
    }

}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */
