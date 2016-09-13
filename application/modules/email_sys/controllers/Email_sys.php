<?php

/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/9/15
 * Time: 3:59 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_sys extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

    }

    public function send_email($to, $subject, $message){

        $this->load->library('email');

        $email_from = $this->configsys->get_config_value('Client_Email_From');
        $email_copy = $this->configsys->get_config_value('Client_Email_Copy');
        $email_blind_copy = $this->configsys->get_config_value('Client_Email_Blind_Copy');
        $client_name = $this->configsys->get_config_value('Client_Name');

        $this->email->from($email_from, $client_name);
        $this->email->to($to);
        $this->email->cc($email_copy);
        $this->email->bcc($email_blind_copy);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();

        return 'Sent Email';
    }


}