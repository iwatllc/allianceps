<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 4/16/15
 * Time: 12:20 AM
 */

class Payment_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function removeAllPayments() {
        $this->db->from('payment_response'); 
        $this->db->truncate(); 
    }

    public function save($data)
    {
        $this->db->insert('payment_response', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        $this->db->where('PaymentResponseId', $id);
        $this->db->update('payment_response', $data);
    }

	public function get($data) {
		$this->db->from('payment_response');
		$this->db->where($data);
		
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
		    log_message("DEBUG", "getByTransactionIdReturns -> ".$row->TransactionAmount);
			return $row;
		}
	}

    public function getpaymentdetails($transactionfileid){

        $this->db->from('payment_response');
        $this->db->where('transactionfilename', $transactionfileid);
        $query = $this->db->get();
        $row = $query->row();

        if(isset($row)){
            $paymenttransactionid = $row->PaymentTransactionId;
            $paymentsource = $row->PaymentSource;

            $this->db->from('payment_response');
            $this->db->join('transaction_status', 'payment_response.transactionstatusid = transaction_status.id');
            $this->db->join('transaction_type', 'payment_response.transactiontypeid = transaction_type.id');
            $this->db->where('paymenttransactionid', $paymenttransactionid);
            $this->db->where('paymentsource', $paymentsource);
            $this->db->order_by('InsertDate', 'ASC');
            $query = $this->db->get();
            return $query;
        }

        return null;
    }
}