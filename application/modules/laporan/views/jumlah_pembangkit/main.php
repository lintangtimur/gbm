<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet"></script>
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css"> -->
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>


<style>
.modal .modal-lg {
    max-width: 120% !important;
}
.detail-kosong{
    display: none;
}
    tr {background-color: #CED8F6;}

        table {
            border-collapse: collapse;
            width:100%;
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
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Penerimaan BBM'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', ['id' => 'ffilter']); ?>
            <div class="form_row">
                <!-- Regional -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                    </div>
                </div>

                <!-- Level 1 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>

                <!-- Level 2 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <!-- Level 3 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>

                <div class="pull-left span3">
                    <label for="password" class="control-label">Pembangkit<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <!-- jenis bahan bakar -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Bahan Bakar <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div>




            </div><br/>
            <div class="form_row">
                <div class="pull-left span2">
                    <label for="password" class="control-label">Cari pembangkit<span class="required">*</span> : </label>
                    <div class="controls">
                        <input type="text" id="cariPembangkit" name="" value="">
                    </div>
                </div>
                <div class="pull-left span1">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-search'></i> Load", ['class' => 'btn', 'id' => 'button-load']); ?>
                    </div>
                </div>
            </div>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                    </div>
                </div>
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                        <!-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#exampleModal' name="button">TSest</button> -->
                    <?php echo anchor(null, "<i class='icon'></i> Detail", [
                        'class'       => 'btn green detail-kosong',
                        'id'          => 'button-detail'
                        // 'data-toggle' => 'modal',
                        // 'data-target' => '#exampleModal'
                    ]); ?>
                    </div>
                </div>
                <!-- Tampilan modal detail -->

                <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", [
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    ]); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", [
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    ]); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="well-content no-search">
            <table id="dataTable" class="display" width="100%" cellspacing="0" style="max-height:1000px;">
                <thead>
                    <tr>
                        <th width="10px">No</th>
                        <th width="300px">Unit</th>
                        <th>Jumlah Pembangkit</th>
                        <th>Pembangkit Aktif</th>
                        <th>Pembangkit Non-Aktif</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>
        <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", [
                  'class' => 'btn',
                  'id'    => 'button-excel-detail'
              ]); ?>
              <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", [
                  'class' => 'btn',
                  'id'    => 'button-pdf-detail'
              ]); ?>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
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
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/persediaan_bbm/export_pdf'); ?>" method="post" >
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
</form>

