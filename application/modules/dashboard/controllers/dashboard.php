<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class dashboard extends MX_Controller {

    private $_title = 'Dashboard';
    private $_module = 'dashboard';
     private $_limit = 5;
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');

        // Protection
        hprotection::login();
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");
         // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','highchart'));
        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );
        $data['sidebar_content']    = 'dashboard/sidebar';
        $data['motivasi']           = array();//$this->dashboard_model->lastmessage();
        $data['page_title']         = '<i class="icon-home"></i> ' . $this->_title;
        $data['page_content']       = $this->_module .'/main2';
        // $data['data_sources2']      = base_url('kms_graph/statistik/load_halfdonut');
        $data['source_search']      = array();//base_url($this->_module . '/search');
        $data['sources_ate']        = array();//base_url($this->_module . '/hitung_ate');
        $data['sources_taks']       = array();//base_url($this->_module . '/hitung_taks_unapproved');
        $data['sources_k_internal'] = array();//base_url($this->_module . '/hitung_k_internal_unapproved'); 
        $data['sources_elibrary']   = array();//base_url($this->_module . '/hitung_elibrary_unapproved');
        $data['sources_info']       = array();//base_url($this->_module . '/load_info');
        
        $data['suggest_elibrary']       = array();//base_url($this->_module . '/load_suggest_elibrary');
        $data['suggest_elibrary2']       = array();//base_url($this->_module . '/load_suggest_elibrary2');
        $data['suggest_elibrary3']       = array();//base_url($this->_module . '/load_suggest_elibrary3');
        
        $data['suggest_takso1']       = array();//base_url($this->_module . '/load_suggest_takso1');
        $data['suggest_takso2']       = array();//base_url($this->_module . '/load_suggest_takso2');
		
		$data['picbelumlaporan'] = $this->dashboard_model->picbelumlaporan();
		$data['picsudahlaporan'] = $this->dashboard_model->picsudahlaporan();
		$data['belumverifikasi'] = $this->dashboard_model->databelumverifikasi();

        echo Modules::run("template/admin", $data);
    }
    
    public function hitung_ate()
    {
        $notif  = 0;
        $text   = "Ask The Expert : Tidak ada pertanyaan yang diajukan kepada anda.";
        $query  = $this->dashboard_model->count_ate_unanswered($this->session->userdata('user_id')); 
        $notif  = count($query); 
        if($notif==0)
        {
            echo $text;
        }
        else
        {
            $text   = "Ask The Expert : Terdapat $notif pertanyaan yang diajukan kepada anda."; 
            $text   = '<a id="button-download"  href="'. base_url('kms_main/ate').'">'.$text.'</a>'; 
            echo $text;
             
        }
        
    }
    
    public function hitung_taks_unapproved()
    {
        $notif  = 0;
        $text   = "Verifikasi Taksonomi : Tidak ada knowledge yang harus anda verifikasi.";
        $query  = $this->dashboard_model->count_unapproved_taks($this->session->userdata('user_id'));
        $notif  = count($query); 
        if($notif==0)
        {
            echo $text;
        }
        else
        {
            $text   = "Verifikasi Taksonomi : Terdapat $notif knowledge yang harus anda verifikasi."; 
            $text   = '<a id="button-download"  href="'. base_url('kms_main/taksonomi_knowledge').'">'.$text.'</a>'; 
            echo $text; 
        } 
    }
    
    public function hitung_k_internal_unapproved()
    {
        $notif  = 0;
        $text   = "Ketentuan Internal : Tidak ada Ketentuan Internal yang harus anda verifikasi.";
        $query  = $this->dashboard_model->count_unapproved_k_int($this->session->userdata('user_id'));  
        $notif  = count($query); 
        if($notif==0)
        {
            echo $text;
            
        }
        else
        {
            $text   = "Ketentuan Internal : Terdapat $notif Ketentuan Internal yang harus anda verifikasi."; 
            $text   = '<a id="button-download"  href="'. base_url('kms_main/ketentuan_internal').'">'.$text.'</a>';
            
            echo $text; 
        }  
                
    }
    
    public function hitung_elibrary_unapproved()
    {
        $notif  = 0;
        $text   = "eLibrary : Tidak ada dokumen di eLibrary yang harus anda verifikasi.";
        $query  = $this->dashboard_model->count_unapproved_elibrary($this->session->userdata('user_id'));  
        $notif  = count($query); 
        if($notif==0)
        {
            echo $text;
            
        }
        else
        {
            $text   = "eLibrary : Terdapat $notif dokumen di eLibrary yang harus anda verifikasi."; 
            $text   = '<a id="button-download"  href="'. base_url('kms_main/elibrary').'">'.$text.'</a>';
            
            echo $text; 
        }  
                
    }
    
    public function load_info()
    {
        echo $this->dashboard_model->get_info($this->session->userdata('user_id'));
    }
    
    public function load_suggest_elibrary()
    {
        echo $this->dashboard_model->get_suggest_elibrary($this->session->userdata('user_id'));
    }
    
    public function load_suggest_elibrary2()
    {
        echo $this->dashboard_model->get_suggest_elibrary2($this->session->userdata('user_id'));
    }
    
    public function load_suggest_elibrary3()
    {
        echo $this->dashboard_model->get_suggest_elibrary3($this->session->userdata('user_id'));
    }
    
    public function load_suggest_takso1()
    {
        echo $this->dashboard_model->get_suggest_takso1($this->session->userdata('user_id'));
    }
    
    public function load_suggest_takso2()
    {
        echo $this->dashboard_model->get_suggest_takso2($this->session->userdata('user_id'));
    }
    
    
    
    public function search($page=0)
    {
        $output = $this->dashboard_model->data_table_data($this->_limit,$page);
        
        $this->load->library('pagination');

        //$config['base_url'] = base_url($this->_module . '/load/'.($page+1));
        $config['base_url'] = base_url($this->_module . '/search/');

        $config['total_rows'] = $this->dashboard_model->count_data();
        $config['per_page'] = $this->_limit;
        $config['anchor_class'] = 'class="button button-border small red"';
        $config['full_tag_open'] = ' <div class="row-fluid">
                                    <div class="span12">
                                        <div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>
                                    </div>
                                </div>';
        // If you want to wrap the "go to first" link
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        // If you want to wrap the "go to last" link
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
       
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';
        
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $output .= $this->pagination->create_links();
        echo $output;
    }
}

/* End of file dashboard.php */
/* Location: ./application/modules/meeting_management/controllers/dashboard.php */
