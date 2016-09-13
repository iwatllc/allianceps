<?php

class Nation_builder_donation extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Creates a reference between a PaymentResponseId and a NationBuilder
     * donation id to allow for updating donations in the future.
     */
    public function add($paymentResponseId, $donationId)
    {
        $data = [
            'PaymentResponseId' => $paymentResponseId,
            'DonationId' => $donationId,
        ];

        $this->db->insert('nation_builder_donation', $data);
        return $this->db->insert_id();
    }

    /*
     * Retrieves a NationBuilder donation id from a PaymentResponseId
     */
    public function getDonationId($paymentResponseId)
    {
        $this->db->from('nation_builder_donation');
        $this->db->where('PaymentResponseId', $paymentResponseId);
        $query = $this->db->get();
        $row = $query->row();

        // TODO: better error handling?
        if(isset($row)) {
            return $row->DonationId;
        } else {
            return null;
        } 
    }
}