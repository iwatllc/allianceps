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
                <?php $attributes = array('class' => 'form-horizontal form-bordered', 'id' => 'searchform'); ?>
                <?php echo form_open('search/execute_search'); ?>
                <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">SEARCH TRANSACTIONS</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                    <div class="form-inline">
                                        <table style="width:100%; border-collapse: separate; border-spacing:1em;">
                                            
                                            <tr>
                                                <td>
                                                        <label>Transaction ID</label>
                                                        <?php echo form_input(array('name'=>'PaymentTransactionId', 'value'=>set_value('PaymentTransactionId', $search_array['PaymentTransactionId']), 'placeholder'=>'ID', 'class'=>'form-control')); ?>
                                                </td>

                                                <td>
                                                        <label>Transaction Begin Date</label>
                                                        <?php echo form_input(array('name'=>'BegDate', 'value'=>set_value('BegDate', $search_array['BegDate']), 'placeholder'=>'Begin Date', 'class'=>'form-control', 'id'=>'datepicker')); ?>
                                                </td>
                                                
                                                <td>
                                                        <label>Transaction End Date</label>
                                                        <?php echo form_input(array('name'=>'EndDate', 'value'=>set_value('EndDate', $search_array['EndDate']), 'placeholder'=>'End Date', 'class'=>'form-control', 'id'=>'datepicker2')); ?>
                                                </td>

                                                <td>
                                                        <label>Transaction Amount</label>
                                                        <?php echo form_input(array('name'=>'TransactionAmount', 'value'=>set_value('TransactionAmount', $search_array['TransactionAmount']), 'placeholder'=>'Transaction Amount', 'class'=>'form-control')); ?>
                                                </td>
                                                <td>
                                                    <label>Status</label>
                                                    <?php echo form_dropdown('TransactionStatusId', $transaction_statuses, $search_array['TransactionStatusId'], array('class'=>'form-control')); ?>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>
                                                        <label>Approval Code</label>
                                                        <?php echo form_input(array('name'=>'AuthCode', 'value'=>set_value('AuthCode', $search_array['AuthCode']), 'placeholder'=>'Approval Code', 'class'=>'form-control')); ?>
                                                </td>

                                                <td>
                                                        <label>Order Number</label>
                                                        <?php echo form_input(array('name'=>'OrderNumber', 'value'=>set_value('OrderNumber', $search_array['OrderNumber']), 'placeholder'=>'Order Number', 'class'=>'form-control')); ?>
                                                </td>
                                                
                                                <td>
                                                        <label>CVV2 Result</label>
                                                        <?php echo form_input(array('name'=>'CVV2ResponseCode', 'value'=>set_value('CVV2ResponseCode', $search_array['CVV2ResponseCode']), 'placeholder'=>'CVV2 Result', 'class'=>'form-control')); ?>
                                                </td>

                                                <td>
                                                        <label>Batch Number</label>
                                                        <?php echo form_input(array('name'=>'SerialNumber', 'value'=>set_value('SerialNumber', $search_array['SerialNumber']), 'placeholder'=>'Batch Number', 'class'=>'form-control')); ?>
                                                </td>
                                                <?php // these two td's go together. ?>
                                                <td>&nbsp;</td>
                                                <!-- Comment this out for go fund it.
                                                <td>
                                                        <label>Payment Source</label>
                                                        <?php echo form_dropdown('PaymentSource', $payment_sources, $search_array['PaymentSource'], array('class'=>'form-control')); ?>
                                                </td>
                                                -->

                                            </tr>
                                            
                                        </table>
                                    </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-9">


                                    <input type="button" onclick="location.href='search';" class="btn btn-sm btn-default" value="Reset" />
<!--                                    <form id="myFormId">-->
<!--                                        <input class="btn btn-sm btn-default" name="reset" type="reset" onclick="resetForm('myFormId');" />-->
<!--                                    </form>-->
                                    <?php
