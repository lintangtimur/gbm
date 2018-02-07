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
        echo $favicon;
        ?>
		<script type="text/javascript">
            var $ = jQuery;
        </script>
    </head>

    <body>
        <img src="<?php echo base_url();?>assets/img/login_bg.png">
        <?php isset($page_content) ? $this->load->view($page_content) : 'Silahkan set $data["page_content"] = ""; '; ?>
    </body>
</html>
