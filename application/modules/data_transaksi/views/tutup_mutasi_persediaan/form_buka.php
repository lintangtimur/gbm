
<!-- /**
 * @module MASTER TRANSPORTIR
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
          <div class="control-group">
            <label for="password" class="control-label">Status : </label>
            <div class="controls">
            <?php echo form_dropdown('VALUE_SETTING', $parent_options_buka, !empty($default->STATUS) ? $default->STATUS : '', 'class="span3", disabled="True"'); ?> 
            </div>
        </div>
       <div class="control-group">
       <label for="password" class="control-label">Tanggal Buka <span class="required">*</span> :  </label>
       <div class="controls">
       <?php echo form_input('TGL_BUKA', !empty($default->TGL_BUKA) ? $default->TGL_BUKA : '', 'class="span3 input-append date form_datetime"'); ?>           
       </div>
     </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Tutup <span class="required">*</span> :  </label>
            <div class="controls">
            <?php echo form_input('TGL_TUTUP', !empty($default->TGL_TUTUP) ? $default->TGL_TUTUP : '', 'class="span3 input-append date form_datetime"'); ?>           
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">BLTH <span class="required">*</span> :  </label>
            <div class="controls">
            <?php echo form_dropdown('BLTH', $blth_options, !empty($default->BLTH) ? $default->BLTH : ''); ?>           
            </div>
        </div>
        <div class="control-group">
        <label for="password" class="control-label">Regional : </label>
        <div class="controls">
        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : ''); ?>
         </div>
        </div>
        <div class="control-group">
        <label for="password" class="control-label">Level 1 : </label>
        <div class="controls">
        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : ''); ?>
        </div>
        </div>
        <div class="control-group">
        <label for="password" class="control-label">Level 2 : </label>
        <div class="controls">
        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : ''); ?>
        </div>
        </div>

        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    $(".form_datetime").datetimepicker({
        dateformat: "yyyy-mm-dd",
        timeFormat:  "hh:mm:ss",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    function setDefaultLv1(){
        $('select[name="COCODE"]').empty();
        $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('select[name="PLANT"]').empty();
        $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
    }
    $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>data_transaksi/tutup_mutasi_persediaan/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>data_transaksi/tutup_mutasi_persediaan/get_options_lv2/'+stateID;

            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                        });
                    }
                });
            }
        });
</script>