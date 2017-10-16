<?php

/**
 * @package Login
 * @modul User
 */
class setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = 'setting';

   
    public function data() {
        $this->db->from($this->_table1);
        
        return $this->db;
    }

    public function update($insert=array())
    {
        
        foreach ($insert as $key => $value)
        {
                    $this->db->trans_begin();
                    $q=$this -> db -> where("setting", $key) -> get($this->_table1);
                                if ($q->num_rows()>0)
                                {
                                   
                                        $this -> db -> where('setting', $key);
                                        $update = array('value' => $value);
                                        $this -> db -> update($this->_table1, $update);
                                    
                
                                }
                                else
                                {
                                    $insert_data = array(
                                        'setting' => $key,
                                        'value' => $value
                                    );
                                    
                                    
                                    $this -> db -> insert($this->_table1, $insert_data);
                                }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        
                    } else {
                        $this->db->trans_commit();
                        // return true;
                    }
        
        }
        return $this->db->trans_status();
    }

}

/* End of file user.php */
/* Location: ./application/modules/login/models/user.php */