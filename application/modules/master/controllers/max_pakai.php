<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Max Pemakaian
 */
class max_pakai extends MX_Controller {

    private $_title = 'Max Pemakaian';
    private $_limit = 10;
    private $_module = 'master/max_pakai';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
		$this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('max_pakai_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

		$data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
			$data['button_group'] = array(
				anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
			);
		}
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Max Pemakaian';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Max Pemakaian';
            $program = $this->max_pakai_model->data($id);
            $data['default'] = $program->get()->row();
        }
        $data['lv4_options'] = $this->max_pakai_model->options();
		$data['jnsbbm_options'] = $this->max_pakai_model->options_jnsbbm();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->max_pakai_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_PROGRAM';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no' => 'center', 'periode' => 'center', 'aksi' => 'center', 'volume' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 3;
        $table->header[] = array(
            "No", 1, 1,
			'Level 2', 1,1,
			'Level 3', 1,1,
			'Level 4', 1,1,
			'Jenis BBM', 1,1,
            "Periode", 1, 1,
			"Volume", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('THBL_MAX_PAKAI', 'Periode Pemakaian', 'trim|required');
		$this->form_validation->set_rules('VOLUME_MAX_PAKAI', 'Volume Pemakaian', 'trim|required');
		$this->form_validation->set_rules('SLOC', 'Pembangkit', 'trim|required');
		$this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'trim|required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');
			
            $thbl = $this->input->post('THBL_MAX_PAKAI');
			$vol = $this->input->post('VOLUME_MAX_PAKAI');
			$sloc = $this->input->post('SLOC');
			$idjnsbbm = $this->input->post('ID_JNS_BHN_BKR');

            if ($id == '') {
                $result = $this->max_pakai_model->save_as_new($thbl,$vol, $sloc, $idjnsbbm);
				if ($result[0]->RCDB == "RC01")
					$message = array(false, 'Proses Gagal', $result[0]->PESANDB, '');
				else
					$message = array(true, 'Proses Berhasil', $result[0]->PESANDB , '#content_table');
            } else {
                if ($this->max_pakai_model->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->max_pakai_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file program.php */
/* Location: ./application/modules/program/controllers/program.php */
