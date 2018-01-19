<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * penerimaan bbm controller
 */
class Penerimaan extends MX_Controller
{
    /**
     * title legend
     * @var string
     */
    private $_title  = 'Penerimaan BBM';

    /**
     * limitation
     * @var int
     */
    private $_limit  = 10;

    /**
     * model
     * @var string
     */
    private $_module = 'laporan/penerimaan';

    public function __construct()
    {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('persediaan_bbm_model', 'tbl_get');
        $this->load->model('penerimaan_model', 'tbl_penerimaan_get');
        $this->load->helper('dd');
    }

    public function index()
    {
        // Load Modules
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(['crud']);
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

        $data['opsi_bbm']   = $this->tbl_penerimaan_get->option_jenisbbm();
        // dd($this->tbl_penerimaan_get->option_jenisbbm());
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/getData');
        // $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }

    /**
     * get data
     * @return mixed
     */
    public function getData()
    {
        // header('Content-Type: application/json');
        $data['JENIS_BBM']     = $this->input->post('JENIS_BBM');
        // $data['BULAN']         = $this->input->post('BULAN');
        // $data['TAHUN']         = $this->input->post('TAHUN');
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['ID_REGIONAL']   = $this->input->post('ID_REGIONAL');
        $data['VLEVELID']      = $this->input->post('VLEVELID');
        $data                  = $this->tbl_penerimaan_get->getData_Model($data);

        echo json_encode($data);
    }

    /**
     * JUST FOR TESTING getData
     * @return mixed
     */
    public function testGetData()
    {
        // header('Content-Type: application/json');

        $data = [
            'JENIS_BBM'   => $this->input->post('JENIS_BBM'),
            // 'BULAN'       => $this->input->post('BULAN'),
            // 'TAHUN'       => $this->input->post('TAHUN'),
            'TGLAWAL'     => $this->input->post('TGLAWAL'),
            'TGLAKHIR'    => $this->input->post('TGLAKHIR'),
            'ID_REGIONAL' => $this->input->post('ID_REGIONAL'),
            'VLEVELID'    => $this->input->post('VLEVELID')
        ];
        $data = $this->tbl_penerimaan_get->testGetDataModel($data);

        echo json_encode($data);
    }

    /**
     * get detail result
     * @return mixed
     */
    public function getDataDetail()
    {
        $data = [
            'ID_BBM'    => $this->input->post('detail_id_bbm'),
            // 'BULAN'     => $this->input->post('detail_bulan'),
            // 'TAHUN'     => $this->input->post('detail_tahun'),
            'KODE_UNIT' => $this->input->post('detail_kode_unit'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir')
        ];
        $data = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        echo json_encode($data);
    }

    public function testDetail()
    {
        header('Content-Type: application/json');
        $data = [
          'ID_BBM'    => $this->input->post('detail_id_bbm'),
          // 'BULAN'     => $this->input->post('detail_bulan'),
          // 'TAHUN'     => $this->input->post('detail_tahun'),
          'KODE_UNIT' => $this->input->post('detail_kode_unit'),
          'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
          'TGL_AKHIR' => $this->input->post('detail_tgl_akhir')
      ];
        $data = $this->tbl_penerimaan_get->testDetail();
        echo json_encode($data);
    }

    public function export_excel()
    {
        header('Content-Type: application/json');
        $data                = [
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
            'BBM'              => $this->input->post('xbbm'), //001
            'JENIS_BBM'        => $this->input->post('xbbm'),
            'VLEVELID'         => $this->input->post('xlvlid'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'TGLAWAL'          => $this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir'),
            'JENIS'            => 'XLS'
        ];

        $data['data'] = $this->tbl_penerimaan_get->getData_Model($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    /**
     * export detail from modal detail
     * @return mixed
     */
    public function export_excel_detail()
    {
        header('Content-Type: application/json');
        $data                = [
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'              => $this->input->post('xlvl4'), //183130
            'BBM'               => $this->input->post('xbbm'), //001
            // 'ID_BBM'            => $this->input->post('xbbm'),
            'ID_BBM'            => '001',
            'VLEVELID'          => $this->input->post('xlvlid'),
            // 'KODE_UNIT'         => $this->input->post('xkodeUnit_detail'),
            'KODE_UNIT'         => '1',
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            // 'TGLAWAL'           => $this->input->post('xtglawal'),
            // 'TGLAKHIR'          => $this->input->post('xtglakhir'),
            'TGLAWAL'           => '01012018',
            'TGLAKHIR'          => '16012018',
            // 'TGL_AWAL'          => $this->input->post('xtglawal'),
            // 'TGL_AKHIR'         => $this->input->post('xtglakhir'),
            'TGL_AWAL'          => '01012018',
            'TGL_AKHIR'         => '16012018',
            'JENIS'             => 'XLS'
        ];

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        $this->load->view($this->_module . '/export_excel_detail', $data);
    }
}
