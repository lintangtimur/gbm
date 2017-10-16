<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div class="well-content">

                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="well">
                                <div class="well-content clearfix">

                                    <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                    <div class="form_row">
                                        <div class="pull-left span4">
                                            <div>
                                                <label>Nama/Username:</label>
                                            </div>
                                            <div>
                                                <?php echo form_input('nama', '', 'class="span12"'); ?>
                                            </div>
                                        </div>
										<div class="pull-left span4">
                                            <div>
                                                <label>Role :</label>
                                            </div>
                                            <div>
                                                <?php echo form_dropdown('role', $role_options, '', 'class="chosen span12"'); ?>
                                            </div>
                                        </div>
                                        <div class="pull-left span2">
                                            <div>
                                                <label>Status :</label>
                                            </div>
                                            <div>
                                                <?php echo form_dropdown('status', hgenerator::status_user(), '', 'class="chosen span12"'); ?>
                                            </div>
                                        </div>
                                        <div class="pull-left span2">
                                            <label></label>
                                            <div>
                                                <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>

                                </div>
                            </div> 
                        </div>
                    </div>

                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="form-content" class="modal fade modal-xlarge"></div>
            </div>
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