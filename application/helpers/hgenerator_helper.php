<?php

/**
 * Description of generator_helper
 */
class hgenerator {

    private static $status_user = array('1' => 'Aktif', '0' => 'Tidak Aktif');

    public static function status_user($kode = '', $default = '--Pilih Status--', $key = '') {
        if (!empty($kode)) {
            return isset(self::$status_user[$kode]) ? self::$status_user[$kode] : '';
        } else {
            if (!empty($default)) {
                return self::merge_array(array($key => $default), self::$status_user);
            } else {
                return self::$status_user;
            }
        }
    }
	
    public static function font_awesome($kode = '', $default = '--Pilih Icon--', $key = '') {
        $font_list = array();
        $font_source = FCPATH . 'assets/css/icon/icon-list.txt';

        if (file_exists($font_source)) {
            $font_content = file_get_contents($font_source);
            $font_list = explode(',', $font_content);
        }

        if (empty($kode)) {
            $data = array();
            foreach ($font_list as $value) {
                $value = trim($value);
                $data[$value] = $value;
            }
            if (!empty($default)) {
                return self::merge_array(array($key => $default), $data);
            } else {
                return $data;
            }
        }
    }

    public static function render_button_group($list = array()) {
        $bg = '';
        foreach ($list as $value) {
            $bg .= '<div class="btn-group">';
            $bg .= $value;
            $bg .= '</div>';
        }
        return $bg;
    }

    public static function switch_tanggal($tanggal, $format = '') {
        if (!empty($tanggal)) {
            switch ($format) {
                case 1:
                    list($a, $b, $c) = explode('-', date('d-M-Y', strtotime($tanggal)));
                    $b = self::$nama_bulan[$b];
                    $date = $a . ' ' . $b . ' ' . $c;
                    break;

                case 2:
                    list($a, $b, $c) = explode('-', $tanggal);
                    $date = $c . '/' . $b . '/' . $a;
                    break;

                default:
                    list($a, $b, $c) = explode('-', $tanggal);
                    $date = $c . '-' . $b . '-' . $a;
                    break;
            }

            return $date;
        } else {
            return '';
        }
    }

    public static function array_to_option($array = array(), $selected = '') {
        $option = '';
        foreach ($array as $key => $value) {
            $sel = '';
            if ($key == $selected)
                $sel = 'selected="selected"';

            $option .= '<option value="' . $key . '" ' . $sel . '>' . $value . '</option>';
        }
        return $option;
    }

    public function merge_array($array1 = array(), $array2 = array()) {
        $array = array();
        foreach ($array1 as $key => $value) {
            $array[$key] = $value;
        }
        foreach ($array2 as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    public static function rupiah($number) {
        return number_format($number, 2, ',', '.');
    }

    public static function datetime_diff($str_interval = '', $start = '', $end = '') {

        $start = date('Y-m-d H:i:s', strtotime($start));
        $end = date('Y-m-d H:i:s', strtotime($end));
        $d_start = new DateTime($start);
        $d_end = new DateTime($end);
        $diff = $d_start->diff($d_end);

        $year = $diff->format('%y');
        $month = $diff->format('%m');
        $day = $diff->format('%d');
        $hour = $diff->format('%h');
        $min = $diff->format('%i');
        $sec = $diff->format('%s');

        switch ($str_interval) {
            case "y":
                $month = $month > 0 ? round($month / 12, 0) : 0;
                $day = $day > 0 ? round($day / 365, 0) : 0;
                $total = $year + $month / 12 + $day / 365;
                break;
            case "m":
                $day = $day > 0 ? round($day / 30, 0) : 0;
                $hour = $hour > 0 ? round($hour / 24, 0) : 0;
                $total = $year * 12 + $month + $day + $hour;
                break;
            case "d":
                $hour = $hour > 0 ? round($hour / 24, 0) : 0;
                $min = $min > 0 ? round($min / 60, 0) : 0;
                $total = ($year * 365) + ($month * 30) + $day + $hour + $min;
                break;
            case "h":
                $min = $min > 0 ? round($min / 60, 0) : 0;
                $total = ((($year * 365) + ($month * 30) + $day) * 24) + $hour + $min;
                break;
            case "i":
                $sec = $sec > 0 ? round($sec / 60, 0) : 0;
                $total = ((((($year * 365) + ($month * 30) + $day) * 24) + $hour) * 60) + $min + $sec;
                break;
            case "s":
                $total = ((((($year * 365) + ($month * 30) + $day) * 24 + $hour) * 60 + $min) * 60) + $sec;
                break;
        }

        if (strtotime($start) < strtotime($end))
            $total = -1 * $total;

        return $total;
    }

    public static function form_dropdown_image($name = '', $options = array(), $selected = array(), $extra = '') {
        $dropdown_print_options = array();
        $dropdown_print_options_icon = array();

        foreach ($options as $key => $value) {
            $dropdown_print_options[$key] = isset($value['title']) ? $value['title'] : '';
            $dropdown_print_options_icon[$key] = isset($value['icon']) ? $value['icon'] : '';
        }

        return form_dropdown($name, $dropdown_print_options, $selected, $extra, 'icon', $dropdown_print_options_icon);
    }

    public static function minute_to_hours($time, $format) {
        settype($time, 'integer');
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public static function switch_number($number) {
        $pecah_titik = str_replace('.', '', $number);
        list($uang, $ekor) = explode(',', $pecah_titik);
        return $uang;
    }

	public static function arr_levelgroup(){
		$arr_lvlgroup = array("-" => "-- Pilih Level Group --",
							  "0" => "Pusat",
							  "R" => "Regional",
							  "1" => "Level 1",
							  "2" => "Level 2",
							  "3" => "Level 3",
							  "4" => "Level 4");
		return $arr_lvlgroup;
	}
	
}

/* End of file hgenerator_helper.php */
/* Location: ./application/helpers/hgenerator_helper.php */
