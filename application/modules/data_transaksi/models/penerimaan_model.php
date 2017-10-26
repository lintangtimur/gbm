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
    private $_table2 = "MUTASI_PENERIMAAN"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('TANGGAL' => $key);
        }
        return $key;
    }

    private function _key_edit($key){
        if (!is_array($key)) {
            $key = array('ID_PENERIMAAN' => $key);
        }
        return $key;
    }

    public function data($key = ''){

        if (!empty($key)) {
            $this->db->from($this->_table2);
            $this->db->where_condition($this->_key_edit($key));
        } else{
            $this->db->from($this->_table1);
        }
        return $this->db;
    }

    public function data_edit($key){
        $this->db->from($this->_table2);
        $this->db->where('ID_PENERIMAAN',$key);
        $query=$this->db->get();
        return $query->result();
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
        $query = $this->db->query("select * from VLOAD_LIST_DETAIL_PENERIMAAN where DATE_FORMAT(tgl_pengakuan,'%m%Y') = '".$tanggal."'");
        return $query->result();
    }

    function saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$kode_level,$user,$jumlah){
        $query = $this->db->query("call PROSES_PENERIMAAN_V2('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.")");
        return $query->result();
		// print_debug("call PROSES_PENERIMAAN_V2('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.")");
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

    public function options_transpotir($default = '--Pilih Transportir--') {
        $this->db->from('MASTER_TRANSPORTIR');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
        }
        return $option;

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

    public function options_jenis_penerimaan($default = '--Pilih Jenis Penerimaan--') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','JENIS_PENERIMAAN');
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
        $sql = "CALL SAVE_PENERIMAAN ('"
            .$data['ID_TRANSPORTIR']."','"
            .$data['ID_PEMASOK']."','"
            .$data['SLOC']."','"
            .$data['TGL_PENGAKUAN']."',
            '".$data['TGL_MUTASI']."','"
            .$data['TGL_PENERIMAAN']."','"
            .$data['VALUE_SETTING']."',"
            .$data['VOL_PENERIMAAN'].","
            .$data['VOL_PENERIMAAN_REAL'].",
            '',
            '0','".
            $data['CREATE_BY']."','"
            .$data['NO_PENERIMAAN']."','"
            .$data['ID_JNS_BHN_BKR']."')";
//        echo $sql;
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

    public function save_edit($data){
        $sql = "CALL EDIT_PENERIMAAN (
            '".$data['ID_PENERIMAAN']."',
            '".$data['STATUS']."',
            '".$data['LEVEL_USER']."',
            '".$data['KODE_LEVEL']."',
            '".$data['CREATE_BY']."',
            ".$data['VOL_PENERIMAAN'].",
            ".$data['VOL_PENERIMAAN_REAL'].")";
//        echo $sql;
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

}
?>