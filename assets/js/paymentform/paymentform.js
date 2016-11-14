/**
 * Created by afrazer on 10/5/2016.
 */

var baseUrl = window.location .protocol + "//" + window.location.host;
var slug = window.location.pathname.split( '/' )[1];


$( document ).ready(function() {
    displaycfmessage();
});

// Display ACH/CC convenience fee message
$(document).on("change", "[type=radio][name=paymenttype]", function(e) {
    e.preventDefault();
    displaycfmessage();
});

function displaycfmessage()
{
    var paymenttype = $('input[type=radio][name=paymenttype]:checked');

    if (paymenttype.val() == 'cc')
    {
        $('span.cc_cfinfo').show();
        $('span.ach_cfinfo').hide();
    } else if (paymenttype.val() == 'ach')
    {
        $('span.ach_cfinfo').show();
        $('span.cc_cfinfo').hide();
    } else
    {
        $('span.cc_cfinfo').hide();
        $('span.ach_cfinfo').hide();
    }
}

$.fn.toggleInputError = function(erred) {
    this.parent('.form-group').toggleClass('has-error', erred);
    return this;
};

// Next button press
$(document).on('click', 'button.btn-next', function(e){
    e.preventDefault();

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i>&nbsp;Next');

    // Collect all of the field values
    var array = {
        uuid:           $('input[name=order_number]').val(),
        name:           $('input[name=name]').val(),
        email:          $('input[name=customerEmail]').val(),
        address1:       $('input[name=billingAddress1]').val(),
        address2:       $('input[name=billingAddress2]').val(),
        city:           $('input[name=billingCity]').val(),
        state:          $('input[name=billingState]').val(),
        zip:            $('input[name=billingZip]').val(),
        cf1:            $('input[name=ud1]').val(),
        cf2:            $('input[name=ud2]').val(),
        cf3:            $('input[name=ud3]').val(),
        amount:         parseFloat($('input[name=amount]').val().replace(/,/g, '')),
        paymenttype:    $("input[name=paymenttype]:checked").val(),
        slug:           slug
    };

    var cf1required = $('input[name=ud1]').data('parsley-required');
    var cf2required = $('input[name=ud2]').data('parsley-required');
    var cf3required = $('input[name=ud3]').data('parsley-required');

    // Display errors if there are any
    $('input[name=name]').toggleInputError(array['name'].length == 0 ? true : false );
    $('input[name=billingAddress1]').toggleInputError(array['address1'].length == 0 ? true : false );
    $('input[name=billingCity]').toggleInputError(array['city'].length == 0 ? true : false );
    $('input[name=billingState]').toggleInputError(array['state'].length == 0 ? true : false );
    $('input[name=billingZip]').toggleInputError(array['zip'].length == 0 ? true : false );
    $('input[name=amount]').toggleInputError($('input[name=amount]').val().length == 0 ? true : false );
    $('input[name=paymenttype]').toggleInputError(!array['paymenttype'] ? true : false );

    var pass = true;
    if (cf1required)
    {
        if (array['cf1'].length == 0)
        {
            $('input[name=ud1]').toggleInputError(array['cf1'].length == 0 ? true : false );
            pass = false;
        }
    }
    if (cf2required)
    {
        if (array['cf2'].length == 0)
        {
            $('input[name=ud2]').toggleInputError(array['cf2'].length == 0 ? true : false );
            pass = false;
        }
    }
    if (cf3required)
    {
        if (array['cf3'].length == 0)
        {
            $('input[name=ud3]').toggleInputError(array['cf3'].length == 0 ? true : false );
            pass = false;
        }
    }

    // If errors, do not proceed to next step
    if (
        !pass
        || array['name'].length == 0
        || array['address1'].length == 0
        || array['city'].length == 0
        || array['state'].length == 0
        || array['zip'].length == 0
        || $('input[name=amount]').val().length == 0
        || !array['paymenttype']
    )
    {
        $(this).removeAttr('disabled').empty().prepend('Next');
        return;
    } else
    {
        $('input').toggleInputError( false ); // Reset form errors
    }

    // Apply convenience fee if credit card
    if (array['paymenttype'] == 'cc' && $('input[name=cc_cfpercentage]').val())
    {
        array['cfpercentage'] = $('input[name=cc_cfpercentage]').val();
    }
    if (array['paymenttype'] == 'ach' && $('input[name=ach_cfpercentage]').val())
    {
        array['cfpercentage'] = $('input[name=ach_cfpercentage]').val();
    }

    var pathToController = "/paymentform/ajax_submit_form";

    jQuery.ajax({
        type: "POST",
        url: baseUrl + pathToController,
        dataType: 'json',
        data: array,
        success: function(res) {
            if (res) {

                // Replace button with Back button
                $("button.btn-next").attr('disabled', true).empty().prepend('Next').hide();
                $("button.btn-back").removeAttr('disabled').show();

                // Calculates the convenience fee and applies it to input
                $("input[name=amount]").val(res.amount).focus();

                // DO NOT DISABLE INPUTS - ONLY MAKE THEM READ ONLY
                // DISABLED INPUTS DO NOT GET SUBMITTED
                // $("input, select", "#client-info").prop('disabled', true);
                $("input", "#client-info").attr('readonly', true);

                // Disable radio buttons for CC and ACH
                $("input[type=radio]", "#client-info").prop('disabled', true);

                if (array['paymenttype'] == 'cc')
                {
                    // Show CC fields and submit button
                    $('div#cc-info').show();
                    $('div#submit-button').show();

                    // Enable CC fields and disable ACH fields
                    // $("input", "#cc-info").prop('disabled', false);
                    // $("input", "#ach-info").prop('disabled', true);

                } else if (array['paymenttype'] == 'ach')
                {
                    // Show ACH fields and submit button
                    $('div#ach-info').show();
                    $('div#submit-button').show();

                    // Enable ACH fields and disable CC fields
                    // $("input", "#cc-info").prop('disabled', true);
                    // $("input", "#ach-info").prop('disabled', false);
                }

                // Populate hidden inputs
                $("input[name=order_number]").val(res.uuid);
                $("input[name=jp_request_hash]").val(res.jphash);
                $("input[name=jp_key]").val(res.jpkey);
                $("input[name=jp_tid]").val(res.jptid);
                $("input[name=trans_type]").val(res.jptranstype);
                $("input[name=merData0]").val(res.payment_type);
                
                // Show order summary table
                $('div#order-info').html(res.table);

            }
        }
    });

});

