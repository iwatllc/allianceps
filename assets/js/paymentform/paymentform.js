/**
 * Created by afrazer on 10/5/2016.
 */

$.fn.toggleInputError = function(erred) {
    this.parent('.form-group').toggleClass('has-error', erred);
    return this;
};

// Process client information
$(document).on('click', 'button.btn-next', function(e){
    e.preventDefault();

    var baseUrl = window.location .protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i>&nbsp;Next');

    // Collect all of the field values
    var array = {
        uuid:       $('input[id=uuid]').val(),
        firstname:  $('.firstname').val(),
        middleinit: $('.middleinitial').val(),
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
        // notes:      $('.notes').val(),
        amount:     $('[data-numeric]').val(),
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

                // Populate hidden input with UUID
                $("input[id=uuid]").val(res.uuid);

                // Disable inputs
                $("input, select", "#client-info").prop('disabled', true);

                // Show CC fields and submit button
                $('div#cc-info').show();
            }
        }
    });

});

// On back button press
$(document).on('click', 'button.btn-back', function(e){
    e.preventDefault();

    // Hide the CC fields
    $('div#cc-info').hide();

    // Enable client fields
    $("input, select", "#client-info").prop('disabled', false);

    // Hide back button, show Next button
    $(this).attr('disabled', true).hide();
    $("button.btn-next").removeAttr('disabled').show();

    // Clear CC info
    $("input", "#cc-info").val('');

});
