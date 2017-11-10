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
                <?php echo form_input('NO_PEMAKAIAN', !empty($default->NO_MUTASI_PEMAKAIAN) ? $default->NO_MUTASI_PEMAKAIAN : '', 'class="span6" placeholder="Nomor Pemakaian" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Catat Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_CATAT', !empty($default->TGL_PENCATATAN) ? $default->TGL_PENCATATAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Catat" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_MUTASI_PENGAKUAN) ? $default->TGL_MUTASI_PENGAKUAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Pengakuan" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'disabled class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level 1<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Level 2<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Level 3<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'disabled class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('VALUE_SETTING', $option_jenis_pemakaian, !empty($default->JENIS_PEMAKAIAN) ? $default->JENIS_PEMAKAIAN : '', 'class="span3"  disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">NO TUG 8/9<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_TUG', !empty($default->NO_TUG) ? $default->NO_TUG : '', 'class="span3" placeholder="NO TUG 8/9" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" disabled'); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Vol. Pemakaian (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VOL_PEMAKAIAN', !empty($default->VOLUME_PEMAKAIAN) ? $default->VOLUME_PEMAKAIAN : '', 'class="span4" placeholder="Volume Pemakaian" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan : </label>
            <div class="controls">
                <?php echo form_input('KETERANGAN', !empty($default->KET_MUTASI_PEMAKAIAN) ? $default->KET_MUTASI_PEMAKAIAN : '', 'class="span4" placeholder="Keterangan Pemakaian" disabled'); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- perhitungan End -->
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">

    $('input[name=VOL_PEMAKAIAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });

</script>