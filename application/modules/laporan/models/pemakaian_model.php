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
        // $bulan      = $data['bulan'];
        // $tahun      = $data['tahun'];
        $idRegional = $data['idRegional'];
        $vlevelId   = $data['vlevelId'];
        $TGLAWAL    = $data['TGLAWAL'];
        $TGLAKHIR   = $data['TGLAKHIR'];

        // $sql = "call lap_rekap_pemakaian(
        //     '$jenisbbm',
        //     '$bulan',
        //     '$tahun',
        //     '$idRegional',
        //     '$vlevelId'
        // )";

        $sql = "call lap_rekap_pemakaian(
            '$jenisbbm',
            '$TGLAWAL' ,
            '$TGLAKHIR' ,
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
        $idbbm    = $data['ID_BBM'];
        $kodeunit = $data['KODE_UNIT'];
        // $bulan    = $data['detail_bulan'];
        // $tahun    = $data['detail_tahun'];
        $tglAwal  = $data['TGL_AWAL'];
        $tglAkhir = $data['TGL_AKHIR'];

        // lap_detail_pemakaian(
        //     idbbm, bulan, tahun, kodeunit
        //     )
        $sql = "call lap_detail_pemakaian(
            '$idbbm',
            '$tglAwal',
            '$tglAkhir',
            '$kodeunit'
            )";
        //

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function testDetailPemakaian()
    {
        $sql = "call lap_detail_pemakaian(
            '001',
            '05012018',
            '08012018',
            '06'
            )";

        $query = $this->db->query($sql);

        return $query->result();
    }
}
