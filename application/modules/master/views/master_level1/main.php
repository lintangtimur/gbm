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
                            <?php echo form_open_multipart('', ['id' => 'ffilter']); ?>
                            <table>
								<tr>
									<td colspan=2><label>Kata Kunci</label>
									</td>
								</tr>
								<tr>
									<td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
									<td> &nbsp </td>
									<td><?php echo anchor(null, "<i class='icon-search'></i> Filter", ['class' => 'btn', 'id' => 'button-filter']); ?></td>
								</tr>
							</table>
						<?php echo form_close(); ?>
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

        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
        });

    });
</script>
