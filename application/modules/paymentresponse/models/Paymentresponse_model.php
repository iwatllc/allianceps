<?php

class Paymentresponse_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }

    public function insert_jp_response($data)
    {
        $this -> db -> insert('payment_response', $data);
    }
    
    public function get_customer_by_uuid($uuid)
    {
        $row = $this -> db -> select('*') -> where('uuid', $uuid) -> get('customers') -> row();

        return $row;
    }
}