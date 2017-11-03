<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Persediaan BBM'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>

                   
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 4 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date("Y-m-d")); $bulan = date("m",$now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan,'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
                    </div>
                </div>
                <div class="pull-left span1">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>
                </div>
                <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="well-content no-search">
            <!-- <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div> -->
            <table id="dataTable" class="table table-bordered table-striped" style="max-height:600px; overflow-y:auto; display:block">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="5">Level</th>
                    <th rowspan="2">Bahan Bakar</th>
                    <th rowspan="2">Tgl Mutasi Persediaan</th>
                    <th rowspan="2">Stok Awal (L)</th>
                    <th rowspan="2">Penerimaan Real (L)</th>
                    <th colspan="2">Pemakaian (L)</th>
                    <th rowspan="2">Volume Opname (L)</th>
                    <th rowspan="2">Dead Stok (L)</th>
                    <th colspan="2">Stok (L)</th>
                    <!-- <th rowspan="2">Stok Akhir Koreksi</th> -->
                    <th rowspan="2">SHO</th>
                    <th rowspan="2">REV</th>
                </tr>
                <tr>
                    <th>0</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>Sendiri</th>
                    <th>Kirim</th>
                    <th>Akhir</th>
                    <th>Akhir Efektif</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="18" align="center">Data Tidak Ditemukan</td>
            </tr>

            </tbody>
            </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>

    </div>
</div>

<script type="text/javascript">
    function convertToRupiah(angka)
        {
            var rupiah = '';        
            var angkarev = angka.toString().split('').reverse().join('');
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rupiah.split('',rupiah.length-1).reverse().join('');
        }

     $('#button-load').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bbm = $('#bbm').val();
        var bln = $('#bln').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('laporan/persediaan_bbm/getData'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "ID_JNS_BHN_BKR": bbm, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                            $('#dataTable tbody').empty();
                            var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                            $("#dataTable tbody").append(str);
                        } else {
                        
                         $('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                            // var NAMA_REGIONAL = value.NAMA_REGIONAL == null ? "" : value.NAMA_REGIONAL;
                            var LEVEL0 = value.LEVEL0 == null ? "" : value.LEVEL0;
                            var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                            var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                            var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var STOCK_AWAL = value.STOCK_AWAL == null ? "" : value.STOCK_AWAL;
                            var PENERIMAAN_REAL = value.PENERIMAAN_REAL == null ? "" : value.PENERIMAAN_REAL;
                            var PEMAKAIAN_SENDIRI = value.PEMAKAIAN_SENDIRI == null ? "" : value.PEMAKAIAN_SENDIRI;
                            var KIRIM = value.PEMAKAIAN_KIRIM == null ? "" : value.PEMAKAIAN_KIRIM;
                            var VOLUME = value.VOLUME_STOCKOPNAME == null ? "" : value.VOLUME_STOCKOPNAME;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            var REV = value.REVISI_MUTASI_PERSEDIAAN == null ? "" : value.REVISI_MUTASI_PERSEDIAAN;

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL0  + '</td>' +
                                    '<td>' + LEVEL1 + '</td>' +
                                    '<td>' + LEVEL2 + '</td>' +
                                    '<td>' + LEVEL3 + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOCK_AWAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(PENERIMAAN_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(PEMAKAIAN_SENDIRI) + '</td>' +
                                    '<td align="right">' + convertToRupiah(KIRIM) + '</td>' +
                                    '<td align="right">' + convertToRupiah(VOLUME) + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    // '<td>' + value.STOCK_AKHIR_KOREKSI + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '<td align="right">' +  REV + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
    });
</script>

<script type="text/javascript">
    jQuery(function($) {

        // if ($('select[name="ID_REGIONAL"]').val()!=''){$('select[name="ID_REGIONAL"').attr('disabled',true);}
        // if ($('select[name="COCODE"]').val()!=''){$('select[name="COCODE"').attr('disabled',true);}
        // if ($('select[name="PLANT"]').val()!=''){$('select[name="PLANT"').attr('disabled',true);}
        // if ($('select[name="STORE_SLOC"]').val()!=''){$('select[name="STORE_SLOC"').attr('disabled',true);}
        // if ($('select[name="SLOC"]').val()!=''){$('select[name="SLOC"').attr('disabled',true);}

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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv2/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv3/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv4/'+stateID;
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
    });
</script>