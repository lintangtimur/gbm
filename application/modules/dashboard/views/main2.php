
        <div class="inner_content">
            <div class="statistic clearfix">
                <div class="current_page float_left">
                   <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
                </div>
            </div>
             
            <div class="widgets_area">
                      <div class="row-fluid">
                        <div class="span12">
                           <div class="well-content ">
                             <div style="margin-bottom: 10px;">
                                 <div><h4>Selamat Datang, <?php echo $this->session->userdata('user_name') . '.'; ?></h4></div>
                             </div>
							
                           </div>
                         </div>  
                     </div>
            </div>
        </div>
  <script type="text/javascript">
    
    jQuery(function($) {
        $('#notif_ate').html("Loading...");
        $('#notif_ate').load($("#notif_ate").attr('data-source'),1);
        
        $('#notif_taks').html("Loading...");
        $('#notif_taks').load($("#notif_taks").attr('data-source'),1);
        
        $('#notif_k_internal').html("Loading...");
        $('#notif_k_internal').load($("#notif_k_internal").attr('data-source'),1);
        
        $('#notif_elibrary').html("Loading...");
        $('#notif_elibrary').load($("#notif_elibrary").attr('data-source'),1);
      
     // $('#searchresult').load($("#searchresult").attr('data-source'),{ keywords: $('#keywords').val() });
		
		 $( document ).on( "click",'#btnsearch', function() {
            $('#searchresult').load($("#searchresult").attr('data-source'),{ keywords: $('#keywords').val() });
            
            return false;
        });
//        
       $( document ).on( "click", ".pagination ul li a", function() {
          	var link = $(this).attr('href');
           
            $('#searchresult').load(link,{ keywords: $('#keywords').val() });
            return false; 
        }); 
        // data_chart('','');
    });
	function data_chart(categorie, series){
		$('#chart').highcharts({
			chart: {
				type: 'columnrange',
				inverted: true
			},
			title: {
				text: 'Temperature variation by month'
			},
			subtitle: {
				text: 'Observed in Vik i Sogn, Norway'
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Temperature ( °C )'
				}
			},
			tooltip: {
				valueSuffix: '°C'
			},
			plotOptions: {
				columnrange: {
					dataLabels: {
						enabled: true,
						formatter: function () {
							return this.y + '°C';
						}
					}
				}
			},
			legend: {
				enabled: false
			},

			series: [{
				name: 'Temperatures',
				data: [
					[-9.7, 9.4],
					[-8.7, 6.5],
					[-3.5, 9.4],
					[-1.4, 19.9],
					[0.0, 22.6],
					[2.9, 29.5],
					[9.2, 30.7],
					[7.3, 26.5],
					[4.4, 18.0],
					[-3.1, 11.4],
					[-5.2, 10.4],
					[-13.5, 9.8]
				]
			}]

		});
	}
</script>
    