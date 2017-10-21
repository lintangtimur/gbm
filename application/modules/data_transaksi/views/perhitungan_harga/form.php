
<!-- /**
 * @module TRANSAKSI PERHITUNGAN BBM
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
            <!--perhitungan Start -->
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="control-group">

                    </div>
                </div>
            </div>
    
            <!-- perhitungan End -->
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    // $('input[name=VOLUME_STOCKOPNAME]').inputmask("numeric", {radixPoint: ".",groupSeparator: ",",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
    // });
</script> 