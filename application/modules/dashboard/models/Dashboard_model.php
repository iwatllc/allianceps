<?php

class Dashboard_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Return the entire amount thus far from payment_response table.
     *
     * SELECT SUM(TransactionAmount) FROM payment_response
     */
    public function get_total_volume()
    {
        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');

        $query = $this->db->get();

        return $query->row()->TransactionAmount;
    }


    /**
     * Returns the number of transactions from tables.
     *
     * guestform_submissions, virtualterminal_submissions
     * SQL:
     * SELECT DISTINCT Name FROM virtualterminal_submissions
     * UNION
     * SELECT DISTINCT name FROM guestform_submissions
     *
     * Note: Codeigniter does not support UNION, so I had to write my own query
     *
     */
    public function get_total_transactions()
    {
        $this->db->select('id');
        $this->db->from('virtualterminal_submissions');
        $this->db->get();
        $query1 = $this->db->last_query();

        $this->db->select('id');
        $this->db->from('guestform_submissions');
        $this->db->get();
        $query2 = $this->db->last_query();

        $query = $this->db->query($query1." UNION ".$query2);

        return $query->num_rows();
    }


    public function get_days_array()
    {
        $days_array = array();

        $time = time();

        // Get the past 7 days of the week and store it in $days_array
        for ($x = 0; $x < 7; $x++)
        {
            $days_array[$x] = date("M d", mktime(0,0,0,date("n", $time),date("j",$time) - $x ,date("Y", $time)));
        }

        return $days_array;
    }

    /**
     * Returns an array of dates to be used in the dashboard graph.
     *
     * @param $begin_date
     * @param $end_date
     * @return array
     */
    public function get_days_array_by_date($begin_date, $end_date)
    {
        $days_array = array();

        $time = time();

        $begin_date = new DateTime($begin_date);
        $end_date = new DateTime($end_date);

        $diff = $end_date->diff($begin_date)->format("%a"); // finds the difference between two dates as a number

        // Get the difference of days and store it in $days_array
        for ($x = 0; $x <= $diff; $x++)
        {
            $days_array[$x] = date("M d", mktime(0,0,0,date("n", date_format($begin_date, 'U')),date("j", date_format($begin_date, 'U')) + $x ,date("Y", date_format($begin_date, 'U')))); // 2015-10-04
        }

        return $days_array;
    }

    /**
     * Returns the total amount within a given date (day) that was approved
     *
     * SELECT SUM(TransactionAmount) FROM payment_response WHERE InsertDate BETWEEN '2015-05-16 00:00:00' AND '2015-05-16 23:59:59'
     * WHERE TransactionStatusID = 1 (1 = Approved).
     */
    public function get_total_amount_by_date($begin_date, $end_date)
    {
        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');

        if ($begin_date != NULL && $end_date != NULL && $begin_date != "1969-12-31" && $end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date)->where('DATE(payment_response.InsertDate) <=', $end_date);

        } else if ($begin_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date);

        } else if ($end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) <=', $end_date);
        }

        $this->db->where('TransactionStatusID', '1');

        $query = $this->db->get();

        return $query->row()->TransactionAmount;
    }


    /**
     * Returns the total amount within a given date (day) that was approved
     *
     * SELECT SUM(TransactionAmount) FROM payment_response WHERE InsertDate BETWEEN '2015-05-16 00:00:00' AND '2015-05-16 23:59:59'
     * WHERE TransactionStatusID = 1 (1 = Approved).
     */
    public function get_total_debit_amount_by_date($begin_date, $end_date)
    {
        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');

        if ($begin_date != NULL && $end_date != NULL && $begin_date != "1969-12-31" && $end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date)->where('DATE(payment_response.InsertDate) <=', $end_date);

        } else if ($begin_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date);

        } else if ($end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) <=', $end_date);
        }

        $this->db->where('TransactionStatusID', '3');

        $query = $this->db->get();

        return $query->row()->TransactionAmount;
    }



    /**
     * Get the number of approved transactions for a date range.
     */
    public function get_total_transactions_by_date($begin_date, $end_date)
    {

        $this->db->select('*');
        $this->db->from('payment_response');

        if ($begin_date != NULL && $end_date != NULL && $begin_date != "1969-12-31" && $end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date)->where('DATE(payment_response.InsertDate) <=', $end_date);

        } else if ($begin_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date);

        } else if ($end_date != "1969-12-31")
        {
            $this->db->where('DATE(payment_response.InsertDate) <=', $end_date);
        }

        $this->db->where('TransactionStatusID', '1');

        $query = $this->db->get();

        return  $query->num_rows();

    }

    /**
     * Get the number of refunded transactions for a date range.
     */
    public function get_total_debit_transactions_by_date($begin_date, $end_date)
    {

        $this->db->select('*');
        $this->db->from('payment_response');

        if ($begin_date != NULL && $end_date != NULL && $begin_date != "1969-12-31" && $end_date != "1969-12-31") {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date)->where('DATE(payment_response.InsertDate) <=', $end_date);

        } else if ($begin_date != "1969-12-31") {
            $this->db->where('DATE(payment_response.InsertDate) >=', $begin_date);

        } else if ($end_date != "1969-12-31") {
            $this->db->where('DATE(payment_response.InsertDate) <=', $end_date);
        }

        $this->db->where('TransactionStatusID', '3');

        $query = $this->db->get();

        return $query->num_rows();

    }



    /**
     * Return the amount from the past seven days given the current day.
     */
    public function get_past_seven_days_total()
    {
        $days_array = array();

        $time = time();

        $today = date('Y-m-d'); // 2015-10-05
        $day1 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 1 ,date("Y", $time))); // 2015-10-04
        $day2 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 2 ,date("Y", $time))); // 2015-10-03
        $day3 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 3 ,date("Y", $time))); // 2015-10-02
        $day4 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 4 ,date("Y", $time))); // 2015-10-01
        $day5 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 5 ,date("Y", $time))); // 2015-09-30
        $day6 = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) - 6 ,date("Y", $time))); // 2015-09-29

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $today . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $today . ' 23:59:59');
        $query = $this->db->get();
        $result0 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day1 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day1 . ' 23:59:59');
        $query = $this->db->get();
        $result1 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day2 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day2 . ' 23:59:59');
        $query = $this->db->get();
        $result2 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day3 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day3 . ' 23:59:59');
        $query = $this->db->get();
        $result3 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day4 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day4 . ' 23:59:59');
        $query = $this->db->get();
        $result4 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day5 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day5 . ' 23:59:59');
        $query = $this->db->get();
        $result5 = $query->row()->TransactionAmount;

        $this->db->select_sum('TransactionAmount');
        $this->db->from('payment_response');
        $this->db->where('DATE(payment_response.InsertDate) >=', $day6 . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $day6 . ' 23:59:59');
        $query = $this->db->get();
        $result6 = $query->row()->TransactionAmount;

        $days_array[0] = $result0;
        $days_array[1] = $result1;
        $days_array[2] = $result2;
        $days_array[3] = $result3;
        $days_array[4] = $result4;
        $days_array[5] = $result5;
        $days_array[6] = $result6;

        return $days_array;
    }


    /**
     * Return the amount from the specified begin date and end date.
     */
    public function get_total_amount_for_graph_by_date($begin_date, $end_date)
    {
        $days_array = array();

        $result_array = array();

        // Find the difference between begin and end date
        $begin_date = new DateTime($begin_date);
        $end_date = new DateTime($end_date);

        $diff = $end_date->diff($begin_date)->format("%a"); // finds the difference between two dates as a number

        for ($i = 0; $i <= $diff; $i++)
        {
            $days_array[$i] = date("Y-m-d", mktime(0,0,0,date("n", date_format($begin_date, 'U')),date("j", date_format($begin_date, 'U')) + $i ,date("Y", date_format($begin_date, 'U')))); // 2015-10-04

            $this->db->select_sum('TransactionAmount');
            $this->db->from('payment_response');
            $this->db->where('DATE(payment_response.InsertDate) >=', $days_array[$i] . ' 00:00:00')->where('DATE(payment_response.InsertDate) <=', $days_array[$i] . ' 23:59:59');
            $this->db->where('TransactionStatusID', '1');
            // $sql = $this->db->get_compiled_select();
            $query = $this->db->get();
            $result_array[$i] = $query->row()->TransactionAmount;
        }

        return $result_array;
    }
}