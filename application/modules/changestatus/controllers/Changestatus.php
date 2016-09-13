<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Changestatus extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Loaded in here to make the validation work correctly.
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;

        $this->load->module('configsys');

        // Your own constructor code
        //$this->dx_auth->check_uri_permissions();

    }

    public function index()
    {

        $transactionfileid = $this->uri->segment(4);

        // Check Status of Payment for Settlement
        $this->load->module('payment');
        $status = $this->payment->checkstatus($transactionfileid);
        $details = $this->payment->getstatusdetails($transactionfileid);
        $paymentdetails = $this->payment->getpaymentdetails($transactionfileid);

        $data['transactionfileid'] = $transactionfileid;
        $data['status'] = $status;
        $data['details'] = $details;
        $data['paymentdetails'] = $paymentdetails;

        $view_vars = array(
            'title' => $this->config->item('Company_Title') . ' | Change Status ',
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Title'). ' Change Status ',
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;

        $this->load->view('changestatus', $data);
    }





}
