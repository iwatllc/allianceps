/**
 * Created by iWAT on 9/24/2016.
 */

var baseUrl;
if (window.location.host == 'localhost' || 'www.onebzb.com') // local environment
{
    baseUrl = window.location .protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
} else // live environment
{
    baseUrl = window.location .protocol + "//" + window.location.host;
}

// Open Add Customer popup
$(document).on('click', '.addcustomer-btn', function(e){

    var pathToController = "/customer/customer/load_add_customer";

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Add Customer');

    $.post(baseUrl + pathToController, {  }, function(response){
    
        $("#modal-dialog").html(response).dialog({
            dialogClass: 'fixed-dialog',
            modal: true,
            height: 'auto',
            width: $(window).width()-250,
            position: ['middle',75],
            title: 'Add New Customer',
            open: function (event, ui) {
                $('#modal-dialog').css('overflow', 'hidden');
            },
            show: {
                effect: "drop",
                complete: function() {
                    setTimeout(function(){
                    },50);
                }
            }
        }).dialog("widget")
          .next(".ui-widget-overlay")
          .css("background", "#000000");
    
        // Replace button with original glyphicon
        $(".addcustomer-btn").removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-plus"></span> Add Customer');
    
    });
    
});

// Close Add Customer popup
$(document).on('click', '.addcustomer-cancel', function(e){
    $('#modal-dialog').dialog('close'); // close the form
});

// Add Customer
$(document).on('click', '.addcustomer-submit', function(e){

    $("span[id*='-err']").html(''); // remove previous error messages
    $("div[id*='-field']").removeClass('has-error'); // remove red field

    // Get inputs
    var array = {
        customername:       $('input[name=customername]').val(),
        slug:               $('input[name=slug]').val(),
        showname:           $('input[name=showname]:checked').val(),
        showlogo:           $('input[name=showlogo]:checked').val(),
        cf1enabled:         $('input[name=cf1enabled]:checked').val(),
        cf2enabled:         $('input[name=cf2enabled]:checked').val(),
        cf3enabled:         $('input[name=cf3enabled]:checked').val(),
        cf1required:        $('input[name=cf1required]:checked').val(),
        cf2required:        $('input[name=cf2required]:checked').val(),
        cf3required:        $('input[name=cf3required]:checked').val(),
        cf1name:            $('input[name=cf1name]').val(),
        cf2name:            $('input[name=cf2name]').val(),
        cf3name:            $('input[name=cf3name]').val(),
        allowach:           $('input[name=allowach]:checked').val(),
        allowcc:            $('input[name=allowcc]:checked').val(),
        emailcustomer:      $('input[name=emailcustomer]:checked').val(),
        emailmerchant:      $('input[name=emailmerchant]:checked').val(),
        emailaddresses:     $('input[name=emails]').val(),
        tid:                $('input[name=tid]').val(),
        key:                $('input[name=key]').val(),
        token:              $('input[name=token]').val(),
        cc_conveniencefee:  $('input[name=cc_conveniencefee]:checked').val(),
        cc_cfpercentage:    $('input[name=cc_cfpercentage]').val(),
        ach_conveniencefee: $('input[name=ach_conveniencefee]:checked').val(),
        ach_cfpercentage:   $('input[name=ach_cfpercentage]').val()
    };

    var pathToController = "/customer/customer/ajax_add_customer";

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Adding Customer');

    jQuery.ajax({
    type: "POST",
    url: baseUrl + pathToController,
    dataType: 'json',
    data: array,
    success: function(res) {
        if (res) {// Show Entered Value
            
            // Replace button with original glyphicon
            $('.addcustomer-submit').removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-save"></span> Add Customer');

            var errors = false;
            for (var key in res)
            {
                if (key.substring(0, 'error_'.length) === 'error_') // holds the error message
                {
                    var field = key.replace("error_", "");
                    if (res[key])
                    {
                        $("span#" + field + "-err").append(res[key]); // display error message under field
                        $("div#" + field + "-field").addClass('has-error'); // make field red
                    }
                    errors = true;
                }
            }

            if (!errors)
            {
                $('#modal-dialog').dialog('close'); // close the form
            } else
            {
                return;
            }

            // Reload the page
            location.reload();
        }
    }
    });
});


