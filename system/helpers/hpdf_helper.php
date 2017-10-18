<?php

/**
 * Description of hpdf
 *
 */
define('_MPDF_PROGRBAR_TITLE', 'Cetak PDF');
define('_MPDF_PROGRBAR_HEADING', 'Proses cetak PDF sedang berlangsung, silahkan tunggu...');
define('_MPDF_URI', base_url() . 'plugin/mpdf/');

require_once FCPATH . '/assets/plugin/mpdf/mpdf.php';

class hpdf extends mPDF {

    private $judul;
    private $content;

    public function __construct($page = 'A4') {
        parent::mPDF('utf-8', $page);
        $this->judul = '';
        $this->content = '';
    }

    public function html($html = '') {
        $this->content .= $html;
    }

    public function judul($html = '') {
        $this->judul = '<div class="box-kop">' . $html . '</div>';
    }

    public function cetak() {
        $this->cacheTables = true;
        $this->packTableData = true; 

        $this->StartProgressBarOutput(2);
        $this->SetHeader(NAMA_KLIENT . ' || ');
        $this->SetFooter(NAMA_APLIKASI . ' || {PAGENO}');
        
        // Style
        $stylesheet = file_get_contents(FCPATH . '/assets/css/laporan.css');
        $this->WriteHTML($stylesheet, 1);

        // Content
        $this->WriteHTML($this->cek_kutip($this->judul));
        $this->WriteHTML($this->cek_kutip($this->content));
        $this->Output();
        exit;
    }

    public function cek_kutip($html = '') {
        return str_replace("'", '"', $html);
    }

}

/* End of file hpdf_helper.php */
/* Location: ./application/helpers/hpdf_helper.php */
