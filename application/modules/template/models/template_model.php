<?php

/**
 * @module User Management
 */
class template_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private $_table1 = 'M_OTORITAS_MENU';
    private $_table2 = 'M_MENU';
    private $_table  = 'SETTING';

    public function data_menu($key = '')
    {
        $this->db->from($this->_table1);
        $this->db->join($this->_table2, "{$this->_table2}.MENU_ID = {$this->_table1}.MENU_ID");
        $this->db->where_condition(array("{$this->_table1}.ROLES_ID" => $key));
        $this->db->order_by($this->_table2 . '.MENU_URUTAN');

        // print_r($this->db->get()->result());
        // die;
        return $this->db;
    }

    public function parameter()
    {
        $this->db->from($this->_table);
        $param = $this->db->get();

        return $param;//->row();
    }

    public function get_notif_kirim()
    {
        $user  = $this->session->userdata('user_name');
        $jenis = $_POST['jenis'];

        if (strtoupper($jenis) == 'KIRIM') {
            $q="CALL GET_NOTIF_KIRIM ('$user') ";
        } else {
            $q="CALL GET_NOTIFIKASI ('$user') ";
        }

        $query = $this->db->query($q)->result();
        $this->db->close();

        return $query;
    }

    public function get_notif()
    {
        $SLOC          = $_POST['SLOC'];
        $TGL_PENGAKUAN = $_POST['TGL_PENGAKUAN'];

        $sql   ="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 4','$PARAM')";
        $query = $this->db->query($sql);

        $query = $this->db->query($q)->result();
        $this->db->close();

        return $query;
    }
}

/* End of file tm_menu.php */
/* Location: ./application/modules/user_management/models/tm_menu.php */
