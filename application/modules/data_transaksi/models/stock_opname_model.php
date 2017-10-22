<?php
 /**
 * @module STOCK OPNAME
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class stock_opname_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "STOCK_OPNAME"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_STOCKOPNAME' => $key);
        }
        return $key;
    }

    
    public function data($key = '') {
        $this->db->select('a.*, b.NAMA_JNS_BHN_BKR, c.LEVEL4');
        $this->db->from($this->_table1.' a');
        $this->db->join('M_JNS_BHN_BKR b', 'b.ID_JNS_BHN_BKR = a.ID_JNS_BHN_BKR', 'left');
        $this->db->join('MASTER_LEVEL4 c', 'c.SLOC = a.SLOC', 'left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }
    public function callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER){
        $this->db->query("CALL PROSES_STOCK_OPNAME('$ID_STOCKOPNAME', '$SLOC', '$ID_JNS_BHN_BKR', '$TGL_PENGAKUAN', '$LEVEL_USER', '$STATUS', '$USER')");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }
    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_STOCKOPNAME', 'no_prefix', 3);
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
            $filter[$this->_table1 . ".SLOC LIKE '%{$kata_kunci}%' "] = NULL;
            $total = $this->data($filter)->count_all_results();
            $this->db->limit($limit, ($offset * $limit) - $limit);
            $record = $this->data($filter)->get();
            $no=(($offset-1) * $limit) +1;
            $rows = array();
            foreach ($record->result() as $row) {
                $id = $row->ID_STOCKOPNAME;
                $aksi = anchor(null, '<i class="icon-share"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'kirim_row(this.id)', 'data-source' => base_url($module . '/sendAction/' . $id)));
                $aksi .= anchor(null, '<i class="icon-check"></i>', array('class' => 'btn transparant', 'id' => 'button-approve-' . $id, 'onclick' => 'approve_row(this.id)', 'data-source' => base_url($module . '/approveAction/' . $id)));
                $aksi .= anchor(null, '<i class="icon-remove"></i>', array('class' => 'btn transparant', 'id' => 'button-tolak-' . $id, 'onclick' => 'tolak_row(this.id)', 'data-source' => base_url($module . '/tolakAction/' . $id)));
                
                // $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                // $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                $rows[$id] = array(
                    'ID_STOCKOPNAME' => $no++,
                    'NO_STOCKOPNAME' => $row->NO_STOCKOPNAME,
                    'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                    'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                    'LEVEL4' => $row->LEVEL4,
                    'VOLUME_STOCKOPNAME' => $row->VOLUME_STOCKOPNAME,
                    'STATUS_APPROVE_STOCKOPNAME' => $row->STATUS_APPROVE_STOCKOPNAME,
                    'aksi' => $aksi
                );
            }    

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_jns_bhn_bkr($default = '--Pilih Pemasok--') {
        $this->db->from('M_JNS_BHN_BKR');
    
        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        return $option;    
        
    }


    public function options_pembangkit($default = '--Pilih Pembangkit--') {
        $this->db->from('MASTER_LEVEL4');
    
        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->SLOC] = $row->LEVEL4;
        }
        return $option;    
        
    }

}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */