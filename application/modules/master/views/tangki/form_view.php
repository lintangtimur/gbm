<?php
/**
 * Created by PhpStorm.
 * User: mrapry
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
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" id="pembangkit" disabled'); ?>
                    <input type="hidden" name="pembangkit_e" id="pembangkit_e" value="<?php echo !empty($default->SLOC) ? $default->SLOC : '' ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Kapasitas Terpasang (L) : </label>
                <div class="controls">
                    <?php echo form_input('VOLUME_TANGKI', !empty($default->VOLUME_TANGKI) ? $default->VOLUME_TANGKI : '', 'class="span3 rp" placeholder="Total Kapasitas Terpasang (L)" id="VOLUME_TANGKI" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Dead Stock (L) : </label>
                <div class="controls">
                    <?php echo form_input('DEADSTOCK_TANGKI', !empty($default->DEADSTOCK_TANGKI) ? $default->DEADSTOCK_TANGKI : '', 'class="span3 rp" placeholder="Total Dead Stock (L)" id="DEADSTOCK_TANGKI" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Kapasitas Mampu (L) : </label>
                <div class="controls">
                    <?php echo form_input('STOCKEFEKTIF_TANGKI', !empty($default->STOCKEFEKTIF_TANGKI) ? $default->STOCKEFEKTIF_TANGKI : '', 'class="span3 rp" placeholder="Total Kapasitas Mampu (L)" id="STOCKEFEKTIF_TANGKI" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jumlah Tangki<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_TANGKI', !empty($default->JML_TANGKI) ? $default->JML_TANGKI : '', 'class="span2 rp_num" placeholder="Max 30" id="JML_TANGKI" disabled'); ?>
                </div>
            </div>
            <br>           
            <div class="content_table">
                <div class="well-content clearfix">
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv0">
                             
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
    $(document).ready(function(){

        var counter = 1;

        $("#addButton").click(function () {
            if(counter>31){
                    alert("Max 31 data yang diperbolehkan");
                    return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                 .attr("id", 'TextBoxDiv' + counter);

            var text_nama_tangki="<input type='text' id='NAMA_TANGKI"+ counter + "' name='NAMA_TANGKI"+ counter + "' placeholder='Nama Tangki' size='37' value='TANGKI "+ counter + "' disabled>";

            var text_k_terpasang="<input type='text' id='VOLUME_TANGKI"+ counter + "' name='VOLUME_TANGKI"+ counter + "' placeholder='Terpasang (L)' size='37' class='rp cls_sum' onChange='setHitungKirim()' disabled>";

            var text_dead_stock="<input type='text' id='DEADSTOCK_TANGKI"+ counter + "' name='DEADSTOCK_TANGKI"+ counter + "' placeholder='Dead Stock (L)' size='37' class='rp cls_sum' onChange='setHitungKirim()' disabled>";

            var text_k_mampu="<input type='text' id='STOCKEFEKTIF_TANGKI"+ counter + "' name='STOCKEFEKTIF_TANGKI"+ counter + "' placeholder='Kapasitas Mampu (L)' size='37' class='rp cls_sum' onChange='setHitungKirim()' disabled>";

            var text_ditera_oleh="<input type='text' id='DITERA_OLEH"+ counter + "' name='DITERA_OLEH"+ counter + "' placeholder='Ditera Oleh' size='37' disabled>";

            var text_tgl_awal="<input type='text' id='TGL_AWAL_TERA"+ counter + "' name='TGL_AWAL_TERA"+ counter + "' placeholder='Tgl Awal Tera' size='37' class='datepicker' disabled>";

            var text_tgl_akhir="<input type='text' id='TGL_AKHIR_TERA"+ counter + "' name='TGL_AKHIR_TERA"+ counter + "' placeholder='Tgl Akhir Tera' size='37' class='datepicker' disabled>";

            var text_status="<input type='checkbox' id='AKTIF"+ counter + "' name='AKTIF"+ counter + "' placeholder='Status Tangki' value='1' class='STATUS' checked disabled>  Aktif";

            var path = "<?php echo !empty($default->PATH_FILE_NOMINASI) ? $default->PATH_FILE_NOMINASI : ''?>";

            var link_doc = "<a href='#' id='LINK_FILE"+ counter + "' target='_blank' style='display: none;'><b>Lihat Dokumen</b></a>";

            var path_edit = '<input type="hidden" name="PATH_FILE_EDIT'+ counter + '" id="PATH_FILE_EDIT'+ counter +'" >';

            var text_upload_doc="<input type='file' id='PATH_DET_TERA"+ counter + "' name='PATH_DET_TERA"+ counter + "' disabled> "+path_edit;
           
            var visi = '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Nama Tangki ke : '+ counter + '</label>'+
            '<div class="controls">'+text_nama_tangki+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label">Ditera Oleh ke : '+ counter + '</label>'+
            '<div class="controls">'+text_ditera_oleh+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Kapasitas Terpasang (L) ke : '+ counter + '</label>'+
            '<div class="controls">'+text_k_terpasang+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label">Tgl Awal Tera ke : '+ counter + '</label>'+
            '<div class="controls">'+text_tgl_awal+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Dead Stock (L) ke : '+ counter + '</label>'+
            '<div class="controls">'+text_dead_stock+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label">Tgl Akhir Tera ke : '+ counter + '</label>'+
            '<div class="controls">'+text_tgl_akhir+'</div></div>'+
            '</div><br>'+

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Kapasitas Mampu (L) ke : '+ counter + '</label>'+
            '<div class="controls">'+text_k_mampu+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label">Upload File (Max 4 MB) ke : '+ counter + '</label>'+
            '<div class="controls">'+text_upload_doc+'</div></div>'+
            '</div><br>'+


            '<div class="form_row">'+
            '<div class="pull-left span5"><label for="password" class="control-label">Status Tangki ke : '+ counter + '</label>'+
            '<div class="controls">'+text_status+'</div></div>'+
            '<div class="pull-left span5"><label for="password" class="control-label"></label>'+
            '<div class="controls">'+link_doc+'</div></div>'+
            '</div><hr>';



            // '<div class="form_row">'+
            // '<div class="pull-left"><label for="password" class="control-label">Status Tangki ke : '+ counter + '</label>'+
            // '<div class="controls">'+text_status+'</div></div>'+
            // '</div><hr>';   

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

        $("#button-jml-tangki").click(function () {
            var x = $('#JML_TANGKI').val(); 

            if(x>30){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 30 data jumlah pengiriman yang diperbolehkan</div>';
                bootbox.alert(message, function() {});
                $('#JML_TANGKI').val('30');
            }

            for (i = 1; i <= 30; i++) {
                $("#TextBoxDiv"+i).hide();
            }

            for (i = 1; i <= x; i++) {
                $("#TextBoxDiv"+i).show();

            }
            setHitungKirim();
        });

        for (i = 0; i < 30; i++) {
            $("#addButton").click();
        }

        for (i = 1; i <= 30; i++) {
            $("#TextBoxDiv"+i).hide();
        }
        
        if ($('input[name=id]').val()){
            get_detail($('input[name=id]').val()); 
        }

        $("#addButton").hide();
        $("#removeButton").hide();
        $("#getButtonValue").hide();
    });

    function getRp(vNilai){
        var x = vNilai.replace(/\./g, "");
        x = x.replace(",", ".");
        if (x==''){x=0};
        x = parseFloat(x);
        return x;
    }

    $(".cls_sum").change(function (e) {
        var text_sum = e.target.id;
        var vke = text_sum.split('_');
        var vcek = $("#"+text_sum).val();

        // console.log(text_sum+' -> '+vcek);
        var vol_volume = $("#VOLUME_"+vke[1]).val();
        var vol_deadstk = $("#DEADSTOCK_"+vke[1]).val();
        var vol_stkefektif = $("#STOCKEFEKTIF_"+vke[1]).val();

        vol_volume = getRp(vol_volume);
        vol_deadstk = getRp(vol_deadstk);
        vol_stkefektif = getRp(vol_stkefektif);

        if (vol_deadstk > vol_volume){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Dead Stock tidak boleh lebih besar dari Kapasitas Terpasang</div>';
                bootbox.alert(message, function() {});
            $("#DEADSTOCK_"+vke[1]).val(vol_volume);
            vol_deadstk = vol_volume;
        }

        if (vke[0]!='STOCKEFEKTIF'){
            vol_stkefektif = vol_volume - vol_deadstk;   
        } else {
            vol_volume = vol_stkefektif + vol_deadstk;
        }

        $("#VOLUME_"+vke[1]).val(vol_volume);
        $("#DEADSTOCK_"+vke[1]).val(vol_deadstk);
        $("#STOCKEFEKTIF_"+vke[1]).val(vol_stkefektif); 
    });

    function setHitungKirim(){
        var vSumTerpasang=0;
        var vSumDeadStock=0;
        var vSumMampu=0;
        var vol=0;
        var new_vol=0;

        for (i = 1; i <= 30; i++) {
            if($("#TextBoxDiv"+i).is(":visible")){
                //hitung vSumTerpasang
                vol = $("#VOLUME_TANGKI"+i).val();
                new_vol = vol.replace(/\./g, "");
                new_vol = new_vol.replace(",", ".");
                if (new_vol==''){new_vol=0;}
                new_vol = parseFloat(new_vol);
                vSumTerpasang += new_vol; 

                //hitung vSumDeadStock
                vol = $("#DEADSTOCK_TANGKI"+i).val();
                new_vol = vol.replace(/\./g, "");
                new_vol = new_vol.replace(",", ".");
                if (new_vol==''){new_vol=0;}
                new_vol = parseFloat(new_vol);
                vSumDeadStock += new_vol; 

                //hitung vSumMampu
                vol = $("#STOCKEFEKTIF_TANGKI"+i).val();
                new_vol = vol.replace(/\./g, "");
                new_vol = new_vol.replace(",", ".");
                if (new_vol==''){new_vol=0;}
                new_vol = parseFloat(new_vol);
                vSumMampu += new_vol;     
            }
        }
        $("#VOLUME_TANGKI").val(vSumTerpasang);
        $("#DEADSTOCK_TANGKI").val(vSumDeadStock);
        $("#STOCKEFEKTIF_TANGKI").val(vSumMampu);
    }

    $("#button-save").click(function () {
        $("#button-jml-tangki").click();
    });

    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd', 
        autoclose:true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $(".rp").inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false,oncleared: function () { self.Value(''); }
    });

    $(".rp_num").inputmask("numeric", {radixPoint: ",",groupSeparator: "",digits: 0,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false,oncleared: function () { self.Value(''); }
    });
    
    
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
        $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>master/tangki/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }

    });

    $('select[name="COCODE"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>master/tangki/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="PLANT"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>master/tangki/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>master/tangki/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="ID_JNS_BHN_BKR"]').on('change', function() {
        var ID_JNS_BHN_BKR = $(this).val();
        var SLOC = $('#pembangkit').val();
        var SLOC_E = $('#pembangkit_e').val();
        var vlink_url = '<?php echo base_url()?>master/tangki/cek_jns_bbm/';
        if ((ID_JNS_BHN_BKR) && (SLOC)) {
            bootbox.modal('<div class="loading-progress"></div>');
            if (SLOC==SLOC_E){SLOC='-'}

            $.ajax({
                url: vlink_url,
                type: "POST",
                dataType: "json",
                data: {"ID_JNS_BHN_BKR": ID_JNS_BHN_BKR,
                        "SLOC":SLOC,
                        },
                success:function(data) {
                    bootbox.hideAll();
                    if(data.status){
                        var x = 'Pembangkit '+$('#pembangkit option:selected').text()+' dgn Jenis BBM '+$('#jnsbbm option:selected').text()+' sudah terdaftar ';
                        var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> '+x+'</div>';
                         bootbox.alert(message, function() {});
                         $('select[name="ID_JNS_BHN_BKR"]').val('');
                    }
                }
            });
        } else {
            if (SLOC==''){
                $('select[name="ID_JNS_BHN_BKR"]').val('');
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Silahkan pilih pembangkit</div>';
                bootbox.alert(message, function() {});
            }
        }
    });

    function get_detail(vId) {
        var data = {idx: vId};

        $.post("<?php echo base_url()?>master/tangki/get_detail_kirim/", data, function (data) {
            var rest = (JSON.parse(data));
            var x=0;
            for (i = 0; i < rest.length; i++) {
                x++;
                $("#NAMA_TANGKI"+x).val(rest[i].NAMA_TANGKI);
                $("#VOLUME_TANGKI"+x).val(rest[i].VOLUME_TANGKI);
                $("#DEADSTOCK_TANGKI"+x).val(rest[i].DEADSTOCK_TANGKI);
                $("#STOCKEFEKTIF_TANGKI"+x).val(rest[i].STOCKEFEKTIF_TANGKI);
                $("#DITERA_OLEH"+x).val(rest[i].DITERA_OLEH);
                $("#TGL_AWAL_TERA"+x).val(rest[i].TGL_AWAL_TERA);
                $("#TGL_AKHIR_TERA"+x).val(rest[i].TGL_AKHIR_TERA);
                
                if (rest[i].AKTIF==1){
                    $("#AKTIF"+x).prop('checked', true);
                } else {
                    $("#AKTIF"+x).prop('checked', false);
                }

                if (rest[i].PATH_DET_TERA){
                    var url = "<?php echo base_url() ?>assets/upload/tangki/"+rest[i].PATH_DET_TERA;

                    $("#PATH_FILE_EDIT"+x).val(rest[i].PATH_DET_TERA);
                    $("#LINK_FILE"+x).attr("href", url);
                    $("#LINK_FILE"+x).show();
                } 
                
                $("#TextBoxDiv"+x).show();
            }
            $("#JML_TANGKI").val(x);
        });
    }

</script>