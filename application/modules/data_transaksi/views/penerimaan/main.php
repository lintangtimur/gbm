<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 12:59 AM
 */
?>


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
            <div id="index-content" class="well-content no-search">

                <div class="well">
                    <div class="content_table">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <div class="content_table">
                    <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                        <table>
                            <tr>
                                <td colspan=2><label>Kata Kunci</label>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
                                <td> &nbsp</td>
                                <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                            </tr>
                        </table>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                <div id="table_detail" hidden>
                    <div class="content_table">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilters')); ?>
                            <table class="pull-right">
                                <tr>
                                    <td></td>
                                    <td colspan=2><label>Kata Kunci</label>
                                    </td>
                                </tr>
                                <tr>

                                    <td><?php echo form_input('kata_kunci_detail', '', 'class="input-xlarge"'); ?></td>
                                    <td> &nbsp</td>
                                    <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter_detail')); ?></td>
                                    <td>
                                        <button class="btn btn-primary" type="button">Kirim</button>
                                    </td>
                                </tr>
                            </table>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                <div id="content_table2" data-source="<?php echo $detail_penerimaan; ?>" data-filter="#ffilters"></div>

                </div>
            </div>
            <div id="form-content" class="well-content"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function show_detail(id) {
        if(!$('#table_detail').is(":visible")){
            $.post('');
            $('#table_detail').show();
        } else{
            $('#table_detail').hide();
        }
    }


    jQuery(function ($) {

        load_table('#content_table', 1, '#ffilter');
        load_table('#content_table2',1, '#ffilters');

        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');
        });

        $('#button-filter_detail').click(function () {
            load_table('#content_table2', 1, '#ffilters');
        });
    });
</script>