<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/18/15
 * Time: 4:54 PM
 */
class Prospect_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_matching_list(){

        $this -> db -> query('SET SQL_BIG_SELECTS=1');

        $this->db->limit(100);
        $this->db->select('contributors.*, prospect.* ');
        $this->db->from('contributors');
        $this->db->join('prospect', 'contributors.lastname = prospect.lastname AND contributors.firstname = prospect.firstname');
        //$sql = $this->db->get_compiled_select();
        $query = $this->db->get();
        return $query;

    }


}