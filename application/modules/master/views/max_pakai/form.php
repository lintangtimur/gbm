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
            <label for="password" class="control-label">Periode<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('THBL_MAX_PAKAI', !empty($default->THBL_MAX_PAKAI) ? $default->THBL_MAX_PAKAI : '', 'class="span6" placeholder="TahunBulan" maxlength=6'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Level 4<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6 chosen"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Jenis Bahan Bakar<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $jnsbbm_options, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6 chosen"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Volume Pemakaian Lalu <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VOLUME_MAX_PAKAI', !empty($default->VOLUME_MAX_PAKAI) ? $default->VOLUME_MAX_PAKAI : '', 'class="span6"'); ?>
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
	$('.chosen').chosen();
	$('input[name=VOLUME_MAX_PAKAI]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared:function () { self.Value(''); }
    });
</script>