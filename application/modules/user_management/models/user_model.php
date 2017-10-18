<?php

/**
 * @module User Management (User)
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "m_user";
    private $_table2 = "roles";
    private $_table3 = "m_loker";
    private $_table4 = "m_unit";
	private $_table_mapping = "keahlian_user";

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select("a.*, b.roles_nama, (CASE 
		WHEN a.LEVEL_USER = '0' THEN 'SGBM'
		WHEN a.LEVEL_USER = 'R' THEN (SELECT c.NAMA_REGIONAL FROM master_regional c 
						WHERE c.ID_REGIONAL = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '1' THEN (SELECT c.LEVEL1 FROM master_level1 c 
						WHERE c.COCODE = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '2' THEN (SELECT c.LEVEL2 FROM master_level2 c 
						WHERE c.PLANT = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '3' THEN (SELECT c.LEVEL3 FROM master_level3 c 
						WHERE c.PLANT = (SELECT SPLIT_STR(a.KODE_LEVEL, ';', 1))
						AND c.STORE_SLOC = (SELECT SPLIT_STR(a.KODE_LEVEL, ';', 2)))
		WHEN a.LEVEL_USER = '4' THEN (SELECT c.LEVEL4 FROM master_level4 c 
						WHERE c.PLANT = a.KODE_LEVEL) END) as LOKER_NAMA ", false);
        $this->db->from($this->_table1 . ' a ');
        $this->db->join($this->_table2 . ' b', 'b.ROLES_ID = a.ROLES_ID');
		
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function save_as_new($roleid, $kduser, $nama, $username, $pwd, $email, $level, $kodelevel, $isaktif, $id = '') {
        // $this->db->trans_begin();

        // $this->db->set_id($this->_table1, 'user_id', 'date_prefix', 10);
        // $this->db->insert($this->_table1, $data);

        // if ($this->db->trans_status() === FALSE) {
            // $this->db->trans_rollback();
            // return FALSE;
        // } else {
            // $this->db->trans_commit();
            // return TRUE;
        // }
		$user = $this->session->userdata("user_name")."-".$this->session->userdata("kode_level");
		$query = "call save_user('". $roleid ."','". $kduser ."','". $nama ."','". $username ."','". $pwd ."','". $email ."','". $level ."','". $kodelevel ."','". $isaktif ."','". $user ."', '".$id."')";
		
		$data = $this->db->query($query);
		
		return $data;
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
            $filter["a.NAMA_USER LIKE '%{$nama}%' "] = NULL;
        }
        if (!empty($role)) {
            $filter["a.roles_id"] = $role;
        }
        if (!empty($status)) {
            $filter["a.isaktif_user"] = $status;
        }
		$total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		

        $rows = array();
        $no = $offset;
		// print_debug($record->result());
        foreach ($record->result() as $row) {
            $id = $row->ID_USER;
			$aksi = '';
			if ($this->laccess->otoritas('edit'))
				$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
			if ($this->laccess->otoritas('delete'))
				$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
         
            $rows[$id] = array(
				'no' => $no,
                'user_nama' => $row->NAMA_USER,
                'user_username' => $row->USERNAME,
                'role_nama' => $row->roles_nama,
                'user_status' => !empty($row->ISAKTIF_USER) ? hgenerator::status_user($row->ISAKTIF_USER) : '',
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