//                                        echo form_reset('reset', 'Reset', "class='btn btn-sm btn-default'", "id='reset'");

                                        echo form_submit('search_submit', 'Submit', "class='btn btn-sm btn-success'", "id='submit'");
                                        echo form_close();
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>   
    
                <div class="panel panel-inverse" >
                    <div class="panel-heading">
                        <h4 class="panel-title">TOTALS</h4>
                    </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php if (isset($num_results)) 
                                      {
                                           echo 'Records Returned: ' . $num_results;
                                      } ?>
                                <table border="1" width="50%" style="text-align: center;">
                              <?php if (isset($results))
                                    { 
                                        if ($results->num_rows() > 0)
                                        { ?>
                                            <thead align="center">
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>Number of Transactions</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                                <?php
                                                echo "<tr>";
                                                    echo "<td>";
                                                        echo "Totals";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo $num_results;
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo sprintf('$%01.2f', $total_amount);
                                                    echo "</td>";
                                                echo "<tr>";
                                                ?>
                                </table>
                                 <?php }
                                    } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>


                <div class="panel panel-inverse" >
                    <div class="panel-heading">
                        <h4 class="panel-title">SEARCH RESULTS</h4>
                    </div>
                        <div class="panel-body">
                            
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered tablesorter">
                                            <thead>
                                                <?php 
                                                if (isset($results))
                                                {
                                                    if ($results->num_rows() > 0)
                                                    { ?>
                                                        <tr>
                                                            <th>Batch Number</th>
                                                            <th>Date</th>
                                                            <th>Payer</th>
                                                            <th>Email</th>
                                                            <th>Notes</th>
                                                            <th>Amount</th>
                                                            <th>Auth Code</th>
                                                            <th>Status</th>
                                                            <th>Type</th>
                                                            <th>CVV2 Result</th>
                                                            <th>CC Last 4</th>
                                                            <th>Card Type</th>
                                                            <th>Actions</th>
                                                        </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($results->result() as $result)
                                                {
                                                    echo "<tr>";
                                                        echo "<td>";
                                                            echo strlen($result->SerialNumber) == 0 ? $result->TransactionFileName : $result->SerialNumber;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo date_conversion_nowording($result->InsertDate);
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->firstname. ' ' . $result->middleinitial . ' ' . $result->lastname;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->email;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->notes;
                                                        echo "</td>";
                                                        echo "<td align='right'>";
                                                            echo sprintf('$%01.2f', $result->TransactionAmount);
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->AuthCode;
                                                        echo "</td>";
														echo "<td>";
                                                            echo $result->status;
                                                            if ($result->status == 'Declined') {
                                                                echo "<br>";
                                                                echo $result->ResponseHTML;
                                                            }
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->type;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->CVV2ResponseCode . ' ' . $result->CVV2ResponseMessage;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            echo $result->cclast4;
                                                        echo "</td>";
                                                        echo "<td>";
                                                            switch ($result->cardtype) {
                                                                case 'visa':
                                                                    echo '<i class="fa fa-2x fa-cc-visa"></i>';
                                                                    break;
                                                                case 'mastercard':
                                                                    echo '<i class="fa fa-2x fa-cc-mastercard"></i>';
                                                                    break;
                                                                case 'amex':
                                                                    echo '<i class="fa fa-2x fa-cc-amex"></i>';
                                                                    break;
                                                                case 'discover':
                                                                    echo '<i class="fa fa-2x fa-cc-discover"></i>';
                                                                    break;
                                                                default:
                                                                    echo $result->cardtype;
                                                                    break;
                                                            }
                                                        echo "</td>";
														if(strcmp($result->status, 'Void') != 0 && strcmp($result->status, 'Refund') != 0 && strcmp($result->status, 'Declined') != 0 ) {
															echo "<td>";
															echo "<button data-paymentTransactionFileName='". $result->TransactionFileName ."' data-paymentResponseId='". $result->PaymentTransactionId ."' class='btn btn-link btn-changestatus'>Check Status</button><br>";
                                                            if(($result->paymentsource == 'DF') || ($result->paymentsource == 'AF')) {
                                                                echo "<button data-paymentTransactionFileName='". $result->TransactionFileName ."' data-paymentResponseId='". $result->PaymentTransactionId ."' class='btn btn-link btn-checkdonationamount'>Check Donation Amount</button><br>";
                                                            }
                                                            echo "</td>";
														}
														else {
															echo "<td>&nbsp;</td>";
														}
                                                    echo "<tr>";
                                                } ?>
                                            </tbody>
                                        </table>
                                </div>
                                            <?php
                                            } else
                                            {
                                                echo 'Search resulted with no records found';
                                            } ?>
                                        <?php 
                                        } else
                                        {
                                            // echo 'Please input info to search.';
                                        } ?>
                        </div>
                    </div>
                </div>
    
    </div>
    <!-- end #content -->
    <input id="transactionid" type="hidden"/>
	<div id="dialog-confirm-void" title="Void Transaction?"></div>
    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->

</div>    
    <!-- end page container -->

</body>

<?php $this->load->view('footer'); ?>
<script type="text/javascript">

    function resetForm($form) {
        $form.find('input:text, input:password, input:file, select, textarea').val('');
        $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
    }

    $( document ).ready(function() {
		//$("#myTable").tablesorter();

        $( "#datepicker" ).datepicker({defaultDate: null});
        $( "#datepicker2" ).datepicker({defaultDate: null});

        $( "#content" ).on("click", ".btn-changestatus", function() {
            window.location = "<?php echo base_url(); ?>changestatus/Changestatus/index/"+$(this).attr("data-paymentTransactionFileName")+"/"+$(this).attr("data-paymentResponseId");
        });

        $( "#content" ).on("click", ".btn-checkdonationamount", function() {
            window.location = "<?php echo base_url(); ?>checkdonationamount/index/"+$(this).attr("data-paymentResponseId");
        });
        
        $( "#content" ).on("click", ".btn-refund", function() {
			window.location = "<?php echo base_url(); ?>refund/Refund/index/"+$(this).attr("data-paymentResponseId");
        });
        
        $( "#content" ).on("click", ".btn-void", function() {
        	$("#transactionid").val($(this).attr("data-paymentResponseId"));
        	$("#dialog-confirm-void").html("<strong>Transaction Id:</strong> " + $(this).attr("data-paymentResponseId") + "</br>"
        								+  "<strong>Transaction Date:</strong> " + $(this).attr("data-transactionDate") + "</br>"
        								+  "<strong>Transaction Amount:</strong> $" + $(this).attr("data-transactionAmount"));
        	$("#dialog-confirm-void").dialog("option", "position", {at: "center top", of: this}).dialog("open");
        });
        
        $( "#dialog-confirm-void").dialog({
        	modal: true,
        	autoOpen: false,
        	buttons: {
        		"Void Transaction": function() {
        			window.location = "<?php echo base_url(); ?>void/Void/index/"+$("#transactionid").val();
        		},
        		Cancel: function() {
        			$(this).dialog("close");
        		}
        	}
        });
    });

</script>


</html>