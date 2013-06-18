<?php

class login_model extends MY_Model{
    var $USER_ROLE;

    function __construct() {
        parent:: __construct();
        $this->load->helper('url');

        /*
            ROLE List :
            1. user_management > Add, Edit, Delete User Management
            2. document_management > type: ADMIN > Document management with full filtering options
            3. document_management > type: SECRETARY > Document management with spesific filtering options and only documents created by himself
            4. document_statistic > Statistic document report created by himself
        */
        // Filtering for role : ADMIN
        $DOC_FILTER_ROLE['ADMIN'] = array('ref_id','status','status_edit_date','type','created_by','created_for','created_date','priority','sorted_by');
        // Filtering for role SECRETARY
        $DOC_FILTER_ROLE['SECRETARY'] = array('ref_id','status','created_date','created_for','status_edit_date');

        $this->USER_ROLE['ADMIN'] = array(
            'user_management'=>array(),
            'document_management'=>array('filter_role'=>$DOC_FILTER_ROLE['ADMIN'])
            );
        $this->USER_ROLE['SECRETARY'] = array(
            'document_management'=>array('add_document'=>null,'delete_document'=>null,'bulk_action'=>null,'filter_role'=>$DOC_FILTER_ROLE['SECRETARY']),
            'document_statistic'=>array('send_email'=>null)
            );
        $this->USER_ROLE['DIRECTOR'] = array(
            'approved_document'=>array(),
            'pending_document'=>array(),
            'wizard_screen'=>array(),
            );
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