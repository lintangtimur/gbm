
<!-- /**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
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
            <label for="password" class="control-label">Status <span class="required">*</span> : </label>
            <div class="controls">
            <?php echo form_dropdown('VALUE_SETTING', $parent_options, !empty($default->STATUS) ? $default->STATUS : '', 'class="span3", disabled="True"'); ?> 
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Tutup <span class="required">*</span> :  </label>
            <div class="controls">
            <?php echo form_input('TGL_TUTUP', !empty($default->TGL_TUTUP) ? $default->TGL_TUTUP : '', 'class="span6 input-append date form_datetime"'); ?>           
            </div>
        </div>

        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
  $(".form_datetime").datetimepicker({
        dateformat: "yyyy-mm-dd",
        timeFormat:  "hh:mm:ss",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

</script>