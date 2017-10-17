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
            <label for="password" class="control-label">Kode Jenis Bahan Bakar <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KODE_JNS_BHN_BKR', !empty($default->KODE_JNS_BHN_BKR) ? $default->KODE_JNS_BHN_BKR : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_JNS_BHN_BKR', !empty($default->NAMA_JNS_BHN_BKR) ? $default->NAMA_JNS_BHN_BKR : '', 'class="span6"'); ?>
            </div>

        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>