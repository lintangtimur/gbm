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
            <label for="password" class="control-label">Status Anak Perusahaan  : </label>
            <div class="controls">
               <?php echo form_checkbox('is_edit[]', $menu_id, isset($otoritas_menu[$menu_id]['is_edit']) && $otoritas_menu[$menu_id]['is_edit'] == 't' ? TRUE : FALSE, 'class="cb_select cb_select_row_' . $menu_id . '"'); ?>
            </div>
        </div>   
        <div class="control-group">
            <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
            </div>
        </div>  
        <div class="control-group">
            <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
            </div>
        </div>  
        <div class="control-group">
            <label for="password" class="control-label">Level 2 : </label>
            <div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Level 3 : </label>
            <div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Level 4 <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('LEVEL4', !empty($default->LEVEL4) ? $default->LEVEL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Sloc <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('SLOC', !empty($default->SLOC) ? $default->SLOC : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Alamat : </label>
            <div class="controls">
                <?php echo form_input('DESCRIPTION_LVL4', !empty($default->DESCRIPTION_LVL4) ? $default->DESCRIPTION_LVL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Latitude : </label>
            <div class="controls">
                <?php echo form_input('LAT_LVL4', !empty($default->LAT_LVL4) ? $default->LAT_LVL4 : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Longitude : </label>
            <div class="controls">
                <?php echo form_input('LOT_LVL4', !empty($default->LOT_LVL4) ? $default->LOT_LVL4 : '', 'class="span6"'); ?>
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
    jQuery(function($) {
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

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
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
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv2/'+stateID;
            setDefaultLv2();
            setDefaultLv3();
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

        $('select[name="PLANT"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv3/'+stateID;
            setDefaultLv3();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                        });
                    }
                });
            }
        });
    });
</script>