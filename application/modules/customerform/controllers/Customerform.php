<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Customerform extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Loaded in here to make the validation work correctly.
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;

        // Load Required Modules
//        $this->load->module('payment');
        $this->load->module('configsys');
//        $this->load->module('nation_builder');
//        $this->load->module('email_sys');
    }
    
    public function index($slug = NULL)
    {
        $this -> load -> model('customerform_model', '', TRUE);

        // Make sure slug is enabled
        if ($this -> customerform_model -> customer_enabled($slug))
        {
            show_404();
        }

        // Query customer table for the slug
        $data['customer'] = $this -> customerform_model -> get_customer_form_from_slug($slug);
        
        // MERCHANT TESTING VARIABLES
        $data['jp_tid']     = 'TESTTERMINAL';
        $data['jp_key']     = '1234567890abcdefghijk';
        $data['jp_token']   = '1234567890ABCDEFGHIJKabcdefghijk';
        $data['cid']        = 'allianceps';
        // END TEST VARIABLES


        // JetDirect URL to send form for testing
        $data['jd_url'] = 'https://testapp1.jetpay.com/jetdirect/post/cc/process_cc.php';

        // JetPay info
//        $data['jp_tid']     = 'TESTMCC3102X';
//        $data['jp_key']     = 'qyXzTempJRiV8iJJPS8V3st6';
//        $data['jp_token']   = 'vmdkorket3hSV12SuH5knWnOj4oqwW5LHTWV5MUuoVtzPcBJ8VK6vXUgGDwiRNzOMNxSEum7';
//        $data['cid']        = $data['customer'] -> uuid;
        $data['trans_type'] = 'SALE';

        // Approved and declined URLs
        $data['ret_url']    = base_url('paymentresponse/approved');
        $data['dec_url']    = base_url('paymentresponse/decline');
//        $data['data_url']   = base_url('paymentresponse/index');

//        $data['ret_url']    = base_url('assets/approved.php');
//        $data['dec_url']    = base_url('assets/decline.php');
        $data['data_url']   = base_url('assets/transactions.php');

        $view_vars = array(
            'title'         => $this -> configsys -> get_config_value('Client_Title'),
            'heading'       => $this -> configsys -> get_config_value('Client_Title'),
            'description'   => $this -> configsys -> get_config_value('Client_Description'),
            'company'       => $this -> configsys -> get_config_value('Client_Name'),
            'logo'          => $this -> configsys -> get_config_value('Client_Logo'),
            'author'        => $this -> configsys -> get_config_value('Client_Author')
        );
        $data['page_data'] = $view_vars;
        
        $this -> load -> view('paymentform', $data);
    }

    public function ajax_submit_customer_info()
    {
        $this -> load -> model('customerform_model', '', TRUE);

        $uid        = $this -> input -> post('uuid');
        $firstname  = $this -> input -> post('firstname');
        $middleinit = $this -> input -> post('middleinit');
        $lastname   = $this -> input -> post('lastname');
        $email      = $this -> input -> post('email');
        $address1   = $this -> input -> post('address1');
        $address2   = $this -> input -> post('address2');
        $city       = $this -> input -> post('city');
        $state      = $this -> input -> post('state');
        $zip        = $this -> input -> post('zip');
        $cf1        = $this -> input -> post('cf1');
        $cf2        = $this -> input -> post('cf2');
        $cf3        = $this -> input -> post('cf3');
        $notes      = $this -> input -> post('notes');
        $amount     = $this -> input -> post('amount');
        $slug       = $this -> input -> post('slug');

        // Get the customerid based on the name of the slug
        $customerid = $this -> customerform_model -> get_customer_form_from_slug($slug) -> id;
        
        // Get current date
        $this -> load -> helper('date');
        $insertdate = mdate("%Y-%m-%d %H:%i:%s", time());

        $data = array(
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'middleinitial' => $middleinit,
            'address'       => $address1,
            'address2'      => $address2,
            'city'          => $city,
            'state'         => $state,
            'zip'           => $zip,
            'email'         => $email,
            'notes'         => $notes,
            'customerid'    => $customerid,
            'cf1'           => $cf1,
            'cf2'           => $cf2,
            'cf3'           => $cf3,
            'insertdate'    => $insertdate
        );

        // Insert into form_submissions table
        $data['uuid'] = $this -> customerform_model -> add_form_submission($data, $uid);

        echo json_encode($data);
    }

    public function generate_hash()
    {
        $hash_vars = $this -> input -> post('hash_vars');

        $hash = hash('sha512', $hash_vars);
        
        echo $hash;
    }

    /**
     * Begin old functions for guestform.
     */

    /*
     * Handles submission of the guest form
     */
    public function submit()
    {
        log_message('debug', 'GuestForm submitted...');

        // Call helper function to setup form validation
        $this->setup_form_validation();

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            // Construct array of submitted data
            $submitted_data = array(
                'firstname' => $this->input->post('firstname'),
                'middleinitial' => $this->input->post('middleinitial'),
                'lastname' => $this->input->post('lastname'),
                'streetaddress' => $this->input->post('streetaddress'),
                'streetaddress2' => $this->input->post('streetaddress2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip' => $this->input->post('zip'),
                'email' => $this->input->post('email'),
                'notes' => $this->input->post('notes'),
                'cardtype' => $this->input->post('cardtype'),
                'cclast4' => substr($this->input->post('creditcard'), -4),
                'amount' => str_replace( ',', '', $this->input->post('paymentamount') ),
                'InsertDate' => date('Y-n-j H:i:s'),
            );

            // Get insertd record id to use as transaction id.
            $transaction_id = $this->Guestform->save($submitted_data);

            // Add transaction id to submitted data and pass to payment method.
            $submitted_data['transaction_id'] = $transaction_id;
            $submitted_data['creditcard'] = $this->input->post('creditcard');
            $submitted_data['expirationmonth'] = $this->input->post('expirationmonth');
            $submitted_data['expirationyear'] = $this->input->post('expirationyear');
            $submitted_data['cvv2'] = $this->input->post('cvv2');
            $submitted_data['PaymentSource'] = 'GF';

            // Process Credit Card            
            $result_data = $this->payment->process_payment($submitted_data);

            // Was the credit card processed successfully?
            if($result_data['IsApproved'] == '1') {
                // Trigger Events
                Events::trigger('guestform_payment_approved', $this->get_view_data($submitted_data, $result_data), 'string');

                // Handle Guestform Receipt
                if(strcasecmp($this->configsys->get_config_value('Guestform_Sendreceipt'), 'false')) {
                    // Send Receipt
                    $this->email_sys->send_email($submitted_data['email'], 
                        $this->configsys->get_config_value('Guesform_Email_Subject', "Payment Receipt"), 
                        $this->get_email_body());
                }
            }

            // Load the guestform result view
            $this->load->view('guestformresult', $this->get_view_data($submitted_data, $result_data));
        }
    }

    /*
     * Collects all required configuration data for the guestform views
     */
    private function get_view_data($submitted_data = array(), $result_data = array()) {
        log_message('debug', 'Getting GuestForm view data...');

        $data = array();

        // Gather all the info for the view
        $data['client_data'] = array(
            'clientname' => $this->configsys->get_config_value('Client_Name'),
            'clientaddress' => $this->configsys->get_config_value('Client_Address'),
            'clientcity' => $this->configsys->get_config_value('Client_City'),
            'clientstate' => $this->configsys->get_config_value('Client_State'),
            'clientzip' => $this->configsys->get_config_value('Client_Zip'),
            'clientphone' => $this->configsys->get_config_value('Client_Phone'),
            'clientwebsite' => $this->configsys->get_config_value('Client_Website'),
        );

        $data['Guestform_Notes'] = $this->configsys->get_config_value('Guestform_Notes');
        $data['Guestform_Email'] = $this->configsys->get_config_value('Guestform_Email');
        $data['Guestform_Clientform'] = $this->configsys->get_config_value('Guestform_Clientform');
        $data['Guestform_Notes_Label'] = $this->configsys->get_config_value('Guestform_Notes_Label');
        $data['Guestform_Notes_Required'] = $this->configsys->get_config_value('Guestform_Notes_Required');
        $data['Guestform_Email_Required'] = $this->configsys->get_config_value('Guestform_Email_Required');
        $data['Guestform_Signature'] = $this->configsys->get_config_value('Guestform_Signature');
        $data['Guestform_Logo'] = $this->configsys->get_config_value('Guestform_Logo');

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

        return $data;
    }

    /*
     * Configures form validation for the guestform
     */
    private function setup_form_validation() {
        log_message('debug', 'Setting up GuestForm form validation...');

        $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[100]');
        $this->form_validation->set_rules('middleinitial', 'Middle Initial', 'max_length[1]');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[100]');
        $this->form_validation->set_rules('streetaddress', 'Street Address', 'required|max_length[100]');
        $this->form_validation->set_rules('city', 'City', 'required|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'required|callback_check_default');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('creditcard', 'Credit Card', 'required|callback_check_creditcard');
        $this->form_validation->set_rules('expirationmonth', 'Expiration Month', 'required|callback_check_default');
        $this->form_validation->set_rules('expirationyear', 'Expiration Year', 'required');
        $this->form_validation->set_rules('cvv2', 'CVV2 Code', 'required|min_length[3]|max_length[4]');
        $this->form_validation->set_rules('paymentamount', 'Payment Amount', 'required');

        // Handle notes field requirement
        $Guestform_Notes_Required = $this->configsys->get_config_value('Guestform_Notes_Required');
        if ($Guestform_Notes_Required == 'TRUE'){
            $this->form_validation->set_rules('notes', 'Notes', 'required');
        }

        // Handle notes field requirement
        $Guestform_Email_Required = $this->configsys->get_config_value('Guestform_Email_Required');
        if ($Guestform_Email_Required == 'TRUE'){
            $this->form_validation->set_rules('email', 'Email', 'required');
        }
    }

    /*
     * Returns the body for an email receipt
     */
    private function get_email_body() {
        $message = '<!DOCTYPE html><html><body>';
        $message .= '<p>';
        $message .= 'Thank you for your payment';
        $message .= '<br>';
        $message .= 'Please keep this receipt for your records';
        $message .= '<br>';
        $message .= '<hr>';
        $message .= $this->input->post('firstname'). ' ' . $this->input->post('lastname');
        $message .= '<br>';
        $message .= $this->input->post('cardtype'). ' Ending in ' . substr($this->input->post('creditcard'), -4);
        $message .= '<br>';
        $message .= 'Amount Paid: ' . str_replace( ',', '', $this->input->post('paymentamount') );
        $message .= '<br>';
        $message .= 'Date: ' . date('Y-n-j H:i:s') ;
        $message .= '<hr>';
        $message .= '<br>';
        $message .= '</p>';
        $message .= '</body></html>';

        return $message;
    }

    function check_default($post_string)
    {
        $this->form_validation->set_message('check_default', 'You need to select a state');
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