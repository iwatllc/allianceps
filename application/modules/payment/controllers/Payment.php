<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 4/13/15
 * Time: 3:38 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load Required Modules
        $this->load->module('nation_builder');
    }

    public function index()
    {
        Echo "index function";
    }

    public function process_payment($data)
    {
        // Save the initial data before processing.
        // SAVE SUBMITTED FORM DATA
        $this->load->model('Payment_model', 'Payment');
		$gateway = $this->config->item('Gateway');
        $payment_data = array(
        	'PaymentTransactionId' => $data['transaction_id'],
            'PaymentSource' => $data['PaymentSource'],
            'TransactionAmount' => $data['amount'],
            'TransactionTypeId' => '1',
            'InsertDate' => date('Y-n-j H:i:s'),
			'Gateway' => $gateway,			
        );
        $payment_id = $this->Payment->save($payment_data);

		log_message('debug', "Gateway is set -> " . $gateway);
		if(strcmp($gateway, 'NPC') == 0) {
			//Gateway is NPC
			$post_payment_data = $this->_NPC_post_payment($data);
		}

		else if(strcmp($gateway, 'NMI') == 0) {
			//Gateway is NMI
			$post_payment_data = $this->_NMI_post_payment($data);	
		}
		else {
			show_error("Unrecognized gateway '". $gateway . "'");
		}

		// check $data for IsApproved = 3 and set transaction status ID to 4
        $this->Payment->update($post_payment_data, $payment_id);

        // Inject payment_id (for use with third party integrations)
        $post_payment_data['PaymentResponseId'] = $payment_id;

        return $post_payment_data;
    }

	private function _NPC_post_payment($data)
	{
		$this->load->module('npc');
        $result_data = $this->npc->post_payment($data);

        return array(
            'AuthCode' => $result_data['AUTHCODE'],
            'SerialNumber' => $result_data['szSerialNumber'],
            'AuthorizationDeclinedMessage' => $result_data['szAuthorizationDeclinedMessage'],
            'AVSResponseCode' => $result_data['szAVSResponseCode'],
            'AVSResponseMessage' => $result_data['szAVSResponseMessage'],
            'OrderNumber' => $result_data['szOrderNumber'],
            'AuthorizationResponseCode' => $result_data['szAuthorizationResponseCode'],
            'IsApproved' => $result_data['szIsApproved'],
            'CVV2ResponseCode' => $result_data['szCVV2ResponseCode'],
            'CVV2ResponseMessage' => $result_data['szCVV2ResponseMessage'],
            'ReturnCode' => $result_data['szReturnCode'],
            'TransactionFileName' => $result_data['szTransactionFileName'],
            'CAVVResponseCode' => $result_data['szCAVVResponseCode'],
            'ResponseHTML' => $result_data['html'],
            'UpdateDate' => date('Y-n-j H:i:s')
        );		
	}
	
	private function _NMI_post_payment($data)
	{
		$this->load->module('nmi');
		$result_data = $this->nmi->doSale($data);

		
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
            'TransactionStatusId' => ($result_data['response'] == '1' ? '1' : '4')
        );
	}
	
	public function process_refund($data)
    {
        $this->load->model('Payment_model', 'Payment');
		$gateway = $this->config->item('Gateway'); //maybe this should be based on payment gateway, but we'd have to change config from static solution

		log_message('debug', "Gateway is set -> " . $gateway);

		if(strcmp($gateway, 'NPC') == 0) {
			//Gateway is NPC
			//TODO: Add NPC Gateway Refund Code
		} else if(strcmp($gateway, 'NMI') == 0) {
			//Gateway is NMI
			$this->load->module('nmi');
			$refund_result_data = $this->_NMI_process_refund($data['transactionfilename'], $data['amount']);

		}
		else {
			show_error("Unrecognized gateway '". $gateway . "'");
		}

		if ($refund_result_data['IsApproved'] == '1' ) {

			$payment_refund_data = array(
                'PaymentTransactionId' => $data['transactionid'],
                'PaymentSource' => $data['paymentsource'],
                'TransactionAmount' => $data['amount'],
                'TransactionTypeId' => '5',
                'InsertDate' => date('Y-n-j H:i:s'),
                'Gateway' => $gateway
			);
			$refund_id = $this->Payment->save($payment_refund_data);

			$this->Payment->update($refund_result_data, $refund_id);

            Events::trigger('payment_refund_approved', $refund_id);
		}

        return $refund_result_data;
    }
	
	private function _NMI_process_refund($transactionId, $transactionAmount)
	{
		$this->load->module('nmi');
		$result_data = $this->nmi->doRefund($transactionId, $transactionAmount);
		
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
            'TransactionStatusId' => 3	//HardCode Refunded Transaction Status
        );
	}
	
	public function process_void($payment)
    {
        $this->load->model('Payment_model', 'Payment');
		$gateway = $this->config->item('Gateway'); //maybe this should be based on payment gateway, but we'd have to change config from static solution

		if(strcmp($gateway, 'NPC') == 0) {
			//Gateway is NPC
			//TODO: Add NPC Gateway Void Code
		}

		else if(strcmp($gateway, 'NMI') == 0) {
			//Gateway is NMI
			$this->load->module('nmi');
			$result_data = $this->_NMI_process_void($payment->TransactionFileName);
			if($result_data['IsApproved'] == 1) {
				$success_void_data = array('VoidResponseHTML' => implode("|", $result_data),
					  					   'TransactionStatusId' => 2, 'TransactionTypeId' => '4',);
				$this->Payment->update($success_void_data, $payment->PaymentResponseId);

                Events::trigger('payment_void_approved', $payment->PaymentResponseId);				  
		    }
		}
		else {
			show_error("Unrecognized gateway '". $gateway . "'");
		}
		return $result_data;
    }

	private function _NMI_process_void($transactionId)
	{
		$this->load->module('nmi');
		$result_data = $this->nmi->doVoid($transactionId);
		
		return array(
            'AuthCode' => $result_data['authcode'],
            'AVSResponseCode' => $result_data['avsresponse'],
            'OrderNumber' => $result_data['orderid'],
            'IsApproved' => $result_data['response'],
            'CVV2ResponseCode' => $result_data['cvvresponse'],
            'ReturnCode' => $result_data['response_code'],
            'TransactionFileName' => $result_data['transactionid'],
            'ResponseHTML' => $result_data['responsetext'],
            'UpdateDate' => date('Y-n-j H:i:s')
        );
	}


    public function checkstatus($transactionid){

        $this->load->model('Payment_model', 'Payment');
        $gateway = $this->config->item('Gateway'); //maybe this should be based on payment gateway, but we'd have to change config from static solution

        if(strcmp($gateway, 'NPC') == 0) {
            //Gateway is NPC
            //TODO: Add NPC Gateway Void Code
        }

        else if(strcmp($gateway, 'NMI') == 0) {
            //Gateway is NMI
            $this->load->module('nmi');
            $result_data = $this->nmi->doQuery($transactionid);

            $status = (string) $result_data->transaction->condition;

        }
        else {
            show_error("Unrecognized gateway '". $gateway . "'");
        }

        return $status;
    }

    public function getstatusdetails($transactionid){

        $this->load->model('Payment_model', 'Payment');
        $gateway = $this->config->item('Gateway'); //maybe this should be based on payment gateway, but we'd have to change config from static solution

        if(strcmp($gateway, 'NPC') == 0) {

            //Gateway is NPC
            //TODO: Add NPC Gateway Void Code

        } else if(strcmp($gateway, 'NMI') == 0) {
            //Gateway is NMI
            $this->load->module('nmi');
            $result_data = $this->nmi->doQuery($transactionid);

        } else {
            show_error("Unrecognized gateway '". $gateway . "'");
        }

        return $result_data;
    }

    public function getpaymentdetails($transactionfileid){

        $this->load->model('Payment_model', 'Payment');
        $gateway = $this->config->item('Gateway'); //maybe this should be based on payment gateway, but we'd have to change config from static solution

        if(strcmp($gateway, 'NPC') == 0) {

            //Gateway is NPC
            //TODO: Add NPC Gateway Void Code

        } else if(strcmp($gateway, 'NMI') == 0) {

            //Gateway is NMI
            $this->load->model('Payment_model', 'Payment');
            $result_data = $this->Payment->getpaymentdetails($transactionfileid);

        } else {
            show_error("Unrecognized gateway '". $gateway . "'");
        }

        return $result_data;
    }



}