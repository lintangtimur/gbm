
<!-- /**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
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
					<div class="well">
                        <!-- <div class="pull-left"> -->
                          <!-- /.row -->
						  <div class="row">
                                <div class="col-md-12">
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
												<?php $now = strtotime(date("Y-m-d")); $bulan = date("m",$now); ?>
												<?php echo form_dropdown('BULAN', $opsi_bulan, $bulan,'style="width: 137px;", id="bln"'); ?>
												<?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
											</div>
										</div>
									</div>
									<div class="form_row">
										<div class="pull-left span5">
										<br>
											<div class="controls">
												<?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter', 'onclick'=> 'loadDataIdo();loadDataBio();loadDataHsd();loadDataMfo();loadDataHsdBio();')); ?></td>
											</div>
										</div>
									</div>
								</div>
						  </div>
					</div>
                    <div class="well">
                        <!-- <div class="pull-left"> -->
                          <!-- /.row -->
                            <div class="row">
                                <div class="col-md-2 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-tachometer fa-3x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divHsd">

                                                    </div>
                                                    <div><h4>HSD</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a onclick="loadTableHsd();showTable();" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#337ab7">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading" style="background-color:#ffc107">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-tasks fa-3x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divMfo">

                                                    </div>
                                                    <div><h4>MFO</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                         <a onclick="loadTableMfo();showTable();" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#ffc107">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" style="background-color:#28a745">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-sun-o fa-3x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divBio">

                                                    </div>
                                                    <div><h4>BIO</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                         <a onclick="loadTableBio();showTable();" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#28a745">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="panel panel-success">
                                        <div class="panel-heading" style="background-color:#dc3545">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-link fa-3x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divHsdBio">
													</div>
                                                    <div><h4>HSD+BIO</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                       <a onclick="loadTableHsdBio();showTable();" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#dc3545">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
								 <div class="col-lg-2 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style="background-color:#04B4AE">
                                            <div class="row" style="color:#fff">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-tint fa-3x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge" style="font-size:12px" id="divIdo">

                                                   </div>
                                                    <div><h4>IDO</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                          <a onclick="loadTableIdo();showTable();" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#04B4AE">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        <!-- </div>  --><!-- end pull left -->
                    </div>
                    
                     <div class="well-content clearfix" id="divTable">
					  <table id="dataTable" class="table table-bordered table-striped">
						<thead>
						<tr>
						<td>No</td>
						<td>Pembangkit</td>
						<td>Jenis Bahan Bakar</td>
						<td>Tanggal Stok Terakhir</td>
						<td>Dead Stok</td>
						<td>Volume Stok Akhir Real</td>
						<td>Volume Stok Akhir Efektir</td>
						<td>SHO</td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td colspan="19" align="center">Data Tidak Ditemukan</td>
						</tr>
						</tbody>
					   </table>
                            <?php
                            /* Mengambil query report
                            foreach($report as $result){
                                $tahun[] = $result->tahun; //ambil bulan
                                $avgHargaKurs[] = (float) $result->avgHargaKurs; //ambil nilai
                                $avgHargaHsd[] = (float) $result->avgHargaHsd; //ambil nilai
                                $avgHargaMfo[] = (float) $result->avgHargaMfo; //ambil nilai
                                $avgHargaMops[] = (float) $result->avgHargaMops; //ambil nilai
                            }
                             end mengambil query*/
                        ?>
					<!-- start row -->
					<!-- <div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h6>HSD</h6>
										</div>
										<div class="panel-body">
										<div id="containerHsd"></div>
										</div>
								</div>
							</div>
							<div class="col-md-12">
								 <div class="panel panel-primary">
									<div class="panel-heading">
										<h6>MFO</h6>
									</div>
									   <div class="panel-body">
									   <div id="containerMfo"></div>
										</div>
									</div>
							   </div>
							</div> -->
					<!-- end row -->
					<!-- start row -->
					<!-- <div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h6>KURS</h6>
									</div>
										 <div class="panel-body">
											 <div id="containerKurs" ></div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h6>MOPS</h6>
										 </div>
										<div class="panel-body">
											<div id="containerMops" ></div>
										</div>
									</div>
							</div>
					</div> -->
					<!-- end row -->
							<!-- <div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h6>All</h6>
									</div>
									<div class="panel-body">
										<div id="containerAll" ></div>
									</div>
								</div>
							</div> -->
				   <!-- end row -->
                    </div>
                 </div> 
                 <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter">
				 </div>
                 <div>&nbsp;</div>
            </div>
            <div id="form-content" class="modal fade modal-xlarge">
           
            </div>
        </div>
    </div>
    
