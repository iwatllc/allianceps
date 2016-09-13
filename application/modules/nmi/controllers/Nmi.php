<?php
/**
 * Created by Aptana Studio.
 * User: gregarnold
 * Date: 8/27/15
 * Time: 7:34 AM
 * 
 * References
 * 		Response Variables -> https://securitycardservices.transactiongateway.com/merchants/resources/integration/integration_portal.php?tid=1338a5ff2a74723f641d4ba4fbf7f93b#transaction_response_variables
 *		Transaction Variable -> https://securitycardservices.transactiongateway.com/merchants/resources/integration/integration_portal.php?tid=1338a5ff2a74723f641d4ba4fbf7f93b#transaction_variables
 * 		Direct Post Example -> https://securitycardservices.transactiongateway.com/merchants/resources/integration/integration_portal.php?tid=1338a5ff2a74723f641d4ba4fbf7f93b#dp_php 
 * 
 * Response Mapping to PaymentResponse Table (Database Column -> Response Field)
 * 		AuthCode -> authcode
 * 		AVSResponseCode -> avsresponse
 * 		OrderNumber -> orderid
 * 		IsApproved -> response
 * 		CVV2ResponseCode -> cvvresponse
 * 		ReturnCode -> response_code
 * 		TransactionFileName -> transactionid
 * 		ResponseHTML -> responsetext
 */

defined('BASEPATH') OR exit('No direct script access allowed');
define("APPROVED", 1);
define("DECLINED", 2);
define("ERROR", 3);

class Nmi extends MX_Controller
{


/*$submitted_data = array(
                'name' => $this->input->post('fullname'),
                'streetaddress' => $this->input->post('streetaddress'),
                'streetaddress2' => $this->input->post('streetaddress2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip' => $this->input->post('zip'),
            );
*/
	function doSale($data) {

	    $query  = "";
		// $formatccexp = sprintf("%02d", $data['expirationmonth']) . 
	    // Login Information
	    $query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
	    $query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";
	    // Sales Information
	    $query .= "ccnumber=" . urlencode(str_replace( ' ', '', $data['creditcard'])) . "&";
	    $query .= "ccexp=" . urlencode($data['expirationmonth'].$data['expirationyear']) . "&";
	    $query .= "amount=" . urlencode(number_format($data['amount'],2,".","")) . "&";
	    $query .= "cvv=" . urlencode($data['cvv2']) . "&";
		$query .= "orderid=" . urlencode($data['transaction_id']) . "&";
	    
		//Optional - Guest Form Information
		$firstname = $data['firstname'];
		$lastname = $data['lastname'];

		$query .= "firstname=" . urlencode($firstname) . "&";
	    $query .= "lastname=" . urlencode($lastname) . "&";
	    if(array_key_exists('streetaddress', $data)) {
	    	$query .= "address1=" . urlencode($data['streetaddress']) . "&";
		}
		if(array_key_exists('streetaddress2', $data)) {
	    	$query .= "address2=" . urlencode($data['streetaddress2']) . "&";
	    }
		if(array_key_exists('city', $data)) {
	    	$query .= "city=" . urlencode($data['city']) . "&";
		}
		if(array_key_exists('state', $data)) {
	    	$query .= "state=" . urlencode($data['state']) . "&";
		}
		if(array_key_exists('zip', $data)) {
	    	$query .= "zip=" . urlencode($data['zip']) . "&";
	    }
		if(array_key_exists('email', $data)) {
	    	$query .= "email=" . urlencode($data['email']) . "&";
		}
		$query .= "type=sale";
		
		//log_message('debug', "NMI Query -> " . print_r($query,TRUE));
	    return $this->_doPost($query, $this->config->item('NMI_URL'));
  	}

	function doVoid($transactionid) {

	    $query  = "";
	    // Login Information
	    $query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
	    $query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";
	    // Transaction Information
	    $query .= "transactionid=" . urlencode($transactionid) . "&";
	    $query .= "type=void";
	    return $this->_doPost($query, $this->config->item('NMI_URL'));
    }

