<?php

class Configsys_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function set_value($key, $value)
    {
        // CodeIgnitor does not support upsert...
        $this->db->where('key', $key);
        $this->db->from('system_config');

        if($this->db->count_all_results() > 0) {
            $this->db->where('key', $key);
            $this->db->update('system_config', ['value' => $value]);
        } else {
            $this->db->insert('system_config', ['key' => $key, 'value' => $value]);
        }        
    }

    function get_value($key)
    {
        $query = $this->db->get_where('system_config', array('key' => $key));
        $row = $query->row();
        if($row) {
            return $row->value;  
        }
        else {
            return null;
        }
    }

    function get_config_value($key, $defaultValue = "")
    {
        $value = $this->get_value($key);
        if($value != null) {
            return $value;  
        }
        else {
            return $defaultValue;
        }
    }

}