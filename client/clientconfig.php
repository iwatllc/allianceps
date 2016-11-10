<?php defined('BASEPATH') OR exit('No direct script access allowed');


$config['base_url'] = 'http://localhost/allianceps/';
// $config['base_url'] = 'https://allywebpay.com';


/***** COMPANY CONFIG ******/
$config['Company_Title'] = 'Alliance Payment Solutions';
$config['Company_Heading'] = 'Company Heading';
$config['Company_Description'] = '';
$config['Company_Author'] = 'Alliance ' . date("Y");
$config['Company_Name'] = 'Alliance Payment Solutions';
$config['Company_Logo'] = 'client/logo.png';
$config['Company_Icon'] = 'client/logo-small.png';
$config['Company_Slogan'] = 'Company Slogan';
/***End Company Config Settings***/

/***** CLIENT CONFIG ******/
// DO NOT ADD ANY MORE CONFIG VARIABLES TO THIS FILE.  WE NEED TO MOVE THEM
// DO THE DATABASE
// $config['Client_Heading'] = 'CLIENT HEADING';
// $config['Client_Description'] = 'CLIENT DESCRIPTION';
// $config['Client_Author'] = 'Client Company ' . date("Y");
// $config['Client_Name'] = 'Client Company Name';
// $config['Client_Logo'] = 'client/client_website/JM-logo.png';
// $config['Client_Slogan'] = 'CLIENT SLOGAN';
/***End Company Config Settings***/

/***** JetPay Config Variables ******/
$config['JetDirect_Url']    = 'https://testapp1.jetpay.com/jetdirect/jdv2/gateway/jp-handler.php';
// $config['JetDirect_Url']    = 'https://extapp01.jetpay.com/jetdirect/jdv2/gateway/jp-handler.php';
$config['JetDirect_retUrl']   = 'paymentresponse/response';
$config['JetDirect_decUrl']   = 'paymentresponse/decline';
$config['JetDirect_dataUrl']  = 'paymentresponse/trans_details';
/***** End JetPay Config Variables ******/
