<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: afrazer
 * Date: 11/03/2016
 * Time: 10:31 AM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $page_data['title'] }}</title>
    <meta name="description" content="{{ $page_data['description'] }}">
    <meta name="author" content="{{ $page_data['author'] }}">
    <link href="{{ base_url('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ base_url('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ base_url('/client/logo-small.png') }}">
    <style type="text/css">
        h1 {
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
        }
        div.box {
            margin: auto;
            width: 60%;
            border: 3px solid #FF0000;
            padding: 10px;
        }
        div.center {
            margin: auto;
        }
        .centeredtext {
            text-align:center;
        }
        .red {
            color:red;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="center">
            <h1 class="red">
                Payment Declined
            </h1>
            <div class="centeredtext">
                <i class="fa fa-times-circle-o fa-5x" style="color:red;"></i>
            </div>
            <h3 class="centeredtext">
                There was an error processing this transaction.
            </h3>
            <br/>
        </div>

        <a href="{{ base_url('paymentform/'.$data['slugname']) }}" class="btn btn-primary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back to Payment Screen
        </a>
    </div>
</body>
</html>