<?php

/**
 * penerimaan bbm model
 */
class penerimaan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData_Model($data)
    {
        $VLEVEL_REGIONAL               = $data['ID_REGIONAL'];
        $VLEVELID                      = $data['VLEVELID'];
        // $BULAN                         = $data['BULAN'];
        $JENIS_BBM                     = $data['JENIS_BBM'];
        $TGLAWAL                       = $data['TGLAWAL'];
        $TGLAKHIR                      = $data['TGLAKHIR'];
        // $TAHUN                         = $data['TAHUN'];

        // if ($VLEVELID == '' and $VLEVEL_REGIONAL == 'all') {
        //     $VLEVELID        = '';
        //     $VLEVEL_REGIONAL = 'all';
        // }
        $sql = "call lap_rekap_penerimaan(
            '$JENIS_BBM',
            '$TGLAWAL' ,
            '$TGLAKHIR' ,
            '$VLEVEL_REGIONAL',
            '$VLEVELID'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function testGetDataModel($data)
    {
        $sql = "call lap_rekap_penerimaan(
            '-',
            '03112017',
            '27112017',
            'Level 1',
            '7700'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    /**
     * getData_Model_Detail
     * @param  array $data from controller
     * @return mixed
     */
    public function getData_Model_Detail($data)
    {
        $idBBM    = $data['ID_BBM'];
        $kodeUnit = $data['KODE_UNIT'];
        $tglAwal  = $data['TGL_AWAL'];
        $tglAkhir = $data['TGL_AKHIR'];
        // $bulan    = $data['BULAN'];
        // $tahun    = $data['TAHUN'];
        // lap_detail_penerimaan(
        //     idbbm, bulan, tahun, kodeunit
        //     )
        $sql      = "call lap_detail_penerimaan(
            '$idBBM',
            '$tglAwal',
            '$tglAkhir',
            '$kodeUnit'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function data_option($key = '')
    {
        $this->db->from('M_JNS_BHN_BKR');

        if (!empty($key) || is_array($key)) {
            $this->db->where_condition($this->_key($key));
        }

        $this->db->close();

        return $this->db;
    }

    public function option_jenisbbm($default = '--Pilih Jenis BBM--')
    {
        $option = [];
        $list   = $this->data_option()->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            if ($row->ID_JNS_BHN_BKR == '004') {
            } else {
                $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
            }
        }
        $this->db->close();

        return $option;
    }
}
