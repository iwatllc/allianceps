<?php

class Customer_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }
     
    public function add_customer($data)
    {
        //set uuid column value as UUID
        $this -> db -> set('uuid', 'UUID()', FALSE);

        //insert all together
        $this -> db -> insert('customers',$data);
        
        // get row that was just inserted
        $id = $this -> db -> insert_id();

        return $id;
    }
    
    public function update_customer($id, $data)
    {
        $this -> db -> where('id', $id);
        $this -> db -> update('customers', $data); 
    }

    public function update_customer_enabled_status($id, $status)
    {
        $data['enabled'] = $status;
        
        $this -> db -> where('id', $id);
        $this -> db -> update('customers', $data); 
    }

    public function get_customer($id)
    {
        $row = $this -> db -> select('*') -> where('id', $id) -> get('customers') -> row();

        return $row;
    }

    public function get_customer_listing()
    {
        $query = $this -> db -> select('*') -> get('customers');

        return $query;
    }

    public function update_logo_name($id, $fileName)
    {
        $data['logofile'] = $fileName;
        
        $this -> db -> where('id', $id) 
                    -> update('customers', $data);
    }

    public function check_customer_exists($customername)
    {
        $this -> db -> where('customername', $customername);
        $query = $this -> db -> get('customers');
        if ($query -> num_rows() > 0)
        {
            return true; // name already exists
        } else
        {
            return false; // name does not exist
        }
    }

    public function check_slug_exists($slugname)
    {
        $this -> db -> where('slugname', $slugname);
        $query = $this -> db -> get('customers');
        if ($query -> num_rows() > 0)
        {
            return true;
        } else
        {
            return false;
        }
    }
}