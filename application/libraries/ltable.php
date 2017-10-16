<?php

class ltable {

    private $id;
    private $data;
    private $content;
    private $total;
    private $style;
    private $link;
    private $header;
    private $title;
    private $limit;
    private $offset;
    private $page;
    private $numbering;
    private $width_colom;
    private $align;
    private $valign;
    private $message;
    private $cellspacing;
    private $cellpadding;
    private $border;
    private $info_cell;
    private $jumlah_kolom;
    private $drildown;
    private $ordering;
    private $ordering_key;


    public function __construct() {
        $this->CI = &get_instance();
    }

    private function config($dataTable) {
        if (!isset($dataTable->id))
            $dataTable->id = '';
        if (!isset($dataTable->content))
            $dataTable->content = array();
        if (!isset($dataTable->total))
            $dataTable->total = 0;
        if (!isset($dataTable->style))
            $dataTable->style = "";
        if (!isset($dataTable->link))
            $dataTable->link = array();
        if (!isset($dataTable->header))
            $dataTable->header = array();
        if (!isset($dataTable->title))
            $dataTable->title = array();
        if (!isset($dataTable->limit))
            $dataTable->limit = 10;
        if (!isset($dataTable->page))
            $dataTable->page = 0;
        if (!isset($dataTable->model))
            $dataTable->model = '';
        if (!isset($dataTable->numbering))
            $dataTable->numbering = true;
        if (!isset($dataTable->width_colom))
            $dataTable->width_colom = array();
        if (!isset($dataTable->align))
            $dataTable->align = array();
        if (!isset($dataTable->valign))
            $dataTable->valign = array();
        if (!isset($dataTable->message))
            $dataTable->message = 'Data tidak ditemukan';
        if (!isset($dataTable->cellspacing))
            $dataTable->cellspacing = 0;
        if (!isset($dataTable->cellpadding))
            $dataTable->cellpadding = 0;
        if (!isset($dataTable->border))
            $dataTable->border = 0;
        if (!isset($dataTable->jumlah_kolom))
            $dataTable->jumlah_kolom = 1;
        if (!isset($dataTable->info_cell))
            $dataTable->info_cell = true;
        if (!isset($dataTable->drildown))
            $dataTable->drildown = FALSE;
        if (!isset($dataTable->ordering))
            $dataTable->ordering = FALSE;
        if (!isset($dataTable->ordering_key))
            $dataTable->ordering_key = '';

        $this->id = $dataTable->id;
        $this->content = $dataTable->content;
        $this->total = $dataTable->total;
        $this->jumlah_kolom = $dataTable->jumlah_kolom;
        $this->style = $dataTable->style;
        $this->link = $dataTable->link;
        $this->header = $dataTable->header;
        $this->title = $dataTable->title;
        $this->limit = $dataTable->limit;
        $this->page = $dataTable->page;
        $this->offset = ($dataTable->page * $dataTable->limit) - $dataTable->limit;
        $this->model = $dataTable->model;
        $this->numbering = $dataTable->numbering;
        $this->width_colom = $dataTable->width_colom;
        $this->align = $dataTable->align;
        $this->valign = $dataTable->valign;
        $this->message = $dataTable->message;
        $this->cellspacing = $dataTable->cellspacing;
        $this->cellpadding = $dataTable->cellpadding;
        $this->border = $dataTable->border;
        $this->info_cell = $dataTable->info_cell;
        $this->drildown = $dataTable->drildown;
        $this->ordering = $dataTable->ordering;
        $this->ordering_key = $dataTable->ordering_key;     
    }

    public function generate($config, $type = 'html', $encode = 'json') {
        // Set Config
        $this->config($config);

        if ($type == 'js') {
            return $this->type_js($encode);
        } else if ($type == 'html') {
            return $this->type_html($encode);
        } else {
            return "Type : " . $type . " tidak ditemukan.";
        }
    }

    private function get_data() {
        $model = $this->model;
        if (!empty($model)) {
            list($model_name, $function_name) = explode('->', $model);
            $m = $this->CI->{$model_name};

            $m->limit = $this->limit;
            $m->offset = $this->offset;
            return $m->{$function_name}();
        } else {
            return false;
        }
    }

    private function type_html($encode) {        
        $total = 0;
        $data = $this->get_data();
        if ($data) {
            $total = $data['total'];
            $this->content = $data['rows'];
        }

        $table = $this->create_header();
        $table .= $this->create_content();

        return array('table' => $table, 'total' => $total, 'limit' => $this->limit);
    }

