<?php
/**
 * Created by PhpStorm.
 * User: aaronfrazer
 * Date: 10/10/16
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The purpose of this class is to decide whether the string typed in the URL is a slug or a controller.
 * Once it makes it's decision, it will redirect appropriately.
 */
class CatchAll extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $slug = $this -> uri -> uri_string();
//        echo $slug . '<br/>';

        $controllers_array = array();
        $modules_array = array();

        // Check if the slug is a controller
        foreach(glob(APPPATH . 'controllers/*' . EXT) as $controller)
        {
            $controller = strtolower(basename($controller, EXT));
            array_push($controllers_array, $controller);
        }

        // Check if the slug is a module
        foreach(glob(APPPATH . 'modules/*') as $module)
        {
            $module = basename($module, EXT);
            array_push($modules_array, $module);
        }

//        echo 'Controllers:';
//        echo '<pre>';
//        print_r($controllers_array);
//        echo '</pre>';
//
//        echo 'Modules:';
//        echo '<pre>';
//        print_r($modules_array);
//        echo '</pre>';

        if (in_array($slug, $controllers_array) || in_array($slug, $modules_array))
        {
            // Redirect to controller
//            echo 'This would redirect to the ' . $slug . ' controller: ' . '/' . $slug;
            redirect($slug . '/index');
        } else
        {
            // Redirect to paymentform controller
//            echo 'This would redirect to the paymentform controller: ' . '/paymentform/index/' . $slug;
            redirect('paymentform/index/' . $slug);
        }

    }

}