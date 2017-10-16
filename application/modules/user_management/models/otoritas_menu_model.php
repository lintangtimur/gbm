<?php

/**
 * @module role management
 */
class otoritas_menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	private $_table1="m_otoritas_menu";
    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('roles_id' => $key);
        }
        return $key;
    }
	
    public function data($key = ''){
        $this->db->from($this->_table1);
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        //$this->db->set_id($this->_table1, 'roles_id', 'no_prefix', 3);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save($data, $key) {
        $this->db->trans_begin();
        $this->db->update($this->_table1, $data, $this->_key($key));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete($key) {
        $this->db->trans_begin();
        $this->db->delete($this->_table1, $this->_key($key));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function options($default = '--Pilih Otoritas Data--') {
        $option = array();
        $list = $this->data()->get();
        if (!empty($default))
            $option[''] = $default;
        foreach ($list->result() as $row) {
            $option[$row->roles_id] = $row->roles_nama;
        }

        return $option;
    }

}

/* End of file otoritas_menu_model.php */
/* Location: ./application/modules/unit/models/otoritas_menu_model.php */