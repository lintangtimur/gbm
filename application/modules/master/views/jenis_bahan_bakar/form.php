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
            <label for="password" class="control-label">Kode Jenis Bahan Bakar <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KODE_JNS_BHN_BKR', !empty($default->KODE_JNS_BHN_BKR) ? $default->KODE_JNS_BHN_BKR : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_JNS_BHN_BKR', !empty($default->NAMA_JNS_BHN_BKR) ? $default->NAMA_JNS_BHN_BKR : '', 'class="span6"'); ?>
            </div>

        </div>

        <div class="control-group">
            <label for="password" class="control-label">Mix : </label>
            <div class="controls">
            <?php echo form_checkbox('IS_MIX_JNS_BHN_BKR', '1', !empty($default->IS_MIX_JNS_BHN_BKR) ? $default->IS_MIX_JNS_BHN_BKR : '', 'id ="checkKomponen"' ); ?>
            </div>
        </div>

        
        <div class="control-group" id="KOMPONEN_1">
        <label  class="control-label">Komponen 1 <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('KOMPONEN_1', $options_komponen1, !empty($default->KOMPONEN_1) ? $default->KOMPONEN_1 : '', 'id="OPTION_KOMPONEN_1"'); ?>
        </div>
        </div>

            
        <div class="control-group" id="KOMPONEN_2">
        <label  class="control-label">Komponen 2 <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('KOMPONEN_2', $options_komponen2, !empty($default->KOMPONEN_2) ? $default->KOMPONEN_2 : '', 'id="OPTION_KOMPONEN_2"'); ?>
        </div>
        </div>

        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<script type="text/javascript">
    function hiddenKomponen(){
        document.getElementById("KOMPONEN_1").style.visibility = "hidden";
        document.getElementById("KOMPONEN_2").style.visibility = "hidden";
    }
    
     function showKomponen(){
        document.getElementById("KOMPONEN_1").style.visibility = "visible";
        document.getElementById("KOMPONEN_2").style.visibility = "visible";
    }

    function checkKomponen(){
        $('#checkKomponen').val();

        if ($('#checkKomponen').is(":checked")){
            showKomponen();
            // $("#KOMPONEN_1").attr('required', ''); 
            // $("#KOMPONEN_2").attr('required', ''); 
            // document.getElementById('OPTION_KOMPONEN_1').required = true;
            // document.getElementById('OPTION_KOMPONEN_2').required = true;
            }   
        else{
            hiddenKomponen();
            // $("#KOMPONEN_1").removeAttr('required');
            // $("#KOMPONEN_2").removeAttr('required');
            // document.getElementById('OPTION_KOMPONEN_1').required = false;
            // document.getElementById('OPTION_KOMPONEN_2').required = false;
		}   
    }

    $(function() {
        checkKomponen();
     });

     $('#checkKomponen').change(function(){
        checkKomponen();
    });
</script>