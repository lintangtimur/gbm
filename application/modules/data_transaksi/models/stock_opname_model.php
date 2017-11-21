<?php
 /**
 * @module STOCK OPNAME
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class stock_opname_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "STOCK_OPNAME"; 
	private $_datasetting = "DATA_SETTING"; 

    private function _key($key) { 
        if (!is_array($key)) {
            $key = array('ID_STOCKOPNAME' => $key);
        }
        return $key;
    }

    
    public function data($key = '') {
        $this->db->select('A.*, R.ID_REGIONAL, R.NAMA_REGIONAL, M1.COCODE, M1.LEVEL1, M2.PLANT, M2.LEVEL2, M3.STORE_SLOC, M3.LEVEL3, M4.LEVEL4, JB.NAMA_JNS_BHN_BKR,   A.TGL_PENGAKUAN, DS.NAME_SETTING');
        $this->db->from($this->_table1.' A');
        $this->db->join('MASTER_LEVEL4 M4', 'M4.SLOC = A.SLOC','left');
        $this->db->join('MASTER_LEVEL3 M3', 'M3.STORE_SLOC = M4.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 M2', 'M2.PLANT = M3.PLANT','left');
        $this->db->join('MASTER_LEVEL1 M1', 'M1.COCODE = M2.COCODE','left');
        $this->db->join('MASTER_REGIONAL R', 'R.ID_REGIONAL = M1.ID_REGIONAL','left');
        $this->db->join('M_JNS_BHN_BKR JB', 'JB.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR','left');
		$this->db->join($this->_datasetting .' DS', "A.STATUS_APPROVE_STOCKOPNAME = DS.VALUE_SETTING AND DS.KEY_SETTING = 'STATUS_APPROVE'");

        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where("R.ID_REGIONAL",$_POST['ID_REGIONAL']);   
        }
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
            $this->db->where("MONTH(A.TGL_PENGAKUAN)",$_POST['BULAN']);   
        }
        if ($_POST['TAHUN'] !='') {
            $this->db->where("YEAR(A.TGL_PENGAKUAN)",$_POST['TAHUN']);   
        }
        if ($_POST['STATUS'] !='') {
            $this->db->where("STATUS_APPROVE_STOCKOPNAME",$_POST['STATUS']);   
        }

        if (!empty($key) || is_array($key)){
            $this->db->where_condition($this->_key($key));
        }
        
		$this->db->order_by("A.TGL_PENGAKUAN asc");

        return $this->db;
    }

    public function dataToUpdate($key = '') {
        $this->db->select('A.*, R.ID_REGIONAL, R.NAMA_REGIONAL, M1.COCODE, M1.LEVEL1, M2.PLANT, M2.LEVEL2, M3.STORE_SLOC, M3.LEVEL3, M4.LEVEL4, JB.NAMA_JNS_BHN_BKR,   A.TGL_PENGAKUAN');
        $this->db->from($this->_table1.' A');
        $this->db->join('MASTER_LEVEL4 M4', 'M4.SLOC = A.SLOC','left');
        $this->db->join('MASTER_LEVEL3 M3', 'M3.STORE_SLOC = M4.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 M2', 'M2.PLANT = M3.PLANT','left');
        $this->db->join('MASTER_LEVEL1 M1', 'M1.COCODE = M2.COCODE','left');
        $this->db->join('MASTER_REGIONAL R', 'R.ID_REGIONAL = M1.ID_REGIONAL','left');
        $this->db->join('M_JNS_BHN_BKR JB', 'JB.ID_JNS_BHN_BKR = A.ID_JNS_BHN_BKR','left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        
        return $this->db;
    }

    public function callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER){
        $myDate = new DateTime($TGL_PENGAKUAN);
        $TGL_PENGAKUAN = $myDate->format('dmY');

        $query="CALL SP_TEMP_SO('$ID_STOCKOPNAME', '$SLOC', '$ID_JNS_BHN_BKR', '$TGL_PENGAKUAN', '$LEVEL_USER', '$STATUS', '$USER')";
        $data = $this->db->query($query);
        return $data->result();

    }
    // versi query CI
    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_STOCKOPNAME', 'no_prefix', 3);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table1, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

   public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->input->post('kata_kunci');
        $level_user = $this->session->userdata('level_user');

        if (!empty($kata_kunci))
            $filter["(JB.NAMA_JNS_BHN_BKR LIKE '%{$kata_kunci}%' OR A.NO_STOCKOPNAME LIKE '%{$kata_kunci}%' OR A.VOLUME_STOCKOPNAME LIKE '%{$kata_kunci}%')"]= NULL;
            $total = $this->data($filter)->count_all_results();
            $this->db->limit($limit, ($offset * $limit) - $limit);
            $record = $this->data($filter)->get();
            $no=(($offset-1) * $limit) +1;
            $rows = array();
            foreach ($record->result() as $row) {
                $aksi = '';
                $id = $row->ID_STOCKOPNAME;
                $status = $row->STATUS_APPROVE_STOCKOPNAME;
                $CREATED_BY = $row->CD_BY_STOKOPNAME;
                $status_hasil='';

                if($level_user == 2){
                    if ($this->laccess->otoritas('add')){
                        if($CREATED_BY==$this->session->userdata('user_name')){
                            if ($status == 0) {
                                $aksi .= anchor(null, '<i class="icon-share" title="Kirim"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'kirim_row(this.id)', 'data-source' => base_url($module . '/sendAction/' . $id)));
                                $aksi .= anchor(null, '<i class="icon-edit" title="Edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                            }else if(($status==2)||($status==1)||($status == 3) ){
                                $aksi .= anchor(null, '<i class="icon-zoom-in" title="View"></i>', array('class' => 'btn transparant', 'id' => 'button-load-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadView/' . $id)));
                            }
                        }                               
                    } else if($this->laccess->otoritas('approve')){
                        if ($status == 1) {
                            $aksi .= anchor(null, '<i class="icon-zoom-in" title="Approve"></i>', array('class' => 'btn transparant', 'id' => 'button-load-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadApprove/' . $id)));
                        }
                        else if(($status==2) || ($status==3) ){
                            $aksi .= anchor(null, '<i class="icon-zoom-in" title="View"></i>', array('class' => 'btn transparant', 'id' => 'button-load-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadView/' . $id)));
                        } 
                    }
                } 
                else if (($level_user == 3)||($level_user == 4)){
                    if ($this->laccess->otoritas('add')){
                        if($CREATED_BY==$this->session->userdata('user_name')){
                            if ($status == 0) {
                                $aksi .= anchor(null, '<i class="icon-share" title="Kirim"></i>', array('class' => 'btn transparant', 'id' => 'button-kirim-' . $id, 'onclick' => 'kirim_row(this.id)', 'data-source' => base_url($module . '/sendAction/' . $id)));
                                $aksi .= anchor(null, '<i class="icon-edit" title="Edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                            }else if(($status==2)||($status==1) || ($status == 3)){
                                $aksi .= anchor(null, '<i class="icon-zoom-in" title="View"></i>', array('class' => 'btn transparant', 'id' => 'button-load-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadView/' . $id)));
                            }
                        }
                    }
                }

                if($status==0){
                   $status_hasil="Belum Dikirim";
                }else if($status==1){
                  $status_hasil="Belum Disetujui";
                }else if($status==2){
                  $status_hasil="Disetujui";
                }else{
                  $status_hasil="Ditolak";
                }
                
                // $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                $rows[$id] = array(
                    'ID_STOCKOPNAME' => $no++,
                    'NO_STOCKOPNAME' => $row->NO_STOCKOPNAME,
                    'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                    'NAMA_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                    'LEVEL4' => $row->LEVEL4,
                    'VOLUME_STOCKOPNAME' => number_format($row->VOLUME_STOCKOPNAME,0,',','.'),
                    'STATUS_APPROVE_STOCKOPNAME' => $row->NAME_SETTING,
                    'aksi' => $aksi
                );
            }    

        return array('total' => $total, 'rows' => $rows);
    }


    public function data_option($key = '', $id = '') {
		if ($key !== ''){
			$key["b.SLOC"] = $id;
		}
			// $this->db->where("b.SLOC", $id);
		
		$this->db->from('M_JNS_BHN_BKR as a');
        $this->db->join("MASTER_TANGKI as b", "a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR");
		
		if (!empty($key) || is_array($key))
			$this->db->where_condition($this->_key($key));
		
		return $this->db;
	}

    public function options_jns_bhn_bkr($default = '--Pilih Jenis Bahan Bakar--', $id = '') {
    
		  $option = array();
		  $list = $this->data_option('', $id)->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        return $option;    
        
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
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
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
        $this->db->where('IS_AKTIF_LVL2','1');
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
        $this->db->where('IS_AKTIF_LVL3','1');
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
        $this->db->where('IS_AKTIF_LVL4','1');
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
    // public function options_bhn_bkr($default = '--Pilih Jenis Bahan Bakar--', $key = 'all', $jenis=0) {
    //     $this->db->select('a.ID_JNS_BHN_BKR, b.NAMA_JNS_BHN_BKR');
    //     $this->db->from('MASTER_TANGKI a');
    //     $this->db->join('M_JNS_BHN_BKR b', 'a.ID_JNS_BHN_BKR = b.ID_JNS_BHN_BKR ','left');
    //     if ($key != 'all'){
    //         $this->db->where('a.SLOC',$key);
    //     }    
    //     if ($jenis==0){
    //         return $this->db->get()->result(); 
    //     } else {
    //         $option = array();
    //         $list = $this->db->get(); 

    //         if (!empty($default)) {
    //             $option[''] = $default;
    //         }

    //         foreach ($list->result() as $row) {
    //             $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
    //         }
    //         return $option;    
    //     }
    // }    
    
// jangan dihapus dulu untuk jaga jaga
    public function options_jns_bhn_bkr_main($default = '--Pilih Jenis Bahan Bakar--') {
        
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

    public function options_lv1_view($default = '--Pilih Level 1--') {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
    
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

    public function options_lv2_view($default = '--Pilih Level 2--') {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
    
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

    public function options_lv3_view($default = '--Pilih Level 3--') {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
    
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

    public function options_lv4_view($default = '--Pilih Pembangkit--') {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
    
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
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function get_level($lv='', $key=''){ 
        switch ($lv) {
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
        $filter='WHERE 1=1 ';
        if ($_POST['ID_REGIONAL'] !='') {
            $filter.=" AND R.ID_REGIONAL='".$_POST['ID_REGIONAL']."' ";   
        }
        if ($_POST['COCODE'] !='') {
            $filter.=" AND M1.COCODE='".$_POST['COCODE']."' ";     
        }
        if ($_POST['PLANT'] !='') {
            $filter.=" AND M2.PLANT='".$_POST['PLANT']."' ";    
        }
        if ($_POST['STORE_SLOC'] !='') {
            $filter.=" AND M3.STORE_SLOC='".$_POST['STORE_SLOC']."' ";      
        }
        if ($_POST['SLOC'] !='') {
            $filter.=" AND M4.SLOC='".$_POST['SLOC']."' ";      
        }
        if ($_POST['BBM'] !='') {
            $filter.=" AND A.ID_JNS_BHN_BKR='".$_POST['BBM']."' ";     
        }
        if ($_POST['BULAN'] !='') {
            $filter.=" AND MONTH(A.TGL_PENGAKUAN)='".$_POST['BULAN']."' ";     
        }
        if ($_POST['TAHUN'] !='') {
            $filter.=" AND YEAR(A.TGL_PENGAKUAN)='".$_POST['TAHUN']."' ";     
        }
        if ($_POST['STATUS'] !='') {
            $filter.=" AND A.STATUS_APPROVE_STOCKOPNAME='".$_POST['STATUS']."' ";    
        }

        $q="SELECT 
        COALESCE(SUM( IF( A.STATUS_APPROVE_STOCKOPNAME = '0', 1, 0 ) ),0) AS BELUM_KIRIM,  
        COALESCE(SUM( IF( A.STATUS_APPROVE_STOCKOPNAME = '1', 1, 0 ) ),0) AS BELUM_DISETUJUI, 
        COALESCE(SUM( IF( A.STATUS_APPROVE_STOCKOPNAME = '2', 1, 0 ) ),0) AS DISETUJUI,
        COALESCE(SUM( IF( A.STATUS_APPROVE_STOCKOPNAME = '3', 1, 0 ) ),0) AS DITOLAK,
        COUNT(*) AS TOTAL 
        FROM  STOCK_OPNAME A
        LEFT JOIN MASTER_LEVEL4 M4 ON M4.SLOC=A.SLOC
        LEFT JOIN MASTER_LEVEL3 M3 ON M3.STORE_SLOC=M4.STORE_SLOC
        LEFT JOIN MASTER_LEVEL2 M2 ON M2.PLANT=M3.PLANT
        LEFT JOIN MASTER_LEVEL1 M1 ON M1.COCODE=M2.COCODE
        LEFT JOIN MASTER_REGIONAL R ON R.ID_REGIONAL=M1.ID_REGIONAL $filter ";  

        $query = $this->db->query($q);

        return $query->result();       
    }

}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */