<?php
	
	/**
		 * @module Master Tangki
	*/
	class kontrak_transportir_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		private $_table1 = "DATA_KONTRAK_TRANSPORTIR"; //nama table setelah mom_
		private $_table2 = "MASTER_TRANSPORTIR"; //nama table setelah mom_
		private $_table3 = "MASTER_DEPO"; //nama table setelah mom_
		private $_table4 = "MASTER_LEVEL4"; //nama table setelah mom_
		private $_table5 = "DET_KONTRAK_TRANS"; //nama table setelah mom_
		
		private function _key($key) { //unit ID
			if (!is_array($key)) {
				$key = array('ID_KONTRAK_TRANS' => $key);
			}
			return $key;
		}
		
		public function data($key = '') {
			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.ID_TRANSPORTIR = a.ID_TRANSPORTIR');
			// $this->db->join($this->_table5 . ' c', 'c.ID_KONTRAK_TRANSPORTIR = a.ID_KONTRAK_TRANSPORTIR');
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}
		
		public function save_as_new($data) {
			$this->db->trans_begin();
			$id = $this->db->set_id($this->_table1, 'ID_KONTRAK_TRANS', 'no_prefix', 11);
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
			$data['ID_KONTRAK_TRANS'] = $id;
			$data['SLOC'] = $this->input->post('option_pembangkit');
            $data['ID_DEPO'] = $this->input->post('option_depo');
            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur');
            $data['JARAK_DET_KONTRAK_TRANS'] = $this->input->post('JARAK');
            $data['HARGA_KONTRAK_TRANS'] = $this->input->post('HARGA');
            $data['CD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['UD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['CD_BY_DET_KONTRAK_TRANS'] = $this->session->userdata('user_name');

			$this->db->trans_begin();
			$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
			$this->db->insert($this->_table5, $data);
			
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
            $filter[$this->_table1 . ".KD_KONTRAK_TRANS LIKE '%{$kata_kunci}%' "] = NULL;
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			$aksi = '';
			foreach ($record->result() as $row) {
				$id = $row->ID_KONTRAK_TRANS;
				// if ($this->laccess->otoritas('edit')) {
				$aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
				// }
				$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
				$rows[$id] = array(
                'no_kontrak' => $row->KD_KONTRAK_TRANS,
                'nama_transportir' => $row->NAMA_TRANSPORTIR,
                'periode' => $row->TGL_KONTRAK_TRANS,
                'nilai_kontrak' => $row->NILAI_KONTRAK_TRANS,
                'keterangan' => $row->KET_KONTRAK_TRANS,
                'aksi' => $aksi
				);
			}
			
			return array('total' => $total, 'rows' => $rows);
		}
		

		public function data_table_detail($module = '', $limit = 20, $offset = 1) {
			$filter = array();
			$kata_kunci = $this->input->post('kata_kunci');
			
			if (!empty($kata_kunci))
            $filter[$this->_table1 . ".KD_KONTRAK_TRANS LIKE '%{$kata_kunci}%' "] = NULL;
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			// $aksi = '';
			foreach ($record->result() as $row) {
				$id = $row->ID_DET_KONTRAK_TRANS;
				// if ($this->laccess->otoritas('edit')) {
				// $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
				// }
				// $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
				$rows[$id] = array(
				'nomor' => $no,
                'depo' => $row->ID_DEPO,
                'pembangkit' => $row->SLOC,
                'harga_kontrak' => $row->HARGA_KONTRAK_TRANS,
                'Jarak' => $row->CD_DET_KONTRAK_TRANS,
                'transportasi' => $row->TYPE_KONTRAK_TRANS,
                // 'aksi' => $aksi
				);
			}
			
			return array('total' => $total, 'rows' => $rows);
		}

		public function dataoption($key = '') {
			$this->db->from($this->_table2);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function options($default = '--Pilih Transportir--') {
			$option = array();
			$list = $this->dataoption()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
			}
			
			return $option;
		}
		
		public function optionDepo($key = '') {
			$this->db->from($this->_table3);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function optionsDepo($default = '--Pilih Depo--') {
			$option = array();
			$list = $this->optionDepo()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->ID_DEPO] = $row->NAMA_DEPO;
			}
			
			return $option;
		}

		public function optionPembangkit($key = '') {
			$this->db->from($this->_table4);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function optionsPembangkit($default = '--Pilih Pembangkit--') {
			$option = array();
			$list = $this->optionPembangkit()->get();
			
			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->SLOC] = $row->LEVEL4;
			}
			
			return $option;
		}

		public function optionsJalur($default = '--Pilih Jalur Transportasi--') {
			$option = array(
				'Darat'        => 'Darat',
		        'Laut/ Sungai' => 'Laut/ Sungai',
		        'Pipa'         => 'Pipa',
		        'Multi'        => 'Multi',
				);

			if (!empty($default))
            $option[''] = $default;

			return $option;
		}
		
	}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */