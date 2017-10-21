<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Persediaan BBM'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : ''); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : ''); ?>
                    </div>
                </div>
                <div class="pull-left span2">
                    <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : ''); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : ''); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 4 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : ''); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 140px;"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;"'); ?>
                    </div>
                </div>
            </div>
            <div class="form_row">
                <div class="pull-left span8">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Excel", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> PDF", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    </div>
                </div>
                 
            </div>
        </div>
        <div class="well-content no-search">
            <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {

        load_table('#content_table', 1);

        $('#button-filter').click(function() {
            load_table('#content_table', 1);
        });

    });
</script>
<script type="text/javascript">
    jQuery(function($) {
        function setDefaultLv1(){
            $('select[name="PLANT"]').empty();
            $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
        }

        function setDefaultLv2(){
            $('select[name="STORE_SLOC"]').empty();
            $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
        }

        function setDefaultLv3(){
            $('select[name="SLOC"]').empty();
            $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
        }

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv2/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv3/'+stateID;
            setDefaultLv2();
            setDefaultLv3();
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
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv4/'+stateID;
            setDefaultLv3();
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
    });
</script>