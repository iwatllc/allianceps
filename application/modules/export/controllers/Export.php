<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MX_Controller {
        
    public function __construct()
    {
        if (!$this->dx_auth->is_logged_in())
        {
            // redirect to login page
            redirect('security/auth', 'refresh');
        }
        
        parent::__construct();
    }
    
    public function index()
    {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->load->library('session');

        $this->load->model('Export_model', 'Export');

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );

        $search_array['BegDate'] = '';
        $search_array['EndDate'] = '';
		$search_array['TransactionStatusId'] = '';
		
		$data['search_array'] = $search_array;
		
		$data['transaction_statuses'] = $this->Export->get_transaction_statuses();
        $data['page_data'] = $view_vars;

        $this->load->view('export', $data);
    }
    
    public function execute_export()
    {
        $search_array['BegDate'] = date( "Y-m-d", strtotime( $this->input->post('BegDate') ) );
        $search_array['EndDate'] = date( "Y-m-d", strtotime( $this->input->post('EndDate') ) );
		$search_array['TransactionStatusId'] = $this->input->post('TransactionStatusId');
        
        $this->load->model('Export_model', 'Export');

        $export_data = $this->Export->get_export_results($search_array);

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = 'CSV_Report.csv';
        $csv_data = $this->dbutil->csv_from_result($export_data, $delimiter, $newline);
        force_download($filename, $csv_data);

        $data['search_array'] = $search_array;

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
		$data['transaction_statuses'] = $this->Export->get_transaction_statuses();
        $data['page_data'] = $view_vars;
        
        $this->load->view('export', $data);
    }
}