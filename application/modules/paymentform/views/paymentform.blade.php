<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    @include('layouts/header')
    <meta charset="UTF-8">
    <!--
    @if(isset($data['customer'] -> logofile))
        <link rel="icon" href="{{ base_url() }}/client/uploads/{{ $data['customer'] -> logofile }}">
    @endif
    -->
    <link rel="icon" href="{{ base_url('/client/logo-small.png') }}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="{{ base_url() }}assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <script src="{{ base_url('assets/js/paymentform/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ base_url('assets/js/paymentform/jquery.payment.min.js') }}"></script>
    <script src="{{ base_url('assets/js/paymentform/jquery.maskMoney.min.js') }}"></script>
    <script src="{{ base_url('assets/js/paymentform/paymentform.js') }}"></script>
</head>
<body>
<div class="container">

    @if ($data['customer'] -> showlogo == '1')
        <center>
            @if($data['customer'] -> logofile != '')
                <img src="{{ base_url(); }}/client/uploads/{{ $data['customer'] -> logofile }}" alt="" style="max-width: 200px; max-height: 200px; vertical-align: middle;">
            @endif
        </center>
    @endif

    @if ($data['customer'] -> showname == '1')
        <h1 style="text-align:center">
            {{ $data['customer'] -> customername }}
        </h1>
    @endif

    @if ($data['customer'] -> headertext)
        {{ $data['customer'] -> headertext }}
        <br/>
    @endif

    <input type="button" value="Fill All Inputs (Testing)" onclick="fill_sample_inputs();" />

    <form novalidate id="submit-form" method="POST" action="{{ $data['jd_url'] }}">

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

            @if ($data['customer'] -> cf1enabled == 1)
            <div class="form-group">
                <label for="{{ $data['customer']->cf1name }}" class="control-label">{{ $data['customer']->cf1name . ($data['customer']->cf1required == 1 ? ' &#42;' : '') }}</label>
                {{ form_input($data['cf1']) }}
            </div>
            @endif

            @if ($data['customer'] -> cf2enabled == 1)
            <div class="form-group">
                <label for="{{ $data['customer']->cf2name; }}" class="control-label">{{ $data['customer']->cf2name . ($data['customer']->cf2required == 1 ? ' &#42;' : '') }}</label>
                {{ form_input($data['cf2']) }}
            </div>
            @endif

            @if ($data['customer'] -> cf3enabled == 1)
            <div class="form-group">
                <label for="{{ $data['customer']->cf3name }}" class="control-label">{{ $data['customer']->cf3name . ($data['customer']->cf3required == 1 ? ' &#42;' : '') }}</label>
                {{ form_input($data['cf3']) }}
            </div>
            @elseif ($data['customer'] -> allowach == 1)
                {{ form_hidden($data['cf3']) }}
            @endif

            <div class="form-group">
                <label for="numeric" class="control-label">Amount &#42;</label>
                <input id="numeric" name="amount" type="tel" class="input-lg form-control" placeholder="$" data-numeric>
            </div>

            <div class="form-group">
                <label for="type" class="control-label">Payment Type &#42;</label>
                <br/>
                @if ($data['customer'] -> allowcc && $data['customer'] -> allowach)
                    <input type="radio" name="paymenttype" value="cc" /> Credit Card<br/>
                    <input type="radio" name="paymenttype" value="ach" /> ACH
                @endif
                @if ($data['customer'] -> allowcc && !$data['customer'] -> allowach)
                    <input type="radio" name="paymenttype" value="cc" checked/> Credit Card
                @endif
                @if ($data['customer'] -> allowach && !$data['customer'] -> allowcc)
                    <input type="radio" name="paymenttype" value="ach" checked/> ACH
                @endif
            </div>

            @if ($data['customer'] -> cc_conveniencefee)
                <input type="hidden" name="cc_cfpercentage" value="{{ $data['customer'] -> cc_cfpercentage }}"/>
            @endif
            @if ($data['customer'] -> ach_conveniencefee)
                <input type="hidden" name="ach_cfpercentage" value="{{ $data['customer'] -> ach_cfpercentage }}"/>
            @endif

            <button type="button" class="btn btn-lg btn-primary btn-next">Next</button>
            <button type="button" class="btn btn-lg btn-primary btn-back" style="display:none;">Back</button>

            @if ($data['customer'] -> cc_conveniencefee)
                <span class="alert alert-info cc_cfinfo" style="display:none;">
                    <strong>NOTE: </strong>
                    If you pay by credit card, there will be a convenience fee of <strong>{{ $data['customer'] -> cc_cfpercentage }}</strong>&#37; applied to your payment.
                </span>
            @endif
            @if ($data['customer'] -> ach_conveniencefee)
                <span class="alert alert-info ach_cfinfo" style="display:none;">
                    <strong>NOTE: </strong>
                    If you pay by check, there will be a convenience fee of <strong>{{ $data['customer'] -> ach_cfpercentage }}</strong>&#37; applied to your payment.
                </span>
            @endif

        </div>

        <br/>

        <div class="row">
            <div id="order-info" class="col-md-5"></div>
        </div>

        <br/>

        <div id="cc-info" style="display:none;">
            <div class="form-group cc-group">
                <label for="cc-number" class="control-label">Card Number  <small class="text-muted"><span class="cc-brand"></span></small></label>
                <input id="cc-number" name="cardNum" type="tel" class="input-lg form-control cc-number" autocomplete="off" placeholder="•••• •••• •••• ••••" required>
            </div>
            <div class="form-group cc-group">
                <label for="cc-exp" class="control-label">Expiration Date </label>
                <input id="cc-exp" name="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="off" placeholder="•• / ••" required>
            </div>
            <div id="exp-info" style="display:none;">
                <input id="mo-exp" name="expMo" required>
                <input id="yr-exp" name="expYr" required>
            </div>
            <div class="form-group cc-group">
                <label for="cc-cvc" class="control-label">Card CVC </label>
                <input id="cc-cvc" name="cvv" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="•••" required>
            </div>
        </div>

        <div id="ach-info" style="display:none;">
            <!--<div class="form-group ach-group">
                <label for="account-holder" class="control-label">Account Holder</label>
                <input type="text" name="name" class="input-lg form-control" placeholder="Account Holder Name" maxlength="100" required />
            </div>-->
            <div class="form-group ach-group">
                <label for="account-number" class="control-label">Account Number</label>
                <input type="text" name="ddaDrop" class="input-lg form-control" placeholder="Account Number" maxlength="10" autocomplete="off" required />
            </div>
            <div class="form-group ach-group">
                <label for="confirm-account-number" class="control-label">Confirm Account Number</label>
                <input type="password" name="dda" class="input-lg form-control" placeholder="••••••••••"  maxlength="10" autocomplete="off" required />
            </div>
            <div class="form-group ach-group">
                <label for="routing-number" class="control-label">Routing Number</label>
                <input type="text" name="abaDrop" class="input-lg form-control" placeholder="Routing Number" maxlength="10" autocomplete="off" required />
            </div>
            <div class="form-group ach-group">
                <label for="confirm-routing-number" class="control-label">Confirm Routing Number</label>
                <input type="password" name="aba" class="input-lg form-control" placeholder="••••••••••"  maxlength="10" autocomplete="off" required />
            </div>
            <input type="hidden" name="achType" value="CHECKING" />
            <div class="form-group ach-group">
                <label for="check-number" class="control-label">Check Number</label>
                <input type="text" name="chkNumber" class="input-lg form-control" placeholder="Check Number" maxlength="5" required />
            </div>

            <div class="form-group">
                <input type="checkbox" name="ach-agreement" value="yes" />
                THE ABOVE ACCOUNT HOLDER AGREES TO THE TERMS AND CONDITIONS LISTED BELOW.
                <br/><br/>
                I AUTHORIZE THIS ELECTRONIC PAYMENT FROM THE FINANCIAL INSTITUTION ACCOUNT ABOVE IN THE AMOUNT
                LISTED ABOVE ALONG WITH ANY APPLICABLE CONVENIENCE FEE.
                <br/><br/>
                I ALSO UNDERSTAND THAT ANY PAYMENT MADE IS SUBJECT TO THE CURRENT TERMS AND CONDITIONS OF (THE
                COMPANY OR ENTITY WHICH PAYMENT IS BEING MADE) INCLUDING, BUT NOT LIMITED TO, THE BUSINESS DAY
                IN WHICH THIS PAYMENT WILL BE APPLIED TO MY ACCOUNT DEPENDING UPON THE DAY AND TIME THIS
                PAYMENT IS BEING MADE.
            </div>

        </div>

        <input type="hidden" name="merData0" maxlength="120" value="Payment Type"                               />
        <input type="hidden" name="merData1" maxlength="120" value="{{ $data['customer'] -> id }}"              />
        <input type="hidden" name="merData2" maxlength="120" value="{{ $data['customer'] -> customername }}"    />
        <input type="hidden" name="merData3" maxlength="120" value="{{ $data['customer'] -> logofile }}"        />
        <input type="hidden" name="merData4" maxlength="120" value="{{ $data['customer'] -> slugname }}"        />
        <input type="hidden" name="merData5" maxlength="120" value="{{ $data['customer'] -> showname }}"        />
        <input type="hidden" name="merData6" maxlength="120" value="{{ $data['customer'] -> showlogo }}"        />

        <input type="hidden"    name="cid"       value="{{ $data['cid'] }}" />
        <input type="hidden"    name="jp_tid"                               />
        <input type="hidden"    name="jp_key"                               />
        <input type="hidden"    name="jp_request_hash"                      />
        <input type="hidden"    name="order_number"                         />
        <input type="hidden"    name="trans_type"                           />

        <input type="hidden" name="retUrl"  value="{{ $data['retUrl'] }}" />
        <input type="hidden" name="decUrl"  value="{{ $data['decUrl'] }}" />
        <input type="hidden" name="dataUrl" value="{{ $data['dataUrl'] }}" />

        <div id="submit-button" style="display:none;">
            <button type="submit" class="btn btn-lg btn-primary" id="submit-btn">Submit</button>
            <span style="display:none;" id="ach-err">&nbsp;<font size="3" color="red">Account Holder must sign agreement before submitting.</font></span>
        </div>

        <h2 class="validation"></h2>
    </form>

    @if ($data['customer'] -> footertext)
        {{ $data['customer'] -> footertext }}
        <br/>
    @endif
