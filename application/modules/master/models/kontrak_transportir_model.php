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
		$sumKirim = ', (select COUNT(KD_KONTRAK_TRANS) FROM DET_KONTRAK_TRANS mk WHERE mk.KD_KONTRAK_TRANS=a.KD_KONTRAK_TRANS) AS JML_PASOKAN ';
		$this->db->select('a.*, b.NAMA_TRANSPORTIR '.$perubahan.$sumKirim);
		$this->db->from($this->_table1 . ' a');
		$this->db->join($this->_table2 . ' b', 'b.ID_TRANSPORTIR = a.ID_TRANSPORTIR');
        $this->db->join('MASTER_LEVEL2 c', 'c.PLANT = a.PLANT','left');
        $this->db->join('MASTER_LEVEL1 d', 'd.COCODE = c.COCODE','left');
        $this->db->join('MASTER_REGIONAL e', 'e.ID_REGIONAL = d.ID_REGIONAL','left');

        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('e.ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("d.COCODE",$_POST['COCODE']);   
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("a.PLANT",$_POST['PLANT']);   
        }
        // if ($_POST['STORE_SLOC'] !='') {
        //     $this->db->where("STORE_SLOC",$_POST['STORE_SLOC']);   
        // }
        // if ($_POST['SLOC'] !='') {
        //     $this->db->where("SLOC",$_POST['SLOC']);   
        // }
        if ($_POST['PERIODE'] !='') {
            $this->db->where("a.TGL_KONTRAK_TRANS",$_POST['PERIODE']);   
        }
	
		if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));

   		$this->db->order_by('a.ID_KONTRAK_TRANS DESC');
		
		return $this->db;
	}

	public function dataEdit($key=''){
		$this->db->from($this->_table1);
		
		if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));
		
		return $this->db;

	}

	public function cek_no_kotrak($key=''){
		$this->db->from($this->_table1);
		$this->db->where('KD_KONTRAK_TRANS',$key);
		$query = $this->db->get();
		return $query->num_rows();
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
			return TRUE;
		}
	}

    public function save_detail($data) {
        $this->db->insert_batch('DET_KONTRAK_TRANS', $data);
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

    public function delete_detail($key) {
        $this->db->trans_begin();

        $this->db->delete('DET_KONTRAK_TRANS', array('KD_KONTRAK_TRANS' => $key)); 

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
		
		// $this->db->delete($this->_table5, $this->_key($key));
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

				$aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Kontrak"></i>', array('class' => 'btn transparant', 'id' => 'button-original-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadKontrakOriginal/' . $id)));
				
			if ($this->laccess->otoritas('edit')) {
				if ($this->session->userdata('user_name')==$row->CD_BY_DET_KONTRAK_TRANS){
					if ($row->PERUBAHAN == 0){
						$aksi .= anchor(null, '<i class="icon-edit" title="Edit Kontrak"></i>', array('class' => 'btn 	transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
					}
				}
			}
			if ($this->laccess->otoritas('add')) {
				$aksi .= anchor(null, '<i class="icon-copy" title="Lihat Adendum"></i>', array('class' => 'btn transparant', 'id' => 'button-adendum-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/adendum/' . $id)));
			}
			if ($this->laccess->otoritas('delete')) {
				if ($this->session->userdata('user_name')==$row->CD_BY_DET_KONTRAK_TRANS){
					if ($row->PERUBAHAN == 0){
					$aksi .= anchor(null, '<i class="icon-trash" title="Hapus Kontrak"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
					}
				}
			}
			
			$rows[$no++] = array(
            'no_kontrak' => $row->KD_KONTRAK_TRANS,
            'nama_transportir' => $row->NAMA_TRANSPORTIR,
            'periode' => $row->TGL_KONTRAK_TRANS,
            'nilai_kontrak' => number_format($row->NILAI_KONTRAK_TRANS,2,',','.'),
			'keterangan' => $row->KET_KONTRAK_TRANS,
			'perubahan' => $row->PERUBAHAN,
            'aksi' => $aksi
			);
		}

		// print_r($this->db->last_query()); die;
		
		return array('total' => $total, 'rows' => $rows);
	}

	public function dataoption($key = '') {
		$this->db->from($this->_table2);
		
		if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));

		$this->db->order_by('REF_NAMA_TRANS, NAMA_TRANSPORTIR');
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
	
	function getDepo() {
		$data = array();
		
	    $this->db->from('MASTER_DEPO');
	    $this->db->order_by('REF_NAMA_TRANS, NAMA_DEPO');
	    $query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
					$data[] = $row;
				}
		}
		$query->free_result();
		return $data;
	}
	function getPembangkitAll() {
		$data = array();
		$query = $this->db->get('MASTER_LEVEL4');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
					$data[] = $row;
				}
		}
		$query->free_result();
		return $data;
	}
	function getPembangkitFilter($key = 'all', $jenis=0) {

		$this->db->from('MASTER_LEVEL4');
		$this->db->where('IS_AKTIF_LVL4','1');
		if ($key != 'all'){
			$this->db->where('PLANT',$key);
		}
		$data = array();
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
					$data[] = $row;
				}
		}
		$query->free_result();
		return $data;
	}

	function getPembangkitByLv($vLv4=null) {
		$data = array();

		if ($vLv4){
			$aktif = ' AND (IS_AKTIF_LVL4=1) ';
		} else {
			$aktif = '';
		}

		$kode_level = $this->session->userdata('kode_level');

		$sql = "select a.SLOC, a.LEVEL4, b.STORE_SLOC, c.PLANT, d.COCODE, e.ID_REGIONAL
				from MASTER_LEVEL4 a 
				left join MASTER_LEVEL3 b on b.STORE_SLOC = a.STORE_SLOC 
				left join MASTER_LEVEL2 c on c.PLANT = b.PLANT
				left join MASTER_LEVEL1 d on d.COCODE = c.COCODE
				left join MASTER_REGIONAL e on e.ID_REGIONAL = d.ID_REGIONAL 
				where ( a.SLOC='$kode_level' OR b.STORE_SLOC='$kode_level' OR c.PLANT='$kode_level' 
				OR d.COCODE='$kode_level' OR e.ID_REGIONAL='$kode_level' ) $aktif 
				order by a.LEVEL4 ";

        $query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
					$data[] = $row;
				}
		}

		$this->db->close();
		return $data;
	}


	public function getJalur() {
	    $this->db->from('DATA_SETTING');
		$key = 'TYPE_KONTRAK_TRANSPORTIR';
		$this->db->where("KEY_SETTING",$key);
		$this->db->order_by('NAME_SETTING');

		$data = array();
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
					$data[] = $row;
				}
		}
		$query->free_result();
		return $data;

	}


    public function get_detail_kirim($key) {
		$q="SELECT a.HARGA_KONTRAK_TRANS, a.SLOC, a.ID_DEPO, a.JARAK_DET_KONTRAK_TRANS, a.TYPE_KONTRAK_TRANS, 
			a.SLOC_PEMASOK, m4.LEVEL4, m3.STORE_SLOC, m3.LEVEL3, m2.PLANT, m2.LEVEL2, m1.COCODE, m1.LEVEL1
			FROM  DET_KONTRAK_TRANS a
			LEFT JOIN MASTER_LEVEL4 m4 ON m4.SLOC=a.SLOC_PEMASOK 
			LEFT JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC=m4.STORE_SLOC 
			LEFT JOIN MASTER_LEVEL2 m2 ON m2.PLANT=m3.PLANT 
			LEFT JOIN MASTER_LEVEL1 m1 ON m1.COCODE=m2.COCODE 
			WHERE a.KD_KONTRAK_TRANS='$key' 
			ORDER BY a.ID_DET_KONTRAK_TRANS ASC ";	

        $query = $this->db->query($q);
        $this->db->close();
        return $query->result();  
    }

	public function get_level($lv='', $key=''){ 
		switch ($lv) {
			case "0":
				$q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
				FROM MASTER_REGIONAL E
				WHERE ID_REGIONAL='$key' ORDER BY E.NAMA_REGIONAL ";
				break;
			case "1":
				$q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
				FROM MASTER_LEVEL1 D 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE COCODE='$key' ORDER BY E.NAMA_REGIONAL ";
				break;
			case "2":
				$q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL2 C 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE PLANT='$key' ORDER BY C.LEVEL2 ";
				break;
			case "3":
				$q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL3 B
				LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE STORE_SLOC='$key' ORDER BY B.LEVEL3 ";
				break;
			case "4":
				$q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
				FROM MASTER_LEVEL4 A
				LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
				LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
				LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
				LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
				WHERE SLOC='$key' ORDER BY A.LEVEL4 ";
				break;
			case "5":
				$q = "SELECT a.LEVEL3, a.STORE_SLOC
				FROM MASTER_LEVEL3 a
				INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
				INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
				WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' 
				ORDER BY a.LEVEL3 ";
				break;
		} 

		$query = $this->db->query($q)->result();
		return $query;
	}

	public function options_reg($default = '--Pilih Regional--', $key = 'all') {
	    $option = array();

	    $this->db->from('MASTER_REGIONAL');
	    $this->db->where('IS_AKTIF_REGIONAL','1');
	    if ($key != 'all'){
	        $this->db->where('ID_REGIONAL',$key);
	    } 
	    $this->db->order_by('NAMA_REGIONAL');  

	    $list = $this->db->get(); 

	    if (!empty($default)) {
	        $option[''] = $default;
	    }

	    foreach ($list->result() as $row) {
	        $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
	    }
	    $this->db->close();
	    return $option;
	}

	public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL1');
	    $this->db->where('IS_AKTIF_LVL1','1');
	    if ($key != 'all'){
	        $this->db->where('ID_REGIONAL',$key);
	    }    
	    $this->db->order_by('LEVEL1'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->COCODE] = $row->LEVEL1;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL2');
	    $this->db->where('IS_AKTIF_LVL2','1');
	    
	    if ($key != 'all'){
	        $this->db->where('COCODE',$key);
	    }   
	    $this->db->order_by('LEVEL2'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->PLANT] = $row->LEVEL2;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL3');
	    $this->db->where('IS_AKTIF_LVL3','1');
	    if ($key != 'all'){
	        $this->db->where('PLANT',$key);
	    }    
	    $this->db->order_by('LEVEL3'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->STORE_SLOC] = $row->LEVEL3;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
	    $this->db->from('MASTER_LEVEL4');
	    $this->db->where('IS_AKTIF_LVL4','1');
	    if ($key != 'all'){
	        $this->db->where('STORE_SLOC',$key);
	    }    
	    $this->db->order_by('LEVEL4'); 

	    if ($jenis==0){
	        $rest = $this->db->get()->result(); 
	    } else {
	        $option = array();
	        $list = $this->db->get(); 

	        if (!empty($default)) {
	            $option[''] = $default;
	        }

	        foreach ($list->result() as $row) {
	            $option[$row->SLOC] = $row->LEVEL4;
	        }
	        $rest = $option;    
	    }
	    $this->db->close();
	    return $rest;
	}

	public function options_transpotir($default = '--Pilih Transportir--') {
	    $this->db->from('MASTER_TRANSPORTIR');
	    $this->db->order_by('REF_NAMA_TRANS, NAMA_TRANSPORTIR');
	    
	    $option = array();
	    $list = $this->db->get();

	    
	    if (!empty($default)) {
	        $option[''] = $default;
	    }
	    
	    foreach ($list->result() as $row) {
	        $option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
	    }
	    $this->db->close();
	    return $option;
	}
	
	
}
	
	/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */