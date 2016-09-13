<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

/** 
	* Author: DMcCleary
	* Name: KMAssets Asset Create Controller
	* Date: 09/14/2015
	* Version: 1.0
	* Notes: Allows to combine and minify per page and cache files.
*/

class Asset_create extends MX_Controller
{
	const ASSET_CSS = 'Asset_css';
	const ASSET_JS = 'Asset_js';
	const EXT_LESS = 'less';
	const EXT_SCSS = 'scss';
	
	function __construct()
    {
        parent::__construct();
		
		$this->load->helper('file');
		$this->load->library('Parse_task');
    }

	public function index($asset = NULL) 
	{ 
		$name = get_class($asset);
		$asset_href = '';
		
		if (trim($name) == constant('self::ASSET_CSS'))
		{
			// Generate CSS href
			$asset_href = $this->generate_css($asset);
		}
		else if (trim($name) == constant('self::ASSET_JS'))
		{
			// Generate JS href
			$asset_href = $this->generate_js($asset);
		}

		return $asset_href;
	}
	
	private function _generate_checksum($files)
	{
		$checksum = '';
		foreach ($files as $file) 
		{
			$file_ext = pathinfo($file, PATHINFO_EXTENSION);
			$file_dir = pathinfo($file, PATHINFO_DIRNAME) . '/';
			$file_name = pathinfo($file, PATHINFO_BASENAME);
			
			if (trim(strtolower($file_ext)) == constant('self::EXT_LESS') || trim(strtolower($file_ext)) == constant('self::EXT_SCSS'))
			{
				$folder = scandir($file_dir);
				
				foreach ($folder as $f) 
				{
					if (pathinfo($f, PATHINFO_BASENAME) != '.' && pathinfo($f, PATHINFO_BASENAME) != '..')
					{
						if (filemtime($file_dir . pathinfo($f, PATHINFO_BASENAME)) != FALSE)
						{
							$checksum .= date('YmdHis', filemtime($file_dir . pathinfo($f, PATHINFO_BASENAME))) . pathinfo($f, PATHINFO_BASENAME);
						}
					}
				}
			}
			else 
			{
				if (filemtime($file_dir . $file_name) != FALSE)
				{
					$checksum .= date('YmdHis', filemtime($file_dir . $file_name)) . $file_name;
				}
			}
		}
		
		return md5($checksum);
	}
	
	public function generate_css($asset)
	{
		$files = array();
		$files = array_merge($files, $asset->get_assets());
		$checksum = $this->_generate_checksum($files);
		
		$css_file = $this->config->item('dir_public_css') . $asset->get_file_name() . '_' . $checksum . '.css';
		
		if ( ! read_file($css_file))
		{
			$tmp_dir = $this->config->item('dir_tmp_assets') . $checksum;
			mkdir($tmp_dir);
			
			$combine_array = array();
			
			foreach ($files as $file) 
			{
				$file_ext = pathinfo($file, PATHINFO_EXTENSION);
			    $file_dir = pathinfo($file, PATHINFO_DIRNAME) . '/';
				$file_name = pathinfo($file, PATHINFO_BASENAME);
				
				if (trim(strtolower($file_ext)) == constant('self::EXT_LESS') || trim(strtolower($file_ext)) == constant('self::EXT_SCSS'))
				{
					$scss_parse = $this->parse_task->_parse_scss([$file_dir . $file_name => $tmp_dir . '/' . $file_name . '.css']);
					
					if ($scss_parse === TRUE) 
					{
						array_push($combine_array, $tmp_dir . '/' . $file_name . '.css');
					}
				}
				else
				{
					array_push($combine_array, $file);
				}
			}
			
			if (sizeof($combine_array) > 0)
			{
				$final_array = array();
				
				foreach ($combine_array as $combine_file) 
				{
					$minify_res = $this->parse_task->_minify_file($combine_file, $tmp_dir . '/' . pathinfo($combine_file, PATHINFO_BASENAME));
					if ($minify_res != FALSE)
					{
						array_push($final_array, $tmp_dir . '/' . pathinfo($combine_file, PATHINFO_BASENAME));
					}
				}
				
				if (sizeof($final_array > 0))
				{
					$concat_res = $this->parse_task->_combine_files($final_array, $this->config->item('dir_public_css') . $asset->get_file_name(). '_' . $checksum . '.css');
					
					if ($concat_res === TRUE)
					{
						$this->parse_task->_delete_dir($tmp_dir . '/');
						
						$delete_status = $this->_delete_old_files($this->config->item('dir_public_css'), $asset->get_file_name(), $asset->get_file_name(). '_' . $checksum . '.css');
						
						return base_url() . $this->config->item('url_dir_public_css') . $asset->get_file_name(). '_' . $checksum . '.css'; 
					}
				}
			}
			
			return '';
		}
		else
		{
			return base_url() . $this->config->item('url_dir_public_css') . $asset->get_file_name(). '_' . $checksum . '.css';
		}
	}
	
