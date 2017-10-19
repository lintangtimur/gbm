<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class laccess {

    public function __construct() {
        
    }

    private $role;

    private function otoritas_data($key) {
        $CI = &get_instance();
        $CI->db->from('M_OTORITAS_MENU a');
        $CI->db->join('M_MENU b', 'a.MENU_ID = b.MENU_ID');
        $CI->db->where_condition($key);
        return $CI->db->get();
    }

    public function check($list_modul = array()) {
        $CI = &get_instance();

        $roles_id = $CI->session->userdata('roles_id');
		

        if (count($list_modul) == 0) {
            $segment1 = $CI->uri->segment(1);
            $segment2 = $CI->uri->segment(2);

            $url = $segment1;
            if ($segment2)
                $url .= '/' . $segment2;

            $roles = $this->otoritas_data(array('a.ROLES_ID' => $roles_id, "b.MENU_URL = '" . strtolower($url) . "'" => null));
			
            if ($roles->num_rows() > 0) {
                $otoritas = $roles->row();
                $this->role[$url] = array(
                    'view' => $otoritas->IS_VIEW,
                    'add' => $otoritas->IS_ADD,
                    'edit' => $otoritas->IS_EDIT,
                    'delete' => $otoritas->IS_DELETE,
                    'approve' => $otoritas->IS_APPROVE
                );
            } else {
                redirect('dashboard');
                exit;
            }
        } else {
            foreach ($list_modul as $list) {
                $url = $list;

                $roles = $this->otoritas_data(array('a.ROLES_ID' => $roles_id, 'b.MENU_URL' => $url));
                if ($roles->num_rows() > 0) {
                    $otoritas = $roles->row();
                    $this->role[$url] = array(
                       'view' => $otoritas->IS_VIEW,
						'add' => $otoritas->IS_ADD,
						'edit' => $otoritas->IS_EDIT,
						'delete' => $otoritas->IS_DELETE,
						'approve' => $otoritas->IS_APPROVE
                    );
                }
            }
        }
    }

    public function otoritas($id = '', $redirect = false, $modul = '') {
        $CI = &get_instance();

        if (!empty($id)) {

            if (empty($modul)) {
                $segment1 = $CI->uri->segment(1);
                $segment2 = $CI->uri->segment(2);
                $url = $segment1;
                if ($segment2)
                    $url .= '/' . $segment2;
            } else {
                $url = $modul;
            }
			
            if (isset($this->role[$url][$id]) && $this->role[$url][$id] == 't') {
                $otoritas = true;
            } else {
                $otoritas = false;
            }
        } else {
            $otoritas = false;
        }

        if ($otoritas) {
            return true;
        } else {
            if ($redirect) {
                $this->redirect();
            } else {
                return false;
            }
        }
    }

    public function redirect() {
        redirect('dashboard');
    }

}
