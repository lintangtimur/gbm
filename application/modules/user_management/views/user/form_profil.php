<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <div class="control-group">
            <label for="password" class="control-label">NPP <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('user_nip', !empty($default->user_nip) ? $default->user_nip : '', 'class="span4" maxlength="100"'); ?>
            <?php echo form_hidden('temp_user_nip', !empty($default->user_nip) ? $default->user_nip : ''); ?>
			</div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('user_nama', !empty($default->user_nama) ? $default->user_nama : '', 'class="span6" maxlength="100"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Lokasi Kerja <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('loker_id', $loker_options, !empty($default->loker_id) ? $default->loker_id : '', 'class="span8 chosen"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Unit Kerja <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('unit_id', $unit_options, !empty($default->unit_id) ? $default->unit_id : '', 'class="span8 chosen"'); ?>
            </div>
        </div>
        <!------>
		
		<div class="control-group">
			<table class="table table-striped table-bordered table-hover datatable dataTable">
                <thead>
                    <tr>
                        <th>Nama Keahlian</th>
                        <th>Pilih Keahlian</th>
                    </tr>
                </thead>
                <?php foreach ($list_menu['rows'] as $menu_id => $row_menu): ?>
                    <tr>
                        <td align="center"><?php echo $row_menu['keahlian_nama']; ?></td>						
                        <td align="center" width="20%">
							<?php echo form_checkbox('is_add[]', $menu_id, isset($cek_menu[$menu_id]['is_add']) && $cek_menu[$menu_id]['is_add'] == $row_menu['keahlian_id'] ? TRUE : FALSE);?>
						</td>
                    </tr>
                <?php endforeach; ?>			
            </table>
        </div>
		
		<!------>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $('.chosen').chosen();
})
</script>