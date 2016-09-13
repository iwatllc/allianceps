<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
    table, th, td {
        border-collapse: separate;
        border-spacing:5em;
    }
    th, td {
        padding: 5px;
    }
</style>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('navbar'); ?>

<head>
    <title><?php echo $title; ?></title>
</head>
    
<body class = "flat-back">

    <div id="content" class="content">
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">
                <?php echo form_open('export/execute_export'); ?>
                <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">EXPORT TRANSACTIONS</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <div class="form-inline">
                                    <table style="width:100%; border-collapse: separate; border-spacing:1em;">
                                        <tr>
                                            <td>
                                                <label>Transaction Begin Date</label>
                                                <?php echo form_input(array('name'=>'BegDate', 'value'=>set_value('BegDate', $search_array['BegDate']), 'placeholder'=>'Begin Date', 'class'=>'form-control', 'id'=>'datepicker')); ?>
                                            </td>
                                            <td>
                                                <label>Transaction End Date</label>
                                                <?php echo form_input(array('name'=>'EndDate', 'value'=>set_value('EndDate', $search_array['EndDate']), 'placeholder'=>'End Date', 'class'=>'form-control', 'id'=>'datepicker4')); ?>
                                            </td>
                                            <td>
                                                <label>Status</label>
                                                <?php echo form_dropdown('TransactionStatusId', $transaction_statuses, $search_array['TransactionStatusId'], array('class'=>'form-control')); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <button type="submit" value="Submit" class="btn btn-sm btn-success" id="submit">Submit Button</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>

<?php $this->load->view('footer'); ?>
<script type="text/javascript">

    $( document ).ready(function() {

        $( "#datepicker" ).datepicker({
            defaultDate: null
        });

        $( "#datepicker4" ).datepicker({
            beforeShow: function (input, inst) {
                var offset = $(input).offset();
                window.setTimeout(function () {
                    var calWidth = inst.dpDiv.width();
                    var inpWidth = $(input).width() + parseInt($(input).css('padding'));
                    inst.dpDiv.css({ left: offset.left + (inpWidth - calWidth) + 'px' })
                }, 1);
            }
        });

    });

</script>


</html>