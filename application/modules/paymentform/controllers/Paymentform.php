<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentform extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Loaded in here to make the validation work correctly.
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;

        // Load Required Modules
        $this->load->module('configsys');
    }
    
    public function index($slug = NULL)
    {
        $this -> load -> model('paymentform_model', '', TRUE);

        // Make sure slug is enabled
        if ($this -> paymentform_model -> customer_enabled($slug))
        {
            show_404();
        }

        // Query customer table for the slug
        $data['customer'] = $this -> paymentform_model -> get_customer_form_from_slug($slug);
        
        // JetDirect URL to send form for testing
        $data['jd_url'] = 'https://testapp1.jetpay.com/jetdirect/post/cc/process_cc.php';

        // JetPay info
        $data['cid'] = $data['customer'] -> uuid;

        // Approved and declined URLs
        $data['ret_url']    = base_url('paymentresponse/approved');
        $data['dec_url']    = base_url('paymentresponse/decline');
        $data['data_url']   = base_url('paymentresponse/trans_details');

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

    public function ajax_submit_form()
    {
        $this -> load -> model('paymentform_model', '', TRUE);

        $prev_uuid  = $this -> input -> post('uuid'); // This is only used for updating form_submissions table
        $name       = $this -> input -> post('name');
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
        $cid = $this -> paymentform_model -> get_customer_form_from_slug($slug) -> uuid;

        // Client info (part 1)
        $data = array(
            'name'          => $name,
            'address'       => $address1,
            'address2'      => $address2,
            'city'          => $city,
            'state'         => $state,
            'zip'           => $zip,
            'email'         => $email,
            'cid'           => $cid,
            'cf1'           => $cf1,
            'cf2'           => $cf2,
            'cf3'           => $cf3,
            'amount'        => $amount,
            'insertdate'    => mdate("%Y-%m-%d %H:%i:%s", time())
        );

        // Insert/update form_submissions table
        if (!$prev_uuid)
        {
            $uuid = $this -> paymentform_model -> add_form_submission($data);
        } else
        {
            $uuid = $this -> paymentform_model -> update_form_submission($prev_uuid, $data);
        }

        // Get JetPay info based on Customer ID
        $customer = $this -> paymentform_model -> get_customer($cid);

        // JetPay credentials coming from customer
        $tid        = $customer -> tid;
        $key        = $customer -> jp_key;
        $token      = $customer -> jp_token;
        $ordernum   = $uuid;
        $transtype  = "SALE";

        $hash_vars  = $tid . $amount . $token . $ordernum;
        $hash       = hash('sha512', $hash_vars);

        // Credit card info (part 2)
        $data = array(
            'jp_tid'        => $tid,
            'jp_token'      => $token,
            'order_number'  => $ordernum,
            'jp_key'        => $key,
            'trans_type'    => $transtype,
            'hash_vars'     => $hash_vars,
            'hash'          => $hash
        );

        $uuid = $this -> paymentform_model -> update_form_submission($uuid, $data);

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