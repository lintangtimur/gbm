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
        $JENIS_BBM = '';
        $PARAM = '';

        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
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
        
         $sql = "SELECT F.NAMA_REGIONAL AS LEVEL0, E.LEVEL1, D.LEVEL2, C.LEVEL3, B.LEVEL4, G.NAMA_JNS_BHN_BKR, 
                DATE_FORMAT(a.`TGL_MUTASI_PERSEDIAAN`, '%d-%m-%Y') AS TGL_MUTASI_PERSEDIAAN,
                a.`STOCK_AWAL`, a.`PENERIMAAN_REAL`, a.`PEMAKAIAN`, 
                pemakaian_sendiri(a.SLOC, a.ID_JNS_BHN_BKR,DATE_FORMAT(a.`TGL_MUTASI_PERSEDIAAN`, '%d-%m-%Y')) AS PEMAKAIAN_SENDIRI, 
                pemakaian_unitlain(a.SLOC, a.ID_JNS_BHN_BKR,DATE_FORMAT(a.`TGL_MUTASI_PERSEDIAAN`, '%d-%m-%Y')) AS PEMAKAIAN_KIRIM, 
                a.`DEAD_STOCK`, a.`VOLUME_STOCKOPNAME`,
                a.`STOCK_AKHIR_REAL`, a.`STOCK_AKHIR_EFEKTIF`, a.`SHO`, `REVISI_MUTASI_PERSEDIAAN`
                FROM `REKAP_MUTASI_PERSEDIAAN` a
                INNER JOIN MASTER_LEVEL4 B ON a.SLOC = B.SLOC
                INNER JOIN MASTER_LEVEL3 C ON B.STORE_SLOC = C.STORE_SLOC AND B.PLANT = C.PLANT
                INNER JOIN MASTER_LEVEL2 D ON C.PLANT = D.PLANT
                INNER JOIN MASTER_LEVEL1 E ON D.COCODE = E.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL = E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON a.ID_JNS_BHN_BKR = G.ID_JNS_BHN_BKR
                WHERE ($PARAM $JENIS_BBM) AND MONTH(a.TGL_MUTASI_PERSEDIAAN) = '$BULAN' AND  YEAR(a.TGL_MUTASI_PERSEDIAAN) = '$TAHUN' ORDER BY a.TGL_MUTASI_PERSEDIAAN DESC ";
        

        // $sql = "SELECT F.NAMA_REGIONAL LEVEL0, E.LEVEL1,D.LEVEL2,C.LEVEL3,B.LEVEL4,A.SLOC,G.NAMA_JNS_BHN_BKR,A.TGL_MUTASI_PERSEDIAAN,
        //         A.AWAL STOCK_AWAL,A.PENERIMAAN_REAL,A.PEMAKAIAN,A.PEMAKAIAN_SENDIRI,A.PEMAKAIAN_KIRIM,
        //         A.DEAD_STOCK,A.VOLUME_STOCKOPNAME,
        //         CASE WHEN A.VOLUME_STOCKOPNAME IS NOT NULL THEN A.VOLUME_STOCKOPNAME ELSE 
        //         ((IFNULL(A.AWAL,0)+IFNULL(A.PENERIMAAN_REAL,0)) - IFNULL(A.PEMAKAIAN,0)) END STOCK_AKHIR_REAL,
        //         CASE WHEN A.VOLUME_STOCKOPNAME IS NOT NULL THEN A.VOLUME_STOCKOPNAME ELSE 
        //         ((IFNULL(A.AWAL,0)+IFNULL(A.PENERIMAAN_REAL,0)) - IFNULL(A.PEMAKAIAN,0) - IFNULL(A.DEAD_STOCK,0) ) END STOCK_AKHIR_EFEKTIF,
        //         A.STOCK_AKHIR_KOREKSI,
        //         ROUND(
        //         CASE WHEN A.VOLUME_STOCKOPNAME IS NOT NULL THEN A.VOLUME_STOCKOPNAME ELSE 
        //         ((IFNULL(A.AWAL,0)+IFNULL(A.PENERIMAAN_REAL,0)) - IFNULL(A.PEMAKAIAN,0) - IFNULL(A.DEAD_STOCK,0)) END /
        //         A.AVG_PAKAI,2) SHO,
        //         A.REVISI_MUTASI_PERSEDIAAN
        //         FROM (
        //         SELECT
        //         CASE WHEN (SELECT volume_stockopname FROM REKAP_MUTASI_PERSEDIAAN b 
        //         WHERE b.sloc=a.sloc AND b.`TGL_MUTASI_PERSEDIAAN`<a.`TGL_MUTASI_PERSEDIAAN` AND a.id_jns_bhn_bkr=b.`ID_JNS_BHN_BKR`
        //         ORDER BY TGL_MUTASI_PERSEDIAAN DESC LIMIT 1) <>'0' THEN
        //         (SELECT volume_stockopname FROM REKAP_MUTASI_PERSEDIAAN b 
        //         WHERE b.sloc=a.sloc AND b.`TGL_MUTASI_PERSEDIAAN`<a.`TGL_MUTASI_PERSEDIAAN` AND a.id_jns_bhn_bkr=b.`ID_JNS_BHN_BKR`
        //         ORDER BY TGL_MUTASI_PERSEDIAAN DESC LIMIT 1)
        //         ELSE 
        //         (SELECT IFNULL(penerimaan_real,0) FROM REKAP_MUTASI_PERSEDIAAN b 
        //         WHERE b.sloc=a.sloc AND b.`TGL_MUTASI_PERSEDIAAN`<a.`TGL_MUTASI_PERSEDIAAN` AND a.id_jns_bhn_bkr=b.`ID_JNS_BHN_BKR`
        //         ORDER BY TGL_MUTASI_PERSEDIAAN DESC LIMIT 1) -
        //         (SELECT IFNULL(pemakaian,0) FROM REKAP_MUTASI_PERSEDIAAN b 
        //         WHERE b.sloc=a.sloc AND b.`TGL_MUTASI_PERSEDIAAN`<a.`TGL_MUTASI_PERSEDIAAN` AND a.id_jns_bhn_bkr=b.`ID_JNS_BHN_BKR`
        //         ORDER BY TGL_MUTASI_PERSEDIAAN DESC LIMIT 1) END awal,
        //         a.sloc,a.id_jns_bhn_bkr,a.tgl_mutasi_persediaan,a.penerimaan_real,a.pemakaian,a.volume_stockopname,
        //         IF(PM.JENIS_PEMAKAIAN='2', PM.VOLUME_PEMAKAIAN, '0') PEMAKAIAN_SENDIRI, 
        //         IF(PM.JENIS_PEMAKAIAN='1', PM.VOLUME_PEMAKAIAN, '0') PEMAKAIAN_KIRIM,
        //         IFNULL(TG.DEADSTOCK_TANGKI,0) DEAD_STOCK,a.STOCK_AKHIR_KOREKSI,a.REVISI_MUTASI_PERSEDIAAN,
        //         (SELECT VALUE_SETTING FROM `DATA_SETTING` WHERE KEY_SETTING='AVG_PAKAI_SENDIRI') AVG_PAKAI
        //         FROM `REKAP_MUTASI_PERSEDIAAN` a
        //         LEFT JOIN MUTASI_PEMAKAIAN PM ON PM.SLOC = a.SLOC AND PM.ID_JNS_BHN_BKR=a.ID_JNS_BHN_BKR AND PM.TGL_MUTASI_PENGAKUAN=a.TGL_MUTASI_PERSEDIAAN
        //         LEFT JOIN `MASTER_TANGKI` TG ON TG.SLOC = a.SLOC AND TG.ID_JNS_BHN_BKR=a.ID_JNS_BHN_BKR
        //         /*WHERE YEAR(a.TGL_MUTASI_PERSEDIAAN)='2017'   
        //         AND a.SLOC='9101' /AND a.id_jns_bhn_bkr='005'*/
        //         ORDER BY a.sloc,a.id_jns_bhn_bkr,a.tgl_mutasi_persediaan
        //         ) A
        //         LEFT JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
        //         LEFT JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
        //         LEFT JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
        //         LEFT JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
        //         LEFT JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
        //         LEFT JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR
        //         WHERE ($PARAM $JENIS_BBM) AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '$BULAN' AND  YEAR(A.TGL_MUTASI_PERSEDIAAN) = '$TAHUN' ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC ";

         $query = $this->db->query($sql);

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

    public function options_lv4($default = '--Pilih Level 4--', $key = 'all', $jenis=0) {
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

    public function data_option($key = '') {
            $this->db->from('M_JNS_BHN_BKR');
            
            if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
            
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

        return $this->db->get()->result();
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
        return $query;
    }
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */