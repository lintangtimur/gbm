<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

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
                            <div class="panel-body">
                                <h4 style="margin-top: 2em;">Add to archive mail from:</h4>
                                <input class="datepicker" type="text"/>
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