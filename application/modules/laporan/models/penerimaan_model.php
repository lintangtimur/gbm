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
        $BULAN                         = $data['BULAN'];
        $JENIS_BBM                     = $data['JENIS_BBM'];
        $TAHUN                         = $data['TAHUN'];

        //  $sql = "call PROCEDURE `lap_rekap_penerimaan`(
        //     IN `$JENIS_BBM` VARCHAR(10) ,
        //     IN `$BULAN` VARCHAR(2),
        //     IN `$TAHUN` VARCHAR(4),
        //     IN `$VLEVEL_REGIONAL` VARCHAR(10),
        //     IN `$VLEVELID` VARCHAR(10)
        // )";
        $sql = "call lap_rekap_penerimaan(
            '$JENIS_BBM',
            '$BULAN' ,
            '$TAHUN' ,
            '$VLEVEL_REGIONAL',
            '$VLEVELID'
        )";
        // $sql = "call lap_rekap_penerimaan(
        //     'BIO',
        //     '12',
        //     '2017',
        //     'Regional',
        //     '04'
        // )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function testGetDataModel($data)
    {
        $sql = "call lap_rekap_penerimaan(
            'BIO',
            '12',
            '2017',
            'Regional',
            '04'
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
        $bulan    = $data['BULAN'];
        $tahun    = $data['TAHUN'];
        // lap_detail_penerimaan(
        //     idbbm, bulan, tahun, kodeunit
        //     )
        $sql      = "call lap_detail_penerimaan(
            '$idBBM',
            '$bulan',
            '$tahun',
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