// Open Edit Customer popup
$(document).on('click', '.editcustomer-btn', function(e){

    var id = $(this).data('id');
    
    var pathToController = "/customer/customer/load_edit_customer";

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Edit');

    $.post(baseUrl + pathToController, { id:id }, function(response){

        $("#modal-dialog").html(response).dialog({
            dialogClass: 'fixed-dialog',
            modal: true,
            height: 'auto',
            width: $(window).width()-250,
            title: 'Update Customer',
            position: ['middle',75],
            open: function (event, ui) {
                $('#modal-dialog').css('overflow', 'hidden');
            },
            show: {
                effect: "drop",
                complete: function() {
                    setTimeout(function(){
                    },50);
                }
            }
        }).dialog("widget")
          .next(".ui-widget-overlay")
          .css("background", "#000000");

        // Replace button with original glyphicon
        $(".editcustomer-btn").removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-pencil"></span> Edit');

    });

});

// Close Edit Customer popup
$(document).on('click', '.editcustomer-cancel', function(e){
    $('#modal-dialog').dialog('close'); // close the form
});

// Update Customer
$(document).on('click', '.editcustomer-submit', function(e){

    $("span[id*='-err']").html(''); // remove previous error messages
    $("div[id*='-field']").removeClass('has-error'); // remove red field

    // Get inputs
    var array = {
        customerid:         $('input[name=customerid]').val(),
        customername:       $('input[name=customername]').val(),
        slug:               $('input[name=slug]').val(),
        showname:           $('input[name=showname]:checked').val(),
        showlogo:           $('input[name=showlogo]:checked').val(),
        cf1enabled:         $('input[name=cf1enabled]:checked').val(),
        cf2enabled:         $('input[name=cf2enabled]:checked').val(),
        cf3enabled:         $('input[name=cf3enabled]:checked').val(),
        cf1required:        $('input[name=cf1required]:checked').val(),
        cf2required:        $('input[name=cf2required]:checked').val(),
        cf3required:        $('input[name=cf3required]:checked').val(),
        cf1name:            $('input[name=cf1name]').val(),
        cf2name:            $('input[name=cf2name]').val(),
        cf3name:            $('input[name=cf3name]').val(),
        allowach:           $('input[name=allowach]:checked').val(),
        allowcc:            $('input[name=allowcc]:checked').val(),
        emailcustomer:      $('input[name=emailcustomer]:checked').val(),
        emailmerchant:      $('input[name=emailmerchant]:checked').val(),
        emailaddresses:     $('input[name=emails]').val(),
        tid:                $('input[name=tid]').val(),
        key:                $('input[name=key]').val(),
        token:              $('input[name=token]').val(),
        cc_conveniencefee:  $('input[name=cc_conveniencefee]:checked').val(),
        cc_cfpercentage:    $('input[name=cc_cfpercentage]').val(),
        ach_conveniencefee: $('input[name=ach_conveniencefee]:checked').val(),
        ach_cfpercentage:   $('input[name=ach_cfpercentage]').val()
    };

    var pathToController = "/customer/customer/ajax_update_customer";

    // Replace button with animated loading gif
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Updating Customer');

    jQuery.ajax({
    type: "POST",
    url: baseUrl + pathToController,
    dataType: 'json',
    data: array,
    success: function(res) {
        if (res) {// Show Entered Value

            // Replace button with original glyphicon
            $('.editcustomer-submit').removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-pencil"></span> Update Customer');

            var errors = false;
            for (var key in res)
            {
                if (key.substring(0, 'error_'.length) === 'error_') // holds the error message
                {
                    var field = key.replace("error_", "");
                    if (res[key])
                    {
                        $("span#" + field + "-err").append(res[key]); // display error message under field
                        $("div#" + field + "-field").addClass('has-error'); // make field red
                    }
                    errors = true;
                }
            }

            if (!errors)
            {
                $('#modal-dialog').dialog('close'); // close the form
            } else
            {
                return;
            }

            // Reload the page
            location.reload();
        }
    }
    });
});


