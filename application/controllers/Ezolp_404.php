<?php
/**
 * Created by PhpStorm.
 * User: aaronfrazer
 * Date: 10/19/2016
 * Time: 11:43 AM
 */
class Ezolp_404 extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this -> output -> set_status_header('404');

        $page_data = array(
            'title'         => $this -> config -> item('Company_Title') . " | 404 Page Not Found",
            'description'   => $this->config->item('Company_Description'),
            'logo'          => $this->config->item('Company_Icon'),
            'author'        => $this->config->item('Company_Author')
        );

        $data = '';

        $this->blade
            ->set('data', $data)
            ->set('page_data', $page_data)
            ->render('ezolp_404');
    }
}
?>