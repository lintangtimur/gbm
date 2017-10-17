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
            <label for="password" class="control-label">Level 4 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('LEVEL4', !empty($default->LEVEL4) ? $default->LEVEL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Sloc <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('SLOC', !empty($default->SLOC) ? $default->SLOC : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Alamat : </label>
            <div class="controls">
                <?php echo form_input('DESCRIPTION_LVL4', !empty($default->DESCRIPTION_LVL4) ? $default->DESCRIPTION_LVL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Latitude : </label>
            <div class="controls">
                <?php echo form_input('LAT_LVL4', !empty($default->LAT_LVL4) ? $default->LAT_LVL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Longitude : </label>
            <div class="controls">
                <?php echo form_input('LOT_LVL4', !empty($default->LOT_LVL4) ? $default->LOT_LVL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
            </div>
        </div>        
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>