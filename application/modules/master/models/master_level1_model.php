<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class master_level1_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "master_level1"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('COCODE' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select('a.*, b.NAMA_REGIONAL ');
        $this->db->from($this->_table1.' a');
        $this->db->join('master_regional b', 'b.ID_REGIONAL = a.ID_REGIONAL','left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        // $this->db->set_id($this->_table1, 'ID_WILAYAH', 'no_prefix', 3);
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

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->input->post('kata_kunci');

        if (!empty($kata_kunci))
            $filter["a.COCODE LIKE '%{$kata_kunci}%' OR a.LEVEL1 LIKE '%{$kata_kunci}%' " ] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->COCODE;
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            $rows[$id] = array(
                'NO' => $no++,
                'LEVEL1' => $row->LEVEL1,
                'COCODE' => $row->COCODE,
                'NAMA_REGIONAL' => $row->NAMA_REGIONAL,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options($default = '--Pilih Level 1--', $key = 'all') {
        $option = array();

        if ($key == 'all') {
            $list = $this->data()->get();
        } else {
            $list = $this->data($this->_key($key))->get();
        }
        // array($this->_table1.'.kms_menu_id' => NULL

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->COCODE] = $row->LEVEL1;
        }
        return $option;
    }

}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */