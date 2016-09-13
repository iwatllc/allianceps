<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Void extends MX_Controller {



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
        $paymentTransactionFileId = $this->uri->segment(4);
		$this->load->model('payment/Payment_model', 'Payment');
		$data = array('TransactionFileName' => $paymentTransactionFileId);
		
		$this->load->module('payment');
		$payment = $this->Payment->get($data);
		$result_data = $this->payment->process_void($payment);
		
        $view_vars = array(
            'title' => $this->config->item('Company_Title'). ' | Void Submission Results',
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Title').' Void Transaction ',
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author'),
        );

        $data['page_data'] = $view_vars;
        $data['result_data'] = $result_data;
		$data['payment'] = $payment;
		
        $this->load->view('voidresults', $data);
    }
}