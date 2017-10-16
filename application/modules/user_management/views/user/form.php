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
        <div class="control-group">
            <label for="password" class="control-label">Username <span class="required">*</span> : </label>
            <div class="controls">
                <?php 
                echo form_input('user_username', !empty($default->user_username) ? $default->user_username : '', 'class="span6" maxlength="30"'); 
                echo form_hidden('temp_user_username', !empty($default->user_username) ? $default->user_username : ''); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Role <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('role_id', $role_options, !empty($default->roles_id) ? $default->roles_id : '', 'class="span6 chosen"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Status <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('user_status', hgenerator::status_user(), !empty($default->user_status) ? $default->user_status : '', 'class="span4 chosen"'); ?>
            </div>
        </div>
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