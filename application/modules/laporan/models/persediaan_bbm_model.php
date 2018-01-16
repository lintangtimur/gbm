<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class persediaan_bbm_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "REKAP_MUTASI_PERSEDIAAN"; //nama table setelah mom_

    public function getData_Model($data)
    {
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];
        $BBM = $data['BBM'];   
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $TGL_DARI = $data['TGL_DARI'];   
        $TGL_SAMPAI = $data['TGL_SAMPAI'];   
        $JENIS_BBM = '';
        $PARAM = '';
        $SETTGL = '';

        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID=='00') {
            $PARAM = "F.ID_REGIONAL != '$PARAM'";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } else {
           $PARAM = "B.SLOC = '$SLOC'";
        }

        if ($BBM == '') {
           $JENIS_BBM = "OR G.ID_JNS_BHN_BKR = '$BBM'";
        } else {
            $JENIS_BBM = "AND G.ID_JNS_BHN_BKR = '$BBM'";
        }

        if ($TGL_DARI== ''){
            $SETTGL = " LIKE '%%'";
        }else{
            $SETTGL = " BETWEEN '$TGL_DARI' AND '$TGL_SAMPAI' ";
        }
        
        $sql = "SELECT F.NAMA_REGIONAL LEVEL0, E.LEVEL1,D.LEVEL2,C.LEVEL3,B.LEVEL4,G.NAMA_JNS_BHN_BKR,
