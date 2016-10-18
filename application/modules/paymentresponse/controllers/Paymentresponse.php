<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentresponse extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );
        $data['page_data'] = $view_vars;
        
        $this -> load -> view('transactions', $data);
    }

    public function trans_details()
    {
        $this -> load -> model('paymentresponse_model', '', TRUE);
        $this->load->library('user_agent');

        //session_start();

//        if ( !isset( $_SESSION["origURL"] ) )
//        {
//            $_SESSION["origURL"] = $_SERVER["HTTP_REFERER"];
//        }

        $data = array(
            'responseText'      => $_REQUEST['responseText'],
            'cid'               => $_REQUEST['cid'],
            'name'              => $_REQUEST['name'],
            'card'              => $_REQUEST['card'],
            'cardNum'           => $_REQUEST['cardNum'],
            'extendedCardNum'   => $_REQUEST['extendedCardNum'],
            'expDate'           => $_REQUEST['expDate'],
            'amount'            => $_REQUEST['amount'],
            'transId'           => $_REQUEST['transId'],
            'actCode'           => $_REQUEST['actCode'],
            'apprCode'          => $_REQUEST['apprCode'],
            'cvvMatch'          => $_REQUEST['cvvMatch'],
            'addressMatch'      => $_REQUEST['addressMatch'],
            'zipMatch'          => $_REQUEST['zipMatch'],
            'avsMatch'          => $_REQUEST['avsMatch'],
            'ccToken'           => $_REQUEST['ccToken'],
            'customerEmail'     => $_REQUEST['customerEmail'],
            'order_number'      => $_REQUEST['order_number'],
            'jp_return_hash'    => $_REQUEST['jp_return_hash'],
            'rrn'               => $_REQUEST['rrn'],
            'uniqueid'          => $_REQUEST['uniqueid'],
            'ud1'               => $_REQUEST['ud1'],
            'ud2'               => $_REQUEST['ud2'],
            'ud3'               => $_REQUEST['ud3'],
            'merData1'          => $_REQUEST['merData1'],
            'merData2'          => $_REQUEST['merData2'],
            'merData3'          => $_REQUEST['merData3'],
            'merData4'          => $_REQUEST['merData4'],
            'merData5'          => $_REQUEST['merData5'],
            'merData6'          => $_REQUEST['merData6'],
            'merData7'          => $_REQUEST['merData7'],
            'merData8'          => $_REQUEST['merData8'],
            'merData9'          => $_REQUEST['merData9'],
            'merData0'          => $_REQUEST['merData0'],
            'referrer'          => $this -> agent -> referrer(),
//            'referrer'          => $_SESSION["origURL"],
            'respArray'         => print_r($_REQUEST, TRUE),
            'insertDate'        => mdate("%Y-%m-%d %H:%i:%s", time())
        );

//        $file = fopen(FCPATH . 'client/logs/' . date("Y-d-m-His") . '.txt', "w") or die("can't open/create log file");
//        fwrite($file, "Request Array: \n" . print_r($_REQUEST, TRUE) . "\n\n");
//        fwrite($file, "Data Array: \n" . print_r($data, TRUE) . "\n");
//        fclose($file);

        $this -> paymentresponse_model -> insert_jp_response($data);
    }
    
    public function response()
    {
        $this -> load -> model('paymentresponse_model', '', TRUE);

        if (!strlen($_SERVER['QUERY_STRING']))
        {
            exit(); // TODO: Display an error page here if no response comes back
        } else
        {
            $string_out = base64_decode($_SERVER['QUERY_STRING']);
            parse_str($string_out, $data);
        }

        $data['slugname'] = $this -> paymentresponse_model -> get_customer_by_uuid($data['cid']) -> slugname;

        if (strpos(strtolower($data['responseText']), 'approved') !== false)
        {
            $page_data = array(
                'title'         => 'Payment Approved',
                'description'   => 'Payment Successful',
//            'logo'          => $data['customer'] -> logofile,
                'author'        => $data['cid'],
            );

            $this -> blade
                -> set('page_data', $page_data)
                -> set('data', $data)
                -> render('approve');
        } else
        {
            $page_data = array(
                'title'         => 'Payment Declined',
                'description'   => 'Payment was not successful',
//            'logo'          => $data['customer'] -> logofile,
                'author'        => $data['cid'],
            );

            $this -> blade
                -> set('page_data', $page_data)
                -> set('data', $data)
                -> render('decline');
        }
    }
}