<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkdonationamount extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->module('configsys');
    }

    public function index()
    {
        $donationid = $this->uri->segment(3);

        $this->load->model('Checkdonationamount_model', 'Checkdonationamount');

        $data['donations'] = $this->Checkdonationamount->get_donations($donationid);

        $result = $data['donations']->result();

//        if(isset($result))
//        {
//            $data['num_company_donations'] = 0;
//            $data['amount_company_donations'] = 0;
//            $data['company_donations'] = 0;
//            $data['num_all_donations'] = 0;
//            $data['amount_all_donations'] = 0;
//            $data['all_donations'] = 0;
//            $data['num_total_donations'] = 0;
//        } else {
            $data['num_company_donations'] = $this->Checkdonationamount->get_num_company_donations($data['donations']);
            $data['amount_company_donations'] = $this->Checkdonationamount->get_amount_company_donations($data['donations']);
            $data['company_donations'] = $this->Checkdonationamount->get_company_donations($data['donations']);
            $data['num_all_donations'] = $this->Checkdonationamount->get_num_all_donations($data['donations']);
            $data['amount_all_donations'] = $this->Checkdonationamount->get_amount_all_donations($data['donations']);
            $data['all_donations'] = $this->Checkdonationamount->get_all_donations($data['donations']);
            $data['num_total_donations'] = $this->Checkdonationamount->get_num_total_donations($data['donations']);
//        }



        $view_vars = array(
            'title' => $this->config->item('Company_Title') . ' | Check Donation Amount ',
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Title'). ' Check Donation Amount ',
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        ini_set('display_errors', 'On');
        ini_set('html_errors', 0);

        $this->load->view('checkdonationamount', $data);
    }



}