<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
use mikehaertl\wkhtmlto\Pdf;

/**
 * pemakaian
 * @author stelin
 */
class pemakaian extends MX_Controller
{
    /**
     * title
     * @var string
     */
    private $_title  = 'Pemakaian BBM';

    /**
     * limit
     * @var int
     */
    private $_limit  = 10;

    /**
     * module for model
     * @var string
     */
    private $_module = 'laporan/pemakaian';

    /**
     * load persediaan bbm model + pemakaian model
     */
    public function __construct()
    {
        parent::__construct();
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('persediaan_bbm_model', 'tbl_get');
        $this->load->model('pemakaian_model', 'tbl_pemakaian_get');
    }

    public function index()
    {
        // Load Modules
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        // $this->asset->set_plugin(array('bootstrap-rakhmat'));
        // $data['data_penerimaan'] = $this->tbl_get->getData_Model();
        $data['lv1_options']     = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options']     = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options']     = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options']     = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user == 4) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC]        = $data_lv[0]->LEVEL4;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $option_lv4;
        } elseif ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } elseif ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } elseif ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } elseif ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options']                  = $option_reg;
                $data['lv1_options']                  = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bbm']   = $this->tbl_get->option_jenisbbm();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/getData');
        // $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }

    /**
     * get pemakaian
     * @return string json encode
     */
    public function getPemakaian()
    {
        $data = array(
            'jenisbbm'   => $this->input->post('JENIS_BBM'),
            // 'bulan'      => $this->input->post('BULAN'),
            // 'tahun'      => $this->input->post('TAHUN'),
            'idRegional' => $this->input->post('ID_REGIONAL'),
            'vlevelId'   => $this->input->post('VLEVELID')
        );

        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');

        $data = $this->tbl_pemakaian_get->getPemakaian($data);

        echo json_encode($data);
    }

    /**
     * for testing detail pemakaian
     * @see https://stackoverflow.com/questions/17575239/is-it-allowed-to-set-return-to-json-in-documentation
     * @return string json encode
     */
    public function testDetailPemakaian()
    {
        header('Content-Type: application/json');
        $data = $this->tbl_pemakaian_get->testDetailPemakaian();
        echo json_encode($data);
    }

    /**
     * get detail pemakaian
     * @return string json encode
     */
    public function getPemakaianDetail()
    {
        $data = array(
            'ID_BBM'    => $this->input->post('detail_id_bbm'),
            // 'detail_bulan'     => $this->input->post('detail_bulan'),
            // 'detail_tahun'     => $this->input->post('detail_tahun'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir'),
            'KODE_UNIT' => $this->input->post('detail_kode_unit')
        );

        $data = $this->tbl_pemakaian_get->getPemakaianDetail($data);
        echo json_encode($data);
    }

    public function asd()
    {
        header('Content-Type: application/json');
        $data = $this->tbl_pemakaian_get->testgetPemakaianDetail();
        echo json_encode($data);
    }

    /**
     * export excel
     * @return mixed
     */
    public function export_excel()
    {
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'idRegional'       => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'             => $this->input->post('xlvl4'), //183130
            'BBM'              => $this->input->post('xbbm'), //001
            'jenisbbm'         => $this->input->post('xbbm'),
            'VLEVELID'         => $this->input->post('xlvlid'),
            'vlevelId'         => $this->input->post('xlvlid'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'TGLAWAL'          => $this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir'),
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_pemakaian_get->getPemakaian($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    /**
     * triggering for button excel detail
     * @return mixed load into view
     */
    public function export_excel_detail()
    {
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'             => $this->input->post('xlvl4'), //183130

            'ID_BBM'              => $this->input->post('xidbbm_detail'), //001
            'KODE_UNIT'           => $this->input->post('xkodeUnit_detail'),
            'TGL_AWAL'            => $this->input->post('xtglawal_detail'),
            'TGL_AKHIR'           => $this->input->post('xtglakhir_detail'),
            'JENIS'               => 'XLS'
          );
        $data['data'] = $this->tbl_pemakaian_get->getPemakaianDetail($data);
        $this->load->view($this->_module . '/export_excel_detail', $data);
    }

    /**
     * export pdf button
     * @return mixed load into view
     */
    public function export_pdf()
    {
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('plvl'), // 01
            'idRegional'       => $this->input->post('plvl'), // 01
            'COCODE'           => $this->input->post('plvl1'),
            'PLANT'            => $this->input->post('plvl2'),
            'STORE_SLOC'       => $this->input->post('plvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

            'SLOC'             => $this->input->post('plvl4'), //183130
            'BBM'              => $this->input->post('pbbm'), //001
            'jenisbbm'         => $this->input->post('pbbm'),
            'VLEVELID'         => $this->input->post('plvlid'),
            'vlevelId'         => $this->input->post('plvlid'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'TGLAWAL'           => $this->input->post('ptglawal'),
            'TGLAKHIR'          => $this->input->post('ptglakhir'),
            'JENIS'             => 'PDF'
        );

        $data['data'] = $this->tbl_pemakaian_get->getPemakaian($data);
        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);

        // $this->load->library('pdf');
        // $this->pdf->load_view($this->_module . '/export_excel', $data);
        // $this->pdf->set_paper('a4', 'landscape');
        // $this->pdf->render();
        // $this->pdf->stream('Laporan_Pemakaian_BBM.pdf');

        $wkhtml_conf = array(
          'fileName'    => 'Laporan_Pemakaian_BBM.pdf',
          'html'        => $html_source,
          'orientation' => 'landscape'
        );
        $this->wkhtmltopdf($wkhtml_conf);
    }

    /**
     * export pdf detail
     * @return mixed load into view
     */
    public function export_pdf_detail()
    {
        header('Content-Type: application/json');
        $data                = array(
          // 'LVL0'             => $this->input->post('xlvl'),
          'ID_REGIONAL'      => $this->input->post('plvl'), // 01
          'COCODE'           => $this->input->post('plvl1'),
          'PLANT'            => $this->input->post('plvl2'),
          'STORE_SLOC'       => $this->input->post('plvl3'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'), //SUMATERA
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

          'SLOC'             => $this->input->post('plvl4'), //183130

          'ID_BBM'              => $this->input->post('pidbbm_detail'), //001
          'KODE_UNIT'           => $this->input->post('pkodeUnit_detail'),
          'TGL_AWAL'            => $this->input->post('ptglawal_detail'),
          'TGL_AKHIR'           => $this->input->post('ptglakhir_detail'),
          'JENIS'               => 'PDF'
      );

        $data['data'] = $this->tbl_pemakaian_get->getPemakaianDetail($data);
        $html_source  = $this->load->view($this->_module . '/export_excel_detail', $data, true);
        // $this->load->library('pdf');
        // $this->pdf->load_view($this->_module . '/export_excel_detail', $data);
        // $this->pdf->set_paper('a4', 'landscape');
        // $this->pdf->render();
        // $this->pdf->stream('Detail_Laporan_Pemakaian_BBM.pdf');
        $wkhtml_conf = array(
          'fileName'    => 'Detail_Laporan_Pemakaian_BBM.pdf',
          'html'        => $html_source,
          'orientation' => 'landscape'
        );
        $this->wkhtmltopdf($wkhtml_conf);
    }

    /**
     * export html to pdf with wkhtmltopdf
     * @param  array $conf array configuration
     * @return void
     */
    private function wkhtmltopdf(array $conf)
    {
        $pdf = new Pdf($conf['html'], array(
          'commandOptions' => array(
            'useExec' => true
          )
        ));
        $pdf->setOptions(array(
        'orientation'=> $conf['orientation']
      ));
        // if (!$pdf->saveAs('wkhtmltopdf.pdf')) {
        //     echo $pdf->getError();
        // }
        $pdf->send($conf['fileName']);
    }
}
