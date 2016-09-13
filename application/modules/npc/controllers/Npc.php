<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 4/15/15
 * Time: 9:34 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Npc extends MX_Controller
{

    public function post_payment($data)
    {
        $merchantserialnumber = $this->config->item('NPC_SerialNumber');
        $developerserialnumber = $this->config->item('NPC_Devloper_SerialNumber');
        $developerurl = $this->config->item('NPC_DevRequestUrl');
        $productionurl = $this->config->item('NPC_ProdRequestUrl');

        //  The below values can be passed in the fields that are marked required so that we
        //  Do not need to capture this informaiton form the end user.
        if (empty($data['streetaddress']))
        {
            $streetaddress = 'None';
        } else {
            $streetaddress = $data['streetaddress'];
        }

        if (empty($data['streetaddress2']))
        {
            $streetaddress2 = '';
        } else {
            $streetaddress2 = $data['streetaddress'];
        }

        if (empty($data['city']))
        {
            $city = 'None';
        } else {
            $city = $data['city'];
        }

        if (empty($data['state']))
        {
            $state = 'NA';
        } else {
            $state = $data['state'];
        }

        if (empty($data['zip']))
        {
            $zip = '55555';
        } else {
            $zip = $data['zip'];
        }




        $npc_data = array
        (
            'serialnumber' => $merchantserialnumber,
            'developerserialnumber' => $developerserialnumber,
            'SJName' => $data['name'],
            'StreetAddress' => $streetaddress,
            'StreetAddress2' => $streetaddress2,
            'City' => $city,
            'State' => $state,
            'ZipCode' => $zip,
            'AccountNumber' => str_replace( '-', '', $data['creditcard']),
            'Month' => $data['expirationmonth'],
            'Year' => $data['expirationyear'],
            'CVV2' => $data['cvv2'],
            'TransactionAmount' => $data['amount'],
            'ordernumber' => $data['transaction_id'],
            'shiptophone' => '0000000000',
            'Email' => 'None',
            'orderstring' => '1~Payment~'.$data['amount'].'~1~N~||'
        );


        //url-ify the data for the POST
        $postFieldsString = '';
        foreach ($npc_data as $fkey => $fvalue)
            $postFieldsString .= $fkey. '='. $fvalue. '&';

        $postFieldsString = rtrim($postFieldsString, '&');

        //open connection
        $requestConn = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($requestConn, CURLOPT_URL, $productionurl);

        // TODO: Remove Following Line in Live
        curl_setopt($requestConn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($requestConn, CURLOPT_POST, 1);
        curl_setopt($requestConn, CURLOPT_POSTFIELDS, $postFieldsString);
        curl_setopt($requestConn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($requestConn, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($requestConn, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");

        //execute post
        $postNPCResult = curl_exec($requestConn);
        $info = curl_getinfo($requestConn);


        //close connection
        curl_close($requestConn);

        $paymentResponse = $this->processPaymentResponse($postNPCResult, $data['transaction_id']);
        $paymentResponse['html'] = $postNPCResult;
        $paymentResponse['success'] = TRUE;

        return $paymentResponse;

    }



    private function processPaymentResponse($result, $trxnId)
    {
        $authCode = $this->findInString("AUTHCODE", $result, "-->", "=");
        $szSerialNumber = $this->findInString("szSerialNumber", $result, "-->", "=");
        $szTransactionAmount = $this->findInString("szTransactionAmount", $result, "-->", "=");
        $szAuthorizationDeclinedMessage = $this->findInString("szAuthorizationDeclinedMessage", $result, "-->", "=");
        $szAVSResponseCode = $this->findInString("szAVSResponseCode", $result, "-->", "=");
        $szAVSResponseMessage = $this->findInString("szAVSResponseMessage", $result, "-->", "=");
        $szOrderNumber = $this->findInString("szOrderNumber", $result, "-->", "=");
        $szAuthorizationResponseCode = $this->findInString("szAuthorizationResponseCode", $result, "-->", "=");
        $szIsApproved = $this->findInString("szIsApproved", $result, "-->", "=");
        $szCVV2ResponseCode = $this->findInString("szCVV2ResponseCode", $result, "-->", "=");
        $szCVV2ResponseMessage = $this->findInString("szCVV2ResponseMessage", $result, "-->", "=");
        $szReturnCode = $this->findInString("szReturnCode", $result, "-->", "=");
        $szTransactionFileName = $this->findInString("szTransactionFileName", $result, "-->", "=");
        $szCAVVResponseCode = $this->findInString("szCAVVResponseCode", $result, "-->", "=");

        $returnVars = array
        (
            'AUTHCODE' => $authCode,
            'szSerialNumber' => $szSerialNumber,
            'szTransactionAmount' => $szTransactionAmount,
            'szAuthorizationDeclinedMessage' => $szAuthorizationDeclinedMessage,
            'szAVSResponseCode' => $szAVSResponseCode,
            'szAVSResponseMessage' => $szAVSResponseMessage,
            'szOrderNumber' => empty($szOrderNumber) ? $trxnId : $szOrderNumber,
            'szAuthorizationResponseCode' => $szAuthorizationResponseCode,
            'szIsApproved' => empty($szIsApproved) ? "0" : $szIsApproved,
            'szCVV2ResponseCode' => $szCVV2ResponseCode,
            'szCVV2ResponseMessage' => $szCVV2ResponseMessage,
            'szReturnCode' => $szReturnCode,
            'szTransactionFileName' => $szTransactionFileName,
            'szCAVVResponseCode' => $szCAVVResponseCode
        );

        return $returnVars;
    }

    private function findInString($searchKey, $stringToSearch, $stringMatchEnd, $splitter)
    {
        $returnVal = "";
        $indexOfSearchKey = stripos($stringToSearch, $searchKey);

        if ($indexOfSearchKey !== FALSE)
        {
            $indexOfStringEnd = stripos($stringToSearch, $stringMatchEnd, $indexOfSearchKey);

            if ($indexOfStringEnd !== FALSE)
            {
                $valueWithSplitter = substr($stringToSearch, $indexOfSearchKey + strlen($searchKey), $indexOfStringEnd - $indexOfSearchKey - strlen($searchKey));
                $indexOfSplitter = stripos($valueWithSplitter, $splitter);

                $returnVal = $valueWithSplitter;

                if ($indexOfSplitter !== FALSE && $indexOfSplitter == 0)
                {
                    $returnVal = substr($valueWithSplitter, $indexOfSplitter + 1, strlen($valueWithSplitter) - 1);
                }
            }
        }

        return $returnVal;
    }

}
