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
            <label  class="control-label">Pemasok<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_PEMASOK', $pemasok_options, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6 chosen" disabled'); ?>
            </div>
        </div>

        <div class="control-group">
            <label for="password" class="control-label">Tgl Kontrak <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_KONTRAK_PEMASOK', !empty($default->TGL_KONTRAK_PEMASOK) ? $default->TGL_KONTRAK_PEMASOK : '', 'class="span2 input-append date form_datetime" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">No PJBBBM <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NOPJBBM_KONTRAK_PEMASOK', !empty($default->NOPJBBM_KONTRAK_PEMASOK) ? $default->NOPJBBM_KONTRAK_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Judul Kontrak <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('JUDUL_KONTRAK_PEMASOK', !empty($default->JUDUL_KONTRAK_PEMASOK) ? $default->JUDUL_KONTRAK_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Awal : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AWAL_KONTRAK_PEMASOK', !empty($default->PERIODE_AWAL_KONTRAK_PEMASOK) ? $default->PERIODE_AWAL_KONTRAK_PEMASOK : '', 'class="span2 input-append date form_datetime" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Akhir : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AKHIR_KONTRAK_PEMASOK', !empty($default->PERIODE_AKHIR_KONTRAK_PEMASOK) ? $default->PERIODE_AKHIR_KONTRAK_PEMASOK : '', 'class="span2 input-append date form_datetime" disabled'); ?>
            </div>
        </div>

        <div class="control-group">
            <label  class="control-label">Jenis Kontrak<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('JENIS_KONTRAK_PEMASOK', $jns_kontrak_options, !empty($default->JENIS_KONTRAK_PEMASOK) ? $default->JENIS_KONTRAK_PEMASOK : '', 'class="span2 chosen" disabled'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <label for="password" class="control-label">Volume (L) : </label> 
            <div class="controls">
                <?php echo form_input('VOLUME_KONTRAK_PEMASOK', !empty($default->VOLUME_KONTRAK_PEMASOK) ? $default->VOLUME_KONTRAK_PEMASOK : '', 'class="span3" disabled'); ?>
            </div>
            <br>
            <!-- <label for="password" class="control-label">Alpha : </label> 
            <div class="controls">
                <?php echo form_input('ALPHA_KONTRAK_PEMASOK', !empty($default->ALPHA_KONTRAK_PEMASOK) ? $default->ALPHA_KONTRAK_PEMASOK : '', 'class="span3" disabled'); ?>
            </div>
            <br> -->
            <label for="password" class="control-label">Nilai Kontrak (Rp): </label> 
            <div class="controls">
                <?php echo form_input('RUPIAH_KONTRAK_PEMASOK', !empty($default->RUPIAH_KONTRAK_PEMASOK) ? $default->RUPIAH_KONTRAK_PEMASOK : '', 'class="span3" disabled'); ?>
                <sup>Termasuk PPN 10 %</sup>
            </div>
            <br>
            <label for="password" class="control-label">Penjamin Kontrak : </label> 
            <div class="controls">
                <?php echo form_input('PENJAMIN_KONTRAK_PEMASOK', !empty($default->PENJAMIN_KONTRAK_PEMASOK) ? $default->PENJAMIN_KONTRAK_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">No Penjamin Kontrak : </label> 
            <div class="controls">
                <?php echo form_input('NO_PENJAMIN_KONTRAK_PEMASOK', !empty($default->NO_PENJAMIN_KONTRAK_PEMASOK) ? $default->NO_PENJAMIN_KONTRAK_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Nominal Jaminan (Rp) : </label> 
            <div class="controls">
                <?php echo form_input('NOMINAL_JAMINAN_KONTRAK', !empty($default->NOMINAL_JAMINAN_KONTRAK) ? $default->NOMINAL_JAMINAN_KONTRAK : '', 'class="span3" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Tgl Berakhir Jaminan : </label> 
            <div class="controls">
                <?php echo form_input('TGL_BERAKHIR_JAMINAN_KONTRAK', !empty($default->TGL_BERAKHIR_JAMINAN_KONTRAK) ? $default->TGL_BERAKHIR_JAMINAN_KONTRAK : '', 'class="span2 input-append date form_datetime" disabled'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Keterangan : </label> 
            <div class="controls">
                <?php echo form_input('KET_KONTRAK_PEMASOK', !empty($default->KET_KONTRAK_PEMASOK) ? $default->KET_KONTRAK_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <br>
            <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_DOC_PEMASOK) ? $default->PATH_DOC_PEMASOK : ''?>">
            <label for="password" class="control-label" id="up_nama">Upload Dokumen : </label> 
            <div class="controls" id="up_file">
                    <?php echo form_upload('ID_DOC_PEMASOK', !empty($default->ID_DOC_PEMASOK) ? $default->ID_DOC_PEMASOK : '', 'class="span6" disabled'); ?>
            </div>
            <label for="password" class="control-label"> </label> 
            <div class="controls" id="dokumen">
                <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
            </div>
			 <!-- <div class="controls" id="dokumen">
				<a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php //echo $url_getfile;?>" data-filename="<?php //echo !empty($default->PATH_DOC_PEMASOK) ? $default->PATH_DOC_PEMASOK : '';?>"><b><?php //echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
			</div>  -->
        </div>
    </div><br>
    
        <div class="form-actions">
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
    $('.chosen').chosen();

    if( $('input[name=id]').val() != '') {
        $("#up_nama").hide();
        $("#up_file").hide();
    }

    $('input[name=VOLUME_KONTRAK_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=ALPHA_KONTRAK_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=RUPIAH_KONTRAK_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=NOMINAL_JAMINAN_KONTRAK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });

    // if ($('#id').val()){
    //     $(':input[type="submit"]').prop('disabled', true);
    // }

</script>            
