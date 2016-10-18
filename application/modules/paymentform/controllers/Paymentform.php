<?php
/**
 * Created by PhpStorm.
 * User: aaronfrazer
 * Date: 10/10/16
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentform extends MX_Controller
{
    public function __construct()
    {
//        if (!$this->dx_auth->is_logged_in()) {
//            // redirect to login page
//            redirect('security/auth', 'refresh');
//        }

        parent::__construct();
        $this->load->library('session');
    }

    public function index($slug = NULL)
    {
        $this -> load -> model('paymentform_model', '', TRUE);

        // Make sure slug is enabled
        if ($this -> paymentform_model -> customer_enabled($slug))
        {
            show_404();
        }

        // Customer slug
        $data['customer'] = $this -> paymentform_model -> get_customer_form_from_slug($slug);

        // JetDirect URL for testing
//        $data['jd_url'] = 'https://testapp1.jetpay.com/jetdirect/post/cc/process_cc.php';
        $data['jd_url'] = 'https://testapp1.jetpay.com/jetdirect/jdv2/gateway/jp-handler.php';

        // Customer ID
        $data['cid'] = $data['customer'] -> uuid;

        // Approved and declined URLs
        $data['retUrl']    = base_url('paymentresponse/response');
        $data['decUrl']    = base_url('paymentresponse/decline');
        $data['dataUrl']   = base_url('paymentresponse/trans_details');

        // Set Custom Fields
        if ($data['customer'] -> cf1enabled == 1)
        {
            $data['cf1'] = array(
                'name'                  => 'ud1',
                'class'                 => 'input-lg form-control',
                'type'                  => 'text',
                'value'                 => set_value('cf1'),
                'placeholder'           => ($data['customer']->cf1required == 1 ? 'Required' : $data['customer']->cf1name),
                'maxlength'             => '50',
                'required'              => ($data['customer']->cf1required == 1 ? 'required' : ''),
                'data-parsley-required' => ($data['customer']->cf1required == 1 ? 'true' : 'false')
            );
        }
        if ($data['customer'] -> cf2enabled == 1)
        {
            $data['cf2'] = array(
                'name'                  => 'ud2',
                'class'                 => 'input-lg form-control',
                'type'                  => 'text',
                'value'                 => set_value('cf2'),
                'placeholder'           => ($data['customer']->cf2required == 1 ? 'Required' : $data['customer']->cf2name),
                'maxlength'             => '50',
                'required'              => ($data['customer']->cf2required == 1 ? 'required' : ''),
                'data-parsley-required' => ($data['customer']->cf2required == 1 ? 'true' : 'false')
            );
        }
        if ($data['customer'] -> cf3enabled == 1)
        {
            $data['cf3'] = array(
                'name'                  => 'ud3',
                'class'                 => 'input-lg form-control',
                'type'                  => 'text',
                'value'                 => set_value('cf3'),
                'placeholder'           => ($data['customer']->cf3required == 1 ? 'Required' : $data['customer']->cf3name),
                'maxlength'             => '50',
                'required'              => ($data['customer']->cf3required == 1 ? 'required' : ''),
                'data-parsley-required' => ($data['customer']->cf3required == 1 ? 'true' : 'false')
            );
        }
        
        $page_data = array(
            'title'         => $data['customer'] -> customername,
            'description'   => $data['customer'] -> customername,
            'logo'          => $data['customer'] -> logofile,
            'author'        => $data['customer'] -> customername,
        );

        $this->blade
            ->set('data', $data)
            ->set('page_data', $page_data)
            ->render('paymentform');
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