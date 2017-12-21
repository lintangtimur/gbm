<?php


/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class perhitungan_harga_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "T_PERHITUNGAN"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PERHITUNGAN' => $key);
        }
        return $key;
    }

    public function data($key = '') {
       $this->db->from($this->_table1);
       if (!empty($key) || is_array($key))
       $this->db->where_condition($this->_key($key));

       $rest = $this->db;
       $this->db->close();
       return $rest;

    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_PERHITUNGAN', 'no_prefix', 3);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }

        $this->db->close();
        return $rest;
    }

    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function delete($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table1, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->input->post('kata_kunci');

        if (!empty($kata_kunci))
            $filter[$this->_table1 . ".BLTH LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_PERHITUNGAN;
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            $rows[$id] = array(
                'ID_PERHITUNGAN' => $no++,
                'blth' => $row->blth,
                'hsdppn' => $row->hsdppn,
                'mfoppn' => $row->mfoppn,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('master_pemasok');
    
        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;    
    }

    public function options_type($default = '--Pilih Type Pemasok--') {
        
        $option = ['PERTAMINA', 'NON PERTAMINA'];
        
        return $option;    
        
    }
	 
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */