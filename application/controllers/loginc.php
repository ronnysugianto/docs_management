<?php
class loginc extends MY_Controller{
    var $login_model;

    function __construct() {
        parent:: __construct();
        $this->load->model('login_model');
        $this->login_model = new login_model();
    }

    function index(){
        
        $data = $this->base->baseImport();

        $this->load_view_with_layout('Admin Login','login/index',$data);
    }
    
    function doLogin(){

        if($this->input->post()){
            $isAuthorize = $this->login_model->isAuthorize($this->input->post('username'),$this->input->post('password'));
            
            if($isAuthorize) {
                $this->load_view_with_layout('Welcome','login/welcome');
            }
            else redirect('loginc/');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('loginc/');
    }
}

?>
