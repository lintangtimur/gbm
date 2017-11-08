<?php

 /**
* @module KURS
* @author  RAKHMAT WIJAYANTO
* @created at 07 NOVEMBER 2017
* @modified at 07 OKTOBER 2017
*/ 
class kurs_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "KURS"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_KURS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }



    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->input->post('kata_kunci');

        if (!empty($kata_kunci))
            $filter[$this->_table1 . ".NOMINAL LIKE '%{$kata_kunci}%' or JUAL LIKE '%{$kata_kunci}%' or KTBI LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_KURS;
            $rows[$id] = array(
                'ID_KURS' => $no++,
                'TGL_KURS' => $row->TGL_KURS,
                'NOMINAL' => $row->NOMINAL,
                'JUAL' => $row->JUAL,
                'KTBI' => $row->KTBI
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }
	 

}

?>