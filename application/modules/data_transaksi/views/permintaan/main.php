<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 12:59 AM
 */
?>


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
                    <div class="pull-left">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <div class="content_table">
                    <div class="well-content clearfix">
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
                                <label for="password" class="control-label">Pembangkit : </label>
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
                    </div>
                </div>
                <br>
                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                <div id="table_detail" hidden>
                    <form method="POST" id="formKirimDetail">
                        <div class="well-content clearfix">
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <div class="controls">
                                        <table>
                                            <tr>
                                                <td><label>Total data</label></td><td><label>:</label></td><td><label><info id="TOTAL"></info></label></td>
                                                <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                                <td></td><td></td><td></td>
                                            </tr>
                                            <tr>
                                                <td><label>Belum Kirim</label></td><td><label>:</label></td><td><label><info id="BELUM_KIRIM"></info></label></td>
                                                <td></td>
                                                <td><label>Disetujui</label></td><td><label>:</label></td><td><label><info id="DISETUJUI"></info></label></td>
                                            </tr>
                                            <tr>
                                                <td><label>Belum Disetujui</label></td><td><label>:</label></td><td><label><info id="BELUM_DISETUJUI"></info></label></td>
                                                <td></td>
                                                <td><label>Ditolak</label></td><td><label>:</label></td><td><label><info id="DITOLAK"></info></label></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <div class="controls">
                                        <table>
                                            <tr>
                                                <td colspan=2><label>Filter Status :</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo form_dropdown('CMB_STATUS', $status_options, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : '', 'class="span15"'); ?></td>
                                                <td> &nbsp </td>
                                                <!-- <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td> -->
                                            </tr>
                                        </table>
                                        <input type="hidden" name="vBLTH">
                                        <input type="hidden" name="vSLOC">
                                        <input type="hidden" name="vAKTIF">
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <div class="controls">
                                        <table>
                                            <tr><td>&nbsp</td></tr>
                                            <tr>
                                                <td>
                                                    <?php if (($this->laccess->otoritas('add') == true) && ($this->session->userdata('level_user') >= "2")) {?>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailKirim(this)" id="btn_kirim">Kirim</button>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailKirimClossing(this)" id="btn_kirim_cls">Kirim Clossing</button>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if (($this->laccess->otoritas('approve') == true) && ($this->session->userdata('level_user') == "2")) {?>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailApprove(this)" id="btn_approve">Approve</button>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailKirimClossing(this)" id="btn_approve_cls">Approve Clossing</button>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if (($this->laccess->otoritas('approve') == true) && ($this->session->userdata('level_user') == "2")) {?>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailTolak(this)" id="btn_tolak">Tolak</button>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <table class="table table-bordered table-striped" id="detailPermintaan">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TGL NOMINASI</th>
                                    <th>NAMA PEMASOK</th>
                                    <th>NAMA JNS BHN BKR</th>
                                    <th>VOL NOMINASI (L)</th>
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
    var offset = -100;

    function toRupiah(angka){
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function pageScroll() {
        window.scrollBy(0,100); 
        if(window.pageYOffset == offset) return;
        offset = window.pageYOffset;
        scrolldelay = setTimeout('pageScroll()',100); 
    }

    function show_detail(tanggal) {
        if (!$('#table_detail').is(":visible")) {
            bootbox.modal('<div class="loading-progress"></div>');
            var vId = tanggal;
            var strArray = vId.split("|");
            var tr = document.getElementById(strArray[2]);
            var tds = tr.getElementsByTagName("td");

            for(var i = 0; i < tds.length; i++) {
              tds[i].style.backgroundColor ="#E0E6F8";
            }

            $('input[name="vBLTH"]').val(strArray[0]);
            $('input[name="vSLOC"]').val(strArray[1]);
            $('input[name="vAKTIF"]').val(strArray[2]);
            $('#detailPermintaan tbody tr').detach();

            if (strArray.length ==3){
                $('select[name="CMB_STATUS"]').val('');  
                get_sum_detail(tanggal); 
                setTombolClossing(0); 
            }

            var data_kirim = {ID_REGIONAL: $('select[name="ID_REGIONAL"]').val(),
                COCODE: $('select[name="COCODE"]').val(),
                PLANT: $('select[name="PLANT"]').val(),
                STORE_SLOC: $('select[name="STORE_SLOC"]').val(),
                SLOC: strArray[1],
                TGL_PENGAKUAN:strArray[0],
                BULAN: $('select[name="BULAN"]').val(),
                TAHUN: $('select[name="TAHUN"]').val(),
                STATUS: $('select[name="CMB_STATUS"]').val(),
            };

            $.post("<?php echo base_url()?>data_transaksi/permintaan/getDataDetail/", data_kirim, function (data) {
                var data_detail = (JSON.parse(data));
                var cekbox = '';
                var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";
                var vUserName = "<?php echo $this->session->userdata('user_name'); ?>";
                var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";
                var vIsApprove = "<?php echo $this->laccess->otoritas('approve'); ?>";
                var vSetEdit='';
                var vEdit='';
                var vEditView='';
                var vlink_url = '';

                for (i = 0; i < data_detail.length; i++) {

                    cekbox = '<input type="checkbox" name="pilihan[' + i + ']" id="pilihan" value="'+data_detail[i].ID_PERMINTAAN+'">';

                    vlink_url = "<?php echo base_url()?>data_transaksi/permintaan/edit_view/"+data_detail[i].ID_PERMINTAAN;
                    vEditView = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PERMINTAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-file-alt" title="Lihat Data"></i></a>'; 

                    vlink_url = "<?php echo base_url()?>data_transaksi/permintaan/edit/"+data_detail[i].ID_PERMINTAAN;
                    vEdit = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PERMINTAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-edit" title="Edit Data"></i></a>'; 

                    vSetEdit = vEditView;

                    if (vLevelUser>=2){
                        if (vLevelUser==2){
                            if (vIsAdd){
                                if((data_detail[i].KODE_STATUS == "1") || (data_detail[i].KODE_STATUS == "2")){
                                    cekbox = '';  
                                } else {
                                    if(data_detail[i].CREATED_BY==vUserName){
                                        vSetEdit = vEdit;     
                                    }    
                                }                               
                            }

                            if (vIsApprove){
                                if (data_detail[i].KODE_STATUS !== "1"){
                                    cekbox = '';
                                }  

                                if (data_detail[i].KODE_STATUS == "0"){
                                    vSetEdit = '';
                                }                                 
                            }
                        }

                        if ((vLevelUser==3) || (vLevelUser==4)){
                            if (data_detail[i].KODE_STATUS !== "0"){
                                cekbox = '';
                            } 
                            if(data_detail[i].KODE_STATUS == "0"){
                                if(data_detail[i].CREATED_BY==vUserName){
                                        vSetEdit = vEdit;     
                                    }
                            }
                        }
                    } else {
                       cekbox = ''; 
                    }

                    $('#detailPermintaan tbody').append(
                        '<tr>' +
                        '<td align="center">' + data_detail[i].ID_PERMINTAAN + '</td>' +
                        '<td align="center">' + data_detail[i].TGL_MTS_NOMINASI + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_PEMASOK + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_JNS_BHN_BKR + '</td>' +
                        '<td align="right">' + toRupiah(data_detail[i].VOLUME_NOMINASI) + '</td>' +
                        '<td align="center">' + data_detail[i].STATUS + '</td>' +
                        '<td align="center">' + vSetEdit +' </td>' +
                        '<td align="center">' +
                        cekbox+
                        '<input type="hidden" id="idPermintaan" name="idPermintaan[' + i + ']" value="' + data_detail[i].ID_PERMINTAAN + '">' +
                        '<input type="hidden" id="status" name="status[' + i + ']" value="' + data_detail[i].STATUS + '">' +
                        '</td>' +
                        '</tr>'
                    );
                }
            });     
            $(".bootbox").modal("hide");
            $('#table_detail').show();
            pageScroll();
        } else {
            $('#detailPermintaan tbody tr').detach();
            $('#table_detail').hide();
            $('td').removeAttr('style');
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

    function saveDetailApprove(obj) {
        if (cekChekBoxPilih('approve')){return;}
		bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
			if(e){
				bootbox.modal('<div class="loading-progress"></div>');
				var url = "<?php echo base_url() ?>data_transaksi/permintaan/saveKiriman/approve";
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
		bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
			if(e){
				var url = "<?php echo base_url() ?>data_transaksi/permintaan/saveKiriman/tolak";
				bootbox.modal('<div class="loading-progress"></div>');
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
            $('#detailPenerimaan tbody tr').detach();
            $('#table_detail').hide();
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
        $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv4/'+stateID;
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


    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    function get_sum_detail(tanggal) {
        var vId = tanggal;
        var strArray = vId.split("|");
        var data = {SLOC: strArray[1],TGL_PENGAKUAN:strArray[0]};

        $.post("<?php echo base_url()?>data_transaksi/permintaan/get_sum_detail/", data, function (data) {
            var data_detail = (JSON.parse(data));

            for (i = 0; i < data_detail.length; i++) {
                $('#TOTAL').html(formatNumber(data_detail[i].TOTAL));
                $('#BELUM_KIRIM').html(formatNumber(data_detail[i].BELUM_KIRIM));
                $('#BELUM_DISETUJUI').html(formatNumber(data_detail[i].BELUM_DISETUJUI));
                $('#DISETUJUI').html(formatNumber(data_detail[i].DISETUJUI));
                $('#DITOLAK').html(formatNumber(data_detail[i].DITOLAK));
            }
        });
    }

    $('select[name="CMB_STATUS"]').on('change', function() {
        var vBLTH = $('input[name="vBLTH"]').val();
        var vSLOC = $('input[name="vSLOC"]').val();
        var vAKTIF = $('input[name="vAKTIF"]').val();
        var vSTATUS = $(this).val();
        var vParam = vBLTH+'|'+vSLOC+'|'+vAKTIF+'|'+vSTATUS;

        if (vSTATUS==4) {
            setTombolClossing(1);   
        } else {
            setTombolClossing(0);    
        }

        show_detail(vParam);
        show_detail(vParam);
    });  

    function setTombolClossing(stat){
        var vIsApprove = "<?php echo $this->laccess->otoritas('approve'); ?>";
        var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";

        if (stat==1){
            if (vIsApprove){
                $("#btn_approve").hide(); 
                $("#btn_approve_cls").show();  
            } 
            if (vIsAdd){
                $("#btn_kirim").hide(); 
                $("#btn_kirim_cls").show();  

            }
        } else {
            if (vIsApprove){
                $("#btn_approve").show(); 
                $("#btn_approve_cls").hide();  
            } 
            if (vIsAdd){
                $("#btn_kirim").show(); 
                $("#btn_kirim_cls").hide();  

            }
        }
    }

</script>