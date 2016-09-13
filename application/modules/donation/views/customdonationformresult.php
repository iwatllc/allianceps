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
            <div><strong>Reciept #:</strong>
                <?php echo $result_data['OrderNumber']; ?>
            </div>
            <div><strong>Date:</strong>
                <?php echo $result_data['UpdateDate']; ?>
            </div>
            <div><strong>Amount:</strong>
                <?php echo $submitted_data['amount']; ?>
            </div>
            <div><strong>Card Ending: ************</strong>
                <?php echo $submitted_data['cclast4']; ?>
            </div>
            <div><strong>Card Holder:</strong>
                <?php echo $submitted_data['firstname'] . ' ' . $submitted_data['middleinitial'] . ' ' . $submitted_data['lastname']; ?>
            </div>
            <div>
                <strong>Address:</strong></br>
                <?php echo $submitted_data['streetaddress']; ?>
                    </br>
                    <?php echo $submitted_data['city']; ?>&nbsp;
                        <?php echo $submitted_data['state']; ?>&nbsp;
                            <?php echo $submitted_data['zip']; ?>
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
                <div>
                    <?php echo $responseHTML; ?>
                </div>
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
                            <div>
                                <?php echo $result_data_recurring['responseHTML']; ?>
                            </div>
                            <?php

                                                }
                                            }

                                        ?>
                                <div style="margin-top:50px;">
                                    <a href="javascript:window.print()" class="btn btn-primary btn-lg m-r-5 dontprint">PRINT RECEIPT</a>
                                    <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button"></div>
                                </div>
    </div>
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
