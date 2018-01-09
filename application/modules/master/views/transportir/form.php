<!-- 
/**
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
            <label for="password" class="control-label">Kode Transportir <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KD_TRANSPORTIR', !empty($default->KD_TRANSPORTIR) ? $default->KD_TRANSPORTIR : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama Transportir <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_TRANSPORTIR', !empty($default->NAMA_TRANSPORTIR) ? $default->NAMA_TRANSPORTIR : '', 'class="span6" style="text-transform:uppercase"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Ket Transportir</span> : </label>
            <div class="controls">
                <?php echo form_input('KET_TRANSPORTIR', !empty($default->KET_TRANSPORTIR) ? $default->KET_TRANSPORTIR : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>