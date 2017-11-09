<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Template
 */
class template extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // Load Modules
        $this->load->module("template/asset");

        // Load global template
        $this->load->model('template_model');

        // Set Autoload
        $this->asset->set_favicon('img/favicon.png');
        $this->asset->set_plugin(array('jquery', 'jquery.ui', 'bootstrap'));
        $this->asset->set_css(array('stylesheet', 'icon/font-awesome', 'custom'));
    }

    public function login($data = array()) {
	
		$this->asset->set_plugin(array(
            'collapsible', 'mCustomScrollbar', 'mousewheel', 'uniform', 'sparkline',
            'minicolors', 'tagsinput', 'autosize', 'chosen', 'charCount',
            'flatpoint_core', 'msgbox'
        ));
	
        // Memanggil Javascript & CSS
        $data["favicon"] = $this->asset->get_favicon();
        $data["js_header"] = $this->asset->get_js();
        $data["css_header"] = $this->asset->get_css();
		
        $dparam=$this->template_model->parameter();
		$arr_setting = array();
		foreach($dparam->result() as $row){
			
			$arr_setting[$row->SETTING]=$row->VALUE;
				
		}
        $data['app_parameter'] = $arr_setting;//$this->template_model->parameter();
        $this->load->view("login", $data);
    }

    public function admin($data = array()) {

        // Set autoload plugin
        $this->asset->set_plugin(array(
            'collapsible', 'mCustomScrollbar', 'mousewheel', 'uniform', 'sparkline',
            'minicolors', 'tagsinput', 'autosize', 'chosen', 'charCount',
            'flatpoint_core', 'msgbox'
        ));

        $this->asset->set_js('custom/clock');

        // Memanggil Javascript & CSS
        $data["favicon"] = $this->asset->get_favicon();
        $data["js_header"] = $this->asset->get_js();
        $data["css_header"] = $this->asset->get_css();

        $data['main_menu'] = $this->main_menu();
        $dparam=$this->template_model->parameter();
		$arr_setting = array();
		foreach($dparam->result() as $row){
			
			$arr_setting[$row->SETTING]=$row->VALUE;
				
		}
		
        $data['app_parameter'] = $arr_setting;

        $this->load->view("admin", $data);
    }

    private function main_menu() {
        $roles_id = $this->session->userdata('roles_id');
        $segment1 = $this->uri->segment(1);
        $segment2 = $this->uri->segment(2);

        $active_group = '';

        $record = $this->template_model->data_menu($roles_id)->get();
        $data = $record->result();
		
        $temp_menu = array();
        foreach ($data as $value) {
            $pos = '';
		
            $parent_id = $value->M_M_MENU_ID;
            $parent = !empty($parent_id) ? $parent_id : 0;

            $com_segment = $segment1 . '/' . $segment2;
            $menu_url = $value->MENU_URL;
            $explode_url = explode('/', $menu_url);
            $e1 = isset($explode_url[0]) ? $explode_url[0] : '';
            $e2 = isset($explode_url[1]) ? $explode_url[1] : '';

            if ($segment1 == $menu_url || ($segment1 == $e1 && $e1 == $e2) || $com_segment == $menu_url) {
                $active_group = $parent_id;
                $pos = 'border-color:#0072c6';
            }

            $temp_menu[$parent][] = (object) array(
                        'kd_menu' => $value->MENU_ID,
                        'kd_parent' => $parent_id,
                        'nama_menu' => $value->MENU_NAMA,
                        'url' => $value->MENU_URL,
                        'icon' => $value->MENU_ICON,
                        'pos' => $pos
            );
        }
	
        $menu = '<ul class="main">';
		
		$cuk = 0;
        if (isset($temp_menu[0])) {
            foreach ($temp_menu[0] as $group) {
                $expand = '';
                $actived = '';
				
                if ($active_group == $group->kd_menu) {
                    $expand = ' class="expand" id="current" ';
                    $actived = 'class="active navAct"';
                }
                $menu .= '<li ' . $actived . '>';
                
                if (isset($temp_menu[$group->kd_menu])) {    
                    $menu .= '  <a ' . $expand . ' style="cursor:pointer;"><i class="' . $group->icon . '"></i> ' . $group->nama_menu . '</a>';

                    $menu .= '  <ul class="sub_main">';
                    foreach ($temp_menu[$group->kd_menu] as $level1) {
                        if (isset($temp_menu[$level1->kd_menu])) {
                            $menu .= '<li><a style="color:#0072c6;font-weight:bold;"><i class="icon-menu"></i> ' . $level1->nama_menu . '</a></li>';

                            foreach ($temp_menu[$level1->kd_menu] as $level2) {

                                if (isset($temp_menu[$level2->kd_menu])) {
                                    $menu .= '<li><a style="padding-left:18px;font-weight:bold;"><i class="icon-menu"></i> ' . $level2->nama_menu . '</a></li>';

                                    foreach ($temp_menu[$level2->kd_menu] as $level3) {
                                        $menu .= '  <li><a href="' . $this->set_url($level3->url) . '" style="padding-left:30px;' . $level3->pos . '"><i class="icon-menu"></i> ' . $level3->nama_menu . ' </a></li>';
                                    }
                                } else {
                                    $menu .= '<li><a href="' . $this->set_url($level2->url) . '" style="padding-left:18px;font-weight:bold;' . $level2->pos . '"><i class="icon-menu"></i> ' . $level2->nama_menu . ' </a></li>';
                                }
                            }
                        } else {
                            $menu .= '<li><a href="' . $this->set_url($level1->url) . '" style="font-weight:bold;color:#0072c6;' . $level1->pos . '"><i class="icon-menu"></i> ' . $level1->nama_menu . '</a></li>';
                        }
                    }
                    $menu .= '  </ul>';
					
                } else {
                    $menu .= '  <a ' . $expand . ' href="' . $this->set_url($group->url) . '" style="cursor:pointer;"><i class="' . $group->icon . '"></i> ' . $group->nama_menu . '</a>';
					// break;
                }
                $menu .= '</li>';
				
            }
        }
        $menu .= '</ul>';
		
        return $menu;
    }

    private function set_url($url) {

        switch ($url) {
            case 'moodle':
                $full_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
                break;
            default:
                $full_url = base_url($url);
                break;
        }
        return $full_url;
    }

}

/* End of file template.php */
/* Location: ./application/modules/template/controllers/template.php */
