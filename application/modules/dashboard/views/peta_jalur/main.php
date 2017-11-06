
<!-- /**
	* @module PETA JALUR
	* @author  ADITYA NOMAN
*/ -->
<link rel="stylesheet" type="text/css" href="http://10.14.152.223/leaflet.css">
<script type="text/javascript" src="http://10.14.152.223/leaflet.js"></script>
<style>
   #map{
	   width:100%;
	   height:100%;
	   position:absolute;
   }
</style>
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
		</div>
	</div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div class="well-content no-search">
					
                    <div class="well" style="height:450px;">
                        <!-- <div class="pull-left"> -->
						<div id="map">
							</div>
                        <!-- </div>  --><!-- end pull left -->
					</div>
				</div> 
				<div>&nbsp;</div>
			</div>
		</div>
	</div>
    
</div>

<script type="text/javascript">

	var pltd1 = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd1.png',
	    // shadowUrl: 'leaf-shadow.png',

	    iconSize:     [28, 35], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [12, 34], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -36] // point from which the popup should open relative to the iconAnchor
	});

	var pltd2 = L.icon({
	    iconUrl: '<?php echo base_url()?>assets/img/pltd2.png',
	    // shadowUrl: 'leaf-shadow.png',

	    iconSize:     [28, 35], // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [12, 34], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -36] // point from which the popup should open relative to the iconAnchor
	});

    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
	var map = L.map('map').setView( [-1.9205768,118.5820232],5  );
	L.tileLayer('http://10.14.152.223/osm_tiles/{z}/{x}/{y}.png',{maxZoom:27}).addTo(map);
	
	/*
		Loooping disini untuk draw Polyline dan Juga Membuat Marker Pembangkit dan Depo
	*/
	
	var vlink_url = '<?php echo base_url()?>dashboard/peta_jalur/get_peta/';
	$.ajax({
	    url: vlink_url,
	    type: "GET",
	    dataType: "json",
	    success:function(data) {
	    	bootbox.hideAll();
	        $.each(data, function(key, value) {

	           var toUnion = [[value.LAT_DEPO, value.LOT_DEPO],[value.LAT_LVL4, value.LOT_LVL4]];
	           L.polyline(toUnion,{color:'red',opacity:1}).addTo(map);

	           L.marker([value.LAT_DEPO, value.LOT_DEPO], {icon: pltd1}).addTo(map).bindPopup('<strong>DEPO</strong><br>'+value.NAMA_DEPO)
	        .openPopup();

	           L.marker([value.LAT_LVL4, value.LOT_LVL4], {icon: pltd2}).addTo(map).bindPopup('<strong>PEMASOK</strong><br>'+value.LEVEL4)
	        .openPopup();


	        });
	    }
	});

	// var toUnion = [[-6.205154, 106.816460],[-6.153930, 106.967688]];
	// var toAncuk = [[-6.317125, 107.150304],[-7.076543, 107.185403]];
	
	// L.polyline(toUnion,{color:'red',opacity:1}).addTo(map);
	// L.polyline(toAncuk,{color:'red',opacity:1}).addTo(map);
	
	/*
		End Looping Draw Polyline
	*/
	
</script>