</div>

<!-- <script type="text/javascript">
     jQuery(function($) {
     $('#containerHsd').highcharts({
        title: {
            text: 'Trend rata-rata Bulanan'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Secondary yAxis
            gridLineWidth: 1,
            title: {
                text: 'HSD',
                style: {
                    color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                }
            },
            min: 5100,
            max: 5400,
            visible:true,
            showEmpty: false,
            labels: {
                format: 'Rp {value}',
                //format:<?php /*echo json_encode($avgHargaHsd);?>,
                style: {
                    color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                }
            },
            showEmpty: false,
            opposite: false

        }],
        plotOptions: {
               line: {
                  dataLabels: {
                     enabled: true
                  },   
                  enableMouseTracking: false
               }
            },
        series: [{
            name: 'Harga HSD',
            data: <?php echo json_encode($avgHargaHsd);?>
        }]
        
    });
	
	 $('#containerMfo').highcharts({
        title: {
            text: 'Trend rata-rata Bulanan'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Secondary yAxis
            gridLineWidth: 1,
            title: {
                text: 'MFO',
                style: {
                    color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                }
            },
            visible:true,
            showEmpty: false,
            labels: {
                format: 'Rp {value}',
                style: {
                    color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                }
            },
            min: 3900,
            max: 4000,
            showEmpty: false,
            opposite: false

        }],
       plotOptions: {
               line: {
                  dataLabels: {
                     enabled: true
                  },   
                  enableMouseTracking: false
               }
            },
        series: [ {
            name: 'Harga MFO',
            data: <?php echo json_encode($avgHargaMfo);?>

        }]
    });
	
	 $('#containerKurs').highcharts({
        title: {
            text: 'Trend rata-rata Bulanan'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            gridLineWidth: 1,
            title: {
              text: 'KURS',
               
                style: {
                   color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                }
            },
            min: 12000,
            max: 14000,
            visible:true,
            labels: {
                 format: 'Rp {value}',
                style: {
                    color: Highcharts.getOptions().colors[1],
                    fontSize: '8px'
                },
            },

            itemHiddenStyle: {
                color: 'white'
            },
            showEmpty: false,
            opposite: false

        }],
        plotOptions: {
               line: {
                  dataLabels: {
                     enabled: true
                  },   
                  enableMouseTracking: false
               }
            },
        series: [{
            name: 'KURS',
            data: <?php echo json_encode($avgHargaKurs);?>

        }]
    });
	 $('#containerMops').highcharts({
			title: {
				text: 'Trend rata-rata Bulanan'
			},
			xAxis: [{
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				crosshair: true
			}],
			yAxis: [
			 { // Tertiary yAxis
				gridLineWidth: 1,
				title: {
					text: 'MOPS',
					style: {
						color: Highcharts.getOptions().colors[1],
						fontSize: '8px'
					}
				},
				visible:true,
				labels: {
					format: '{value} USD/Brl',
					style: {
						color: Highcharts.getOptions().colors[1],
						fontSize: '8px'
					}
				},
				showEmpty: false,
				opposite: false
			}],
			plotOptions: {
				   line: {
					  dataLabels: {
						 enabled: true
					  },   
					  enableMouseTracking: false
				   }
				},
			series: [{
				name: 'MOPS',
				data: <?php echo json_encode($avgHargaMops);?>,
				tooltip: {
					valueSuffix: ' USD/Brl'
				}
			}]
		});
		
		$('#containerAll').highcharts({
        title: {
            text: 'Trend rata-rata Bulanan'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
		yAxis: {
			title: {
				text: 'All'
			}
		},
         
         plotOptions: {
               line: {
                  dataLabels: {
                     enabled: true
                  },   
                  enableMouseTracking: false
               }
            },
        series: [{
            name: 'Harga HSD',
           
          
            data: <?php echo json_encode($avgHargaHsd);?>
            
        }, {
            name: 'Harga MFO',
           
           
            data: <?php echo json_encode($avgHargaMfo);?>
            

        }, {
            name: 'KURS',
            
            data: <?php echo json_encode($avgHargaKurs);?>
          
            
         

        }, {
            name: 'MOPS',
           
            data: <?php echo json_encode($avgHargaMops);*/?>
           
        }],

    });


    });
