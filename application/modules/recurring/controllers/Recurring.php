<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 10/21/15
 * Time: 8:30 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring extends MX_Controller {

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

    public function index(){

        // Pull current recurring transactions
        $this->load->model('recurring_model', 'recurring');

        $data['query'] = $this->recurring->get_recurring();

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('recurring', $data);

    }

    public function addrecurring($data) {
        $gateway = $this->config->item('Gateway');

        $recurring_data = array();

        // SUBMIT TO GATEWAY
        if(strcmp($gateway, 'NPC') == 0) {
            //Gateway is NPC
            // $recurring_data = $this->_NPC_post_payment($data);
        } else if(strcmp($gateway, 'NMI') == 0) {
            //Gateway is NMI
            $recurring_data = $this->_NMI_post_recurring($data);
        } else {
            show_error("Unrecognized gateway '". $gateway . "'");
        }

        // SAVE DATA TO RECURRING TABLE (1 IS APPROVED)
        if ($recurring_data['IsApproved'] == 1) {
            $this->load->model('recurring_model', 'Recurring');

            $save_data = array(
                'recurring' => $data['recurring'],
                'plan_payments' => $data['plan_payments'],
                'plan_amount' => $data['plan_amount'],
                'month_frequency' => $data['month_frequency'],
                'day_of_month' => $data['day_of_month'],
                'creditcard' => $data['creditcard'],
                'expirationmonth' => $data['expirationmonth'],
                'expirationyear' => $data['expirationyear'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address1'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip' => $data['zip'],
                'email' => $data['email'],
                'authcode' => $recurring_data['AuthCode'],
                'isapproved' => $recurring_data['IsApproved'],
                'returncode' => $recurring_data['ReturnCode'],
                'responsehtml' => $recurring_data['ResponseHTML'],
                'subscription_id' => $recurring_data['subscription_id'],
                'transactionfilename' => $recurring_data['TransactionFileName'],
                'status' => 'Active',
                'cardtype' => $data['cardtype'],
                'created' => date('Y-n-j H:i:s')
            );

            $this->Recurring->save($save_data);

        }


        return $recurring_data;

    }


    public function cancelrecurring() {
        $subscription_id = $this->uri->segment(3);

        $this->load->model('recurring_model', 'recurring');

        $recurring_data = $this->_NMI_post_cancelrecurring($subscription_id);

        if($recurring_data['IsApproved'] == '1') {
            // Save data and return to the page
            $this->recurring->update_recurring($subscription_id);
            $data['Delete_Success'] = 1;
            $data['Delete_Success_Text'] = 'The recurring transaction has been deleted';
        } else {
            // Send massage it could not be deleted
            $data['Delete_Success'] = 0;
            $data['Delete_Success_Text'] = 'The recurring transaction has not been deleted';
        }


        // Pull current recurring transactions
        $data['query'] = $this->recurring->get_recurring();

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('recurring', $data);

    }


    private function _NMI_post_recurring($data){

        $this->load->module('nmi');
        $result_data = $this->nmi->doCancelRecurring($data);

        return array(
            'AuthCode' => $result_data['authcode'],
            'AVSResponseCode' => $result_data['avsresponse'],
            'OrderNumber' => $result_data['orderid'],
            'IsApproved' => $result_data['response'],
            'CVV2ResponseCode' => $result_data['cvvresponse'],
            'ReturnCode' => $result_data['response_code'],
            'TransactionFileName' => $result_data['transactionid'],
            'ResponseHTML' => $result_data['responsetext'],
            'UpdateDate' => date('Y-n-j H:i:s'),
            'TransactionStatusId' => 1, //Hardcode Approved Transaction Status
            'subscription_id' => $result_data['subscription_id']
        );
    }

    private function _NMI_post_cancelrecurring($data){

        $this->load->module('nmi');
        $result_data = $this->nmi->doCancelRecurring($data);

        return array(
            'AuthCode' => $result_data['authcode'],
            'AVSResponseCode' => $result_data['avsresponse'],
            'OrderNumber' => $result_data['orderid'],
            'IsApproved' => $result_data['response'],
            'CVV2ResponseCode' => $result_data['cvvresponse'],
            'ReturnCode' => $result_data['response_code'],
            'TransactionFileName' => $result_data['transactionid'],
            'ResponseHTML' => $result_data['responsetext'],
            'UpdateDate' => date('Y-n-j H:i:s'),
            'TransactionStatusId' => 1, //Hardcode Approved Transaction Status
            'subscription_id' => $result_data['subscription_id']
        );


    }







}