<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
            <table class="table">
                    <tr>
                        <td>
                            <div class="control-group">
                                <label for="password" class="control-label">Pembangkits <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('unit_pembangkit', $unit_pembangkit, !empty($default->SLOC) ? $default->SLOC : '', 'class="span10"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Jenis BBM<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('jenis_bbm', $jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span10"'); ?>
                                </div>
                            </div>
                            <div class="control-group" hidden>
                                <label for="password" class="control-label">Nama Tangki<span class="required">*</span> : </label>
                                <div class="controls">
                                   <!-- <?php echo form_input('NAMA_TANGKI', !empty($default->NAMA_TANGKI) ? $default->NAMA_TANGKI : '', 'class="span10"'); ?> -->
                                    <?php echo form_input('NAMA_TANGKI', 'TANGKI TIMBUN', 'class="span10"'); ?>
                                </div>
                        </td>
                        <td>
                            </div>
                             <div class="control-group">
                                <label for="password" class="control-label">Kapasitas (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('KAPASITAS', !empty($default->VOLUME_TANGKI) ? $default->VOLUME_TANGKI : '', 'class="span10"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Dead Stock (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('DEAD_STOCK', !empty($default->DEADSTOCK_TANGKI) ? $default->DEADSTOCK_TANGKI : '', 'class="span10"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Kapasitas Efektif (L)<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('STOCK_EFEKTIF', !empty($default->STOCKEFEKTIF_TANGKI) ? $default->STOCKEFEKTIF_TANGKI : '', 'class="span10"'); ?>
                                </div>
                            </div>
                           
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <label for="password" class="control-label">Tera<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('TERA', $tera, !empty($default->ID_TERA) ? $default->ID_TERA : '', 'class="span8"'); ?>
                                </div>
                            </div>
                             <div class="control-group">
                                <label for="password" class="control-label">Tanggal Akhir Tera<span class="required">*</span> : </label>
                                <div class="controls">
                                <?php echo form_input('TGL_TERA', !empty($default->TGL_DET_TERA) ? $default->TGL_DET_TERA : '', 'class="span8", id="TGL_TERA"'); ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="control-group">
                                <label for="password" class="control-label" id="up_nama">Upload Dokumen : </label> 
                                <div class="controls" id="up_file">
                                    <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_DET_TERA) ? $default->PATH_DET_TERA : '', 'class="span6"'); ?>
                                </div>
                            <div class="controls" id="dokumen">
                                <a href="<?php echo base_url().'assets/upload/tangki/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                            </div>
								<!-- <div class="controls" id="dokumen">
									<a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="TANGKI" data-url="<?php// echo $url_getfile;?>" data-filename="<?php //echo !empty($default->PATH_DET_TERA) ? $default->PATH_DET_TERA : '';?>"><b><?php// echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
								</div>  -->
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Aktif <span class="required">*</span> : </label>
                                <div class="controls">
                                <?php echo form_checkbox('STATUS', '1',!empty($default->ISAKTIF_DET_TERA) ? $default->ISAKTIF_DET_TERA : '', 'class ="STATUS"' ); ?> 
                                </div>
                            </div>
                            <!-- <div class="control-group">
                                <div class="controls">
                                    <?php #echo anchor(null, '<i class="icon-plus"></i> Tambah', array( 'id' => 'tambah', 'class' => 'blue btn')); ?>
                                </div>
                            </div> -->
                        </td>
                    </tr>
            </table>
            <!-- <div id="content_table" data-source="<?php #echo $data_detail; ?>" data-filter="#ffilter"></div> -->
       <!--  <div class="well-content" id="content_table">
            <table id="data_tera" class="table table-striped table-bordered table-hover datatable dataTable">
                <thead>
                    <tr>
                        <th>Tera</th>
                        <th>Path Tera</th>
                        <th>Tanggal Detail Tera</th>
                        <th>Status</th>
                    </tr>
                </thead>
                    <tr>
                        <td><?php #echo $data_detail->ID_TERA; ?></td>
                        <td><?php #echo $data_detail->PATH_DET_TERA; ?></td>
                        <td><?php #echo $data_detail->TGL_DET_TERA; ?></td>
                        <td><?php #echo $data_detail->ISAKTIF_DET_TERA; ?></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
 -->
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
             <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
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

<script type="text/javascript">
$("#TGL_TERA").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    
    $('input[name=KAPASITAS]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=DEAD_STOCK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
    $('input[name=STOCK_EFEKTIF]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    });
</script>
<script type="text/javascript">
     $("#tambah").click(function () {
        var stat = '';
        if ($('.STATUS').is(":checked"))
        {
            stat = 'AKTIF';
        } else {
            stat = 'TIDAK AKTIF';
        }

        if ($('.tera').val() != '') {
            $('#data_tera').append('<tr><td>'+ $('.tera').val()  +'</td><td>'+ $('.tera option:selected').text()  +'</td><td>'+ $('.filepath').val()  +'</td><td>'+ $('#TGL_TERA').val()  +'</td><td>'+ stat +'</td></tr>');
        } else {
            alert('Data Belum Lengkap');
        };

    });

</script>