<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class grafik_model extends CI_Model {

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
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */