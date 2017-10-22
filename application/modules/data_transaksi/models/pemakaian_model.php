<?php

/**
 * Class pemakaian_model
 * User: mrapry
 * Date: 10/20/17
 * Time: 20:10 AM
 */
class pemakaian_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "VLOAD_LIST_PEMAKAIAN"; //nama table setelah mom_

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
		$num = 1;
        foreach ($record->result() as $row) {
            // $count = $row->COUNT_VOLUME;
            // if ($count!=0) {
                $id = $row->TANGGAL;
                $aksi = anchor(null, '<i class="icon-eye-open"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
                $rows[$num] = array(
                    'NO' => $num,
                    'BLTH' => $row->BLTH,
                    'LEVEL4' => $row->LEVEL4,
                    'STATUS' => $row->STATUS_APPROVE,
                    'TOTAL_VOLUME' => $row->SUM_VOLUME,
                    'COUNT' => $row->COUNT_VOLUME,
                    'AKSI' => $aksi
                );
				$num++;
            // }
        }
        return array('total' => $total, 'rows' => $rows);
    }

    function getTableViewDetail($tanggal){
        $data = $this->db->query("select * from VLOAD_LIST_DETAIL_PEMAKAIAN where DATE_FORMAT(TGL_PENGAKUAN,'%m%Y') = '".$tanggal."'");
        return $data->result();
    }

    function saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$user,$jumlah){
        $query = $this->db->query("call PROSES_PEMAKAIAN_V2('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$user."',".$jumlah.")");
        return $query->result();
    }

    public function options_jenis_bahan_bakar($default = '--Pilih Jenis Bahan Bakar--') {
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

    public function options_jenis_pemakaian($default = '--Pilih Jenis Penerimaan--') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','JENIS_PEMAKAIAN');
        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        return $option;

    }

    public function options_level($level_user,$kode_level) {
        $default = '--Pilih Level--';
        $query = $this->db->query('call LOAD_LEVEL4('.$level_user.', '.$kode_level.')');
        $option = array();
        $list = $query;

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->SLOC] = $row->LEVEL4;
        }
        $this->db->close();
        return $option;

    }

    public function save($data){
        $sql = "CALL SAVE_PEMAKAIAN ('"
            .$data['SLOC']."','"
            .$data['TGL_PENGAKUAN']."','"
            .$data['TGL_CATAT']."','"
            .$data['VALUE_SETTING']."',"
            .$data['VOL_PEMAKAIAN'].",'"
            .$data['KETERANGAN']."',
            '0','".
            $data['CREATE_BY']."','"
            .$data['NO_PEMAKAIAN']."','"
            .$data['ID_JNS_BHN_BKR']."')";
//        echo $sql;
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }
}
?>