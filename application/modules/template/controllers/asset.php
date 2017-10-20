<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Template
 */
class asset extends MX_Controller {

    private $path_asset;
    private $favicon;
    private $plugin_list = array();
    private $temp_plugin = array();
    private $list_plugin_js = array();
    private $list_plugin_css = array();
    private $list_js = array();
    private $list_css = array();

    public function __construct() {
        parent::__construct();
        $this->config();
    }

    private function config() {
        $this->path_asset = base_url() . "assets/";

        /*
         * Daftar Plugin
         * Format untuk mendaftarkan plugin
         * array( 
         * 	  'nama_plugin' => array(
         * 			'js' => array(
         * 				'nama_file_js1',
         * 				'nama_file_js2'
         * 			),
         * 			'css' => array(
         * 				'nama_file_css1',
         * 				'nama_file_css2'
         * 			)
         * 	   )
         * )
         */
        $this->plugin_list = array(
            'jquery' => array(
                'js' => array('jquery-1.10.2')
            ),
            'jquery.ui' => array(
                'js' => array('jquery-ui-1.10.3')
            ),
            'bootstrap' => array(
                'js' => array(
                    'bootstrap',
                    'library/bootstrap-datetimepicker',
                    'library/bootstrap-timepicker',
                    'library/bootstrap-datepicker',
                    'library/bootstrap-fileupload'
                ),
                'css' => array('bootstrap', 'bootstrap-responsive')
            ),
            'collapsible' => array(
                'js' => array('library/jquery.collapsible.min')
            ),
            'mCustomScrollbar' => array(
                'js' => array('library/jquery.mCustomScrollbar.min', '')
            ),
            'mousewheel' => array(
                'js' => array('library/jquery.mousewheel.min')
            ),
            'uniform' => array(
                'js' => array('library/jquery.uniform.min')
            ),
            'sparkline' => array(
                'js' => array('library/jquery.sparkline.min')
            ),
            'chosen' => array(
                'js' => array('library/chosen.jquery.min')
            ),
            'easytabs' => array(
                'js' => array('library/jquery.easytabs')
            ),
            'flot' => array(
                'js' => array(
                    'library/flot/excanvas.min',
                    'library/flot/jquery.flot',
                    'library/flot/jquery.flot.pie',
                    'library/flot/jquery.flot.selection',
                    'library/flot/jquery.flot.resize',
                    'library/flot/jquery.flot.orderBars'
                )
            ),
            'maps' => array(
                'js' => array(
                    'library/maps/jquery.vmap',
                    'library/maps/maps/jquery.vmap.world',
                    'library/maps/data/jquery.vmap.sampledata'
                )
            ),
            'autosize' => array(
                'js' => array('library/jquery.autosize-min')
            ),
            'charCount' => array(
                'js' => array('library/charCount')
            ),
            'minicolors' => array(
                'js' => array('library/jquery.minicolors')
            ),
            'tagsinput' => array(
                'js' => array('library/jquery.tagsinput')
            ),
            'fullcalendar' => array(
                'js' => array('library/fullcalendar.min', 'calendar', 'custom/calender')
            ),
            'footable' => array(
                'js' => array('library/footable/footable', 'library/footable/data-generator')
            ),
            'inputmask' => array(
                'js' => array('library/jquery.inputmask.bundle')
            ),
            'flatpoint_core' => array(
                'js' => array('flatpoint_core', 'forms')
            ),
            'tinymce' => array(
                'js' => array('library/tinymce/tinymce.min')
            ),
            'crud' => array(
					'js' => array('jquery.form', 'library/bootstrap-modal', 'library/bootstrap-modalmanager', 'library/jquery.easyui.pagination', 'custom/crud','custom/custom'),
                'css' => array('library/easyui/themes/default/pagination')
            ),
            'msgbox' => array(
                'js' => array('library/bootbox/jquery.bootbox')
            ),
            'canvasjs' => array(
                'js' => array('canvasjs.min')
            ),
            'select2' => array(
                'js' => array('library/select2/select2.min'),
                'css' => array('library/select2/select2')
            ),
            'treegrid' => array(
                'js' => array('treegrid'),
                'css' => array('library/treegrid')
            ),
            'aciTree' => array(
                'js' => array('library/aciTrese/jquery.min', 'library/aciTree/jquery.aciPlugin.min', 'library/aciTree/jquery.aciTree.dom', 'library/aciTree/jquery.aciTree.core', 'library/aciTree/jquery.aciTree.selectable', 'library/aciTree/jquery.aciTree.checkbox', 'library/aciTree/jquery.aciTree.radio'),
                'css' => array('library/aciTree/aciTree', 'library/aciTree/demo')
            ),
            'highchart' => array(
                'js' => array('library/highchart/js/highcharts', 'library/highchart/js/modules/exporting')
            ),
			'raty' => array(
				'js' => array('library/raty/jquery.raty','library/raty/jquery.raty.min'),
				'css' => array('library/raty/demo')
			),
			'tooltips' => array(
				'js' => array('library/tooltips/jquery.tools.min')
					),
			'upload' => array(
				'js' => array('library/file_upload/jquery.uploadfile','library/file_upload/jquery.uploadfile.min'),
				'css' => array('library/file_upload/uploadfile')
					),
			'hadi' => array(
				'js' => array('custom/hadi')
			        ),
            "bootstrap-rakhmat" => array(
                'css'=> array('bootstrap-rakhmat/bootstrap'),
                'js'=> array('bootstrap-rakhmat/bootstrap')
            ),
            "jui" => array(
            'css'=> array('library/jui/jquery-ui'),
            'js'=> array('library/jui/jquery-ui')
            ),
            "file-upload" => array(
            'js'=> array('library/file-upload/dropify'),
            'css'=> array('library/file-upload/dropify')
            ),
            "format_number" => array(
            'js'=> array('cf/jquery.inputmask.bundle')
            )
	   );
    }
	

