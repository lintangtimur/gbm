
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
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-link fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">26</div>
                                                    <div><h1>HSD</h1></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">View Details</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-tasks fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">12</div>
                                                    <div><h1>MFO</h1></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">View Details</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-sun-o fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">124</div>
                                                    <div><h1>BIO</h1></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">View Details</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-tachometer fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">13</div>
                                                    <div><h2>HSD+BIO</h2></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">View Details</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        <!-- </div>  --><!-- end pull left -->
                    </div>
                    
                     <div class="well-content clearfix">
                            <?php
                            /* Mengambil query report*/
                            foreach($report as $result){
                                $tahun[] = $result->tahun; //ambil bulan
                                $avgHargaKurs[] = (float) $result->avgHargaKurs; //ambil nilai
                                $avgHargaHsd[] = (float) $result->avgHargaHsd; //ambil nilai
                                $avgHargaMfo[] = (float) $result->avgHargaMfo; //ambil nilai
                                $avgHargaMops[] = (float) $result->avgHargaMops; //ambil nilai
                            }
                            /* end mengambil query*/
                        ?>
                <!-- start row -->
                <div class="row">
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h6>HSD</h6>
									</div>
									<div class="panel-body">
									<div id="containerHsd"></div>
									</div>
							</div>
						</div>
						<div class="col-md-6">
							 <div class="panel panel-primary">
								<div class="panel-heading">
									<h6>MFO</h6>
								</div>
								   <div class="panel-body">
								   <div id="containerMfo"></div>
									</div>
								</div>
						</div>
                </div>
                <!-- end row -->
                <!-- start row -->
                <div class="row">
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h6>KURS</h6>
								</div>
									 <div class="panel-body">
										 <div id="containerKurs" ></div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h6>MOPS</h6>
									 </div>
									<div class="panel-body">
										<div id="containerMops" ></div>
									</div>
								</div>
						</div>
                </div>
                <!-- end row -->
						<div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
            						<h6>All</h6>
                                </div>
                                <div class="panel-body">
                                    <div id="containerAll" ></div>
                                </div>
                            </div>
                        </div>
               
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

<script type="text/javascript">
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
                //format:<?php echo json_encode($avgHargaHsd);?>,
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
           
            data: <?php echo json_encode($avgHargaMops);?>
           
        }],

    });


    });
</script>