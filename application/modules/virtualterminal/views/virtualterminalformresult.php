<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

if($Virtualterminal_Clientform == "FALSE") {

?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

    <?php $this->load->view('header'); ?>

    <body class="flat-black receipt-print">
    <div id="page-container" class="fade in page-without-sidebar">
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin page-header -->
            <div class="center-text">
                <h1><?php echo $page_data['heading'];?></h1>
                <p>
                    <?php echo $client_data['clientaddress'];?><br/>
                    <?php echo $client_data['clientcity'];?>, <?php echo $client_data['clientstate'];?><?php echo $client_data['clientzip'];?><br/>
                    <?php echo $client_data['clientphone'];?><br/>
                    <?php echo $client_data['clientwebsite'];?><br/>
                </p>
            </div>
            <!-- end page-header -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-12">
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
                            <div class='success'>
                            Payment Successfully Processed!
                            </div>
                            <br>
                            Payment Reciept
                            </br>
                            </br>
                            <b>Reciept #:</b> <?php echo $result_data['OrderNumber']; ?>
                            </br></br>
                            <b>Date:</b> <?php echo $result_data['UpdateDate']; ?>
                            </br></br>
                            <b>Amount: $</b> <?php echo $submitted_data['amount']; ?>
                            </br></br>
                            <b>Card Ending: ************</b><?php echo $submitted_data['cclast4']; ?>
                            </br></br>
                            <b>Card Holder:</b> <?php echo $submitted_data['firstname']. ' ' . $submitted_data['lastname']; ?>
                            </br></br>

                            <?php if($Virtualterminal_Signature == "TRUE"){ ?>
                                <div class="center-text">
                                I AGREE TO PAY ABOVE
                                TOTAL AMOUNT ACCORDING
                                TO THE CARD ISSUER
                                AGREEMENT
                                </div>
                                <br/>
                                <b>Signature:</b>
                                </br></br></br></br>
                                X__________________________________________________
                                <br/><?php echo $submitted_data['firstname']. ' ' . $submitted_data['lastname']; ?>
                                <br/>
                            <?php } ?>

                            <?php
                        }
                        else
                        {
                            ?>
                            <div style='color: #FF0000; font-weight: bold;' />
                            There was an error processing this transaction.
                            </div>
                            <br/>
                            <div style='font-weight: bold;'>
                            Here is the response for further details as to possibly why there was a failure:
                            </div>
                            <br/>
                            <?php echo $responseHTML; ?>
                            <br/>
                            <br/>
                            <?php
                        }

                        echo "<div style='font-weight: bold;'>";
                        if (isset($response)){
                            // echo $respones;
                        };
                        echo "</div>";
                    ?>
                </div>
            </div>
        </div>
        <!-- end #content -->


    <?php
        echo anchor('virtualterminal/', 'PROCESS ANOTHER CARD', array('class' => 'btn btn-primary btn-lg m-r-5 dontprint'));
    ?>

    <a href="javascript:window.print()" class="btn btn-primary btn-lg m-r-5 dontprint">PRINT RECEIPT</a>

    </div>
    <!-- end page container -->

    </body>
</html>

<?php } else { ?>

<?php 
		$css = new Asset_css('virtualterminalform');
	    $css->add_asset($this->config->item('base_preprocess'));
		$css->add_asset($this->config->item('client'));
		$css->add_asset('./client/client-virtualterminal.scss');
	
		$data['asset'] = $css;
		$this->load->view('header', $data); 
?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

    <?php $this->load->view('header_client'); ?>

<body>

	<?php include './client/client_website/client-header.php' ?>
	
	<div class="container" style="padding-bottom: 75px; margin: 0 auto; max-width: 960px;">
	
    <?php echo $page_data['heading'];?>
    <br>
    <?php echo $client_data['clientaddress'];?><br/>
    <?php echo $client_data['clientcity'];?>, <?php echo $client_data['clientstate'];?><?php echo $client_data['clientzip'];?><br/>
    <?php echo $client_data['clientphone'];?><br/>
    <?php echo $client_data['clientwebsite'];?><br/>

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

        Payment Successfully Processed!
        <br>
        Payment Reciept
        </br>
        </br>
        <b>Reciept #:</b> <?php echo $result_data['OrderNumber']; ?>
        </br></br>
        <b>Date:</b> <?php echo $result_data['UpdateDate']; ?>
        </br></br>
        <b>Amount: $</b> <?php echo $submitted_data['amount']; ?>
        </br></br>
        <b>Card Ending: ************</b><?php echo $submitted_data['cclast4']; ?>
        </br></br>
        <b>Card Holder:</b> <?php echo $submitted_data['firstname']. ' ' . $submitted_data['lastname']; ?>
        </br></br>

        <?php if($Virtualterminal_Signature == "TRUE"){ ?>
            <div class="center-text">
            I AGREE TO PAY ABOVE
            TOTAL AMOUNT ACCORDING
            TO THE CARD ISSUER
            AGREEMENT
            </div>
            <br/>
            <b>Signature:</b>
            </br></br></br></br>
            X__________________________________________________
            <br/><?php echo $submitted_data['firstname']. ' ' . $submitted_data['lastname']; ?>
            <br/>
        <?php } ?>

    <?php } else { ?>

                <div style='color: #FF0000; font-weight: bold;' />
                There was an error processing this transaction.
                </div>
                <br/>
                <div style='font-weight: bold;'>
                Here is the response for further details as to possibly why there was a failure:
                </div>
                <br/>
                <?php echo $responseHTML; ?>
                <br/>
                <br/>
    <?php }
        echo "<div style='font-weight: bold;'>";
        if (isset($response)){
            // echo $respones;
        }
        echo "</div>";
    ?>

    <?php
    echo anchor('virtualterminal/', 'PROCESS ANOTHER CARD', array('class' => 'btn btn-primary'));
    ?>

    <a class="btn btn-primary" href="javascript:window.print()" >PRINT RECEIPT</a>

</div>

<?php include './client/client_website/client-footer.php' ?>

</body>
</html>

<?php } ?>