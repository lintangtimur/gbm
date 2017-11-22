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
                <label class="control-label">Tanggal Penerimaan (DO/TUG)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_PENERIMAAN', !empty($default->TGL_PENERIMAAN) ? $default->TGL_PENERIMAAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Penerimaan (DO/TUG)" id="TGL_PENERIMAAN"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Pengakuan Fisik<span class="required">*</span> : </label>
                <div class="controls">
                     <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Pengakuan Fisik" id="TGL_PENGAKUAN"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Transportir<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" id="pembangkit"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('VALUE_SETTING', $option_jenis_penerimaan, !empty($default->JNS_PENERIMAAN) ? $default->JNS_PENERIMAAN : '', 'class="span3"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_PENERIMAAN', !empty($default->NO_MUTASI_TERIMA) ? $default->NO_MUTASI_TERIMA : '', 'class="span4" placeholder="Nomor Penerimaan"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm"'); ?>
                </div>
            </div>
			
			<div class="control-group" id="komponen" style="<?php echo !empty($default->IS_MIX_BBM) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('KOMPONEN', $option_komponen, !empty($default->ID_KOMPONEN_BBM) ? $default->ID_KOMPONEN_BBM : '', 'class="span3" id="cbokomponen"'); ?>
					<input type="hidden" id="ismix" name="ismix" value="<?php echo !empty($default->IS_MIX_BBM) ? $default->IS_MIX_BBM : '' ;?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Volume DO/TUG<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN', !empty($default->VOL_TERIMA) ? $default->VOL_TERIMA : '', 'class="span4" placeholder="Volume DO / TUG"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Volume Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN_REAL', !empty($default->VOL_TERIMA_REAL) ? $default->VOL_TERIMA_REAL : '', 'class="span4" placeholder="Volume Penerimaan"'); ?>
                </div>
                <div style="display:none">
                    <?php echo form_input('STATUS_MUTASI_TERIMA', !empty($default->STATUS_MUTASI_TERIMA) ? $default->STATUS_MUTASI_TERIMA : '0'); ?>
                </div> 
            </div>
            <div class="form-actions">
                <?php 
                if ($this->laccess->otoritas('edit')) {
                    echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back');"));
                }?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
            </div>
            <?php
        echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">

	$( "#pembangkit" ).change(function() {
		var sloc = $(this).val();
		load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");
	});
	
	$("#jnsbbm").change(function(){
		var id  = $(this).val();
		check_jenis_bbm('<?php echo $urlcheckjnsbbm;?>/' + id, "#komponen", "#cbokomponen");
	});
	
    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    // start
    function checkTanggalPenerimaan(){
        var vDateStart = $("input[name=TGL_PENERIMAAN]").val();
        var vDateEnd = $("input[name=TGL_PENGAKUAN]").val();

         // var vDateStart = $("input[name=TGL_PENGAKUAN]").val();
        // var vDateEnd = $("input[name=TGL_PENERIMAAN]").val();


        if (vDateEnd > vDateStart) {
            $('input[name=TGL_PENGAKUAN').datepicker('update', vDateStart);
        }

        $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', $("input[name=TGL_PENERIMAAN]").val());
    }

    function checkTanggalPengakuan(){
        var vDateStart = $("input[name=TGL_PENERIMAAN]").val();
        var vDateEnd = $("input[name=TGL_PENGAKUAN]").val();

        if (vDateEnd > vDateStart) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan Fisik tidak boleh melebihi Tanggal Penerimaan (DO/TUG)</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENGAKUAN').datepicker('update', vDateStart);
        }
    }

    $("input[name=TGL_PENERIMAAN]").change(checkTanggalPenerimaan);
    $("input[name=TGL_PENGAKUAN]").focusout(checkTanggalPengakuan);
    $("input[name=TGL_PENGAKUAN]").click(checkTanggalPenerimaan);
    $("input[name=button-save]").click(checkTanggalPengakuan);

    // end

    // start
    function formatDateDepan(date) {
     return date.getDate()+1 + "-" + date.getMonth() + "-" + date.getFullYear();
    }

    function setDefaulthTglPenerimaan(){
        var date = new Date();
        date.setDate(date.getDate() + 1);
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();

        $('input[name=TGL_PENERIMAAN]').datepicker('setEndDate', new Date(currentYear, currentMonth, currentDate));
    }

    function checkDefaulthTglPenerimaan(){
         var date = new Date();
         var datePengakuan = $("input[name=TGL_PENGAKUAN]").val();
 

        var dateBatasan =  formatDateDepan(date);
        var datePenerimaan = $("input[name=TGL_PENERIMAAN]").val();

        if (datePenerimaan > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Penerimaan (DO/TUG) tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENERIMAAN').datepicker('update', date);
         
        }
        else if(datePenerimaan>datePengakuan){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Penerimaan (DO/TUG) tidak boleh melebihi Tanggal Pengakuan Fisik</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENERIMAAN').datepicker('update', datePengakuan);
        }

    }
    $("input[name=TGL_PENERIMAAN]").focusout(checkDefaulthTglPenerimaan);

    // set tanggal penerimaan fisik
    $(function() {
    setDefaulthTglPenerimaan();
  });
  
    // end

    $('input[name=VOL_PENERIMAAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=VOL_PENERIMAAN_REAL]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    
    function setDefaultLv1(){
        $('select[name="COCODE"]').empty();
        $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('select[name="PLANT"]').empty();
        $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3(){
        $('select[name="STORE_SLOC"]').empty();
        $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4(){
        $('select[name="SLOC"]').empty();
        $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="COCODE"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="PLANT"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                }
            });
        }
    });

</script>



