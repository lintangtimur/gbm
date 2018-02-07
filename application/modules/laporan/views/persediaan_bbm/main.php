<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    tr {background-color: #CED8F6;}

        table {
            border-collapse: collapse;
            width:100%;
            /*font-size: 10px;*/
        }
        .dataTables_filter{
           display: none;
         }
        /*td,  th {
            border: 1px solid  #f4f6f6 ;
        }
*/
        /*table.tdetail thead {background-color: #CED8F6}*/

/*    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }*/

</style>

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
                    <label for="password" class="control-label">Jenis Bahan Bakar : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <!-- <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                    </div>
                </div> -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Periode <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:38px"></label>
                    <div class="controls">
                        <?php
                            // $TGL_DARI = date("Y-m");
                            // $TGL_DARI = $TGL_DARI.'-01';
                            // $TGL_SAMPAI = date("Y-m-d");
                        ?>
                        <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                  <!-- <label for="" class="control-label" style="margin-left:1px;">Tampil data</label>
                  <div class="controls">
                    <?php echo form_dropdown('tampilData', array(
                      '-Tampilkan Data-'=> 'Tampilkan Data',
                      '25'              => '25 data',
                      '50'              => '50 data',
                      '100'             => '100 data',
                      '200'             => '200 data'
                    ), '', 'style="margin-left:1px;" id="tampilData"') ?>
                  </div> -->
                </div>
                <div class="pull-left span2">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="cariPembangkit" name="" value="">
                    </div>
                </div>
                <div class="pull-left span1">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>
                </div>
            </div>
            <div class="form_row">
              <div class="pull-left span2">

              </div>
              <div class="pull-left span2">

              </div>
              <div class="pull-left span2">

              </div>
              <div class="pull-left span4">
                  <label></label>
                  <div class="controls">
                  <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                  </div>
              </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="well-content no-search">
            <table id="dataTable" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="4">Level</th>
                    <th rowspan="2">Pembangkit</th>
                    <th rowspan="2">Bahan Bakar</th>
                    <th rowspan="2">Tgl Mutasi Persediaan</th>
                    <th rowspan="2">Stok Awal (L)</th>
                    <th colspan="2">Penerimaan (L)</th>
                    <th colspan="2">Pemakaian (L)</th>
                    <th rowspan="2">Volume Opname (L)</th>
                    <th rowspan="2">Dead Stok (L)</th>
                    <th rowspan="2">Max Pemakaian (L)</th>
                    <th colspan="2">Stok (L)</th>
                    <th rowspan="2">SHO (Hari)</th>
                </tr>
                <tr>
                    <th>0</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>Terima Pemasok</th>
                    <th>Terima Unit Lain</th>
                    <th>Sendiri</th>
                    <th>Kirim</th>
                    <th>Akhir</th>
                    <th>Akhir Efektif</th>
                </tr>
            </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>

    </div>
</div>

<form id="export_excel" action="<?php echo base_url('laporan/persediaan_bbm/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xbbm">
    <input type="hidden" name="xbln">
    <input type="hidden" name="xthn">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/persediaan_bbm/export_pdf_newVersion'); ?>" method="post" >
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="pbbm">
    <input type="hidden" name="pbln">
    <input type="hidden" name="pthn">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
</form>

<script type="text/javascript">
    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    $('#cariPembangkit').on( 'keyup', function () {
        var table = $('#dataTable').DataTable();
        table.search( this.value ).draw();
    } );

    //Untuk button tampilkan data
    $('#tampilData').on('change', function () {
      oTable = $('#dataTable').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = this.value;
      oTable.fnDraw();
    });

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    function setCekTgl(){
         var dateStart = $('#tglawal').val();
         var dateEnd = $('#tglakhir').val();

         if (dateEnd < dateStart){
             $('#tglakhir').datepicker('update', dateStart);
         }
     }

     $('#tglawal').on('change', function() {
         var dateStart = $(this).val();
         $('#tglakhir').datepicker('setStartDate', dateStart);
         if ($('#tglakhir').val() == '') {

         }else{
           setCekTgl();
         }
     });

     $('#tglakhir').on('change', function() {
         setCekTgl();
     });

    function convertToRupiah(angka){
        var bilangan = angka.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            isMinus = '-';
        }

        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        if ((rupiah=='') || (rupiah==0)) {rupiah='0,00'}
        rupiah = isMinus+''+rupiah;

        return rupiah;
    }

    $(document).ready(function() {
        $('#dataTable').dataTable({
            "scrollY": "450px",
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":true,
            "bLengthChange": true,
            "lengthMenu": [10,25,50,100,200],
            "bFilter": false,
            "bInfo": true,
            "bAutoWidth": true,
            "ordering": false,
            "fixedColumns": {"leftColumns": 6},
            "language": {
                "decimal": ",",
                "thousands": ".",
                "infoEmpty": "Total Data: 0",
                "info": "Total Data: _MAX_",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_"
            },
            "columnDefs": [
                 {"className": "dt-right", "targets": [8,9,10,11,12,13,14,15,16,17,18]}
          ]
        });
    } );

    $('#button-load').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bbm = $('#bbm').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        var tglawal = $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var tglakhir = $('#tglakhir').val().replace(/-/g, '');


        if (lvl0=='') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        }else if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        }  else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('laporan/persediaan_bbm/getData'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "ID_JNS_BHN_BKR": bbm, "BULAN":bln, "TAHUN": thn, "TGL_DARI":tglawal, "TGL_SAMPAI":tglakhir},
                    success:function(response) {
                        var obj = JSON.parse(response);

                        var t = $('#dataTable').DataTable();
                        t.clear().draw();

                        if (obj == "" || obj == null) {
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                        } else {

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
                            var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;


                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');
                            if ((SHO=='') || (SHO==0)) {SHO='0,00'}
                            var REV = value.REVISI_MUTASI_PERSEDIAAN == null ? "0" : value.REVISI_MUTASI_PERSEDIAAN;
                            var TERIMA_PEMASOK = value.TERIMA_PEMASOK == null ? "0" : value.TERIMA_PEMASOK;
                            var TERIMA_UNITLAIN = value.TERIMA_UNITLAIN == null ? "0" : value.TERIMA_UNITLAIN;

                            t.row.add( [nomer,LEVEL0,LEVEL1,LEVEL2,LEVEL3,LEVEL4,NAMA_JNS_BHN_BKR,TGL_MUTASI_PERSEDIAAN,convertToRupiah(STOCK_AWAL),convertToRupiah(TERIMA_PEMASOK),convertToRupiah(TERIMA_UNITLAIN),convertToRupiah(PEMAKAIAN_SENDIRI),convertToRupiah(KIRIM),convertToRupiah(VOLUME),convertToRupiah(DEAD_STOCK),convertToRupiah(MAX_PEMAKAIAN),convertToRupiah(STOK_REAL),convertToRupiah(STOK_EFEKTIF),SHO
                            ] ).draw( false );

                            nomer++;

                          });
                          bootbox.hideAll();
                        };
                    }
                });
        };
    });


    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        if (tglawal == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Tanggal Awal-- </div>', function() {});
        } else if (tglakhir == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Tanggal Akhir-- </div>', function() {});
        } else if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Regional-- </div>', function() {});
        } else {
            $('input[name="xlvl0"]').val($('#lvl0').val());
            $('input[name="xlvl1"]').val($('#lvl1').val());
            $('input[name="xlvl2"]').val($('#lvl2').val());
            $('input[name="xlvl3"]').val($('#lvl3').val());

            $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="xlvl4"]').val($('#lvl4').val());
            $('input[name="xbbm"]').val($('#bbm').val());
            $('input[name="xbln"]').val($('#bln').val());
            $('input[name="xthn"]').val($('#thn').val());
            $('input[name="xtglawal"]').val($('#tglawal').val());
            $('input[name="xtglakhir"]').val($('#tglakhir').val());

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        if (tglawal == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Tanggal Awal-- </div>', function() {});
        } else if (tglakhir == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Tanggal Akhir-- </div>', function() {});
        } else if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan Pilih Regional-- </div>', function() {});
        } else {
            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());
            $('input[name="pbbm"]').val($('#bbm').val());
            $('input[name="pbln"]').val($('#bln').val());
            $('input[name="pthn"]').val($('#thn').val());
            $('input[name="ptglawal"]').val($('#tglawal').val());
            $('input[name="ptglakhir"]').val($('#tglakhir').val());

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
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
