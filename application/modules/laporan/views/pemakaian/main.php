<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css"> -->
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>


<style>
#exampleModal{
  width: 100%;
  left: 0%;
  margin: 0 auto;
}
.detail-kosong{
    display: none;
}
.dataTables_filter{
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
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
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
              <div class="pull-left span3">
                  <label for="password" class="control-label">Periode <span class="required">*</span> : </label>
                  <label for="password" class="control-label" style="margin-left:38px"></label>
                  <div class="controls">
                      <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                      <label for="">s/d</label>
                      <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime tglakhir" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
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
                <!-- <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                    </div>
                </div> -->
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                        <!-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#exampleModal' name="button">TSest</button> -->
                    <?php echo anchor(null, "<i class='icon'></i> Detail", array(
                        'class'       => 'btn green detail-kosong',
                        'id'          => 'button-detail'
                        // 'data-toggle' => 'modal',
                        // 'data-target' => '#exampleModal'
                    )); ?>
                    </div>
                </div>
                <!-- Tampilan modal detail -->
                <div class="pull-left span2">

                </div>
                <div class="pull-left span2">

                </div>
                <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="well-content no-search">
            <table id="dataTable" class="display" width="100%" cellspacing="0" style="max-height:1000px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>KODE Unit</th>
                        <th>Unit</th>
                        <th>ID BBM</th>
                        <th>Jenis Bahan Bakar</th>
                        <th>Jumlah Pakai</th>
                        <th>Tgl Awal Pakai</th>
                        <th>Tgl Akhir Pakai</th>
                        <th>Total Volume Pemakaian(L)</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>
        <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog"          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="pull-right">


                  <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                      'class' => 'btn',
                      'id'    => 'button-excel-detail'
                  )); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                      'class' => 'btn',
                      'id'    => 'button-pdf-detail'
                  )); ?>
                  <!-- <?php echo form_dropdown('tampilData', array(
                    '-Tampilkan Data-'=> 'Tampilkan Data',
                    '25'              => '25 data',
                    '50'              => '50 data',
                    '100'             => '100 data',
                    '200'             => '200 data'
                  ), '', 'style="margin-left:1px;" id="tampilData_detail"') ?> -->
                  </div>
                  <table id="dataTable_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                      <thead>
                      <tr>
                          <th rowspan="2">NO</th>
                          <th colspan="4">Level</th>
                          <th rowspan="2">Unit Pembangkit</th>
                          <th rowspan="2">Jenis BBM</th>
                          <th rowspan="2">Jenis Pemakaian</th>
                          <th rowspan="2">No Pemakaian</th>
                          <th rowspan="2">Tanggal Catat</th>
                          <th rowspan="2">Tanggal Pengakuan</th>
                          <th rowspan="2" style="text-align: center;">Volume Pemakaian (L)</th>
                          <th rowspan="2">Keterangan</th>
                      </tr>
                      <tr>
                        <th>0</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                      </tr>
                      </thead>
                      <tbody></tbody>
                  </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<form id="export_excel" action="<?php echo base_url('laporan/pemakaian/export_excel'); ?>" method="post">
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
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xlvl">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/pemakaian/export_pdf'); ?>" method="post" >
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl">
    <input type="hidden" name="plvlid">
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

<form id="export_excel_detail" action="<?php echo base_url('laporan/pemakaian/export_excel_detail'); ?>" method="post">
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
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xlvl">

    <input type="hidden" name="xtglawal_detail">
    <input type="hidden" name="xtglakhir_detail">
    <input type="hidden" name="xkodeUnit_detail">
    <input type="hidden" name="xidbbm_detail">
</form>
<form id="export_pdf_detail" action="<?php echo base_url('laporan/pemakaian/export_pdf_detail'); ?>" method="post" >
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl">
    <input type="hidden" name="plvlid">
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

    <input type="hidden" name="ptglawal_detail">
    <input type="hidden" name="ptglakhir_detail">
    <input type="hidden" name="pkodeUnit_detail">
    <input type="hidden" name="pidbbm_detail">