	private function _delete_old_files($directory, $file_name_prefix, $current_file_name)
	{
		try
		{
			$names = get_filenames($directory);
			$old_files = array();
			
			foreach ($names as $value) 
			{
				if (strpos($value, $file_name_prefix . '_') !== FALSE && $value !== $current_file_name)
				{
					array_push($old_files, $value);
				}
			}
			
			foreach ($old_files as $file_name) {
				unlink($directory . $file_name);
			}
			
			return TRUE;
		}
		catch (Exception $ex)
		{
			log_message('error', $ex);

			return FALSE;
		}
	}
	
	
	
	public function generate_js($asset)
	{
		$files = array();
		$defer_files = array();
		
		$files = array_merge($files, $asset->get_assets());
		$defer_files = array_merge($defer_files, $asset->get_defer_assets());
		
		$js_hrefs = array();
		
		// Regular JS
		if (isset($files) && ! empty($files))
		{
			$checksum = $this->_generate_checksum($files);
			$js_file = $this->config->item('dir_public_js') . $asset->get_file_name() . '_' . $checksum . '.js';
			
			if ( ! read_file($js_file))
			{
				$tmp_dir = $this->config->item('dir_tmp_assets') . $checksum;
				mkdir($tmp_dir);
				
				$final_array = array();
				
				foreach ($files as $f) 
				{
					$minify_res = $this->parse_task->_minify_file($f, $tmp_dir . '/' . pathinfo($f, PATHINFO_BASENAME));
					if ($minify_res != FALSE)
					{
						array_push($final_array, $tmp_dir . '/' . pathinfo($f, PATHINFO_BASENAME));
					}
				}
				
				if (sizeof($final_array > 0))
				{
					$concat_res = $this->parse_task->_combine_files($final_array, $this->config->item('dir_public_js') . $asset->get_file_name(). '_' . $checksum . '.js');
					
					if ($concat_res === TRUE)
					{
						$this->parse_task->_delete_dir($tmp_dir . '/');
						
						$delete_status = $this->_delete_old_files($this->config->item('dir_public_js'), $asset->get_file_name(), $asset->get_file_name(). '_' . $checksum . '.js');
						
						$js_hrefs['js'] = base_url() . $this->config->item('url_dir_public_js') . $asset->get_file_name(). '_' . $checksum . '.js'; 
					}
				}
				
			}
			else 
			{
				$js_hrefs['js'] = base_url() . $this->config->item('url_dir_public_js') . $asset->get_file_name(). '_' . $checksum . '.js';
			}
		}
		else 
		{
			log_message('info', 'No JS files loaded in view.');
		}
		
		// Defer JS
		
		if (isset($defer_files) && ! empty($defer_files))
		{
			$file_name = $asset->get_file_name() . 'DEFER';
			$defer_checksum = $this->_generate_checksum($defer_files);
			$js_file_defer = $this->config->item('dir_public_js') . $file_name . '_' . $defer_checksum . '.js';
			
			if ( ! read_file($js_file_defer))
			{
				$tmp_dir_defer = $this->config->item('dir_tmp_assets') . $defer_checksum . '_defer';
				mkdir($tmp_dir_defer);
				
				$final_array_defer = array();
				
				foreach ($defer_files as $df) 
				{
					$minify_res_defer = $this->parse_task->_minify_file($df, $tmp_dir_defer . '/' . pathinfo($df, PATHINFO_BASENAME));
					if ($minify_res_defer != FALSE)
					{
						array_push($final_array_defer, $tmp_dir_defer . '/' . pathinfo($df, PATHINFO_BASENAME));
					}
				}
				
				if (sizeof($final_array_defer > 0))
				{
					$concat_res_defer = $this->parse_task->_combine_files($final_array_defer, $this->config->item('dir_public_js') . $file_name . '_' . $defer_checksum . '.js');
					
					if ($concat_res_defer === TRUE)
					{
						$this->parse_task->_delete_dir($tmp_dir_defer . '/');
						
						$delete_status_defer = $this->_delete_old_files($this->config->item('dir_public_js'), $file_name, $file_name . '_' . $defer_checksum . '.js');
						
						$js_hrefs['js_defer'] = $this->_create_defer_html(base_url() . $this->config->item('url_dir_public_js') . $file_name . '_' . $defer_checksum . '.js'); 
					}
				}
			}
			else 
			{
				$js_hrefs['js_defer'] = $this->_create_defer_html(base_url() . $this->config->item('url_dir_public_js') . $file_name . '_' . $defer_checksum . '.js');
			}
		}
		else 
		{
			log_message('info', 'No Defer JS files loaded in view.');
		}
		
		return $js_hrefs;
	}
	
	private function _create_defer_html($url)
	{
		$html = '';
		$html .= 'function downloadJSAtOnload() {';
		$html .= 'var element = document.createElement("script");';
		$html .= 'element.src = "' . $url . '";';
		$html .= 'document.body.appendChild(element);';
		$html .= '}';
		$html .= 'if (window.addEventListener) {';
		$html .= 'window.addEventListener("load", downloadJSAtOnload, false);';
		$html .= '} else if (window.attachEvent) {';
		$html .= 'window.attachEvent("onload", downloadJSAtOnload);';
		$html .= '} else {'; 
		$html .= 'window.onload = downloadJSAtOnload;';
		$html .= '}';
		
		return $html;
	}

}