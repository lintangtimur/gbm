
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
            <label for="password" class="control-label">Pilih Pemasok <span class="required">*</span> : </label>
            <div class="controls">
               <?php echo form_dropdown('ID_PEMASOK', $parent_options, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama Depo / Depot : </label>
            <div class="controls">
                <?php echo form_input('NAMA_DEPO', !empty($default->NAMA_DEPO) ? $default->NAMA_DEPO : '', 'class="span6"'); ?>
            </div>
        </div>
           <div class="control-group">
            <label for="password" class="control-label">LAT : </label>
            <div class="controls">
                <?php echo form_input('LAT_DEPO', !empty($default->LAT_DEPO) ? $default->LAT_DEPO : '', 'class="span6"'); ?>
            </div>
        </div>
           <div class="control-group">
            <label for="password" class="control-label">LOT : </label>
            <div class="controls">
                <?php echo form_input('LOT_DEPO', !empty($default->LOT_DEPO) ? $default->LOT_DEPO : '', 'class="span6"'); ?>
            </div>
        </div>
          <div class="control-group">
            <label for="password" class="control-label">Alamat Depo / Depot : </label>
            <div class="controls">
                <?php echo form_input('ALAMAT_DEPO', !empty($default->ALAMAT_DEPO) ? $default->ALAMAT_DEPO : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>