<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class kontrak_pemasok_adendum_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "ADENDUM_KONTRAK_PEMASOK"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_ADENDUM_PEMASOK' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $idkontrak = $this->session->userdata('ID_KONTRAK_PEMASOK'); 

        $this->db->select('a.*, (SELECT ID_PEMASOK fROM DATA_KONTRAK_PEMASOK b WHERE b.ID_KONTRAK_PEMASOK = a.ID_KONTRAK_PEMASOK) ID_PEMASOK ');
        $this->db->from($this->_table1.' a');
        $this->db->where('ID_KONTRAK_PEMASOK',$idkontrak);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function data_awal($key = '') {
        $field="ID_KONTRAK_PEMASOK, ID_PEMASOK,  
        TGL_KONTRAK_PEMASOK TGL_ADENDUM_PEMASOK, JUDUL_KONTRAK_PEMASOK JUDUL_ADENDUM_PEMASOK, 
        PERIODE_AWAL_KONTRAK_PEMASOK PERIODE_AWAL_ADENDUM_PEMASOK, PERIODE_AKHIR_KONTRAK_PEMASOK PERIODE_AKHIR_ADENMDUM_PEMASOK, 
        JENIS_KONTRAK_PEMASOK JENIS_AKHIR_ADENDUM_PEMASOK, VOLUME_KONTRAK_PEMASOK VOL_AKHIR_ADENDUM_PEMASOK, 
        ALPHA_KONTRAK_PEMASOK ALPHA_ADENDUM_PEMASOK, RUPIAH_KONTRAK_PEMASOK RP_ADENDUM_PEMASOK, 
        PENJAMIN_KONTRAK_PEMASOK PENJAMIN_ADENDUM_PEMASOK, NO_PENJAMIN_KONTRAK_PEMASOK NO_PENJAMIN_ADENDUM_PEMASOK, 
        NOMINAL_JAMINAN_KONTRAK NOMINAL_ADENDUM_PEMASOK, TGL_BERAKHIR_JAMINAN_KONTRAK TGL_AKHIR_ADENDUM_PEMASOK, 
        CD_KONTRAK_PEMASOK, CD_BY_KONTRAK_PEMASOK, UD_KONTRAK_PEMASOK, ISAKTIF_KONTRAK_PEMASOK";

        $this->db->select($field);
        $this->db->from('DATA_KONTRAK_PEMASOK ');
        if (!empty($key) || is_array($key))
            $this->db->where('ID_KONTRAK_PEMASOK',$key);

        return $this->db;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_ADENDUM_PEMASOK', 'no_prefix', 5);
        $this->db->insert($this->_table1, $data);

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

        if (!empty($kata_kunci)) {
            $filter["a.NO_ADENDUM_PEMASOK LIKE '%{$kata_kunci}%' OR a.JUDUL_ADENDUM_PEMASOK LIKE '%{$kata_kunci}%'OR a.KET_ADENDUM_PEMASOK LIKE '%{$kata_kunci}%'"] = NULL;
        }

        $total = $this->data($filter)->count_all_results() + 1;
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();

        //payung kontrak
        $idkontrak = $this->session->userdata('ID_KONTRAK_PEMASOK'); 
        $id=$idkontrak;

        $aksi = anchor(null, '<i class="icon-zoom-in" title="View"></i>', array('class' => 'btn transparant', 'id' => 'button-edit2-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
        $rows['A'.$id] = array(
            'NO' => $no++,
            'NO_ADENDUM_PEMASOK' => '-',
            'TGL_ADENDUM_PEMASOK' => '-',
            'KET_ADENDUM_PEMASOK' => 'Awal Kontrak (PJBBBM)',
            'aksi' => $aksi
        );

        foreach ($record->result() as $row) {
            $id = $row->ID_ADENDUM_PEMASOK;
            $aksi = '';

            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit" title="Edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit3-' . $id, 'onclick' => 'load_form(this.id)', 'data-source' => base_url($module . '/edit_adendum/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash" title="Hapus"></i>', array('class' => 'btn transparant', 'id' => 'button-delete2-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete_adendum/' . $id)));
            }

            $rows[$id] = array(
                'NO' => $no++,
                'NO_ADENDUM_PEMASOK' => $row->NO_ADENDUM_PEMASOK,
                'TGL_ADENDUM_PEMASOK' => $row->TGL_ADENDUM_PEMASOK,
                'KET_ADENDUM_PEMASOK' => $row->KET_ADENDUM_PEMASOK,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }  

    public function options_jns_kontrak() {
        $option = array();
        $option[''] = '--Pilih Jenis--';
        $option['1'] = 'CIF';
        $option['2'] = 'FOB';
        return $option;
    }

    public function options_pemasok($default = '--Pilih Pemasok--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_PEMASOK');
        if ($key != 'all'){
            $this->db->where('ID_PEMASOK',$key);
        }   
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        return $option;
    }
     
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */