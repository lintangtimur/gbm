<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class master_level3_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_LEVEL3"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('STORE_SLOC' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select('a.*, b.LEVEL2, c.COCODE, c.LEVEL1, d.ID_REGIONAL, d.NAMA_REGIONAL');
        $this->db->from($this->_table1.' a');
        $this->db->join('MASTER_LEVEL2 b', 'b.PLANT = a.PLANT','left');
        $this->db->join('MASTER_LEVEL1 c', 'c.COCODE = b.COCODE','left');
        $this->db->join('MASTER_REGIONAL d', 'd.ID_REGIONAL = c.ID_REGIONAL','left');


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
            $filter["a.STORE_SLOC LIKE '%{$kata_kunci}%' OR a.LEVEL3 LIKE '%{$kata_kunci}%' OR b.LEVEL2 LIKE '%{$kata_kunci}%' OR c.LEVEL1 LIKE '%{$kata_kunci}%' OR d.NAMA_REGIONAL LIKE '%{$kata_kunci}%'" ] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        
        $rows = array();
        
        $no=(($offset-1) * $limit) +1;

        foreach ($record->result() as $row) {
            $id = $row->STORE_SLOC;
            $aksi = '';
            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
            $rows[$no] = array(
                'NO' => $no,
                'LEVEL3' => $row->LEVEL3,
                'STORE_SLOC' => $row->STORE_SLOC,
                'NAMA_REGIONAL' => $row->NAMA_REGIONAL,
                'LEVEL1' => $row->LEVEL1,
                'LEVEL2' => $row->LEVEL2,
                'aksi' => $aksi
            );
            $no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;    
        }
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            return $option;    
        }
    }

}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */