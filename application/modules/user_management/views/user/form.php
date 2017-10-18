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
            <label  class="control-label">Kode User : </label>
            <div class="controls">
                <?php echo form_input('kode_user', !empty($default->KD_USER) ? $default->KD_USER : '', 'class="span4" maxlength="100"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('nama_user', !empty($default->NAMA_USER) ? $default->NAMA_USER : '', 'class="span6"'); ?>
            </div>
        </div>
		 <div class="control-group">
            <label for="password" class="control-label">Email <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('email_user', !empty($default->EMAIL_USER) ? $default->EMAIL_USER : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level Group <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('level_user', hgenerator::arr_levelgroup(), !isset($default->LEVEL_USER) ? '' : $default->LEVEL_USER, 'class="span8 chosen" id="level_user"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2 "'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Username <span class="required">*</span> : </label>
            <div class="controls">
                <?php 
                echo form_input('user_username', !empty($default->USERNAME) ? $default->USERNAME : '', 'class="span6" '. $disabled); 
                ?>
            </div>
        </div>
		<div class="control-group">
            <label for="password" class="control-label">Password <span class="required">*</span> : </label>
            <div class="controls">
                <?php 
                echo form_password('password', !empty($default->PWD_USER) ? $default->PWD_USER : '', 'class="span6"'); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Role <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('role_id', $role_options, !empty($default->ROLES_ID) ? $default->ROLES_ID : '', 'class="span6 chosen"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Status <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('user_status', hgenerator::status_user(), !isset($default->ISAKTIF_USER) ? '' : $default->ISAKTIF_USER , 'class="span4 chosen"'); ?>
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
	$( "#level_user" ).change(function() {
		idlevel = $(this).val();
		if (idlevel !== '0'){
			if (idlevel !== '-')
				load_level('<?php echo $loadlevel; ?>' + idlevel, "jancuk");
		}
	});
});
</script>