</script> -->

<script>
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv4/'+stateID;
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

	function convertToRupiah(angka){
            var rupiah = '';        
            var angkarev = angka.toString().split('').reverse().join('');
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rupiah.split('',rupiah.length-1).reverse().join('');
    }
		

	function loadDataBio(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/grafik/getDataBio'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            $('#divBio').text("0 (L)");
							bootbox.hideAll();
							} else {
                        
                         $('#divBio').text("");
                       
                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;
							
                            $('#divBio').text(convertToRupiah(STOK)+' (L)');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
	}
	
	function loadDataHsd(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
            
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/grafik/getDataHsd'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            $('#divHsd').text("0 (L)");
							bootbox.hideAll();
							} else {
                        
                         $('#divHsd').text("");
                       
                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;
							
                            $('#divHsd').text(convertToRupiah(STOK)+' (L)');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
	}
	
	function loadDataMfo(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
            
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/grafik/getDataMfo'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            $('#divMfo').text("0 (L)");
							bootbox.hideAll();
							} else {
                        
                         $('#divMfo').text("");
                       
                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;
							
                            $('#divMfo').text(convertToRupiah(STOK)+' (L)');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
	}
	
	function loadDataHsdBio(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
           
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/grafik/getDataHsdBio'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            $('#divHsdBio').text("0 (L)");
							bootbox.hideAll();
                             } else {
                        
                         $('#divHsdBio').text("");
                       
                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;
							
                            $('#divHsdBio').text(convertToRupiah(STOK)+' (L)');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
	}
	
	function loadDataIdo(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        if (lvl0 == '') {
            
        } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/grafik/getDataIdo'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            $('#divIdo').text("0 (L)");
                              bootbox.hideAll();
                             } else {
                        
                         $('#divIdo').text("");
                       
                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;
							
                            $('#divIdo').text(convertToRupiah(STOK)+' (L)');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        };
	}

  $(function() {
   loadDataIdo();
   loadDataMfo();
   loadDataHsd();
   loadDataHsdBio();
   loadDataBio();
   
   document.getElementById("divTable").style.visibility = "hidden";
  });
  
	function showTable(){
		 document.getElementById("divTable").style.visibility = "visible";
	}

	function loadTableHsdBio(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			if (lvl0 == '') {
				bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			} else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableHsdBio'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#divIdo').text("0");
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                           
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			};
		}

		function loadTableHsd(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			if (lvl0 == '') {
				bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			} else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableHsd'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#divIdo').text("0");
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                           
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			};
		}

		function loadTableBio(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			if (lvl0 == '') {
				bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			} else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableBio'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#divIdo').text("0");
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                           
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			};
		}

		function loadTableMfo(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			if (lvl0 == '') {
				bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			} else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableMfo'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#divIdo').text("0");
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                           
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			};
		}
		
		function loadTableIdo(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			if (lvl0 == '') {
				bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			} else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableIdo'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#divIdo').text("0");
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                         var nomer = 1;
                         $.each(obj, function (index, value) {
                           
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO = SHO.toString().replace(/\./g, ',');  
                            

                            var strRow =
                                    '<tr>' +
                                    '<td>' + nomer + '</td>' +
                                    '<td>' + LEVEL4 + '</td>' +
                                    '<td>' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td>' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    '<td align="right">' + SHO + '</td>' +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			};
		}


</script>
