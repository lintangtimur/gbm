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

    private $_table1 = "VLOAD_LIST_PENERIMAAN_V2"; //nama table setelah mom_
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
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);
        }

        $this->db->group_by('ID_REGIONAL');
        $this->db->group_by('BLTH');
        if ($_POST['COCODE'] !='') {
            $this->db->group_by('COCODE');
        }
        if ($_POST['PLANT'] !='') {
            $this->db->group_by('PLANT');
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->group_by('STORE_SLOC');
        }

        if ($_POST['BULAN'] !='') {
            $this->db->group_by('BL'); 
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->group_by('TH'); 
        }
        // if ($_POST['SLOC'] !='') {
            $this->db->group_by('SLOC');
        // }

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
            $filter["a.LEVEL4 LIKE '%{$kata_kunci}%' OR a.BLTH LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
		$num = 1;
        foreach ($record->result() as $row) {
            // $count = $row->COUNT_VOLUME;
            // if ($count!=0) {
                $id = $row->TANGGAL.'|'.$row->SLOC;;
                $aksi = anchor(null, '<i class="icon-eye-open"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
                $rows[$num] = array(
                    'NO' => $num,
                    'BLTH' => $this->get_blth($row->BL,$row->TH),
                    'LEVEL4' => $row->LEVEL4,
//                    'STATUS' => $row->STATUS_APPROVE,
                    'TOTAL_VOLUME' => number_format($row->SUM_VOLUME,0,',','.'),
                    'COUNT' => $row->COUNT_VOLUME,
                    'AKSI' => $aksi
                );
				$num++;
            // }
        }
        return array('total' => $total, 'rows' => $rows);
    }

    function getTableViewDetail(){

        $this->db->from('VLOAD_LIST_DETAIL_PENERIMAAN_V2');


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
        if ($_POST['SLOC']!='') {
            $this->db->where("SLOC",$_POST['SLOC']);
        }
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);   
        }
        $data = $this->db->get();

        return $data->result();
    }

    function saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$kode_level,$user,$jumlah){
        $query = $this->db->query("call SP_PENERIMAAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$kode_level."','".$user."',".$jumlah.")");
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
        $query = $this->db->query("call LOAD_LEVEL4('".$level_user."','".$kode_level."')");
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

    public function get_blth($bulan, $tahun){
        Switch ($bulan){
            case 1 : $bulan="Januari";
                Break;
            case 2 : $bulan="Februari";
                Break;
            case 3 : $bulan="Maret";
                Break;
            case 4 : $bulan="April";
                Break;
            case 5 : $bulan="Mei";
                Break;
            case 6 : $bulan="Juni";
                Break;
            case 7 : $bulan="Juli";
                Break;
            case 8 : $bulan="Agustus";
                Break;
            case 9 : $bulan="September";
                Break;
            case 10 : $bulan="Oktober";
                Break;
            case 11 : $bulan="November";
                Break;
            case 12 : $bulan="Desember";
                Break;
            }

        $tahun = substr($tahun,2);
        $bulan .= '-'.$tahun;

        return $bulan;
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