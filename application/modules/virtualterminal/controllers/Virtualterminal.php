<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Virtualterminal extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Loaded in here to make the validation work correctly.
         $this->load->library('form_validation');
         $this->form_validation->CI =& $this;

        $this->load->module('configsys');

        // Your own constructor code
        //$this->dx_auth->check_uri_permissions();

    }

    public function index()
    {
        // Gather all the info for the view
        $clientname = $this->configsys->get_config_value('Client_Name');
        $clientaddress = $this->configsys->get_config_value('Client_Address');
        $clientcity = $this->configsys->get_config_value('Client_City');
        $clientstate = $this->configsys->get_config_value('Client_State');
        $clientzip = $this->configsys->get_config_value('Client_Zip');
        $clientphone = $this->configsys->get_config_value('Client_Phone');
        $clientwebsite = $this->configsys->get_config_value('Client_Website');


        $client_data = array(
            'clientname' => $clientname,
            'clientaddress' => $clientaddress,
            'clientcity' => $clientcity,
            'clientstate' => $clientstate,
            'clientzip' => $clientzip,
            'clientphone' => $clientphone,
            'clientwebsite' => $clientwebsite
        );

        $data['client_data'] = $client_data;

        $data['Virtualterminal_Notes'] = $this->configsys->get_config_value('Virtualterminal_Notes');
        $data['Virtualterminal_Email'] = $this->configsys->get_config_value('Virtualterminal_Email');
        $data['Virtualterminal_Clientform'] = $this->configsys->get_config_value('Virtualterminal_Clientform');

        $view_vars = array(
            'title' => $this->configsys->get_config_value('Client_Title'),
            'heading' => $this->configsys->get_config_value('Client_Title'),
            'description' => $this->configsys->get_config_value('Client_Description'),
            'company' => $this->configsys->get_config_value('Client_Name'),
            'logo' => $this->configsys->get_config_value('Client_Logo'),
            'author' => $this->configsys->get_config_value('Client_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('virtualterminalform', $data);
    }


    public function submit()
    {
        $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[100]');
        $this->form_validation->set_rules('middleinitial', 'Middle Initial', 'max_length[1]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[100]');
        $this->form_validation->set_rules('creditcard', 'Credit Card', 'required|callback_check_creditcard');
        $this->form_validation->set_rules('expirationmonth', 'Expiration Month', 'required|callback_check_month');
        $this->form_validation->set_rules('expirationyear', 'Expiration Year', 'required');
        // $this->form_validation->set_rules('cvv2', 'CVV2 Code', 'required|min_length[3]|max_length[4]');
        $this->form_validation->set_rules('paymentamount', 'Payment Amount', 'required');
        $this->form_validation->set_rules('cardtype', 'Card Type','trim');
        $this->form_validation->set_rules('notes', 'Notes','trim');
        $this->form_validation->set_rules('email', 'Email','trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {

            // SAVE SUBMITTED FORM DATA
            $this->load->model('Virtualterminal_model', 'Virtualterminalform');

            $submitted_data = array(
                'firstname' => $this->input->post('firstname'),
                'middleinitial' => $this->input->post('middleinitial'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'notes' => $this->input->post('notes'),
                'cardtype' => $this->input->post('cardtype'),
                'cclast4' => substr($this->input->post('creditcard'), -4),
                'amount' => str_replace( ',', '', $this->input->post('paymentamount') ),
                'InsertDate' => date('Y-n-j H:i:s')
            );


            // Get insertd record id to use as transaction id.
            $transaction_id = $this->Virtualterminalform->save($submitted_data);

            // Add transaction id to submitted data and pass to payment method.
            $submitted_data['transaction_id'] = $transaction_id;
            $submitted_data['creditcard'] = $this->input->post('creditcard');
            $submitted_data['expirationmonth'] = $this->input->post('expirationmonth');
            $submitted_data['expirationyear'] = $this->input->post('expirationyear');
            $submitted_data['cvv2'] = $this->input->post('cvv2');
            $submitted_data['PaymentSource'] = 'VT';


            // PROCESS CREDIT CARD DATA
            $this->load->module('payment');
            $result_data = $this->payment->process_payment($submitted_data);

            // CHECK TO SEE IF TRANSACTION WENT THROUGH
            if($result_data['IsApproved'] == '1') {
                // SEND EMAIL RECIEPT TO PAYER
                $virtualterminal_sendreceipt = $this->configsys->get_config_value('Virtualterminal_Sendreceipt');
                $virtualterminal_emailsubject = $this->configsys->get_config_value('Virtualterminal_Email_Subject');
                $to_email = $this->input->post('email');
                if ($virtualterminal_sendreceipt == 'TRUE') {
                    if (strlen(trim($to_email)) > 0) {
                        $this->load->module('email_sys');

                        $message = '<!DOCTYPE html><html><body>';
                        $message .= '<p>';
                        $message .= 'Than you for your payment';
                        $message .= '<br>';
                        $message .= 'Please keep this receipt for your records';
                        $message .= '<br>';
                        $message .= '<hr>';
                        $message .= $this->input->post('firstname') . ' ' . $this->input->post('lastname');
                        $message .= '<br>';
                        $message .= $this->input->post('cardtype') . ' Ending in ' . substr($this->input->post('creditcard'), -4);
                        $message .= '<br>';
                        $message .= 'Amount Paid: ' . str_replace(',', '', $this->input->post('paymentamount'));
                        $message .= '<br>';
                        $message .= 'Date: ' . date('Y-n-j H:i:s');
                        $message .= '<hr>';
                        $message .= '<br>';
                        $message .= '</p>';
                        $message .= '</body></html>';

                        $result_info = $this->email_sys->send_email($to_email, $virtualterminal_emailsubject, $message);
                    }
                }
            }



            // Gather all the info for the view
            $clientname = $this->configsys->get_config_value('Client_Name');
            $clientaddress = $this->configsys->get_config_value('Client_Address');
            $clientcity = $this->configsys->get_config_value('Client_City');
            $clientstate = $this->configsys->get_config_value('Client_State');
            $clientzip = $this->configsys->get_config_value('Client_Zip');
            $clientphone = $this->configsys->get_config_value('Client_Phone');
            $clientwebsite = $this->configsys->get_config_value('Client_Website');

            $client_data = array(
                'clientname' => $clientname,
                'clientaddress' => $clientaddress,
                'clientcity' => $clientcity,
                'clientstate' => $clientstate,
                'clientzip' => $clientzip,
                'clientphone' => $clientphone,
                'clientwebsite' => $clientwebsite
            );

            $data['client_data'] = $client_data;

            // Gather all the info for the view
            $data['Virtualterminal_Signature'] = $this->configsys->get_config_value('Virtualterminal_Signature');
            $data['Virtualterminal_Clientform'] = $this->configsys->get_config_value('Virtualterminal_Clientform');
            $view_vars = array(
                'title' => $this->configsys->get_config_value('Client_Title'),
                'heading' => $this->configsys->get_config_value('Client_Title'),
                'description' => $this->configsys->get_config_value('Client_Description'),
                'company' => $this->configsys->get_config_value('Client_Name'),
                'logo' => $this->configsys->get_config_value('Client_Logo'),
                'author' => $this->configsys->get_config_value('Client_Author')
            );
            $data['page_data'] = $view_vars;
            $data['result_data'] = $result_data;
            $data['submitted_data'] = $submitted_data;

            $this->load->view('virtualterminalformresult', $data);
        }



    }


    public function print_test()
    {

        // Gather all the info for the view
        $clientname = $this->configsys->get_config_value('clientname');
        $clientaddress = $this->configsys->get_config_value('clientaddress');
        $clientcity = $this->configsys->get_config_value('clientcity');
        $clientstate = $this->configsys->get_config_value('clientstate');
        $clientzip = $this->configsys->get_config_value('clientzip');
        $clientphone = $this->configsys->get_config_value('clientphone');
        $clientwebsite = $this->configsys->get_config_value('clientwebsite');

        $client_data = array(
            'clientname' => $clientname,
            'clientaddress' => $clientaddress,
            'clientcity' => $clientcity,
            'clientstate' => $clientstate,
            'clientzip' => $clientzip,
            'clientphone' => $clientphone,
            'clientwebsite' => $clientwebsite
        );

        $data['client_data'] = $client_data;

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $post_payment_data = array(
            'OrderNumber' => '77777',
            'IsApproved' => 1,
            'ReturnCode' => 'ReturnCode',
            'ResponseHTML' => 'This is the response HTML',
            'UpdateDate' => date('Y-n-j H:i:s')
        );
        $result_data = $post_payment_data;
        $data['result_data'] = $result_data;


        $submitted_data['transaction_id'] = '12345676';
        $submitted_data['creditcard'] = '1111';
        $submitted_data['expirationmonth'] = '08';
        $submitted_data['expirationyear'] = 2012;
        $submitted_data['cvv2'] = '123';
        $submitted_data['PaymentSource'] = 'VT';
        $submitted_data['amount'] = '125.34';
        $submitted_data['cclast4'] = '4444';
        $submitted_data['name'] = 'John Doe';

        $data['submitted_data'] = $submitted_data;

        $this->load->view('virtualterminalformresult', $data);

    }



    function check_month($post_string)
    {
        $this->form_validation->set_message('check_month', 'You need to select a month');
        return $post_string == '0' ? FALSE : TRUE;
    }

    function check_creditcard($post_string)
    {
        $result = TRUE;
        $creditcard = $post_string;
        $creditcard = str_replace(' ', '', $creditcard);
        $cc_length = strlen($creditcard);

        if ($cc_length < '15') {
            $this->form_validation->set_message('check_creditcard', 'Credit Card Number is not correct');
            $result = FALSE;
        } else if ($cc_length > '16') {
            $this->form_validation->set_message('check_creditcard', 'Credit Card Number is not correct');
            $result = FALSE;
        }

        return $result;
    }

}