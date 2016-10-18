<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: iWAT
 * Date: 10/15/2016
 * Time: 10:31 PM
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
            <fieldset>
                <legend>Error Details</legend>
                <strong>Transaction ID:</strong> {{ $data['transId'] }}
                <br/>
                <strong>Order Number:</strong> {{ $data['order_number'] }}
                <br/><br/>
                @if ($data['name'])
                    <strong>Name:</strong> {{ $data['name'] }}
                    <br/>
                @endif
                @if ($data['cardNum'])
                    <strong>Card Number:</strong> **** **** **** {{ $data['cardNum'] }}
                    <br/>
                @endif
                @if ($data['amount'])
                    <strong>Amount Attempted:</strong> ${{ $data['amount'] }}
                    <br/>
                @endif
                <strong>Date:</strong> {{ date("m/d/y g:i A") }}
                <br/><br/>
                <strong>Response:</strong> {{ $data['responseText'] }}
                <br/><br/>
            </fieldset>
            <br/>
        </div>

        <a href="{{ base_url('paymentform/'.$data['slugname']) }}" class="btn btn-primary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back to Payment Screen
        </a>
    </div>
</body>
</html>