</form>
<script type="text/javascript">

    $(document).ready(function() {
        $('#button-detail').addClass('disabled');
        // $("#button-detail").attr("disabled", true);
        $(".form_datetime").datepicker({
          format: "yyyy-mm-dd",
          autoclose: true,
          todayBtn: true,
          pickerPosition: "bottom-left"
      });
     //  function formatDateDepan(date) {
     //    var tanggal =date.getDate();
     //    var bulan = date.getMonth()+1;
     //    var tahun = date.getFullYear();
     //
     //    if(tanggal<10){
     //       tanggal='0'+tanggal;
     //      }
     //
     //    if(bulan<10){
     //       bulan='0'+bulan;
     //      }
     //
     //    return tanggal + "-" + bulan + "-" + tahun;
     //  }
     //
     // function formatDateBelakang(date) {
     //    var tanggal =date.getDate();
     //    var bulan = date.getMonth()+1;
     //    var tahun = date.getFullYear();
     //
     //    if(tanggal<10){
     //       tanggal='0'+tanggal;
     //      }
     //
     //    if(bulan<10){
     //       bulan='0'+bulan;
     //      }
     //
     //    return tahun + "" + bulan + "" + tanggal;
     //
     // }
     //  function checkDefaulthTglDari(){
     //      var date = new Date();
     //
     //      var datePengakuan = $("input[name=TGL_SAMPAI]").val();
     //      var dateBatasan =formatDateBelakang(date);
     //      var datePenerimaan = $("input[name=TGL_DARI]").val();
     //
     //      var dateStart = datePenerimaan.substring(0, 2);
     //      var monthStart = datePenerimaan.substring(3, 5);
     //      var yearStart = datePenerimaan.substring(6, 10);
     //
     //      var dateEnd = datePengakuan.substring(0, 2);
     //      var monthEnd = datePengakuan.substring(3, 5);
     //      var yearEnd = datePengakuan.substring(6, 10);
     //
     //      var vDateStart = yearStart + "" + monthStart + "" + dateStart;
     //      var vDateEnd = yearEnd + "" + monthEnd + "" + dateEnd;
     //
     //      if (vDateStart > dateBatasan) {
     //          var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Awal tidak boleh melebihi Tanggal Hari ini</div>';
     //          bootbox.alert(message, function() {});
     //          $('input[name=TGL_DARI').datepicker('update', date);
     //
     //      }
     //      else if(vDateEnd > dateBatasan){
     //          var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Akhir tidak boleh melebihi Tanggal Hari ini</div>';
     //          bootbox.alert(message, function() {});
     //          $('input[name=TGL_SAMPAI').datepicker('update', date);
     //      }
     //      else if(vDateStart > vDateEnd){
     //          if(datePenerimaan!=""&&datePengakuan!=""){
     //              var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal awal tidak boleh melebihi Tanggal akhir</div>';
     //              bootbox.alert(message, function() {});
     //              $('input[name=TGL_DARI').datepicker('update', datePengakuan);
     //          }
     //      }
     //
     //  }
     //  function setDefaulthTglDari(){
     //      var date = new Date();
     //      var tanggal = formatDateDepan(date);
     //
     //      $('input[name=TGL_DARI]').datepicker('setEndDate', tanggal);
     //  }
     //
     //   function setDefaulthTglSampai(){
     //      var date = new Date();
     //      var tanggal = formatDateDepan(date);
     //
     //      $('input[name=TGL_SAMPAI]').datepicker('setEndDate', tanggal);
     //    }
     //  $("input[name=TGL_DARI]").change(checkDefaulthTglDari);
     //  $("input[name=TGL_SAMPAI]").change(checkDefaulthTglDari);
     //  $(function() {
     //    setDefaulthTglDari();
     //    setDefaulthTglSampai();
     //  });
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
    });
    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    function convertToRupiah(angka){
        var bilangan = angka.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            isMinus = '-';
        }

        bilangan = bilangan.replace("-", "");

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
        // $('#dataTable_detail').dataTable({
        //     "scrollY": "450px",
        //     responsive : true,
        //     "scrollX": true,
        //     "scrollCollapse": false,
        //     "bPaginate": true,
        //     // "bLengthChange": false,
        //     // "pageLength" : 50,
        //     // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        //     "bFilter": false,
        //     "bInfo": false,
        //     "bAutoWidth": true,
        //     // "ordering": false,
        //     "searching": false,
        //     // "fixedColumns": {"leftColumns": 6},
        //     "language": {
        //         "decimal": ",",
        //         "thousands": ".",
        //         "emptyTable": "Tidak ada data untuk ditampilkan"
        //     },
        //     "columnDefs": [
        //          {
        //            "className": "dt-right", "targets": [4]
        //          }
        //          // {
        //          //   "orderable" : false,
        //          //   "targets" : [-1]
        //          // },
        //   ]
        // });

        $('#dataTable').dataTable({
            "scrollY": "450px",
            "searching": true,
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "lengthMenu": [10, 25, 50, 100, 200],
            "bLengthChange": true,
            "bFilter": false,
            "bInfo": true,
            "bAutoWidth": true,
            // "fixedColumns": {"leftColumns": 6},
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "info": "Total Data: _MAX_",
                "infoEmpty": "Total Data: 0",
                "lengthMenu": "Jumlah Data _MENU_"
            },
            "columnDefs": [
              {
                "orderable" : false,
                // "targets" : [0,1,3,5,7,8,9]
                "targets" : [-1]
              },
                {
                    "targets" : [1],
                    "visible" : false
                },
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
                },
                {
                    "targets" : [3],
                    "visible" : false
                },
                {
                        "className": "dt-right",
                        "targets": [5]
                },
                {
                        "className": "dt-center",
                        "targets": [0,3,4,8,2,6,7,9]
                },
                {
                        "className": "dt-left",
                        "targets": [1,2]
                },
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
        var tglAwal= $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var tglAkhir =$('#tglakhir').val().replace(/-/g, '');

        var awal_tahun = tglAwal.substring(0,4);
        var awal_bulan = tglAwal.substring(4,6);
        var awal_hari = tglAwal.substring(6,8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0,4);
        var akhir_bulan = tglAkhir.substring(4,6);
        var akhir_hari = tglAkhir.substring(6,8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        console.log("Awalparsed:"+awalParsed+" akhrparsed:"+akhirParsed);

        //check last filled vlevlid
        if (lvl0=='') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        }else if (tglAwal == '' && tglAkhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglAkhir == '' && tglAwal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        } else {
            // lvl0 : jenis2 level -> Regional,Level 1, Level 2, Level 3
            // lvl3 : isi dari VLEVELID
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
                if (vlevelid == "00") {
                    lvl0 = "Pusat";
                }
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

            if (tglAwal == '' && tglAkhir == '') {
              awalParsed = "-";
              akhirParsed = '-';
            }

            // console.log("BBM: " + bbm + ' tahun: '+thn+' bulan: '+bln +' regional: '+ lvl0+' vlevlid: ' + vlevelid);
            console.log("BBM: " + bbm + ' Tglakhir: '+akhirParsed+' Tglawal: '+awalParsed +' regional: '+ lvl0+' vlevlid: ' + vlevelid);
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    // url: "<?php echo base_url('laporan/persediaan_bbm/getData'); ?>",
                    url : "<?php echo base_url('laporan/pemakaian/getPemakaian'); ?>",
                    data: {
                        "JENIS_BBM": bbm,
                        // "BULAN":bln,
                        // "TAHUN": thn,
                        "ID_REGIONAL": lvl0,
                        "VLEVELID":vlevelid,
                        "TGLAWAL": awalParsed,
                        "TGLAKHIR": akhirParsed,
                        },
                    success:function(response) {
                        var obj = JSON.parse(response);
                        console.log(obj);
                        var t = $('#dataTable').DataTable();

                        t.clear().draw();

                        if (obj == "" || obj == null) {
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                        } else {

                         var nomer = 1;
                         $.each(obj, function (index, value) {
                            var UNIT = value.UNIT == null ? "" : value.UNIT;
                            var KODE_UNIT = value.KODE == null ? "" : value.KODE;
                            var ID_BBM = value.ID_BBM == null ? "" : value.ID_BBM;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var JUMLAH_PAKAI = value.JMLH_PAKAI == null ? "" : value.JMLH_PAKAI;
                            var TGL_AWAL_PAKAI = value.TGL_AWAL_PAKAI == null ? "" : value.TGL_AWAL_PAKAI;
                            var TGL_AKHIR_PAKAI = value.TGL_AKHIR_PAKAI == null ? "" : value.TGL_AKHIR_PAKAI;
                            var VOLUME_PEMAKAIAN = value.VOLUME_PEMAKAIAN == null ? "" : value.VOLUME_PEMAKAIAN;

                            var DEVISIASI = value.DEVISIASI == null ? "" : value.DEVISIASI;


                            t.row.add( [
                                nomer, KODE_UNIT,
                                UNIT, ID_BBM,
                                NAMA_JNS_BHN_BKR, JUMLAH_PAKAI,
                                TGL_AWAL_PAKAI, TGL_AKHIR_PAKAI,
                                convertToRupiah(VOLUME_PEMAKAIAN)
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
        var table = $('#dataTable').DataTable();
        table.search( this.value ).draw();
    } );

    $('#tampilData').on('change', function () {
      oTable = $('#dataTable').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = this.value;
      oTable.fnDraw();
    });

    $('#tampilData_detail').on('change', function () {
      oTable = $('#dataTable_detail').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = this.value;
      oTable.fnDraw();
    });

    function clearDT_Detail()
    {
        var t = $('#dataTable_detail').DataTable();
        t.clear().draw();
    }

    function tampilData_default()
    {
      $('#tampilData').val('-Tampilkan Data-');
      $('#tampilData_detail').val('-Tampilkan Data-');
    }
    //when datatable detailButton clicked
    $('#dataTable tbody').on( 'click', 'button', function () {
      tampilData_default();
        clearDT_Detail();
        var t = $('#dataTable').DataTable();

        var selected_row= t.row($(this).parents('tr')).data();
        console.log(selected_row);
        // var bln = $('#bln').val(); //bulan dropdown
        // var thn = $('#thn').val(); //tahun dropdown

        var kode_unit = selected_row[1];
        var id_bbm = selected_row[3];
        var jumlah_terima = selected_row[5];
        var tglAwal= selected_row[6].replace(/-/g, '');//02-11-2018
        var tglAwal_tahun = tglAwal.substring(0,4);
        var tglAwal_bulan = tglAwal.substring(4,6);
        var tglAwal_hari = tglAwal.substring(6,8);
        var parsed_tglawal = tglAwal_hari.concat(tglAwal_bulan, tglAwal_tahun);

        var tglAkhir =selected_row[7].replace(/-/g, '');
        var tglAkhir_tahun = tglAkhir.substring(0,4);
        var tglAkhir_bulan = tglAkhir.substring(4,6);
        var tglAkhir_hari = tglAkhir.substring(6,8);
        var parsed_tglakhir = tglAkhir_hari.concat(tglAkhir_bulan, tglAkhir_tahun);

        var tdetail = $('#dataTable_detail').DataTable({
          destroy : true,
          "bLengthChange": true,
          "lengthMenu": [10, 25, 50, 100, 200],
          fixedHeader: {
            header: true,
            footer: true
          },
          "scrollY": "450px",
          "scrollX": true,
          "bPaginate": true,
          "bFilter": false,
          "bInfo": true,
          "bAutoWidth": true,
          // "ordering": false,
          // fixedHeader: true,
          "language": {
              "decimal": ",",
              "thousands": ".",
              "emptyTable": "Tidak ada data untuk ditampilkan",
              "info": "Total Data: "+jumlah_terima,
              "infoEmpty": "Total Data: 0",
              "lengthMenu": "Jumlah Data _MENU_"
          },
          "columnDefs":[
            {
              "className" : "dt-right",
              "targets" : [-1, -2]
            },
            {
              "className" : "dt-center",
              "targets" : [0,5,6,9,10]
            },
            {
              "className" : "dt-left",
              "targets" : [1,2,3,4]
            }
          ]
        });


        //Untuk Trigger button excel detail
        $('input[name="xkodeUnit_detail"]').val(kode_unit);
        $('input[name="xtglawal_detail"]').val(parsed_tglawal);
        $('input[name="xtglakhir_detail"]').val(parsed_tglakhir);
        $('input[name="xidbbm_detail"]').val(id_bbm);

        //Untuk Trigger button pdf detail
        $('input[name="pkodeUnit_detail"]').val(kode_unit);
        $('input[name="ptglawal_detail"]').val(parsed_tglawal);
        $('input[name="ptglakhir_detail"]').val(parsed_tglakhir);
        $('input[name="pidbbm_detail"]').val(id_bbm);

        console.log(" KodeUNIT: "+kode_unit+" ID_BBM: "+id_bbm+" TglAwal:"+parsed_tglawal+" TglAkhir: "+parsed_tglakhir);
        $.ajax({
            url : "<?php echo base_url('laporan/pemakaian/getPemakaianDetail'); ?>",
            type: 'POST',
            data: {
                "detail_id_bbm": id_bbm,
                // "detail_bulan": bln,
                // "detail_tahun": thn,
                "detail_tgl_awal": parsed_tglawal,
                "detail_tgl_akhir":parsed_tglakhir,
                "detail_kode_unit": kode_unit
            }
        })
        .done(function(data) {
            var detail_parser = JSON.parse(data);
            var nomer = 1;
            console.log(detail_parser);
            $.each(detail_parser, function(index, el) {
                var LEVEL0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                var LEVEL1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                var LEVEL2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                var LEVEL3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                var NAMA_JNS_BHN_BKR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
                var JENIS_PEMAKAIAN = el.JENIS_PEMAKAIAN == null ? "" : el.JENIS_PEMAKAIAN;
                var NO_PEMAKAIAN = el.NO_PEMAKAIAN == null ? "" : el.NO_PEMAKAIAN;
                var TGL_CATAT = el.TGL_CATAT == null ? "" : el.TGL_CATAT;

                var TGL_PENGAKUAN_PAKAI = el.TGL_PENGAKUAN_PAKAI == null ? "" : el.TGL_PENGAKUAN_PAKAI;
                var VOL_PEMAKAIAN = el.VOLUME_PEMAKAIAN == null ? "" : el.VOLUME_PEMAKAIAN;
                var KETERANGAN = el.KETERANGAN == null ? "" : el.KETERANGAN;

                tdetail.row.add( [
                    nomer, LEVEL0, LEVEL1, LEVEL2, LEVEL3,
                    UNIT_PEMBANGKIT, NAMA_JNS_BHN_BKR, JENIS_PEMAKAIAN, NO_PEMAKAIAN,
                    TGL_CATAT,TGL_PENGAKUAN_PAKAI, convertToRupiah(VOL_PEMAKAIAN), KETERANGAN
                ] ).draw( false );
                nomer++;
            });
        });

        $('#exampleModal').modal('show');

        // check if #button-detail have disabled class
        // if ($('#button-detail').hasClass('disabled')) {
        //     console.log($('#button-detail').hasClass('disabled'));
        //     bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>Detail hanya bisa dilihat jika memilih sampai dengan --Level 4--</div>');
        // }else{
        //
        // }
    } );

    $('#button-excel').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown
      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
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
          $('input[name="xlvl0"]').val($('#lvl0').val()); // 01
          $('input[name="xlvl1"]').val($('#lvl1').val()); //COCODE
          $('input[name="xlvl2"]').val($('#lvl2').val());
          $('input[name="xlvl3"]').val($('#lvl3').val());

          $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
          $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

          $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
          $('input[name="xbbm"]').val(bbm); // 001
          $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
          $('input[name="xthn"]').val($('#thn').val()); // 2017
          $('input[name="xthn"]').val($('#thn').val());
          var tglAwal = $('#tglawal').val().replace(/-/g, '');
          var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
          var awal_tahun = tglAwal.substring(0,4);
          var awal_bulan = tglAwal.substring(4,6);
          var awal_hari = tglAwal.substring(6,8);
          var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

          var akhir_tahun = tglAkhir.substring(0,4);
          var akhir_bulan = tglAkhir.substring(4,6);
          var akhir_hari = tglAkhir.substring(6,8);
          var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

          if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="xtglawal"]').val(awalParsed);
            $('input[name="xtglakhir"]').val(akhirParsed);
          }else{
            $('input[name="xtglawal"]').val(awalParsed);
            $('input[name="xtglakhir"]').val(akhirParsed);
          }
          $('input[name="xlvlid"]').val(vlevelid);
          $('input[name="xlvl"]').val(lvl0);
          console.log(vlevelid);
            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
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
            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());

            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="pbbm"]').val(bbm);
            $('input[name="plvl"]').val(lvl0);

            var tglAwal = $('#tglawal').val().replace(/-/g, '');
            var tglAkhir = $('#tglakhir').val().replace(/-/g, '');

            var awal_tahun = tglAwal.substring(0,4);
            var awal_bulan = tglAwal.substring(4,6);
            var awal_hari = tglAwal.substring(6,8);
            var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

            var akhir_tahun = tglAkhir.substring(0,4);
            var akhir_bulan = tglAkhir.substring(4,6);
            var akhir_hari = tglAkhir.substring(6,8);
            var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);
            if (tglAwal == '' && tglAkhir == '') {
              awalParsed = "-";
              akhirParsed = '-';
              $('input[name="ptglawal"]').val(awalParsed);
              $('input[name="ptglakhir"]').val(akhirParsed);
            }else{
              $('input[name="ptglawal"]').val(awalParsed);
              $('input[name="ptglakhir"]').val(akhirParsed);
            }
            console.log("PDF: tglawal "+awalParsed+ "tglakhir: "+akhirParsed+"vlevelid: "+vlevelid+"bbm: "+bbm);
            // $('input[name="pbln"]').val($('#bln').val());
            // $('input[name="pthn"]').val($('#thn').val());

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
    });

    // DETAIL EXCEL AND PDF
    $('#button-excel-detail').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown
      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown

      if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
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
          $('input[name="xlvl0"]').val($('#lvl0').val()); // 01
          $('input[name="xlvl1"]').val($('#lvl1').val()); //COCODE
          $('input[name="xlvl2"]').val($('#lvl2').val());
          $('input[name="xlvl3"]').val($('#lvl3').val());

          $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
          $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

          $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
          $('input[name="xbbm"]').val(bbm); // 001
          $('input[name="xlvl"]').val(lvl0); // 001
          console.log(vlevelid);
            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel_detail').submit();
                }
            });
        }
    });
    $('#button-pdf-detail').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
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
            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());

            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="pbbm"]').val(bbm);
            $('input[name="plvl"]').val(lvl0);

            var tglAwal = $('#tglawal').val().replace(/-/g, '');
            var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
            if (tglAwal == '' && tglAkhir == '') {
              tglAwal = "-";
              tglAkhir = '-';
              $('input[name="ptglawal"]').val(tglAwal);
              $('input[name="ptglakhir"]').val(tglAkhir);
            }else{
              $('input[name="ptglawal"]').val(tglAwal);
              $('input[name="ptglakhir"]').val(tglAkhir);
            }
            console.log("PDF: tglawal "+tglAwal+ "tglakhir: "+tglAkhir+"vlevelid: "+vlevelid+"bbm: "+bbm);
            // $('input[name="pbln"]').val($('#bln').val());
            // $('input[name="pthn"]').val($('#thn').val());

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf_detail').submit();
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
            clearDT_Detail();
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
