<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

if($Virtualterminal_Clientform == "FALSE") {

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>



<style>
    /* ====== THIS IS THE STYLING FOR THE MODAL PROCESSING FORM ======= */
    #loading-div-background{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        background: #fff;
        width: 100%;
        height: 100%;
    }

    #loading-div{
        width: 300px;
        height: 150px;
        background-color: #fff;
        border: 5px solid #f59c1a;
        text-align: center;
        color: #202020;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        behavior: url("/css/pie/PIE.htc"); /* HANDLES IE */
    }
</style>

<body class="flat-black">

<div id="page-container" class="fade in page-without-sidebar">


    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin page-header -->
        <h1 class="page-header"><?php echo $page_data['heading'];?></h1>
        <!-- end page-header -->


        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">
                <?php $attributes = array('class' => 'form-horizontal', 'id' => 'vtpaymentform'); ?>
                <?php echo form_open('virtualterminal/submit', $attributes);

                    $data = array(
                        'type'  => 'hidden',
                        'name'  => 'cardtype',
                        'id'    => 'cardtype',
                        'value' => '',
                        'class' => 'cardtype'
                    );

                        echo form_input($data) ;


                ?>
                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">PAYMENT INFORMATION (* = Required Field)</h4>
                        </div>
                        <div class="panel-body">
                            <legend>Billing Information</legend>

                            <div class="form-group <?php echo(!empty(form_error('firstname')) ? 'has-error has-feedback' : ''); ?>">
                                <label class="col-md-3 control-label">FIRST NAME*</label>
                                <div class="col-md-9">
                                    <?php
                                    $data = array(
                                        'name'          => 'firstname',
                                        'id'            => 'firstname',
                                        'value'         => set_value('firstname'),
                                        'class'         => 'form-control',
                                        'type'          => 'text',
                                        'placeholder'   => 'Required',
                                        'maxlength'     => '100',
                                        'data-parsley-required' => 'true'
                                    );

                                    echo form_input($data);
                                    ?>
                                    <?php echo(!empty(form_error('firstname')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                    <?php echo form_error('firstname'); ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo(!empty(form_error('middleinitial')) ? 'has-error has-feedback' : ''); ?>">
                                <label class="col-md-3 control-label">MIDDLE INITIAL</label>
                                <div class="col-md-9">
                                    <?php
                                    $data = array(
                                        'name'          => 'middleinitial',
                                        'id'            => 'middleinitial',
                                        'value'         => set_value('middleinitial'),
                                        'class'         => 'form-control',
                                        'type'          => 'text',
                                        'placeholder'   => 'Middle Initial',
                                        'maxlength'     => '1'
                                    );

                                    echo form_input($data);
                                    ?>
                                    <?php echo(!empty(form_error('middleinitial')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                    <?php echo form_error('middleinitial'); ?>
                                </div>
                            </div>
                            <div class="form-group <?php echo(!empty(form_error('lastname')) ? 'has-error has-feedback' : ''); ?>">
                                <label class="col-md-3 control-label">LAST NAME*</label>
                                <div class="col-md-9">
                                    <?php
                                    $data = array(
                                        'name'          => 'lastname',
                                        'id'            => 'lastname',
                                        'value'         => set_value('lastname'),
                                        'class'         => 'form-control',
                                        'type'          => 'text',
                                        'placeholder'   => 'Required',
                                        'maxlength'     => '100',
                                        'data-parsley-required' => 'true'
                                    );

                                    echo form_input($data);
                                    ?>
                                    <?php echo(!empty(form_error('lastname')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                    <?php echo form_error('lastname'); ?>
                                </div>
                            </div>

                            <?php if($Virtualterminal_Email == "TRUE") { ?>
                                <div class="form-group <?php echo(!empty(form_error('email')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">EMAIL</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'email',
                                            'id'            => 'email',
                                            'value'         => set_value('email'),
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'placeholder'   => 'Email',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('email')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($Virtualterminal_Notes == "TRUE") { ?>
                                <div class="form-group <?php echo(!empty(form_error('notes')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">NOTES</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'notes',
                                            'id'            => 'notes',
                                            'value'         => set_value('notes'),
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'placeholder'   => 'Notes',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('notes')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('notes'); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <legend>Credit Card Information</legend>
                                <div class="form-group <?php echo(!empty(form_error('creditcard')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">CREDIT CARD *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'creditcard',
                                            'id'            => 'creditcard',
                                            'value'         => set_value('creditcard'),
                                            'class'         => 'form-control creditcard',
                                            'type'          => 'text',
                                            'placeholder'   => '9999 9999 9999 9999',
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('creditcard')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('creditcard'); ?>

                                    </div>
                                </div>

                                <div class="form-group <?php echo(!empty(form_error('expirationmonth')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Expiration Month *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $extra = array(
                                            'class' => 'form-control selectpicker',
                                            'id' => 'expirationmonth',
                                            'name' => 'expirationmonth',
                                            'data-live-search' => 'true',
                                            'data-style' => (!empty(form_error('expirationmonth')) ? 'btn-danger' : ''),
                                        );

                                        $options = array(
                                            '0'  => 'Select Month',
                                            '01' => 'January (01)',
                                            '02' => 'February (02)',
                                            '03' => 'March (03)',
                                            '04' => 'April (04)',
                                            '05' => 'May (05)',
                                            '06' => 'June (06)',
                                            '07' => 'July (07)',
                                            '08' => 'August (08)',
                                            '09' => 'September (09)',
                                            '10' => 'October (10)',
                                            '11' => 'November (11)',
                                            '12' => 'December (12)',
                                        );

                                        echo form_dropdown('expirationmonth', $options, set_value('expirationmonth'), $extra);
                                        ?>
										
                                        <?php echo(!empty(form_error('expirationmonth')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('expirationmonth'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('expirationyear')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Expiration Year *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $extra = array(
                                            'class' => 'form-control selectpicker',
                                            'id' => 'expirationyear',
                                            'name' => 'expirationyear',
                                            'data-live-search' => 'true',
                                            'data-style' => (!empty(form_error('expirationyear')) ? 'btn-danger' : ''),
                                        );


                                        $options = array();
                                        for ($i = 0; $i <= 10; $i++ ){
                                            $a_year = date("Y") + $i;
                                            $options[$a_year] = $a_year;
                                        }

                                        echo form_dropdown('expirationyear', $options, set_value('expirationyear'), $extra);
                                        ?>
                                        <?php echo(!empty(form_error('expirationyear')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('expirationyear'); ?>
                                    </div>
                                </div>

                                <div class="form-group <?php echo(!empty(form_error('cvv2')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">CVV2</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'cvv2',
                                            'id'            => 'cvv2',
                                            'value'         => set_value('cvv2'),
                                            'class'         => 'form-control cvv2',
                                            'type'          => 'text',
                                            'placeholder'   => '000',
                                            'maxlength'     => '4',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('cvv2')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('cvv2'); ?>
                                    </div>
                                </div>

                            <legend>Payment Amount</legend>
                                <div class="form-group <?php echo(!empty(form_error('paymentamount')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Amount *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'paymentamount',
                                            'id'            => 'maskedMoney-input-paymentamount',
                                            'value'         => set_value('paymentamount'),
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

                            <div class="form-group">
                                <label class="col-md-3 control-label">Submit</label>
                                <div class="col-md-9">
                                    <button type="submit" value="Submit" class="btn btn-sm btn-success" id="submit">Submit Button</button>
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

    <!-- #modal-message -->
    <div id="loading-div-background">
        <div id="loading-div" class="ui-corner-all">
            <img style="height:64px;width:62px;margin:30px;" src="<?php echo base_url(); ?>assets/img/wait_spinner.gif" alt="Loading.."/><br>PROCESSING. PLEASE WAIT...
        </div>
    </div>


    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->

</div>
<!-- end page container -->

<?php $this->load->view('footer'); ?>
	
	<script src="<?php echo base_url(); ?>/assets/plugins/jquery-payment/lib/jquery.payment.min.js"></script>


<script type="text/javascript">

    $(document).ready(function() {
        $("#loading-div-background").css({ opacity: 1.0 });

        $('#vtpaymentform').submit(function(){
            var cardType = $.payment.cardType($('.creditcard').val());
            $('.cardtype').val(cardType);
            $('#submit').attr({
                disabled: 'disabled',
                value: 'Processing, Please Wait...'
            });
            $("#loading-div-background").show();
        });

        $('.creditcard').payment('formatCardNumber');
        $('.cc-cvc').payment('formatCardCVC');
    });

</script>


<script type="text/javascript">
    /* Credit Card Swipe Logic */
    var readErrorReason = "Credit card read error. Please try again.";

    var creditCardParser = function (rawData) {

        var trackpattern = new RegExp("^(%[^%;\\?]+\\?)(;[0-9\\:<>\\=]+\\?)?(;[0-9\\:<>\\=]+\\?)?");

        var trackmatches = trackpattern.exec(rawData);
        if (!trackmatches) return null;

        var fieldpattern = new RegExp("^(\\%)([a-zA-Z])(\\d{1,19})(\\^)(.{2,26})(\\^)(\\d{0,4}|\\^)(\\d{0,3}|\\^)(.*)(\\?)");

        var fieldmatches = fieldpattern.exec(rawData);

        if (!fieldmatches) return null;

        // Extract the three lines
        var cardData = {
            track1: trackmatches[1],
            track2: trackmatches[2],
            track3: trackmatches[3],
            FC: fieldmatches[2],
            PAN: fieldmatches[3],
            NM: fieldmatches[5],
            ED: fieldmatches[7],
            SC: fieldmatches[8],
            DD: fieldmatches[9]
        };

        if (cardData.FC != "B")
        {
            readErrorReason = "Invalid Format Code. Only cards with Format Code 'B' may be processed.";
        }
        else if (cardData.PAN.length == 0)
        {
            readErrorReason = "Can not read Primary Account Number. Please try again.";
        }
        else if (cardData.ED.length == 0)
        {
            readErrorReason = "Can not read Expiration Date. Please try again.";
        }

        console.log(cardData);

        return cardData;
    };

    var goodScan = function (data) {
        $("#status").text("Success!");
        $("#track1").text(data.track1);
        $("#track2").text(data.track2);
        $("#track3").text(data.track3);

        // console.log(data.PAN);
        // console.log(data.ED.substring(2, 4));
        // console.log(data.ED.substring(0, 2));

        // Swap around the name
        var fullname  = data.NM.split("/");
        var firstname = fullname[1].trim();
        var lastname = fullname[0].trim();
        var formattedname = firstname.concat(" ", lastname).trim();

        $("[name='fullname']").val(formattedname);
        $("[name='creditcard']").val(data.PAN);

        // Set Value of Element then run the selectpicker refresh
        $("#expirationmonth").val(data.ED.substring(2, 4));
        $('.selectpicker').selectpicker('refresh');

        // var expirationyear = data.ED.substring(0, 2);
        // $("[name='expirationyear']").val(data.ED.substring(0, 2));
        var year_prefix = "20";
        var year_suffix = data.ED.substring(0, 2);
        var cardyear = year_prefix.concat(year_suffix);
        $("#expirationyear").val(cardyear);
        $('.selectpicker').selectpicker('refresh');


        $("[name='cvv2']").focus();
    }

    var badScan = function () {
        $("#status").text("Failed!");
        $(".line").text("");
        alert(readErrorReason);
    }

    // Initialize the plugin with default parser and callbacks.
    //
    // Set debug to true to watch the characters get captured and the state machine transitions
    // in the javascript console. This requires a browser that supports the console.log function.
    //
    // Set firstLineOnly to true to invoke the parser after scanning the first line. This will speed up the
    // time from the start of the scan to invoking your success callback.
    $.cardswipe({
        firstLineOnly: false,
        success: goodScan,
        parser: creditCardParser,
        error: badScan,
        debug: true
    });

</script>

</body>
</html>

<?php } else { ?>


<?php 
		$css = new Asset_css('virtualterminalform');
	    $css->add_asset($this->config->item('base_preprocess'));
		$css->add_asset($this->config->item('client'));
		$css->add_asset('./client/client-virtualterminal.scss');
	
		$data['asset'] = $css;
		$this->load->view('header', $data); 
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->


<?php $this->load->view('header_client'); ?>

<style>
    /* ====== THIS IS THE STYLING FOR THE MODAL PROCESSING FORM ======= */
    #loading-div-background{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        background: #fff;
        width: 100%;
        height: 100%;
    }

    #loading-div{
        width: 300px;
        height: 150px;
        background-color: #fff;
        border: 5px solid #1d1ff5;
        text-align: center;
        color: #202020;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        behavior: url("/css/pie/PIE.htc"); /* HANDLES IE */
    }
</style>

<body>
	
		<?php include './client/client_website/client-header.php' ?>
	
<div class="container" style="max-width: 500px;">
    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'vtpaymentform'); ?>
    <?php echo form_open('virtualterminal/submit', $attributes);
        $data = array(
            'type'  => 'hidden',
            'name'  => 'cardtype',
            'id'    => 'cardtype',
            'value' => '',
            'class' => 'cardtype'
        );
        echo form_input($data) ;
    ?>
        <?php echo(!empty(form_error('firstname')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>FIRST NAME*</label>
        <?php
            $data = array(
                'name'          => 'firstname',
                'id'            => 'firstname',
                'value'         => set_value('firstname'),
                'class'         => 'form-control',
                'type'          => 'text',
                'placeholder'   => 'Required',
                'maxlength'     => '100',
                'data-parsley-required' => 'true'
            );
            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('firstname')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('firstname'); ?>

    <br>

        <label>MIDDLE INITIAL</label>
        <?php
            $data = array(
                'name'          => 'middleinitial',
                'id'            => 'middleinitial',
                'value'         => set_value('middleinitial'),
                'class'         => 'form-control',
                'type'          => 'text',
                'placeholder'   => 'Middle Initial',
                'maxlength'     => '1'
            );
            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('middleinitial')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('middleinitial'); ?>

    <br>

        <?php echo(!empty(form_error('lastname')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>LAST NAME*</label>
        <?php
            $data = array(
                'name'          => 'lastname',
                'id'            => 'lastname',
                'value'         => set_value('lastname'),
                'class'         => 'form-control',
                'type'          => 'text',
                'placeholder'   => 'Required',
                'maxlength'     => '100',
                'data-parsley-required' => 'true'
            );
            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('lastname')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('lastname'); ?>

    <br>

        <?php if($Virtualterminal_Email == "TRUE") { ?>
            <label>EMAIL</label>
            <?php
                $data = array(
                    'name'          => 'email',
                    'id'            => 'email',
                    'value'         => set_value('email'),
                    'class'         => 'form-control',
                    'type'          => 'text',
                    'placeholder'   => 'Email',
                    'maxlength'     => '100',
                    'data-parsley-required' => 'true'
                );
                echo form_input($data);
            ?>
            <?php echo(!empty(form_error('email')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
            <?php echo form_error('email'); ?>
        <?php } ?>

    <br>

        <?php if($Virtualterminal_Notes == "TRUE") { ?>
            <label>NOTES</label>
            <?php
                $data = array(
                    'name'          => 'notes',
                    'id'            => 'notes',
                    'value'         => set_value('notes'),
                    'class'         => 'form-control',
                    'type'          => 'text',
                    'placeholder'   => 'Notes',
                    'maxlength'     => '100',
                    'data-parsley-required' => 'true'
                );
                echo form_input($data);
            ?>
            <?php echo(!empty(form_error('notes')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
            <?php echo form_error('notes'); ?>
        <?php } ?>

    <br>

        <?php echo(!empty(form_error('creditcard')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>CREDIT CARD *</label>
        <?php
            $data = array(
                'name'          => 'creditcard',
                'id'            => 'creditcard',
                'value'         => set_value('creditcard'),
                'class'         => 'form-control creditcard',
                'type'          => 'text',
                'placeholder'   => '9999 9999 9999 9999',
            );
            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('creditcard')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('creditcard'); ?>

    <br>

        <?php echo(!empty(form_error('expirationmonth')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>Expiration Month *</label>
        <?php
            $extra = array(
                'class' => 'form-control selectpicker',
                'id' => 'expirationmonth',
                'name' => 'expirationmonth',
                'data-live-search' => 'true',
                'data-style' => (!empty(form_error('expirationmonth')) ? 'btn-danger' : ''),
            );

            $options = array(
                '0'  => 'Select Month',
                '01' => 'January (01)',
                '02' => 'February (02)',
                '03' => 'March (03)',
                '04' => 'April (04)',
                '05' => 'May (05)',
                '06' => 'June (06)',
                '07' => 'July (07)',
                '08' => 'August (08)',
                '09' => 'September (09)',
                '10' => 'October (10)',
                '11' => 'November (11)',
                '12' => 'December (12)',
            );

            echo form_dropdown('expirationmonth', $options, set_value('expirationmonth'), $extra);
        ?>
        <?php echo(!empty(form_error('expirationmonth')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('expirationmonth'); ?>

    <br>

        <?php echo(!empty(form_error('expirationyear')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>Expiration Year *</label>
        <?php
            $extra = array(
                'class' => 'form-control selectpicker',
                'id' => 'expirationyear',
                'name' => 'expirationyear',
                'data-live-search' => 'true',
                'data-style' => (!empty(form_error('expirationyear')) ? 'btn-danger' : ''),
            );


            $options = array();
            for ($i = 0; $i <= 10; $i++ ){
                $a_year = date("Y") + $i;
                $options[$a_year] = $a_year;
            }

            echo form_dropdown('expirationyear', $options, set_value('expirationyear'), $extra);
        ?>
        <?php echo(!empty(form_error('expirationyear')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('expirationyear'); ?>

    <br>

        <?php echo(!empty(form_error('cvv2')) ? '???PUT CLASS HERE???' : ''); ?>
        <label>CVV2 *</label>
        <?php
            $data = array(
                'name'          => 'cvv2',
                'id'            => 'cvv2',
                'value'         => set_value('cvv2'),
                'class'         => 'form-control cvv2',
                'type'          => 'text',
                'placeholder'   => '000',
                'maxlength'     => '4',
                'data-parsley-required' => 'true'
            );

            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('cvv2')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('cvv2'); ?>

    <br>

        <?php echo(!empty(form_error('paymentamount')) ? ' ???PUT CLASS HERE??? ' : ''); ?>
        <label>Amount *</label>
        <?php
            $data = array(
                'name'          => 'paymentamount',
                'id'            => 'maskedMoney-input-paymentamount',
                'value'         => set_value('paymentamount'),
                'class'         => 'form-control',
                'type'          => 'text',
                'placeholder'   => '0.00',
                'maxlength'     => '10',
                'data-parsley-required' => 'true'
            );

            echo form_input($data);
        ?>
        <?php echo(!empty(form_error('paymentamount')) ? '<span class="???PUT CLASS HERE???"></span>' : ''); ?>
        <?php echo form_error('paymentamount'); ?>

    <br>

    <button type="submit" value="Submit" class="btn btn-primary" id="submit">Submit Button</button>

    <br>

    <?php echo form_close(); ?>

	</div>

    <!-- #modal-message -->
    <div id="loading-div-background">
        <div id="loading-div" class="ui-corner-all">
            <img style="height:64px;width:62px;margin:30px;" src="<?php echo base_url(); ?>assets/img/wait_spinner.gif" alt="Loading.."/><br>PROCESSING. PLEASE WAIT...
        </div>
    </div>
	
	<?php include './client/client_website/client-footer.php' ?>
	
	
<?php $this->load->view('footer_client'); ?>

<script src="<?php echo base_url(); ?>/assets/plugins/jquery-payment/lib/jquery.payment.min.js"></script>


<script type="text/javascript">

    $(document).ready(function() {
        $("#loading-div-background").css({ opacity: 1.0 });

        $('#vtpaymentform').submit(function(){
            var cardType = $.payment.cardType($('.creditcard').val());
            $('.cardtype').val(cardType);
            $('#submit').attr({
                disabled: 'disabled',
                value: 'Processing, Please Wait...'
            });
            $("#loading-div-background").show();
        });

        $('.creditcard').payment('formatCardNumber');
        $('.cc-cvc').payment('formatCardCVC');
    });

</script>


<script type="text/javascript">
    /* Credit Card Swipe Logic */
    var readErrorReason = "Credit card read error. Please try again.";

    var creditCardParser = function (rawData) {

        var trackpattern = new RegExp("^(%[^%;\\?]+\\?)(;[0-9\\:<>\\=]+\\?)?(;[0-9\\:<>\\=]+\\?)?");

        var trackmatches = trackpattern.exec(rawData);
        if (!trackmatches) return null;

        var fieldpattern = new RegExp("^(\\%)([a-zA-Z])(\\d{1,19})(\\^)(.{2,26})(\\^)(\\d{0,4}|\\^)(\\d{0,3}|\\^)(.*)(\\?)");

        var fieldmatches = fieldpattern.exec(rawData);

        if (!fieldmatches) return null;

        // Extract the three lines
        var cardData = {
            track1: trackmatches[1],
            track2: trackmatches[2],
            track3: trackmatches[3],
            FC: fieldmatches[2],
            PAN: fieldmatches[3],
            NM: fieldmatches[5],
            ED: fieldmatches[7],
            SC: fieldmatches[8],
            DD: fieldmatches[9]
        };

        if (cardData.FC != "B")
        {
            readErrorReason = "Invalid Format Code. Only cards with Format Code 'B' may be processed.";
        }
        else if (cardData.PAN.length == 0)
        {
            readErrorReason = "Can not read Primary Account Number. Please try again.";
        }
        else if (cardData.ED.length == 0)
        {
            readErrorReason = "Can not read Expiration Date. Please try again.";
        }

        console.log(cardData);

        return cardData;
    };

    var goodScan = function (data) {
        $("#status").text("Success!");
        $("#track1").text(data.track1);
        $("#track2").text(data.track2);
        $("#track3").text(data.track3);

        // console.log(data.PAN);
        // console.log(data.ED.substring(2, 4));
        // console.log(data.ED.substring(0, 2));

        // Swap around the name
        var fullname  = data.NM.split("/");
        var firstname = fullname[1].trim();
        var lastname = fullname[0].trim();
        var formattedname = firstname.concat(" ", lastname).trim();

        $("[name='fullname']").val(formattedname);
        $("[name='creditcard']").val(data.PAN);

        // Set Value of Element then run the selectpicker refresh
        $("#expirationmonth").val(data.ED.substring(2, 4));
        $('.selectpicker').selectpicker('refresh');

        // var expirationyear = data.ED.substring(0, 2);
        // $("[name='expirationyear']").val(data.ED.substring(0, 2));
        var year_prefix = "20";
        var year_suffix = data.ED.substring(0, 2);
        var cardyear = year_prefix.concat(year_suffix);
        $("#expirationyear").val(cardyear);
        $('.selectpicker').selectpicker('refresh');


        $("[name='cvv2']").focus();
    }

    var badScan = function () {
        $("#status").text("Failed!");
        $(".line").text("");
        alert(readErrorReason);
    }

    // Initialize the plugin with default parser and callbacks.
    //
    // Set debug to true to watch the characters get captured and the state machine transitions
    // in the javascript console. This requires a browser that supports the console.log function.
    //
    // Set firstLineOnly to true to invoke the parser after scanning the first line. This will speed up the
    // time from the start of the scan to invoking your success callback.
    $.cardswipe({
        firstLineOnly: false,
        success: goodScan,
        parser: creditCardParser,
        error: badScan,
        debug: true
    });

</script>	
	
</body>
</html>

<?php } ?>

