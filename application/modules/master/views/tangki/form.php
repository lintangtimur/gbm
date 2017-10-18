<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
            <table class="table">
                    <tr>
                        <td>
                            <div class="control-group">
                                <label for="password" class="control-label">Pembangkit <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('unit_pembangkit', $unit_pembangkit, !empty($default->SLOC) ? $default->SLOC : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Jenis BBM<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('jenis_bbm', $jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Tera<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('TERA', $tera, !empty($default->NAMA_TERA) ? $default->NAMA_TERA : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Nama Tangki<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('NAMA_TANGKI', !empty($default->NAMA_TANGKI) ? $default->NAMA_TANGKI : '', 'class="span8"'); ?>
                                </div>
                            </div>
                        </td>
                        <td>
                             <div class="control-group">
                                <label for="password" class="control-label">Kapasitas (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('KAPASITAS', !empty($default->VOLUME_TANGKI) ? $default->VOLUME_TANGKI : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Dead Stock (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('DEAD_STOCK', !empty($default->DEADSTOCK_TANGKI) ? $default->DEADSTOCK_TANGKI : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Stock Efektif (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('STOCK_EFEKTIF', !empty($default->STOCKEFEKTIF_TANGKI) ? $default->STOCKEFEKTIF_TANGKI : '', 'class="span8"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Tanggal Tera<span class="required">*</span> : </label>
                                <div class="controls">
                                <?php $attributes = 'id="TGL_TERA" placeholder=""'; echo form_input('TGL_TERA', set_value('TGL_TERA'), $attributes); ?>
                                      
                                </div>
                            </div>
                            
                        </td>
                    </tr>
            </table>
            <div class="control-group">
                <label for="password" class="control-label">Upload File<span class="required">*</span> : </label>
                <div class="controls">
                <?php echo form_upload('FILE_UPLOAD', !empty($default->FILE_UPLOAD) ? $default->FILE_UPLOAD : '', 'class="span4"'); ?>
                </div>
            </div>

         <div class="well-content" id="content_table">
            <table class="table table-striped table-bordered table-hover datatable dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Detail Tera</th>
                        <th>Path Tera</th>
                        <th>Tanggal Detail Tera</th>
                        <th>Status</th>
                    </tr>
                </thead>
                    <tr>
                        <td>1</td>
                        <td>iiaia</td>
                        <td>ii</td>
                        <td>ii</td>
                        <td>ii</td>
                    </tr>
            </table>
        </div>

        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
             <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
$(function() {
    $("#TGL_TERA").datepicker();
});
</script>