<script type="text/javascript">

    $(document).ready(function() {
        $('#button-detail').addClass('disabled');
        // $("#button-detail").attr("disabled", true);
    });
    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    function convertToRupiah(angka){
        var bilangan = angka.replace(".", ",");

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

        return rupiah;
    }

    $(document).ready(function() {
      disableBtn();
        $('#dataTable').dataTable({
            "scrollY": "450px",
            "searching": true,
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": true,
            "bAutoWidth": true,
            "ordering": false,
            // "fixedColumns": {"leftColumns": 6},
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan"
            },
            "columnDefs": [
                {
                        "className": "dt-left",
                        "targets": [1]
                },
                {
                        "className": "dt-center",
                        "targets": [0,2,3,4]
                }
            ]
          //   "columnDefs": [
          //        {"className": "dt-right", "targets": [8,9,10,11,12,13,14,15]}
          // ]
        });
    } );


    $('#button-load').click(function(e) {
        // $(".bdet").attr("disabled", true);
        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown

        //check last filled vlevlid

        if (lvl0=='') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            // lvl0 : jenis2 level -> Regional,Level 1, Level 2, Level 3
            // lvl3 : isi dari VLEVELID
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
            }
            if (lvl1 !== "") {
                lvl0 = 'Level 1';
                vlevelid = $('#lvl1').val();
            }
            if (lvl2 !== "") {
                lvl0 = 'Level 2';
                vlevelid = $('#lvl2').val();
            }
            if (lvl3 !== ""){
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
            if (bbm !== "") {
                bbm = $('#bbm').val();
                if (bbm =='001') {
                    bbm = 'MFO';
                }else if(bbm == '002'){
                    bbm = 'IDO';
                }else if(bbm == '003'){
                    bbm = 'BIO';
                }else if(bbm == '004'){
                    bbm = 'HSD+BIO';
                }else if(bbm == '005'){
                    bbm = 'HSD';
                }
            }
            if (bbm == '') {
                bbm = '-';
            }

            console.log("bbm: " + bbm + ' tahun: '+thn+' bulan: '+bln +' regional: '+ lvl0+' vlevlid: ' + vlevelid);
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url : "<?php echo base_url('laporan/jumlah_pembangkit/getDataPembangkit'); ?>",
                    data: {
                        "ID_REGIONAL": lvl0,
                        "VLEVELID":vlevelid
                        },
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
                            var UNIT = value.UNIT == null ? "" : value.UNIT;
                            var totalPembangkit = value.TOTAL_PEMBANGKIT == null ? "" : value.TOTAL_PEMBANGKIT;
                            var pembangkitAktif = value.PEMBANGKIT_AKTIF == null ? "" : value.PEMBANGKIT_AKTIF;
                            var pembangkitNonAktif = value.PEMBANGKIT_NON_AKTIF == null ? "" : value.PEMBANGKIT_NON_AKTIF;

                            t.row.add( [
                                nomer, UNIT, totalPembangkit, pembangkitAktif, pembangkitNonAktif
                            ] ).draw( false );
                            nomer++;
                          });
                          bootbox.hideAll();
                        };
                    }
                });
        };
    });

    $('#cariPembangkit').on( 'keyup', function () {
        console.log(this.value);
        var table = $('#dataTable').DataTable();
        table.search( this.value ).draw();
    } );
    //when datatable detailButton clicked
    function clearDT_Detail()
    {
        var t = $('#dataTable_detail').DataTable();
        t.clear().draw();
    }

    function disableBtn() {
        document.getElementById("bln").disabled = true;
        document.getElementById("thn").disabled = true;
        document.getElementById("bbm").disabled = true;
    }
    // $('#dataTable tbody').on( 'click', 'button', function () {
    //     var t = $('#dataTable').DataTable();
    //     var tdetail = $('#dataTable_detail').DataTable();
    //     var selected_row= t.row($(this).parents('tr')).data();
    //     // console.log(selected_row);
    //     clearDT_Detail();
    //     var bln = $('#bln').val(); //bulan dropdown
    //     var thn = $('#thn').val(); //tahun dropdown
    //
    //     var kode_unit = selected_row[1];
    //     var id_bbm = selected_row[3];
    //
    //     // check if #button-detail have disabled class
    //     if ($('#button-detail').hasClass('disabled')) {
    //         console.log($('#button-detail').hasClass('disabled'));
    //         bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>Detail hanya bisa dilihat jika memilih sampai dengan --Level 4--</div>');
    //     }else{
    //         console.log("Bulan: "+bln+" Tahun: "+thn+" KodeUNIT: "+kode_unit+" ID_BBM: "+id_bbm);
    //         $.ajax({
    //             url : "<?php echo base_url('laporan/penerimaan/getDataDetail'); ?>",
    //             type: 'POST',
    //             data: {
    //                 "detail_id_bbm": id_bbm,
    //                 "detail_bulan": bln,
    //                 "detail_tahun": thn,
    //                 "detail_kode_unit": kode_unit
    //             }
    //         })
    //         .done(function(data) {
    //             var detail_parser = JSON.parse(data);
    //             var nomer = 1;
    //             console.log(detail_parser);
    //             $.each(detail_parser, function(index, el) {
    //                 console.log(el.UNIT);
    //                 var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
    //                 var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
    //                 var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
    //                 var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
    //                 var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
    //                 var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
    //                 var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
    //                 var DEVISIASI_DETAIL = el.DEVISIASI == null ? "" : el.DEVISIASI;
    //
    //                 tdetail.row.add( [
    //                     nomer, UNIT_PEMBANGKIT, NOMER_PENERIMAAN,
    //                     NAMA_PEMASOK, NAMA_TRANSPORTIR,
    //                     TGL_TERIMA_FISIK, VOL_DO,
    //                     TERIMA_REAL, DEVISIASI_DETAIL
    //                 ] ).draw( false );
    //                 nomer++;
    //             });
    //         });
    //
    //         $('#exampleModal').modal('show');
    //     }
    // } );

    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val();
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
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

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
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

        function disabledDetailButton()
        {
            $('#button-detail').removeClass('disabled');
            $('#button-detail').addClass('disabled');
        }


        $('select[name="ID_REGIONAL"]').on('change', function() {

            var stateID = $(this).val();
            console.log(stateID);
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
            disabledDetailButton();

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
            disabledDetailButton();

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
            disabledDetailButton();

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
            disabledDetailButton();

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

        $('select[name="SLOC"]').on('change',function() {
            // console.log(typeof $(this).val());
            if ($(this).val() !== '') {
                $('#button-detail').removeClass('disabled');
            }else {
                $('#button-detail').addClass('disabled');
            }

            console.log($(this).val());
            /* Act on the event */
        });
    });
</script>
