<?php


class pemakaian_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getPemakaian by array
     * @param  array $data passing from controller
     * @return mixed
     */
    public function getPemakaian(array $data)
    {
        $jenisbbm   = $data['jenisbbm'];
        $bulan      = $data['bulan'];
        $tahun      = $data['tahun'];
        $idRegional = $data['idRegional'];
        $vlevelId   = $data['vlevelId'];

        $sql = "call lap_rekap_pemakaian(
            '$jenisbbm',
            '$bulan',
            '$tahun',
            '$idRegional',
            '$vlevelId'
        )";
        $query = $this->db->query($sql);

        return $query->result();
    }

    /**
     * get pemakaian detail usage
     * @param  array $data data from controller
     * @return mixed
     */
    public function getPemakaianDetail($data)
    {
        $idbbm    = $data['detail_id_bbm'];
        $kodeunit = $data['detail_kode_unit'];
        $bulan    = $data['detail_bulan'];
        $tahun    = $data['detail_tahun'];

        // lap_detail_pemakaian(
        //     idbbm, bulan, tahun, kodeunit
        //     )
        $sql = "call lap_detail_pemakaian(
            '$idbbm',
            '$bulan',
            '$tahun',
            '$kodeunit'
            )";
        //

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function testgetPemakaianDetail()
    {
        $sql = "call lap_detail_pemakaian(
            '003',
            '12',
            '2017',
            '3040'
            )";

        $query = $this->db->query($sql);

        return $query->result();
    }
}
