<?php


/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class depo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_DEPO"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_DEPO' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select('a.*, b.NAMA_PEMASOK');
        $this->db->from($this->_table1.' a');
        $this->db->join('MASTER_PEMASOK b', 'b.ID_PEMASOK = a.ID_PEMASOK', 'left');
        

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        $this->db->order_by('CD_DEPO', 'ASC');

        return $this->db;

    }

    function check_depo($kd_depo){
        $query = $this->db->get_where($this->_table1, array('KD_DEPO' => $kd_depo));
       
        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
     }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_DEPO', 'no_prefix', 3);
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
        $filter["a.NAMA_DEPO LIKE '%{$kata_kunci}%' or b.NAMA_PEMASOK LIKE '%{$kata_kunci}%' or a.LAT_DEPO LIKE '%{$kata_kunci}%' or  a.LOT_DEPO LIKE '%{$kata_kunci}%' or a.ALAMAT_DEPO LIKE '%{$kata_kunci}%'"] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_DEPO;

            if ($this->laccess->otoritas('edit')) {
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }
            
            if ($this->laccess->otoritas('delete')) {
            $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
            $rows[$id] = array(
                'ID_DEPO' => $no++,
                'NAMA_PEMASOK' => $row->NAMA_PEMASOK,
                'KD_DEPO' => $row->KD_DEPO,
                'NAMA_DEPO' => $row->NAMA_DEPO,
                'LAT_DEPO' => $row->LAT_DEPO,
                'LOT_DEPO' => $row->LOT_DEPO,
                'ALAMAT_DEPO' => $row->ALAMAT_DEPO,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('MASTER_PEMASOK');
    
        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        return $option;    
        
    }
	 


}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */