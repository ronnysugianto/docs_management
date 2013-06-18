<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author ronnysugianto
 */
class user_model extends MY_Model {

    var $tablename = 'users';

    function __construct() {
        parent:: __construct();
        $this->load->helper('url');
    }

    function readAll($start, $limit) {
        return $this->db->query('select iduser, username, email, role, status from users where isdeleted=0 limit ' . $start . ',' . $limit);
    }

    function read($id) {
        return $this->db->query('select iduser, username, email, password, status, role from users where iduser=' . $id);
    }

    function insert($data) {
        return $this->insertToDatabase($this->tablename, $data);
    }

    function update($data, $where) {
        return $this->updateToDatabase($this->tablename, $data, $where);
    }

    function delete($where) {
        return $this->updateToDatabase($this->tablename, array('isdeleted' => '1'), $where);
    }

    function row_count() {
        return $this->db->query('select iduser from users where isdeleted=0')->num_rows();
    }

    function read_as_list($role) {

        $query = $this->db->query('select iduser, username from users where role = "'.$role.'" and isdeleted = 0')->result_array();
        foreach ($query as $q) {
            $parents[$q['iduser']] = $q['name'];
        }
        return $parents;
    }

    function get_list_by_role($role = 'SECRETARY'){
        $query = $this->db->query('select iduser, username from users where role="'.$role.'" and isdeleted = 0 and status = 1')->result();

        $list = array();
        foreach ($query as $q) {
            $list[$q->iduser] = $q->username;
        }
        return $list;
    }


}

?>
