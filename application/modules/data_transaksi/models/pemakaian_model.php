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

    private $_table1 = "VLOAD_LIST_PEMAKAIAN_V2"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('TANGGAL' => $key);
        }
        return $key;
    }

    private function data($key = ''){
        $this->db->select('a.*, sum(a.COUNT_VOLUME) as JML, sum(a.SUM_volume) as JML_VOLUME');
        $this->db->from($this->_table1.' a' );
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("COCODE",$_POST['COCODE']);   
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("PLANT",$_POST['PLANT']);   
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);   
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("SLOC",$_POST['SLOC']);   
        }

        $this->db->group_by('ID_REGIONAL');
        if ($_POST['COCODE'] !='') {
            $this->db->group_by('COCODE');
        }
        if ($_POST['PLANT'] !='') {
            $this->db->group_by('PLANT');
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->group_by('STORE_SLOC');
        }
        if ($_POST['SLOC'] !='') {
            $this->db->group_by('SLOC');
        }

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
                $id = $row->TANGGAL.'|'.$row->ID_REGIONAL;
                $aksi = anchor(null, '<i class="icon-eye-open"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
                $rows[$num] = array(
                    'NO' => $num,
                    'BLTH' => $row->BLTH,
                    'LEVEL4' => $row->LEVEL4,
                    'TOTAL_VOLUME' => $row->JML_VOLUME,
                    'COUNT' => $row->JML,
                    'AKSI' => $aksi
                );
                $num++;
            // }
        }
        return array('total' => $total, 'rows' => $rows);
    }

    function getTableViewDetail($tanggal=null){
        // $data = $this->db->query("select * from VLOAD_LIST_DETAIL_PEMAKAIAN where DATE_FORMAT(TGL_PENGAKUAN,'%m%Y') = '".$tanggal."'");
        // return $data->result();

        $this->db->from('VLOAD_LIST_DETAIL_PEMAKAIAN_V2');


        if ($_POST['TGL_PENGAKUAN'] !='') {
            $this->db->where("DATE_FORMAT(TGL_PENGAKUAN,'%m%Y')",$_POST['TGL_PENGAKUAN']);
        }
        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("COCODE",$_POST['COCODE']);   
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("PLANT",$_POST['PLANT']);   
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);   
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("SLOC",$_POST['SLOC']);   
        }

        $data = $this->db->get();

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
    
    public function load_option($id = '', $kode = ''){
         $option='';
        switch ($id) {
            case "R":
                $this->db->select("ID_REGIONAL as KODE, NAMA_REGIONAL as NAMA");
                $this->db->from("MASTER_REGIONAL");
                $list = $this->db->get();
                break;
            case "1":
                $this->db->select("COCODE as KODE, LEVEL1 as NAMA");
                $this->db->where("ID_REGIONAL", $kode);
                $this->db->from("MASTER_LEVEL1");
                $list = $this->db->get();
                break;
            case "2":
                $this->db->select("PLANT as KODE, LEVEL2 as NAMA");
                $this->db->where("COCODE", $kode);
                $this->db->from("MASTER_LEVEL2");
                $list = $this->db->get();
                break;
            case "3":
                $this->db->select("STORE_SLOC as KODE, LEVEL3 as NAMA");
                $this->db->where("PLANT", $kode);
                $this->db->from("MASTER_LEVEL3");
                $list = $this->db->get();
                break;
            case "4":
                $c = explode("..", $kode);
                $this->db->select("concat(concat(SLOC,'#'), STORE_SLOC) as KODE, LEVEL4 as NAMA", false);
                if (count($c) > 1){
                    $this->db->where(array("PLANT" => $c[0], "STORE_SLOC" => $c[1]));    
                } else {
                    $this->db->where("STORE_SLOC",$c[0]);
                }
                $this->db->from("MASTER_LEVEL4");
                $list = $this->db->get();
                break;
        }

        foreach ($list->result() as $row) {
            $option[$row->KODE] = $row->NAMA;
        }
        return $option;
        // return $list->result();
    }
    
    public function load_optionJSON($id = '', $kode = ''){
         $option='';
        switch ($id) {
            case "R":
                $this->db->select("ID_REGIONAL as kode, NAMA_REGIONAL as nama");
                $this->db->from("MASTER_REGIONAL");
                $list = $this->db->get();
                break;
            case "1":
                $this->db->select("COCODE as kode, LEVEL1 as nama");
                $this->db->where("ID_REGIONAL", $kode);
                $this->db->from("MASTER_LEVEL1");
                $list = $this->db->get();
                break;
            case "2":
                $this->db->select("PLANT as kode, LEVEL2 as nama");
                $this->db->where("COCODE", $kode);
                $this->db->from("MASTER_LEVEL2");
                $list = $this->db->get();
                break;
            case "3":
                $this->db->select("STORE_SLOC as kode, LEVEL3 as nama");
                $this->db->where("PLANT", $kode);
                $this->db->from("MASTER_LEVEL3");
                $list = $this->db->get();
                break;
            case "4":
                $c = explode("..", $kode);
                $this->db->select("SLOC kode, LEVEL4 as nama", false);
                $this->db->where(array("PLANT" => $c[0], "STORE_SLOC" => $c[1]));
                $this->db->from("MASTER_LEVEL4");
                $list = $this->db->get();
                break;
        }
        
        return $list->result();
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
// print_debug($sql);
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }
}
?>