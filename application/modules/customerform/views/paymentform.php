<?php
/**
 * Created by PhpStorm.
 * User: afrazer
 * Date: 10/4/2016
 * Time: 12:10 PM
 */

$page_status = 'payment';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $POSTED = TRUE;

    $page_status = 'reciept';

    $firstname = $_POST['firstname'];
    $middleinitial = $_POST['middleinitial'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $notes = $_POST['notes'];
    $cardtype = $_POST['cardtype'];
    $cc_number = $_POST['cc-number'];
    $cc_exp = $_POST['cc-exp'];
    $cc_cvc = $_POST['cc-cvc'];
    $numeric = $_POST['numeric'];

    //echo var_dump($_POST);

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, 'http://localhost:8888/ezolp/restapi/payment.json');
    curl_setopt($curl_handle, CURLAUTH_DIGEST);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_POST, 1);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
        'firstname' => $firstname,
        'middleinitial' => $middleinitial,
        'lastname' => $lastname,
        'email' => $email,
        'notes' => $notes,
        'cardtype' => $cardtype,
        'cc-number' => $cc_number,
        'cc-exp' => $cc_exp,
        'cc-cvc' => $cc_cvc,
        'numeric' => $numeric
    ));

    // Optional, delete this line if your API is open
    // $username = 'admin';
    // $password = '1234';
    //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
    define('USERNAME','admin');
    define('PASSWORD','1234');
    curl_setopt($curl_handle, CURLOPT_USERPWD, USERNAME . ':' . PASSWORD);

    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);

    $result = json_decode($buffer);


    $error = false;
    $error_message = "";

    if(isset($result->status) && $result->status == false)
    {
        $error = true;
        $error_message = 'You are Unauthorized to interact with the api';
    } else {
        //echo 'Something has gone wrong';
    }

//    echo "<br>";
    echo var_dump($buffer);
//    echo "<br>";
    echo var_dump($result);
//    echo "<br>";



}

?>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="<?php echo base_url('assets/js/paymentform/jquery-1.11.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/paymentform/jquery.payment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/paymentform/jquery.maskMoney.min.js'); ?>"></script>

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

    <?php if ($customer -> showlogo == '1') { ?>
        <center>
            <?php if(isset($customer -> logofile)){ ?>
                <img src="<?php echo base_url(); ?>/client/uploads/<?php echo $customer -> logofile; ?>" alt="" style="max-width: 200px; max-height: 200px; vertical-align: middle;">
            <?php } ?>
        </center>
    <?php } ?>

    <?php
    if ($customer -> showname == '1')
    {
        echo '<h1 style="text-align:center">';
            echo $customer -> customername;
        echo '</h1>';
    }
    ?>


    <?php
//        if ($error){
//            echo '<strong>$error_message</strong>';
//        }
    ?>

    <form novalidate autocomplete="on" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
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

        <?php if ($customer -> cf1enabled == 1) { ?>
        <div class="form-group">
            <label for="<?php echo $customer->cf1name; ?>" class="control-label"><?php echo $customer->cf1name . ($customer->cf1required == 1 ? ' *' : '') ?></label>
            <?php
                $data = array(
                    'id'            => 'cf1',
                    'name'          => 'cf1',
                    'class'         => 'input-lg form-control cf1',
                    'type'          => 'text',
                    'value'         => set_value('cf1'),
                    'placeholder'   => ($customer->cf1required == 1 ? 'Required' : $customer->cf1name),
                    'required'      => ($customer->cf1required == 1 ? 'required' : ''),
                    'data-parsley-required' => ($customer->cf1required == 1 ? 'true' : 'false')
                );

                echo form_input($data);
            ?>
        </div>
        <?php } ?>

        <?php if ($customer -> cf2enabled == 1) { ?>
        <div class="form-group">
            <label for="<?php echo $customer->cf2name; ?>" class="control-label"><?php echo $customer->cf2name . ($customer->cf2required == 1 ? ' *' : '') ?></label>
            <?php
                $data = array(
                    'id'            => 'cf2',
                    'name'          => 'cf2',
                    'class'         => 'input-lg form-control cf2',
                    'type'          => 'text',
                    'value'         => set_value('cf2'),
                    'placeholder'   => ($customer->cf2required == 1 ? 'Required' : $customer->cf2name),
                    'required'      => ($customer->cf2required == 1 ? 'required' : ''),
                    'data-parsley-required' => ($customer->cf2required == 1 ? 'true' : 'false')
                );

                echo form_input($data);
            ?>
        </div>
        <?php } ?>
        
        <?php if ($customer -> cf3enabled == 1) { ?>
        <div class="form-group">
            <label for="<?php echo $customer->cf3name; ?>" class="control-label"><?php echo $customer->cf3name . ($customer->cf3required == 1 ? ' *' : '') ?></label>
            <?php
                $data = array(
                    'id'            => 'cf3',
                    'name'          => 'cf3',
                    'class'         => 'input-lg form-control cf3',
                    'type'          => 'text',
                    'value'         => set_value('cf3'),
                    'placeholder'   => ($customer->cf3required == 1 ? 'Required' : $customer->cf3name),
                    'required'      => ($customer->cf3required == 1 ? 'required' : ''),
                    'data-parsley-required' => ($customer->cf3required == 1 ? 'true' : 'false')
                );

                echo form_input($data);
            ?>
        </div>
        <?php } ?>
        
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

    if ($result->result_processpayment->IsApproved == '1'){
        // TRANSACTION IS APPROVED
        ?>
            <div class="container">
                <h1>Payment Successfully Processed!</h1>
                <br><br>
                Payment Reciept
                </br>
                </br>
                <b>AuthCode #:</b> <?php echo $result->result_processpayment->AuthCode; ?>
                </br></br>
                <b>Date:</b> <?php echo $result->result_processpayment->UpdateDate; ?>
                </br></br>
                <b>Amount: $</b> <?php echo $numeric; ?>
                </br></br>
                <b>Card Ending: ************</b><?php echo substr($cc_number, -4); ?> (<?php echo $cardtype; ?>)
                </br></br>
                <b>Card Holder:</b> <?php echo $firstname. ' ' . $lastname; ?>
                </br></br>
            </div>
        <?php
    } else {
        // TRANSACTION IS NOT APPROVED
        ?>
            <div class="container">
                <h1>Payment Not Processed!</h1>
                <br>
                <b>There was an error processing your payment.</b>
                </br></br>
                <b>Message:</b> <?php echo ($error == true ? $error_message : ''); ?> <?php echo $result->result_processpayment->ResponseHTML; ?>
                </br></br>
            </div>
        <?php
    }

} ?>


</body>
</html>