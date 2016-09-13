<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/8/15
 * Time: 10:08 AM
 */
class Recurring_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {

        $this->db->insert('recurring', $data);
        return $this->db->insert_id();

    }

    public function get_recurring(){

        return $this->db->get_where('recurring', array('status'=>'Active'));

    }

    public function update_recurring($data){

        $update_data = array(
            'status' => 'Deleted',
            'updated' => date('Y-n-j H:i:s')
        );

        $this->db->where('subscription_id', $data);
        $this->db->update('recurring', $update_data);

    }




}