<?php

class Donation_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }

    public function removeAllDonations() {
        $this->db->from('donationform_submissions'); 
        $this->db->truncate(); 
    }

    public function save($data)
    {

        $this->db->insert('donationform_submissions', $data);
        return $this->db->insert_id();

    }


}