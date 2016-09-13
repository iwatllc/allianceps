<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contributionreport extends MX_Controller {
        
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
        $data['todays_date'] = date('l, F j, Y');

        // By default, the date filter will display info for the past 7 days starting from today
        $begin_date = date("Y-m-d", strtotime('-7 days')); // begin_date = today's date - 7
        $end_date = date("Y-m-d"); // end_date = today

        $data['begin_date'] = '';
        $data['end_date'] = '';

        $data['begin_formatted'] = date("F j, Y", strtotime('-7 days'));
        $data['end_formatted'] = date("F j, Y");

        $this->load->model('Contributionreport_model', 'Contributionreport');

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        // New code with dates
        // $data['results'] = $this->Contributionreport->get_total_amounts_donated_through_company_by_date($begin_date, $end_date);
        $data['results'] = $this->Contributionreport->get_matching_list($begin_date, $end_date);

        $this->load->view('contributionreport', $data);
    }

    /**
     * Filter the Contribution Report for insert dates on company donations.
     */
    public function filter_date()
    {
        $data['begin_date'] = date( "Y-m-d", strtotime( $this->input->post('BegDate') ) );
        $data['end_date'] = date( "Y-m-d", strtotime( $this->input->post('EndDate') ) );

        $data['begin_formatted'] = date('F j, Y', strtotime($data['begin_date']));
        $data['end_formatted'] = date('F j, Y', strtotime($data['end_date']));

        $this->load->model('Contributionreport_model', 'Contributionreport');

        //$data['results'] = $this->Contributionreport->get_total_amounts_donated_through_company_by_date($data['begin_date'], $data['end_date']);
        $data['results'] = $this->Contributionreport->get_matching_list($data['begin_date'], $data['end_date']);

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('contributionreport', $data);
    }
}