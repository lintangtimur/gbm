<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class laccess {

    public function __construct() {
        
    }

    private $role;

    private function otoritas_data($key) {
        $CI = &get_instance();
        $CI->db->from('m_otoritas_menu a');
        $CI->db->join('m_menu b', 'a.menu_id = b.menu_id');
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

            $roles = $this->otoritas_data(array('a.roles_id' => $roles_id, "b.menu_url = '" . strtolower($url) . "'" => null));
			
            if ($roles->num_rows() > 0) {
                $otoritas = $roles->row();
                $this->role[$url] = array(
                    'view' => $otoritas->is_view,
                    'add' => $otoritas->is_add,
                    'edit' => $otoritas->is_edit,
                    'delete' => $otoritas->is_delete,
                    'import' => $otoritas->is_import,
                    'export' => $otoritas->is_export
                );
            } else {
                redirect('dashboard');
                exit;
            }
        } else {
            foreach ($list_modul as $list) {
                $url = $list;

                $roles = $this->otoritas_data(array('a.roles_id' => $roles_id, 'b.menu_url' => $url));
                if ($roles->num_rows() > 0) {
                    $otoritas = $roles->row();
                    $this->role[$url] = array(
                        'view' => $otoritas->is_view,
                        'add' => $otoritas->is_add,
                        'edit' => $otoritas->is_edit,
                        'delete' => $otoritas->is_delete,
                        'approve' => $otoritas->is_approve,
                        'import' => $otoritas->is_import,
                        'export' => $otoritas->is_export
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
