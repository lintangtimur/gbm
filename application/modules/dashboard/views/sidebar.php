<script type="text/javascript">
    $(function() {
        $('#box-title-ulang-tahun').click(function(){
            var status = $(this).attr('status');
            var new_status = '';
            var icon = '';
            if (status === 'open') {
                icon = '<i class="icon-plus"></i>';
                new_status = 'close';
            } else {
                icon = '<i class="icon-minus"></i>';
                new_status = 'open';
            }
            $('#keterangan-icon-ultah').html(icon);
            $(this).attr('status', new_status);
            $('#box-list-pegawai-yang-ulangtahun').slideToggle(); 
        });
    });
    
    $(function() {
        $('#box-title-ulang-tahun2').click(function(){
            var status = $(this).attr('status');
            var new_status = '';
            var icon = '';
            if (status === 'open') {
                icon = '<i class="icon-plus"></i>';
                new_status = 'close';
            } else {
                icon = '<i class="icon-minus"></i>';
                new_status = 'open';
            }
            $('#keterangan-icon-ultah2').html(icon);
            $(this).attr('status', new_status);
            $('#box-list-pegawai-yang-ulangtahun2').slideToggle(); 
        });
    });
    
</script>
        
<div id='sidebar'> <!-- Sidebar start -->
        <div class='inner_sidebar'>
            <div class='tabs_container'>
                <div class='widget_content'>
                    <h5><i class='icon-reorder'></i> Info Terbaru</h5>
                    <div class='sidebar_widget'>
                        
                        <div class="alert">
                                 <div><h5 style="text-decoration: underline;margin-bottom: 5px;font-weight: bold;" >Motivation Quote</h5></div>
                                 <div style="text-align: justify;">
                                     <?php echo isset($motivasi)?$motivasi:"Semangat!!"; ?>
                                 </div>
                        </div>
                       
<!--                        <div id="suggest_elibrary" data-source='<?php // echo $suggest_elibrary;?>'></div>-->
<!--                        <br>
                        
                       <div id="info_content" data-source='<?php // echo $sources_info;?>'></div>-->
                       
                       
                       
                        
                    </div>
                
                
                 
                    <div class="sidebar_widget">
                        <div class="alert alert-info" id="box-ultah" style="padding-right: 10px !important;">
                            <div id="box-title-ulang-tahun" >
                                
                                
                                <div id="suggest_elibrary2" data-source='<?php echo $suggest_elibrary2;?>'></div>
                                
                            
                            </div>
                            <div id="box-list-pegawai-yang-ulangtahun" style="display: none;padding-top: 5px;margin-top: 5px; border-top: 1px dashed #3a87ad;overflow-y: scroll;max-height: 300px;">
                                    
                                <div id="suggest_elibrary3" data-source='<?php echo $suggest_elibrary3;?>'></div>
                            
                            </div>

                        </div>

                    </div>
               
                
                
                    <div class="sidebar_widget">
                        <div class="alert alert-info" id="box-ultah" style="padding-right: 10px !important;">
                            <div id="box-title-ulang-tahun2" >
                                
                                
                                <div id="suggest_takso1" data-source='<?php echo $suggest_takso1;?>'></div>
                                
                            
                            </div>
                            <div id="box-list-pegawai-yang-ulangtahun2" style="display: none;padding-top: 5px;margin-top: 5px; border-top: 1px dashed #3a87ad;overflow-y: scroll;max-height: 300px;">
                                    
                                <div id="suggest_takso2" data-source='<?php  echo $suggest_takso2;?>'></div>
                            
                            </div>

                        </div>

                    </div>
          </div>
                
                
                <div class='widget_content'>
                    <h5><i class='icon-reorder'></i> Statistik</h5>
                    <div class='sidebar_widget'>
                        <!--<div class='sidebar_buttons align_right'>
                            <a href='#' class='button red'>Update</a>
                            <a href='#' class='button blue'>Settings</a>
                        </div>-->
                        <div class='sidebar_chart' id='sidebarchart1' style='height: 220px;' data-source="<?php echo $data_sources2; ?>"></div>
                        
                         
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
    jQuery(function($) {
		GraphRender('sidebarchart1');
		
        $('#info_content').html("<div><div>").addClass('loading-progress');;
        $('#info_content').load($("#info_content").attr('data-source'),1);
        $('#info_content').removeClass('loading-progress').html("<div><div>");
        
        $('#suggest_elibrary').html("<div><div>").addClass('loading-progress');;
        $('#suggest_elibrary').load($("#suggest_elibrary").attr('data-source'),1);
        $('#suggest_elibrary').removeClass('loading-progress').html("<div><div>"); 
        
        $('#suggest_elibrary2').html("<div><div>").addClass('loading-progress');;
        $('#suggest_elibrary2').load($("#suggest_elibrary2").attr('data-source'),1);
        $('#suggest_elibrary2').removeClass('loading-progress').html("<div><div>"); 
        
        $('#suggest_elibrary3').html("<div><div>").addClass('loading-progress');;
        $('#suggest_elibrary3').load($("#suggest_elibrary3").attr('data-source'),1);
        $('#suggest_elibrary3').removeClass('loading-progress').html("<div><div>");
        
        $('#suggest_takso1').html("<div><div>").addClass('loading-progress');;
        $('#suggest_takso1').load($("#suggest_takso1").attr('data-source'),1);
        $('#suggest_takso1').removeClass('loading-progress').html("<div><div>");
        
        $('#suggest_takso2').html("<div><div>").addClass('loading-progress');;
        $('#suggest_takso2').load($("#suggest_takso2").attr('data-source'),1);
        $('#suggest_takso2').removeClass('loading-progress').html("<div><div>");
        
        
    });
</script>

 