    function doRefund($transactionid, $amount = 0) {

	    $query  = "";
	    // Login Information
	    $query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
	    $query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";
	    // Transaction Information
	    $query .= "transactionid=" . urlencode($transactionid) . "&";
	    if ($amount>0) {
	        $query .= "amount=" . urlencode(number_format($amount,2,".","")) . "&";
	    }
	    $query .= "type=refund";
	    return $this->_doPost($query, $this->config->item('NMI_URL'));
    }

	function doRecurring($data) {

		$query  = "";
		// Login Information
		$query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
		$query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";
		// Transaction Information
		$query .= "recurring=" . $data['recurring'] . "&";
		$query .= "plan_payments=" . $data['plan_payments'] . "&";
		$query .= "plan_amount=" . urlencode(number_format($data['plan_amount'],2,".","")) . "&";
		$query .= "month_frequency=" . $data['month_frequency'] . "&";
		$query .= "day_of_month=" . $data['day_of_month'] . "&";
		$query .= "ccnumber=" . urlencode(str_replace( ' ', '', $data['creditcard'])) . "&";
		$query .= "ccexp=" . urlencode($data['expirationmonth'].$data['expirationyear']) . "&";
		$query .= "first_name=" . urlencode($data['first_name']) . "&";
		$query .= "last_name=" . urlencode($data['last_name']) . "&";
		$query .= "city=" . urlencode($data['city']) . "&";
		$query .= "state=" . urlencode($data['state']) . "&";
		$query .= "zip=" . urlencode($data['zip']) . "&";
        if(array_key_exists('email', $data)) {
            $query .= "email=" . urlencode($data['email']) . "&";
        }
        if(array_key_exists('streetaddress', $data)) {
         $query .= "address1=" . urlencode($data['streetaddress']) . "&";
        }
		if(array_key_exists('streetaddress2', $data)) {
            $query .= "address2=" . urlencode($data['streetaddress2']) . "&";
        }

        // log_message('debug', "NMI Query -> " . print_r($query,TRUE));

		return $this->_doPost($query, $this->config->item('NMI_URL'));
	}

	function doCancelRecurring($data){
		$query  = "";
		// Login Information
		$query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
		$query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";
		// Transaction Information
        $query .= "recurring=delete_subscription&";
        $query .= "subscription_id=" . $data;


        // log_message('debug', "NMI Query -> " . print_r($query,TRUE));

        return $this->_doPost($query, $this->config->item('NMI_URL'));

	}


	private function _doPost($query, $url) {

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
	    curl_setopt($ch, CURLOPT_POST, 1);
	
	    if (!($data = curl_exec($ch))) {
	        return ERROR;
	    }
	    curl_close($ch);
	    unset($ch);
	    
	    $data = explode("&",$data);

	    for($i=0;$i<count($data);$i++) {
	        $rdata = explode("=",$data[$i]);
	        $responses[$rdata[0]] = $rdata[1];
	    }
	    return $responses;
	}

	function doQuery($transactionid)
	{
		$query  = "";

		// Login Information
		$query .= "username=" . urlencode($this->config->item('NMI_Username')) . "&";
		$query .= "password=" . urlencode($this->config->item('NMI_Password')) . "&";

		// Transaction Information
        $query .= "transaction_id=$transactionid" ;

        // THIS METHOD WILL DO IT'S OWN CURL CALL SINCE THE RETURN OBJECT
        // IS DIFFERENT THAN THE ON FROM THE OTHER doPOST functions
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->item('NMI_URL_QUERY'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_POST, 1);

        if (!($data = curl_exec($ch))) {
            return ERROR;
        }
        curl_close($ch);
        unset($ch);

        $transactionXML = new SimpleXMLElement($data);

		return $transactionXML;
	}





}
