<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class kontrak_transportir_adendum_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "ADENDUM_KONTRAK_TRANSPORTIR"; //nama table setelah mom_

    private $_table2 = "MASTER_TRANSPORTIR"; //nama table setelah mom_
    private $_table3 = "MASTER_DEPO"; //nama table setelah mom_
    private $_table4 = "MASTER_LEVEL4"; //nama table setelah mom_
    private $_table5 = "DET_KONTRAK_TRANS_ADENDUM"; //nama table setelah mom_
    private $_table6 = "DATA_SETTING"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_ADENDUM_TRANS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $idkontrak = $this->session->userdata('ID_KONTRAK_TRANS'); 

        $this->db->select('a.*, (SELECT ID_TRANSPORTIR fROM DATA_KONTRAK_TRANSPORTIR b WHERE b.ID_KONTRAK_TRANS = a.ID_KONTRAK_TRANS) ID_TRANSPORTIR ');
        $this->db->from($this->_table1.' a');
        $this->db->where('ID_KONTRAK_TRANS',$idkontrak);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }


	public function dataEdit($id = '') {
        $this->db->from($this->_table1 . ' a');
        $this->db->join($this->_table2 . ' b', 'b.ID_TRANSPORTIR = a.ID_TRANSPORTIR');
        $this->db->join($this->_table5 . ' c', 'c.ID_ADENDUM_TRANS = a.ID_ADENDUM_TRANS');
        $this->db->join($this->_table6 . ' f', 'f.VALUE_SETTING = c.TYPE_KONTRAK_TRANS');
        $this->db->join($this->_table3 . ' d', 'd.ID_DEPO = c.ID_DEPO');
        $this->db->join($this->_table4 . ' e', 'e.SLOC = c.SLOC');
        
        // if (!empty($key) || is_array($key))
            $this->db->where("f.KEY_SETTING = 'TYPE_KONTRAK_TRANSPORTIR' AND a.ID_ADENDUM_TRANS =", $id);
        
        return $this->db;
        
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $id = $this->db->set_id($this->_table1, 'ID_ADENDUM_TRANS', 'no_prefix', 11);
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
        $data['ID_ADENDUM_TRANS'] = $id;
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

        if (!empty($kata_kunci)) {
            $filter["a.KD_KONTRAK_TRANS LIKE '%{$kata_kunci}%'"] = NULL;
        }

        $total = $this->data($filter)->count_all_results() + 1;
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();

        //payung kontrak
        $idkontrak = $this->session->userdata('ID_KONTRAK_TRANS'); 
        $id=$idkontrak;

        $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit2-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadKontrakOriginal/' . $id)));
        $rows['A'.$id] = array(
            'NO' => $no++,
            'KD_KONTRAK_TRANS' => '-',
            'TGL_KONTRAK_TRANS' => '-',
            'KET_KONTRAK_TRANS' => 'Awal Kontrak',
            'aksi' => $aksi
        );

        foreach ($record->result() as $row) {
            $id = $row->ID_ADENDUM_TRANS;
            $aksi = '';

            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit3-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/loadKontrakAdendum/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash" title="Hapus Data"></i>', array('class' => 'btn transparant', 'id' => 'button-delete2-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete_adendum/' . $id)));
            }

            $rows[$id] = array(
                'NO' => $no++,
                'KD_KONTRAK_TRANS' => $row->KD_KONTRAK_TRANS,
                'TGL_KONTRAK_TRANS' => $row->TGL_KONTRAK_TRANS,
                'KET_KONTRAK_TRANS' => $row->KET_KONTRAK_TRANS,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }  
     
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */