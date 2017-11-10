<?php

/**
 * @package Login
 * @modul User
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'M_USER';

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    public function data($a, $password) {
        // $this->db->from($this->_table1);
        // if (!empty($key) || is_array($key))
            // $this->db->where_condition($this->_key($key));
        // return $this->db;
		$query = "call LOGIN('".$a."', '".$password."')";
		$data = $this->db->query($query);
		return $data;
    }
	
	public function dataldap($email, $username) {
        $query = "call LOGIN_LDAP('".$email."', '".$username."')";
		$data = $this->db->query($query);
		return $data;
    }
	
	public function logout($iduser){
		$this->db->where("ID_USER", $iduser);
		$this->db->update($this->_table1, array("IS_LOGIN"=> "0"));
	}

	public function reset($email){
		// $this->db->where("EMAIL_USER", $email);
		// $this->db->update($this->_table1, array("IS_LOGIN"=> "0"));
		$query = "call RESET_SESSION('$email')";
		$data = $this->db->query($query);
		
		return $data->result();
	}
	
    public function encrypt($str) {
        return md5($str);
    }
}

/* End of file user.php */
/* Location: ./application/modules/login/models/user.php */