// Disable a customer
$(document).on('click', '.disablecustomer-switch', function(){
    
    var id = $(this).data('id');
    var status;
    if ($(this).is(':checked'))
    {
        status = "1";
    }
    if (!$(this).is(':checked'))
    {
        status = "0";
    }
    
    var pathToController = "/customer/customer/ajax_update_customer_enabled_status";

    // disable switch
    // $(this).attr("disabled", true);

    jQuery.ajax({
        type: "POST",
        url: baseUrl + pathToController,
        dataType: 'json',
        data: { id:id, status:status },
        success: function(res) {
            if (res) {

                // if (res.status == "1")
                // {
                //     $('tr#'+res.id + ' td').css({ 'background-color' : 'grey'});
                // }
                // if (res.status == "0")
                // {
                //     $('tr#'+res.id + ' td').css({ 'background-color' : 'white'});
                // }

            }
        }
    });
});

// Upload new image for customer
$(document).on('click', '.addlogo-btn', function(e){
    
    var cid = $(this).data('id');
    var cname = $(this).data('cname');

    // Change title of modal
    $(".modal-title").html("Upload Logo for Customer: <strong>" + cname + "</strong>");

    // Show popup modal
    $('#myModal').modal("show");
    
    // Set customer ID in modal so that we can get it when uploading file via dropzone.js
    $( "#myModal" ).attr( "customerid", cid );
});

// Load Header modal
$(document).on('click', '.editheader-btn', function(e){
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> H');
    var cid = $(this).data('id');
    var cname = $(this).data('cname');
    $(".modal-title").html("Update Header for <strong>" + cname + "</strong>");
    var pathToController = "/customer/customer/get_customer_header";
    $.post(baseUrl + pathToController, { cid:cid }, function(response){
        CKEDITOR.instances['customerheader'].setData(response);
        $(".editheader-btn").removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-collapse-up"></span> H');
    });
    $(".header-submit").attr( "data-customerid", cid );
    $('#headerModal').modal("show");
});

// Update Header
$(document).on('click', '.header-submit', function(e){
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Update');
    var cid = $(this).data('customerid');
    var headertext = CKEDITOR.instances['customerheader'].getData();
    var pathToController = "/customer/customer/update_customer_header";
    $.post(baseUrl + pathToController, { cid:cid, headertext:headertext }, function(){
        location.reload();
    });
});

// Load Footer modal
$(document).on('click', '.editfooter-btn', function(e){
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> F');
    var cid = $(this).data('id');
    var cname = $(this).data('cname');
    $(".modal-title").html("Update Footer for <strong>" + cname + "</strong>");
    var pathToController = "/customer/customer/get_customer_footer";
    $.post(baseUrl + pathToController, { cid:cid }, function(response){
        CKEDITOR.instances['customerfooter'].setData(response);
        $(".editfooter-btn").removeAttr('disabled').empty().prepend('<span class="glyphicon glyphicon-collapse-down"></span> F');
    });
    $(".footer-submit").attr( "data-customerid", cid );
    $('#footerModal').modal("show");
});

// Update Footer
$(document).on('click', '.footer-submit', function(e){
    $(this).attr('disabled', true).empty().prepend('<i class="fa fa-spinner fa-spin"></i> Update');
    var cid = $(this).data('customerid');
    var footertext = CKEDITOR.instances['customerfooter'].getData();
    var pathToController = "/customer/customer/update_customer_footer";
    $.post(baseUrl + pathToController, { cid:cid, footertext:footertext }, function(){
        location.reload();
    });
});

// Search Customer table
$(document).on('keyup', '#customersearch', function(e){
    //split the current value of searchInput
    var data = this.value.split(" ");
    //create a jquery object of the rows
    var jo = $("#fbody").find("tr");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.is(":contains('" + data[d] + "')")) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
    .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});

// Fill the name of the slug when customer name input is keyed
$(document).on('keyup', 'input[name=customername]', function(e){
    // Get text from name input
    var customername = $(this).val();

    customername = slugify(customername);

    $('input[name=slug]').val(customername);
});

// Turns text into a slug
function slugify(text)
{
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}