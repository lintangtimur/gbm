<?php

/**
 * Class perhitungan_harga_model
 * User: mrapry
 * Date: 10/20/17
 * Time: 20:10 AM
 */
class penerimaan_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "VLOAD_LIST_PENERIMAAN"; //nama table setelah mom_
    private $_table2 = "VLOAD_LIST_DETAIL_PENERIMAAN";

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('TANGGAL' => $key);
        }
        return $key;
    }

    private function data($key = ''){
        $this->db->from($this->_table1);
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    private function data_detail($key = ''){
        $this->db->from($this->_table2);
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
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
            $count = $row->COUNT_VOLUME;
            if ($count!=0) {
                $id = $row->TANGGAL;
                $aksi = anchor(null, '<i class="icon-eye-open"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
                $rows[$id] = array(
                    'NO' => $no++,
                    'BLTH' => $row->BLTH,
                    'LEVEL4' => $row->LEVEL4,
                    'STATUS' => $row->STATUS_APPROVE,
                    'TOTAL_VOLUME' => $row->SUM_VOLUME,
                    'COUNT' => $row->COUNT_VOLUME,
                    'AKSI' => $aksi
                );
            }
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function data_table_detail($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->input->post('kata_kunci_detail');

        if (!empty($kata_kunci))
            $filter[$this->_table2 . ".TGL_PENGAKUAN LIKE '%{$kata_kunci}%' "] = NULL;

        $total = $this->data_detail($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_detail($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
                $id = $row->ID_PENERIMAAN;
                $aksi = anchor(null, '<i class="icon-eye-open"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail('.$id.')'));
                $rows[$id] = array(
                    'ID' => $row->ID_PENERIMAAN,
                    'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                    'NAMA_PEMASOK' => $row->NAMA_PEMASOK,
                    'NAMA_TRANSPORTIR' => $row->NAMA_TRANSPORTIR,
                    'NAMA_JNS_BHN_BKR'=>$row->NAMA_JNS_BHN_BKR,
                    'VOL_TERIMA'=>$row->VOL_TERIMA,
                    'VOL_TERIMA_REAL'=>$row->VOL_TERIMA_REAL,
                    'STATUS'=>$row->STATUS,
                    'AKSI' => $aksi,
                );
        }
        return array('total' => $total, 'rows' => $rows);
    }
}
?>