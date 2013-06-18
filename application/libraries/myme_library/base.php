<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base Class with integrated custom PHP helper functions like import script, manipulate image, upload file, check existed value in array, etc..
 */
class base{
    function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->helper('html');
        $this->ci->load->helper('url');
    }

    /**
     * Generate import script for external javascript or css file
     * @param array $addition Type of import that wanted to include (tinymce, datepicker, colorpicker, etc..)
     * @return array|string
     */
    public function baseImport($addition=array()){
        $data['base'] = base_url();
        $data['logourl'] = base_url($this->ci->config->item('logourl'));
        $data['baseimport'] = '';

        //add tinymce imports file
        if(key_exists('tinymce',$addition) || $this->is_array_has_value('tinymce', $addition)){
            $tinymcebuttons = array();

            if(key_exists('tinymce',$addition) && $addition['tinymce'] != null && $addition['tinymce'] != '') $tinymcebuttons = $addition['tinymce'];

            $data['baseimport'] .= script_tag($this->ci->config->item('script_tinymce'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_basic_tinymce'));
            $data['baseimport'] .= $this->generateTinyMceImport($tinymcebuttons);
        }

        if(key_exists('datepicker',$addition) || $this->is_array_has_value('datepicker', $addition)){
            $datepicker = array();

            if(key_exists('datepicker',$addition) && $addition['datepicker'] != null && $addition['datepicker'] != '')
                $datepicker = $addition['datepicker'];

            $data['baseimport'] .= link_tag($this->ci->config->item('css_datepicker'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_datepicker'));
        }
        if(key_exists('colorpicker',$addition) || $this->is_array_has_value('colorpicker', $addition)){
            $colorpicker = array();

            if(key_exists('colorpicker',$addition) && $addition['colorpicker'] != null && $addition['colorpicker'] != '')
                $colorpicker = $addition['colorpicker'];

            $data['baseimport'] .= link_tag($this->ci->config->item('css_colorpicker'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_colorpicker'));
        }
        // belum ditesting - belum bootstrap
        if(key_exists('autocomplete',$addition) || $this->is_array_has_value('autocomplete', $addition)){
            $autocomplete = array();

            if(key_exists('autocomplete',$addition) && $addition['autocomplete'] != null && $addition['autocomplete'] != '')
                $autocomplete = $addition['autocomplete'];

            $data['baseimport'] .= link_tag($this->ci->config->item('css_autocomplete'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_autocomplete'));
        }
        // belum ditesting - belum bootstrap
        if(key_exists('timepicker',$addition) || $this->is_array_has_value('timepicker', $addition)){
            $timepicker = array();

            if(key_exists('timepicker',$addition) && $addition['timepicker'] != null && $addition['timepicker'] != '')
                $timepicker = $addition['timepicker'];

            $data['baseimport'] .= link_tag($this->ci->config->item('css_timepicker'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_timepicker'));
        }
        // belum ditesting - belum bootstrap
        if(key_exists('chart',$addition) || $this->is_array_has_value('chart', $addition)){
            $chart = array();

            if($addition['chart'] != null && $addition['chart'] != '')
                $chart = $addition['chart'];

            $data['baseimport'] .= script_tag($this->ci->config->item('script_highcharts'));
            $data['baseimport'] .= script_tag($this->ci->config->item('script_highcharts_exporting'));
        }

        return $data;
    }

    /**
     * Generate initialization for tinymce script
     * @param array $buttons Richtext formating buttons that what to enable/disable
     * @return string
     */
    private function generateTinyMceImport($buttons=array()){

        if(key_exists('button1', $buttons)){
            if($buttons['button1'] == 'default')
                $buttons['button1'] = 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect';
        }else $buttons['button1'] = '';

        if(key_exists('button2', $buttons)){
            if($buttons['button2'] == 'default')
                $buttons['button2'] = 'cut,copy,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,ibrowser,image,cleanup,|,preview,|,forecolor,backcolor,pagebreak';
        }else $buttons['button2'] = '';

        if(key_exists('button3', $buttons)){
            if($buttons['button3'] == 'default')
            $buttons['button3'] = 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,advhr,|,print,|,fullscreen';
        }else $buttons['button3'] = '';

        $tinymce_import = <<<EOT
            <script type="text/javascript">
                    tinyMCE.init({
                        // General options
                        mode : "textareas",
                        elements : 'nourlconvert',
                        relative_urls : false,
                        convert_urls : false,
                        theme : "advanced",
                        plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

                        // Theme options
                        theme_advanced_buttons1 : "$buttons[button1]",
                        theme_advanced_buttons2 : "$buttons[button2]",
                        theme_advanced_buttons3 : "$buttons[button3]",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,


                        // Example content CSS (should be your site CSS)
                        content_css : "css/content.css",

                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url : "lists/template_list.js",
                        external_link_list_url : "lists/link_list.js",
                        external_image_list_url : "lists/image_list.js",
                        media_external_list_url : "lists/media_list.js",

                        // Replace values for the template plugin
                        template_replace_values : {
                            username : "Some User",
                            staffid : "991234"
                        }
                    });
        </script>
EOT;

        return $tinymce_import;
    }

    /**
     * Trimming all POST & GET Request
     */
    public function trimmingRequest(){
        ($_POST != false) ? $postKeys = array_keys($_POST) : $postKeys = array();
        ($_GET != false) ? $getKeys = array_keys($_GET) : $getKeys = array();

        foreach($postKeys as $key){
            $_POST[$key] = str_replace('%20','',$_POST[$key]);
            if(!is_array($_POST[$key])) $_POST[$key] = trim($_POST[$key]);
        }
        foreach($getKeys as $key){
            $_GET[$key] = str_replace('%20','',$_GET[$key]);
            if(!is_array($_GET[$key])) $_GET[$key] = trim($_GET[$key]);
        }
    }

    /**
     * Delete file if its exist with spesific path and filename
     * @param $filepath Filepath of file (can be path of directory) !important >> must be real path
     * @param $file Filename that want to be deleted
     */
    public function deleteIfExists($filepath,$file){
        if($file != "" && $file != null){
            if(file_exists($filepath."/".$file)){ unlink($filepath."/".$file); }
        }
    }

    /**
     * Get current date in PHP that compatible with MySQL TIMESTAMP format
     * @return string
     */
    public function currentDateMySQLFormat(){
        return date('Y-m-d H:i:s');
    }

    /**
     * Custom encryption text (usually use for password encryption)
     * @param $text Text that wanted to be encrypted
     * @return string
     */
    public function ecnryptThis($text){
        $md=md5($text);
        return substr($md,4).substr($md,0,4).rand();
    }

    /**
     * Check raw text, encrypt it and compare with encrypted text (usally use for checking password authentication)
     * @param $text Raw Text
     * @param $encryptText Encrypted text that want to be match with Rat Text
     * @return bool
     */
    public function check($text,$encryptText){
        $md=md5($text);
        $te=substr($md,4).substr($md,0,4);
        return $te==substr($encryptText,0,strlen($te));
    }

    /**
     * Convert array to become separated each string, ex : "1,2,3" will become ",""12","3"
     * @param $arry Array that want to be converted
     * @return string
     */
    public function implodeArrayToEachString($arry){
        $result = implode('","',$arry);
        return '"'.$result.'"';
    }

    /**
     * Combine between idparent and array of id --> usefull for many to many table
     * @param $id Id parent
     * @param $arry Array of id for combine with id parent (ex : array('1','2','3'..))
     * @return string String of combine result (ex : '(1,2),(1,3),(1,4)..'))
     */
    public function constructManyToMany($id,$arry){
        $valueText = '';
        for($i=0;$i<count($arry);$i++){
            if($i != 0) $valueText .= ',';

            $valueText .= '('.$id.','.$arry[$i].')';
        }
        return $valueText;
    }

    /**
     * Set confirmation to next render (success/error) message with flashdata
     * @param $result Variable to use as guidance (success/error) - error : $result == 0, success : $result > 0
     * @param $success Success message and redirect link to trigger
     * @param $error Error message and redirect link to trigger
     */
    public function generate_confirmation($result,$success,$error){

        if(is_array($success) && is_array($error) && key_exists('message',$success)
            && key_exists('redirect',$success) && key_exists('message',$error) && key_exists('redirect',$error)){
            if($result > 0){
                $this->ci->session->set_flashdata('confirmation',
                    array('type' => 'success','message' => $success['message']));
                if(isset($success['redirect'])) redirect($success['redirect']);
            }
            else {
                $this->ci->session->set_flashdata('confirmation',
                    array('type' => 'error','message' => $error['message']));
                if(isset($success['redirect'])) redirect($error['redirect']);
            }
        }
        return false;
    }

    /**
     * Get excerpt from string
     *
     * @param String $str String to get an excerpt from
     * @param Integer $startPos Position int string to start excerpt from
     * @param Integer $maxLength Maximum length the excerpt may be
     * @return String excerpt
     */
    public function get_excerpt($str, $startPos=0, $maxLength=100, $withHTML=FALSE, $allowable_tags='') {
        $str = trim($str);

        if($withHTML) $str = strip_tags($str,$allowable_tags);

        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

    /**
     * Upload a file with Code Igniter Library Helper (upload, image_lib
     * @param null $upload Upload setting.. Follow the upload setting on CI
     * @return array
     */
    function do_upload($upload=null){
        if($upload == null) return;

        $this->ci->load->library('upload', $upload);
        $result = array('result'=>1,'error'=>'','file'=>'');

        if(!$this->ci->upload->do_upload()){
            $err = $this->ci->upload->display_errors('<p>', '</p>');
            $result['result'] = 0;
            $result['error'] = $err;
        }
        $file_data = $this->ci->upload->data();

        $result['file'] = $file_data;

        return $result;
    }

    /**
     * Manipulate image (resize, rotate, crop, etc.. )
     * @param null $manipulate Manipulate setting to be performed
     */
    function manipulate_image($type='',$image_data,$manipulate=null){

        if($type == '' || $manipulate == null) return;

        $result = array('result'=>1,'error'=>'','file'=>'');

        if($type == 'resize'){
            if($manipulate == null) return $result;
            $manipulate['source_image'] = $image_data['full_path'];
            $this->ci->load->library('image_lib');
            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($manipulate);
            if(!$this->ci->image_lib->resize()){
                $err = $this->ci->image_lib->display_errors('<p>', '</p>');
                $result['result'] = 0;
                $result['error'] = $err;
            }
            $result['file'] = $image_data;

            return $result;
        }
        return;
    }

    /**
     * Get realpath of a file/directory (usually use for file upload path.. base_url() can't be used, because its only url path not real directory path
     * @param string $url URL to append with realpath
     * @return string
     */
    function get_realpath($url=''){
        return realpath(APPPATH.$url);
    }


    /**
     * Recursively check whether a value is contain in the array (no matter how deep it is, use standard array or hash array)
     * @param $needle Value that want to be search
     * @param $haystack Array of collection
     * @return bool
     */
    function is_array_has_value($needle, $haystack) {
        if(in_array($needle, $haystack)) {
            return true;
        }
        foreach($haystack as $element) {
            if(is_array($element) && $this->is_array_has_value($needle, $element))
                return true;
        }
        return false;
    }

    function array_unshift_assoc(&$arr, $key, $val){
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr = array_reverse($arr, true);

        return $arr;
    }
}
