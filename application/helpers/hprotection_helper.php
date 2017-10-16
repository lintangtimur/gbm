<?php

/**
 * Description of protection_helper
 */
class hprotection {

    public static function login($status = true) {
        if ($status) {
            if (!self::status_login()) {
                redirect('login');
                exit;
            }
        } else {
            if (self::status_login()) {
                redirect('dashboards');
                exit;
            }
        }
    }

    public static function status_login() {
        $ci = &get_instance();
        return $ci->session->userdata('login_status');
    }

}

/* End of file hprotection_helper.php */
/* Location: ./application/helpers/hprotection_helper.php */
