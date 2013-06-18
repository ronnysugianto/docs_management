<?php

/**
 * Extended CI_Controller with custom functions
 *
 */
ini_set('display_errors',1);
ini_set('date.timezone', 'Asia/Jakarta');
class MY_Controller extends CI_Controller{
    /**
     * @var base Object variable from class base.php (libraries/myme_library/base)
     */
    var $base;
    var $user_roles;
    var $doc_status;
    var $doc_types;
    var $archived_status;
    var $priority_list;
    var $sorted_by;
    var $doc_imgpath;

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('view_helper');
        $this->load->library('session');
        $this->load->library('myme_library/base');
        $this->load->library('firephp');

        $this->user_roles = array('ADMIN'=>'ADMIN','SECRETARY'=>'SECRETARY','DIRECTOR'=>'DIRECTOR');
        $this->doc_status = array('-1'=>'REJECTED','0'=>'WAITING','1'=>'APPROVED');
        $this->archived_status = array('0'=>'UN-ARCHIVED','1'=>'ARCHIVED');
        $this->doc_types = array('PR'=>'PR','PO'=>'PO');
        $this->priority_list = array('NORMAL' => 'NORMAL','URGENT' => 'URGENT');
        $this->sorted_by = array('0'=>'Priority','1'=>'Created By','2'=>'Status Edited Date');
        $this->doc_imgpath = base_url().'assets/images/';

        $this->base = new base();
        $this->require_login();
//        $this->output->enable_profiler(TRUE); //for debugging only
    }

    /**
     * Get current user login information
     * Return USER DATA (object) from $this->session->userdata('userlogin')
     * @return bool
     */
    public function current_user(){
        if ($this->session->userdata('userlogin')) {
            return $this->session->userdata('userlogin');
        } else {
            return FALSE;
        }
    }

    /**
     * Set USER DATA (object) to $this->session->set_userdata('userlogin',$userlogin);
     * @param $userlogin Object USER DATA that will be added to session
     */
    public function set_current_user($userlogin){
        $this->session->set_userdata('userlogin',$userlogin);
    }

    /**
     * Check USER authencation for each page.. Except in page 'loginc/doLogin' and 'loginc/index'
     * <br/>
     * <ol>
     *  <li>'loginc/doLogin' > URL Path for user when submitint login credential</li>
     *  <li>'loginc/index' > URL Path for Login Page</li>
     * </ol>
     */
    public function require_login(){
        if (!$this->current_user() && $this->uri->uri_string() != 'loginc/doLogin' && $this->uri->uri_string() != 'loginc/index'){
            redirect('loginc/index');
        }
    }

    /**
     * Load view with template
     * @param string $page_title Title of the page
     * @param $view View that will be rendered in section tag
     * @param array $data Data that will be passed to view (in array)
     */
    protected function load_view_with_layout($page_title='',$view, $data=array()){
        //This is the end. Must not return.
        $data['current_user'] = $this->current_user();
        $data['view'] = $view;
        $data['page_title'] = $page_title;
        $this->load->view('myme_views/template', $data);
    }

    /**
     * Firephp library to write to firephp console as Warning (usually for tracking & debugging)
     * @param $text Text to write to firephp consle
     */
    protected function console($text){
        $this->firephp->warn($text);
    }

    /**
     * External library to track visited URL History (usually for tracking & debugging)
     * Write to Firebug console
     */
    protected function view_history(){
        $this->console('last page 0 >> '.$this->session->last_page());
        $this->console('last page 1 >> '.$this->session->last_page(1));
        $this->console('last page 2 >> '.$this->session->last_page(2));
        $this->console('last page 3 >> '.$this->session->last_page(3));
        $this->console('referrer page >> '.$this->input->server('HTTP_REFERER', TRUE));
    }

    /**
     * Function to return array base on its statickeys.. If key not found, will be fill as empty string
     * @param type $setting Array that wanted to check
     * @param type $staticKeys Array of key value that must be exist in $setting
     * @return string return array that already been checked..
     */
    protected function validateSetting($setting,$staticKeys){
        $validSetting = array();

        foreach($staticKeys as $key){
            if(isset($setting[$key])) $validSetting[$key] = urldecode($setting[$key]);
            else $validSetting[$key] = '';
        }

        return $validSetting;
    }

}