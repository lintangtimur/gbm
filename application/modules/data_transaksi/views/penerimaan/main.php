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
                    <div class="well-content clearfix">
                        <table class="pull-right">

                            <tr>
                                <td>
                                    <button class="btn btn-primary" type="button">Kirim</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="content">
                        <table class="table table-bordered table-striped" id="detailPenerimaan">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>TGL PENGAKUAN</th>
                                <th>NAMA PEMASOK</th>
                                <th>NAMA TRANSPORTIR</th>
                                <th>NAMA JNS BHN BKR</th>
                                <th>VOL TERIMA</th>
                                <th>VOL TERIMA REAL</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                                <th>CHECK</th>
                            </tr>
                            </thead>
                            <tbody ></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="form-content" class="well-content"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#detailPenerimaan').dataTable;

    function show_detail(tanggal) {
        if (!$('#table_detail').is(":visible")) {
            $.get("<?php echo base_url()?>data_transaksi/penerimaan/getDataDetail/"+tanggal, function (data) {
                var data_detail = (JSON.parse(data));
                console.log(data_detail);
                for (i = 0; i < data_detail.length; i++) {
                    console.log(data_detail.length);
                    $('#detailPenerimaan tbody').append('<tr>' +
                        '<td align="center">'+data_detail[i].ID_PENERIMAAN+'</td>' +
                        '<td align="center">'+data_detail[i].TGL_PENGAKUAN+'</td>' +
                        '<td align="center">'+data_detail[i].NAMA_PEMASOK+'</td>' +
                        '<td align="center">'+data_detail[i].NAMA_TRANSPORTIR+'</td>' +
                        '<td align="center">'+data_detail[i].NAMA_JNS_BHN_BKR+'</td>' +
                        '<td align="center">'+data_detail[i].VOL_TERIMA+'</td>' +
                        '<td align="center">'+data_detail[i].VOL_TERIMA_REAL+'</td>' +
                        '<td align="center">'+data_detail[i].STATUS+'</td>' +
                        '<td align="center">AKSI</td>' +
                        '<td align="center">CHECK</td>' +
                        '</tr>')
                }
            });
            $('#table_detail').show();
        } else {
            $('#detailPenerimaan tbody tr').detach();
            $('#table_detail').hide();
        }
    }

    jQuery(function ($) {
        load_table('#content_table', 1, '#ffilter');
        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');
        });
    });
</script>