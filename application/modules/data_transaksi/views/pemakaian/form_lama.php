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
        <div class="control-group" id="regional" style="<?php echo !empty($read[0]) ? $read[0] : '';?>">
            <label  class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_regional', $option_regional, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2 " id="kode_regional"'); ?>
            </div>
        </div>
        <div class="control-group" id="level1" style="<?php echo !empty($read[1]) ? $read[1] : '';?>">
            <label  class="control-label">Level 1<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level1', !empty($option_level1) ? $option_level1 : array(), !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level1"'); ?>
            </div>
        </div>
		<div class="control-group" id="level2" style="<?php echo !empty($read[2]) ? $read[2] : '';?>">
            <label  class="control-label">Level 2<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level2', !empty($option_level2) ? $option_level2 : array(), !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level2"'); ?>
            </div>
        </div>
		<div class="control-group" id="level3" style="<?php echo !empty($read[3]) ? $read[3] : '';?>">
            <label  class="control-label">Level 3<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level3', !empty($option_level3) ? $option_level3 : array(), !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level3"'); ?>
            </div>
        </div>
		<div class="control-group" id="level4" style="<?php echo !empty($read[4]) ? $read[4] : '';?>">
            <label  class="control-label">Level 4<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level4', !empty($option_level4) ? $option_level4 : array(), !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level4"'); ?>
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
	idlevel = "<?php echo $this->session->userdata('level_user');?>";
	$( "#kode_regional" ).change(function() {
		load_level('<?php echo $loadlevel; ?>1/'+$(this).val(),'', "#kode_level1");
	});
	$( "#kode_level1" ).change(function() {
		load_level('<?php echo $loadlevel; ?>2/'+$(this).val(),'', "#kode_level2");
	});
	$( "#kode_level2" ).change(function() {
		load_level('<?php echo $loadlevel; ?>3/'+$(this).val(),'', "#kode_level3");
	});
	$( "#kode_level3" ).change(function() {
		a = $("#kode_level2").val();
		b = $("#kode_level3").val();
		c = a + ".." + b;
		load_level('<?php echo $loadlevel; ?>4/'+c,'', "#kode_level4");
	});
	
</script>