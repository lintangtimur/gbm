<?php
	
	/**
		 * @module Master Max Pemakaian
		* @author  Aditya
	*/
	class max_pakai_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		private $_table1 = "MAX_PEMAKAIAN"; 
		
		private function _key($key) { //unit ID
			if (!is_array($key)) {
				$key = array('ID_MAX_PAKAI' => $key);
			}
			return $key;
		}
		
		public function data($key = '') {
			$this->db->from($this->_table1);
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}
		
		public function save_as_new($thbl, $vol, $sloc, $jnsbbm) {
			$query = "call SAVE_MAX_PEMAKAIAN('$thbl','$vol','$sloc','$jnsbbm')";
			$data = $this->db->query($query);
			
			return $data->result();
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
			
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			$aksi = '';
			foreach ($record->result() as $row) {
				$id = $row->ID_MAX_PAKAI;
				
				if ($row->STATUS_MAX_PAKAI == '0') /*TIDAK AKTIVE*/
					if ($this->laccess->otoritas('edit'))
						$aksi = anchor(null, '<i class="icon-check"></i>', array('class' => 'btn transparant', 'id' => 'button-aktif-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/aktif/' . $id)));
				else
					if ($this->laccess->otoritas('edit'))
						$aksi = anchor(null, '<i class="icon-close"></i>', array('class' => 'btn transparant', 'id' => 'button-deactive-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/deactive/' . $id)));
				
				$rows[$id] = array(
				'no' => $no++,
                'periode' => $row->THBL_MAX_PAKAI,
                'volume' => $row->VOLUME_MAX_PAKAI,
                'aksi' => $aksi
				);
			}
			
			return array('total' => $total, 'rows' => $rows);
		}
		
		public function options(){
			$lvl = $this->session->userdata('level_user');
			$kode = $this->session->userdata('kode_level');
			$option = array(""=> "Pilih Pembangkit");
			$list = $this->db->query("SELECT SLOC, LEVEL4 FROM MASTER_LEVEL4"); 

			foreach ($list->result() as $row) {
				$option[$row->SLOC] = $row->LEVEL4;
			}
			return $option;    
		}
		
		public function options_jnsbbm(){
			$option = array(""=> "Pilih Jenis Bahan Bakar");
			$list = $this->db->query("SELECT ID_JNS_BHN_BKR, NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR"); 

			foreach ($list->result() as $row) {
				$option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
			}
			return $option;    
		}
		
	}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */