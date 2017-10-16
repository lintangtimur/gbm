<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

/**
 * @module jabatan
 */
class menu extends MX_Controller {

    private $_title = 'Modul Management';
    private $_module = 'user_management/menu';

    public function __construct() {
        parent::__construct();
		// Init Otorisasi Modul Akses 
		$this->laccess->check(array('user_management/menu'));
		
        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('menu_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS menu
        $this->asset->set_plugin(array('crud', 'select2'));
		$btn = array();
		//Validasi Otorisasi Tambah / Add
		if ($this->laccess->otoritas('add', false, 'user_management/menu'))
		$btn = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );
		
        $data['button_group'] = $btn;

        $data['parent_options'] = $this->menu_model->options('--Pilih Parent--', array('m_menu.kms_menu_id' => NULL));
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Data';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Data';
            $loker = $this->menu_model->data($id);
            $data['default'] = $loker->get()->row();
        }

        $data['parent_options'] = $this->menu_model->options('--Pilih Parent--', array('m_menu.kms_menu_id' => NULL));

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');

        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 0) {
        $data_table = $this->menu_model->data_table($this->_module);

        $this->load->library("ltable");
        $icon = anchor(null, '<i class="icon-th"></i>');

        $table = new stdClass();
        $table->id = 'menu_id';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('menu_flag' => 'center', 'menu_icon' => 'center', 'menu_urutan' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->jumlah_kolom = 6;
        $table->header[] = array(
            $icon, 1, 1,
            "Icon", 1, 1,
            "Nama Menu", 1, 1,
            "URL", 1, 1,
            "Keterangan", 1, 1,
            "Urutan", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('menu_nama', 'Nama', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('kms_menu_id', 'Parent');
        $this->form_validation->set_rules('menu_url', 'URL', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('menu_keterangan', 'Keterangan', 'trim|max_length[250]');
        $this->form_validation->set_rules('menu_urutan', 'Urutan', 'trim|required|integer|max_length[3]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');
            $parent_id = $this->input->post('kms_menu_id');

            $menu = array();
            $menu['menu_nama'] = $this->input->post('menu_nama');
            $menu['kms_menu_id'] = !empty($parent_id) ? $parent_id : NULL;
            $menu['menu_url'] = $this->input->post('menu_url');
            $menu['menu_keterangan'] = $this->input->post('menu_keterangan');
            $menu['menu_urutan'] = $this->input->post('menu_urutan');
            $menu['menu_icon'] = $this->input->post('menu_icon');

            if ($id == '') {
                if ($this->menu_model->save_as_new($menu)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {

                if ($this->menu_model->save($menu, $id)) {

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

        if ($this->menu_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file menu.php */
/* Location: ./application/modules/menu/controllers/menu.php */
