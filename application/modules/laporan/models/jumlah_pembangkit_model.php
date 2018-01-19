<?php


class jumlah_pembangkit_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testPembangkit()
    {
        $sql = "call lap_rekap_pembangkit(
            'Regional',
            '04'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getDataPembangkit($data)
    {
        $regional = $data['regional'];
        $levelId  = $data['level'];
        $sql      = "call lap_rekap_pembangkit(
        '$regional',
        '$levelId'
        )";
        $query = $this->db->query($sql);

        return $query->result();
    }
}
