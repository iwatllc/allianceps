<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contribute - Kathy Szeliga for US Senate</title>
    <link href="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/theme.scss" rel="stylesheet" />
    <link href="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/bootswatch.scss" rel="stylesheet" />
    <link href="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/szeliga.scss" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <meta name="Title" content="Contribute">
    <meta property="og:title" content="Contribute" />
    <meta property="og:type" content="article">
    <link rel="image_src" href="https://d3n8a8pro7vhmx.cloudfront.net/electkathy/sites/3/meta_images/original/logo3.png?1450899288" />
    <meta property="og:image" content="https://d3n8a8pro7vhmx.cloudfront.net/electkathy/sites/3/meta_images/original/logo3.png?1450899288" />
    <meta property="og:site_name" content="Kathy Szeliga for US Senate" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/cupertino/jquery-ui.css" type="text/css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/jquery.ui.effect.min.js"></script>
    <script type="text/javascript" src="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/jquery.ui.effect-slide.min.js"></script>
    <script type="text/javascript">
    var StagedDonations = StagedDonations || {};
    $(document).ready(function() {
        (function() {
            this.updateContainerHeight = function(height) {
                $('.progress-stages').animate({
                    'min-height': height
                }, 300);
            }
            this.updateProgressIndicator = function(indicator, direction) {
                var current = indicator.find('.active');
                var next = current.next();
                var previous = current.prev();
                if (direction && current.next().length) {
                    current.addClass('completed').find('.stage-count-inner').addClass('icon-tick');
                    current.removeClass('active');
                    next.addClass('active');
                    next.addClass('seen');
                } else if (!direction && current.prev().length) {
                    current.removeClass('active');
                    previous.addClass('active');
                } else {}
            }
            this.updateProgressStages = function(stages, direction) {
                var ns = this;
                var current = stages.find('.active');
                var next = current.next();
                var previous = current.prev();
                if (direction && current.next().length) {
                    current.hide('slide', {
                        direction: 'left',
                        easing: 'easeInBack'
                    }, 300, function() {
                        $(this).removeClass('active');
                        current.next().show('slide', {
                            direction: 'left'
                        }, 300, function() {
                            $(this).addClass('active');
                        });
                    });
                } else if (!direction && current.prev().length) {
                    current.hide('slide', {
                        direction: 'left',
                        easing: 'easeInBack'
                    }, function() {
                        $(this).removeClass('active');
                        current.prev().show('slide', {
                            direction: 'left'
                        }, 300, function() {
                            $(this).addClass('active');
                        });
                    });
                } else {}
            }
            this.triggerAlert = function(alertMessage, insertBefore) {
                var message = '<div class="help-block form-error">' + alertMessage + '</div>';
                insertBefore.after(message);
            }
            this.removeAlerts = function() {
                $('.form-error').remove();
                $('.error').each(function() {
                    $(this).removeClass('error');
                });
                $('.has-error').each(function() {
                    $(this).removeClass('has-error');
                });
            }
            this.validateEmail = function(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }
            this.validateDonations = function(currentStage) {
                var donationAmount = Number($('#otheramount').val()) ;
                switch (currentStage) {
                    case "1":
                        if ((isNaN(donationAmount) || (donationAmount < 0.01)) && ($('.progress-stage input[type="radio"]:checked').length == 0)) {
                            $('#otheramount').parent().addClass('has-error');
                            this.triggerAlert("Invalid donation amount", $('#otheramount'));
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "2":
                        var invalidCount = 0;
                        var validatedEmail = this.validateEmail($('#email').val());
                        if (!$('#streetaddress').val()) {
                            $('#streetaddress').parent().addClass('has-error');
                            this.triggerAlert("Address1 can't be blank", $('#streetaddress'));
                            invalidCount++;
                        }
                        if (!$('#city').val()) {
                            $('#city').parent().addClass('has-error');
                            this.triggerAlert("City can't be blank", $('#city'));
                            invalidCount++;
                        }
                        if ($('#state').find(":selected").val() === "0") {
                            $('#state').parent().addClass('has-error');
                            this.triggerAlert("A State must be selected", $('#state'));
                            invalidCount++;
                        }
                        if (!$('#masked-input-zip').val()) {
                            $('#masked-input-zip').parent().addClass('has-error');
                            this.triggerAlert("Postal code can't be blank", $('#masked-input-zip'));
                            invalidCount++;
                        }
                        if (!$('#firstname').val()) {
                            $('#firstname').parent().addClass('has-error');
                            this.triggerAlert("You must supply a first name", $('#firstname'));
                            invalidCount++;
                        }
                        if (!$('#lastname').val()) {
                            $('#lastname').parent().addClass('has-error');
                            this.triggerAlert("You must supply a last name", $('#lastname'));
                            invalidCount++;
                        }
                        if (!validatedEmail) {
                            $('#email').parent().addClass('has-error');
                            this.triggerAlert("Email address not valid", $('#email'));
                            invalidCount++;
                        }
                        if (!$('#employer').val()) {
                            $('#employer').parent().addClass('has-error');
                            this.triggerAlert("You must supply an employer", $('#employer'));
                            invalidCount++;
                        }
                        if (!$('#occupation').val()) {
                            $('#occupation').parent().addClass('has-error');
                            this.triggerAlert("You must supply an occupation", $('#occupation'));
                            invalidCount++;
                        }

                        if(invalidCount > 0) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    case "3":
                        var invalidCount = 0;
                        if (!$('#donation_is_confirmed').is(':checked')) {
                            $('#donation_is_confirmed').parent().parent().addClass('has-error');
                            this.triggerAlert("You must check this box to contribute. ", $('#donation_is_confirmed').parent());
                            invalidCount++;
                        }

                        if(invalidCount > 0) {
                            return false;
                        } else {
                            return true;
                        }
                        break;
                    default:
                        return true;
                }
            }
        }).apply(StagedDonations);
        if ($('.progress-indicator-stages').length) {
            var progressIndicator = $('.progress-indicator-stages');
            var progressStages = $('.progress-stages');
            $('.progress-indicator-stages .stage-count').each(function() {
                $(this).click(function(event) {
                    event.preventDefault();
                    if (!$(this).parent().hasClass('active')) {
                        if ($(this).parent().hasClass('completed') || $(this).parent().hasClass('seen')) {
                            var clickedIndicatorStageClass = $.grep($(this).parent().attr("class").split(" "), function(v, i) {
                                return v.indexOf('stage-') === 0;
                            }).join();
                            var currentActiveIndicator = progressIndicator.find('.active');
                            var desiredProgressStage = progressStages.children('.' + clickedIndicatorStageClass);
                            var currentActiveStage = progressStages.find('.active');
                            currentActiveIndicator.removeClass('active');
                            $(this).parent().addClass('active');
                            currentActiveStage.hide('slide', {
                                direction: 'left',
                                easing: 'easeInBack'
                            }, 300, function() {
                                $(this).removeClass('active');
                                desiredProgressStage.show('slide', {
                                    direction: 'left'
                                }, 300, function() {
                                    $(this).addClass('active');
                                });
                            });
                        }
                    }
                });
            });
            $('.progress-stage-button-next').each(function() {
                $(this).click(function(event) {
                    event.preventDefault();
                    StagedDonations.removeAlerts();
                    var currentStage = $('.progress-stage.active').attr('data-stageid');
                    var isValid = StagedDonations.validateDonations(currentStage);
                    if (isValid) {
                        StagedDonations.updateProgressIndicator(progressIndicator, 1);
                        StagedDonations.updateProgressStages(progressStages, 1);
                    } else {
                        progressIndicator.find('.active').removeClass('completed').find('.stage-count-inner').removeClass('icon-tick');
                        progressIndicator.find('.active').next().removeClass('seen');
                    }
                });
            });
            // Prevent submission of form if validation fails.
            $('#donate_page_new_donation_form').on('submit', function(e){
                StagedDonations.removeAlerts();
                var currentStage = $('.progress-stage.active').attr('data-stageid');
                var isValid = StagedDonations.validateDonations(currentStage);
                if(!isValid) {
                    e.preventDefault();
                }
            });
            $('.progress-stages .radio').each(function() {
                $(this).click(function(event) {
                    StagedDonations.updateProgressIndicator(progressIndicator, 1);
                    StagedDonations.updateProgressStages(progressStages, 1);
                });
            });
            $('.progress-stage-button-prev').each(function() {
                $(this).click(function(event) {
                    event.preventDefault();
                    StagedDonations.removeAlerts();
                    StagedDonations.updateProgressIndicator(progressIndicator, 0);
                    StagedDonations.updateProgressStages(progressStages, 0);
                });
            });
            progressStages.find('input[type="submit"]').click(function(event) {
                progressIndicator.find('.active').addClass('completed').find('.stage-count-inner').addClass('icon-tick');
            });
        }
    });

    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }
    $(function() {
        var amount = getUrlParameter('amount');
        if (amount) {
            $('#otheramount').val(amount);
            $('.progress-stage.stage-1 .progress-stage-button-next').click();
        }
    });
    $(function() { 
        $('#otheramount').on('input',function(e){
            $("input:radio[name='paymentamount']").not("#donation_amount_o").each(function(i) {
                this.checked = false;
            });
            $("#donation_amount_o").prop('checked', true);
        });
    });
    </script>
    <style>
        .no-gutter > [class*='col-'] {
            padding-right:0;
            padding-left:0;
        }
    </style>
</head>

<body class="aware-theme v2-theme page-type-donation page-pages-show-donation-wide js">
    <header>
        <nav class="navbar navbar-default navbar-custom ">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <img style="max-height:75px;" alt="Kathy Szeliga for US Senate" src="https://d3n8a8pro7vhmx.cloudfront.net/electkathy/sites/3/meta_images/original/logo3.png?1450899288" />
                    </a>
                </div>
                <div id="navbar-util">
                    <button aria-controls="navbar" aria-expanded="false" class="navbar-toggle collapsed" data-target=".side-collapse" data-target-2=".side-collapse-container" data-toggle="collapse-side" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="side-collapse in">
                    <div class="navbar-collapse pull-right" id="navbar">
                        <ul class="nav navbar-nav">
                            <li class="donate1"><a href="/donate" style="background-color: #113376;color:#fff;">Contribute</a></li>
                            <li class="visible-xs social-table social">
                                <table style="width:100%;">
                                    <tr>
                                        <td width="10%"></td>
                                        <td width="40%">
                                            <a class="facebook" href="http://www.facebook.com/kathy.szeliga"><i class="fa fa-facebook fa-2x"></i></a>
                                        </td>
                                        <td width="40%">
                                            <a class="twitter" href="http://www.twitter.com/KathyforMD"><i class="fa fa-twitter fa-2x"></i></a>
                                        </td>
                                        <td width="10%"></td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="main-container side-collapse-container" id="middle">
        <div class="main container clearfix ">
            <div class="column content-pages-show-donation-wide">
                <div class="columns-1-flash">
                    <div id="flash_container">
                    </div>
                </div>
                <div id="content">
                    <div class="row">
                        <div class="col-md-6 donation-content">
                            <h2 class="headline" style="text-align:center;">Contribute</h2>
                            <div id="intro" class="intro">
                                <p>D.C. Insiders consider this Senate seat "theirs" to win and think this Senate seat is one that they "own." Marylanders are sick and tired of their vote being taken for granted. They want a Senator, who cares about their priorities and someone who will work as hard as they do.</p>
                                <p>This race may not be an easy WIN, but I am willing to stand up and fight if you are!</p>
                                <p>Let’s do this together, if we do, I believe WE WILL WIN!</p>
                                <p>- Kathy</p>
                            </div>
                        </div>
                        <div class="col-md-6 donation-container" id="donation-container">
                        <?php $attributes = array('class' => 'donation_form', 'id' => 'donate_page_new_donation_form'); ?>
                        <?php echo form_open('donation/Donation/submit', $attributes); ?>
                                <div class="form-wrap padtopmore">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-progress-indicator">
                                                    <ul class="progress-indicator-stages clearfix">
                                                        <li class="progress-indicator-stage stage-1 active"><span class="stage-label">Amount</span><span class="stage-count">
                    <span class="stage-count-inner">1</span>
                                                            </span>
                                                        </li>
                                                        <li class="progress-indicator-stage stage-2"><span class="stage-label">Your Info</span><span class="stage-count">
                    <span class="stage-count-inner">2</span>
                                                            </span>
                                                        </li>
                                                        <li class="progress-indicator-stage stage-3"><span class="stage-label">Payment</span><span class="stage-count">
                    <span class="stage-count-inner">3</span>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="form-errors">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                        <div class="progress-stages">
                                            <div class="progress-stage stage-1 active" data-stageID="1">
                                                <div class="container-fluid">
                                                    <div class="row radio-inline padbottomless">
                                                        <span><input id="donation_amount_25" type="radio" name="paymentamount" class="donation_amount_option" value="25"  /><label class="radio" for="donation_amount_25">$25</label></span>
                                                        <span><input id="donation_amount_50" type="radio" name="paymentamount" class="donation_amount_option" value="50" /><label class="radio" for="donation_amount_50">$50</label></span>
                                                        <span><input id="donation_amount_100" type="radio" name="paymentamount" class="donation_amount_option" value="100" /><label class="radio" for="donation_amount_100">$100</label></span>
                                                        <span><input id="donation_amount_250" type="radio" name="paymentamount" class="donation_amount_option" value="250" /><label class="radio" for="donation_amount_250">$250</label></span>
                                                        <span><input id="donation_amount_1000" type="radio" name="paymentamount" class="donation_amount_option" value="1000" /><label class="radio" for="donation_amount_1000">$1,000</label></span>
                                                        <span><input id="donation_amount_2500" type="radio" name="paymentamount" class="donation_amount_option" value="2500" /><label class="radio" for="donation_amount_2500">$2,500</label></span>   
                                                        <span style="display: none;"><input id="donation_amount_o" type="radio" name="paymentamount" class="donation_amount_option" value="other" checked="checked" /><label class="radio" for="donation_amount_o">Other</label></span>
                                                        <div class="padtop form-inline">
                                                            <label for="otheramount">Other $</label>
                                                            <div class="form-group">
                                                            <?php
                                                                $data = array(
                                                                    'name'          => 'otheramount',
                                                                    'id'            => 'otheramount',
                                                                    'value'         => set_value('otheramount'),
                                                                    'class'         => 'form-control',
                                                                    'type'          => 'text',
                                                                    'placeholder'   => '0.00',
                                                                    'maxlength'     => '10',
                                                                    'data-parsley-required' => 'true'
                                                                );

                                                                echo form_input($data);
                                                            ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="padtop button-container"><span class="progress-stage-button-next button btn btn-primary">Continue</span></div>
                                            </div>
                                            <!-- .progress-stage-1 -->
                                            <div class="progress-stage stage-2" data-stageID="2">
                                                <div>
                                                    <div class="row form-group">
                                                        <div class="col-md-6">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'firstname',
                                                                'id'            => 'firstname',
                                                                'value'         => set_value('firstname'),
                                                                'class'         => 'form-control max-250',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'First Name',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <?php
                                                        $data = array(
                                                            'name'          => 'lastname',
                                                            'id'            => 'lastname',
                                                            'value'         => set_value('lastname'),
                                                            'class'         => 'form-control max-250',
                                                            'type'          => 'text',
                                                            'placeholder'   => 'Last Name',
                                                            'maxlength'     => '100',
                                                            'data-parsley-required' => 'true'
                                                        );
                                                        echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'streetaddress',
                                                                'id'            => 'streetaddress',
                                                                'value'         => set_value('streetaddress'),
                                                                'class'         => 'form-control max-350',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Address 1',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'streetaddress2',
                                                                'id'            => 'streetaddress2',
                                                                'value'         => set_value('streetaddress2'),
                                                                'class'         => 'form-control max-350',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Address 2',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'false'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'city',
                                                                'id'            => 'city',
                                                                'value'         => set_value('city'),
                                                                'class'         => 'form-control max-350',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'City',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                        <div class="col-md-4 us-or-canada form-group">
                                                        <?php
                                                            $extra = array(
                                                                'class' => 'form-control selectpicker max-200',
                                                                'id' => 'state',
                                                                'data-live-search' => 'true',
                                                                'data-style' => (!empty(form_error('state')) ? 'btn-danger' : ''),
                                                            );

                                                            $options = array(
                                                                '0' => 'State',
                                                                'AL' =>'Alabama',
                                                                'AK' =>'Alaska',
                                                                'AZ' =>'Arizona',
                                                                'AR' =>'Arkansas',
                                                                'CA' =>'California',
                                                                'CO' =>'Colorado',
                                                                'CT' =>'Connecticut',
                                                                'DE' =>'Delaware',
                                                                'DC' =>'District Of Columbia',
                                                                'FL' =>'Florida',
                                                                'GA' =>'Georgia',
                                                                'HI' =>'Hawaii',
                                                                'ID' =>'Idaho',
                                                                'IL' =>'Illinois',
                                                                'IN' =>'Indiana',
                                                                'IA' =>'Iowa',
                                                                'KS' =>'Kansas',
                                                                'KY' =>'Kentucky',
                                                                'LA' =>'Louisiana',
                                                                'ME' =>'Maine',
                                                                'MD' =>'Maryland',
                                                                'MA' =>'Massachusetts',
                                                                'MI' =>'Michigan',
                                                                'MN' =>'Minnesota',
                                                                'MS' =>'Mississippi',
                                                                'MO' =>'Missouri',
                                                                'MT' =>'Montana',
                                                                'NE' =>'Nebraska',
                                                                'NV' =>'Nevada',
                                                                'NH' =>'New Hampshire',
                                                                'NJ' =>'New Jersey',
                                                                'NM' =>'New Mexico',
                                                                'NY' =>'New York',
                                                                'NC' =>'North Carolina',
                                                                'ND' =>'North Dakota',
                                                                'OH' =>'Ohio',
                                                                'OK' =>'Oklahoma',
                                                                'OR' =>'Oregon',
                                                                'PA' =>'Pennsylvania',
                                                                'RI' =>'Rhode Island',
                                                                'SC' =>'South Carolina',
                                                                'SD' =>'South Dakota',
                                                                'TN' =>'Tennessee',
                                                                'TX' =>'Texas',
                                                                'UT' =>'Utah',
                                                                'VT' =>'Vermont',
                                                                'VA' =>'Virginia',
                                                                'WA' =>'Washington',
                                                                'WV' =>'West Virginia',
                                                                'WI' =>'Wisconsin',
                                                                'WY' =>'Wyoming',
                                                            );

                                                            echo form_dropdown('state', $options, set_value('state'), $extra);
                                                        ?>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'zip',
                                                                'id'            => 'masked-input-zip',
                                                                'value'         => set_value('zip'),
                                                                'class'         => 'form-control max-100',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Zip Code',
                                                                'maxlength'     => '5',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'email',
                                                                'id'            => 'email',
                                                                'value'         => set_value('email'),
                                                                'class'         => 'form-control max-250',
                                                                'type'          => 'email',
                                                                'placeholder'   => 'Email',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => $Donationform_Email_Required
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'phone',
                                                                'id'            => 'phone',
                                                                'value'         => set_value('phone'),
                                                                'class'         => 'form-control max-250',
                                                                'type'          => 'phone',
                                                                'placeholder'   => 'Phone',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'false'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>

                                                    <?php if($Donationform_Notes == "TRUE") { ?>
                                                        <div class="row">
                                                            <div class="col-md-12 form-group">
                                                            <?php
                                                                $data = array(
                                                                    'name'          => 'notes',
                                                                    'id'            => 'notes',
                                                                    'value'         => set_value('notes'),
                                                                    'class'         => 'form-control max-350',
                                                                    'type'          => 'text',
                                                                    'placeholder'   => 'Notes',
                                                                    'maxlength'     => '100',
                                                                    'data-parsley-required' => 'true'
                                                                );

                                                                echo form_input($data);
                                                            ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <h4 class="padbottomless padtop text-center">Employment Info</h4>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'employer',
                                                                'id'            => 'employer',
                                                                'value'         => set_value('employer'),
                                                                'class'         => 'form-control max-350',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Employer',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'occupation',
                                                                'id'            => 'occupation',
                                                                'value'         => set_value('occupation'),
                                                                'class'         => 'form-control max-350',
                                                                'type'          => 'text',
                                                                'placeholder'   => 'Occupation',
                                                                'maxlength'     => '100',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="padtopless padbottomless"><small>Law requires we ask for your employer and occupation. If you don't have an employer or are retired, put N/A, and if you are self-employed put "self-employed" in employer and describe your occupation.</small></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="padtop button-container">
                                                    <span class="progress-stage-button-next button btn btn-primary">Continue</span>
                                                    <a class="progress-stage-button-prev" href="#donation-container">Back</a>
                                                </div>
                                            </div>
                                            <!-- .progress-stage-2 -->
                                            <div class="progress-stage stage-3" data-stageID="3">
                                                <div class="row">
                                                    <div class="col-md-7 form-group">
                                                    <?php
                                                        $data = array(
                                                            'name'          => 'creditcard',
                                                            'id'            => 'creditcard',
                                                            'value'         => set_value('creditcard'),
                                                            'class'         => 'form-control max-200 creditcard',
                                                            'type'          => 'text',
                                                            'placeholder'   => '9999 9999 9999 9999',
                                                        );

                                                        echo form_input($data);
                                                    ?>
                                                    <?php 
                                                        $data = array(
                                                            'type'  => 'hidden',
                                                            'name'  => 'cardtype',
                                                            'id'    => 'cardtype',
                                                            'value' => '',
                                                            'class' => 'cardtype'
                                                        );

                                                        echo form_input($data) ;
                                                    ?>
                                                    </div>
                                                    <div class="col-md-5 cc"> <img src="https://d3n8a8pro7vhmx.cloudfront.net/assets/icons/visa2.gif" class="icon-cc" /> <img src="https://d3n8a8pro7vhmx.cloudfront.net/assets/icons/mastercard.gif" class="icon-cc" /> <img src="https://d3n8a8pro7vhmx.cloudfront.net/assets/icons/amex.gif" class="icon-cc" /> <img src="https://d3n8a8pro7vhmx.cloudfront.net/assets/icons/discover.gif" class="icon-cc" /></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group no-gutter">
                                                        <label for="donation_card_expires_on">Expiration Date</label>
                                                        <div class="col-md-3">
                                                            <?php
                                                                $extra = array(
                                                                    'class' => 'form-control selectpicker max-200',
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
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php
                                                                $extra = array(
                                                                    'class' => 'form-control selectpicker max-200',
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
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 form-group no-gutter">
                                                        <label for="donation_card_expires_on">Security Code</label>
                                                        <?php
                                                            $data = array(
                                                                'name'          => 'cvv2',
                                                                'id'            => 'cvv2',
                                                                'value'         => set_value('cvv2'),
                                                                'class'         => 'form-control max-200 cvv2',
                                                                'type'          => 'text',
                                                                'placeholder'   => '000',
                                                                'maxlength'     => '4',
                                                                'data-parsley-required' => 'true'
                                                            );

                                                            echo form_input($data);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <label for="is_confirmation_text"><strong>Contribution rules</strong></label>
                                                        Please note that donations from corporations and foreign nationals are prohibited. Contributions are not deductible as charitable contributions for federal income tax purposes. The max an individual may contribute is $5,400 ($2,700 primary/$2,700 general).
                                                        <label for="donation_is_confirmed" class="checkbox padtop">
                                                            <input name="donation[is_confirmed]" type="hidden" value="0" />
                                                            <input class="checkbox" id="donation_is_confirmed" name="donation[is_confirmed]" type="checkbox" value="1" /> I confirm that the above statements are true and accurate.</label>
                                                        <div class="row tax-info">
                                                            <div class="col-md-12"><small>Contributions are <i>not</i> tax deductible.</small></div>
                                                        </div>
                                                        <div class="padtop row">
                                                            <div class="col-md-12 button-container">
                                                                <button type="submit" class="btn btn-donate btn-primary">Contribute</button>
                                                                <a class="progress-stage-button-prev" href="#donation-container">Back</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- .progress-stage-3 -->
                                        </div>
                                        <!-- .progress-stages -->
                                    <?php echo form_close(); ?>
                                    <!-- .form -->
                                </div>
                                <!-- .form-wrap -->
                            </div>
                        </div>
                        <!-- .span6 -->
                        <div class="col-md-6">
                            <!-- content area -->
                            <!-- this section should be empty to show background image -->
                        </div>
                        <!-- .span5 -->
                    </div>
                    <!-- .row -->
                    <br clear="both" />
                </div>
            </div>
            <!-- .column -->
            <!-- /_columns_1.html -->
        </div>
        <!-- .main -->
    </div>
    <!-- .main-container -->
    <footer>
        <div class="container ">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <!-- social media icons -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p style="padding: 0 0 45px 0;"><img style="max-height:100px;" alt="Kathy Szeliga for US Senate" src="https://d3n8a8pro7vhmx.cloudfront.net/themes/56782757221393cc23000001/attachments/original/1450887891/footer-logo.png?1450887891" /></p>
                            <p style="padding: 20px 0;"><small>PO Box 43516<br/>Nottingham, MD 21236<br/>(443) 516-7252 &middot; <a href="mailto:info@kathyformaryland.com">info@kathyformaryland.com</a></small>
                                <br/>
                            </p>
                            <p style="padding-bottom:15px;"><small><a href="/privacy">Privacy Policy</a> &middot; Created with <a href="http://nationbuilder.com/">NationBuilder</a></small></p>
                            <p class="disclaimer" style="font-size:10px;border: 1px solid #000;background-color:#fff;width:180px;margin: 10px auto;color:#000;text-align:center;padding:5px 7px;">Paid for by Kathy for Maryland</p>
                        </div>
                    </div>
                </div>
                <!-- // .col -->
            </div>
            <!-- // .row -->
        </div>
        <!-- // container -->
    </footer>
    <script src="https://electkathy.nationbuilder.com/themes/3/56782757221393cc23000001/0/attachments/14507154531451619718/default/bootstrap.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        var sideslider = $('[data-toggle=collapse-side]');
        var sel = sideslider.attr('data-target');
        var sel2 = sideslider.attr('data-target-2');
        sideslider.click(function(event) {
            $(sel).toggleClass('in');
            $(sel2).toggleClass('out');
        });
    });
    </script>
    
</body>

</html>
