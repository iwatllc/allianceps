<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

if($Guestform_Clientform == "FALSE") {

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
                <h1 class="page-header"><?php echo $page_data['heading'];?></h1>
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
                                <b>Amount:</b> <?php echo $submitted_data['amount']; ?>
                                </br></br>
                                <b>Card Ending: ************</b><?php echo $submitted_data['cclast4']; ?>
                                </br></br>
                                <b>Card Holder:</b> <?php echo $submitted_data['firstname']. ' ' . $submitted_data['lastname']; ?>
                                </br></br>
                                <b>Address:</b></br>
                                <?php echo $submitted_data['streetaddress']; ?></br>
                                <?php echo $submitted_data['city']; ?>&nbsp;<?php echo $submitted_data['state']; ?>&nbsp;<?php echo $submitted_data['zip']; ?>
                                </br><br></br>

                                <?php if($Guestform_Signature == "TRUE"){ ?>
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
                                <br/><br/>
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
        </div>
        <!-- end #content -->

    <?php
        echo anchor('guestform/', 'PROCESS ANOTHER CARD', array('class' => 'btn btn-primary btn-lg m-r-5 dontprint'));
    ?>

    <a href="javascript:window.print()" class="btn btn-primary btn-lg m-r-5 dontprint">PRINT RECEIPT</a>

    </div>
    <!-- end page container -->

    </body>
</html>

<?php } else { ?>


<? } ?>
