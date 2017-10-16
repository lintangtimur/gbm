<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Login
 * @controller Login
 */
class app_config extends MX_Controller {

    private $_title = 'Pengaturan Aplikasi';
    private $_module = 'backend/app_config';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();

        $this->load->model('setting_model');
        

        $this->laccess->check();
        $this->laccess->otoritas('view', true); 
        
        
        $this->load->helper(array('developer_helper')); 
       

    }

    public function index() 
    {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['page_title'] = '<i class="icon-wrench"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data_table = $this->setting_model->data();
		$arr_detail = array();
		foreach($data_table->get()->result() as $row){
			
			$arr_detail [$row->setting]=$row->value;
				
		}
         
        $data['setting'] = $arr_detail;
        $data['form_action'] = base_url($this->_module . '/save');
        //$data['source_tab2'] = base_url($this->_module . '/tab2');

        echo Modules::run("template/admin", $data);
    }
    
    function save()
    {
        $this->form_validation->set_rules('fclient', 'Nama Perusahaan', 'required');
         $this->form_validation->set_rules('faplikasi', 'Nama Aplikasi', 'required');
            if ($this->form_validation->run($this)) {
                $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
                
               $insert = array(
				'companyname' => $this -> input -> post('fclient'),
				'nama_aplikasi' => $this -> input -> post('faplikasi')
                );
    
                if($this->setting_model->update($insert)){
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '');
                }
            } else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
            }
            echo json_encode($message, true);
    }
    
}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */
