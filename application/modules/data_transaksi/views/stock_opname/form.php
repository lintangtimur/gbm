
<!-- /**
 * @module TRANSAKSI PERHITUNGAN BBM
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


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
            <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        </div>
                         <div class="panel-body">
                         <div class="col-md-6">
                            <div class="control-group">
                            <label for="password" class="control-label">No Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('NAMA_DEPO', !empty($default->NAMA_DEPO) ? $default->NAMA_DEPO : '', 'class="span6"'); ?>
                             </div>
                            </div>
                            <div class="control-group">
                            <label for="password" class="control-label">Pilih Jenis Bahan Bakar <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_dropdown('ID_JNS_BHN_BKR', $parent_options, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6"'); ?> 
                            </div>
                            </div>
                            <div class="control-group">
                            <label for="password" class="control-label">Pilih Pembangkit <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_dropdown('SLOC', $parent_options_pem, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6"'); ?> 
                            </div>
                            </div>                          
                        </div>
                        <div class="col-md-6">
                          <div class="control-group">
                            <label for="password" class="control-label">Volume Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('VOLUME_STOCKOPNAME', !empty($default->VOLUME_STOCKOPNAME) ? $default->VOLUME_STOCKOPNAME : '', 'class="span7"'); ?>
                             </div>
                            </div>
                          <div class="control-group">
                            <label for="password" class="control-label">Tanggal BA Stock Opname <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('TGL_BA_STOCKOPNAME', !empty($default->TGL_BA_STOCKOPNAME) ? $default->TGL_BA_STOCKOPNAME : '', 'class="span7", id="datepicker"'); ?>
                            </div>
                          </div>
                          <div class="control-group">
                            <label for="password" class="control-label">Tanggal Pengakuan <span class="required">*</span> : </label>
                            <div class="controls">
                            <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span7", id="datepicker1"'); ?>
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
                    </div>
                <div class="form-actions">
                 <div class="col-md-9">
                    <center>
                <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
                </center>
                </div>
                </div>
            </div>
    </div>
            <!-- perhitungan End -->
        <?php echo form_close(); ?>
    </div>
</div>

 <script>
  $( function() {
    $.datepicker._gotoToday = function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);

            var date = new Date();
            this._setDate(inst,date);
            this._hideDatepicker();
            
        }

    $( "#datepicker" ).datepicker({
         showButtonPanel: true
    });
     $( "#datepicker1" ).datepicker({
        showButtonPanel: true
    });

    $('.dropify').dropify();
   
  } );
  </script>
</script>