<?php

/**
 * @module User Management
 */
class template_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "m_otoritas_menu";
    private $_table2 = "m_menu";
    private $_table3 = "global_settings";
    private $_table = "setting";
    
    public function data_menu($key = '') {
        $this->db->from($this->_table1);
        $this->db->join($this->_table2, "{$this->_table2}.menu_id = {$this->_table1}.menu_id");

        $this->db->where_condition(array("{$this->_table1}.roles_id" => $key));

        $this->db->order_by($this->_table2 . '.menu_urutan');
        return $this->db;
    }
    
    public function parameter() {
        $this->db->from($this->_table);
        $param = $this->db->get();
        return $param;//->row();
    }
    
    

}

/* End of file tm_menu.php */
/* Location: ./application/modules/user_management/models/tm_menu.php */