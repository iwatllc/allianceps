<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/23/15
 * Time: 4:49 PM
 */
class Restapi_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {

        $this->db->insert('api_submissions', $data);
        return $this->db->insert_id();

    }


}