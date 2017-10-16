<?php

/**
 * Description of MY_Form_validation
 *
 */
class MY_Form_validation extends CI_Form_validation {

    public function run($module = '', $group = '') {
        (is_object($module)) AND $this->CI = & $module;
        return parent::run($group);
    }

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */