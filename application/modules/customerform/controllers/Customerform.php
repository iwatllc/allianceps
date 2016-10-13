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
//        $data['jp_tid']     = 'TESTTERMINAL';
//        $data['jp_key']     = '1234567890abcdefghijk';
//        $data['jp_token']   = '1234567890ABCDEFGHIJKabcdefghijk';
//        $data['cid']        = 'allianceps';
        // END TEST VARIABLES
        
        // JetDirect URL to send form for testing
        $data['jd_url'] = 'https://testapp1.jetpay.com/jetdirect/post/cc/process_cc.php';

        // JetPay info
        //$data['cid'] = $data['customer'] -> uuid;
        $data['cid'] = "TestMerchantCID";

        // Approved and declined URLs
        $data['ret_url']    = base_url('paymentresponse/approved');
        $data['dec_url']    = base_url('paymentresponse/decline');
        $data['data_url']   = base_url('paymentresponse/trans_details');
//        $data['data_url']   = base_url('transaction-record.php');

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
        $slug       = $this -> input -> post('slug');
        $amount     = $this -> input -> post('amount');

        // Get the customerid based on the name of the slug
        $customerid = $this -> customerform_model -> get_customer_form_from_slug($slug) -> id;
        
        // Get current date
        $this -> load -> helper('date');
        $insertdate = mdate("%Y-%m-%d %H:%i:%s", time());

        $data = array(
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'address'       => $address1,
            'address2'      => $address2,
            'city'          => $city,
            'state'         => $state,
            'zip'           => $zip,
            'email'         => $email,
            'customerid'    => $customerid,
            'cf1'           => $cf1,
            'cf2'           => $cf2,
            'cf3'           => $cf3,
            'amount'        => $amount,
            'insertdate'    => $insertdate
        );

        // Insert into form_submissions table
        $uuid = $this -> customerform_model -> add_form_submission($data, $uid);

        // Return JetPay info
        $tid        = "TESTTERMINAL";
        $token      = "1234567890ABCDEFGHIJKabcdefghijk";
        $ordernum   = $uuid;
        $key        = "1234567890abcdefghijk";
        $transtype  = "SALE";

        $hash_vars = $tid . $amount . $token . $ordernum;

        $hash = hash('sha512', $hash_vars);

        $data = array(
            'uuid'          => $uuid,
            'jphash'        => $hash,
            'jpkey'         => $key,
            'jptid'         => $tid,
            'jptranstype'   => $transtype,
        );
        
        echo json_encode($data);
    }

}