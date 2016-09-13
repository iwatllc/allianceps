<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 2/9/15
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Testpage extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        if (!$this->ion_auth->logged_in())
        {
            //redirect to the login page
            redirect('auth/login', 'refresh');
        }
        
        parent::__construct();
        // Your own constructor code
        //$this->dx_auth->check_uri_permissions();
    }




    public function index()
    {
        $data = array(
            'title' => 'EZ Online Pay | Guest Payment',
            'heading' => 'Guest Payment Page',
            'description' => 'EZ Online Pay Guest Payment Form',
            'author' => 'EZ Online Pay 2015'
        );
        $this->load->view('test_page', $data);
    }
}