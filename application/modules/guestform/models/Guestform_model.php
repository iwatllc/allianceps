<?php

class Guestform_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }

    public function save($data)
    {

        $this->db->insert('guestform_submissions', $data);
        return $this->db->insert_id();

    }


}