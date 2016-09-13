<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/20/15
 * Time: 9:00 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."modules/restapi/libraries/REST_Controller.php";

class Restapi extends REST_Controller
{
    function payment_get()
    {
        $this->load->module('payment');
        $this->load->module('configsys');
    }

    function api_get()
    {
        $this->load->view('apitest');
    }

    function payment_post()
    {

        $this->load->module('configsys');

        $submitted_data = array(
            'firstname' => $this->post('firstname'),
            'middleinitial' => $this->post('middleinitial'),
            'lastname' => $this->post('lastname'),
            'address' => $this->post('address'),
            'address2' => $this->post('address2'),
            'city' => $this->post('city'),
            'state' => $this->post('state'),
            'zip' => $this->post('zip'),
            'employer' => $this->post('employer'),
            'occupation' => $this->post('occupation'),
            'email' => $this->post('email'),
            'notes' => $this->post('notes'),
            'cardtype' => $this->post('cardtype'),
            'cclast4' => substr($this->post('cc-number'), -4),
            'amount' => str_replace( ',', '', $this->post('numeric') ),
            'InsertDate' => date('Y-n-j H:i:s')
        );

        $this->load->model('Restapi_model', 'Restapi');
        $transaction_id = $this->Restapi->save($submitted_data);

        list($expmonth, $expyear) = explode("/", $this->post('cc-exp'));

        // Add transaction id to submitted data and pass to payment method.
        $submitted_data['transaction_id'] = $transaction_id;
        $submitted_data['creditcard'] = $this->post('cc-number');
        $submitted_data['expirationmonth'] = trim($expmonth);
        $submitted_data['expirationyear'] = trim($expyear);
        $submitted_data['cvv2'] = $this->post('cc-cvc');
        $submitted_data['PaymentSource'] = 'AF';


        // PROCESS CREDIT CARD DATA
        ini_set('display_errors', 'On');
        ini_set('html_errors', 0);
        $this->load->module('payment');
        $result_processpayment = $this->payment->process_payment($submitted_data);

        // SEND EMAIL RECIEPT TO PAYER
        if ($result_processpayment['IsApproved'] == '1'){
            $api_sendreceipt = $this->configsys->get_config_value('Api_Sendreceipt');
            $api_emailsubject = $this->configsys->get_config_value('Api_Email_Subject');
            $to_email = $this->post('email');
            if ($api_sendreceipt == 'TRUE') {
                if (strlen(trim($to_email)) > 0) {
                    $this->load->module('email_sys');

                    $message = '<!DOCTYPE html><html><body>';
                    $message .= '<p>';
                    $message .= 'Thank you for your payment';
                    $message .= '<br>';
                    $message .= 'Please keep this receipt for your records';
                    $message .= '<br>';
                    $message .= '<hr>';
                    $message .= $this->post('firstname') . ' ' . $this->post('middleinitial') . ' ' . $this->post('lastname');
                    $message .= '<br>';
                    $message .= $this->post('address');
                    $message .= '<br>';
                    if (strlen(trim($this->post('address2'))) <> 0) {
                        $message .= $this->post('address2');
                        $message .= '<br>';
                    }
                    $message .= $this->post('city') . ', ' . $this->post('state') . ' ' . $this->post('zip');
                    $message .= '<br>';
                    $message .=  'Email: ' . $this->post('email');
                    $message .= '<br>';
                    $message .= '<br>';
                    $message .=  'Employer: ' . $this->post('employer');
                    $message .= '<br>';
                    $message .=  'Occupation: ' . $this->post('occupation');
                    $message .= '<br>';
                    if (strlen(trim($this->post('notes'))) <> 0) {
                        $message .= '<br>';
                        $message .= 'Notes: ' . $this->post('notes');
                        $message .= '<br>';
                    }
                    $message .= '<br>';
                    $message .= $this->post('cardtype') . ' Ending in ' . substr($this->post('cc-number'), -4);
                    $message .= '<br>';
                    $message .= 'Amount Paid: ' . str_replace(',', '', $this->post('numeric') );
                    $message .= '<br>';
                    $message .= '<br>';
                    $message .= 'Date: ' . date('Y-n-j H:i:s');
                    $message .= '<hr>';
                    $message .= '<br>';
                    $message .= '</p>';
                    $message .= '</body></html>';

                    $result_sendemail = $this->email_sys->send_email($to_email, $api_emailsubject, $message);

                    // At some point we might want to check and give response to the page if the email was sent.
                    $data['result_sendemail'] = $result_sendemail;
                }
            }
        }

        $data['result_processpayment'] = $result_processpayment;

        $this->response($data, 200);


    }

}