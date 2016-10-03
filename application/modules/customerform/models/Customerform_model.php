<?php

class Customerform_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }

    public function customer_enabled($slugname)
    {
        $this -> db -> where('slugname', $slugname) -> where('enabled', 1);
        $query = $this -> db -> get('customers');
        if ($query -> num_rows() > 0)
        {
            return false;
        } else
        {
            return true;
        }
    }
    
    public function get_customer_form_from_slug($slug)
    {
        $row = $this -> db -> select('*') -> where('slugname', $slug) -> get('customers') -> row();

        return $row;
    }
    
    public function save($data)
    {
        $this->db->insert('guestform_submissions', $data);
        return $this->db->insert_id();
    }
}