</div>

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

            $('#submit-btn').attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i>&nbsp;Submit');

            $('#ach-err').hide();

            if ($("input[name=paymenttype]:checked").val() == 'cc')
            {
                var cardType = $.payment.cardType($('.cc-number').val());
                $('.cardtype').val(cardType);

                $('[data-numeric]').toggleInputError($('[data-numeric]').val().length == 0 ? true : false );
                $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
                $('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
                $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
                $('.cc-brand').text(cardType);
                $('.validation').removeClass('text-danger text-success');
                $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');

                if ($('.form-group, .cc-group').hasClass('has-error')) {
                    e.preventDefault();
                    $('#submit-btn').removeAttr('disabled').empty().prepend('Submit');
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
//                console.log(
//                    'name: '                    + $("input[name=name]").val() + '\n' +
//                    'cardNum: '                 + $("input[name=cardNum]").val() + '\n' +
//                    'expMo: '                   + $("input[name=expMo]").val() + '\n' +
//                    'expYr: '                   + $("input[name=expYr]").val() + '\n' +
//                    'cvv: '                     + $("input[name=cvv]").val() + '\n' +
//                    'amount: '                  + $("input[name=amount]").val() + '\n' +
//                    'email: '                   + $("input[name=customerEmail]").val() + '\n' +
//                    'billingAddress1: '         + $("input[name=billingAddress1]").val() + '\n' +
//                    'billingAddress2: '         + $("input[name=billingAddress2]").val() + '\n' +
//                    'billingCity: '             + $("input[name=billingCity]").val() + '\n' +
//                    'billingState: '            + $("input[name=billingState]").val() + '\n' +
//                    'billingZip: '              + $("input[name=billingZip]").val() + '\n' +
//                    'billingCountry: '          + $("input[name=billingCountry]").val() + '\n' +
//                    '\n' +
//                    'cid: '                     + $("input[name=cid]").val() + '\n' +
//                    'jp_tid: '                  + $("input[name=jp_tid]").val() + '\n' +
//                    'jp_key: '                  + $("input[name=jp_key]").val() + '\n' +
//                    'jp_request_hash: '         + $("input[name=jp_request_hash]").val() + '\n' +
//                    'order_number: '            + $("input[name=order_number]").val() + '\n' +
//                    'trans_type: '              + $("input[name=trans_type]").val() + '\n' +
//                    'UD1: '                     + $("input[name=ud1]").val() + '\n' +
//                    'UD2: '                     + $("input[name=ud2]").val() + '\n' +
//                    'UD3: '                     + $("input[name=ud3]").val() + '\n' +
//                    'retURL: '                  + $("input[name=retUrl]").val() + '\n' +
//                    'decURL: '                  + $("input[name=decUrl]").val() + '\n' +
//                    'dataURL: '                 + $("input[name=dataUrl]").val() + '\n'
//                );

            } else if ($("input[name=paymenttype]:checked").val() == 'ach')
            {
                // Form validation for ACH form
                $('input[name=accountName]').toggleInputError($('input[name=accountName]').val().length == 0 ? true : false );
                $('input[name=abaDrop]').toggleInputError($('input[name=abaDrop]').val().length < 8 ? true : false );
                $('input[name=aba]').toggleInputError($('input[name=aba]').val().length < 8 ? true : false );
                $('input[name=ddaDrop]').toggleInputError($('input[name=ddaDrop]').val().length < 4 ? true : false );
                $('input[name=dda]').toggleInputError($('input[name=dda]').val().length < 4 ? true : false );
                $('input[name=chkNumber]').toggleInputError($('input[name=chkNumber]').val().length == 0 ? true : false );

                if ($('.form-group, .ach-group').hasClass('has-error')) {
                    e.preventDefault();
                    $('#submit-btn').removeAttr('disabled').empty().prepend('Submit');
                    return;
                }

                // If purchase agreement not checked, do not proceed
                if (!$("input[type=checkbox][name=ach-agreement]").is(':checked'))
                {
                    $('#ach-err').show();
                    e.preventDefault();
                    $('#submit-btn').removeAttr('disabled').empty().prepend('Submit');
                    return;
                }

                // Disable CC inputs
                $("#cc-info :input").attr("disabled", true);

                // Remove decimals from amount field
                $("input[name=amount]").val($("input[name=amount]").val().replace(".", ""));

            }
        });
    </script>

</body>
</html>