<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class lap_persediaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "REKAP_MUTASI_PERSEDIAAN"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_MUTASI_PERSEDIAAN' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $kolom = 'M1.LEVEL1, M2.LEVEL2, M3.LEVEL3, M4.LEVEL4, JB.NAMA_JNS_BHN_BKR, A.TGL_MUTASI_PERSEDIAAN, A.STOCK_AWAL, A.PENERIMAAN_REAL, A.PEMAKAIAN, PM.VOLUME_PEMAKAIAN, A.DEAD_STOCK, SO.VOLUME_STOCKOPNAME, A.STOCK_AKHIR_REAL, A.STOCK_AKHIR_EFEKTIF, A.STOCK_AKHIR_KOREKSI, A.SHO, A.REVISI_MUTASI_PERSEDIAAN';
        $this->db->select($kolom);
        $this->db->from($this->_table1.' A');
        $this->db->join('DETIL_PERSEDIAAN B', 'B.ID_MUTASI_PERSEDIAAN = A.ID_MUTASI_PERSEDIAAN','left');
        $this->db->join('MASTER_LEVEL4 M4', 'M4.SLOC = B.SLOC','left');
        $this->db->join('MASTER_LEVEL3 M3', 'M3.STORE_SLOC = M4.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 M2', 'M2.PLANT = M3.PLANT','left');
        $this->db->join('MASTER_LEVEL1 M1', 'M1.COCODE = M2.COCODE','left');
        $this->db->join('M_JNS_BHN_BKR JB', 'JB.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR','left');
        $this->db->join('MUTASI_PEMAKAIAN PM', 'PM.ID_PEMAKAIAN = B.ID_PEMAKAIAN','left');
        $this->db->join('STOCK_OPNAME SO', 'SO.ID_STOCKOPNAME = B.ID_STOCKOPNAME','left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->input->post('kata_kunci');

        // if (!empty($kata_kunci))
        //     $filter["a.COCODE LIKE '%{$kata_kunci}%' OR a.LEVEL1 LIKE '%{$kata_kunci}%' " ] = NULL;

        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_MUTASI_PERSEDIAAN;
            $aksi = '';
            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
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
    
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */