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
                <label for="password" class="control-label">No Kontrak <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_KONTRAK', !empty($default->KD_KONTRAK_TRANS) ? $default->KD_KONTRAK_TRANS : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Pilih Transportir<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Tanggal Tera<span class="required">*</span> : </label>
                <div class="controls">
                <?php echo form_input('TGL_KONTRAK_TRANS', !empty($default->TGL_KONTRAK_TRANS) ? $default->TGL_KONTRAK_TRANS : '', 'class="span3", id="TGL_KONTRAK_TRANS"'); ?>
                </div>
            </div>
            <!-- <div class="control-group">
                <label for="password" class="control-label">Periode (Bulan)<span class="required">*</span></label>
            </div> -->
            <div class="control-group">
                <label for="password" class="control-label">Jumlah Pasokan <span class="required"> *</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_PASOKAN', !empty($default->JML_PASOKAN) ? $default->JML_PASOKAN : '', 'class="span2", id="jmlpas", placeholder="Max 5"'); ?>
                </div>
            </div>
            <div id="pasokan" class="control-group" hidden>
                <label for="password" class="control-label">Harga Transport (Rp/Lt) <span class="required"> *</span> : </label>
                    <div class="controls" id="inputan">
                        <table>
                           <tr>
                                <td>
                                    <?php echo form_dropdown('option_depo', $option_depo, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>
                                <td>
                                    <?php echo form_dropdown('option_pembangkit', $option_pembangkit, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>
                                <td>
                                    <?php echo form_dropdown('option_jalur', $option_jalur, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <?php echo form_input('HARGA', !empty($default->HARGA_KONTRAK_TRANS) ? $default->HARGA_KONTRAK_TRANS : '', 'class="span12", placeholder="Harga (Rp)"'); ?> &nbsp
                                </td><td>
                                    <?php echo form_input('JARAK', !empty($default->JARAK) ? $default->JARAK : '', 'class="span12", placeholder="Jarak (KL / ML)"'); ?> &nbsp
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="controls" id="inputan_awal" style="display:none">
                        <table>
                           <tr>
                                <td>
                                    <?php echo form_dropdown('option_depo', $option_depo, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>
                                <td>
                                    <?php echo form_dropdown('option_pembangkit', $option_pembangkit, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>
                                <td>
                                    <?php echo form_dropdown('option_jalur', $option_jalur, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class=""'); ?>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <?php echo form_input('HARGA', !empty($default->HARGA_KONTRAK_TRANS) ? $default->HARGA_KONTRAK_TRANS : '', 'class="span12", placeholder="Harga (Rp)"'); ?> &nbsp
                                </td><td>
                                    <?php echo form_input('JARAK', !empty($default->JARAK) ? $default->JARAK : '', 'class="span12", placeholder="Jarak (KL / ML)"'); ?> &nbsp
                                </td>
                            </tr>
                        </table>
                    </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Nilai Kontrak (Rp)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NILAI_KONTRAK', !empty($default->NILAI_KONTRAK_TRANS) ? $default->NILAI_KONTRAK_TRANS : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Keterangan<span class="required">*</span> : </label>
                <div class="controls">
                      <?php echo form_input('KETERANGAN', !empty($default->KET_KONTRAK_TRANS) ? $default->KET_KONTRAK_TRANS : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Upload File<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_KONTRAK_TRANS) ? $default->PATH_KONTRAK_TRANS : '', 'class="span6"'); ?>
                </div>
                <div class="controls" id="dokumen">
                    <a href="<?php echo base_url().'assets/upload_kontrak_trans/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                </div>
            </div>
       
        <div class="well-content" id="content_table">
        <label>Detail Pasokan</label>
            <table id="detil_kontrak_trans" class="table table-striped table-bordered table-hover datatable dataTable">
                <thead>
                    <tr>
                        <th>Depo</th>
                        <th>Pembangkit</th>
                        <th>Harga Kontrak</th>
                        <th>Jarak</th>
                        <th>Transportasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center"><?php echo !empty($default->NAMA_DEPO) ? $default->NAMA_DEPO : '-'; ?></td>
                        <td align="center"><?php echo !empty($default->LEVEL4) ? $default->LEVEL4 : '-'; ?></td>
                        <td align="right"><?php echo !empty($default->NILAI_KONTRAK_TRANS) ? $default->NILAI_KONTRAK_TRANS : '-'; ?></td>
                        <td align="right"><?php echo !empty($default->JARAK_DET_KONTRAK_TRANS) ? $default->JARAK_DET_KONTRAK_TRANS : '-'; ?></td>
                        <td align="center"><?php echo !empty($default->TYPE_KONTRAK_TRANS) ? $default->TYPE_KONTRAK_TRANS : '-'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $("#TGL_KONTRAK_TRANS").datepicker({
        format: 'yyyy-mm-dd', 
        autoclose:true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    
    $('input[name=HARGA]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=JARAK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=NILAI_KONTRAK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });

</script>
<script type="text/javascript">
var inputan_awal =  $('#inputan_awal').html();

$('#jmlpas[type="text"]').on('change', function() {
    // alert($(this).val());
    var x = $("#jmlpas").val();
        var str = "";
        if ( x == 0 || x > 5 ) {
            alert('Jumlah Pasokan Max 5');
        } else {
            $('#inputan').empty();
            for(i=0;i<x;i++){
                str += $('#inputan_awal').html() + "<br/>";
            }
            document.getElementById("inputan").innerHTML = str;
           $("#pasokan").show();
           $("#jmlpas").prop('disabled', false);
        };
})
</script>