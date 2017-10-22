<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Role Management'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <div class="control-group">
            <label for="password" class="control-label">Nama Role <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('roles_nama', !empty($default->ROLES_NAMA) ? $default->ROLES_NAMA : '', 'class="span6"'); ?>
            </div>
            <br>
			 <div class="control-group">
				<label  class="control-label">Level Group <span class="required">*</span> : </label>
				<div class="controls">
					<?php echo form_dropdown('level_user', hgenerator::arr_levelgroup(), !isset($default->LEVEL_ROLES) ? '' : $default->LEVEL_ROLES, 'class="span8 chosen" id="level_user"'); ?>
				</div>
			</div>
			<br/>
            <label for="password" class="control-label">Keterangan : </label>
            <div class="controls">
                <?php echo form_input('roles_keterangan', !empty($default->ROLES_KETERANGAN) ? $default->ROLES_KETERANGAN : '', 'class="span6"'); ?>
            </div>
        </div><br>
        <div class="well-content" id="content_table">
            <table class="table table-striped table-bordered table-hover datatable dataTable">
                <thead>
                    <tr>
                        <th><?php echo form_checkbox('cb_select_menu', '', false, 'id="cb_select_menu" target-selected="cb_select" onchange="select_all(this.id)"'); ?></th>
                        <th>Nama Menu</th>
                        <th>View</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <!--<th>Export</th>
                        <th>Import</th>-->
                        <th>Approve</th>
                    </tr>
                </thead>
                <?php foreach ($list_menu['rows'] as $menu_id => $row_menu): ?>
                    <tr>
                        <td align="center">
                            <?php echo $row_menu['menu_flag']; ?>
                        </td>
                        <td><?php echo $row_menu['menu_nama']; ?></td>				
                        <td align="center"><?php echo form_checkbox('is_view[]', $menu_id, isset($otoritas_menu[$menu_id]['is_view']) && $otoritas_menu[$menu_id]['is_view'] == 't' ? TRUE : FALSE, 'class="cb_select" id="cb_select_menu_' . $menu_id . '" target-selected="cb_select_row_' . $menu_id . '" onchange="select_all(this.id)"'); ?></td>
                        <td align="center"><?php echo form_checkbox('is_add[]', $menu_id, isset($otoritas_menu[$menu_id]['is_add']) && $otoritas_menu[$menu_id]['is_add'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>
                        <td align="center"><?php echo form_checkbox('is_edit[]', $menu_id, isset($otoritas_menu[$menu_id]['is_edit']) && $otoritas_menu[$menu_id]['is_edit'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>
                        <td align="center"><?php echo form_checkbox('is_delete[]', $menu_id, isset($otoritas_menu[$menu_id]['is_delete']) && $otoritas_menu[$menu_id]['is_delete'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>
                        <!--<td align="center"><?php //echo form_checkbox('is_export[]', $menu_id, isset($otoritas_menu[$menu_id]['is_export']) && $otoritas_menu[$menu_id]['is_export'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>
                        <td align="center"><?php //echo form_checkbox('is_import[]', $menu_id, isset($otoritas_menu[$menu_id]['is_import']) && $otoritas_menu[$menu_id]['is_import'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>-->
                        <td align="center"><?php echo form_checkbox('is_approve[]', $menu_id, isset($otoritas_menu[$menu_id]['is_approve']) && $otoritas_menu[$menu_id]['is_approve'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?></td>
                    </tr>
                <?php endforeach; ?>			
            </table>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
