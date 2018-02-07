<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = ['id' => !empty($id) ? $id : ''];
        echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
        ?>
        <div class="control-group">
            <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('LEVEL1', !empty($default->LEVEL1) ? $default->LEVEL1 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Company Code <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('COCODE', !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Aktif : </label>
            <div class="controls">
            <?php echo form_checkbox('IS_AKTIF_LVL1', '1', !empty($default->IS_AKTIF_LVL1) ? $default->IS_AKTIF_LVL1 : ''); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', ['id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')"]); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', ['id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)']); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
