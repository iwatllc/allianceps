<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
	* Author: DMcCleary
	* Name: KMAsset JS Library Class
	* Date: 09/14/2015
	* Version: 1.0
	* Notes: JS Asset Library Class for collecting custom and vendor js files.
*/

class Asset_js
{
	public $assets = array();
	public $defer_assets = array();
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
	
	public function add_defer_asset($file)
	{
		array_push($this->defer_assets, $file);
	}
	
	public function get_defer_assets()
	{
		return $this->defer_assets;
	}
}