A.TGL_MUTASI_PERSEDIAAN,A.STOCK_AWAL,A.PENERIMAAN_REAL,A.PEMAKAIAN,PK1.PEMAKAIAN_SENDIRI
,PK2.PEMAKAIAN_KIRIM,PN2.TERIMA_PEMASOK,PN1.TERIMA_UNITLAIN,
A.DEAD_STOCK,A.VOLUME_STOCKOPNAME,A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.STOCK_AKHIR_KOREKSI,
ROUND(A.SHO, 2) SHO,A.REVISI_MUTASI_PERSEDIAAN,
CASE WHEN MP.VOLUME_MAX_PAKAI IS NULL
THEN (  SELECT VOLUME_MAX_PAKAI
   FROM MAX_PEMAKAIAN D
 WHERE D.THBL_MAX_PAKAI < DATE_FORMAT (A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
AND D.SLOC = A.SLOC
AND D.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR 
ORDER BY D.THBL_MAX_PAKAI DESC LIMIT 1) ELSE MP.VOLUME_MAX_PAKAI END MAX_PEMAKAIAN
FROM (
SELECT * FROM REKAP_MUTASI_PERSEDIAAN
WHERE IS_AKTIF_MUTASI_PERSEDIAAN='1' AND TGL_MUTASI_PERSEDIAAN $SETTGL)
A 
LEFT OUTER JOIN
(
SELECT SLOC,ID_JNS_BHN_BKR,TGL_PENGAKUAN,SUM(VOL_TERIMA_REAL) TERIMA_UNITLAIN FROM MUTASI_PENERIMAAN
WHERE STATUS_MUTASI_TERIMA IN ('2','6') AND JNS_PENERIMAAN='1' AND TGL_PENGAKUAN $SETTGL GROUP BY SLOC,ID_JNS_BHN_BKR,TGL_PENGAKUAN) PN1 
ON PN1.SLOC = A.SLOC AND PN1.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND PN1.TGL_PENGAKUAN=A.TGL_MUTASI_PERSEDIAAN
LEFT OUTER JOIN
(
SELECT SLOC,ID_JNS_BHN_BKR,TGL_PENGAKUAN,SUM(VOL_TERIMA_REAL) TERIMA_PEMASOK FROM MUTASI_PENERIMAAN
WHERE STATUS_MUTASI_TERIMA IN ('2','6') AND JNS_PENERIMAAN='2' AND TGL_PENGAKUAN $SETTGL GROUP BY SLOC,ID_JNS_BHN_BKR,TGL_PENGAKUAN) PN2
ON PN2.SLOC = A.SLOC AND PN2.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND PN2.TGL_PENGAKUAN=A.TGL_MUTASI_PERSEDIAAN
LEFT OUTER JOIN
(
SELECT SLOC,ID_JNS_BHN_BKR,TGL_MUTASI_PENGAKUAN,SUM(VOLUME_PEMAKAIAN) PEMAKAIAN_SENDIRI FROM MUTASI_PEMAKAIAN
WHERE STATUS_MUTASI_PEMAKAIAN IN ('2','6') AND JENIS_PEMAKAIAN='1' AND TGL_MUTASI_PENGAKUAN $SETTGL GROUP BY SLOC,ID_JNS_BHN_BKR,TGL_MUTASI_PENGAKUAN) PK1
ON PK1.SLOC = A.SLOC AND PK1.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND PK1.TGL_MUTASI_PENGAKUAN=A.TGL_MUTASI_PERSEDIAAN
LEFT OUTER JOIN
(
SELECT SLOC,ID_JNS_BHN_BKR,TGL_MUTASI_PENGAKUAN,SUM(VOLUME_PEMAKAIAN) PEMAKAIAN_KIRIM FROM MUTASI_PEMAKAIAN
WHERE STATUS_MUTASI_PEMAKAIAN IN ('2','6') AND JENIS_PEMAKAIAN='2' AND TGL_MUTASI_PENGAKUAN $SETTGL GROUP BY SLOC,ID_JNS_BHN_BKR,TGL_MUTASI_PENGAKUAN ) PK2
ON PK2.SLOC = A.SLOC AND PK2.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND PK2.TGL_MUTASI_PENGAKUAN=A.TGL_MUTASI_PERSEDIAAN
LEFT OUTER JOIN (
     SELECT SLOC,ID_JNS_BHN_BKR,THBL_MAX_PAKAI,VOLUME_MAX_PAKAI FROM `MAX_PEMAKAIAN`
) MP
ON MP.SLOC = A.SLOC AND MP.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR AND MP.THBL_MAX_PAKAI = DATE_FORMAT(A.TGL_MUTASI_PERSEDIAAN,'%Y%m') - 1
INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
WHERE ($PARAM $JENIS_BBM)  
GROUP BY F.NAMA_REGIONAL, E.LEVEL1,D.LEVEL2,C.LEVEL3,B.LEVEL4,G.NAMA_JNS_BHN_BKR,
A.TGL_MUTASI_PERSEDIAAN,A.STOCK_AWAL,A.PENERIMAAN_REAL,A.PEMAKAIAN,
A.DEAD_STOCK,A.VOLUME_STOCKOPNAME,
A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.STOCK_AKHIR_KOREKSI,A.SHO,A.REVISI_MUTASI_PERSEDIAAN
ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC, LEVEL0 ASC, LEVEL1 ASC, LEVEL2 ASC, LEVEL3 ASC, LEVEL4 ASC, NAMA_JNS_BHN_BKR ASC ";     
        
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
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
        $this->db->close();
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function data_option($key = '') {
            $this->db->from('M_JNS_BHN_BKR');
            
            if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

            $this->db->close();    
            return $this->db;
        }

    public function option_jenisbbm($default = '--Pilih Jenis BBM--') {
            $option = array();
            $list = $this->data_option()->get();
            
            if (!empty($default))
            $option[''] = $default;
            
            foreach ($list->result() as $row) {
                $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
            }

            $this->db->close();
            return $option;
        }

    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['1'] = 'Januari';
        $option['2'] = 'Febuari';
        $option['3'] = 'Maret';
        $option['4'] = 'April';
        $option['5'] = 'Mei';
        $option['6'] = 'Juni';
        $option['7'] = 'Juli';
        $option['8'] = 'Agustus';
        $option['9'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_bulanv2() {
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

        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function options_get_lv($lv = '', $key=''){
        switch ($lv) {
            case "1":
                $this->db->select("ID_REGIONAL AS KODE");
                $this->db->from('MASTER_LEVEL1');
                $this->db->where('COCODE',$key);
                break;
            case "2":
                $this->db->select("COCODE AS KODE");
                $this->db->from('MASTER_LEVEL2');
                $this->db->where('PLANT',$key);
                break;
            case "3":
                $this->db->select("PLANT AS KODE");
                $this->db->from('MASTER_LEVEL3');
                $this->db->where('STORE_SLOC',$key);
                break;
            case "4":
                $this->db->select("STORE_SLOC AS KODE");
                $this->db->from('MASTER_LEVEL4');
                $this->db->where('SLOC',$key);
                break;
        } 

        $query =  $this->db->get()->result();
        $this->db->close();
        return $query;
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
        } 

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */