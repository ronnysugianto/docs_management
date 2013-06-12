<?php
/**
 * Importing custom function to views
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('display_confirmation')){
    /**
     * Display confirmation message (success/error)
     * @param string $type Type of confirmation ('success'/'error')
     * @param $message Confirmation Message
     * @return string
     */
    function display_confirmation($type='',$message){
        if($type === 'success'){
            return '<div class="row-fluid"><div class="span12 alert alert-success"><h5>'.$message.'</h5></div></div>';
        }else if($type === 'error'){
            return '<div class="row-fluid"><div class="span12 alert alert-error"><h5>'.$message.'</h5></div></div>';
        }
        return '';
    }
}

if ( ! function_exists('init_validation')){

    /**
     * Init form validation on spesific form
     * @param $idform Form id
     * @return string Generated javascript code
     */
    function init_validation($idform){
        return <<<EOT
            $(document).ready(function(){
                $("#$idform").validationEngine();
            });
EOT;
    }
}

if ( ! function_exists('show_validate_prompt')){
    /**
     * Generate javascript to display message with jquery form validation
     * @param string $id HTML tag ID for message will be displayed
     * @param string $message Text message
     * @param string $type Type for message (default = 'error')
     * @return string Generated javascript code
     */
    function show_validate_prompt($id='',$message='',$type='error'){
        return <<<EOT
            $('#$id').validationEngine('showPrompt','$message','$type',true);
EOT;
    }
}


if ( ! function_exists('script_tag')) {
    /**
     * Additional Function for javascript import
     * @param type $src
     * @param type $language
     * @param type $type
     * @param type $index_page
     * @return string
     */
    function script_tag($src = '', $language = 'javascript', $type = 'text/javascript', $index_page = FALSE)
    {
        $CI =& get_instance();
        $script = '<scr'.'ipt';
        if (is_array($src)) {
            foreach ($src as $k=>$v) {
                if ($k == 'src' AND strpos($v, '://') === FALSE) {
                    if ($index_page === TRUE) {
                        $script .= ' src="'.$CI->config->site_url($v).'"';
                    }
                    else {
                        $script .= ' src="'.$CI->config->slash_item('base_url').$v.'"';
                    }
                }
                else {
                    $script .= "$k=\"$v\"";
                }
            }

            $script .= "></scr"."ipt>\n";
        }
        else {
            if ( strpos($src, '://') !== FALSE) {
                $script .= ' src="'.$src.'" ';
            }
            elseif ($index_page === TRUE) {
                $script .= ' src="'.$CI->config->site_url($src).'" ';
            }
            else {
                $script .= ' src="'.$CI->config->slash_item('base_url').$src.'" ';
            }

            $script .= 'language="'.$language.'" type="'.$type.'"';
            $script .= ' /></scr'.'ipt>'."\n";
        }
        return $script;
    }
}
