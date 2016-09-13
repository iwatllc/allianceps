<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

/** 
	* Author: DMcCleary
	* Name: Robo methods
	* Date: 09/14/2015
	* Version: 1.0
	* Notes: Robo file that contains application task methods that are called using vendor Robo
*/

class Parse_task extends Robo\Tasks
{
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	private $temp_css_dir;
	private $temp_js_dir;
	private $public_css;
	private $public_js;

	public function _parse_scss($file)
	{
		try
		{
			$res = $this->taskScss($file)
				->run();
			
			if ($res->wasSuccessful() === TRUE)
			{
				return TRUE;
			}
			else
			{
				log_message('error', 'Parse scss error ' . print_r($res, TRUE));
				return FALSE;
			}
		}
		catch (Exception $e)
		{
			log_message('error', $e);
			return FALSE;
		}
	}
	
	public function _parse_less()
	{
		try
		{
			$res = $this->taskLess($file)
				->run();
			
			if ($res->wasSuccessful() === TRUE)
			{
				return TRUE;
			}
			else
			{
				log_message('error', 'Parse less error ' . print_r($res, TRUE));
				return FALSE;
			}
		}
		catch (Exception $e)
		{
			log_message('error', $e);
			return FALSE;
		}
	}
	
	public function _delete_dir($path)
	{
		$result = $this->taskDeleteDir($path)->run();
		
		if ($result->wasSuccessful() === FALSE)
		{
			log_message('error', 'Unable to delete directory ' . $path);
		}
	}

	public function _minify_file($file, $to)
	{
		try
		{
			$res = $this->taskMinify($file)
						->to($to)
						->keepImportantComments(FALSE)
						->run();
			
			if ($res->wasSuccessful() === TRUE)
			{
				return $this->CI->utils->get_protected_value($res->getTask(), 'dst');
			}
			else 
			{
				log_message('error', 'minify files error ' . print_r($res, TRUE));
				return FALSE;
			}
		}
		catch (Exception $e)
		{
			log_message('error', $e);
			return FALSE;
		}
	}
	
	public function _combine_files($files, $to)
	{
		try
		{
			$res = $this->taskConcat($files)
					->to($to)
					->run();
			
			if ($res->wasSuccessful())
			{
				return TRUE;
			}
			else
			{
				log_message('error', 'CSS was unable to be combined! ' . print_r($res, TRUE));
			}
		}
		catch (Exception $e)
		{
			log_message('error', $e);
			return FALSE;
		}
	}
}