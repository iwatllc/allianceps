<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/17/15
 * Time: 3:08 PM
 */
class Fileupload_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function import_file($filename, $fileeolcharacters){

        $file_path = FCPATH.'/uploads/'. $filename;
        $table = 'prospect';

        $query_name = "LOAD DATA LOCAL INFILE '"
            . $file_path .
            "' INTO TABLE `"
            . $table .
            "` FIELDS TERMINATED BY ','
             LINES TERMINATED BY '" . $fileeolcharacters . "'
             (firstname,lastname,email)
              ";
        if ( ! $this->db->simple_query($query_name))
        {
            $result = $this->db->error(); // Has keys 'code' and 'message'
        } else {
            $result = array('message' => 'The file was imported sucessfully');
        }

        return $result;

    }

}