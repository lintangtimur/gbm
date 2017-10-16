<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module role management
 */
class role extends MX_Controller {

    private $_title = 'Role Management';
    private $_limit = 10;
    private $_module = 'user_management/role';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('role_model');
        $this->load->model('menu_model');
        $this->load->model('otoritas_menu_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'][] = anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add')));
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            $page_title = 'Tambah Role';
            $data['id'] = $id;
            $otoritas = array();
            if ($id != '') {
                $page_title = 'Edit Role';
                $role = $this->role_model->data($id);
                $data['default'] = $role->get()->row();
                $data_otoritas = $this->otoritas_menu_model->data(array('roles_id' => $id))->get();
                foreach ($data_otoritas->result() as $dt_otoritas) {
                    $otoritas[$dt_otoritas->MENU_ID] = array
                        ('is_view' => $dt_otoritas->IS_VIEW,
                        'is_add' => $dt_otoritas->IS_ADD,
                        'is_edit' => $dt_otoritas->IS_EDIT,
                        'is_delete' => $dt_otoritas->IS_DELETE,
                        'is_approve' => $dt_otoritas->IS_APPROVE
                    );
                }
            }

            $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
            $data['list_menu'] = $this->menu_model->data_table();
            $data['otoritas_menu'] = $otoritas;
            $data['form_action'] = base_url($this->_module . '/proses');
            $this->load->view($this->_module . '/form', $data);
        } else {
            $this->laccess->redirect();
        }
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->role_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'roles_id';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 4;
        $table->header[] = array(
            "No", 1, 1,
            "Nama Role", 1, 1,
            "Keterangan Role", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        if ($this->laccess->otoritas('add') || $this->laccess->otoritas('edit')) {
            $this->form_validation->set_rules('roles_nama', 'Nama Role', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('roles_keterangan', 'Keterangan Role', 'trim|max_length[250]');
            if ($this->form_validation->run($this)) {
                $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
                $id = $this->input->post('id');
                $data = array();
                $data['roles_nama'] = $this->input->post('roles_nama');
                $data['roles_keterangan'] = $this->input->post('roles_keterangan');
                $temp = array();
                $is_view = $this->input->post('is_view');
                $is_add = $this->input->post('is_add');
                $is_edit = $this->input->post('is_edit');
                $is_delete = $this->input->post('is_delete');
                // $is_export = $this->input->post('is_export');
                // $is_import = $this->input->post('is_import');
                $is_approve = $this->input->post('is_approve');

                if (is_array($is_view) && count($is_view) > 0) {
                    foreach ($is_view as $val) {
                        $temp[$val]['is_view'] = 't';
                    }
                }
                if (is_array($is_add) && count($is_add) > 0) {
                    foreach ($is_add as $val) {
                        $temp[$val]['is_add'] = 't';
                    }
                }
                if (is_array($is_edit) && count($is_edit) > 0) {
                    foreach ($is_edit as $val) {
                        $temp[$val]['is_edit'] = 't';
                    }
                }
                if (is_array($is_delete) && count($is_delete) > 0) {
                    foreach ($is_delete as $val) {
                        $temp[$val]['is_delete'] = 't';
                    }
                }
                // if (is_array($is_export) && count($is_export) > 0) {
                    // foreach ($is_export as $val) {
                        // $temp[$val]['is_export'] = 't';
                    // }
                // }
                // if (is_array($is_import) && count($is_import) > 0) {
                    // foreach ($is_import as $val) {
                        // $temp[$val]['is_import'] = 't';
                    // }
                // }
                if (is_array($is_approve) && count($is_approve) > 0) {
                    foreach ($is_approve as $val) {
                        $temp[$val]['is_approve'] = 't';
                    }
                }

                if ($id == '') {
                    if ($this->role_model->save_as_new($data, $temp)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
                } else {
                    if ($this->role_model->save($data, $id, $temp)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }
            } else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
            }
            echo json_encode($message, true);
        } else {
            $this->laccess->redirect();
        }
    }

    public function delete($id) {
        if ($this->laccess->otoritas('delete', true)) {
            $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

            if ($this->role_model->delete($id)) {
                $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
            }
            echo json_encode($message);
        }
    }

}

/* End of file role.php */
/* Location: ./application/modules/role/controllers/role.php */
