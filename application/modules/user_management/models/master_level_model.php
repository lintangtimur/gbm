<?php

/**
 * @module Master Level Model
 */
class master_level_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	private $_tabler = "MASTER_REGIONAL";
    private $_table1 = "MASTER_LEVEL1";
    private $_table2 = "MASTER_LEVEL2";
    private $_table3 = "MASTER_LEVEL3";
    private $_table4 = "MASTER_LEVEL4";
	
	public function load_option($id = '', $kode = ''){
		 $option='';
        switch ($id) {
			case "R":
				$this->db->select("ID_REGIONAL as kode, NAMA_REGIONAL as nama");
				$this->db->from($this->_tabler);
				$list = $this->db->get();
				break;
			case "1":
				$this->db->select("COCODE as kode, LEVEL1 as nama");
				$this->db->where("ID_REGIONAL", $kode);
				$this->db->from($this->_table1);
				$list = $this->db->get();
				break;
			case "2":
				$this->db->select("PLANT as kode, LEVEL2 as nama");
				$this->db->where("COCODE", $kode);
				$this->db->from($this->_table2);
				$list = $this->db->get();
				break;
			case "3":
				$this->db->select("STORE_SLOC as kode, LEVEL3 as nama");
				$this->db->where("PLANT", $kode);
				$this->db->from($this->_table3);
				$list = $this->db->get();
				break;
			case "4":
				$c = explode("..", $kode);
				$this->db->select("concat(concat(STORE_SLOC,'..'), SLOC) as kode, LEVEL4 as nama", false);
				$this->db->where(array("PLANT" => $c[0], "STORE_SLOC" => $c[1]));
				$this->db->from($this->_table4);
				$list = $this->db->get();
				break;
		}
     
        return $list->result();
    }
	
	public function load_regional(){
		$this->db->select("ID_REGIONAL as kode, NAMA_REGIONAL as nama");
		$this->db->from($this->_tabler);
		$list = $this->db->get();
		return $list->result();
	}
	
	public function load_level1($idlevel1 = ''){
		$idregional = '';
		$this->db->select("COCODE as kode, LEVEL1 as nama, ID_REGIONAL");
		$this->db->from($this->_table1);
		$list = $this->db->get()->result();
		foreach ($list as $row) {
			if($row->kode == $idlevel1){
				$idregional = $row->ID_REGIONAL;
			}
		}
		$data["idregional"] = $idregional;
		$data["list"] = $list;
		return $data;
	}
	
	public function load_level2($idlevel2 = ''){
		$idlevel1 = '';
		$this->db->select("PLANT as kode, LEVEL2 as nama, COCODE", false);
		$this->db->from($this->_table2);
		$list = $this->db->get()->result();
		foreach ($list as $row) {
			if($row->kode == $idlevel2){
				$idlevel1 = $row->COCODE;
			}
		}
		$data["idlevel1"] = $idlevel1;
		$data["list"] = $list;
		return $data;
	}
	
	public function load_level3($idlevel3 = ''){
		$idlevel2 = '';
		
		$this->db->select("STORE_SLOC as kode, LEVEL3 as nama, PLANT", false);
		$this->db->from($this->_table3);
		$list = $this->db->get()->result();
		foreach ($list as $row) {
			if($row->kode == $idlevel3){
				$idlevel2 = $row->PLANT;
			}
		}
		$data["idlevel2"] = $idlevel2;
		$data["list"] = $list;
		return $data;
	}
	
	public function load_level4($idlevel4 = ''){
		$idlevel3 = '';
		
		$c = explode("..", $idlevel4);
		$this->db->select("concat(concat(SLOC,'#'), STORE_SLOC) as kode, LEVEL4 as nama, PLANT, STORE_SLOC", false);
		$this->db->where(array("PLANT" => $c[0], "STORE_SLOC" => $c[1]));
		$this->db->from($this->_table4);
		$list = $this->db->get()->result();
		foreach ($list as $row) {
			if($row->PLANT == $c[0] && $row->STORE_SLOC == $c[1]){
				$idlevel3 = $row->STORE_SLOC;
			}
		}
		$data["idlevel3"] = $idlevel3;
		$data["list"] = $list;
		return $data;
	}
	
}

/* End of file user_model.php */
/* Location: ./application/modules/meeting_management/models/user_model.php */ 