<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Model DAO from Site
 *
 * @author ronnysugianto
 */
class doc_model extends MY_Model {

    var $tablename = 'documents';
    var $sorted_by = array('0'=>'d.priority','1'=>'d.created_by','2'=>'d.status_edit_date','3'=>'d.priority, d.created_date');

    function __construct() {
        parent:: __construct();
        $this->load->helper('url');
        $this->load->library('firephp');
    }

    function readAll($start, $limit,$filter=array()) {

        $where = $this->construct_where($filter);

        return $this->db->query('select d.iddocument, d.priority, d.type, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%Y-%m-%d") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser '.$where.' limit ' . $start . ',' . $limit);
    }

    function read($id) {
        return $this->db->query('select d.iddocument, d.priority, d.type, d.priority, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%Y-%m-%d") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser where d.iddocument = '.$id);
    }

    function statistic(){
        return $this->db->query('select sum(case when isemailed=1 then 1 else 0 end) as emailed, sum(case when isemailed=1 then 0 else 1 end) as unemailed, sum(case when isarchived=1 then 1 else 0 end) as archived,sum(case when isarchived=1 then 0 else 1 end) as unarchived from documents');
    }

    function get_lasted_document($settings=null){
        $where = '';
        if($settings != null){
            if($settings['current_id'] != 'null' && $settings['action'] != 'null'){
                if($settings['action'] == 'next') $where = 'where iddocument > '.$settings['current_id'];
                else if($settings['action'] == 'prev') $where = 'where iddocument < '.$settings['current_id'];
            }else if($settings['current_id'] != 'null') $where = 'where iddocument = '.$settings['current_id'];
        }

        return $this->db->query('select d.iddocument, d.priority, d.type, d.priority, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%Y-%m-%d") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser '.$where.' order by d.iddocument desc');
    }

    function insert($data) {
        return $this->insertToDatabase($this->tablename, $data);
    }

    function update($data, $where) {
        return $this->updateToDatabase($this->tablename, $data, $where);
    }

    function delete($where) {
        return $this->updateToDatabase($this->tablename, array('isdeleted' => '1','image' => ''), $where);
    }

    function row_count($filter) {
        $where = $this->construct_where($filter);

        return $this->db->query('select d.iddocument from documents d '.$where)->num_rows();
    }

    function construct_where($filter){
        $where = 'where d.isdeleted = 0 ';
        $where_list = array('ref_id'=>'d.iddocument','status'=>'d.status','status_date'=>'d.status_edit_date','type'=>'d.type','created_by'=>'d.created_by','created_for'=>'d.created_for','priority'=>'d.priority');

        $keys = array_keys($where_list);
        if(count($filter) > 0){
            foreach ($keys as $key){
                if(array_key_exists($key,$filter) && $filter[$key] != 'null' && $filter[$key] != '')
                    $where .= ' and '.$where_list[$key] .'="'.$filter[$key].'"';
            }
        }


        if(isset($filter['sorted_by']) && $filter['sorted_by'] != FALSE){
            $where .= ' order by '.$this->sorted_by[$filter['sorted_by']];
        }
        return $where;
    }

}

?>
