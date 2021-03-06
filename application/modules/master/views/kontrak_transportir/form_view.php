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
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6" id="ID_REGIONAL" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1 <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2 <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">No Kontrak <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('KD_KONTRAK_TRANS', !empty($default->KD_KONTRAK_TRANS) ? $default->KD_KONTRAK_TRANS : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Nama Transportir <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Tgl Awal Kontrak <span class="required">*</span> : </label>
                <div class="controls">
                <?php echo form_input('TGL_KONTRAK_TRANS', !empty($default->TGL_KONTRAK_TRANS) ? $default->TGL_KONTRAK_TRANS : '', 'class="span3 datepicker", id="TGL_KONTRAK_TRANS" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Tgl Akhir Kontrak <span class="required">*</span> : </label>
                <div class="controls">
                <?php echo form_input('TGL_KONTRAK_TRANS_AKHIR', !empty($default->TGL_KONTRAK_TRANS_AKHIR) ? $default->TGL_KONTRAK_TRANS_AKHIR : '', 'class="span3 datepicker", id="TGL_KONTRAK_TRANS_AKHIR" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Jumlah Pasokan <span class="required"> *</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_PASOKAN', !empty($default->JML_PASOKAN) ? $default->JML_PASOKAN : '', 'class="span2", id="JML_KIRIM", placeholder="Max 20" disabled'); ?>
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
            </br>
            <div class="control-group">
                <label for="password" class="control-label">Nilai Kontrak (Rp) <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NILAI_KONTRAK', !empty($default->NILAI_KONTRAK_TRANS) ? $default->NILAI_KONTRAK_TRANS : '', 'class="span3" disabled'); ?>
                    <sup>Termasuk PPN 10 %</sup>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Keterangan : </label>
                <div class="controls">
                      <?php echo form_input('KETERANGAN', !empty($default->KET_KONTRAK_TRANS) ? $default->KET_KONTRAK_TRANS : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls" id="dokumen">
                    <a href="<?php echo base_url().'assets/upload/kontrak_transportir/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                </div>
                <!-- <div class="controls" id="dokumen">
                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKTRANSPORTIR" data-url="<?php// echo $url_getfile;?>" data-filename="<?php// echo !empty($default->PATH_KONTRAK_TRANS) ? $default->PATH_KONTRAK_TRANS : '';?>"><b><?php //echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                </div> -->
            </div>


        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var counter = 1;
        $("#addButton").click(function () {
            if(counter>20){
                    alert("Max 20 data yang diperbolehkan");
                    return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                 .attr("id", 'TextBoxDiv' + counter);


            var combo_depo ="<select class='form-control cls_depo' id='depo_ke"+ counter + "' name='depo_ke"+ counter + "' disabled>"+
            "<option value='' disabled selected>--Pilih Depo--</option>"+
            <?php if ($option_depo != '')
                { foreach ($option_depo as $depo)
                     { ?>
                     "<option value='<?php echo $depo['ID_DEPO']?>'> <?php echo $depo['NAMA_DEPO'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var combo_pembangkit ="<select class='form-control' id='pembangkit_ke"+ counter + "' name='pembangkit_ke"+ counter + "' disabled>"+
            "<option value='' disabled selected>--Pilih Pembangkit--</option>"+
            <?php if ($option_pembangkit != '')
                { foreach ($option_pembangkit as $pembangkit)
                     { ?>
                     "<option value='<?php echo $pembangkit['SLOC']?>'> <?php echo $pembangkit['LEVEL4'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var combo_jalur ="<select class='form-control' id='jalur_ke"+ counter + "' name='jalur_ke"+ counter + "' disabled>"+
            "<option value='' disabled selected>--Pilih Jalur--</option>"+
            <?php if ($option_jalur != '')
                { foreach ($option_jalur as $jalur)
                     { ?>
                     "<option value='<?php echo $jalur['VALUE_SETTING']?>'> <?php echo $jalur['NAME_SETTING'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var text_harga_kontrak="<input type='text' id='harga_ke"+ counter + "' name='harga_ke"+ counter + "' placeholder='Harga (Rp) / L' disabled> <sup>Termasuk PPN 10 %</sup>";
            var text_jarak="<input type='text' id='jarak_ke"+ counter + "' name='jarak_ke"+ counter + "' placeholder='Jarak (KM aau ML)' size='37' disabled>";

            var cmb_level1 = "<select class='form-control cls_lv1' id='cmblv1_ke"+ counter + "' name='cmblv1_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 1--</option></select>";
            var cmb_level2 = "<select class='form-control cls_lv2' id='cmblv2_ke"+ counter + "' name='cmblv2_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 2--</option></select>";
            var cmb_level3 = "<select class='form-control cls_lv3' id='cmblv3_ke"+ counter + "' name='cmblv3_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 3--</option></select>";
            var cmb_level4 = "<select class='form-control' id='cmblv4_ke"+ counter + "' name='cmblv4_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Pembangkit--</option></select>";
           
            var visi = '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Depo ke : '+ counter + '</label>'+
            '<div class="controls">'+combo_depo+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv1_ke'+ counter + '">Level 1 Pemasok ke : '+ counter + '</label>'+
            '<div class="controls">'+cmb_level1+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">KIT Penerima ke : '+ counter + '</label>'+
            '<div class="controls">'+combo_pembangkit+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv2_ke'+ counter + '">Level 2 Pemasok ke : '+ counter + '</label>'+
            '<div class="controls">'+cmb_level2+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Jalur ke : '+ counter + '</label>'+
            '<div class="controls">'+combo_jalur+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv3_ke'+ counter + '">Level 3 Pemasok ke : '+ counter + '</label>'+
            '<div class="controls">'+cmb_level3+'</div></div>'+
            '</div><br>'+

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Jarak (KM atau ML) ke : '+ counter + '</label>'+
            '<div class="controls">'+text_jarak+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv4_ke'+ counter + '">KIT Pemasok ke : '+ counter + '</label>'+
            '<div class="controls">'+cmb_level4+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Harga (Rp) / L ke : '+ counter + '</label>'+
            '<div class="controls">'+text_harga_kontrak+'</div></div>'+
            '</div><hr>';

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
                msg += "\n Textbox #" + i + " : " + $('#jalur_ke' + i).val();
            }
            alert(msg);
        });

        $("#button-jml-kirim").click(function () {
            var x = $('#JML_KIRIM').val(); 

            if(x>20){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 20 data jumlah pasokan yang diperbolehkan</div>';
                bootbox.alert(message, function() {});
                $('#JML_KIRIM').val('20');
            }

            for (i = 1; i <= 20; i++) {
                $("#TextBoxDiv"+i).hide();
            }

            for (i = 1; i <= x; i++) {
                $("#TextBoxDiv"+i).show();

            }
            
        });

        for (i = 0; i < 20; i++) {
            $("#addButton").click();
        }

        for (i = 1; i <= 20; i++) {
            $("#TextBoxDiv"+i).hide();
        }
        
        if ($('input[name=id]').val()){
            get_detail($('input[name=KD_KONTRAK_TRANS]').val()); 
        }

        for (i = 1; i <= 20; i++) {
            $('input[name=harga_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }

            });


            $('input[name=jarak_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
           
            });
        }

        $("#addButton").hide();
        $("#removeButton").hide();
        $("#getButtonValue").hide();

    });

    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd', 
        autoclose:true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $('input[name=JML_PASOKAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 0,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=NILAI_KONTRAK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false,oncleared: function () { self.Value(''); }
    });


    function setComboEdit(vid,vlv,vrecid,vrecdata){
        $("#cmblv"+vlv+"_"+vid).empty();

        if (vlv==4){
            $("#cmblv"+vlv+"_"+vid).append('<option value="'+vrecid+'" selected>'+vrecdata+'</option>');
        } else { 
            $("#cmblv"+vlv+"_"+vid).append('<option value="'+vrecid+'" selected>'+vrecdata+'</option>'); 
        }
    }

    function setVisibleLv(vid,vStatus){
        if (vStatus){
            $("#cmblv1_"+vid).show();
            $("#cmblv2_"+vid).show();
            $("#cmblv3_"+vid).show();
            $("#cmblv4_"+vid).show();
            $("#lblv1_"+vid).show();
            $("#lblv2_"+vid).show();
            $("#lblv3_"+vid).show();
            $("#lblv4_"+vid).show();
        } else {
            $("#cmblv1_"+vid).hide();
            $("#cmblv2_"+vid).hide();
            $("#cmblv3_"+vid).hide();
            $("#cmblv4_"+vid).hide();
            $("#lblv1_"+vid).hide();
            $("#lblv2_"+vid).hide();
            $("#lblv3_"+vid).hide();
            $("#lblv4_"+vid).hide();
        }       
    }

    function get_detail(vId) {
        var data = {idx: vId};

        $.post("<?php echo base_url()?>master/kontrak_transportir/get_detail_kirim/", data, function (data) {
            var rest = (JSON.parse(data));
            var x=0;
            for (i = 0; i < rest.length; i++) {
                x++;
                $("#depo_ke"+x).val(rest[i].ID_DEPO);
                $("#pembangkit_ke"+x).val(rest[i].SLOC);
                $("#jalur_ke"+x).val(rest[i].TYPE_KONTRAK_TRANS);
                $("#harga_ke"+x).val(rest[i].HARGA_KONTRAK_TRANS);
                $("#jarak_ke"+x).val(rest[i].JARAK_DET_KONTRAK_TRANS);
                setVisibleLv('ke'+x,false);

                if (rest[i].SLOC_PEMASOK){
                    setVisibleLv('ke'+x,true);
                    setComboEdit('ke'+x,1,rest[i].COCODE,rest[i].LEVEL1);
                    setComboEdit('ke'+x,2,rest[i].PLANT,rest[i].LEVEL2);
                    setComboEdit('ke'+x,3,rest[i].STORE_SLOC,rest[i].LEVEL3);
                    setComboEdit('ke'+x,4,rest[i].SLOC_PEMASOK,rest[i].LEVEL4);
                }

                $("#TextBoxDiv"+x).show();
            }
        });
    }

</script>