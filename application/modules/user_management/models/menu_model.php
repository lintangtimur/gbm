<?php

/**
 * @module Menu
 */
class menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->laccess->check(array('user_management/menu'));
    }

    private $_table1 = "m_menu";
    private $_rows = array();

    private function _key($key) {
        if (!is_array($key)) {
            $key = array('menu_id' => $key);
        }
        return $key;
    }

    // untuk mendapatkan data
    public function data($key = '') {
        $this->db->from($this->_table1);
        if (!empty($key) || is_array($key)) {
            $this->db->where_condition($this->_key($key));
        }
        return $this->db;
        // mereturn objek db, jd bisa di get,set dll
    }

    // create data baru
    public function save_as_new($data) {

        $this->db->trans_begin(); //transaksi = ketika semua proses sudah dilakukan di commit

        $this->db->set_id($this->_table1, 'menu_id', 'no_prefix', 3); //set id handle auto increment -table -field

        $this->db->insert($this->_table1, $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // untuk update data
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

    // untuk menampilkan data ke table 
    public function data_table($module = '') {

        // show parent
        $parent = array();
        // $parent['kms_menu_id'] = NULL;
        $total = $this->data($parent)->count_all_results();
        $this->db->order_by($this->_table1 . '.menu_urutan');
        $record = $this->data($parent)->get();

        $temp = array();
        foreach ($record->result() as $value) {
            $parent_id = $value->kms_menu_id;
            $parent = !empty($parent_id) ? $parent_id : 0;
            $temp[$parent][] = $value;
        }

        $this->_parsing_menu(0, $temp, $module);
        $rows = $this->_rows;

        return array('total' => $total, 'rows' => $rows);
    }

    private function _parsing_menu($parent_id, $temp, $module) {
        if (isset($temp[$parent_id])) {
			$aksi = '';
            foreach ($temp[$parent_id] as $row) {
                $id = $row->menu_id;
				// Validasi User Role Menu Edit
				if ($this->laccess->otoritas('edit', false, 'user_management/menu'))
					$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
				// Validasi User Role Menu Edit
                if ($this->laccess->otoritas('delete', false, 'user_management/menu'))
					$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));

                $flag = anchor(null, '<i class="icon-chevron-down"></i>');
                $title = '<a style="color:#0072c6;font-weight:bold;">' . $row->menu_nama . '</a>';
                if ($parent_id > 0) {
                    $flag = anchor(null, '<i class="icon-menu"></i>');
                    $title = $row->menu_nama;
                }

                $this->_rows[$id] = array(
                    'menu_flag' => $flag,
                    'menu_icon' => !empty($row->menu_icon) ? "<i class='{$row->menu_icon}'></i>" : '-',
                    'menu_nama' => $title,
                    'menu_url' => $row->menu_url,
                    'menu_keterangan' => $row->menu_keterangan,
                    'menu_urutan' => $row->menu_urutan,
                    'aksi' => $aksi
                );
                $this->_parsing_menu($row->menu_id, $temp, $module);
				$aksi = '';
            }
        }
    }

    public function options($default = '--Pilih Parent--', $key = 'all') {
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
            $option[$row->menu_id] = $row->menu_nama;
        }
        return $option;
    }

}

/* End of file tm_gelar.php */
/* Location: ./application/modules/menu/models/menu.php */