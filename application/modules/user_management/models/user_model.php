<?php

/**
 * @module User Management (User)
 */
class user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "M_USER";
    private $_table2 = "ROLES";
    private $_table3 = "M_LOKER";
    private $_table4 = "M_UNIT";

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select("a.*, b.ROLES_NAMA, (CASE 
		WHEN a.LEVEL_USER = '0' THEN 'SGBM'
		WHEN a.LEVEL_USER = 'R' THEN (SELECT c.NAMA_REGIONAL FROM MASTER_REGIONAL c 
						WHERE c.ID_REGIONAL = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '1' THEN (SELECT c.LEVEL1 FROM MASTER_LEVEL1 c 
						WHERE c.COCODE = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '2' THEN (SELECT c.LEVEL2 FROM MASTER_LEVEL2 c 
						WHERE c.PLANT = a.KODE_LEVEL)
		WHEN a.LEVEL_USER = '3' THEN (SELECT c.LEVEL3 FROM MASTER_LEVEL3 c 
						WHERE c.PLANT = (SELECT SPLIT_STR(a.KODE_LEVEL, ';', 1))
						AND c.STORE_SLOC = (SELECT SPLIT_STR(a.KODE_LEVEL, ';', 2)))
		WHEN a.LEVEL_USER = '4' THEN (SELECT c.LEVEL4 FROM MASTER_LEVEL4 c 
						WHERE c.PLANT = a.KODE_LEVEL) END) as LOKER_NAMA ", false);
        $this->db->from($this->_table1 . ' a ');
        $this->db->join($this->_table2 . ' b', 'b.ROLES_ID = a.ROLES_ID');
		
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function save_as_new($roleid, $kduser, $nama, $username, $pwd, $email, $level, $kodelevel, $isaktif, $id = '') {
		$user = $this->session->userdata("user_name")."-".$this->session->userdata("kode_level");
		$query = "call SAVE_USER('". $roleid ."','". $kduser ."','". $nama ."','". $username ."','". $pwd ."','". $email ."','". $level ."','". $kodelevel ."','". $isaktif ."','". $user ."', '".$id."')";
		// print_debug($query);
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

	public function edit($key, $data) {
        $this->db->trans_begin();
		$this->db->set($data);
		$this->db->where($this->_key($key));
        $this->db->update($this->_table1);

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

	public function logout($iduser){
		$this->db->where("ID_USER", $iduser);
		$this->db->update($this->_table1, array("IS_LOGIN"=> "0"));
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
            $filter["a.ROLES_ID"] = $role;
        }
        if (!empty($status)) {
            $filter["a.ISAKTIF_USER"] = $status;
        }
		$total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		

        $rows = array();
        $no=(($offset-1) * $limit) +1;
		
        foreach ($record->result() as $row) {
            $id = $row->ID_USER;
			$aksi = '';
			if ($this->laccess->otoritas('edit'))
				$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
			if ($this->laccess->otoritas('delete'))
				if($row->ISAKTIF_USER <> "1")
					$aksi .= anchor(null, '<i class="icon-close"></i>', array('class' => 'btn transparant', 'id' => 'button-aktif-' . $id, 'onclick' => 'aktivasi_user(this.id, "Mengaktifkan")', 'data-source' => base_url($module . '/aktif/' . $id)));
				else
					$aksi .= anchor(null, '<i class="icon-check"></i>', array('class' => 'btn transparant', 'id' => 'button-aktif-' . $id, 'onclick' => 'aktivasi_user(this.id, "Menonaktifkan")', 'data-source' => base_url($module . '/nonaktif/' . $id)));
         
            $rows[$no] = array(
				'no' => $no,
                'user_nama' => $row->NAMA_USER,
                'user_username' => $row->USERNAME,
                'role_nama' => $row->ROLES_NAMA,
                'user_status' => !empty($row->ISAKTIF_USER) ? hgenerator::status_user($row->ISAKTIF_USER) : 'Tidak Aktif',
                'aksi' => $aksi
            );
			$no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }
	
}

/* End of file user_model.php */
/* Location: ./application/modules/meeting_management/models/user_model.php */ 