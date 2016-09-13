<?php

class Checkdonationamount_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Pass in the id from donationform_submissions table and query the database for user's info
     * Return query from database
     */
    public function get_donations($donationid)
    {
        $this->db->select('*');
        $this->db->from('form_submissions');
        $this->db->where('id', $donationid);

        $query = $this->db->get();

        //$query = $this->db->query('SELECT firstname, lastname, middleinitial, city, state, zip FROM donationform_submissions UNION ALL SELECT firstname, lastname, middleinitial, city, state, zip FROM api_submissions');

        return $query;
    }

    /**
     * Return all donations from our system.
     */
    public function get_company_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $donation_array['firstname'] = $result->firstname;
            $donation_array['lastname'] = $result->lastname;
            $donation_array['middleinitial'] = $result->middleinitial;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
        }

        $this->db->select('*');
        $this->db->from('form_submissions');
        $this->db->where('firstname', $donation_array['firstname']);
        $this->db->where('lastname', $donation_array['lastname']);
        $this->db->where('middleinitial', $donation_array['middleinitial']);
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip', $donation_array['zip']);


        $query = $this->db->get();

        return $query;
    }

    /**
     * Return number of rows in donations from our system.
     */
    public function get_num_company_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $donation_array['firstname'] = $result->firstname;
            $donation_array['lastname'] = $result->lastname;
            $donation_array['middleinitial'] = $result->middleinitial;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
        }

        $this->db->select('*');
        $this->db->from('form_submissions');
        $this->db->where('firstname', $donation_array['firstname']);
        $this->db->where('lastname', $donation_array['lastname']);
        $this->db->where('middleinitial', $donation_array['middleinitial']);
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip', $donation_array['zip']);


        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * Return the amount of donations from our system.
     */
    public function get_amount_company_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $donation_array['id'] = $result->id;
            $donation_array['firstname'] = $result->firstname;
            $donation_array['lastname'] = $result->lastname;
            $donation_array['middleinitial'] = $result->middleinitial;
            $donation_array['streetaddress'] = $result->address;
            $donation_array['streetadress2'] = $result->address2;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
            $donation_array['notes'] = $result->notes;
            $donation_array['cclast4'] = $result->cclast4;
            $donation_array['amount'] = $result->amount;
            $donation_array['InsertDate'] = $result->insertdate;
        }

        $this->db->select('SUM(amount) AS total_amt');
        $this->db->from('form_submissions');
        $this->db->where('firstname', $donation_array['firstname']);
        $this->db->where('lastname', $donation_array['lastname']);
        $this->db->where('middleinitial', $donation_array['middleinitial']);
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip', $donation_array['zip']);


        $query = $this->db->get();

        return $query->row()->total_amt;

    }

    /**
     * Return the amount of donations from all other systems.
     */
    public function get_num_all_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $fullname = $result->lastname . ', ' . $result->firstname;

            $donation_array['id'] = $result->id;
            $donation_array['name'] = $fullname;
            $donation_array['streetaddress'] = $result->address;
            $donation_array['streetadress2'] = $result->address2;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
            $donation_array['notes'] = $result->notes;
            $donation_array['cclast4'] = $result->cclast4;
            $donation_array['amount'] = $result->amount;
            $donation_array['InsertDate'] = $result->insertdate;
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');
        $this->db->select('*');
        $this->db->from('contributors');
        $this->db->where("(`name` LIKE '%$result->firstname%' AND `name` LIKE '%$result->lastname%')");
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip_code', $donation_array['zip']);


        $query = $this->db->get();

        return $query->num_rows();

    }

    /**
     * Return the amount of donations from all other systems.
     */
    public function get_amount_all_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $fullname = $result->lastname . ', ' . $result->firstname;

            $donation_array['id'] = $result->id;
            $donation_array['name'] = $fullname;
            $donation_array['streetaddress'] = $result->address;
            $donation_array['streetadress2'] = $result->address2;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
            $donation_array['notes'] = $result->notes;
            $donation_array['cclast4'] = $result->cclast4;
            $donation_array['amount'] = $result->amount;
            $donation_array['InsertDate'] = $result->insertdate;
        }

        $this->db->select('SUM(transaction_amt) AS total_amt');
        $this->db->from('contributors');
        $this->db->where("(`name` LIKE '%$result->firstname%' AND `name` LIKE '%$result->lastname%')");
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip_code', $donation_array['zip']);


        $query = $this->db->get();

        return $query->row()->total_amt;

    }

    /**
     * Pass the row returned from the donation form.  Create an array of information for that row.
     * Query the database to see which fields match.  On a match return that row.
     * Return query from database.
     */
    public function get_all_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $fullname = $result->lastname . ', ' . $result->firstname;

            $donation_array['id'] = $result->id;
            $donation_array['name'] = $fullname;
            $donation_array['streetaddress'] = $result->address;
            $donation_array['streetadress2'] = $result->address2;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
            $donation_array['notes'] = $result->notes;
            $donation_array['cclast4'] = $result->cclast4;
            $donation_array['amount'] = $result->amount;
            $donation_array['InsertDate'] = $result->insertdate;
        }

        $this->db->select('*');
        $this->db->from('contributors');
        $this->db->where("(`name` LIKE '%$result->firstname%' AND `name` LIKE '%$result->lastname%')");
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip_code', $donation_array['zip']);


        $query = $this->db->get();

        return $query;
    }

    /**
     * Return the number of rows from both tables.
     */
    public function get_num_total_donations($donationrow)
    {
        $donation_array = array();

        foreach ($donationrow->result() as $result)
        {
            $fullname = $result->lastname . ', ' . $result->firstname;

            $donation_array['fullname'] = $fullname;
            $donation_array['firstname'] = $result->firstname;
            $donation_array['lastname'] = $result->lastname;
            $donation_array['middleinitial'] = $result->middleinitial;
            $donation_array['city'] = $result->city;
            $donation_array['state'] = $result->state;
            $donation_array['zip'] = $result->zip;
        }

        $this->db->select("InsertDate, amount");
        $this->db->from("form_submissions");
        $this->db->where('firstname', $donation_array['firstname']);
        $this->db->where('lastname', $donation_array['lastname']);
        $this->db->where('middleinitial', $donation_array['middleinitial']);
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip', $donation_array['zip']);
        $this->db->get();
        $query1 = $this->db->last_query();

        $this->db->select("transaction_date, transaction_amt");
        $this->db->from("contributors");
        $this->db->where("(`name` LIKE '%$result->firstname%' AND `name` LIKE '%$result->lastname%')");
        $this->db->where('city', $donation_array['city']);
        $this->db->where('state', $donation_array['state']);
        $this->db->where('zip_code', $donation_array['zip']);
        $this->db->get();
        $query2 =  $this->db->last_query();

        $query = $this->db->query($query1." UNION ".$query2);

        return $query->num_rows();
    }

}