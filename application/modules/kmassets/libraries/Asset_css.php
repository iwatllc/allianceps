<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
	* Author: DMcCleary
	* Name: Asset Css Library Class
	* Date: 09/14/2015
	* Version: 1.0
	* Notes: Css Asset Library Class for collecting custom and vendor scss or css files.
*/

class Asset_css
{
	public $assets = array();
	public $file_name;
	
	public function __construct($file_name = 'default')	
	{
		$this->set_file_name($file_name);
	}
	
	public function set_file_name($file_name)
	{
		$this->file_name = strtolower(trim($file_name));
	}
	
	public function get_file_name()
	{
		return $this->file_name;
	}

	public function add_asset($file)
	{
		array_push($this->assets, $file);
	}
	
	public function get_assets()
	{
		return $this->assets;
	}
}