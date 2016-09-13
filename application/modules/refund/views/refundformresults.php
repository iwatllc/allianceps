<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('navbar'); ?>

<head>
    <title><?php echo $title; ?></title>
</head>

    <body class = "flat-back">
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- end page-header -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-12">

                    <!-- begin panel -->
                    <div class="panel panel-inverse" >
                        <div class="panel-heading">
                            <h4 class="panel-title">CHANGE STATUS</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <div class="form-inline">
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
                                            Refund Successfully Processed!
                                            </div>
                                            </br>
                                            <b>Date:</b> <?php echo $result_data['UpdateDate']; ?>
                                            </br></br>
                                            <b>Amount:</b> <?php echo $submitted_data['amount']; ?>
                                            </br><br></br>

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
                </div>
            </div>
        </div>
        <!-- end #content -->
    </body>

<?php $this->load->view('footer'); ?>

</html>