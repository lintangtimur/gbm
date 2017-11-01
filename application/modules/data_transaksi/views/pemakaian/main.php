<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 12:59 AM
 */
?>

        <!-- <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" /> -->
        <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
 <!--        <link href="./css/prettify-1.0.css" rel="stylesheet">
        <link href="./css/base.css" rel="stylesheet"> -->
        
        <!-- <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet"> -->

        <!-- <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script> -->
        
        <!-- <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script> -->
            <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script> -->
            <!-- <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script> -->

<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
</div>
<div class="widgets_area">
    <div class="row-fluid">
        <div class="span12">
            <div id="index-content" class="well-content no-search">
                <div class="well">
                    <div class="content_table">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                <div class="form_row">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Regional : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 1 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 2 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                        </div>
                    </div>
                </div><br/>
                <div class="form_row">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 3 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 4 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                        <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;", id="bln"'); ?>
                            <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form_row">
                    <div class="pull-left span5">
                        <div class="controls">
                            <table>
                                <tr>
                                    <td colspan=2><label>Kata Kunci</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo form_input('kata_kunci', '', 'class="input-large"'); ?></td>
                                    <td> &nbsp </td>
                                    <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <br>
                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                <div id="table_detail" hidden>
                    <form method="POST" id="formKirimDetail">
                        <div class="well-content clearfix">
                            <table class="pull-right">
                                <tr>
                                    <td>
                                        <?php if ($this->session->userdata('level_user') > "2"){
                                            if ($this->laccess->otoritas('add') == true){?>
                                                <button class="btn btn-primary" type="button" onclick="saveDetailKirim(this)">Kirim</button>
                                        <?php }}?>
                                    </td>
                                    <td>
                                        <?php if ($this->laccess->otoritas('approve') == true && $this->session->userdata('level_user') == "2") {?>
                                                <button class="btn btn-primary" type="button" onclick="saveDetailApprove(this)">Approve</button>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($this->laccess->otoritas('approve') == true && $this->session->userdata('level_user') == "2") {?>
                                                <button class="btn btn-primary" type="button" onclick="saveDetailTolak(this)">Tolak</button>
                                        <?php }?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="content">
                            <table class="table table-bordered table-striped" id="detailPenerimaan">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TGL PENGAKUAN</th>
                                    <th>NAMA JNS BHN BKR</th>
                                    <th>VOL PEMAKAIAN (L)</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                    <th>CHECK</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div id="form-content" class="well-content"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var icon = 'icon-remove-sign';
	var color = '#ac193d;';
    function toRupiah(angka){
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }
    function show_detail(tanggal) {
        if (!$('#table_detail').is(":visible")) {
            var vId = tanggal;
            var strArray = vId.split("|");

            var data = {ID_REGIONAL: $('select[name="ID_REGIONAL"]').val(),
                        COCODE: $('select[name="COCODE"]').val(),
                        PLANT: $('select[name="PLANT"]').val(),
                        STORE_SLOC: $('select[name="STORE_SLOC"]').val(),
                        SLOC: strArray[1],
                        TGL_PENGAKUAN:strArray[0],
                        BULAN: $('select[name="BULAN"]').val(),
                        TAHUN: $('select[name="TAHUN"]').val(),
                        };
            // $.get("<?php echo base_url()?>data_transaksi/pemakaian/getDataDetail/" + tanggal, function (data) {
            $.post("<?php echo base_url()?>data_transaksi/pemakaian/getDataDetail/", data, function (data) {
                var data_detail = (JSON.parse(data));
				var cekbox = '';
                var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";
                var vEdit='';
                var vlink_url = '';

                for (i = 0; i < data_detail.length; i++) {
                    cekbox = '<input type="checkbox" name="pilihan[' + i + ']" id="pilihan" value="'+data_detail[i].ID_PEMAKAIAN+'">';
                    vlink_url = "<?php echo base_url()?>data_transaksi/pemakaian/edit_view/"+data_detail[i].ID_PEMAKAIAN;
                    vEdit = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PEMAKAIAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-edit"></i></a>'; 

                    if (vLevelUser>=2){
                        if (vLevelUser==2){
                            if (data_detail[i].KODE_STATUS !== "1"){
                                cekbox = '';
                            }   
                            if (data_detail[i].KODE_STATUS == "0"){
                                vEdit = '';
                            }  
                        }

                        if ((vLevelUser==3) || (vLevelUser==4)){
                            if((data_detail[i].KODE_STATUS == "1") || (data_detail[i].KODE_STATUS == "2")){
                                cekbox = '';  
                            }
                            if((data_detail[i].KODE_STATUS == "0") || (data_detail[i].KODE_STATUS == "3")){
                                vlink_url = "<?php echo base_url()?>data_transaksi/pemakaian/edit/"+data_detail[i].ID_PEMAKAIAN;
                                vEdit = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PEMAKAIAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-edit"></i></a>'; 
                            }
                        }
                    } else {
                       cekbox = ''; 
                    }

                    $('#detailPenerimaan tbody').append(
                        '<tr>' +
                        '<td align="center">' + data_detail[i].ID_PEMAKAIAN + '</td>' +
                        '<td align="center">' + data_detail[i].TGL_PENGAKUAN + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_JNS_BHN_BKR + '</td>' +
                        '<td align="right">' + toRupiah(data_detail[i].VOLUME_PEMAKAIAN) + '</td>' +
                        '<td align="center">' + data_detail[i].STATUS_PEMAKAIAN + '</td>' +
                        '<td align="center">' + vEdit +' </td>' +
                        '<td align="center">' +
                        cekbox +
						'<input type="hidden" id="idPenerimaan" name="idPenerimaan[' + i + ']" value="' + data_detail[i].ID_PEMAKAIAN + '">' +
                        '<input type="hidden" id="status" name="status[' + i + ']" value="' + data_detail[i].STATUS_PEMAKAIAN + '">' +
                        '</td>' +
                        '</tr>'
                    );
					cekbox = '';
                }
            });
            $('#table_detail').show();
        } else {
            $('#detailPenerimaan tbody tr').detach();
            $('#table_detail').hide();
        }
    }

    function cekChekBoxPilih(vJenis){
        var data = $('#formKirimDetail').serializeArray();

        var arrNames = [];
        Object.keys(data).forEach(function(key) {
          var val = data[key]["name"];
          arrNames.push(val);
        }); 

        var vAda=1;
        for (var i=0; i < arrNames.length ; ++i) {
            var str = arrNames[i];
            var res =  str.substr(0, 7);

            if (res=='pilihan'){
                vAda = 0;
            }
        }

        if (vAda){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Silahkan pilih data yang akan di '+vJenis+'</div>';
            bootbox.alert(message, function() {});
        }

        return vAda;
    }

    function saveDetailKirim(obj) {
        if (cekChekBoxPilih('kirim')){return;}
        var url = "<?php echo base_url() ?>data_transaksi/pemakaian/saveKiriman/kirim";
		bootbox.confirm('Yakin data ini akan dikirim ?', "Tidak", "Ya", function(e) {
			if(e){
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

    function saveDetailApprove(obj) {
        if (cekChekBoxPilih('approve')){return;}
        var url = "<?php echo base_url() ?>data_transaksi/pemakaian/saveKiriman/approve";
		bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
			if(e){
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
    function saveDetailTolak(obj) {
        if (cekChekBoxPilih('tolak')){return;}
        var url = "<?php echo base_url() ?>data_transaksi/pemakaian/saveKiriman/tolak";
		bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
			if(e){
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

    jQuery(function ($) {
        load_table('#content_table', 1, '#ffilter');
        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');
        });
    });

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

    function setDefaultLv4(){
        $('select[name="SLOC"]').empty();
        $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
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

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                }
            });
        }
    });    
</script>