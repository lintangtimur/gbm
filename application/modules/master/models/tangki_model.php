<?php
	
	/**
		 * @module Master Tangki
	*/
	class tangki_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		private $_table1 = "master_tangki"; //nama table setelah mom_
		private $_table2 = "master_level4"; //nama table setelah mom_
		private $_table3 = "m_jns_bhn_bkr"; //nama table setelah mom_
		private $_table4 = "master_tera"; //nama table setelah mom_
		private $_table5 = "det_tera_tangki"; //nama table setelah mom_
		
		private function _key($key) { //unit ID
			if (!is_array($key)) {
				$key = array('ID_TANGKI' => $key);
			}
			return $key;
		}
		
		public function data($key = '') {
			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.sloc = a.sloc');
			$this->db->join($this->_table3 . ' c', 'c.ID_JNS_BHN_BKR = a.ID_JNS_BHN_BKR');
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}
		
		public function save_as_new($data) {
			$this->db->trans_begin();
			$id = $this->db->set_id($this->_table1, 'ID_TANGKI', 'no_prefix', 4);
			$this->db->insert($this->_table1, $data);
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
				} else {
				$this->db->trans_commit();
				$this->save_as_new2($id);
				return TRUE;
			}
		}


		public function save_as_new2($id) {
			$tera['ID_TANGKI'] = $id;
			$tera['TGL_DET_TERA'] = $this->input->post('TGL_TERA');
            $tera['CD_DET_TERA'] = date("Y/m/d");
            $tera['UD_DET_TERA'] = date("Y/m/d");
            $tera['CD_BY_DET_TERA'] = $this->session->userdata('user_name');
            $tera['ID_TERA'] = $this->input->post('TERA');
            $data['FILE_UPLOAD'] = $this->input->post('FILE_UPLOAD');

			$this->db->trans_begin();
			$this->db->set_id($this->_table5, 'ID_DET_TERA', 'no_prefix', 5);
			// $id = $this->db->set_id($this->_table1, 'ID_TANGKI', 'no_prefix', 4);
			$this->db->insert($this->_table5, $tera);
			
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
			
			if (!empty($kata_kunci))
            $filter[$this->_table1 . ".NAMA_TANGKI LIKE '%{$kata_kunci}%' "] = NULL;
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			$aksi = '';
			foreach ($record->result() as $row) {
				$id = $row->ID_TANGKI;
				// if ($this->laccess->otoritas('edit')) {
				$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
				// }
				$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
				$rows[$id] = array(
                'number' => $no++,
                'unit_pembangkit' => $row->LEVEL4,
                'jenis_bbm' => $row->NAMA_JNS_BHN_BKR,
                'kapasitas' => $row->VOLUME_TANGKI,
                'deadstock' => $row->DEADSTOCK_TANGKI,
                'stockefektif' => $row->STOCKEFEKTIF_TANGKI,
                'aksi' => $aksi
				);
			}
			
			return array('total' => $total, 'rows' => $rows);
		}
		
		public function data_option($key = '') {
			$this->db->from($this->_table2);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function data_option2($key = '') {
			$this->db->from($this->_table3);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function data_option3($key = '') {
			$this->db->from($this->_table4);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function option_pembangkit($default = '--Pilih Unit Pembangkit--') {
			$option = array();
			$list = $this->data_option()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->SLOC] = $row->LEVEL4;
			}
			
			return $option;
		}
		

		public function option_jenisbbm($default = '--Pilih Jenis BBM--') {
			$option = array();
			$list = $this->data_option2()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
			}
			
			return $option;
		}

		public function option_tera($default = '--Pilih Tera--') {
			$option = array();
			$list = $this->data_option3()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->ID_TERA] = $row->NAMA_TERA;
			}
			
			return $option;
		}

	}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */