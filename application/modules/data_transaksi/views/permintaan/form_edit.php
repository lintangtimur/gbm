<?php
/**
 * Created by PhpStorm.
 * User: cf
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
            <div class="control-group">
                <label class="control-label">Nomor Nominasi<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_NOMINASI', !empty($default->NO_NOMINASI) ? $default->NO_NOMINASI : '', 'class="span4" placeholder="Nomor Nominasi / Permintaan" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Nominasi<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_MTS_NOMINASI', !empty($default->TGL_MTS_NOMINASI) ? $default->TGL_MTS_NOMINASI : '', 'class="span12 input-append date form_datetime" placeholder="Tanggal Nominasi" id="TGL_MTS_NOMINASI" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="control-label" class="control-label"> </label> 
                <!-- <div class="controls" id="dokumen">
                    <?php
                        // $link = !empty($default->PATH_FILE_NOMINASI) ? $default->PATH_FILE_NOMINASI : ''     
                    ?>
                    <a href="<?php //echo base_url().'assets/upload_nominasi/'.$link;?>" target="_blank"><b><?php //echo (empty($link)) ? $link : 'Lihat Dokumen'; ?></b></a>
                </div>-->
				<!-- <div class="controls" id="dokumen">
					<a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_FILE_NOMINASI) ? $default->PATH_FILE_NOMINASI : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
				</div> -->
                <div class="controls" id="dokumen">
                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                  </div>
            </div>
            <div class="control-group">
                <label class="control-label">Volume<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOLUME_NOMINASI', !empty($default->VOLUME_NOMINASI) ? $default->VOLUME_NOMINASI : '', 'class="span4" placeholder="Volume Nominasi" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jumlah Pengiriman<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_KIRIM', !empty($default->JML_KIRIM) ? $default->JML_KIRIM : '', 'class="span4" placeholder="Jumlah Pengiriman" id="JML_KIRIM" disabled'); ?>
                </div>
            </div>
            <br>           
            <div class="content_table">
                <div class="well-content clearfix">
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv0">
                                <!-- <div class="form_row">
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Tgl Kirim ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Volume (L) ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                </div><br>  -->   
                            </div>
                        </div>
                        <input type='button' value='Add Button' id='addButton'>
                        <input type='button' value='Remove Button' id='removeButton'>
                        <input type='button' value='Get TextBox Value' id='getButtonValue'>                        
                </div>
            </div>

            <div class="form-actions">
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
            </div>
            <?php
        echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $('input[name=VOLUME_NOMINASI]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });

    function get_detail(vId) {
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_detail_kirim/'+vId;
        var i=0;
        $.ajax({
            url: vlink_url,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $.each(data, function(key, value) {
                    i = i+1;
                    $("#tgl_ke"+i).val(value.TGL_KIRIM);
                    $("#vol_ke"+i).val(value.VOLUME_NOMINASI);
                    $("#TextBoxDiv"+i).show();
                });
            }
        });
    };

$(document).ready(function(){

    var counter = 1;

    $("#addButton").click(function () {
        if(counter>31){
                alert("Max 31 data yang diperbolehkan");
                return false;
        }

        var newTextBoxDiv = $(document.createElement('div'))
             .attr("id", 'TextBoxDiv' + counter);

        var visi = '<div class="form_row"><div class="pull-left"><label for="password" class="control-label">Tgl Kirim ke : '+ counter + '</label><div class="controls"><input type="text" id="tgl_ke'+ counter + '" name="tgl_ke'+ counter + '" class="input-append date form_datetime" placeholder="Tanggal Kirim" disabled></div></div><div class="pull-left"><label for="password" class="control-label">Volume (L) ke : '+ counter + '</label><div class="controls"><input type="text" id="vol_ke'+ counter + '" name="vol_ke'+ counter + '" placeholder="Volume (L)" onChange="setHitungKirim()" disabled></div></div></div><br>';     

        newTextBoxDiv.after().html(visi);
        newTextBoxDiv.appendTo("#TextBoxesGroup");
        counter++;
    });

    $("#removeButton").click(function () {
        if(counter==1){
            //alert("No more textbox to remove");
            return false;
        }

        counter--;
        $("#TextBoxDiv" + counter).remove();
    });

    $("#getButtonValue").click(function () {
        var msg = '';
        for(i=1; i<counter; i++){
            msg += "\n Textbox #" + i + " : " + $('#tgl_ke' + i).val();
        }
        alert(msg);
    });


    for (i = 0; i < 31; i++) {
        $("#addButton").click();
    }

    for (i = 1; i <= 31; i++) {
        $("#TextBoxDiv"+i).hide();
    }   

    for (i = 1; i <= 31; i++) {
        var val="input[name=vol_ke"+i+"]";
        $('input[name=vol_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
        });
    }

    get_detail($('input[name=NO_NOMINASI]').val()); 

    $("#addButton").hide();
    $("#removeButton").hide();
    $("#getButtonValue").hide();
});
</script>