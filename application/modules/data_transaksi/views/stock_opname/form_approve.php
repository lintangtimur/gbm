
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
                            <?php echo form_dropdown('ID_JNS_BHN_BKR', $parent_options_jns, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6"'); ?> 
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
                            <label for="password" class="control-label">Volume Stock Opname (L)<span class="required">*</span> : </label>
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
                            <div style="display:none">
                                <input type="text" id="setuju" name="setuju">
                                <?php echo anchor(null, '<i class="icon-check"></i> ok', array('id' => 'button-ok', 'class' => 'red btn',
                                'value' => 'tolak','onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                            </div> 
                        <div class="md-card-content">
                            <label for="password" class="control-label">Upload File<span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_STOCKOPNAME) ? $default->PATH_STOCKOPNAME : '', 'class="span6"'); ?>
                            </div>
                            <div class="controls" id="dokumen">
                             <a href="<?php echo base_url().'assets/upload_stock_opname/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                            </div>
                        </div>
                        </div>
                    
                <div class="form-actions">
                <div class="col-md-9">
                <br>
                 <?php echo anchor(null, '<i class="icon-check"></i> Setujui', array('id' => 'button-approve', 'class' => 'blue btn',
                'value' => 'setuju', 'onclick' => "simpan_datax(this.id, '#finput', '#button-back')")); ?>
            

                <?php echo anchor(null, '<i class="icon-check"></i> Tolak', array('id' => 'button-tolak', 'class' => 'red btn',
                'value' => 'tolak','onclick' => "simpan_datax(this.id, '#finput', '#button-back')")); ?>

                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
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

    $("#button-approve").click(function() {
        $('#setuju').val('2');
        $( "#button-ok" ).click();
    });

    $("#button-tolak").click(function() {
        $('#setuju').val('3');
        $( "#button-ok" ).click();
    });
</script>            

