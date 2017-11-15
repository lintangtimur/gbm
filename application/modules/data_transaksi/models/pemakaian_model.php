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

    // private $_table1 = "VLOAD_LIST_PEMAKAIAN_V2"; //nama table setelah mom_
    private $_table2 = "MUTASI_PEMAKAIAN"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_PEMAKAIAN' => $key);
        }
        return $key;
    }

    private function data($key = ''){
        $this->db->select('a.*, sum(a.COUNT_VOLUME) as JML, sum(a.SUM_volume) as JML_VOLUME');

        // $this->db->from($this->_table1.' a' );
        if ($this->laccess->otoritas('add')){
            $this->db->from('VLOAD_LIST_PEMAKAIAN_LV3 a' );
        } else {
            $this->db->from('VLOAD_LIST_PEMAKAIAN_LV2 a' );
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
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);   
        }

        if (!empty($key) || is_array($key)){
            $this->db->where_condition($this->_key($key));
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

        $this->db->order_by($_POST['ORDER_BY'].' '.$_POST['ORDER_ASC']);

        return $this->db;
    }

    public function data_detail($key = ''){
        $this->db->select('a.*, b.STORE_SLOC, c.PLANT, d.COCODE, e.ID_REGIONAL');
        $this->db->from($this->_table2.' a');
        $this->db->join('MASTER_LEVEL4 f', 'f.SLOC = a.SLOC','left');
        $this->db->join('MASTER_LEVEL3 b', 'b.STORE_SLOC = f.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 c', 'c.PLANT = b.PLANT','left');
        $this->db->join('MASTER_LEVEL1 d', 'd.COCODE = c.COCODE','left');
        $this->db->join('MASTER_REGIONAL e', 'e.ID_REGIONAL = d.ID_REGIONAL','left');


        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->input->post('kata_kunci');

        if (!empty($kata_kunci))
            $filter["(a.LEVEL4 LIKE '%{$kata_kunci}%' OR a.BLTH LIKE '%{$kata_kunci}%' )"] = NULL;
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        $num = 1;
        foreach ($record->result() as $row) {
            // $count = $row->COUNT_VOLUME;
            // if ($count!=0) {
                $id = $row->TANGGAL.'|'.$row->SLOC.'|'.$num;
                $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Detail Data"></i>', array('class' => 'btn transparant button-detail', 'id' => 'button-view-' . $id, 'onClick' => 'show_detail(\''.$id.'\')'));
                $rows[$num] = array(
                    'NO' => $num,
                    'BLTH' =>  $this->get_blth($row->BL,$row->TH),
                    'LEVEL4' => $row->LEVEL4,
                    'TOTAL_VOLUME' => number_format($row->JML_VOLUME,0,',','.'),
                    'COUNT' => number_format($row->JML,0,',','.'),
                    'AKSI' => $aksi
                );
                $num++;
            // }
        }
        return array('total' => $total, 'rows' => $rows);
    }

    function getTableViewDetail($tanggal=null){
        $this->db->query("call PROC_EDIT_STATUS('".$this->input->post('TGL_PENGAKUAN')."', '3')");

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
        if ($_POST['BULAN'] !='') {
            $this->db->where("BL",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("TH",$_POST['TAHUN']);   
        }
        if ($_POST['STATUS'] !='') {
            $this->db->where("KODE_STATUS",$_POST['STATUS']);   
        }

        if (!$this->laccess->otoritas('add')){
            $this->db->where('STATUS_PEMAKAIAN !=','Belum Dikirim');    
        }
		
        if ($_POST['KATA_KUNCI_DETAIL'] !=''){

            $filter="NO_TUG LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' OR NAMA_JNS_BHN_BKR LIKE '%".$_POST['KATA_KUNCI_DETAIL']."%' ";

            $this->db->where("(".$filter.")", NULL, FALSE);
        }
        
        $this->db->order_by($_POST['ORDER_BY_D'].' '.$_POST['ORDER_ASC_D']);
		
        $data = $this->db->get();

        return $data->result();
    }

    function saveDetailPenerimaan($idPenerimaan, $statusPenerimaan,$level_user,$user,$jumlah){
		// $id = explode("#", $idPenerimaan);
		// for($i = 0; $i <= $jumlah - 1; $i++){
			// $query = "call SP_TEMP_PEMAKAIAN('".$id[$i]."','".$statusPenerimaan."','".$level_user."','".$user."',".$i.")";
			// $data = $this->db->query($query);
			// // $this->db->reconnect();
		// }
		// $this->db->reconnect();
		// print_debug("call SP_TEMP_PEMAKAIAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$user."',".$jumlah.")");
		$query = "call PROSES_PEMAKAIAN('".$idPenerimaan."','".$statusPenerimaan."','".$level_user."','".$user."',".$jumlah.")";
		
		$data = $this->db->query($query);
		 $res = $data->result();

       $data->next_result(); // Dump the extra resultset.
       $data->free_result(); // Does what it says.

        // return $data->result();
		 return $res;
    }

    function saveDetailClossing($sloc,$idPenerimaan,$level_user,$statusPenerimaan,$kode_level,$user_name,$jumlah){
        $query = $this->db->query("call SP_TEMP_CLOSSING('".$sloc."','".$idPenerimaan."','".$level_user."','".$statusPenerimaan."','".$kode_level."','".$user_name."',".$jumlah.")");
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

    public function options_jenis_pemakaian($default = '--Pilih Jenis Pemakaian--') {
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
            .$data['KETERANGAN']."','0','".
			 $data['CREATE_BY']."','"
            .$data['NO_PEMAKAIAN']."','"
            .$data['ID_JNS_BHN_BKR']."','"
            .$data['NO_TUG']."')";
// print_debug($sql);
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

    public function update($data){
        $sql = "CALL EDIT_PEMAKAIAN ('"
            .$data['ID_PEMAKAIAN']."','"
            .$data['ID_JNS_BHN_BKR']."','"
            .$data['SLOC']."','"
            .$data['TGL_CATAT']."','"
            .$data['TGL_PENGAKUAN']."','"
            .$data['VOL_PEMAKAIAN']."','"
            .$data['UD_BY_MUTASI_PEMAKAIAN']."','"
            .$data['NO_PEMAKAIAN']."','"
            .$data['VALUE_SETTING']."','"
            .$data['KETERANGAN']."','"
            .$data['NO_TUG']."')";
//print_debug($sql);
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
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

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
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
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            return $option;    
        }
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
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
                $option[$row->SLOC] = $row->LEVEL4;
            }
            return $option;    
        }
    }

    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['01'] = 'Januari';
        $option['02'] = 'Febuari';
        $option['03'] = 'Maret';
        $option['04'] = 'April';
        $option['05'] = 'Mei';
        $option['06'] = 'Juni';
        $option['07'] = 'Juli';
        $option['08'] = 'Agustus';
        $option['09'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_tahun() {
        $year = date("Y"); 

        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function options_order() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['BLTH'] = 'BLTH';
        $option['LEVEL4'] = 'PEMBANGKIT';
        // $option['JML'] = 'JML';
        // $option['JML_VOLUME'] = 'JML_VOLUME';
        return $option;
    }

    public function options_order_d() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['TGL_PENGAKUAN'] = 'TGL PENGAKUAN';
        $option['NO_TUG'] = 'NO TUG';
        $option['NAMA_JNS_BHN_BKR'] = 'JNS BHN BKR';
        return $option;
    }

    public function options_asc() {
        $option = array();
        // $option[''] = '--Pilih--';
        $option['ASC'] = 'ASC';
        $option['DESC'] = 'DESC';
        return $option;
    }

    public function get_level($lv='', $key=''){ 
        switch ($lv) {
            case "R":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "0":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "1":
                $q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_LEVEL1 D 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE COCODE='$key' ";
                break;
            case "2":
                $q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL2 C 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE PLANT='$key' ";
                break;
            case "3":
                $q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL3 B
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE STORE_SLOC='$key' ";
                break;
            case "4":
                $q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL4 A
                LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE SLOC='$key' ";
                break;
            case "5":
                $q = "SELECT a.LEVEL3, a.STORE_SLOC
                FROM MASTER_LEVEL3 a
                INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
                INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
                WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' ";
                break;
        } 

        $query = $this->db->query($q)->result();
        return $query;
    }

    public function options_status() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_APPROVE');
        $this->db->order_by("VALUE_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '-- Semua --';

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        return $option;    
    }

    public function get_sum_detail() {
        $SLOC = $_POST['SLOC'];
        $TGL_PENGAKUAN = $_POST['TGL_PENGAKUAN'];

        $q="SELECT 
            SLOC, date_format(TGL_MUTASI_PENGAKUAN,'%m%Y') AS TGL_PENGAKUAN, 
            sum( if( STATUS_MUTASI_PEMAKAIAN = '0', 1, 0 ) ) AS BELUM_KIRIM,  
            sum( if( STATUS_MUTASI_PEMAKAIAN = '1', 1, 0 ) ) AS BELUM_DISETUJUI, 
            sum( if( STATUS_MUTASI_PEMAKAIAN = '2', 1, 0 ) ) AS DISETUJUI,
            sum( if( STATUS_MUTASI_PEMAKAIAN = '3', 1, 0 ) ) AS DITOLAK,
            count(*) AS TOTAL 
            FROM  MUTASI_PEMAKAIAN
            WHERE SLOC='$SLOC' AND date_format(TGL_MUTASI_PENGAKUAN,'%m%Y') = '$TGL_PENGAKUAN'     
            GROUP BY SLOC, TGL_PENGAKUAN ";

        $query = $this->db->query($q);

        return $query->result();       
    }

}
?>