<?php

class Application_settings extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
	}
	
    function set_value($key, $value)
    {
        // CodeIgnitor does not support upsert...
        $this->db->where('key', $key);
        $this->db->from('application_config');

        if($this->db->count_all_results() > 0) {
        	$this->db->where('key', $key);
        	$this->db->update('application_config', ['value' => $value]);
        } else {
        	$this->db->insert('application_config', ['key' => $key, 'value' => $value]);
        }        
    }

    function get_value($key)
    {
		$query = $this->db->get_where('application_config', array('key' => $key));
        $row = $query->row();
        if($row) {
            return $row->value;  
        }
        else {
            return null;
        }
    }
}