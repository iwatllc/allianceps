<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
            border: 3px solid #73AD21;
            padding: 10px;
        }
        div.center {
            margin: auto;
        }
        .centeredtext {
            text-align:center;
        }
        .green {
            color:green;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="center">
            <h1 class="green">
                Payment Successful
            </h1>
            <div class="centeredtext">
                <i class="fa fa-check-circle fa-5x" style="color:green;"></i>
            </div>
            <h2 class="centeredtext">
                Thank You!
            </h2>
            <h4 class="centeredtext">
                Your payment was processed successfully.
            </h4>
            <br/>
                <fieldset>
                    <legend>Order Summary</legend>
                    <strong>Name:</strong> {{ $data['name'] }}
                    <br/>
                    @if ($data['paymentType'] == 'cc')
                    <strong>Card Type:</strong>
                    <img src="{{ $data['cardImage'] }}">
                    <br/>
                    <strong>Card Number:</strong> **** **** **** {{ $data['cardNum'] }}
                    <br/>
                    <strong>Card Expires:</strong> {{ $data['expDate'] }}
                    <br/>
                    @elseif ($data['paymentType'] == 'ach')
                    <strong>Account Number:</strong> {{ $data['obfDdaNum'] }}
                    <br/>
                    @endif
                    <strong>Amount Paid:</strong> ${{ $data['amount'] }}
                    <br/><br/>
                    <strong>Order Number:</strong> {{ $data['order_number'] }}
                    <br/>
                    <strong>Date:</strong> {{ date("m/d/y g:i A") }}
                    <br/>
                    <strong>Transaction ID:</strong> {{ $data['transId'] }}
                    <br/>
                    <strong>Customer ID:</strong> {{ $data['cid'] }}
                    <!--<br/>
                    <strong>Response:</strong> {{ $data['responseText'] }}-->
                </fieldset>
            <br/>
            @if ($data['emailSent'])
                <h5 class="centeredtext">
                     An email receipt including the details about your payment has been sent to your email address.  Please keep it for your records.
                </h5>
            @endif
        </div>

        <br/>

        <a href="{{ base_url($data['slugname']) }}" class="btn btn-primary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Process Another Payment
        </a>
        <a href="javascript:window.print()" class="btn btn-primary" style="float:right;">
            <i class="fa fa-print" aria-hidden="true"></i> PRINT RECEIPT
        </a>
    </div>

    <!--<pre>
        {{ print_r($data) }}
    </pre>-->
</body>
</html>