// Back button press
$(document).on('click', 'button.btn-back', function(e){
    e.preventDefault();

    var uuid = $("input[name=order_number]").val();

    var pathToController = "/paymentform/paymentform/ajax_get_form_submission_amount";

    $('#ach-err').hide();

    // Query the database for the amount and put in amount field
    $.post(baseUrl + pathToController, { uuid:uuid }, function(amount){

        if ($("input[name=paymenttype]:checked").val() == 'cc')
        {
            $("input[name=amount]").val(amount).focus().blur();
        }

        // Hide the CC fields
        $('div#cc-info').hide();
        $('div#ach-info').hide();
        $('div#submit-button').hide();

        // DO NOT DISABLE INPUTS - ONLY MAKE THEM READ ONLY
        // DISABLED INPUTS DO NOT GET SUBMITTED
        //$("input, select", "#client-info").prop('disabled', false);

        // Turn off read only fields
        $("input", "#client-info").attr('readonly', false);

        // Enable radio buttons for CC and ACH
        $("input[type=radio]", "#client-info").prop('disabled', false);
    });

    // Hide back button, show Next button
    $(this).attr('disabled', true).hide();
    $("button.btn-next").removeAttr('disabled').show();

    // // Clear CC and ACH info
    $("input", "#cc-info, #ach-info").val('');

    // Destroy order summary table
    $('div#order-info').html('');

});

// Confirm dda/aba fields match
$(document).on("keyup", "input[name=dda], input[name=aba], input[name=ddaDrop], input[name=abaDrop]", function(e) {
    e.preventDefault();

    var ddaDrop = $("input[name=ddaDrop]").val();
    var dda     = $("input[name=dda]").val();
    var abaDrop = $("input[name=abaDrop]").val();
    var aba     = $("input[name=aba]").val();

    if (ddaDrop != dda)
    {
        $('input[name=ddaDrop]').toggleInputError( true );
        $('input[name=dda]').toggleInputError( true );
        // $("#divCheckPasswordMatch").html("Passwords do not match!");
    } else
    {
        $('input[name=ddaDrop]').toggleInputError( false );
        $('input[name=dda]').toggleInputError( false );
    }

    if (abaDrop != aba)
    {
        $('input[name=abaDrop]').toggleInputError( true );
        $('input[name=aba]').toggleInputError( true );
        // $("#divCheckPasswordMatch").html("Passwords do not match!");
    } else
    {
        $('input[name=abaDrop]').toggleInputError( false );
        $('input[name=aba]').toggleInputError( false );
    }
});

// Check ACH terms and conditions checkbox
$(document).on("change", "[type=checkbox][name=ach-agreement]", function(e) {
    e.preventDefault();

    if(this.checked)
    {
        // Create and add date/time stamp to ud3 field
        var currDatetime = new Date().toISOString().slice(0, 19).replace('T', ' ');
        $("input[name=ud3]").val(currDatetime);
    } else
    {
        // Empty ud3 field
        $("input[name=ud3]").val('');
    }
});

function fill_sample_inputs()
{
    $("input[name=name]").val('John Q. Public');
    $("input[name=customerEmail]").val('aarfrazer@gmail.com');
    $("input[name=billingAddress1]").val('3361 Boyington Dr');
    $("input[name=billingAddress2]").val('Suite 180');
    $("input[name=billingCity]").val('Carrollton');
    $("input[name=billingState]").val('TX');
    $("input[name=billingZip]").val('75006');
    $("input[name=ud1]").val('UD1 TAG');
    $("input[name=ud2]").val('UD2 TAG');
    // $("input[name=ud3]").val('UD3 TAG');
    $("input[name=amount]").val('10.00');
    $("input:radio[name=paymenttype][value='ach']").prop("checked",true);

    $(".btn-next").click();

    // Credit card sample inputs
    // $("input[name=cardNum]").val('4111 1111 1111 1111');
    // $("input[name=cc-exp]").val('12 / 17');
    // $("input[name=cvv]").val('321');

    // ACH sample inputs
    $("input[name=ddaDrop]").val('123411');
    $("input[name=dda]").val('123411');
    $("input[name=abaDrop]").val('122000496');
    $("input[name=aba]").val('122000496');
    $("input[name=chkNumber]").val('234');
}