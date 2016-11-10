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

    /**
     * Saves the response from JetPay into the database.
     */
    public function trans_details()
    {
        $this -> load -> model('paymentresponse_model', '', TRUE);
        $this -> load -> library('user_agent');

        $data = array(
            'responseText'      => $_POST['responseText'],
            'cid'               => $_POST['cid'],
            'name'              => $_POST['name'],
            'card'              => $_POST['card'],
            'cardNum'           => $_POST['cardNum'],
//            'extendedCardNum'   => $_POST['extendedCardNum'],
            'expDate'           => $_POST['expDate'],
            'amount'            => $_POST['amount'],
            'transId'           => $_POST['transId'],
            'actCode'           => $_POST['actCode'],
            'apprCode'          => $_POST['apprCode'],
            'cvvMatch'          => $_POST['cvvMatch'],
            'addressMatch'      => $_POST['addressMatch'],
            'zipMatch'          => $_POST['zipMatch'],
            'avsMatch'          => $_POST['avsMatch'],
            'ccToken'           => $_POST['ccToken'],
            'customerEmail'     => $_POST['customerEmail'],
            'order_number'      => $_POST['order_number'],
            'jp_return_hash'    => $_POST['jp_return_hash'],
            'rrn'               => $_POST['rrn'],
            'uniqueid'          => $_POST['uniqueid'],
            'ud1'               => $_POST['ud1'],
            'ud2'               => $_POST['ud2'],
            'ud3'               => $_POST['ud3'],
            'merData1'          => $_POST['merData1'],
            'merData2'          => $_POST['merData2'],
            'merData3'          => $_POST['merData3'],
            'merData4'          => $_POST['merData4'],
            'merData5'          => $_POST['merData5'],
//            'merData6'          => $_POST['merData6'],
//            'merData7'          => $_POST['merData7'],
//            'merData8'          => $_POST['merData8'],
//            'merData9'          => $_POST['merData9'],
            'merData0'          => $_POST['merData0'],
            'referrer'          => $this -> agent -> referrer(),
            'respArray'         => print_r($_POST, TRUE),
            'insertDate'        => mdate("%Y-%m-%d %H:%i:%s", time())
        );

        $this -> paymentresponse_model -> insert_jp_response($data);
    }

    /**
     * Response that will be called to load the approve/decline screens
     */
    public function response()
    {
        $this -> load -> model('paymentresponse_model', '', TRUE);

        if (!strlen($_SERVER['QUERY_STRING']))
        {
            $this -> load_error_trans();
        } else
        {
            $string_out = base64_decode($_SERVER['QUERY_STRING']);
            parse_str($string_out, $data);
        }

        $data['slugname'] = $this -> paymentresponse_model -> get_customer_by_uuid($data['cid']) -> slugname;

        if (array_key_exists('card' , $data))
        {
            $data['paymentType'] = 'cc';
            $data['cardImage'] = $this -> getCardImage($data['card']);
        } else
        {
            $data['paymentType'] = 'ach';
        }

        if (strpos(strtolower($data['responseText']), 'approved') !== false)
        {
            $this -> load_approve_trans($data);
        } else
        {
            $this -> load_decline_trans($data);
        }
    }

    /**
     * Sends emails to customer/merchants and loads the payment approved screen.
     */
    public function load_approve_trans($data)
    {
        $data['emailSent'] = FALSE;

        $customer = $this -> paymentresponse_model -> get_customer_by_uuid($data['cid']);

        // Get form_submission record
        $order = $this -> paymentresponse_model -> get_form_submission_by_order_number($data['order_number']);

        $data['subtotal']       = $order -> amount;
        $data['cfPercentage']   = $order -> cfpercentage;
        $data['total']          = $order -> amount_cf;
        $data['customerEmail']  = $order -> email;
        $data['address']        = $order -> address;
        $data['address2']       = $order -> address2;
        $data['city']           = $order -> city;
        $data['state']          = $order -> state;
        $data['zip']            = $order -> zip;
        $data['paymenttype']    = $order -> paymenttype;

        $data['customerName']   = $customer -> customername;
        $data['slugname']       = $customer -> slugname;
        $data['showlogo']       = $customer -> showlogo;
        $data['logofile']       = $customer -> logofile;

        if ($data['paymenttype'] == 'cc')
        {
            $data['paymentMethod'] = 'Credit Card';
            if ($data['card'] == 'VS') $data['cardName'] = 'Visa';
            else if ($data['card'] == 'MC') $data['cardName'] = 'Mastercard';
            else if ($data['card'] == 'DS') $data['cardName'] = 'Discover';
            else if ($data['card'] == 'AX') $data['cardName'] = 'Amex';
            else if ($data['card'] == 'DC') $data['cardName'] = 'Diners Club';
            else $data['cardName'] = '';
        } else if ($data['paymenttype'] == 'ach')
        {
            $data['paymentMethod'] = 'Check';
        }

        $data['subtotal'] = '$' . number_format($data['subtotal'], 2, '.', '');
        $data['cfAmount'] = '$' . number_format((float)($data['total'] - $data['subtotal']), 2, '.', '');
        if ($data['cfPercentage'] != '')
            $data['cfPercentage'] = '('.$data['cfPercentage'].'%)';
        else
            $data['cfPercentage'] = '(0%)';

        // Set email preferences
        $from               = $this -> config -> item('smtp_user');
        $fromname           = $customer -> customername;
        $to                 = $data['customerEmail'];
        $subject            = 'Order Reciept (#'.$data['transId'].')';
        $customer_message   = $this -> load -> view('customerordersummary', $data, TRUE);
        $merchant_message   = 'Email message for merchants will go here.';

        // Send email out to customer
        if ($customer -> emailcustomer == '1')
        {
            if ($this -> send_email($from, $fromname, $to, $subject, $customer_message))
            {
                $data['emailSent'] = TRUE;
            }
        }

        // Send email out to merchants
        if ($customer -> emailmerchant == '1')
        {
            $addresses = array_filter(explode(",", $customer -> emailaddresses));

            if (!empty($addresses))
            {
                foreach ($addresses as $address)
                {
                    $this -> send_email($from, $fromname, $address, $subject, $merchant_message);
                }
            }
        }

        $page_data = array(
            'title'         => 'Payment Approved',
            'description'   => 'Payment Successful',
            'logo'          => $this -> config -> item('Company_Icon'),
            'author'        => $data['cid']
        );

        $this -> blade
            -> set('page_data', $page_data)
            -> set('data', $data)
            -> render('approve');
    }

    /**
     * Loads the payment declined screen.
     */
    public function load_decline_trans($data)
    {
            $page_data = array(
                'title'         => 'Payment Declined',
                'description'   => 'Payment was not successful',
                'logo'          => $this -> config -> item('Company_Icon'),
                'author'        => $data['cid']
            );

            $this -> blade
                -> set('page_data', $page_data)
                -> set('data', $data)
                -> render('decline');
    }
    
    /**
     * Loads the payment error screen.  This function is only called if the response cannot be retrieved.
     */
    public function load_error_trans()
    {
        $page_data = array(
            'title'         => 'Payment Error',
            'description'   => 'Payment was not successful',
            'logo'          => $this -> config -> item('Company_Icon'),
            'author'        => $this -> config -> item('Company_Name')
        );

        $this -> blade
            -> set('page_data', $page_data)
            -> render('paymenterror');
    }

    /**
     * Sends an email.
     */
    public function send_email($from, $from_name, $to, $subject, $message)
    {
        $this -> load -> library('email');

        $this -> email -> from($from, $from_name);
        $this -> email -> to($to);

        $this -> email -> subject($subject);
        $this -> email -> message($message);

        $this -> email -> send();
    }

    /**
     * Gets a credit card image.
     */
    public function getCardImage($cardName)
    {
        switch ($cardName) 
        {
            case "VS":
                $cardImage = base_url('assets/img/cards/visa.jpg');
                break;
            case "MC":
                $cardImage = base_url('assets/img/cards/mastercard.jpg');
                break;
            case "DS":
                $cardImage = base_url('assets/img/cards/discover.jpg');
                break;
            case "AX":
                $cardImage = base_url('assets/img/cards/amex.jpg');
                break;
            case "DC":
                $cardImage = base_url('assets/img/cards/dinersclub.jpg');
                break;
        }

        return $cardImage;
    }
}