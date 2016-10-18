<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MX_Controller 
{
    public function __construct()
    {
        if (!$this->dx_auth->is_logged_in())
        {
            // redirect to login page
            redirect('security/auth', 'refresh');
        }
        
        parent::__construct();
        $this -> load -> library('session');
    }
    
    public function index()
    {
        $this -> load -> model('search_model', '', TRUE);
		
		$search_array['PaymentTransactionId'] = '';
        $search_array['BegDate'] = '';
        $search_array['EndDate'] = '';
        $search_array['PaymentSource'] = '';
        $search_array['TransactionAmount'] = '';
        $search_array['AuthCode'] = '';
        $search_array['OrderNumber'] = '';
        $search_array['CVV2ResponseCode'] = '';
        $search_array['CVV2ResponseMessage'] = '';
        $search_array['SerialNumber'] = '';
		$search_array['TransactionStatusId'] = '';
		
		$data['search_array'] = $search_array;
		
		$data['transaction_statuses']   = $this -> search_model -> get_transaction_statuses();
        $data['results']                = $this -> search_model -> get_transactions();
        $data['num_results']            = $this -> search_model -> get_num_transactions($data['results']);
        $data['total_amount']           = $this -> search_model -> get_total_amount_transactions();

        $this -> blade
            -> set('data', $data)
            -> set('search_array', $search_array)
            -> render('search');
    }
    
    public function execute_search()
    {
        $search_array['PaymentTransactionId'] = $this->input->post('PaymentTransactionId');
        $search_array['BegDate'] = date( "Y-m-d", strtotime( $this->input->post('BegDate') ) );
        $search_array['EndDate'] = date( "Y-m-d", strtotime( $this->input->post('EndDate') ) );
        $search_array['PaymentSource'] = $this->input->post('PaymentSource');
        $search_array['TransactionAmount'] = $this->input->post('TransactionAmount');
        $search_array['AuthCode'] = $this->input->post('AuthCode');
        $search_array['OrderNumber'] = $this->input->post('OrderNumber');
        $search_array['CVV2ResponseCode'] = $this->input->post('CVV2ResponseCode');
        $search_array['SerialNumber'] = $this->input->post('SerialNumber');
		$search_array['TransactionStatusId'] = $this->input->post('TransactionStatusId');
        
        $this->load->model('Search_model', 'Search');

        $data['results'] = $this->Search->get_search_results($search_array);

        $data['num_results'] = $this->Search->get_num_results($data['results']);
        $total_amount = $this->Search->get_total_amount($data['results']);
        $data['total_amount'] = floor($total_amount * 100) / 100; // round down nearest 2 decimal places
        
        $data['search_array'] = $search_array;

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
		$data['transaction_statuses'] = $this->Search->get_transaction_statuses();
		$data['payment_sources'] = $this->Search->get_form_lists();
        $data['page_data'] = $view_vars;
        
        $this->load->view('search', $data);
    }
}