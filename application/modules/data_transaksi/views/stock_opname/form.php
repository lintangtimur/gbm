
<!-- /**
	* @module STOCK OPNAME
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
		<!--perhitungan Start -->
		<div class="control-group">
			<br>
			<label for="password" class="control-label">No Stok Opname <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('NO_STOCKOPNAME', !empty($default->NO_STOCKOPNAME) ? $default->NO_STOCKOPNAME : '', 'class="span3"'); ?>
			</div>
			<br>
			<label for="password" class="control-label">Tanggal BA Stock Opname <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('TGL_BA_STOCKOPNAME', !empty($default->TGL_BA_STOCKOPNAME) ? $default->TGL_BA_STOCKOPNAME : '', 'class="span3 input-append date form_datetime", id="datepicker"'); ?>
			</div>
			<br>
			<label for="password" class="control-label">Tanggal Pengakuan <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span3 input-append date form_datetime"'); ?>
			</div>
			<br>
			<label  class="control-label">Regional <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 1<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 2<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 3<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Pembangkit<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="pembangkit", class="span6"'); ?>
			</div>
			<br>
			<label for="password" class="control-label">Pilih Jenis Bahan Bakar <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $parent_options_jns, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="jnsbbm", class="span3"'); ?> 
			</div>
		</div>                          
		<div class="control-group">
			<br>
			<label for="password" class="control-label">Volume Stock Opname (L)<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('VOLUME_STOCKOPNAME', !empty($default->VOLUME_STOCKOPNAME) ? $default->VOLUME_STOCKOPNAME : '', 'class="span3"'); ?>
			</div>
			
		</div>
		<div class="md-card-content">
			<label for="password" class="control-label">Upload File (Maks 4 MB) <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_STOCKOPNAME) ? $default->PATH_STOCKOPNAME : '', 'class="span6"'); ?>
			</div>
			<div class="controls" id="dokumen">
				<a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="SO" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_STOCKOPNAME) ? $default->PATH_STOCKOPNAME : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
			</div>
			<!--<div class="controls" id="dokumen">
				<a href="<?php echo base_url().'assets/upload/stockopname/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
			</div>-->
		</div>		 
		<div class="form-actions">
			<br>
			<?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
			<?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
		</div>
		<!-- perhitungan End -->
        <?php echo form_close(); ?>
		</div>
</div>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
	});
	$( "#pembangkit" ).change(function() {
		var sloc = $(this).val();
		load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");
	});
    function cekTanggalBa(){
        var vDateStart = $("input[name=TGL_BA_STOCKOPNAME]").val();
        var vDateEnd = $("input[name=TGL_PENGAKUAN]").val();
		
        if (vDateEnd > vDateStart) {
            $('input[name=TGL_PENGAKUAN').datepicker('update', vDateStart);
		}
		
        $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', $("input[name=TGL_BA_STOCKOPNAME]").val());
		
	}
	
    function cekTanggalPengakuan(){
        var vDateStart = $("input[name=TGL_BA_STOCKOPNAME]").val();
        var vDateEnd = $("input[name=TGL_PENGAKUAN]").val();
		
        if (vDateEnd > vDateStart) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan tidak boleh melebihi Tanggal Berita Acara</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENGAKUAN').datepicker('update', vDateStart);
		}
	}
	
    $("input[name=TGL_BA_STOCKOPNAME]").change(cekTanggalBa);
    $("input[name=TGL_PENGAKUAN]").focusout(cekTanggalPengakuan);
    $("input[name=TGL_PENGAKUAN]").click(cekTanggalBa);
    $("input[name=button-save]").click(cekTanggalPengakuan);
	
	// start
	
    function formatDateBelakang(date) {
      var tanggal =date.getDate();
      var bulan = date.getMonth()+1;
      var tahun = date.getFullYear();

      if(tanggal<10){
         tanggal='0'+tanggal;
        } 

      if(bulan<10){
         bulan='0'+bulan;
        } 

      return tahun + "-" + bulan + "-" + tanggal;
	}
	
    function setDefaulthTglBa(){
        var date = new Date();
        var tanggal = formatDateBelakang(date);
		
        $('input[name=TGL_BA_STOCKOPNAME]').datepicker('setEndDate', tanggal);
	}
	
    function checkDefaulthTglBa(){
        var date = new Date();
		
        var dateBatasan =formatDateBelakang(date);
        var dateCatat = $("input[name=TGL_BA_STOCKOPNAME]").val();
		
        if (dateCatat > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Berita Acara tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_BA_STOCKOPNAME').datepicker('update', date);
			
		}
		
	}
	
    $("input[name=TGL_BA_STOCKOPNAME]").focusout(checkDefaulthTglBa);
    
    $(function() {
        setDefaulthTglBa();
	});
	
    // end
	
    $('input[name=VOLUME_STOCKOPNAME]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
	});
	
</script> 


<script type="text/javascript">
    jQuery(function($) {
		
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
            $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
		}
		
        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv1/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv2/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv3/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv4/'+stateID;
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
	});
</script>           
