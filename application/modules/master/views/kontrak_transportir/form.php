<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#detail">Detail</a></li>
          <li><a data-toggle="tab" href="#addendum">Menu 1</a></li>
        </ul>

        <div class="tab-content">
          <div id="detail" class="tab-pane fade in active">
                <div class="control-group">
                    <label for="password" class="control-label">No Kontrak <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('NO_KONTRAK', !empty($default->NO_KONTRAK) ? $default->NO_KONTRAK : '', 'class="span6"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Pilih Transportir<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('TRANSPORTIR', $option_transportir, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class="span6"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tanggal Tera<span class="required">*</span> : </label>
                    <div class="controls">
                    <?php $attributes = 'id="TGLKONTRAK" placeholder="Tanggal Kontrak"'; echo form_input('TGLKONTRAK', set_value('TGLKONTRAK'), $attributes); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Periode (Bulan)<span class="required">**</span></label>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Jumlah Pasokan <span class="required"> *</span> : </label>
                    <div class="controls">
                        <?php echo form_input('JML_PASOKAN', !empty($default->JML_PASOKAN) ? $default->JML_PASOKAN : '', 'class="span2", id="jmlpas"'); ?>
                    </div>
                </div>
                <div id="pasokan" class="control-group" hidden>
                    <label for="password" class="control-label">Harga Transport (Rp/Lt) <span class="required"> *</span> : </label>
                        <div class="controls" id="inputan">
                            <table>
                                <tr><?php echo form_input('HARGA', !empty($default->HARGA) ? $default->HARGA : '', 'class="span3", placeholder="Harga"'); ?></tr>    
                                <tr><?php echo form_dropdown('option_depo', $option_depo, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class="span3"'); ?></tr>    
                                <tr><?php echo form_dropdown('option_pembangkit', $option_pembangkit, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class="span3"'); ?></tr>    
                                <tr><?php echo form_dropdown('option_jalur', $option_jalur, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class="span3"'); ?></tr> 
                            </table>
                        </div><br/>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Nilai Kontrak (Rp)<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('NILAI_KONTRAK', !empty($default->NILAI_KONTRAK) ? $default->NILAI_KONTRAK : '', 'class="span6"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Keterangan<span class="required">*</span> : </label>
                    <div class="controls">
                          <?php echo form_input('KETERANGAN', !empty($default->KETERANGAN) ? $default->KETERANGAN : '', 'class="span6"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Upload File<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_upload('FILE_UPLOAD', !empty($default->FILE_UPLOAD) ? $default->FILE_UPLOAD : '', 'class="span6"'); ?>
                    </div>
                </div>
          </div>
          <div id="addendum" class="tab-pane fade">
            <div class="control-group">
            <?php echo anchor(null, '<i class="icon-plus"></i> Tambah Addendum', array('id' => 'button-tambah', 'class' => 'blue btn', 'onclick' => "tambah_addendum()")); ?> <br/>
            </div>
            <div class="content_table">
                <table class="table table-striped table-bordered table-hover datatable dataTable">
                  <thead>
                      <tr>
                          <td>Nomor</td>
                          <td>Addendum</td>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
          </div>
        </div> <!-- end tab content -->

       
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<script type="text/javascript">
$(function() {
    $("#TGLKONTRAK").datepicker();
});
</script>
<script type="text/javascript">
   $(document).keyup(function (e) {
    if ($("#jmlpas:focus") && (e.keyCode === 13)) {
        var x = $("#jmlpas").val();
       $("#pasokan").show();
        
    }
 });
</script>