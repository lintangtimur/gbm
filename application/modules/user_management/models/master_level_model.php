<?php

/**
 * @module Master Level Model
 */
class master_level_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	private $_tabler = "master_regional";
    private $_table1 = "master_level1";
    private $_table2 = "master_level2";
    private $_table3 = "master_level3";
    private $_table4 = "master_level4";
	
	public function load_option($id = ''){
		 $option='';
        switch ($id) {
			case "R":
				$this->db->select("ID_REGIONAL as kode, NAMA_REGIONAL as nama");
				$this->db->from($this->_tabler);
				$list = $this->db->get();
				break;
			case "1":
				$this->db->select("COCODE as kode, LEVEL1 as nama");
				$this->db->from($this->_table1);
				$list = $this->db->get();
				break;
			case "2":
				$this->db->select("PLANT as kode, LEVEL2 as nama");
				$this->db->from($this->_table2);
				$list = $this->db->get();
				break;
			case "3":
				$this->db->select("STORE_SLOC as kode, LEVEL3 as nama");
				$this->db->from($this->_table3);
				$list = $this->db->get();
				break;
			case "4":
				$this->db->select("concat(concat(SLOC,''), STORE_SLOC) as kode, LEVEL4 as nama", false);
				$this->db->from($this->_table4);
				$list = $this->db->get();
				break;
		}
        // foreach ($list->result() as $row) {
			// $option .= "<option value='". $row->kode ."'>". $row->nama ."</option>";
		// }
        return $list->result();
    }
}

/* End of file user_model.php */
/* Location: ./application/modules/meeting_management/models/user_model.php */ 