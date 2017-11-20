
<!-- /**
 * @module MASTER TRANSPORTIR
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
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div class="well-content no-search">

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
                                    <?php  echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : ''); ?>
                                    </div>
                                </div>
                            </div>
                            <table>
								<tr>
									<td colspan=2><label>Kata Kunci</label>
									</td>
								</tr>
								<tr>
									<td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
									<td> &nbsp </td>
									<td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
								</tr>
							</table>
						<?php echo form_close(); ?>
                        </div>
                    </div>  
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div> 
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div id="content_table_buka" data-source="<?php echo $data_sources_buka_mutasi; ?>" data-filter="#ffilter_buka_mutasi"></div>
                </div>
                <div id="form-content" class="modal fade modal-xlarge"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {

        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function() {
            load_table('#content_table_buka', 1, '#ffilter_buka_mutasi');
        });

        load_table('#content_table_buka', 1, '#ffilter_buka_mutasi');

        function setDefaultLv1(){
            $('select[name="COCODE"]').empty();
            $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
        }

        function setDefaultLv2(){
            $('select[name="PLANT"]').empty();
            $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
        }

        function setDefaultLv1(){
        $('select[name="COCODE"]').empty();
        $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('select[name="PLANT"]').empty();
        $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
    }
    $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>data_transaksi/tutup_mutasi_persediaan/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
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
            var vlink_url = '<?php echo base_url()?>data_transaksi/tutup_mutasi_persediaan/get_options_lv2/'+stateID;

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

    });
</script>