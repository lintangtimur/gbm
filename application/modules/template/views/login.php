<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Metro Design</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        echo $css_header;
        echo $js_header;
        echo $favicon;
        ?>
    </head>

    <body class="blue-login">
        <?php isset($page_content) ? $this->load->view($page_content) : 'Silahkan set $data["page_content"] = ""; '; ?>
    </body>
</html>
