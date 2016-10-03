<?php

class Contribution_model extends CI_Model {

    public function __construct()
    {
    	$this->load->model('configsys/configsys_model');

    	$this->currentDatabase = $this->db->database;
    	$this->contributionsDatabase = $this->configsys_model->get_config_value('contributions_database_name', 'ezolp_contributions');

        parent::__construct();
    }

    public function removeAllContributors()
    {
    	$this->db->db_select($this->contributionsDatabase);
    	$this->db->from('contributors'); 
		$this->db->truncate(); 

        $this->selectPreviousDatabase();
    }

    public function insertContributor($data)
    {
    	

    	$this->db->db_select($this->contributionsDatabase);
        $this->db->insert('contributors', $data);
        $id = $this->db->insert_id();

        $this->selectPreviousDatabase();

        return $id;
    }

    public function getCommitteeIds() {
    	$committeeIds = array();

    	$this->db->db_select($this->contributionsDatabase);
    	$result = $this->db->query('SELECT `CMTE_ID` FROM `committeemaster`');

    	foreach($result->result_array() as $item){
   			$committeeIds[] = $item['CMTE_ID'];
		}

		$this->selectPreviousDatabase();

		return $committeeIds;
    }

    /*
     * second database.
     */ 
    private function selectPreviousDatabase() {
    	$this->db->db_select($this->currentDatabase);
    }
}