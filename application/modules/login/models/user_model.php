<?php

/**
 * @package Login
 * @modul User
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'user_webadmin';

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('user_id' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function encrypt($str) {
        return md5($str);
    }

}

/* End of file user.php */
/* Location: ./application/modules/login/models/user.php */