    private function reg_plugin($plugin_name) {
        /*
         * Me'looping daftar plugin untuk mencocokan nama plugin yang dipanggil
         */
        $alpha = 0;
        foreach ($this->plugin_list as $key => $value) {
            if (!in_array($key, $this->temp_plugin)) {
                if ($key == $plugin_name) {
                    /*
                     * Mendaftarkan file javascript jika ada yang disertakan kedalam plugin
                     */
                    if (isset($value['js'])) {
                        $idx = 0;
                        foreach ($value['js'] as $js) {
                            if (!empty($js)) {
                                $index = str_pad($alpha, 4, "0", STR_PAD_LEFT) . str_pad($idx, 4, "0", STR_PAD_LEFT);
                                $this->list_plugin_js[$index] = $js . '.js';
                                $idx++;
                            }
                        }
                    }

                    /*
                     * Mendaftarkan file css jika ada yang disertakan kedalam plugin
                     */
                    if (isset($value['css'])) {
                        $idx = 0;
                        foreach ($value['css'] as $css) {
                            if (!empty($css)) {
                                $index = str_pad($alpha, 4, "0", STR_PAD_LEFT) . str_pad($idx, 4, "0", STR_PAD_LEFT);
                                $this->list_plugin_css[$index] = $css . '.css';
                                $idx++;
                            }
                        }
                    }

                    /*
                     * Jika nama plugin yang dipanggil sama dengan index name daftar plugin proses looping dihentikan
                     */
                    break;
                }
                $alpha++;
            } else {
                /*
                 * Jika nama plugin sudah terdaftar
                 */
                break;
            }
        }
    }

    public function set_plugin($plugin = array()) {
        if (is_array($plugin)) {
            foreach ($plugin as $value) {
                $this->reg_plugin($value);
            }
        } else {
            if ($plugin == 'all') {
                foreach ($this->plugin_list as $key => $value) {
                    $this->reg_plugin($key);
                }
            } else {
                $this->reg_plugin($plugin);
            }
        }
    }

    public function get_js() {
        $js_path = $this->path_asset . "js/";
        $list = "";

        $list_plugin = $this->list_plugin_js;
        ksort($list_plugin);
        foreach ($list_plugin as $value) {
            $list .= "<script src='" . $js_path . $value . "'></script>";
        }

        $list_js = $this->list_js;
        ksort($list_js);
        foreach ($list_js as $value) {
            $list .= "<script src='" . $js_path . $value . "'></script>";
        }

        return "<!-- Begin : Javacript -->" . $list . "<!-- End : Javacript -->";
    }

    public function get_css() {
        $css_path = $this->path_asset . "css/";
        $list = "";

        $list_plugin = $this->list_plugin_css;
        ksort($list_plugin);
        foreach ($list_plugin as $value) {
            $list .= "<link href='" . $css_path . $value . "' rel='stylesheet'>";
        }

        $list_css = $this->list_css;
        ksort($list_css);
        foreach ($list_css as $value) {
            $list .= "<link href='" . $css_path . $value . "' rel='stylesheet'>";
        }

        return "<!-- Begin : CSS -->" . $list . "<!-- End : CSS -->";
    }

    public function set_css($css = array()) {
        if (is_array($css)) {
            foreach ($css as $value) {
                $this->list_css[] = $value . '.css';
            }
        } else {
            $this->list_css[] = $css . '.css';
        }
    }

    public function set_js($js = array()) {
        if (is_array($js)) {
            foreach ($js as $value) {
                $this->list_js[] = $value . '.js';
            }
        } else {
            $this->list_js[] = $js . '.js';
        }
    }

    public function set_favicon($favicon) {
        $this->favicon = $favicon;
    }

    public function get_favicon() {
        return "<link rel='shortcut icon' href='" . $this->path_asset . $this->favicon . "'>";
    }

    public function image($name, $attribut = '') {
        return "<img src='" . $this->path_asset . 'img/' . $name . "' " . $attribut . "/>";
    }

}

/* End of file asset.php */
/* Location: ./application/modules/template/controllers/asset.php */
