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
                <label for="password" class="control-label">Periode (Bulan)<span class="required">*</span></label>
            </div>
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
                                    <?php echo form_input('HARGA', !empty($default->HARGA) ? $default->HARGA : '', 'class="span12", placeholder="Harga (Rp)"'); ?> &nbsp
                                </td><td>
                                    <?php echo form_input('JARAK', !empty($default->JARAK) ? $default->JARAK : '', 'class="span12", placeholder="(KL / ML)"'); ?> &nbsp
                                </td>
                            </tr>
                        </table>
                    </div>
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
                    <?php echo form_upload('FILE_UPLOAD', '0', 'class="span6"'); ?>
                </div>
            </div>
            <form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm">
                <input type="file" name="file" id="file" />
                <!-- <input type="submit" name="submit" value="Upload"/> -->
            </form>

       
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script type="text/javascript">
    function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // $('#uploadForm + embed').remove();
            // $('#uploadForm').after('<embed src="'+e.target.result+'" width="450" height="300">');
            $('#uploadForm + img').remove();
            $('#uploadForm').after('<img src="'+e.target.result+'" width="450" height="300"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#file").change(function () {
    filePreview(this);
});
</script>
<script type="text/javascript">
$(function() {
    $("#TGLKONTRAK").datepicker({
        format: 'yyyy-mm-dd', 
        autoclose:true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
});
</script>
<script type="text/javascript">
$('#jmlpas[type="text"]').on('change', function() {
    // alert($(this).val());
    var x = $("#jmlpas").val();
        var str = "";
        if ( x == 0 || x > 5 ) {
            alert('Jumlah Pasokan Max 5');
        } else {
            for(i=0;i<x;i++){
                str += $('#inputan').html() + "<br/>";
            }
            document.getElementById("inputan").innerHTML = str;
           $("#pasokan").show();
           $("#jmlpas").prop('disabled', true);
        };
})
</script>