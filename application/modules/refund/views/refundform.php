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

<body class="flat-black">
    <!-- begin #content -->
    <div id="content" class="content">

        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">
                <?php $attributes = array('class' => 'form-horizontal'); ?>
                <?php echo form_open('refund/Refund/submit', $attributes); ?>
                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">REFUND INFORMATION (* = Required Field)</h4>
                        </div>
                        <div class="panel-body">
                            <legend>Transaction Information</legend>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Transaction Id</label>
                                    <div class="col-md-9">
                                        <?php
                                            $data = array(
                                                'name'          => 'tid',
                                                'id'            => 'tid',
                                                'value'         => set_value('transactionid', $page_data['payment']->TransactionFileName),
                                                'class'         => 'form-control',
                                                'type'          => 'text',
                                                'disabled'		=> 'disabled'
                                            );
                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Order Number</label>
                                    <div class="col-md-9">
                                        <?php
                                            $data = array(
                                                'name'          => 'onumber',
                                                'id'            => 'onumber',
                                                'value'         => set_value('ordernumber', $page_data['payment']->OrderNumber),
                                                'class'         => 'form-control',
                                                'type'          => 'text',
                                                'disabled'		=> 'disabled'
                                            );

                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Transaction Date</label>
                                    <div class="col-md-9">
                                        <?php
                                            $data = array(
                                                'name'          => 'idate',
                                                'id'            => 'idate',
                                                'value'         => set_value('insertdate', $page_data['payment']->InsertDate),
                                                'class'         => 'form-control',
                                                'type'          => 'text',
                                                'disabled'		=> 'disabled'
                                            );

                                            echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('paymentamount')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Amount to Refund*</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'paymentamount',
                                            'id'            => 'maskedMoney-input-paymentamount',
                                            'value'         => set_value('paymentamount', $page_data['payment']->TransactionAmount),
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'placeholder'   => '0.00',
                                            'maxlength'     => '10',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('paymentamount')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('paymentamount'); ?>
                                    </div>
                                </div>
							<?php echo form_hidden('paymentresponseid', $page_data['payment']->PaymentResponseId) ?>
							<?php echo form_hidden('insertdate', $page_data['payment']->InsertDate) ?>
							<?php echo form_hidden('ordernumber', $page_data['payment']->OrderNumber) ?>
							<?php echo form_hidden('transactionid', $page_data['payment']->PaymentTransactionId) ?>
							<?php echo form_hidden('paymentsource', $page_data['payment']->PaymentSource) ?>
							<?php echo form_hidden('transactionfilename', $page_data['payment']->TransactionFileName) ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Submit</label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success">Submit Button</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->

                <?php echo form_close(); ?>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->

    </div>
    <!-- end #content -->

</div>
<!-- end page container -->

<?php $this->load->view('footer'); ?>

</body>

</html>