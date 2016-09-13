<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Refund extends MX_Controller {



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
		$payment = $this->Payment->get($data);
        $data['payment'] = $payment;
		
        $view_vars = array(
            'title' => $this->config->item('Company_Title') . ' | Refund Form',
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Title'). ' Refund Form',
            'author' => $this->config->item('Company_Author'),
            'logo' => $this->config->item('Company_Logo'),
            'payment' => $payment
        );
        $data['page_data'] = $view_vars;
		
        $this->load->view('refundform', $data);
    }


    public function submit()
    {
        $this->form_validation->set_rules('paymentamount', 'Payment Amount', 'required');
		$this->form_validation->set_rules('transactionid', 'Transaction Id', 'required');


        if ($this->form_validation->run() == FALSE)
        {
			$paymentTransactionFileId = $this->input->post('transactionfilename');
	        $this->load->model('payment/Payment_model', 'Payment');
			$data = array('TransactionFileName' => $paymentTransactionFileId);
			$payment = $this->Payment->get($data);

            $view_vars = array(
                'title' => $this->config->item('Company_Title') . ' | Refund Form',
                'heading' => $this->config->item('Company_Title'),
                'description' => $this->config->item('Company_Title'). ' Refund Form',
                'author' => $this->config->item('Company_Author'),
                'logo' => $this->config->item('Company_Logo'),
                'payment' => $payment
            );
	        $data['page_data'] = $view_vars;
			
	        $this->load->view('refundform', $data);
        }
        else
        {
        	$submitted_data['transactionfilename'] = $this->input->post('transactionfilename');
			$submitted_data['transactionid'] = $this->input->post('transactionid');
			$submitted_data['amount'] = $this->input->post('paymentamount');
			$submitted_data['ordernumber'] = $this->input->post('ordernumber');
			$submitted_data['paymentdate'] = $this->input->post('insertdate');
			$submitted_data['paymentsource'] = $this->input->post('paymentsource');
			
            // PROCESS CREDIT CARD DATA
            $this->load->module('payment');
            $result_data = $this->payment->process_refund($submitted_data);

            // Gather all the info for the view
            $view_vars = array(
                'title' => $this->config->item('Company_Title') . ' | Refund Form',
                'heading' => $this->config->item('Company_Title'),
                'description' => $this->config->item('Company_Title'). ' Refund Form',
                'author' => $this->config->item('Company_Author'),
                'logo' => $this->config->item('Company_Logo'),
            );
            $data['page_data'] = $view_vars;
            $data['result_data'] = $result_data;
            $data['submitted_data'] = $submitted_data;

            $this->load->view('refundformresults', $data);
        }

    }


    function check_amount($post_string)
    {
        $this->form_validation->set_message('check_default', 'You need to select a state');
        return $post_string == '0' ? FALSE : TRUE;
    }

}