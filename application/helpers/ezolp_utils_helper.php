<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EZOLP
 *
 * @author		Robert Fulcher
 * @date		6-17-2009
 */

// ------------------------------------------------------------------------

/*
Instructions:

Load the plugin using:

 	$this->load->helper('bb_utils');

Once loaded you can generate a captcha like this:

NOTES:

RETURNED DATA


/**
|==========================================================
| Convert date to command language date like today
|==========================================================
|
*/

function getClientLogo() {
  $logo_url = base_url() . 'client/client-logo.png';
  return $logo_url;
}

function issetor(&$var, $default = false) {
    return isset($var) ? $var : $default;
}

function date_conversion_nowording($date)
{
  // first check the date and make sure it is a date.
  if ($date == NULL or strlen($date) == 0 or $date == '0000-00-00 00:00:00' or $date == '0000-00-00'){
    return "";
  } else {
    $adate = date_create($date);
    $date_as_string = date_format($adate,'m/d/Y');
    //$date->format('m/d/Y');
    $today = date('m/d/Y');
    $yesterday = date('m/d/Y',time()-86400);
    $tomorrow = date('m/d/Y',time()+86400);
    return $adate->format('m/d/Y h:i a');
  }

}

function date_conversion($date)
{
	// first check the date and make sure it is a date.
	if ($date == NULL or strlen($date) == 0 or $date == '0000-00-00 00:00:00' or $date == '0000-00-00'){
		return "";
	} else {
		$adate = date_create($date);
		$date_as_string = date_format($adate,'m/d/Y');
		//$date->format('m/d/Y');
		$today = date('m/d/Y');
		$yesterday = date('m/d/Y',time()-86400);
		$tomorrow = date('m/d/Y',time()+86400);
		if ($date_as_string == $today){
			return "Today ".$adate->format('h:i a');
		} elseif ($date_as_string == $yesterday) {
			return "Yesterday ".$adate->format('h:i a');
		} elseif ($date_as_string == $tomorrow) {
			return "Tomorrow ".$adate->format('h:i a');
		} else {
			return $adate->format('m/d/Y h:i a');
		}
	}

}

function date_conversion_notime($date)
{
	// first check the date and make sure it is a date.
	if ($date == NULL or strlen($date) == 0 or $date == '0000-00-00 00:00:00' or $date == '0000-00-00'){
		return "";
	} else {
		$adate = date_create($date);
		$date_as_string = date_format($adate,'m/d/Y');
		return $adate->format('m/d/Y');
	}

}

function time_conversion($time)
{
	return $time->format('h:i a');
}

function currency_clean($data)
{
  $data = str_replace(",", "", $data);
  return $data;
}