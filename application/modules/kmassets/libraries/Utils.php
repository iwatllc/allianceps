<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 
	* Author: DMcCleary
	* Name: Utils Class
	* Date: 09/14/2015
	* Version: 1.0
	* Notes: Application utility functions and methods.
*/

class Utils
{
	protected $CI;

    public function __construct()
    {

	}
	
	/**
	 * Reflection on an object to set a protected value of an object property to accessible
	 *
	 * @param	object  the object to apply reflection to 
	 * @param   string  name of property to set accessible
	 * @return	string	the value of the property of the object
	 */
	
	public function get_protected_value($obj, $property_name)
	{
		$ref_object   = new ReflectionObject($obj);
		$ref_property = $ref_object->getProperty($property_name);
		$ref_property->setAccessible(TRUE);
		
		return $ref_property->getValue($obj);
	}
}