<?php

class login_model extends MY_Model{
    var $USER_ROLE;
    
    function __construct() {
        parent:: __construct();
        $this->load->helper('url');
        
        $this->USER_ROLE['ADMIN'] = array('add_user'=>true, 'edit_ap'=>true, 'add_segmen'=>true,'add_site'=>true, 'edit_site'=>true, 'add_area'=>true, 'edit_area'=>true, 'add_ap'=>true);
        $this->USER_ROLE['SECRETARY'] = array('add_user'=>true, 'edit_ap'=>true, 'add_segmen'=>true,'add_site'=>true, 'edit_site'=>true, 'add_area'=>true, 'edit_area'=>true, 'add_ap'=>false);
        $this->USER_ROLE['DIRECTOR'] = array('add_user'=>false, 'edit_ap'=>false, 'add_segmen'=>false,'add_site'=>false, 'edit_site'=>false, 'add_area'=>false, 'edit_area'=>false, 'add_ap'=>true);
    }

    /**
     * Check login authentication
     * @param $username
     * @param $password
     * @return bool
     */
    function isAuthorize($username,$password){
        $isFound = false;
        $query = $this->db->query("select iduser, username, role, status, password from users where isdeleted=0 and status = 1");

        foreach($query->result() as $row){
            if($row->username == $username){
                if(($this->base->check($password,$row->password))){
                    $isFound = true;
                    break;
                }
            }
        }

        if($isFound){
            $this->load->library('session');
            $row->role = 'ADMIN';
            $userlogin = array(
                    'username' => $row->username,
                    'iduser' => $row->iduser,
                    'role' => $row->role,
                    'ability' => $this->USER_ROLE[$row->role],
            );
            $this->session->set_userdata('userlogin',$userlogin);
        }

        return $isFound;
    }
}

?>