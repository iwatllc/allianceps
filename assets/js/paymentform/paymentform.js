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
    
    var baseUrl = window.location .protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i>&nbsp;Next');

    // Collect all of the field values
    var array = {
        uuid:       $('input[name=order_number]').val(),
        firstname:  $('.firstname').val(),
        lastname:   $('.lastname').val(),
        email:      $('.email').val(),
        address1:   $('.address1').val(),
        address2:   $('.address2').val(),
        city:       $('.city').val(),
        state:      $('.state').val(),
        zip:        $('.zip').val(),
        cf1:        $('.cf1').val(),
        cf2:        $('.cf2').val(),
        cf3:        $('.cf3').val(),
        amount:     $('input[name=amount]').val(),
        slug:       window.location.pathname.split( '/' )[3]
    };

    var cf1required = $('.cf1').data('parsley-required');
    var cf2required = $('.cf2').data('parsley-required');
    var cf3required = $('.cf3').data('parsley-required');

    // Display any errors
    $('.firstname').toggleInputError(array['firstname'].length == 0 ? true : false );
    $('.lastname').toggleInputError(array['lastname'].length == 0 ? true : false );
    $('.address1').toggleInputError(array['address1'].length == 0 ? true : false );
    $('.city').toggleInputError(array['city'].length == 0 ? true : false );
    $('.state').toggleInputError(array['state'].length == 0 ? true : false );
    $('.zip').toggleInputError(array['zip'].length == 0 ? true : false );

    var pass = true;
    if (cf1required)
    {
        if (array['cf1'].length == 0)
        {
            $('.cf1').toggleInputError(array['cf1'].length == 0 ? true : false );
            pass = false;
        }
    }
    if (cf2required)
    {
        if (array['cf2'].length == 0)
        {
            $('.cf2').toggleInputError(array['cf2'].length == 0 ? true : false );
            pass = false;
        }
    }
    if (cf3required)
    {
        if (array['cf3'].length == 0)
        {
            $('.cf3').toggleInputError(array['cf3'].length == 0 ? true : false );
            pass = false;
        }
    }

    // If errors, do not proceed to next step
    if (!pass || array['firstname'].length == 0 || array['lastname'].length == 0 || array['address1'].length == 0 || array['city'].length == 0 || array['state'].length == 0 || array['zip'].length == 0)
    {
        $(this).removeAttr('disabled').empty().prepend('Next');
        return;
    } else
    {
        $('input').toggleInputError( false ); // Reset form errors
    }

    var pathToController = "/customerform/customerform/ajax_submit_customer_info";

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
                $("input, select", "#client-info").attr('readonly', true);

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
    $("input, select", "#client-info").attr('readonly', false);

    // Hide back button, show Next button
    $(this).attr('disabled', true).hide();
    $("button.btn-next").removeAttr('disabled').show();

    // Clear CC info
    $("input", "#cc-info").val('');

});


function fill_sample_inputs()
{
    $("input[name=fName]").val('Wade');
    $("input[name=lName]").val('Wilson');
    $("input[name=customerEmail]").val('wadewwilson@gmail.com');
    $("input[name=billingAddress1]").val('3361 Boyington Dr');
    $("input[name=billingAddress2]").val('Suite 180');
    $("input[name=billingCity]").val('Carrollton');
    $('select[name=billingState] option[value="TX"]').prop('selected', 'selected').change();
    $("input[name=billingZip]").val('75006');
    $("input[name=ud1]").val('UD1 TAG');
    $("input[name=ud2]").val('UD2 TAG');
    $("input[name=ud3]").val('UD3 TAG');
    $("input[name=amount]").val('10.00');

    $(".btn-next").click();

    $("input[name=cardNum]").val('4111 1111 1111 1111');
    $("input[name=cc-exp]").val('12 / 13');
    $("input[name=cvv]").val('321');
}