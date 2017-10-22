
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
       
        <div class="col-md-11.5">
                        <div class="col-md-5">
                            <div class="control-group">
                            <br>
                            <label for="password" class="control-label">No Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('NO_STOCKOPNAME', !empty($default->NO_STOCKOPNAME) ? $default->NO_STOCKOPNAME : '', 'class="span6"'); ?>
                             </div>
                             <br>
                            <label for="password" class="control-label">Pilih Jenis Bahan Bakar <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_dropdown('ID_JNS_BHN_BKR', $parent_options, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6"'); ?> 
                            </div>
                            <br>
                            <label for="password" class="control-label">Pilih Pembangkit <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_dropdown('SLOC', $parent_options_pem, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6"'); ?> 
                            </div>
                            </div>                          
                        </div>
                        <div class="col-md-5">
                          <div class="control-group">
                          <br>
                            <label for="password" class="control-label">Volume Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('VOLUME_STOCKOPNAME', !empty($default->VOLUME_STOCKOPNAME) ? $default->VOLUME_STOCKOPNAME : '', 'class="span6"'); ?>
                             </div>
                             <br>
                            <label for="password" class="control-label">Tanggal BA Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('TGL_BA_STOCKOPNAME', !empty($default->TGL_BA_STOCKOPNAME) ? $default->TGL_BA_STOCKOPNAME : '', 'class="span6 input-append date form_datetime", id="datepicker"'); ?>
                            </div>
                            <br>
                            <label for="password" class="control-label">Tanggal Pengakuan <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span6 input-append date form_datetime"'); ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-11">
                        <div class="md-card-content">
                            <br>
                            <center><h3 class="heading_a uk-margin-small-bottom">
                             Uploas Max size (2 MB)
                            </h3></center>
                            <br>
                            <input type="file" id="input-file-e" class="dropify" data-height="150" data-max/>
                        </div>
                        </div>
                    
                <div class="form-actions">
                <div class="col-md-9">
                <br>
                <center>
                <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
                </center>
                </div>
			</div>
            <!-- perhitungan End -->
        <?php echo form_close(); ?>
		</div>
		</div>
</div>
 <script>
  $( function() {
    $('.dropify').dropify();
  } );
 </script>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $('input[name=VOLUME_STOCKOPNAME]').inputmask("numeric", {radixPoint: ".",groupSeparator: ",",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
</script>            

