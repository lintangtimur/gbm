<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class peta_jalur_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DUMMY_GRAFIK"; //nama table setelah mom_

    public function report(){
        $query = $this->db->query("SELECT DATE_FORMAT(a.tanggal,'%m') bulan,DATE_FORMAT(a.tanggal,'%M %Y') blth,DATE_FORMAT(a.tanggal,'%Y%m') blth2, ROUND(AVG(a.Harga),2) avgHargaKurs, ROUND(AVG(a.hsdnoppn),2) avgHargaHsd, ROUND(AVG(a.mfonoppn),2) avgHargaMfo, ROUND(AVG(a.rmopshsd),2) avgHargaMops, DATE_FORMAT(a.tanggal,'%Y') tahun FROM DUMMY_GRAFIK a WHERE DATE_FORMAT(a.tanggal,'%Y')= YEAR(NOW()) GROUP BY a.blth;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    } 

    public function getVolMfo(){
       $query = $this->db->query("SELECT SUM(A.STOCK_AKHIR_REAL) AS 'STOK' , B.NAMA_JNS_BHN_BKR FROM REKAP_MUTASI_PERSEDIAAN A
       LEFT OUTER JOIN M_JNS_BHN_BKR B ON A.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR
       WHERE B.NAMA_JNS_BHN_BKR = 'MFO'
       GROUP BY A.ID_JNS_BHN_BKR ORDER BY A.ID_JNS_BHN_BKR ;");
        
       if($query->num_rows() > 0){
           foreach($query->result() as $data){
               $hasil[] = $data;
           }
           return $hasil;
       }
    }

    public function getVolHsd(){
        $query = $this->db->query("SELECT SUM(A.STOCK_AKHIR_REAL) AS 'STOK' , B.NAMA_JNS_BHN_BKR FROM REKAP_MUTASI_PERSEDIAAN A
        LEFT OUTER JOIN M_JNS_BHN_BKR B ON A.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR
        WHERE B.NAMA_JNS_BHN_BKR = 'HSD'
        GROUP BY A.ID_JNS_BHN_BKR ORDER BY A.ID_JNS_BHN_BKR ;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
     }

     public function getVolBio(){
        $query = $this->db->query("SELECT SUM(A.STOCK_AKHIR_REAL) AS 'STOK' , B.NAMA_JNS_BHN_BKR FROM REKAP_MUTASI_PERSEDIAAN A
        LEFT OUTER JOIN M_JNS_BHN_BKR B ON A.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR
        WHERE B.NAMA_JNS_BHN_BKR = 'BIO'
        GROUP BY A.ID_JNS_BHN_BKR ORDER BY A.ID_JNS_BHN_BKR ;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
     }
     public function getVolHsdBio(){
        $query = $this->db->query("SELECT SUM(A.STOCK_AKHIR_REAL) AS 'STOK' , B.NAMA_JNS_BHN_BKR FROM REKAP_MUTASI_PERSEDIAAN A
        LEFT OUTER JOIN M_JNS_BHN_BKR B ON A.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR
        WHERE B.NAMA_JNS_BHN_BKR = 'HSD+BIO'
        GROUP BY A.ID_JNS_BHN_BKR ORDER BY A.ID_JNS_BHN_BKR ;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
     }

    public function options_tahun($default = '--Pilih Tahun--') {
        $option = array();
        $list=$this->db->query("SELECT DISTINCT(YEAR(a.tanggal)) tahun FROM DUMMY_GRAFIK a ;");
        
        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->tahun] = $row->tahun;
        }
        return $option;    
        
    }  

    public function get_peta() {
        $q="SELECT A.ID_DEPO, A.NAMA_DEPO, A.LAT_DEPO, A.LOT_DEPO, 
            M4.LEVEL4, M4.LAT_LVL4, M4.LOT_LVL4
            FROM MASTER_DEPO A
            INNER JOIN DET_KONTRAK_TRANS B ON B.ID_DEPO=A.ID_DEPO
            INNER JOIN MASTER_LEVEL4 M4 ON M4.SLOC=B.SLOC
            GROUP BY A.ID_DEPO, M4.SLOC";

        $query = $this->db->query($q);

        return $query->result();       
    }
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */