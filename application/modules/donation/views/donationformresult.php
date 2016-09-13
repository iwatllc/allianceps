<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php 
		$css = new Asset_css('donationform-result');
	    $css->add_asset($this->config->item('base_preprocess'));
		$css->add_asset($this->config->item('client'));
		$css->add_asset('./assets/scss/donation.scss');
	
		$data['asset'] = $css;
		$this->load->view('header', $data); 
?>

<body class="flat-black donation-form receipt-print">

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
                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $page_data['heading'];?></h4>
                        </div>
                        <div class="panel-body">
							<div class="donation-grp">
								<div class="row">
									<div class="col-md-9">
												<?php
											$approved = $result_data['IsApproved'];
											$responseHTML = $result_data['ResponseHTML'];
											$responseCODE = $result_data['ReturnCode'];

											if ($approved == 1)
											{
												$approved = TRUE;
											} else {
												$approved = FALSE;
											}

											if (isset($approved) && $approved === TRUE)
											{
												?>
												<div class='alert alert-success'>
													Donation Successfully Processed!
												</div>

												<h3>Donation Reciept</h3>

												<div><strong>Reciept #:</strong> <?php echo $result_data['OrderNumber']; ?></div>

												<div><strong>Date:</strong> <?php echo $result_data['UpdateDate']; ?></div>

												<div><strong>Amount:</strong> <?php echo $submitted_data['amount']; ?></div>

												<div><strong>Card Ending: ************</strong><?php echo $submitted_data['cclast4']; ?></div>

												<div><strong>Card Holder:</strong> <?php echo $submitted_data['firstname'] . ' ' . $submitted_data['middleinitial'] . ' ' . $submitted_data['lastname']; ?></div>

												<div>
													<strong>Address:</strong></br>	
													<?php echo $submitted_data['streetaddress']; ?></br>
													<?php echo $submitted_data['city']; ?>&nbsp;<?php echo $submitted_data['state']; ?>&nbsp;<?php echo $submitted_data['zip']; ?>
												</div>

													<?php
												}
												else
												{
													?>
												<div style='color: #FF0000; font-weight: bold;'>
													There was an error processing this transaction.
												</div>
                            
													<div style='font-weight: bold;'>
														Here is the response for further details as to possibly why there was a failure:
													</div>

													<div><?php echo $responseHTML; ?></div>

												<?php
												}

												echo "<div style='font-weight: bold;'>";
												if (isset($response)){
													// echo $respones;
												};
												echo "</div>";
												?>

                                        <?php

                                            if($is_recurring == 'recurring' and $approved) {
                                                if ($result_data_recurring['IsApproved'] == 1)
                                                {
                                                    $approved_recurring = TRUE;
                                                } else {
                                                    $approved_recurring = FALSE;
                                                }
                                                if (isset($approved_recurring) && $approved_recurring === TRUE)
                                                {   ?>

                                                        <div class='alert alert-success'>
                                                            Recurring Transaction was Successfully Processed!
                                                        </div>

                                                    <?php
                                                } else {
                                                    ?>

                                                        <div style='color: #FF0000; font-weight: bold;'>
                                                            There was an error processing the recurring transaction.
                                                        </div>

                                                        <div style='font-weight: bold;'>
                                                            Here is the response for further details as to possibly why there was a failure:
                                                        </div>

                                                        <div><?php echo $result_data_recurring['responseHTML']; ?></div>

                                                    <?php

                                                }
                                            }

                                        ?>


								
								
								<div style="margin-top:50px;">
					<?php
        echo anchor('donation/Donation/', 'PROCESS ANOTHER DONATION', array('class' => 'btn btn-primary btn-lg m-r-5 dontprint'));
    ?>

    <a href="javascript:window.print()" class="btn btn-primary btn-lg m-r-5 dontprint">PRINT RECEIPT</a>
    <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button"></div>
						</div>
								
								
								
									</div>
							</div>
            </div>
        </div>
        <!-- end #content -->
    
												
											</div><!-- ./col-md-9 -->
										</div><!-- ./row -->
								</div>	
	
						
                        </div>
                    </div>
                    <!-- end panel -->

            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->

</div>
<!-- end page container -->

<?php $this->load->view('footer'); ?>


<div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>



</body>
</html>