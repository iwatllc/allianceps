<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

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

                <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">CHANGE STATUS</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                    <div class="form-inline">

                                        Status: <?php echo $status ?>
                                        <br><br>

                                        <?php if ($status == 'pending') { ?>
                                            <strong>'Auth Only' transactions that are awaiting capture.</strong>
                                        <?php } elseif ($status == 'pendingsettlement') { ?>
                                            <strong>This transaction is awaiting settlement.</strong>
                                            <br><br>
                                            <a href="<?php echo base_url(); ?>void/Void/index/<?php echo $transactionfileid ?>" >
                                                <span>Click Here to void the transaction</span>
                                            </a>
                                        <?php } elseif ($status == 'failed') { ?>
                                            <strong>This transaction has failed.</strong>
                                        <?php } elseif ($status == 'canceled') { ?>
                                            <strong>This transaction has been voided.</strong>
                                        <?php } elseif ($status == 'complete') { ?>
                                            <strong>This transaction has settled.</strong>
                                            <br><br>
                                            <a href="<?php echo base_url(); ?>refund/Refund/index/<?php echo $transactionfileid ?>" >
                                                <span>Click Here to process a refund for the transaction</span>
                                            </a>
                                        <?php } elseif ($status == 'unknown') { ?>
                                            <strong>An unknown error was encountered while processing this transaction.</strong>
                                        <?php } elseif ($status == '') { ?>
                                            <strong>An unknown error was encountered while processing this transaction.</strong><br>
                                            <strong>The status of this transaction is unkown.</strong>
                                        <?php } ?>

                                    </div>
                            </div>
                        </div>
                    </div>   
            </div>
        </div>
        <!-- PAYMENT DETAILS -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">

                <!-- begin panel -->
                <div class="panel panel-inverse" >
                    <div class="panel-heading">
                        <h4 class="panel-title">PAYMENT DETAILS</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-9">
                            <div class="form-inline">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Batch Number</th>
                                            <th>Date</th>
                                            <th>Auth Code</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($paymentdetails->result() as $row){ ?>
                                            <tr>
                                                <td>
                                                    <?php echo $row->TransactionFileName; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->InsertDate; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->AuthCode; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->type; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->status; ?>
                                                </td>
                                                <td align="right">
                                                    <?php echo '$'.$row->TransactionAmount; ?>
                                                </td>
                                            </tr>
                                       <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRANSACTION DETAILS -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">

                <!-- begin panel -->
                <div class="panel panel-inverse" >
                    <div class="panel-heading">
                        <h4 class="panel-title">GATEWAY DETAILED STATUS</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-9">
                            <div class="form-inline">

                                <?php // echo $details->asXML(); ?>
                                <?php //echo '<pre>' ?>
                                <?php //print_r($details); ?>
                                <?php //echo '</pre>' ?>

                                <?php

                                $arr = json_decode( json_encode($details) , 1);
                                //print_r($arr);

                                echo pp($arr);

                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


<!-- end page container -->

</body>

<?php $this->load->view('footer'); ?>

</html>


<?php

function pp($arr){
    if (is_object($arr))
        $arr = (array) $arr;
    $retStr = '<ul>';
    if (is_array($arr)){
        foreach ($arr as $key=>$val){
            if (is_object($val))
                $val = (array) $val;
            if (is_array($val)){
                if(empty($val)){
                    $retStr .= '<li>' . $key . ' => ' . (' ') . '</li>';
                } else {
                    $retStr .= '<li>' . $key . ' => array(' . pp($val) . ')</li>';
                }
            }else{
                $retStr .= '<li>' . $key . ' => ' . ($val == '' ? '""' : $val) . '</li>';
            }
        }
    }
    $retStr .= '</ul>';
    return $retStr;
}



?>