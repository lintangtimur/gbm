<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

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
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="NO_PEMAKAIAN" class="form-control span4" placeholder="Nomor Pemakaian">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Catat Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="TGL_CATAT" class="form-control span12 form_datetime" placeholder="Tanggal Catat"
                       required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="TGL_PENGAKUAN" class="form-control span12 form_datetime" placeholder="Tanggal Pengakuan" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Level 4<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SLOC', $option_level, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('VALUE_SETTING', $option_jenis_pemakaian, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">NO TUG 8/9<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="NO_TUG" class="form-control span4" placeholder="Volume Penerimaan">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6"'); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Vol. Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="VOL_PEMAKAIAN" class="form-control span4" placeholder="Volume Pemakaian">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">KETERANGAN<span class="required">*</span> : </label>
            <div class="controls">
                <input type="text" name="KETERANGAN" class="form-control span4" placeholder="Keterangan Pemakaian">
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- perhitungan End -->
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

</script>