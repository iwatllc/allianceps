<?php

class Export_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
     
     /**
      * Pass in the search array and query the database
      * Return the info from the database query
      */
      public function get_export_results($search_array)
      {
          // only search if search_array has something in it
          if (!empty($search_array))
          {
              $this->db->select('*');
              $this->db->from('export_submissions');
              
              if ($search_array['BegDate'] != NULL && $search_array['EndDate'] != NULL && $search_array['BegDate'] != "1969-12-31" && $search_array['EndDate'] != "1969-12-31") {
                  $this->db->where('DATE(export_submissions.InsertDate) >=', $search_array['BegDate'])->where('DATE(export_submissions.InsertDate) <=', $search_array['EndDate']);
              } else if ($search_array['BegDate'] != NULL) {
                  $this->db->where('DATE(export_submissions.InsertDate) >=', $search_array['BegDate']);
              } else if ($search_array['EndDate'] != NULL) {
                  $this->db->where('DATE(export_submissions.InsertDate) <=', $search_array['EndDate']);
              }


			  if ($search_array['TransactionStatusId'] != NULL) {
                  $this->db->where('export_submissions.TransactionStatusId', $search_array['TransactionStatusId']);
              }

              $this->db->order_by('export_submissions.InsertDate', 'DESC');

              return $this->db->get();

          } else {
              // search_array is empty
              return NULL;
          }
          
      }



	public function get_transaction_statuses()
	{
		$query = $this->db->query('SELECT id, status FROM transaction_status WHERE active=1 ORDER BY id');
		$data = array();

        $data[''] = "-All-";
        foreach ($query->result() as $row) {
            $data[$row -> id] = $row -> status;
        }

        return $data;
	}


}