<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <div class="control-group" id="ldap_info">
            <label  class="control-label">User LDAP : <span class="required"></span></label>
            <div class="controls">
                <?php echo form_input('ldap_user','', 'class="span4" maxlength="100" placeholder="domain\user_ldap"'); ?>
                <?php echo anchor(null, 'Info LDAP', array('id' => 'button-get-ldap', 'class' => 'green btn')); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Kode User : <span class="required">*</span></label>
            <div class="controls">
                <?php echo form_input('kode_user', !empty($default->KD_USER) ? $default->KD_USER : '', 'class="span4" maxlength="100" placeholder="Kode User"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nama <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('nama_user', !empty($default->NAMA_USER) ? $default->NAMA_USER : '', 'class="span6" placeholder="Nama User"'); ?>
            </div>
        </div>
		 <div class="control-group">
            <label for="password" class="control-label">Email <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('email_user', !empty($default->EMAIL_USER) ? $default->EMAIL_USER : '', 'class="span6" placeholder="Email User"'); ?>
            </div>
        </div>
         <div class="control-group">
            <label for="password" class="control-label">Role <span class="required">*</span> : </label>
            <div class="controls">
				<input type="hidden" name="level_user" id="level_user" value="<?php echo empty($default->ROLES_ID) ? '': $default->ROLES_ID ."..".$default->LEVEL_USER ;?>"/>
                <?php echo form_dropdown('role_id', $role_options, !empty($default->ROLES_ID) ? $default->ROLES_ID ."..".$default->LEVEL_USER : '', 'class="span6 chosen" id="role_id"'); ?>
            </div>
        </div>
		 <div class="control-group" id="regional" style="display:none;">
            <label  class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_regional', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2 " id="kode_regional"'); ?>
            </div>
        </div>
        <div class="control-group" id="level1" style="display:none;">
            <label  class="control-label">Level 1<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level1', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level1"'); ?>
            </div>
        </div>
		<div class="control-group" id="level2" style="display:none;">
            <label  class="control-label">Level 2<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level2', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level2"'); ?>
            </div>
        </div>
		<div class="control-group" id="level3" style="display:none;">
            <label  class="control-label">Level 3<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level3', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level3"'); ?>
            </div>
        </div>
		<div class="control-group" id="level4" style="display:none;">
            <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('kode_level4', $bindlevel, !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : '', 'class="span8 select2" id="kode_level4"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Username <span class="required">*</span> : </label>
            <div class="controls">
                <?php 
                echo form_input('user_username', !empty($default->USERNAME) ? $default->USERNAME : '', 'class="span6"  placeholder="Username" '. $disabled); 
                ?>
            </div>
        </div>
		<!-- <div class="control-group">
            <label for="password" class="control-label">Password <span class="required">*</span> : </label>
            <div class="controls">
                <?php 
                echo form_password('password', !empty($default->PWD_USER) ? $default->PWD_USER : '', 'class="span6"'); 
                ?>
            </div>
        </div> -->
        <div class="control-group">
            <label for="password" class="control-label">Status <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('user_status', hgenerator::status_user(), !isset($default->ISAKTIF_USER) ? '' : $default->ISAKTIF_USER , 'class="span4 chosen"'); ?>
            </div>
        </div>
        <div class="control-group" id="ldap_ket">
            <label for="password" class="control-label"></label>
            <div class="controls">
                <span class="required">*) Pengisian user LDAP : 'domain\user_ldap' (contoh : pusat\devgbm)</span>
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
$(function(){
    $('.chosen').chosen();
	$( "#role_id" ).change(function() {
		idlevel = $(this).val();
		a = idlevel.split("..");
		console.log(a);
		$("#regional").hide();
		$("#level1").hide();
		$("#level2").hide();
		$("#level3").hide();
		$("#level4").hide();
		$("#level_user").val(idlevel);
		if (a[1] !== "0")
			load_level('<?php echo $loadlevel; ?>R',a[1], "#kode_regional", "#regional");
		
	});
	
	$( "#kode_regional" ).change(function() {
		load_level('<?php echo $loadlevel; ?>1/'+$(this).val(),'', "#kode_level1");
	});
	$( "#kode_level1" ).change(function() {
		load_level('<?php echo $loadlevel; ?>2/'+$(this).val(),'', "#kode_level2");
	});
	$( "#kode_level2" ).change(function() {
		load_level('<?php echo $loadlevel; ?>3/'+$(this).val(),'', "#kode_level3");
	});
	$( "#kode_level3" ).change(function() {
		a = $("#kode_level2").val();
		b = $("#kode_level3").val();
		c = a + ".." + b;
		load_level('<?php echo $loadlevel; ?>4/'+c,'', "#kode_level4");
	});
	
	level = '<?php echo !empty($default->LEVEL_USER) ? $default->LEVEL_USER : ''; ?>';
	kodelevel = '<?php echo !empty($default->KODE_LEVEL) ? $default->KODE_LEVEL : ''; ?>';
	if(level === 'R')
		load_dynamic_levelgroup('<?php echo $url_levegroup; ?>' + level,kodelevel, "#kode_regional", level);
	else if(level == "1")
		load_dynamic_levelgroup('<?php echo $url_levegroup; ?>' + level +"/"+kodelevel,kodelevel, "#kode_level1,#kode_regional", level);
	else if(level == "2")
		load_dynamic_levelgroup('<?php echo $url_levegroup; ?>' + level +"/"+kodelevel,kodelevel, "#kode_level2,#kode_level1,#kode_regional", level);
	else if(level == "3")
		load_dynamic_levelgroup('<?php echo $url_levegroup; ?>' + level +"/"+kodelevel,kodelevel, "#kode_level3,#kode_level2,#kode_level1,#kode_regional", level);
	else if(level == "4")
		load_dynamic_levelgroup('<?php echo $url_levegroup; ?>' + level +"/"+kodelevel,kodelevel, "#kode_level4,#kode_level3,#kode_level2,#kode_level1,#kode_regional", level);
	
    $("#button-get-ldap").click(function () {
        bootbox.confirm('Apakah yakin akan akses info LDAP ?', "Tidak", "Ya", function(e) {
            if(e){
                get_info_ldap();
            }
        });
    });	

    if ($('input[name="id"]').val()){
        $("#ldap_info").hide();  
        $("#ldap_ket").hide();   
    }

    function get_info_ldap() {
        var data = {ldap_user: $('input[name="ldap_user"]').val()};
        bootbox.modal('<div class="loading-progress"></div>');
        $.post("<?php echo base_url()?>user_management/user/get_info_ldap/", data, function (data) {
            var data_detail = (JSON.parse(data));
            $(".bootbox").modal("hide");

            if (data_detail.status) {
                icon = 'icon-ok-sign';
                color = '#0072c6;';
            } else {
                icon = 'icon-remove-sign';
                color = '#ac193d;';                
            }

            var message = '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i>  '+data_detail.msg+'</div>';

            bootbox.alert(message, function() {});

            if (data_detail.status) {
                $('input[name="kode_user"]').val(data_detail.ldap_nik);
                $('input[name="nama_user"]').val(data_detail.ldap_nama);
                $('input[name="email_user"]').val(data_detail.ldap_email);
                $('input[name="user_username"]').val(data_detail.ldap_user);
            }
        });
    }

    function saveDetailKirim(obj) {
        if (cekChekBoxPilih('kirim')){return;}
        bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var url = "<?php echo base_url() ?>data_transaksi/permintaan/saveKiriman/kirim";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('#formKirimDetail').serializeArray(),
                    dataType:"json",
                    success: function (data) {
                        $(".bootbox").modal("hide");
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];
                        bootbox.alert(message, function() {
                            load_table("#content_table", 1);
                            $('#detailPenerimaan tbody tr').detach();
                            $('#table_detail').hide();
                        });
                    }
                });
            }
        });
    }
	
});
</script>