<?php

/**
 * @module User Management (User)
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "user_webadmin";
    private $_table2 = "role";
    private $_table3 = "m_loker";
    private $_table4 = "m_unit";
	private $_table_mapping = "keahlian_user";

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('user_id' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select("a.*, b.roles_nama, c.loker_nama ");
        $this->db->from($this->_table1 . ' a ');
        $this->db->join($this->_table2 . ' b', 'b.roles_id = a.roles_id');
        $this->db->join($this->_table3 . ' c', 'c.loker_id = a.loker_id');
		// $this->db->join($this->_table4 . ' d', 'd.unit_id = a.unit_id','LEFT');
		// print_r($this->db->last_query());
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();

        $this->db->set_id($this->_table1, 'user_id', 'date_prefix', 10);
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

    public function reset_password($key) {
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

    public function data_table($module = '', $limit = 20, $offset = 1) {
        // data filtering
        $filter = array();
        $nama = $this->input->post('nama');
        $role = $this->input->post('role');
        $loker = $this->input->post('loker');
        $unit = $this->input->post('unit');
        $status = $this->input->post('status');

        if (!empty($nama)) {
            $filter["a.user_nama LIKE '%{$nama}%'"] = NULL;
        }
        if (!empty($role)) {
            $filter["a.roles_id"] = $role;
        }
        if (!empty($loker)) {
            $filter["a.loker_id"] = $loker;
        }
        if (!empty($unit)) {
            $filter["a.unit_id"] = $unit;
        }
        if (!empty($status)) {
            $filter["a.user_status"] = $status;
        }

        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();

        $rows = array();
        $no = $offset;
        foreach ($record->result() as $row) {
            $id = $row->user_id;
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
         
            $rows[$id] = array(
				'no' => $no,
                'user_nama' => $row->user_nama,
                'user_username' => $row->user_username,
                'role_nama' => $row->roles_nama,
                'user_status' => !empty($row->user_status) ? hgenerator::status_user($row->user_status) : '',
                'aksi' => $aksi
            );
            $no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }
	
	

    public function datakeahlian($key = '') {
        $this->db->from($this->_table_mapping);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }
	
	public function save_mapping($data) {
        $this->db->trans_begin();
 
        $this->db->insert($this->_table_mapping, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_mapping($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table_mapping, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}

/* End of file user_model.php */
/* Location: ./application/modules/meeting_management/models/user_model.php */ 