<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
        
    public function __construct()
    {
        if (!$this->dx_auth->is_logged_in())
        {
            // redirect to login page
            redirect('security/Auth', 'refresh');
        }


        parent::__construct();
    }

    /**
     * Loads the dashboard and displays total number of customers, total volume, and gross volume of sales for the past 7 days
     */
    public function index()
    {

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->load->library('session');
        
        $data['username'] = $this->session->userdata('DX_username');

        $data['todays_date'] = date('l, F j, Y');

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $begin_date = date("Y-m-d", strtotime('-7 days')); // begin_date = today's date - 7
        $end_date = date("Y-m-d"); // end_date = today

        $data['begin_date'] = '';
        $data['end_date'] = '';

        $data['begin_formatted'] = date("F j, Y", strtotime('-7 days'));
        $data['end_formatted'] = date("F j, Y");

        $this->load->model('Dashboard_model', 'Dashboard');

        // Get the total amount of transaction minus any refunds for the time frame.
        // Void will just be ignored.
        $total_volume = round($this->Dashboard->get_total_amount_by_date($begin_date, $end_date), 2) - round($this->Dashboard->get_total_debit_amount_by_date($begin_date, $end_date), 2);
        $data['total_volume'] = $total_volume;

        // Get the total number of transactions minus any refunded transactions.
        // Voids again will be ignored.
        $total_transactions = $this->Dashboard->get_total_transactions_by_date($begin_date, $end_date) - $this->Dashboard->get_total_debit_transactions_by_date($begin_date, $end_date);;
        $data['total_customers'] = $total_transactions;

        // Use these if you want the entire total transactions/volume (all time)
//        $data['total_volume'] = round($this->Dashboard->get_total_volume(), 2); // round to nearest tenth cent
//        $data['total_customers'] = $this->Dashboard->get_total_transactions();

        $data['total'] = $this->Dashboard->get_total_amount_for_graph_by_date($begin_date, $end_date);

        $data['days_array'] = $this->Dashboard->get_days_array_by_date($begin_date, $end_date);

//        $data['total'] = $this->Dashboard->get_past_seven_days_total();
//        $data['days_array'] = $this->Dashboard->get_days_array();

        $this->load->view('dashboard', $data);
    }

    /**
     * Filters the entire dashboard between two dates of time.
     */
    public function filter_date()
    {



        $data['begin_date'] = date( "Y-m-d", strtotime( $this->input->post('BegDate') ) );
        $data['end_date'] = date( "Y-m-d", strtotime( $this->input->post('EndDate') ) );

        $data['todays_date'] = date('l, F j, Y');

        $data['begin_formatted'] = date('F j, Y', strtotime($data['begin_date']));
        $data['end_formatted'] = date('F j, Y', strtotime($data['end_date']));

        $this->load->model('Dashboard_model', 'Dashboard');

        $data['days_array'] = $this->Dashboard->get_days_array_by_date($data['begin_date'], $data['end_date']);

        $data['total_customers'] = $this->Dashboard->get_total_transactions();

        $data['total_volume'] = round($this->Dashboard->get_total_amount_by_date($data['begin_date'], $data['end_date']), 2);
        $data['total_customers'] = $this->Dashboard->get_total_transactions_by_date($data['begin_date'], $data['end_date']);
        $data['total'] = $this->Dashboard->get_total_amount_for_graph_by_date($data['begin_date'], $data['end_date']);

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('dashboard', $data);
    }
}