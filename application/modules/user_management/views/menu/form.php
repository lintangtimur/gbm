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
            <label for="password" class="control-label">Nama Menu <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('menu_nama', !empty($default->menu_nama) ? $default->menu_nama : '', 'class="span6"'); ?>
            </div>
        </div>
         <div class="control-group">
            <label for="password" class="control-label">Parent Menu : </label>
            <div class="controls">
                <?php echo form_dropdown('parent_id', $parent_options, !empty($default->kms_menu_id) ? $default->kms_menu_id : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Set URL <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('menu_url', !empty($default->menu_url) ? $default->menu_url : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Keterangan : </label>
            <div class="controls">
                <?php echo form_input('menu_keterangan', !empty($default->menu_keterangan) ? $default->menu_keterangan : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Urutan <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('menu_urutan', !empty($default->menu_urutan) ? $default->menu_urutan : '', 'class="span2"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Icon : <?php echo !empty($default->menu_icon) ? $default->menu_icon : ''; ?></label>
            <div class="controls">
                <?php echo form_dropdown('menu_icon', hgenerator::font_awesome(), !empty($default->menu_icon) ? $default->menu_icon : '', 'id="sico" class="select2-me input-xlarge"'); ?>
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
    $(function() {
        select2_icon('sico');
    });
</script>