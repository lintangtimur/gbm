<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div class="well-content no-search">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="well">
								<div class="box-title">
							        <?php echo '<i class="icon-laptop"></i> Ubah Password'; ?>
							    </div>
                                <div class="box-content">
						        <?php
						        $hidden_form = array('id' => !empty($id) ? $id : '');
						        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
						        ?>
						        <div class="control-group">
						            <label for="password_lama" class="control-label">Password Lama <span class="required">*</span> : </label>
						            <div class="controls">
						                <?php 
											echo form_password('password_lama', '', 'type="password" class="span6" maxlength="100"'); 
										?>
						            </div>
						        </div>
								<div class="control-group">
						            <label for="password_baru" class="control-label">Password Baru <span class="required">*</span> : </label>
						            <div class="controls">
						                <?php echo form_password('password_baru', '', 'class="span6" id="password_baru" maxlength="30"'); ?>
										<span style="color:red" id='result'></span> 
						            </div>
						        </div>
								<div class="control-group">
						            <label for="konf_password" class="control-label">Password Baru (konfirmasi)<span class="required">*</span> : </label>
						            <div class="controls">
						                <?php echo form_password('konf_password', '', 'class="span6" id="konf_password" maxlength="30"'); ?>
										<span style="color:red" id='result2'></span> 
						            </div>
						        </div>
						        <div class="form-actions">
						            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
						            <?php // echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
						        </div>
						        <?php echo form_close(); ?>
						    </div>
                            </div> 
                        </div>
                    </div>					
                </div>                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/password_strength_metter.js" ></script>
<script type="text/javascript">
    jQuery(function($) {
        $('#password_baru').keyup(function(){
			$('#result').html(passwordStrength($('#password_baru').val(),''));
		});
		$('#konf_password').keyup(function(){
			$('#result2').html(checkMatchPass($('#password_baru').val(), $('#konf_password').val()));
		});
    });
	
	function checkMatchPass(pass, konfPass){
		if(pass != konfPass){
			return "Password tidak sama.";
		} else {
			return '<i style="color:green" class="icon-ok"></i>';
		}
	}
</script>