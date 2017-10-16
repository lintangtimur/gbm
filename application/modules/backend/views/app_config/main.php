
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
           <div class="span6">
                        <div class="well orange">
                            <div class="well-header">
                                <h5>Setting Aplikasi</h5>
                                
                            </div>
        
                            <div class="well-content no-search">
                                <form id='fsetting' action="<?php echo $form_action;?>" method="post">
                                    <div class='form_row'>
                                        <div class=" control-group info">
                                            <label class="field_name">Nama Perusahaan</label>
                                            <div class="field">
                                                <input type="text" class="span6" id="inputWarning1" name="fclient" placeholder="<?php echo isset($setting['companyname']) ? $setting['companyname'] :"";?>" value="<?php echo isset($setting['companyname']) ? $setting['companyname'] :"";?>">
                                                <!--<span class="help-inline">Username is already taken!</span>-->
                                            </div>
                                        </div>
                                     </div>
                                <div class='form_row'>
                                    <div class=" control-group info">
                                    <label class="field_name">Nama Aplikasi</label>
                                    <div class="field">
                                        <input type="text" class="span6" id="inputWarning2" name="faplikasi" placeholder="<?php echo isset($setting['nama_aplikasi']) ? $setting['nama_aplikasi'] :"";?>" value="<?php echo isset($setting['nama_aplikasi']) ? $setting['nama_aplikasi'] :"";?>">
                                        <!--<span class="help-inline">Username is already taken!</span>-->
                                    </div>
                                </div>
                                </div>
                                <div class='form_row'>
                                    <div class=" control-group info">
                                    <label class="field_name">Deskripsi Aplikasi</label>
                                    <div class="field">
                                        <?php echo form_textarea('isi', !empty($setting['desk_aplikasi']) ? $setting['desk_aplikasi'] : '', 'class="span6"'); ?>
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="form_row">
                                    <div class="field">
                                       
                                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan Perubahan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#fsetting', '#button-back')")); ?>
            
                                    </div>
                                </div>
                                <form>
                            </div>
                        </div>
                    </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
       // config_tabs_ajax('#myTabs');
    });
</script>