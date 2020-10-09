<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Form Value
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea.  If Form Validation
 * is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @return	mixed
 */
if ( ! function_exists('set_value'))
{
	function set_value($field = '', $default = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			if ( ! isset($_POST[$field]))
			{
				return $default;
			}

			return form_prep($_POST[$field], $field);
		}
		return form_prep($OBJ->set_value($field, $default), $field);
	}
}

if ( ! function_exists('extract_data'))
{
	function extract_data($string) {
	 

	    

	    var_dump($matches);exit;
	   
	    return $current_data;
	} 
}
if ( ! function_exists('set_array'))
{
	function set_array($index,$field = '', $default = '')
	{
 
		$found_matches = preg_match_all('/\[([a-zA-Z0-9_-]+)\]/', $field, $matches);

	    if (!$found_matches) {
	            return null;
	    }
	    if(!isset($_POST[$index])){
	    	return $default;
	    }
		$current_data = $_POST[$index];
		
	    foreach ($matches[1] as $name) {

	            if (key_exists($name, $current_data)) {
	                    $current_data = $current_data[$name];
	            } else {
	                    return null;
	            }
	    }

	    return $current_data;

	}
}

if(!function_exists('array_combos')){
	function array_combos($arr,$id='id',$value='name',$firstValue=false,$todos=false,$selecciona=true){
	if($firstValue && $todos && $selecciona){
	     $res = array(''=>'-- Selecciona --',
	     			 '-1'=>'Todos');
    }else if($firstValue && !$todos && $selecciona){
   	 $res = array(''=>'-- Selecciona --');
   	}else{
       $res = array();
   	}
	if(is_array($arr)){
		foreach($arr as $row){
			$res[(trim($row->{$id}))] =($row->{$value});
		}
	}
	return $res;
	}
}
if(!function_exists('array_combos_fechas')){
	function array_combos_fechas($arr,$id='id',$value='name',$firstValue=false,$todos=false,$selecciona=true){
	if($firstValue && $todos && $selecciona){
	     $res = array(''=>'-- Selecciona --',
	     			 '-1'=>'Todos');
    }else if($firstValue && !$todos && $selecciona){
   	 $res = array(''=>'-- Selecciona --');
   	}else{
       $res = array();
   	}
	if(is_array($arr)){
		foreach($arr as $row){
			$res[(trim($row->{$id}))] =(date_eng2esp_1($row->{$value}));
		}
	}
	return $res;
	}
}

if (!function_exists('exist_obj')){	
	function exist_obj($obj,$val,$default=''){
		if(isset($obj->$val)){
			return $obj->$val;
		}
		return $default;
	}	
}
	
if (!function_exists('exist_arr')){	
	function exist_arr($obj,$val,$default=''){
		if(isset($obj[$val])){
			return $obj[$val];
		}
		return $default;
	}	
}



// ------------------------------------------------------------------------

/**
 * Text Hidden Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_hidden'))
{
	function form_hidden($data = '', $value = '', $extra = '')
	{
		
		if (is_array($data))
		{
		
			foreach ($data as $key => $val)
			{
				$form = form_hidden($key, $val, $extra);
			}
			return $form;
		}
	
		$defaults = array('type' => 'hidden', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		$form = "<input "._parse_form_attributes($data, $defaults).$extra." />";
		
		return $form;
	}
}
