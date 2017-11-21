<?php
	
	/**
		 * @module Master Tangki
	*/
	class tangki_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		private $_table1 = "MASTER_TANGKI"; //nama table setelah mom_
		private $_table2 = "MASTER_LEVEL4"; //nama table setelah mom_
		private $_table3 = "M_JNS_BHN_BKR"; //nama table setelah mom_
		private $_table4 = "MASTER_TERA"; //nama table setelah mom_
		private $_table5 = "DET_TERA_TANGKI"; //nama table setelah mom_
		
		private function _key($key) { //unit ID
			if (!is_array($key)) {
				$key = array('ID_TANGKI' => $key);
			}
			return $key;
		}
		
		public function data($key = '') {
			$level_user = $this->session->userdata('level_user');
			$kode_level = $this->session->userdata('kode_level');

			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.SLOC = a.SLOC');
			$this->db->join($this->_table3 . ' c', 'c.ID_JNS_BHN_BKR = a.ID_JNS_BHN_BKR');
			// $this->db->join($this->_table5 . ' d', 'd.ID_TANGKI = a.ID_TANGKI');
			   

			$data_lv = $this->get_level($level_user,$kode_level);
			if ($level_user==3|| $level_user==4){
				 $this->db->where("b.SLOC",$data_lv[0]->SLOC);
			}

			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function dataEdit($key = '') {
			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.SLOC = a.SLOC');
			$this->db->join($this->_table3 . ' c', 'c.ID_JNS_BHN_BKR = a.ID_JNS_BHN_BKR');
			$this->db->join($this->_table5 . ' d', 'd.ID_TANGKI = a.ID_TANGKI');

			
			if (!empty($key) || is_array($key))
			$this->db->where("a.ID_TANGKI",$key);
            // $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}
		
		public function save_as_new($data, $nama_file) {
			$this->db->trans_begin();
			$id = $this->db->set_id($this->_table1, 'ID_TANGKI', 'no_prefix', 4);
			$this->db->insert($this->_table1, $data);
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
				} else {
				$this->db->trans_commit();
				$this->save_as_new2($id, $nama_file);
				return TRUE;
			}
		}


		public function save_as_new2($id, $nama_file) {
			$tera['ID_TANGKI'] = $id;
			$tera['TGL_DET_TERA'] = $this->input->post('TGL_TERA');
            $tera['CD_DET_TERA'] = date("Y-m-d");
            $tera['UD_DET_TERA'] = date("Y-m-d");
            $tera['CD_BY_DET_TERA'] = $this->session->userdata('user_name');
            $tera['ID_TERA'] = $this->input->post('TERA');
            $tera['ISAKTIF_DET_TERA'] = $this->input->post('STATUS');
            $tera['PATH_DET_TERA'] = $nama_file;

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
		
		public function save($data, $key, $nama_file) {
			$this->db->trans_begin();
			$this->db->update($this->_table1, $data, $this->_key($key));
			$id = $key;
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
				} else {
				$this->db->trans_commit();
				$this->save2($id, $nama_file);
				return TRUE;
			}
		}

		public function save2($id, $nama_file) {
			$tera['ID_TANGKI'] = $id;
			$tera['TGL_DET_TERA'] = $this->input->post('TGL_TERA');
            $tera['UD_DET_TERA'] = date("Y-m-d");
            $tera['CD_BY_DET_TERA'] = $this->session->userdata('user_name');
            $tera['ID_TERA'] = $this->input->post('TERA');
            $tera['ISAKTIF_DET_TERA'] = $this->input->post('STATUS');
            $tera['PATH_DET_TERA'] = $nama_file;

			$this->db->trans_begin();
			$this->db->update($this->_table5, $tera, $this->_key($id));
			
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
			
			$this->db->delete($this->_table5, $this->_key($key));
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
            $filter["b.LEVEL4 LIKE '%{$kata_kunci}%' OR c.NAMA_JNS_BHN_BKR LIKE '%{$kata_kunci}%' OR a.VOLUME_TANGKI LIKE '%{$kata_kunci}%' OR a.DEADSTOCK_TANGKI LIKE '%{$kata_kunci}%' OR a.STOCKEFEKTIF_TANGKI LIKE '%{$kata_kunci}%' "] = NULL;
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			foreach ($record->result() as $row) {
				$aksi = '';
				$id = $row->ID_TANGKI;
				if ($this->laccess->otoritas('edit')) {
				$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
				}
				if ($this->laccess->otoritas('delete')) {
				$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
				}
				$rows[$id] = array(
                'number' => $no++,
                'unit_pembangkit' => $row->LEVEL4,
                'jenis_bbm' => $row->NAMA_JNS_BHN_BKR,
                'kapasitas' => number_format($row->VOLUME_TANGKI,0,',','.'),
                'deadstock' => number_format($row->DEADSTOCK_TANGKI,0,',','.'),
                'stockefektif' => number_format($row->STOCKEFEKTIF_TANGKI,0,',','.'),
                'aksi' => $aksi
				);
			}
			
			return array('total' => $total, 'rows' => $rows);
		}
		
		public function data_table_detail($module = '', $limit = 20, $offset = 1) {
			$filter = array();
			$kata_kunci = $this->input->post('kata_kunci');
			
			if (!empty($kata_kunci))
            $filter["b.LEVEL4 LIKE '%{$kata_kunci}%' OR c.NAMA_JNS_BHN_BKR LIKE '%{$kata_kunci}%' OR a.VOLUME_TANGKI LIKE '%{$kata_kunci}%' OR a.DEADSTOCK_TANGKI LIKE '%{$kata_kunci}%' OR a.STOCKEFEKTIF_TANGKI LIKE '%{$kata_kunci}%' "] = NULL;
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->get_detail($filter)->get();
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

		// function get_detail($key = '') {
		// 	$this->db->from($this->_table5);
			
		// 	if (!empty($key) || is_array($key))
  //           $this->db->where_condition($this->_key($key));
			
		// 	return $this->db;
		// }

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

		public function option_pembangkit_all($default = '--Pilih Unit Pembangkit--') {
			$option = array();
			$list = $this->data_option()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->SLOC] = $row->LEVEL4;
			}
			
			return $option;
		}

		public function option_pembangkit_filter($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
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

	}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */