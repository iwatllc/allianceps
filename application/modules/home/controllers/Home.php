<?php
/**
 * Created by PhpStorm.
 * User: aaronfrazer
 * Date: 10/10/16
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller
{
    public function __construct()
    {
        if ($this->dx_auth->is_logged_in())
        {
            // redirect to customer page
            redirect('customer', 'refresh');
        }

        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $this -> load -> model('home_model', '', TRUE);

        $page_data = array(
            'title'         => $this->config->item('Company_Title'),
            'description'   => $this->config->item('Company_Description'),
            'logo'          => $this->config->item('Company_Logo'),
            'author'        => $this->config->item('Company_Author')
        );
        
        $this -> blade
//            -> set('data', $data)
            -> set('page_data', $page_data)
            -> render('home');
    }
}