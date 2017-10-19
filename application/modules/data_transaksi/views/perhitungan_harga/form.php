
<!-- /**
 * @module TRANSAKSI PERHITUNGAN BBM
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

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
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        </div>
                         <div class="panel-body">
                             <div class="col-md-6">
                                <div class="panel panel-default">
                                <div class="panel-heading">
                                </div>
                                <div class="panel-body">
                                    <h4 style="margin-top: 2em;">Add to archive mail from:</h4>
                                   <input id="datepicker" type="text" />
                                </div>
                             </div>
                             </div>
                        </div>
                    </div>
            </div>
    </div>
            <!-- perhitungan End -->
        <?php echo form_close(); ?>
    </div>
</div>

 <script>
  $( function() {
    $.datepicker._gotoToday = function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);

            var date = new Date();
            this._setDate(inst,date);
            this._hideDatepicker();
            
        }

    $( "#datepicker" ).datepicker({
        showButtonPanel: true
    });
   
  } );
  </script>
</script>