<?php
/**
 * Created by Aptana.
 * User: gregarnold
 * Date: 8/27/15
 * Time: 7:07 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Donation extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Loaded in here to make the validation work correctly.
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;

        // Load Required Modules
        $this->load->module('payment');
        $this->load->module('configsys');
        $this->load->module('nation_builder');
        $this->load->module('email_sys');

        // Load Required Models
        $this->load->model('Donation_model', 'Donation');
    }

    /*
     * Handles the default view
     */
    public function index()
    {
        // Display the guestform index
        $this->load->view('donationform', $this->get_view_data());
    }

    /*
     * Handles submission of the donation form
     */
    public function submit()
    {
        log_message('debug', 'Donation form submitted...');

        // Call helper function to setup form validation
        $this->setup_form_validation();

        $isrecurring = $this->input->post('recurring');

        if ($this->form_validation->run($this) == false)
        {
        	$this->index();
        }
        else {
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
                'notes' => $this->input->post('notes'),
                'employer' => $this->input->post('employer'),
                'occupation' => $this->input->post('occupation'),
                'email' => $this->input->post('email'),
                'cardtype' => $this->input->post('cardtype'),
                'cclast4' => substr($this->input->post('creditcard'), -4),
                'amount' => $this->get_payment_amount(),
                'ip' => $this->input->ip_address(),
                'InsertDate' => date('Y-n-j H:i:s')
            );

            // Get inserted record id to use as transaction id.
            $transaction_id = $this->Donation->save($submitted_data);

            // Add transaction id to submitted data and pass to payment method.
            $submitted_data['transaction_id'] = $transaction_id;
            $submitted_data['creditcard'] = $this->input->post('creditcard');
            $submitted_data['expirationmonth'] = $this->input->post('expirationmonth');
            $submitted_data['expirationyear'] = $this->input->post('expirationyear');
            $submitted_data['cvv2'] = $this->input->post('cvv2');
            $submitted_data['PaymentSource'] = 'DF';

            // Process Credit Card  
            $result_data = $this->payment->process_payment($submitted_data);
            $result_data_recurring = array();

            // Was the credit card processed successfully?
            if($result_data['IsApproved'] == '1') {
                // Trigger Events
                Events::trigger('donation_payment_approved', $this->get_view_data($submitted_data, $result_data), 'string');

                // Handle donationform receipt
                if(strcasecmp($this->configsys->get_config_value('Donationform_Sendreceipt'), 'false')) {
                    // Send Receipt
                    $this->email_sys->send_email($submitted_data['email'], 
                        $this->configsys->get_config_value('Donationform_Email_Subject', "Payment Receipt"), 
                        $this->get_email_body());
                }

                // Handle Recurring Dontation
                if($isrecurring == 'recurring') {
                    $recurring_data['recurring'] ='add_subscription';
                    $recurring_data['plan_payments'] = '0';
                    $recurring_data['plan_amount'] = $this->get_payment_amount();
                    $recurring_data['month_frequency'] = '1';
                    $recurring_data['day_of_month'] = date('d');
                    $recurring_data['creditcard'] = $this->input->post('creditcard');
                    $recurring_data['expirationmonth'] = $this->input->post('expirationmonth');
                    $recurring_data['expirationyear'] = $this->input->post('expirationyear');
                    $recurring_data['cardtype'] = $this->input->post('cardtype');
                    $recurring_data['first_name'] = $this->input->post('firstname');
                    $recurring_data['last_name'] = $this->input->post('lastname');
                    $recurring_data['address1'] = $this->input->post('streetaddress');
                    $recurring_data['city'] = $this->input->post('city');
                    $recurring_data['state'] = $this->input->post('state');
                    $recurring_data['zip'] = $this->input->post('zip');
                    $recurring_data['email'] = $this->input->post('email');

                    $this->load->module('recurring');
                    $result_data_recurring = $this->recurring->addrecurring($recurring_data);

                    $data['result_data_recurring'] = $result_data_recurring;
                }
            }

            // Load the donation form result view
            $this->load->view('donationformresult', $this->get_view_data($submitted_data, $result_data, $result_data_recurring));
        }
    }

    /*
     * Collects all required configuration data for the donation form views
     */
    private function get_view_data($submitted_data = array(), $result_data = array(), $recurring_data = array()) {
        log_message('debug', 'Getting Donation view data...');

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

        $data['Donationform_Email_Required'] = $this->configsys->get_config_value('Donationform_Email_Required');

        $data['Donationform_Notes'] = $this->configsys->get_config_value('Donationform_Notes');

        $data['Donationform_Logo'] = $this->configsys->get_config_value('Donationform_Logo');

        $clientname = $this->configsys->get_config_value('Client_Name');

        $view_vars = array(
            'title' => '',
            'heading' => $this->config->item('Client_Heading'),
            'description' => $this->config->item('Client_Description'),
            'company' => $clientname,
            'logo' => $this->config->item('Client_Logo'),
            'slogan' => '',
            'author' => $this->config->item('Client_Author')
        );
        $data['page_data'] = $view_vars;
        $data['result_data'] = $result_data;
        $data['submitted_data'] = $submitted_data;

        if(isset($recurring_data[0])) {
            $data['is_recurring'] = $recurring_data[0];
        } else {
            $data['is_recurring'] = false;
        }

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
        $this->form_validation->set_rules('employer', 'Employer', 'required|max_length[100]');
        $this->form_validation->set_rules('occupation', 'Occupation', 'required|max_length[100]');
        $this->form_validation->set_rules('creditcard', 'Credit Card', 'required|callback_check_creditcard');
        $this->form_validation->set_rules('expirationmonth', 'Expiration Month', 'required');
        $this->form_validation->set_rules('expirationyear', 'Expiration Year', 'required');
        $this->form_validation->set_rules('cvv2', 'CVV2 Code', 'required|min_length[3]|max_length[4]');
        $this->form_validation->set_rules('paymentamount', 'Payment Amount', 'required');
        $this->form_validation->set_rules('otheramount', 'Other Amount', 'trim|callback_check_otheramount');
        $this->form_validation->set_rules('recurring', 'Recurring','trim');
        $this->form_validation->set_rules('cardtype', 'Card Type','trim');

        // Handle notes field requirement
        $Donationform_Notes_Required = $this->configsys->get_config_value('Donationform_Notes_Required');
        if ($Donationform_Notes_Required == 'TRUE'){
            $this->form_validation->set_rules('notes', 'Notes', 'required');
        }

        // Handle notes field requirement
        $Donationform_Email_Required = $this->configsys->get_config_value('Donationform_Email_Required');
        if ($Donationform_Email_Required == 'TRUE'){
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
        $message .= $this->input->post('firstname') . ' ' . $this->input->post('middleinitial') . ' ' . $this->input->post('lastname');
        $message .= '<br>';
        $message .= $this->input->post('address');
        $message .= '<br>';
        if (strlen(trim($this->input->post('address2'))) <> 0) {
            $message .= $this->input->post('address2');
            $message .= '<br>';
        }
        $message .= $this->input->post('city') . ', ' . $this->input->post('state') . ' ' . $this->input->post('zip');
        $message .= '<br>';
        $message .=  'Email: ' . $this->input->post('email');
        $message .= '<br>';
        $message .= '<br>';
        $message .=  'Employer: ' . $this->input->post('employer');
        $message .= '<br>';
        $message .=  'Occupation: ' . $this->input->post('occupation');
        $message .= '<br>';
        if (strlen(trim($this->input->post('notes'))) <> 0) {
            $message .= '<br>';
            $message .= 'Notes: ' . $this->input->post('notes');
            $message .= '<br>';
        }
        $message .= '<br>';
        $message .= $this->input->post('cardtype'). ' Ending in ' . substr($this->input->post('creditcard'), -4);
        $message .= '<br>';
        $message .= 'Amount Paid: ' . str_replace( ',', '', $this->get_payment_amount());
        $message .= '<br>';
        $message .= 'Date: ' . date('Y-n-j H:i:s') ;
        $message .= '<hr>';
        $message .= '<br>';
        $message .= '</p>';
        $message .= '</body></html>';

        return $message;
    }

    /*
     * Returns the amount the user paid
     */
    private function get_payment_amount() {
        // Determine Payment Amount
        if(strcasecmp($this->input->post('paymentamount'), 'other') == 0) {
            $payment_amount = str_replace( ',', '', $this->input->post('otheramount') );
        } else {
            $payment_amount = str_replace( ',', '', $this->input->post('paymentamount') );
        }

        return $payment_amount;
    }

    function check_default($post_string)
    {
        $this->form_validation->set_message('check_default', 'You need gito select a state');
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

	function check_otheramount($post_string)
    {
    	$paymentamount = $this->input->post('paymentamount');
		
		log_message('debug', 'Payment amount = '.$paymentamount);
		
		if(strcasecmp($paymentamount, 'other') == 0) {
			if(strlen($post_string) == 0) {
				log_message('debug', 'check_otheramount FAILED length check = '.$post_string);
				$this->form_validation->set_message('check_otheramount', 'Enter a donation amount');
				return FALSE;
			}
			else if(is_numeric($post_string) == FALSE) {
				log_message('debug', 'check_otheramount FAILED is_numeric check = '.$post_string);
				$this->form_validation->set_message('check_otheramount', 'Amount must be numeric');
				return FALSE;
			}
			else if($post_string <= 0) {
				log_message('debug', 'check_otheramount FAILED > 0 check = '.$post_string);
				$this->form_validation->set_message('check_otheramount', 'Amount must greater than 0');
				return FALSE;
			}
		}
        return TRUE;
    }
}