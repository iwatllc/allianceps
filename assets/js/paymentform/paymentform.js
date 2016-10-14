/**
 * Created by afrazer on 10/5/2016.
 */

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
        uuid:       $('input[name=order_number]').val(),
        name:       $('input[name=name]').val(),
        email:      $('input[name=customerEmail]').val(),
        address1:   $('input[name=billingAddress1]').val(),
        address2:   $('input[name=billingAddress2]').val(),
        city:       $('input[name=billingCity]').val(),
        state:      $('input[name=billingState]').val(),
        zip:        $('input[name=billingZip]').val(),
        cf1:        $('input[name=ud1]').val(),
        cf2:        $('input[name=ud2]').val(),
        cf3:        $('input[name=ud3]').val(),
        amount:     $('input[name=amount]').val(),
        slug:       window.location.pathname.split( '/' )[3]
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
    $('input[name=amount]').toggleInputError(array['amount'].length == 0 ? true : false );

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
    if (!pass || array['name'].length == 0 || array['address1'].length == 0 || array['city'].length == 0 || array['state'].length == 0 || array['zip'].length == 0 || array['amount'].length == 0)
    {
        $(this).removeAttr('disabled').empty().prepend('Next');
        return;
    } else
    {
        $('input').toggleInputError( false ); // Reset form errors
    }

    var baseUrl = window.location .protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
    var pathToController = "/paymentform/paymentform/ajax_submit_form";

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

                // DO NOT DISABLE INPUTS - ONLY MAKE THEM READ ONLY
                // DISABLED INPUTS DO NOT GET SUBMITTED
                // $("input, select", "#client-info").prop('disabled', true);
                $("input", "#client-info").attr('readonly', true);

                // Show CC fields and submit button
                $('div#cc-info').show();

                // Populate hidden inputs
                $("input[name=order_number]").val(res.uuid);
                $("input[name=jp_request_hash]").val(res.jphash);
                $("input[name=jp_key]").val(res.jpkey);
                $("input[name=jp_tid]").val(res.jptid);
                $("input[name=trans_type]").val(res.jptranstype);

            }
        }
    });

});

// On back button press
$(document).on('click', 'button.btn-back', function(e){
    e.preventDefault();

    // Hide the CC fields
    $('div#cc-info').hide();

    // DO NOT DISABLE INPUTS - ONLY MAKE THEM READ ONLY
    // DISABLED INPUTS DO NOT GET SUBMITTED
    //$("input, select", "#client-info").prop('disabled', false);

    // Turn off read only fields
    $("input", "#client-info").attr('readonly', false);

    // Hide back button, show Next button
    $(this).attr('disabled', true).hide();
    $("button.btn-next").removeAttr('disabled').show();

    // Clear CC info except for order_number (in case we want to go back and edit client info)
    $("input", "#cc-info").not("input[name=order_number]").val('');

});

function fill_sample_inputs()
{
    $("input[name=name]").val('Wade Winston Wilson');
    $("input[name=customerEmail]").val('wadewwilson@gmail.com');
    $("input[name=billingAddress1]").val('3361 Boyington Dr');
    $("input[name=billingAddress2]").val('Suite 180');
    $("input[name=billingCity]").val('Carrollton');
    $("input[name=billingState]").val('TX');
    $("input[name=billingZip]").val('75006');
    $("input[name=ud1]").val('UD1 TAG');
    $("input[name=ud2]").val('UD2 TAG');
    $("input[name=ud3]").val('UD3 TAG');
    $("input[name=amount]").val('10.00');

    $(".btn-next").click();

    $("input[name=cardNum]").val('4111 1111 1111 1111');
    $("input[name=cc-exp]").val('12 / 17');
    $("input[name=cvv]").val('321');
}