<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
use mikehaertl\wkhtmlto\Pdf;

/**
 * @module persediaan_bbm
 */
class persediaan_bbm extends MX_Controller
{
    private $_title  = 'Persediaan BBM';
    private $_limit  = 10;
    private $_module = 'laporan/persediaan_bbm';

    public function __construct()
    {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('persediaan_bbm_model', 'tbl_get');
    }

    public function index()
    {
        // Load Modules
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        // $this->asset->set_plugin(array('bootstrap-rakhmat'));

        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

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

    public function getData()
    {
        $data['ID_REGIONAL'] = $this->input->post('ID_REGIONAL');
        $data['COCODE']      = $this->input->post('COCODE');
        $data['PLANT']       = $this->input->post('PLANT');
        $data['STORE_SLOC']  = $this->input->post('STORE_SLOC');
        $data['SLOC']        = $this->input->post('SLOC');
        $data['BBM']         = $this->input->post('ID_JNS_BHN_BKR');
        $data['BULAN']       = $this->input->post('BULAN');
        $data['TAHUN']       = $this->input->post('TAHUN');
        $data['TGL_DARI']    = $this->input->post('TGL_DARI');
        $data['TGL_SAMPAI']  = $this->input->post('TGL_SAMPAI');

        $data = $this->tbl_get->getData_Model($data);
        echo json_encode($data);
    }

    public function export_excel()
    {
        $data['ID_REGIONAL'] = $this->input->post('xlvl0');
        $data['COCODE']      = $this->input->post('xlvl1');
        $data['PLANT']       = $this->input->post('xlvl2');
        $data['STORE_SLOC']  = $this->input->post('xlvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('xlvl0_nama');
        $data['COCODE_NAMA']      = $this->input->post('xlvl1_nama');
        $data['PLANT_NAMA']       = $this->input->post('xlvl2_nama');
        $data['STORE_SLOC_NAMA']  = $this->input->post('xlvl3_nama');

        $data['SLOC']       = $this->input->post('xlvl4');
        $data['BBM']        = $this->input->post('xbbm');
        $data['BULAN']      = $this->input->post('xbln');
        $data['TAHUN']      = $this->input->post('xthn');
        $data['TGL_DARI']   = $this->input->post('xtglawal');
        $data['TGL_SAMPAI'] = $this->input->post('xtglakhir');
        $data['JENIS']      = 'XLS';

        $data['data'] = $this->tbl_get->getData_Model($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf()
    {
        $data['ID_REGIONAL'] = $this->input->post('plvl0');
        $data['COCODE']      = $this->input->post('plvl1');
        $data['PLANT']       = $this->input->post('plvl2');
        $data['STORE_SLOC']  = $this->input->post('plvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('plvl0_nama');
        $data['COCODE_NAMA']      = $this->input->post('plvl1_nama');
        $data['PLANT_NAMA']       = $this->input->post('plvl2_nama');
        $data['STORE_SLOC_NAMA']  = $this->input->post('plvl3_nama');

        $data['SLOC']       = $this->input->post('plvl4');
        $data['BBM']        = $this->input->post('pbbm');
        $data['BULAN']      = $this->input->post('pbln');
        $data['TAHUN']      = $this->input->post('pthn');
        $data['TGL_DARI']   = $this->input->post('ptglawal');
        $data['TGL_SAMPAI'] = $this->input->post('ptglakhir');
        $data['JENIS']      = 'PDF';

        $data['data'] = $this->tbl_get->getData_Model($data);
        $this->load->view($this->_module . '/export_excel', $data);

        $this->load->library('pdf');
        $this->pdf->load_view($this->_module . '/export_excel', $data);
        $this->pdf->set_paper('a4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream('Laporan_Persediaan_BBM.pdf');
    }

    public function export_pdf_newVersion()
    {
        $data['ID_REGIONAL'] = $this->input->post('plvl0');
        $data['COCODE']      = $this->input->post('plvl1');
        $data['PLANT']       = $this->input->post('plvl2');
        $data['STORE_SLOC']  = $this->input->post('plvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('plvl0_nama');
        $data['COCODE_NAMA']      = $this->input->post('plvl1_nama');
        $data['PLANT_NAMA']       = $this->input->post('plvl2_nama');
        $data['STORE_SLOC_NAMA']  = $this->input->post('plvl3_nama');

        $data['SLOC']       = $this->input->post('plvl4');
        $data['BBM']        = $this->input->post('pbbm');
        $data['BULAN']      = $this->input->post('pbln');
        $data['TAHUN']      = $this->input->post('pthn');
        $data['TGL_DARI']   = $this->input->post('ptglawal');
        $data['TGL_SAMPAI'] = $this->input->post('ptglakhir');
        $data['JENIS']      = 'PDF';

        $data['data'] = $this->tbl_get->getData_Model($data);
        $html         = $this->load->view($this->_module . '/export_excel', $data, true);

        $pdf = new Pdf($html, array(
          'commandOptions' => array(
            'useExec' => true
          )
      ));
        $pdf->setOptions(array(
        'orientation'=> 'landscape'
      ));
        // if (!$pdf->saveAs('wkhtmltopdf.pdf')) {
        //     echo $pdf->getError();
        // }
        $pdf->send('Laporan_Persediaan_BBM.pdf');
    }

    public function get_options_lv1($key=null)
    {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null)
    {
        $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null)
    {
        $message = $this->tbl_get->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null)
    {
        $message = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_bbm()
    {
        $message = $this->tbl_get->options_bhn_bkr('--Pilih Jenis BBM--', $key, 0);
        echo json_encode($message);
    }
}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
