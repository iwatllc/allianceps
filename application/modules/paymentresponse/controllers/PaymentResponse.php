<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentresponse extends MX_Controller
{
    public function __construct()
    {
//        if (!$this->dx_auth->is_logged_in())
//        {
//            // redirect to login page
//            redirect('security/auth', 'refresh');
//        }
        
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
        
//        $data['test'] = 'This is where the information will be loaded to.';

        session_start();

        $file = fopen(FCPATH . 'client/logs/' . date("Y-d-m-His") . '.txt', "w") or die("can't open/create log file");

        fwrite($file, "--------TRANSACTION DETAILS-----------\n");
        fwrite($file, "TRANSACTION RESPONSE: " . $_REQUEST['responseText'] . "\n");
        fwrite($file, "CUSTOMER ID: " . $_REQUEST['cid'] . "\n");
        fwrite($file, "CARD HOLDER NAME: " . $_REQUEST['name'] . "\n");
        fwrite($file, "--------CREDIT CARD DETAILS-----------\n");
        fwrite($file, "CARD TYPE: " . $_REQUEST['card'] . "\n");
        fwrite($file, "LAST 4 OF CARD: " . $_REQUEST['cardNum'] . "\n");
        fwrite($file, "CARD DISPLAY NUMBER: " . $_REQUEST['expandedCardNum'] . "\n");
        fwrite($file, "EXPIRATION DATE: " . $_REQUEST['expDate'] . "\n");
        fwrite($file, "--------END CARD DETAILS-----------\n");
        fwrite($file, "--------ACH DETAILS-----------\n");
        fwrite($file, "CH TYPE: " . $_REQUEST['achType'] . "\n");
        fwrite($file, "LAST 4 DDA: " . $_REQUEST['ofcAchNum'] . "\n");
        fwrite($file, "ABA: " . $_REQUEST['aba'] . "\n");
        fwrite($file, "CHECK NUMBER: " . $_REQUEST['chkNumber'] . "\n");
        fwrite($file, "--------END ACH DETAILS-----------\n");
        fwrite($file, "TRANSACTION AMOUNT: " . $_REQUEST['amount'] . "\n");
        fwrite($file, "TRANSACTION ID: " . $_REQUEST['transId'] . "\n");
        fwrite($file, "ACTION CODE: " . $_REQUEST['actCode'] . "\n");
        fwrite($file, "APPROVAL CODE: " . $_REQUEST['apprCode'] . "\n");
        fwrite($file, "CVV MATCH: " . $_REQUEST['cvvMatch'] . "\n");
        fwrite($file, "ADDRESS MATCH: " . $_REQUEST['addressMatch'] . "\n");
        fwrite($file, "ZIP MATCH: " . $_REQUEST['zipMatch'] . "\n");
        fwrite($file, "AVS MATCH: " . $_REQUEST['avsMatch'] . "\n");
        fwrite($file, "JP SAFE TOKEN: " . $_REQUEST['ccToken'] . "\n");
        fwrite($file, "CUSTOMER EMAIL: " . $_REQUEST['customerEmail'] . "\n");
        fwrite($file, "ORDER NUMBER: " . $_REQUEST['order_number'] . "\n");
        fwrite($file, "RRN: " . $_REQUEST['rrn'] . "\n");
        fwrite($file, "UNIQUE ID: " . $_REQUEST['uniqueid'] . "\n");
        fwrite($file, "RAW REPONSE: " . $_REQUEST['rawResponse'] . "\n");
        fwrite($file, "ADDRESS 1: " . $_REQUEST['billingAddress1'] . "\n");
        fwrite($file, "ADDRESS 2: " . $_REQUEST['billingAddress2'] . "\n");
        fwrite($file, "CITY: " . $_REQUEST['billingCity'] . "\n");
        fwrite($file, "STATE: " . $_REQUEST['billingState'] . "\n");
        fwrite($file, "ZIP: " . $_REQUEST['billingZip'] . "\n");
        fwrite($file, "CNTRY: " . $_REQUEST['billingCountry'] . "\n");
        fwrite($file, "-------OPTIONAL DATA IF SUPPLIED--------\n");
        fwrite($file, "UD1: " . $_REQUEST['ud1'] . "\n");
        fwrite($file, "UD2: " . $_REQUEST['ud2'] . "\n");
        fwrite($file, "UD3: " . $_REQUEST['ud3'] . "\n");
        fwrite($file, "MERDATA 0: " . $_REQUEST['merData0'] . "\n");
        fwrite($file, "MERDATA 1: " . $_REQUEST['merData1'] . "\n");
        fwrite($file, "MERDATA 2: " . $_REQUEST['merData2'] . "\n");
        fwrite($file, "MERDATA 3: " . $_REQUEST['merData3'] . "\n");
        fwrite($file, "MERDATA 4: " . $_REQUEST['merData4'] . "\n");
        fwrite($file, "MERDATA 5: " . $_REQUEST['merData5'] . "\n");
        fwrite($file, "MERDATA 6: " . $_REQUEST['merData6'] . "\n");
        fwrite($file, "MERDATA 7: " . $_REQUEST['merData7'] . "\n");
        fwrite($file, "MERDATA 8: " . $_REQUEST['merData8'] . "\n");
        fwrite($file, "MERDATA 9: " . $_REQUEST['merData9'] . "\n");
        fwrite($file, "-------END TRANSACTION DEETAILS--------\n");

        fclose($file);


        $data['jp_return_hash'] = $this -> input -> post('jp_return_hash');
        $data['cid']            = $this -> input -> post('cid');
        $data['cardNum']        = $this -> input -> post('cardNum');
        $data['card']           = $this -> input -> post('card');
        $data['chargeTotal']    = $this -> input -> post('chargeTotal');
        $data['responseText']   = $this -> input -> post('responseText');
        $data['transId']        = $this -> input -> post('transId');
        $data['actCode']        = $this -> input -> post('actCode');
        $data['apprCode']       = $this -> input -> post('apprCode');
        $data['cvvMatch']       = $this -> input -> post('cvvMatch');
        $data['addressMatch']   = $this -> input -> post('addressMatch');
        $data['zipMatch']       = $this -> input -> post('zipMatch');
        $data['avsMatch']       = $this -> input -> post('avsMatch');
        $data['ccToken']        = $this -> input -> post('ccToken');
        $data['name']           = $this -> input -> post('name');
        $data['merOrderNumber'] = $this -> input -> post('merOrderNumber');
        $data['merUd1']         = $this -> input -> post('merUd1');
        $data['merUd2']         = $this -> input -> post('merUd2');
        $data['merUd3']         = $this -> input -> post('merUd3');

        return $data;

//        $this -> load -> view('transactions', $data);
    }

    public function approved()
    {
        $data['test'] = 'This is the approved transaction screen.';

        $data['jp_return_hash'] = $this -> input -> post('jp_return_hash');
        $data['cid']            = $this -> input -> post('cid');
        $data['cardNum']        = $this -> input -> post('cardNum');
        $data['card']           = $this -> input -> post('card');
        $data['chargeTotal']    = $this -> input -> post('chargeTotal');
        $data['responseText']   = $this -> input -> post('responseText');
        $data['transId']        = $this -> input -> post('transId');
        $data['actCode']        = $this -> input -> post('actCode');
        $data['apprCode']       = $this -> input -> post('apprCode');
        $data['cvvMatch']       = $this -> input -> post('cvvMatch');
        $data['addressMatch']   = $this -> input -> post('addressMatch');
        $data['zipMatch']       = $this -> input -> post('zipMatch');
        $data['avsMatch']       = $this -> input -> post('avsMatch');
        $data['ccToken']        = $this -> input -> post('ccToken');
        $data['name']           = $this -> input -> post('name');
        $data['merOrderNumber'] = $this -> input -> post('merOrderNumber');
        $data['merUd1']         = $this -> input -> post('merUd1');
        $data['merUd2']         = $this -> input -> post('merUd2');
        $data['merUd3']         = $this -> input -> post('merUd3');

        $this -> load -> view('approved', $data);
    }

    public function decline()
    {
        $data['test'] = 'This is the declined transaction screen.';

//        $data = $this -> index();

//        var_dump($_POST);
//        session_start();
//        if (!strlen($_SERVER['QUERY_STRING']))
//        {
//            exit ();
//        }
//        $string_out = base64_decode($_SERVER['QUERY_STRING']);
//        parse_str($string_out, $_SESSION);
//        print ($string_out);
//        $data['jp_return_hash'] = $_SESSION['jp_return_hash'];
//        $data['cid']            = $_SESSION['jp_return_hash'];
//        $data['transId']        = $_SESSION['jp_return_hash'];
//        $data['responseText']   = $_SESSION['jp_return_hash'];
//        $data['actCode']        = $_SESSION['jp_return_hash'];
//        $data['amount']         = $_SESSION['jp_return_hash'];
//        $data['name']           = $_SESSION['jp_return_hash'];
//        $data['merOrderNumber'] = $_SESSION['jp_return_hash'];

//        $data['jp_return_hash'] = $this -> input -> post('jp_return_hash');
//        $data['cid']            = $this -> input -> post('cid');
//        $data['transId']        = $this -> input -> post('transId');
//        $data['responseText']   = $this -> input -> post('responseText');
//        $data['actCode']        = $this -> input -> post('actCode');
//        $data['amount']         = $this -> input -> post('amount');
//        $data['name']           = $this -> input -> post('name');
//        $data['merOrderNumber'] = $this -> input -> post('merOrderNumber');
        
        $this -> load -> view('decline', $data);
    }
    
}