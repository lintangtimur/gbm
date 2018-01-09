<!DOCTYPE html>
<html lang="en">
    <head>
	
        <meta charset="utf-8">
        <title><?php echo $app_parameter['nama_aplikasi'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php
        echo $css_header;
        echo $js_header;
        ?>

        <script type="text/javascript">
            var $ = jQuery;
        </script>
    </head>

    <body>
        <header class="blue"> <!-- Header start -->
            <a href="#" class="logo_image"><span class="hidden-480"></span></a>
            <ul class="header_actions pull-left hidden-480 hidden-768">
                <li rel="tooltip" data-placement="bottom" title="Hide/Show main navigation" ><a href="#" class="hide_navigation"><i class="icon-chevron-left"></i></a></li>
            </ul>
            <ul class="header_actions pull-left hidden-768">
                <li><a class="app_name"></a></li>
            </ul>
            <ul class="header_actions">
                <!-- <li rel="tooltip" data-placement="bottom" title="Notifikasi" class="messages"> -->
                <li id="nf_notif" style="display: none;" data-placement="bottom" title="Klik untuk detail notifikasi" class="messages">    
                    <a class="iconic" href="#"><i id="nf_icon" class="icon-bell" style="color:orange;"></i><nf id="nf_total" style="color:orange; font-weight: bold">2</nf></a>
                    <ul class="dropdown-menu pull-right messages_dropdown">
                        <li>
                            <div class="details">
                                <div class="name"><b><u>Notifikasi</u></b></div>
                                <a href="<?php echo base_url() ?>data_transaksi/permintaan"><div id="nf_permintaan" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/penerimaan"><div id="nf_penerimaan" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/pemakaian"><div id="nf_pemakaian" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/stock_opname"><div id="nf_stock_opname" class="name"></div></a>

                                <a href="<?php echo base_url() ?>data_transaksi/permintaan"><div id="nf_permintaan_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/penerimaan"><div id="nf_penerimaan_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/pemakaian"><div id="nf_pemakaian_c" class="name"></div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/stock_opname"><div id="nf_stock_opname_c" class="name"></div></a>
                                <!-- <div class="name">aaa</div>                                    
                                <div class="message">
                                    Lorem ipsum Commodo quis nisi...
                                </div> -->
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" style="min-width: 110px;display: block;">
                        <span style="float: left;"> <?php echo $this->session->userdata('user_name'); ?></span> 
                        <span style="float: right"><i style="padding-left: 20px;"></i> <i class="icon-angle-down"></i></span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url() ?>user_management/user/profil"><i class="icon-user"></i> User Profil</a></li>
                        
                        <li><a href="<?php echo base_url() ?>user_management/user/ganti_password"><i class="icon-key"></i> Ganti Password</a></li>
                        <li><a href="<?php echo base_url() ?>document/documentsop"><i class="icon-info-sign"></i> Bantuan</a></li>
                        <li><a href="<?php echo base_url() ?>login/stop"><i class="icon-signout"></i> Logout</a></li>
                    </ul>
                </li>
                <li rel="tooltip" data-placement="bottom" title="Waktu Sekarang" class="messages hidden-480 hidden-768">
                    <a href="javascript:void(0);">
                        <i class="icon-time"></i>
                        <span id="date_time"></span>
                    </a>
                    <script type="text/javascript">window.onload = date_time('date_time');</script>
                </li>
                <li rel="tooltip" data-placement="bottom" title="Waktu Sekarang" style="display: none;" class="messages show-480 show-767">
                    <a href="javascript:void(0);"><i class="icon-time"></i></a>
                    <ul class="dropdown-menu pull-right messages_dropdown">
                        <li>
                            <a href="#">
                                <div class="details">
                                    <div class="message">
                                        <span id="date_time2"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <script type="text/javascript">window.onload = date_time('date_time2');</script>
                </li>
                <li class="responsive_menu"><a class="iconic" href="#"><i class="icon-reorder"></i></a></li>
            </ul>
        </header>

        <div id="main_navigation" class="blue"> <!-- Main navigation start -->
            <div class="inner_navigation">
                <?php echo $main_menu; ?>
            </div>
        </div>  

        <div id="content" <?php echo isset($sidebar_content)? "class='sidebar'" :"";?>> 
            <?php isset($page_content) ? $this->load->view($page_content) : 'Silahkan set $data["page_content"] = ""; '; ?>
        </div>
        <footer style="display: none;">
            <span class="hidden-480">&copy; ICON+</span>
        </footer>

    </body>
</html>

<script type="text/javascript">

    var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";
    var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";

    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    function get_notif_kirim(vjenis) {
        var data = {jenis: vjenis};
        $.post("<?php echo base_url()?>template/template/get_notif_kirim/", data, function (data) {
            var get_data = (JSON.parse(data));

            for (i = 0; i < get_data.length; i++) {
                var TOTAL = get_data[i].TOTAL; 
                var PERMINTAAN = get_data[i].PERMINTAAN; 
                var PEMAKAIAN  = get_data[i].PEMAKAIAN; 
                var PENERIMAAN = get_data[i].PENERIMAAN; 
                var STOCK_OPNAME = get_data[i].STOCK_OPNAME; 
                var PERMINTAAN_CLOSING = get_data[i].PERMINTAAN_CLOSING; 
                var PEMAKAIAN_CLOSING  = get_data[i].PEMAKAIAN_CLOSING; 
                var PENERIMAAN_CLOSING = get_data[i].PENERIMAAN_CLOSING; 
                var STOCK_OPNAME_CLOSING = get_data[i].STOCK_OPNAME_CLOSING; 
            }
            
            if (TOTAL > 0) {
                $('#nf_total').html(formatNumber(TOTAL));
                if (PERMINTAAN>0){$('#nf_permintaan').html('Data Permintaan Belum '+vjenis+' : '+formatNumber(PERMINTAAN));}
                if (PEMAKAIAN>0){$('#nf_pemakaian').html('Data Pemakaian Belum '+vjenis+' : '+formatNumber(PEMAKAIAN));}
                if (PENERIMAAN>0){$('#nf_penerimaan').html('Data Penerimaan Belum '+vjenis+' : '+formatNumber(PENERIMAAN));}
                if (STOCK_OPNAME>0){$('#nf_stock_opname').html('Stock Opname Belum '+vjenis+' : '+formatNumber(STOCK_OPNAME));}

                if (vjenis=='Kirim'){
                    if (PERMINTAAN_CLOSING>0){$('#nf_permintaan_c').html('Data Permintaan Closing : '+formatNumber(PERMINTAAN_CLOSING));}
                    if (PEMAKAIAN_CLOSING>0){$('#nf_pemakaian_c').html('Data Pemakaian Closing : '+formatNumber(PEMAKAIAN_CLOSING));}
                    if (PENERIMAAN_CLOSING>0){$('#nf_penerimaan_c').html('Data Penerimaan Closing : '+formatNumber(PENERIMAAN_CLOSING));}
                    if (STOCK_OPNAME_CLOSING>0){$('#nf_stock_opname_c').html('Stock Opname Closing : '+formatNumber(STOCK_OPNAME_CLOSING));}                   
                }

                $('#nf_notif').show();

                // setNotif();
                // setInterval(setNotif, 5000);
            }
            
        });
    }

    // if ((vIsAdd) && (vLevelUser>=2)){
        get_notif_kirim('Kirim');
        get_notif_kirim('Approve');
    // }

function setNotif() {
  // setTimeout(function () {
  //     $('#nf_total').hide();
  //   }, 1000);
  // setTimeout(function () {
  //     $('#nf_total').show();
  //   }, 2000);
  setTimeout(function () {
      $('#nf_total').hide();
    }, 3000);
  setTimeout(function () {
      $('#nf_total').show();
    }, 4000);
}

    
</script>
