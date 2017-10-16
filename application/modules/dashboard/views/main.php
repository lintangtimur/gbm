<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div class="well-content ">
                    <div style="margin-bottom: 10px;">
                        <div><h4>Selamat Datang, <?php echo $this->session->userdata('user_name') . '.'; ?></h4></div>
                    </div>
                    <div class="alert alert-success">
                        <div><h5 style="text-decoration: underline;margin-bottom: 5px;font-weight: bold;" ></h5></div>
                        <div style="text-align: justify;">
                            <?php echo $app_parameter->global_setting_description; ?>
                        </div>
                    </div>
                    <!--<div class="alert">
                        <div><h5 style="text-decoration: underline;margin-bottom: 5px;font-weight: bold;" >Motivation Quote</h5></div>
                        <div style="text-align: justify;">
                            <?php echo isset($motivasi)?$motivasi:"Semangat!!"; ?>
                        </div>
                    </div>-->
                </div>
            </div>

            <div class="span5" style="margin-top: 10px;">
                <div class="well">
                    <div class="well-header">
                        <h5>Notifications</h5>
                    </div>

                    <div class="well-content no_padding" style="display: block;">
                        <ul class="rows">
                            <li>
                                <span class="icon error"><i class="icon-bolt"></i></span>
                                <p>Evaluasi yang harus di tanggapi</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>