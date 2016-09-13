<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/17/15
 * Time: 6:50 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Prospect extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function get_matches(){

        $this->load->model('Prospect_model', 'Prospect');

        $data['results'] = $this->Prospect->get_matching_list();

        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;


        $this->load->view('prospect_list', $data);


    }




}