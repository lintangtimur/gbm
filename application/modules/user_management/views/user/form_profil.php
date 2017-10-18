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
            <label for="password" class="control-label">Kode User : </label>
            <div class="controls">
                <?php echo form_input('kode_user', !empty($default->KODE_USER) ? $default->KODE_USER : '', 'class="span4" maxlength="100"'); ?>
            <?php echo form_hidden('temp_user_nip', !empty($default->KODE_USER) ? $default->KODE_USER : ''); ?>
			</div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('user_nama', !empty($default->NAMA_USER) ? $default->NAMA_USER : '', 'class="span6" maxlength="100"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Username : </label>
            <div class="controls">
                <?php echo form_input('username', !empty($default->USERNAME) ? $default->USERNAME: '', 'class="span6" maxlength="100" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Level User : </label>
            <div class="controls">
                <?php echo form_input('level_user', !empty($default->LEVEL_USER) ? $default->LEVEL_USER: '', 'class="span6" maxlength="100" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Group User : </label>
            <div class="controls">
                <?php echo form_input('level_user', !empty($default->LOKER_NAMA) ? $default->LOKER_NAMA: '', 'class="span6" maxlength="100" disabled'); ?>
            </div>
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