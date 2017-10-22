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
				$this->db->select("concat(concat(SLOC,'#'), STORE_SLOC) as kode, LEVEL4 as nama", false);
				$this->db->where(array("PLANT" => $c[0], "STORE_SLOC" => $c[1]));
				$this->db->from($this->_table4);
				$list = $this->db->get();
				break;
		}
     
        return $list->result();
    }
}

/* End of file user_model.php */
/* Location: ./application/modules/meeting_management/models/user_model.php */ 