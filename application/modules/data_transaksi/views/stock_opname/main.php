
<!-- /**
 * @module STOCK OPNAME
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
</div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content no-search">

                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                            <div class="form_row">
                                <div class="pull-left span3">
                                <label for="password" class="control-label">Regional : </label>
                                    <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : ''); ?>
                                     </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Level 1 : </label>
                                    <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : ''); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                <label for="password" class="control-label">Level 2 : </label>
                                    <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : ''); ?>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Level 3 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : ''); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Pembangkit : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : ''); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Jenis Bahan Bakar : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('BBM', $parent_options_jns, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : ''); ?>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                    <div class="controls">
                                    
                                    <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;", id="bln"'); ?>                 
                                    <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Filter Status <span class="required">*</span> : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('STATUS', $status_options, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : ''); ?>
                                    </div>
                                </div>
                            </div> 
                            <br>
                            <div class="form_row">
                            <div class="pull-left span4">
                                <div class="controls">
                                    <table>
                                        <tr>
                                            <td colspan=2><label>Kata Kunci</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo form_input('kata_kunci', '', 'class="input-large"'); ?></td>
                                            <td> &nbsp </td>
                                            <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="pull-left span5">
                                <div class="controls">
                                    <table>
                                        <tr>
                                            <td><label>Total data</label></td><td><label>:</label></td><td><label><info id="TOTAL"></info></label></td>
                                            <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                            <td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <td><label>Belum Kirim</label></td><td><label>:</label></td><td><label><info id="BELUM_KIRIM"></info></label></td>
                                            <td></td>
                                            <td><label>Disetujui</label></td><td><label>:</label></td><td><label><info id="DISETUJUI"></info></label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Belum Disetujui</label></td><td><label>:</label></td><td><label><info id="BELUM_DISETUJUI"></info></label></td>
                                            <td></td>
                                            <td><label>Ditolak</label></td><td><label>:</label></td><td><label><info id="DITOLAK"></info></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>   
						<?php echo form_close(); ?>
                        </div>
                    </div> 
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="well-content"></div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    jQuery(function($) {

        load_table('#content_table', 1, '#ffilter');
        get_sum_detail();

        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
            get_sum_detail();
        });

    });
</script>

<script type="text/javascript">
    jQuery(function($) {

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
            $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
        }
        
        function setDefaultJnsBhnBkr(){
            $('select[name="ID_JNS_BHN_BKR"]').empty();
            $('select[name="ID_JNS_BHN_BKR"]').append('<option value="">--Pilih Jenis Bahan Bakar--</option>');
        }

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            setDefaultJnsBhnBkr();
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv2/'+stateID;
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            setDefaultJnsBhnBkr();
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv3/'+stateID;
            setDefaultLv3();
            setDefaultLv4();
            setDefaultJnsBhnBkr();
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv4/'+stateID;
            setDefaultLv4();
            setDefaultJnsBhnBkr();
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

        // $('select[name="SLOC"]').on('change', function() {
        //     var stateID = $(this).val();
        //     var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_bbm/'+stateID;
        //     setDefaultJnsBhnBkr();
        //     if(stateID) {
        //         $.ajax({
        //             url: vlink_url,
        //             type: "GET",
        //             dataType: "json",
        //             success:function(data) {
        //                 $.each(data, function(key, value) {
        //                     $('select[name="BBM"]').append('<option value="'+ value.ID_JNS_BHN_BKR +'">'+ value.NAMA_JNS_BHN_BKR +'</option>');
        //                 });
        //             }
        //         });
        //     }
        // });

    });

    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    function get_sum_detail() {
        var data = $('#ffilter').serializeArray()

        $.post("<?php echo base_url()?>data_transaksi/stock_opname/get_sum_detail/", data, function (data) {
            var data_detail = (JSON.parse(data));

            for (i = 0; i < data_detail.length; i++) {
                $('#TOTAL').html(formatNumber(data_detail[i].TOTAL));
                $('#BELUM_KIRIM').html(formatNumber(data_detail[i].BELUM_KIRIM));
                $('#BELUM_DISETUJUI').html(formatNumber(data_detail[i].BELUM_DISETUJUI));
                $('#DISETUJUI').html(formatNumber(data_detail[i].DISETUJUI));
                $('#DITOLAK').html(formatNumber(data_detail[i].DITOLAK));
            }
        });
    }
</script>