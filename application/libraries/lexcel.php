<?php

require_once FCPATH . 'assets/plugin/phpexcel/PHPExcel.php';

class lexcel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

    public function page_setup($sheet, $size = '', $orientation = '') {
        $sheet->getHeaderFooter()->setOddHeader('&L&"-,Bold Italic"' . NAMA_KLIENT);
        $sheet->getHeaderFooter()->setOddFooter('&L&"-,Bold Italic"' . NAMA_APLIKASI . ' &R&I&P');
        $sheet->getHeaderFooter()->setAlignWithMargins(true);
        $sheet->getPageSetup()->setOrientation($orientation);
        $sheet->getPageSetup()->setPaperSize($size);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getDefaultRowDimension()->setRowHeight(15);
    }

    public function margin($sheet, $header = 0.3, $footer = 0.3, $top = 0.5, $right = 0.5, $left = 0.5, $bottom = 0.5) {
        $sheet->getPageMargins()->setHeader($header);
        $sheet->getPageMargins()->setFooter($footer);
        $sheet->getPageMargins()->setTop($top);
        $sheet->getPageMargins()->setRight($right);
        $sheet->getPageMargins()->setLeft($left);
        $sheet->getPageMargins()->setBottom($bottom);
    }

    public static function simpan($nama_file, $content, $type = 'Excel5') {
        if ($type == 'Excel2007') {
            $type = 'Excel2007';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $nama_file . '.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $type = 'Excel5';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $nama_file . '.xls"');
            header('Cache-Control: max-age=0');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($content, $type);
        $objWriter->save('php://output');
        exit;
    }

    public static function generate_table($cell, $file_name = '', $type = 'Excel5') {
        $excel = new hexcel();
        $row_start = 1;

        $index_kolom = 'A';
        $first_kolom = $index_kolom;
        $last_kolom = $index_kolom;
        for ($i = 1; $i <= $cell->kolom; $i++) {
            $last_kolom = $index_kolom;
            $index_kolom++;
        }

        // Defult Border
        $defaultBorder = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        );

        $excel->getDefaultStyle()->getFont()->setName('Arial');
        $excel->getDefaultStyle()->getFont()->setSize(8);
        $excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        // Set Active Sheet 1
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();

        // Seting Halaman
        $excel->page_setup($sheet, PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4, PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->margin($sheet, 0.3, 0.3, 0.5, 0.5, 0.5, 0.5);

        // Judul
        $sheet->setCellValue($first_kolom . $row_start, $cell->judul);
        $sheet->getRowDimension(1)->setRowHeight(27);
        $sheet->getStyle($first_kolom . $row_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($first_kolom . $row_start)->applyFromArray(array('font' => array('bold' => true, 'size' => 11)));
        $sheet->mergeCells($first_kolom . $row_start . ':' . $last_kolom . $row_start);

        // Generate Header
        $row_start++;
        $header_start = $row_start - 1;
        foreach ($cell->header as $head) {
            $header_start++;
            $coll_head = $first_kolom;
            foreach ($head as $key => $val) {
                $sheet->setCellValue($coll_head . $header_start, $key);
                $sheet->getColumnDimension($coll_head)->setWidth($val);
                $coll_head++;
            }
        }

        $sheet->getStyle($first_kolom . $row_start . ':' . $last_kolom . $header_start)->applyFromArray(array('font' => array('bold' => true), 'borders' => array('inside' => $defaultBorder, 'outline' => $defaultBorder)));
        $sheet->getStyle($first_kolom . $row_start . ':' . $last_kolom . $header_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($row_start, $header_start);

        // Generate Content
        $content_start = $header_start;
        $idx = $content_start;
        if ($cell->data['total'] > 0) {
            foreach ($cell->data['rows'] as $content) {
                $idx++;
                $coll_content = $first_kolom;
                foreach ($content as $key => $val) {
                    $sheet->setCellValueExplicit($coll_content . $idx, $val, PHPExcel_Cell_DataType::TYPE_STRING);
                    $align = isset($cell->align[$key]) ? self::style_aligement($cell->align[$key]) : PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                    $sheet->getStyle($coll_content . $idx)->getAlignment()->setHorizontal($align);
                    $coll_content++;
                }
            }
            $sheet->getStyle($first_kolom . $content_start . ':' . $last_kolom . $idx)->applyFromArray(array('borders' => array('inside' => $defaultBorder, 'outline' => $defaultBorder)));
        } else {
            $content_start++;
            $sheet->setCellValue($first_kolom . $content_start, 'Data tidak ditemukan');
            $sheet->mergeCells($first_kolom . $content_start . ':' . $last_kolom . $content_start);
            $sheet->getStyle($first_kolom . $content_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($first_kolom . $content_start . ':' . $last_kolom . $content_start)->applyFromArray(array('borders' => array('inside' => $defaultBorder, 'outline' => $defaultBorder)));
        }

        // Proses Generate Excel
        self::simpan($file_name, $excel, $type);
    }

    public static function style_aligement($align) {
        switch ($align) {
            case 'center':
                return PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                break;
            case 'right':
                return PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                break;
            default:
                return PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                break;
        }
    }

}

/* End of file lexcel.php */
/* Location: ./application/libraries/lexcel.php */