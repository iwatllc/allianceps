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

    <?php $this->load->view('header'); ?>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <script src="<?php echo base_url('assets/js/paymentform/jquery-1.11.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/paymentform/jquery.payment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/paymentform/jquery.maskMoney.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/paymentform/paymentform.js'); ?>"></script>

<?php if($page_status == 'payment'){
    //=======================================================================================
    // DISPLAY THE PAYMENT FORM
    //=======================================================================================
?>

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

    <?php if ($customer -> showname == '1') { ?>
        <h1 style="text-align:center">
            <?php echo $customer -> customername; ?>
        </h1>
    <?php } ?>

    <input type="button" value="Fill All Inputs (Testing)" onclick="fill_sample_inputs();" />

    <form novalidate id="submit-form" method="POST" action="<?php echo $jd_url; ?>">

        <div id="client-info">
            <div class="form-group">
                <label for="name" class="control-label">Name &#42;</label>
                <input name="name" type="text" class="input-lg form-control" autocomplete="name" placeholder="Card Holder Name" maxlength ="100" required>
            </div>

            <div class="form-group">
                <label for="email" class="control-label">Email </label>
                <input name="customerEmail" type="text" class="input-lg form-control" autocomplete="email" placeholder="Email" maxlength ="255" required>
            </div>

            <div class="form-group">
                <label for="address1" class="control-label">Billing Address &#42;</label>
                <input name="billingAddress1" type="text" class="input-lg form-control" autocomplete="address1" placeholder="Billing Address 1" maxlength ="100" required>
            </div>

            <div class="form-group">
                <label for="address2" class="control-label">Billing Address (2)</label>
                <input name="billingAddress2" type="text" class="input-lg form-control" autocomplete="address2" placeholder="Billing Address 2" maxlength ="100" required>
            </div>

            <div class="form-group">
                <label for="city" class="control-label">City &#42;</label>
                <input name="billingCity" type="text" class="input-lg form-control" autocomplete="city" placeholder="City" maxlength ="50" required>
            </div>

            <div class="form-group">
                <label for="state" class="control-label">State &#42;</label>
                <input name="billingState" type="text" class="input-lg form-control" autocomplete="state" placeholder="State" maxlength ="2" required>
            </div>

            <div class="form-group">
                <label for="zip" class="control-label">Zip &#42;</label>
                <input name="billingZip" type="text" class="input-lg form-control" autocomplete="zip" placeholder="Zip" maxlength="11" required>
            </div>

            <input type="hidden" name="billingCountry" value="USA">

            <?php if ($customer -> cf1enabled == 1) { ?>
            <div class="form-group">
                <label for="<?php echo $customer->cf1name; ?>" class="control-label"><?php echo $customer->cf1name . ($customer->cf1required == 1 ? ' &#42;' : '') ?></label>
                <?php
                    $data = array(
                        'name'          => 'ud1',
                        'class'         => 'input-lg form-control',
                        'type'          => 'text',
                        'value'         => set_value('cf1'),
                        'placeholder'   => ($customer->cf1required == 1 ? 'Required' : $customer->cf1name),
                        'maxlength'     => '50',
                        'required'      => ($customer->cf1required == 1 ? 'required' : ''),
                        'data-parsley-required' => ($customer->cf1required == 1 ? 'true' : 'false')
                    );

                    echo form_input($data);
                ?>
            </div>
            <?php } ?>

            <?php if ($customer -> cf2enabled == 1) { ?>
            <div class="form-group">
                <label for="<?php echo $customer->cf2name; ?>" class="control-label"><?php echo $customer->cf2name . ($customer->cf2required == 1 ? ' &#42;' : '') ?></label>
                <?php
                    $data = array(
                        'name'          => 'ud2',
                        'class'         => 'input-lg form-control',
                        'type'          => 'text',
                        'value'         => set_value('cf2'),
                        'placeholder'   => ($customer->cf2required == 1 ? 'Required' : $customer->cf2name),
                        'maxlength'     => '50',
                        'required'      => ($customer->cf2required == 1 ? 'required' : ''),
                        'data-parsley-required' => ($customer->cf2required == 1 ? 'true' : 'false')
                    );

                    echo form_input($data);
                ?>
            </div>
            <?php } ?>

            <?php if ($customer -> cf3enabled == 1) { ?>
            <div class="form-group">
                <label for="<?php echo $customer->cf3name; ?>" class="control-label"><?php echo $customer->cf3name . ($customer->cf3required == 1 ? ' &#42;' : '') ?></label>
                <?php
                    $data = array(
                        'name'          => 'ud3',
                        'class'         => 'input-lg form-control',
                        'type'          => 'text',
                        'value'         => set_value('cf3'),
                        'placeholder'   => ($customer->cf3required == 1 ? 'Required' : $customer->cf3name),
                        'maxlength'     => '50',
                        'required'      => ($customer->cf3required == 1 ? 'required' : ''),
                        'data-parsley-required' => ($customer->cf3required == 1 ? 'true' : 'false')
                    );

                    echo form_input($data);
                ?>
            </div>
            <?php } ?>
            
            <div class="form-group">
                <label for="numeric" class="control-label">Amount &#42;</label>
                <input id="numeric" name="amount" type="tel" class="input-lg form-control" placeholder="$" data-numeric>
            </div>

            <button type="button" class="btn btn-lg btn-primary btn-next">Next</button>
            <button type="button" class="btn btn-lg btn-primary btn-back" style="display:none;">Back</button>

        </div>

        <br/><br/>

        <div id="cc-info" style="display:none;">
            <div class="form-group">
                <label for="cc-number" class="control-label">Card Number  <small class="text-muted">[<span class="cc-brand"></span>]</small></label>
                <input id="cc-number" name="cardNum" type="tel" class="input-lg form-control cc-number" autocomplete="off" placeholder="•••• •••• •••• ••••" required>
            </div>

            <div class="form-group">
                <label for="cc-exp" class="control-label">Card Expiry </label>
                <input id="cc-exp" name="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="off" placeholder="•• / ••" required>
            </div>

            <div id="exp-info" style="display:none;">
                <input id="mo-exp" name="expMo" required>
                <input id="yr-exp" name="expYr" required>
            </div>

            <div class="form-group">
                <label for="cc-cvc" class="control-label">Card CVC </label>
                <input id="cc-cvc" name="cvv" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="•••" required>
            </div>

            <input type="hidden"    name="cid"              value="<?php echo $cid; ?>" />
            <input type="hidden"    name="jp_tid"                                       />
            <input type="hidden"    name="jp_key"                                       />
            <input type="hidden"    name="jp_request_hash"                              />
            <input type="hidden"    name="order_number"                                 />
            <input type="hidden"    name="trans_type"                                   />

            <input type="hidden" name="retUrl"  value="<?php echo $ret_url; ?>" />
            <input type="hidden" name="decUrl"  value="<?php echo $dec_url; ?>" />
            <input type="hidden" name="dataUrl" value="<?php echo $data_url; ?>" />

            <button type="submit" class="btn btn-lg btn-primary" id="submit-btn">Submit</button>
        </div>

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

    <script type="text/javascript">
        // Credit card validation
        $('[data-numeric]').maskMoney();
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
        
            $('[data-numeric]').toggleInputError($('[data-numeric]').val().length == 0 ? true : false );
            $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
            $('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
            $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
            $('.cc-brand').text(cardType);
            $('.validation').removeClass('text-danger text-success');
            $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');
        
            if ($('.form-group').hasClass('has-error')) {
                e.preventDefault();
                return;
            }
        
            $("input[name=cardNum]").val($("input[name=cardNum]").val().replace(/\s/g, ''));
        
            // Split card expiry fields into two hidden inputs (month and year)
            var expire_date = $('.cc-exp').val();
            var splitdate = expire_date.split(' / ');
            var expMo = splitdate[0];
            var expYr = splitdate[1];
            if (expYr.length > 2) {
                expYr = expYr.substring(2);
            }
            // Fill inputs with values
            $('#mo-exp').val(expMo);
            $('#yr-exp').val(expYr);
        
            // Print all inputs
            console.log(
                'fName: '                   + $("input[name=fName]").val() + '\n' +
                'lName: '                   + $("input[name=lName]").val() + '\n' +
                'cardNum: '                 + $("input[name=cardNum]").val() + '\n' +
                'expMo: '                   + $("input[name=expMo]").val() + '\n' +
                'expYr: '                   + $("input[name=expYr]").val() + '\n' +
                'cvv: '                     + $("input[name=cvv]").val() + '\n' +
                'amount: '                  + $("input[name=amount]").val() + '\n' +
                'email: '                   + $("input[name=customerEmail]").val() + '\n' +
                'billingAddress1: '         + $("input[name=billingAddress1]").val() + '\n' +
                'billingAddress2: '         + $("input[name=billingAddress2]").val() + '\n' +
                'billingCity: '             + $("input[name=billingCity]").val() + '\n' +
                'billingState: '            + $("select[name=billingState]").val() + '\n' +
                'billingZip: '              + $("input[name=billingZip]").val() + '\n' +
                'billingCountry: '          + $("input[name=billingCountry]").val() + '\n' +
                '\n' +
                'cid: '                     + $("input[name=cid]").val() + '\n' +
                'jp_tid: '                  + $("input[name=jp_tid]").val() + '\n' +
                'jp_key: '                  + $("input[name=jp_key]").val() + '\n' +
                'jp_request_hash: '         + $("input[name=jp_request_hash]").val() + '\n' +
                'order_number: '            + $("input[name=order_number]").val() + '\n' +
                'trans_type: '              + $("input[name=trans_type]").val() + '\n' +
                'UD1: '                     + $("input[name=ud1]").val() + '\n' +
                'UD2: '                     + $("input[name=ud2]").val() + '\n' +
                'UD3: '                     + $("input[name=ud3]").val() + '\n' +
                'retURL: '                  + $("input[name=retUrl]").val() + '\n' +
                'decURL: '                  + $("input[name=decUrl]").val() + '\n' +
                'dataURL: '                 + $("input[name=dataUrl]").val() + '\n'
            );
        
        //            e.preventDefault();
        });
    </script>

</body>
</html>