    function create_header() {
        $row = $col = 0;
        $isFirst = $this->numbering;
        $rowHeader = count($this->header);
        $style = '';
        if (!empty($this->style))
            $style = "class = '$this->style'";
        $id = '';
        if (!empty($this->id))
            $id = "id='$this->id'";
        $stringData = "<table $id $style border='$this->border' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding'><thead>";
        if ($rowHeader > 0) {
            foreach ($this->header as $dataHeader) {
                $col = count($dataHeader);
                $stringData .= "<tr>";
                if ($isFirst) {
                    $stringData .= "<th class='cell-first' rowspan='$rowHeader'>No.</th>";
                    $isFirst = false;
                }
                $colspan = 1;
                $rowspan = 2;
                for ($index = 0; $index < $col; $index+=3) {

                    $cell_first = '';
                    if ($index == 0 && !$this->numbering)
                        $cell_first = "class='cell-first'";

                    $stringData .= "<th $cell_first colspan='$dataHeader[$colspan]' rowspan='$dataHeader[$rowspan]'>";
                    // $stringData .= "<th $cell_first >";
                    $stringData .= "$dataHeader[$index]";
                    $stringData .= "</th>";
                    $colspan += 3;
                    $rowspan += 3;
                }
                $stringData .= "</tr>";
            }
        }
        $stringData .= "</thead>";
        return $stringData;
    }

    function create_content() {
        $content = '';
        $kolom = $this->jumlah_kolom;
        $nomor = ($this->page - 1) * $this->limit;
        $data = $this->content;
        $content.='<tbody>';

        if (count($data) > 0) {

            foreach ($data as $row) {
                $nomor++;

                $pk = '';
                if (isset($row['primary_key'])) {
                    $pk = $row['primary_key'];
                    unset($row['primary_key']);
                }

                if (!empty($pk)) {
                    $content .= '<tr id="content_row_' . $pk . '">';
                } else {
                    $content .= '<tr>';
                }

                $jml_colom = 0;

                // Jika akan menampilkan penomoran
                if ($this->numbering) {
                    $jml_colom++;
                    $content .= '<td class="cell-first" style="text-align:center;">' . $nomor . '</td>';
                }

                $index = 0;
                foreach ($row as $key => $value) {
                    $jml_colom++;

                    $align = (isset($this->align[$key])) ? 'align="' . $this->align[$key] . '"' : '';
                    $valign = (isset($this->valign[$key])) ? 'valign="' . $this->valign[$key] . '"' : '';
                    $width = (isset($this->width_colom[$key])) ? 'width="' . $this->width_colom[$key] . '"' : '';

                    $cell_first = '';
                    if ($index == 0 && !$this->numbering)
                        $cell_first = 'class="cell-first"';

                    $cell = '';
                    if ($this->info_cell) {
                        $cell = 'cell="' . $key . '" ';
                    }

                    $content .= '<td ' . $cell_first . ' ' . $cell . ' ' . $align . ' ' . $valign . ' ' . $width . '>';

                    if (isset($this->link[$key])) {
                        $content .= '<a href="javascript:void(0)" id="drildown_key_' . $this->id . '_' . $pk . '" rel="' . $pk . '" data-source="' . $this->link[$key] . '" parent="' . $this->id . '" onclick="drildown(this.id)">' . $value . '</a>';
                    } else {
                        $content .= $value;
                    }

                    $content .= '</td>';
                    $index++;
                }

                $content .= '</tr>';

                if (!empty($pk))
                    $content .= '<tr id="drildown_row_' . $this->id . '_' . $pk . '" status="close" style="display:none;"><td style="background: #fff;" colspan="' . $jml_colom . '">&nbsp;</td></tr>';
            }
        } else {
            $content .= '<tr><td class="cell-first" align="center" colspan="' . $kolom . '">' . $this->message . '</td></tr>';
        }
        $content.='</tbody>';

        $content .= '</table>';

        return $content;
    }

    private function type_js($encode) {
        $table = array();

        $table['id'] = $this->id;
        $table['style'] = $this->style;
        $table['align'] = $this->align;
        $table['valign'] = $this->valign;
        $table['jumlah_kolom'] = $this->jumlah_kolom;
        $table['message'] = $this->message;
        $table['limit'] = $this->limit;
        $table['page'] = $this->page;
        $table['total'] = $this->total;
        $table['header'] = $this->header;
        $table['content'] = $this->content;
        $table['drildown'] = $this->drildown;
        $table['ordering'] = $this->ordering;
        $table['ordering_key'] = $this->ordering_key;

        return $this->encode_js($table);
    }

    public function encode_js($data) {     
        header("Content-Type: application/javascript");
        $result = json_encode($data, true);
        $obj = "while(1){function xhr_result(w,s,p){return {$result}}; break;}";
        return $obj;
    }

}

/* End of file ltable.php */
/* Location: ./application/libraries/ltable.php */