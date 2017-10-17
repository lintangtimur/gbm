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
            <label for="password" class="control-label">Pembangkit <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('unit_pembangkit', $unit_pembangkit, !empty($default->unit_pembangkit) ? $default->unit_pembangkit : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('jenis_bbm', $jenis_bbm, !empty($default->jenis_bbm) ? $default->jenis_bbm : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tera<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('TERA', $tera, !empty($default->tera) ? $default->tera : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama Tangki<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_TANGKI', !empty($default->NAMA_TANGKI) ? $default->NAMA_TANGKI : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Kapasitas (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KAPASITAS', !empty($default->KAPASITAS) ? $default->KAPASITAS : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Dead Stock (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('DEAD_STOCK', !empty($default->DEAD_STOCK) ? $default->DEAD_STOCK : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Stock Efektif (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('STOCK_EFEKTIF', !empty($default->STOCK_EFEKTIF) ? $default->STOCK_EFEKTIF : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Tera<span class="required">*</span> : </label>
            <div class="controls">
            <?php $attributes = 'id="tgltera" placeholder=""'; echo form_input('tgltera', set_value('tgltera'), $attributes); ?>
                  
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Upload File<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_upload('FILE_UPLOAD', !empty($default->FILE_UPLOAD) ? $default->FILE_UPLOAD : '', 'class="span6"'); ?>
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
$(function() {
    $("#tgltera").datepicker();
});
</script>