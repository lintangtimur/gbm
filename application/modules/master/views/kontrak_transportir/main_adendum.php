<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Role Management'; ?>
    </div>
    <div class="span6">
                <div class="well">
                    <div class="pull-left">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
            
            <div class="well">
                <div class="well-content clearfix">
                    <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
                    <table>
                        <tr>
                            <td colspan=2><label>Kata Kunci</label>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
                            <td> &nbsp </td>
                            <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter2')); ?></td>
                        </tr>
                    </table>
                    <?php echo form_close(); ?>
                </div>
            </div> 
            <div id="content_table2" data-source="<?php echo $data_sources2; ?>" data-filter="#ffilter2"></div>
            <div>&nbsp;</div>
        <div id="form-content2" class="well-content"></div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {

        load_table('#content_table2', 1);

        $('#button-filter2').click(function() {
            load_table('#content_table2', 1);
        });

    });
</script>