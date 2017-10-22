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

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_MUTASI_PERSEDIAAN' => $key);
        }
        return $key;
    }

     public function data($key = '') {
        // $kolom = 'A.ID_MUTASI_PERSEDIAAN, M1.LEVEL1, M2.LEVEL2, M3.LEVEL3, M4.LEVEL4, JB.NAMA_JNS_BHN_BKR, A.TGL_MUTASI_PERSEDIAAN, A.STOCK_AWAL, A.PENERIMAAN_REAL, A.PEMAKAIAN, PM.VOLUME_PEMAKAIAN, A.DEAD_STOCK, SO.VOLUME_STOCKOPNAME, A.STOCK_AKHIR_REAL, A.STOCK_AKHIR_EFEKTIF, A.STOCK_AKHIR_KOREKSI, A.SHO, A.REVISI_MUTASI_PERSEDIAAN';

        $kolom_sum = 'A.ID_MUTASI_PERSEDIAAN, M1.LEVEL1, M2.LEVEL2, M3.LEVEL3, M4.LEVEL4, JB.NAMA_JNS_BHN_BKR,
        A.TGL_MUTASI_PERSEDIAAN, SUM(A.STOCK_AWAL) STOCK_AWAL, SUM(A.PENERIMAAN_REAL) PENERIMAAN_REAL, SUM(A.PEMAKAIAN) PEMAKAIAN, SUM(PM.VOLUME_PEMAKAIAN) VOLUME_PEMAKAIAN, SUM(A.DEAD_STOCK) DEAD_STOCK, SUM(SO.VOLUME_STOCKOPNAME) VOLUME_STOCKOPNAME, SUM(A.STOCK_AKHIR_REAL) STOCK_AKHIR_REAL, SUM(A.STOCK_AKHIR_EFEKTIF) STOCK_AKHIR_EFEKTIF,
        SUM(A.STOCK_AKHIR_KOREKSI) STOCK_AKHIR_KOREKSI, SUM(A.SHO) SHO, SUM(A.REVISI_MUTASI_PERSEDIAAN) REVISI_MUTASI_PERSEDIAAN';
        $this->db->select($kolom_sum);
        $this->db->from($this->_table1.' A');
        $this->db->join('DETIL_PERSEDIAAN B', 'B.ID_MUTASI_PERSEDIAAN = A.ID_MUTASI_PERSEDIAAN','left');
        $this->db->join('MASTER_LEVEL4 M4', 'M4.SLOC = B.SLOC','left');
        $this->db->join('MASTER_LEVEL3 M3', 'M3.STORE_SLOC = M4.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 M2', 'M2.PLANT = M3.PLANT','left');
        $this->db->join('MASTER_LEVEL1 M1', 'M1.COCODE = M2.COCODE','left');
        $this->db->join('M_JNS_BHN_BKR JB', 'JB.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR','left');
        $this->db->join('MUTASI_PEMAKAIAN PM', 'PM.ID_PEMAKAIAN = B.ID_PEMAKAIAN','left');
        $this->db->join('STOCK_OPNAME SO', 'SO.ID_STOCKOPNAME = B.ID_STOCKOPNAME','left');

        if ($_POST['COCODE'] !='') {
            $this->db->where("M1.COCODE",$_POST['COCODE']);   
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("M2.PLANT",$_POST['PLANT']);   
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("M3.STORE_SLOC",$_POST['STORE_SLOC']);   
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("M4.SLOC",$_POST['SLOC']);   
        }
        if ($_POST['BBM'] !='') {
            $this->db->where("JB.ID_JNS_BHN_BKR",$_POST['BBM']);   
        }
        if ($_POST['BULAN'] !='') {
            $this->db->where("MONTH(A.TGL_MUTASI_PERSEDIAAN)",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("YEAR(A.TGL_MUTASI_PERSEDIAAN)",$_POST['TAHUN']);   
        }

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        if ($_POST['COCODE'] !='') {
            $this->db->group_by('M1.LEVEL1');  
        }
        if ($_POST['PLANT'] !='') {
            $this->db->group_by('M2.LEVEL2');   
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->group_by('M3.LEVEL3');   
        }
        if ($_POST['SLOC'] !='') {
            $this->db->group_by('M4.LEVEL4');     
        }
        // if ($_POST['BBM'] !='') {
        //     $this->db->group_by('JB.NAMA_JNS_BHN_BKR');     
        // }
        $this->db->group_by('JB.NAMA_JNS_BHN_BKR'); 

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
            $filter = array();
            $kata_kunci = $this->input->post('kata_kunci');
            
            $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_MUTASI_PERSEDIAAN;
            $rows[$id] = array(
                'NO' => $no++,
                'LEVEL1' => $row->LEVEL1,
                'AREA' => $row->LEVEL2,
                'RAYON' => $row->LEVEL3,
                'PEMBANGKIT' => $row->LEVEL4,
                'BBM' => $row->NAMA_JNS_BHN_BKR,
                'TGL_MUTASI' => $row->TGL_MUTASI_PERSEDIAAN,
                'STOCK_AWAL' => $row->STOCK_AWAL,
                'PENERIMAAN_REAL' => $row->PENERIMAAN_REAL,
                'PEMAKAIAN' => $row->PEMAKAIAN,
                'VOLUME_PEM' => $row->VOLUME_PEMAKAIAN,
                'DEAD_STOCK' => $row->DEAD_STOCK,
                'VOLUME_STOCKOPNAME' => $row->VOLUME_STOCKOPNAME,
                'STOCK_REAL' => $row->STOCK_AKHIR_REAL,
                'STOCK_EFEKTIF' => $row->STOCK_AKHIR_EFEKTIF,
                'STOCK_KOREKSI' => $row->STOCK_AKHIR_KOREKSI,
                'SHO' => $row->SHO,
                'REV' => $row->REVISI_MUTASI_PERSEDIAAN,
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_LEVEL1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }   
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }
            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;    
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

public function options_tahun() {
        $year = date("Y"); 

        $option = array();
        $option[$year-1] = $year-1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */