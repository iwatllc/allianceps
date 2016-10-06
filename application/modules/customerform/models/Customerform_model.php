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

    public function add_form_submission($data, $uuid)
    {
        $my = 0;

        $this -> db -> where('uuid', $uuid);
        $q = $this -> db -> get('form_submissions');

        if ($q -> num_rows() > 0) // update
        {
            $this -> db -> flush_cache();

            $this -> db -> where('uuid', $uuid);
            $this -> db -> update('form_submissions', $data);
        } else // insert
        {
            //set uuid column value as UUID
            $this -> db -> set('uuid', 'UUID()', FALSE);

            //insert all together
            $this -> db -> insert('form_submissions', $data);

            // get row that was just inserted
            $id = $this -> db -> insert_id();

            $q = $this -> db -> get_where('form_submissions', array('id' => $id));
        }

        return $q -> row() -> uuid;
    }


    public function save($data)
    {
        $this->db->insert('guestform_submissions', $data);
        return $this->db->insert_id();
    }
}