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
                <li data-placement="bottom" title="Klik untuk detail notifikasi" class="messages">    
                    <a class="iconic" href="#"><i class="icon-warning-sign"></i> 1</a>
                    <ul class="dropdown-menu pull-right messages_dropdown">
                        <li>
                            <div class="details">
                                <div class="name"><b><u>Notifikasi</u></b></div>
                                <a href="<?php echo base_url() ?>data_transaksi/permintaan"><div class="name">Kirim Permintaan 4</div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/penerimaan"><div class="name">Kirim Penerimaan 2</div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/pemakaian"><div class="name">Kirim Pemakaian 7</div></a>
                                <a href="<?php echo base_url() ?>data_transaksi/stock_opname"><div class="name">Kirim Stock Opname 2</div></a>
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

</script>
