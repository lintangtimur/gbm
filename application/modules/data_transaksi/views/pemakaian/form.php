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

        <!--<div class="control-group">
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php //echo form_input('NO_PEMAKAIAN', !empty($default->NO_MUTASI_PEMAKAIAN) ? $default->NO_MUTASI_PEMAKAIAN : '', 'class="span6" placeholder="Nomor Pemakaian"'); ?>
            </div>
        </div>-->
        <div class="control-group">
            <label class="control-label">Jenis Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('VALUE_SETTING', $option_jenis_pemakaian, !empty($default->JENIS_PEMAKAIAN) ? $default->JENIS_PEMAKAIAN : '', 'class="span3"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label class="control-label">NO Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_TUG', !empty($default->NO_TUG) ? $default->NO_TUG : '', 'class="span4" placeholder="NO Pemakaian"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Catat Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_CATAT', !empty($default->TGL_PENCATATAN) ? $default->TGL_PENCATATAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Catat" id="TGL_CATAT"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_MUTASI_PENGAKUAN) ? $default->TGL_MUTASI_PENGAKUAN : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Pengakuan" id="TGL_PENGAKUAN"'); ?>
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
            <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm"'); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Vol. Pemakaian (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VOL_PEMAKAIAN', !empty($default->VOLUME_PEMAKAIAN) ? $default->VOLUME_PEMAKAIAN : '', 'class="span4" placeholder="Volume Pemakaian"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan : </label>
            <div class="controls">
                <?php echo form_input('KETERANGAN', !empty($default->KET_MUTASI_PEMAKAIAN) ? $default->KET_MUTASI_PEMAKAIAN : '', 'class="span4" placeholder="Keterangan Pemakaian"'); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php 
            if ($this->laccess->otoritas('edit')) {
                echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')"));
            }?>
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

	$( "#pembangkit" ).change(function() {
		var sloc = $(this).val();
		load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");
	});
	
    // start
    function cekTanggalCatat(){
        var strStart = $("input[name=TGL_CATAT]").val();
        var strEnd = $("input[name=TGL_PENGAKUAN]").val();

        var dateStart = strStart.substring(0, 2);
        var monthStart = strStart.substring(3, 5);
        var yearStart = strStart.substring(6, 10);

        var dateEnd = strEnd.substring(0, 2);
        var monthEnd = strEnd.substring(3, 5);
        var yearEnd = strEnd.substring(6, 10);

        var vDateStart = yearStart + "-" + monthStart + "-" + dateStart;
        var vDateEnd = yearEnd + "-" + monthEnd + "-" + dateEnd;

        if (vDateEnd > vDateStart) {
            $('input[name=TGL_PENGAKUAN').datepicker('update', strStart);
        }

        $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', $("input[name=TGL_CATAT]").val());
       
    }

    function cekTanggalPengakuan(){
        var strStart = $("input[name=TGL_CATAT]").val();
        var strEnd = $("input[name=TGL_PENGAKUAN]").val();

        var dateStart = strStart.substring(0, 2);
        var monthStart = strStart.substring(3, 5);
        var yearStart = strStart.substring(6, 10);

        var dateEnd = strEnd.substring(0, 2);
        var monthEnd = strEnd.substring(3, 5);
        var yearEnd = strEnd.substring(6, 10);

        var vDateStart = yearStart + "-" + monthStart + "-" + dateStart;
        var vDateEnd = yearEnd + "-" + monthEnd + "-" + dateEnd;

        if (vDateEnd > vDateStart) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan tidak boleh melebihi Tanggal Catat</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENGAKUAN').datepicker('update', strStart);
        }
    }

    $("input[name=TGL_CATAT]").change(cekTanggalCatat);
    $("input[name=TGL_PENGAKUAN]").focusout(cekTanggalPengakuan);
    $("input[name=TGL_PENGAKUAN]").click(cekTanggalCatat);
    $("input[name=button-save]").click(cekTanggalPengakuan);

    // end

    // start
    function formatDateDepan(date) {
      var tanggal =date.getDate();
      var bulan = date.getMonth()+1;
      var tahun = date.getFullYear();

      if(tanggal<10){
         tanggal='0'+tanggal;
        } 

      if(bulan<10){
         bulan='0'+bulan;
        } 

      return tanggal + "-" + bulan + "-" + tahun;
    }

    function setDefaulthTglCatat(){
        var date = new Date();
        var tanggal = formatDateDepan(date);

        $('input[name=TGL_CATAT]').datepicker('setEndDate', tanggal);
    }

    function checkDefaulthTglCatat(){
        var date = new Date();
        var dateBatasan =  formatDateDepan(date);
        var dateCatat = $("input[name=TGL_CATAT]").val();

        if (dateCatat > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Catat Pemakaian tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_CATAT').datepicker('update', date);
         
        }

    }

    $("input[name=TGL_CATAT]").focusout(checkDefaulthTglCatat);
    
    $(function() {
        setDefaulthTglCatat();
    });

    // end

    // var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";

    // if( vLevelUser <= 2) {
    //     $("#button-save").hide();
    // }

    $('input[name=VOL_PEMAKAIAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv4/'+stateID;
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