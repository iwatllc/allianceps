<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/23/15
 * Time: 11:11 AM
 */

$page_status = 'payment';
$error = '';
$error_message = '';

?>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="jquery.payment.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery-payment/lib/jquery.payment.min.js"></script>
    <script src="jquery.maskMoney.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/maskMoney/jquery.maskMoney.min.js"></script>

    <?php if($page_status == 'payment'){
    //=======================================================================================
    // DISPLAY THE PAYMENT FORM
    //=======================================================================================
    ?>

    <style type="text/css" media="screen">
        .has-error input {
            border-width: 2px;
        }
        .validation.text-danger:after {
            content: 'Validation failed';
        }
        .validation.text-success:after {
            content: 'Validation passed';
        }
    </style>

    <script>
        jQuery(function($) {
            $('[data-numeric]').maskMoney();;
            $('.cc-number').payment('formatCardNumber');
            $('.cc-exp').payment('formatCardExpiry');
            $('.cc-cvc').payment('formatCardCVC');
            $.fn.toggleInputError = function(erred) {
                this.parent('.form-group').toggleClass('has-error', erred);
                return this;
            };
            $('form').submit(function(e) {
                //e.preventDefault();
                var cardType = $.payment.cardType($('.cc-number').val());
                $('.cardtype').val(cardType);
                $('.firstname').toggleInputError($('.firstname').val().length == 0 ? true : false );
                $('.lastname').toggleInputError($('.lastname').val().length == 0 ? true : false );
                $('[data-numeric]').toggleInputError($('[data-numeric]').val().length == 0 ? true : false );
                $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
                $('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
                $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
                $('.cc-brand').text(cardType);
                // $('.validation').removeClass('text-danger text-success');
                // $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');

                if ($('.form-group').hasClass('has-error')) {
                    e.preventDefault();
                }
            });
        });
    </script>

</head>
<body>
<div class="container">
    <h1>
        Payment Page
    </h1>
    <p>A general purpose payment page.</p>

    <?php
    if ($error){
        echo '<strong>$error_message</strong>';
    }
    ?>

    <form novalidate autocomplete="on" method="POST" action="restapi/payment">
        <input type="hidden" name="cardtype" value="" id="cardtype" class="cardtype"  />

        <div class="form-group">
            <label for="firstname" class="control-label">First Name</label>
            <input id="firstname" name="firstname" type="text" class="input-lg form-control firstname" autocomplete="name" placeholder="First Name" required>
        </div>

        <div class="form-group">
            <label for="middleinitial" class="control-label">Middle Initial</label>
            <input id="middleinitial" name="middleinitial" type="text" class="input-lg form-control middleinitial" autocomplete="name" placeholder="Middle Initial" required>
        </div>

        <div class="form-group">
            <label for="lastname" class="control-label">Last Name</label>
            <input id="lastname" name="lastname" type="text" class="input-lg form-control lastname" autocomplete="name" placeholder="Last Name" required>
        </div>

        <div class="form-group">
            <label for="email" class="control-label">Email </label>
            <input id="email" name="email" type="text" class="input-lg form-control email" autocomplete="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="notes" class="control-label">Notes</label>
            <input id="notes" name="notes" type="text" class="input-lg form-control notes" placeholder="Notes" required>
        </div>

        <div class="form-group">
            <label for="cc-number" class="control-label">Card Number  <small class="text-muted">[<span class="cc-brand"></span>]</small></label>
            <input id="cc-number" name="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••" required>
        </div>

        <div class="form-group">
            <label for="cc-exp" class="control-label">Card Expiry </label>
            <input id="cc-exp" name="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="•• / ••" required>
        </div>

        <div class="form-group">
            <label for="cc-cvc" class="control-label">Card CVC </label>
            <input id="cc-cvc" name="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="•••" required>
        </div>

        <div class="form-group">
            <label for="numeric" class="control-label">Amount</label>
            <input id="numeric" name="numeric" type="tel" class="input-lg form-control" placeholder="$" data-numeric>
        </div>

        <button type="submit" class="btn btn-lg btn-primary">Submit</button>

        <h2 class="validation"></h2>
    </form>
</div>


<?php } else {
    //=======================================================================================
    //DISPLAY THE RECEIPT SECTION IF THE TRANSACTION IS PROCESSED SUCCESSFULLY
    //=======================================================================================
    ?>







<?php } ?>


</body>
</html>