<?php

/**
 * @module role management
 */
class role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "ROLES";
    private $_table2 = "M_OTORITAS_MENU";

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ROLES_ID' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        return $this->db;
    }

    public function save_as_new($data, $temp) {
        $this->db->trans_begin();
        $save_id = $this->db->set_id($this->_table1, 'ROLES_ID', 'no_prefix', 2);
        $this->db->insert($this->_table1, $data);
        $this->save_otoritas($save_id, $temp);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save_otoritas($save_id, $temp) {
        $this->db->delete($this->_table2, array('ROLES_ID' => $save_id));
        foreach ($temp as $key => $val) {
            $data_otoritas = array();
            $data_otoritas['roles_id'] = $save_id;
            $data_otoritas['menu_id'] = $key;
            $data_otoritas['is_view'] = isset($val['is_view']) ? 't' : 'f';
            $data_otoritas['is_add'] = isset($val['is_add']) ? 't' : 'f';
            $data_otoritas['is_edit'] = isset($val['is_edit']) ? 't' : 'f';
            $data_otoritas['is_delete'] = isset($val['is_delete']) ? 't' : 'f';
            $data_otoritas['is_approve'] = isset($val['is_approve']) ? 't' : 'f';
            $this->db->insert($this->_table2, $data_otoritas);
        }
    }

    public function save($data, $key, $temp) {
        $this->db->trans_begin();
        $this->db->update($this->_table1, $data, $this->_key($key));
        $this->save_otoritas($key, $temp);
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
            $filter[$this->_table1 . ".ROLES_NAMA LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $rows = array();
        $no = $offset;
        foreach ($record->result() as $row) {
            $id = $row->ROLES_ID;
            $aksi = '';
            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
            $rows[$no] = array(
                'no' => $no,
                'roles_nama' => $row->ROLES_NAMA,
                'roles_keterangan' => $row->ROLES_KETERANGAN,
                'aksi' => !empty($aksi) ? $aksi : '<i class="icon-lock denied-color" title="Acces Denied"></i>'
            );
            $no++;
        }
        return array('total' => $total, 'rows' => $rows);
    }

    public function options($default = '--Pilih Role User--') {
        $option = array();
        $list = $this->data()->get();

        if (!empty($default))
            $option[''] = $default;

        foreach ($list->result() as $row) {
            $option[$row->ROLES_ID.'..'.$row->LEVEL_ROLES] = $row->ROLES_NAMA;
        }

        return $option;
    }

}

/* End of file role_model.php */
/* Location: ./application/modules/unit/models/role_model.php */