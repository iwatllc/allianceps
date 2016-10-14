<?php

class Paymentform_model extends CI_Model {

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

    public function add_form_submission($data)
    {
        //set uuid column value as UUID
        $this -> db -> set('uuid', 'UUID()', FALSE);

        // Generate length 12 alphanumeric UUID
//            $length = 12;
//            $random = '';
//            for ($i = 0; $i < $length; $i++) {
//                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
//            }
//            $data['uuid'] = $random;
        
        $this -> db -> insert('form_submissions', $data);

        // get row that was just inserted
        $id = $this -> db -> insert_id();

        $q = $this -> db -> get_where('form_submissions', array('id' => $id));
        
        return $q -> row() -> uuid;
    }

    public function update_form_submission($uuid, $data)
    {
        $this -> db -> where('uuid', $uuid);
        $q = $this -> db -> get('form_submissions');
        $this -> db -> flush_cache();
        $this -> db -> where('uuid', $uuid);
        $this -> db -> update('form_submissions', $data);

        return $q -> row() -> uuid;
    }
    
    public function get_customer($uuid)
    {
        $row = $this -> db -> select('*') -> where('uuid', $uuid) -> get('customers') -> row();

        return $row;
    }
}