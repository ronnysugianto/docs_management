<?php
/**
 * Extended CI_Session with custom functions
 */
class MY_Session extends CI_Session {

    function __construct() {
        parent::__construct();

        $this->tracker();
    }

    /**
     * Track every URL Access in array and keep it in session ('_tracker')
     */
    public function tracker() {
        $this->CI->load->helper('url');

        $tracker =& $this->userdata('_tracker');

        if( $this->is_ajax() == FALSE ) {
            $tracker[] = array(
                'uri'   =>      $this->CI->uri->uri_string(),
                'ruri'  =>      $this->CI->uri->ruri_string(),
                'timestamp' =>  time()
            );
        }

        $this->set_userdata( '_tracker', $tracker );
    }


    /**
     * Get last_page with
     * @param Integer $offset Index page in history (1 > 1 page before, 2 > 2 page before, etc ..)
     * @param String $key Get URL type ('uri/ruri')
     */
    public function last_page( $offset = 0, $key = 'uri' ) {
        if( !( $history = $this->userdata('_tracker') ) ) {
            return $this->config->item('base_url');
        }

        $history = array_reverse($history);

        if( isset( $history[$offset][$key] ) ) {
            return $history[$offset][$key];
        } else {
            return $this->config->item('base_url');
        }
    }

    private function is_ajax(){
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}