<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Class
 *
 * @author ronnysugianto
 */
class MY_Class {
    var $customFunction;
    
    function __construct() {
        
        $this->customFunction = array('modify_row_data'=>null);
    }
    
    protected function run_custom_function($name,$args){
        $response = 'null';
        if(is_array($this->customFunction) && key_exists($name, $this->customFunction) && $this->customFunction[$name] != null)
            $response = call_user_func_array($this->customFunction[$name],$args);
        
        return $response;
    }
    
    /**
     * Validate values in setting array with requirement keys.. Default key values is '' (if not set)
     * @param $setting Setting array
     * @param $staticKeys Requirements setting keys
     * @return array
     */
    protected function validateSetting($setting,$staticKeys){
        $validSetting = array();

        foreach($staticKeys as $key){
            if(isset($setting[$key])) $validSetting[$key] = $setting[$key];
            else $validSetting[$key] = '';
        }

        return $validSetting;
    }
}

?>
