<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>

<body class="flat-black">

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade in page-without-sidebar page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <a href="<?php echo current_url(); ?>" class="navbar-brand"><span class="navbar-logo"></span> EZ Online Pay</a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->


    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin page-header -->
        <h1 class="page-header"><?php echo $page_data['heading'];?></h1>
        <!-- end page-header -->


        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">
                <?php $attributes = array('class' => 'form-horizontal form-bordered'); ?>
                <?php echo form_open('virtualterminal/submit', $attributes); ?>
                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">PAYMENT INFORMATION (* = Required Field)</h4>
                        </div>
                        <div class="panel-body">
                            <legend>Billing Informaiton</legend>
                                <div class="form-group <?php echo(!empty(form_error('fullname')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">FULL NAME*</label>
                                    <div class="col-md-9">
                                        <?php
                                            $data = array(
                                                'name'          => 'fullname',
                                                'id'            => 'fullname',
                                                'value'         => set_value('fullname'),
                                                'class'         => 'form-control',
                                                'type'          => 'text',
                                                'placeholder'   => 'Required',
                                                'maxlength'     => '100',
                                                'data-parsley-required' => 'true'
                                            );

                                            echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('fullname')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('fullname'); ?>
                                    </div>
                                </div>
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
                            <legend>Credit Card Informaiton</legend>
                                <div class="form-group <?php echo(!empty(form_error('creditcard')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">CREDIT CARD *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'creditcard',
                                            'id'            => 'masked-input-cc',
                                            'value'         => set_value('creditcard'),
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'placeholder'   => '9999-9999-9999-9999',
                                            'maxlength'     => '19',
                                            'data-parsley-required' => 'true'
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
                                    <label class="col-md-3 control-label">CVV2 *</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'cvv2',
                                            'id'            => 'masked-input-cvv2',
                                            'value'         => set_value('cvv2'),
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'placeholder'   => '999',
                                            'maxlength'     => '3',
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


    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->

</div>
<!-- end page container -->

<?php $this->load->view('footer'); ?>

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