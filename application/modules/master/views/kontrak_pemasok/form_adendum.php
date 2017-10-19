<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Role Management'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <div class="control-group">
            <label for="password" class="control-label">Pemasok <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_PEMASOK', $pemasok_options, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <div class="controls" style="display:none">
                <?php echo form_input('ID_KONTRAK_PEMASOK', !empty($default->ID_KONTRAK_PEMASOK) ? $default->ID_KONTRAK_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">No Adendum <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_ADENDUM_PEMASOK', !empty($default->NO_ADENDUM_PEMASOK) ? $default->NO_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Keterangan Adendum <span class="required">*</span> : </label> 
            <div class="controls">
                <?php echo form_input('KET_ADENDUM_PEMASOK', !empty($default->KET_ADENDUM_PEMASOK) ? $default->KET_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <hr>
            <label for="password" class="control-label">Tgl Kontrak <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_ADENDUM_PEMASOK', !empty($default->TGL_ADENDUM_PEMASOK) ? $default->TGL_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Judul Kontrak <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('JUDUL_ADENDUM_PEMASOK', !empty($default->JUDUL_ADENDUM_PEMASOK) ? $default->JUDUL_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Awal : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AWAL_ADENDUM_PEMASOK', !empty($default->PERIODE_AWAL_ADENDUM_PEMASOK) ? $default->PERIODE_AWAL_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Akhir : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AKHIR_ADENMDUM_PEMASOK', !empty($default->PERIODE_AKHIR_ADENMDUM_PEMASOK) ? $default->PERIODE_AKHIR_ADENMDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Jenis Kontrak : </label> 
            <div class="controls">
                <?php echo form_dropdown('JENIS_AKHIR_ADENDUM_PEMASOK', $jns_kontrak_options, !empty($default->JENIS_AKHIR_ADENDUM_PEMASOK) ? $default->JENIS_AKHIR_ADENDUM_PEMASOK : '', 'class="span2"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Volume : </label> 
            <div class="controls">
                <?php echo form_input('VOL_AKHIR_ADENDUM_PEMASOK', !empty($default->VOL_AKHIR_ADENDUM_PEMASOK) ? $default->VOL_AKHIR_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Alpha : </label> 
            <div class="controls">
                <?php echo form_input('ALPHA_ADENDUM_PEMASOK', !empty($default->ALPHA_ADENDUM_PEMASOK) ? $default->ALPHA_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Rupiah Kontrak : </label> 
            <div class="controls">
                <?php echo form_input('RP_ADENDUM_PEMASOK', !empty($default->RP_ADENDUM_PEMASOK) ? $default->RP_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Penjamin Kontrak : </label> 
            <div class="controls">
                <?php echo form_input('PENJAMIN_ADENDUM_PEMASOK', !empty($default->PENJAMIN_ADENDUM_PEMASOK) ? $default->PENJAMIN_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">No Penjamin Kontrak : </label> 
            <div class="controls">
                <?php echo form_input('NO_PENJAMIN_ADENDUM_PEMASOK', !empty($default->NO_PENJAMIN_ADENDUM_PEMASOK) ? $default->NO_PENJAMIN_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Nominal Jaminan : </label> 
            <div class="controls">
                <?php echo form_input('NOMINAL_ADENDUM_PEMASOK', !empty($default->NOMINAL_ADENDUM_PEMASOK) ? $default->NOMINAL_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Tgl Berakhir Jaminan : </label> 
            <div class="controls">
                <?php echo form_input('TGL_AKHIR_ADENDUM_PEMASOK', !empty($default->TGL_AKHIR_ADENDUM_PEMASOK) ? $default->TGL_AKHIR_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <!-- <br>
            <label for="password" class="control-label">Upload Dokumen : </label> 
            <div class="controls">
                    <?php echo form_upload('ID_DOC_PEMASOK', !empty($default->ID_DOC_PEMASOK) ? $default->ID_DOC_PEMASOK : '', 'class="span6"'); ?>
            </div> -->

        </div>
    </div><br>
    
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
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
    $('select[name="ID_PEMASOK"]').attr("disabled", true);
</script>            
