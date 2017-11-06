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
            <label for="password" class="control-label">Kode Pemasok <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KODE_PEMASOK', !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama Pemasok <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_PEMASOK', !empty($default->NAMA_PEMASOK) ? $default->NAMA_PEMASOK : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Aktif : </label>
            <div class="controls">
            <?php echo form_checkbox('ISAKTIF_PEMASOK', '1', !empty($default->ISAKTIF_PEMASOK) ? $default->ISAKTIF_PEMASOK : '' ); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>