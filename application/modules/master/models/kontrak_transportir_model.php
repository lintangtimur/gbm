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
		private $_table6 = "DATA_SETTING"; //nama table setelah mom_
		
		private function _key($key) { //unit ID
			if (!is_array($key)) {
				$key = array('ID_KONTRAK_TRANS' => $key);
			}
			return $key;
		}
		
		public function data($key = '') {
			$perubahan = ' ,(SELECT COUNT(*) FROM ADENDUM_KONTRAK_TRANSPORTIR b WHERE b.ID_KONTRAK_TRANS=a.ID_KONTRAK_TRANS) AS PERUBAHAN';
			$this->db->select('a.*, b.NAMA_TRANSPORTIR '.$perubahan);
			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.ID_TRANSPORTIR = a.ID_TRANSPORTIR');
			// $this->db->join($this->_table5 . ' c', 'c.ID_KONTRAK_TRANS = a.ID_KONTRAK_TRANS');
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}

		public function dataEdit($key = '') {
			$this->db->from($this->_table1 . ' a');
			$this->db->join($this->_table2 . ' b', 'b.ID_TRANSPORTIR = a.ID_TRANSPORTIR');
			$this->db->join($this->_table5 . ' c', 'c.ID_KONTRAK_TRANS = a.ID_KONTRAK_TRANS');
			$this->db->join($this->_table6 . ' f', 'f.VALUE_SETTING = c.TYPE_KONTRAK_TRANS');
			$this->db->join($this->_table3 . ' d', 'd.ID_DEPO = c.ID_DEPO');
			$this->db->join($this->_table4 . ' e', 'e.SLOC = c.SLOC');
			
			if (!empty($key) || is_array($key))
				$this->db->where("f.KEY_SETTING = 'TYPE_KONTRAK_TRANSPORTIR' AND a.ID_KONTRAK_TRANS =", $key);
            // $this->db->where_condition($this->_key($key));
			
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
			// $jumlah = $this->input->post('JML_PASOKAN');
			$data['ID_KONTRAK_TRANS'] = $id;
            $data['CD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['UD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['CD_BY_DET_KONTRAK_TRANS'] = $this->session->userdata('user_name');

            if ($this->input->post('option_depo1') != '') {
            	$data['ID_DEPO'] = $this->input->post('option_depo1');
				$data['SLOC'] = $this->input->post('option_pembangkit1');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur1');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK1'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA1'));
	           	$this->db->trans_begin();
				$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
				$this->db->insert($this->_table5, $data);
            }

            if ($this->input->post('option_depo2') != '') {
            	$data['ID_DEPO'] = $this->input->post('option_depo2');
				$data['SLOC'] = $this->input->post('option_pembangkit2');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur2');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK2'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA2'));
	           	$this->db->trans_begin();
				$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
				$this->db->insert($this->_table5, $data);
            }
            if ($this->input->post('option_depo3') != '') {
            	$data['ID_DEPO'] = $this->input->post('option_depo3');
				$data['SLOC'] = $this->input->post('option_pembangkit3');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur3');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK3'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA3'));
	           	$this->db->trans_begin();
				$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
				$this->db->insert($this->_table5, $data);
            }
            if ($this->input->post('option_depo4') != '') {
				$data['SLOC'] = $this->input->post('option_pembangkit4');
            	$data['ID_DEPO'] = $this->input->post('option_depo4');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur4');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK4'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA4'));
	           	$this->db->trans_begin();
				$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
				$this->db->insert($this->_table5, $data);
            }
            if ($this->input->post('option_depo5') != '') {
				$data['SLOC'] = $this->input->post('option_pembangkit5');
            	$data['ID_DEPO'] = $this->input->post('option_depo5');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur5');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK5'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA5'));
	           	$this->db->trans_begin();
				$this->db->set_id($this->_table5, 'ID_DET_KONTRAK_TRANS', 'no_prefix', 11);
				$this->db->insert($this->_table5, $data);
            }
            
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
			$id = $key;
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
				} else {
				$this->db->trans_commit();
				$this->save2($id);
				return TRUE;
			}
		}
		
		public function save2($id) {
			// $jumlah = $this->input->post('JML_PASOKAN');
			$data['ID_KONTRAK_TRANS'] = $id;
            $data['UD_DET_KONTRAK_TRANS'] = date("Y/m/d");
            $data['CD_BY_DET_KONTRAK_TRANS'] = $this->session->userdata('user_name');

            if ($this->input->post('option_depo1') != '') {
            	$data['ID_DEPO'] = $this->input->post('option_depo1');
				$data['SLOC'] = $this->input->post('option_pembangkit1');
	            $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur1');
	            $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK1'));
	            $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA1'));
	           	$this->db->trans_begin();
				$this->db->update($this->_table5, $data, $this->_key($id));
            }

    //         if ($this->input->post('option_depo2') != '') {
    //         	$data['ID_DEPO'] = $this->input->post('option_depo2');
				// $data['SLOC'] = $this->input->post('option_pembangkit2');
	   //          $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur2');
	   //          $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK2'));
	   //          $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA2'));
	   //         	$this->db->trans_begin();
				// $this->db->update($this->_table5, $data, $this->_key($id));
    //         }
    //         if ($this->input->post('option_depo3') != '') {
    //         	$data['ID_DEPO'] = $this->input->post('option_depo3');
				// $data['SLOC'] = $this->input->post('option_pembangkit3');
	   //          $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur3');
	   //          $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK3'));
	   //          $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA3'));
	   //         	$this->db->trans_begin();
				// $this->db->update($this->_table5, $data, $this->_key($id));
    //         }
    //         if ($this->input->post('option_depo4') != '') {
				// $data['SLOC'] = $this->input->post('option_pembangkit4');
    //         	$data['ID_DEPO'] = $this->input->post('option_depo4');
	   //          $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur4');
	   //          $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK4'));
	   //          $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA4'));
	   //         	$this->db->trans_begin();
				// $this->db->update($this->_table5, $data, $this->_key($id));
    //         }
    //         if ($this->input->post('option_depo5') != '') {
				// $data['SLOC'] = $this->input->post('option_pembangkit5');
    //         	$data['ID_DEPO'] = $this->input->post('option_depo5');
	   //          $data['TYPE_KONTRAK_TRANS'] = $this->input->post('option_jalur5');
	   //          $data['JARAK_DET_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('JARAK5'));
	   //          $data['HARGA_KONTRAK_TRANS'] = str_replace(".","",$this->input->post('HARGA5'));
	   //         	$this->db->trans_begin();
				// $this->db->update($this->_table5, $data, $this->_key($id));
    //         }
            
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
			$filter["b.NAMA_TRANSPORTIR LIKE '%{$kata_kunci}%' OR a.KD_KONTRAK_TRANS LIKE '%{$kata_kunci}%'" ] = NULL;	
			$total = $this->data($filter)->count_all_results();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			$no=(($offset-1) * $limit) +1;
			$rows = array();
			foreach ($record->result() as $row) {
				$aksi = '';
				$id = $row->ID_KONTRAK_TRANS;
				if ($this->laccess->otoritas('edit')) {
				$aksi = anchor(null, '<i class="icon-zoom-in"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadKontrakOriginal/' . $id)));
				}
				if ($this->laccess->otoritas('add')) {
					$aksi .= anchor(null, '<i class="icon-copy" title="Lihat Adendum"></i>', array('class' => 'btn transparant', 'id' => 'button-adendum-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/adendum/' . $id)));
				}
				if ($this->laccess->otoritas('delete')) {
					if ($row->PERUBAHAN == 0){
				$aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
					}
				}
				$rows[$id] = array(
                'no_kontrak' => $row->KD_KONTRAK_TRANS,
                'nama_transportir' => $row->NAMA_TRANSPORTIR,
                'periode' => $row->TGL_KONTRAK_TRANS,
                'nilai_kontrak' => number_format($row->NILAI_KONTRAK_TRANS,0,',','.'),
				'keterangan' => $row->KET_KONTRAK_TRANS,
				'perubahan' => $row->PERUBAHAN,
                'aksi' => $aksi
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

		
		public function opsiJalur($key = '') {
			$this->db->from('DATA_SETTING');
			
			$key = 'TYPE_KONTRAK_TRANSPORTIR';
			if (!empty($key) || is_array($key))
			$this->db->where("KEY_SETTING",$key);
			
			return $this->db;
		}



		public function optionsJalur($default = '--Pilih Jalur Transportasi--') {
			$option = array();
			$list = $this->opsiJalur()->get();

			if (!empty($default))
            $option[''] = $default;
			
			foreach ($list->result() as $row) {
				$option[$row->VALUE_SETTING] = $row->NAME_SETTING;
			}
			
			return $option;
		}
		
	}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */