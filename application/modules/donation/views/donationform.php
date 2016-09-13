<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php 
		$css = new Asset_css('donationform');
	    $css->add_asset($this->config->item('base_preprocess'));
		$css->add_asset($this->config->item('client'));
		$css->add_asset('./assets/scss/donation.scss');
	
		$data['asset'] = $css;
		$this->load->view('header', $data); 
?>
<style>
    #loading-div-background{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        background: #fff;
        width: 100%;
        height: 100%;
    }

    #loading-div{
        width: 300px;
        height: 150px;
        background-color: #fff;
        border: 5px solid #f59c1a;
        text-align: center;
        color: #202020;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        behavior: url("/css/pie/PIE.htc"); /* HANDLES IE */
    }
</style>

<body class="flat-black donation-form">

<!-- begin #page-container -->
<div id="page-container" class="fade in page-without-sidebar">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <a href="<?php echo current_url(); ?>">
                    <div class="logo-img">
                        <?php if($Donationform_Logo != 'FALSE'){ ?>
                            <img src="<?php echo base_url(); ?>/client/<?php echo $Donationform_Logo ?>" height="300" width="350">
                        <?php } ?>
                    </div>
                    <h1 class="page-title"><?php echo $page_data['title'];?></h1>
                </a>
            </div>
            <!-- end mobile sidebar expand / collapse button -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin page-header -->
        <h1 class="page-header"><?php echo $page_data['slogan'];?></h1>
        <!-- end page-header -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-12">
                <?php $attributes = array('class' => 'form-horizontal', 'id' => 'donationform'); ?>
                <?php echo form_open('donation/Donation/submit', $attributes); ?>
                    <?php $data = array(
                        'type'  => 'hidden',
                        'name'  => 'cardtype',
                        'id'    => 'cardtype',
                        'value' => '',
                        'class' => 'cardtype'
                    );

                    echo form_input($data) ;

                    ?>

                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">DONATION INFORMATION ( <span class="required">*</span> = Required Field)</h4>
                        </div>
                        <div class="panel-body">
                        		<div class="donation-grp">
									<legend>My Donation</legend>
									<div class="form-group <?php echo(!empty(form_error('paymentamount')) ? 'has-error has-feedback' : ''); ?>">
										<div class="row">
											<label class="col-md-3 control-label">Amount <span class="required">*</span></label>
											<div class="col-md-9">
												<div class="btn-group pay-btns pay-btns-1" data-toggle="buttons">
													<label class="btn btn-primary">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamount25" value="25.00" <?php echo set_radio('paymentamount', '25.00'); ?> /> <span>$25</span>
													</label>
												
													<label class="btn btn-primary">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamount50" value="50.00" <?php echo set_radio('paymentamount', '50.00'); ?> /><span>$50</span>
													</label>
											
													<label class="btn btn-primary">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamount75" value="75.00" <?php echo set_radio('paymentamount', '75.00'); ?> /><span>$75</span>
													</label>
												
													<label class="btn btn-primary">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamount100" value="100.00" <?php echo set_radio('paymentamount', '100.00'); ?> /><span>$100</span>
													</label>
												
													<label class="btn btn-primary">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamount200" value="200.00" <?php echo set_radio('paymentamount', '200.00'); ?> /><span>$200</span>
													</label>
													
													<label class="btn btn-primary other-special">
														<input type="radio" class="amt-rad" name="paymentamount" id="paymentamountother" value="other" <?php echo set_radio('paymentamount', 'other'); ?> /><span>Other</span>
														$
													</label>
													<?php
                                                        $data = array(
                                                            'name'          => 'otheramount',
                                                            'id'            => 'maskedMoney-input-paymentamount',
                                                            'value'         => set_value('otheramount'),
                                                            'class'         => 'form-control input-other-pay',
                                                            'type'          => 'text',
                                                            'placeholder'   => '0.00',
                                                            'maxlength'     => '10',
                                                            'data-parsley-required' => 'true'
                                                        );

                                                        echo form_input($data);
                                                    ?>
												</div><!-- ./ pay-btns -->
											</div><!-- ./col-md-9 -->
										</div><!-- ./row -->

										<div class="row other-pay-error">
											<div class="col-md-9 col-md-offset-3">
												<?php echo form_error('paymentamount'); ?>
												<?php echo form_error('otheramount'); ?>
											</div>
										</div>
                                        <div class="row other-pay-error">
                                            <div class="col-md-9 col-md-offset-3">
                                                <label class="col-md-3 control-label">Make Recurring</label>
                                                <div class="col-md-9">
                                                    <?php
                                                    $data = array(
                                                        'name'          => 'recurring',
                                                        'id'            => 'recurring',
                                                        'value'         => 'recurring',
                                                        'class'         => 'form-control max-250',
                                                        'checked'       => set_checkbox('recurring')
                                                    );
                                                    echo form_checkbox($data);
                                                    ?>
                                                </div>
                                                Please make this a recurring contribution.<br>
                                                By clicking donate, you acknowledge that you are making a <br>
                                                recurring contribution and that the amount selected will <br>
                                                be charged to your credit card immediately and on this <br>
                                                date every month during the campaign.<br>
                                            </div>
                                        </div>
									</div><!-- ./ form-grp -->	
								</div><!-- ./donation-grp -->
									

				
				
				
							<div class="donation-grp">
                            <legend>My Information</legend>

                                <div class="form-group <?php echo(!empty(form_error('firstname')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">First Name <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                            $data = array(
                                                'name'          => 'firstname',
                                                'id'            => 'firstname',
                                                'value'         => set_value('firstname'),
                                                'class'         => 'form-control max-250',
                                                'type'          => 'text',
                                                'placeholder'   => 'Required',
                                                'maxlength'     => '100',
                                                'data-parsley-required' => 'true'
                                            );

                                            echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('firstname')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('firstname'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('middleinitial')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Middle Initial </label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'middleinitial',
                                            'id'            => 'middleinitial',
                                            'value'         => set_value('middleinitial'),
                                            'class'         => 'form-control max-100',
                                            'type'          => 'text',
                                            'placeholder'   => ' ',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'false'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('middleinitial')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('middleinitial'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('lastname')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Last Name <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'lastname',
                                            'id'            => 'lastname',
                                            'value'         => set_value('lastname'),
                                            'class'         => 'form-control max-250',
                                            'type'          => 'text',
                                            'placeholder'   => 'Required',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('lastname')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('lastname'); ?>
                                    </div>
                                </div>



                                <div class="form-group <?php echo(!empty(form_error('streetaddress')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Street Address <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'streetaddress',
                                            'id'            => 'streetaddress',
                                            'value'         => set_value('streetaddress'),
                                            'class'         => 'form-control max-350',
                                            'type'          => 'text',
                                            'placeholder'   => 'Required',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('streetaddress')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('streetaddress'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('streetaddress2')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Street Address (2)</label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'streetaddress2',
                                            'id'            => 'streetaddress2',
                                            'value'         => set_value('streetaddress2'),
                                            'class'         => 'form-control max-350',
                                            'type'          => 'text',
                                            'placeholder'   => '',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('streetaddress2')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('streetaddress2'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('city')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">City <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'city',
                                            'id'            => 'city',
                                            'value'         => set_value('city'),
                                            'class'         => 'form-control max-350',
                                            'type'          => 'text',
                                            'placeholder'   => 'Required',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('city')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('city'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('state')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">State <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                            $extra = array(
                                                'class' => 'form-control selectpicker max-200',
                                                'data-live-search' => 'true',
                                                'data-style' => (!empty(form_error('state')) ? 'btn-danger' : ''),
                                            );

                                            $options = array(
                                                '0' => 'Select State',
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
                                        <?php echo(!empty(form_error('state')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('state'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('zip')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Zip Code <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'zip',
                                            'id'            => 'masked-input-zip',
                                            'value'         => set_value('zip'),
                                            'class'         => 'form-control max-100',
                                            'type'          => 'text',
                                            'placeholder'   => '99999',
                                            'maxlength'     => '5',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('zip')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('zip'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('email')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Email<?php echo( $Donationform_Email_Required == 'TRUE' ? '*' : ' ') ?></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'email',
                                            'id'            => 'email',
                                            'value'         => set_value('email'),
                                            'class'         => 'form-control max-250',
                                            'type'          => 'email',
                                            'placeholder'   => 'email address',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => $Donationform_Email_Required
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('email')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('notes')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Notes</label>
                                    <div class="col-md-9">
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
                                        <?php echo(!empty(form_error('notes')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('notes'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('employer')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Employer <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        Federal law requires us to collect the following information:<br>
                                        if retired please put “Retired” in each field
                                        <?php
                                        $data = array(
                                            'name'          => 'employer',
                                            'id'            => 'employer',
                                            'value'         => set_value('employer'),
                                            'class'         => 'form-control max-350',
                                            'type'          => 'text',
                                            'placeholder'   => 'Required',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('employer')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('employer'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('occupation')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Occupation <span class="required">*</span></label>
                                    <div class="col-md-9">
                                        <?php
                                        $data = array(
                                            'name'          => 'occupation',
                                            'id'            => 'occupation',
                                            'value'         => set_value('occupation'),
                                            'class'         => 'form-control max-350',
                                            'type'          => 'text',
                                            'placeholder'   => 'Required',
                                            'maxlength'     => '100',
                                            'data-parsley-required' => 'true'
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo(!empty(form_error('occupation')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('occupation'); ?>
                                    </div>
                                </div>
							</div>	
							
							<div class="donation-grp">
                            <legend>My Payment Information</legend>
                            <div class="form-group <?php echo(!empty(form_error('creditcard')) ? 'has-error has-feedback' : ''); ?>">
                            <label class="col-md-3 control-label">We Accept</label>
                            <div class="col-md-9"><img src="<?php echo base_url(); ?>/client/credit-card-icons.png" width="150"/></div>
                            </div>
                                <div class="form-group <?php echo(!empty(form_error('creditcard')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Credit Card <span class="required">*</span></label>
                                    <div class="col-md-9">
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
                                        <?php echo(!empty(form_error('creditcard')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('creditcard'); ?>

                                    </div>
                                </div>

                                <div class="form-group <?php echo(!empty(form_error('expirationmonth')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Expiration Month <span class="required">*</span></label>
                                    <div class="col-md-9">
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
                                        <?php echo(!empty(form_error('expirationmonth')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('expirationmonth'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo(!empty(form_error('expirationyear')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">Expiration Year <span class="required">*</span></label>
                                    <div class="col-md-9">
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
                                        <?php echo(!empty(form_error('expirationyear')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('expirationyear'); ?>
                                    </div>
                                </div>

                                <div class="form-group <?php echo(!empty(form_error('cvv2')) ? 'has-error has-feedback' : ''); ?>">
                                    <label class="col-md-3 control-label">CVV <span class="required">*</span> <span style="display: inline;" class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="3 digit security code on back of credit card"></span></label>
                                    <div class="col-md-9">
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
                                        <?php echo(!empty(form_error('cvv2')) ? '<span class="fa fa-times form-control-feedback"></span>' : ''); ?>
                                        <?php echo form_error('cvv2'); ?>
                                    </div>
                                </div>
							</div>	

                            <div class="form-group">
                                <div class="col-md-12 end-form-donate">
                                    <button type="submit" class="btn btn-donate btn-primary">Donate Now</button>
                                </div>
                            </div>

                        

                        </div>
                    </div>
                    <!-- end panel -->

                <?php echo form_close(); ?>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->




    </div>
    <!-- end #content -->

    <!-- #modal-message -->
    <div id="loading-div-background">
        <div id="loading-div" class="ui-corner-all">
            <img style="height:64px;width:62px;margin:30px;" src="<?php echo base_url(); ?>assets/img/wait_spinner.gif" alt="Loading.."/><br>PROCESSING. PLEASE WAIT...
        </div>
    </div>

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->

</div>
<!-- end page container -->

<?php $this->load->view('footer'); ?>

<script src="<?php echo base_url(); ?>/assets/plugins/jquery-payment/lib/jquery.payment.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#loading-div-background").css({ opacity: 1.0 });

        $('#donationform').submit(function(){
            var cardType = $.payment.cardType($('.creditcard').val());
            $('.cardtype').val(cardType);
            $('#submit').attr({
                disabled: 'disabled',
                value: 'Processing, Please Wait...'
            });
            $("#loading-div-background").show();
        });

        $('.creditcard').payment('formatCardNumber');
        $('.cc-cvc').payment('formatCardCVC');

    });
</script>

</body>
</html>