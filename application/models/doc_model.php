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
        $this->firephp->warn($filter);
        $this->firephp->warn($where);

        return $this->db->query('select d.iddocument, d.priority, d.type, d.isarchived, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%Y-%m-%d") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser '.$where.' limit ' . $start . ',' . $limit);
    }

    function read($id) {
        return $this->db->query('select d.iddocument, d.priority, d.type, d.isarchived, d.image, d.description, d.created_for, uu.username as created_for_name, uu.email, u.username as created_by_name, u.email as created_by_email, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%Y-%m-%d") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser where d.iddocument = '.$id);
    }

    function statistic($filter=null){
        $where = '';
        if(isset($filter['created_by'])) $where = 'and created_by = '.$filter['created_by'];

        return $this->db->query('select sum(case when isemailed=1 then 1 else 0 end) as emailed, sum(case when isemailed=1 then 0 else 1 end) as unemailed, sum(case when isarchived=1 then 1 else 0 end) as archived,sum(case when isarchived=1 then 0 else 1 end) as unarchived from documents where isdeleted = 0 '.$where);
    }

    function get_email_list($filter=null){
        $where = '';
        if(isset($filter['created_by'])) $where = 'and d.created_by = '.$filter['created_by'];

        return $this->db->query('select u.email,group_concat(d.iddocument) as iddocument,sum((case when d.isemailed = 0 then 1 else 0 end)) as unemailed,uu.username as created_by_name from documents d left join users u on d.created_for = u.iduser LEFT JOIN users uu on d.created_by = uu.iduser where d.isdeleted = 0 '.$where.' GROUP BY d.created_for');
    }

    function get_lasted_document($settings=null){
        $where = '';
        if($settings != null){
            $where = ' and d.created_for = '.$settings['created_for'];
            if($settings['current_id'] != 'null' && $settings['action'] != 'null'){
                if($settings['action'] == 'next') $where = 'and d.created_for = '.$settings['created_for'].' and d.iddocument > '.$settings['current_id'].' order by d.priority desc, d.created_date asc';
                else if($settings['action'] == 'prev') $where = 'and d.created_for = '.$settings['created_for'].' and d.iddocument < '.$settings['current_id'].' order by d.priority desc, d.created_date desc';
            }else if($settings['current_id'] != 'null') $where = 'and d.created_for = '.$settings['created_for'].' and d.iddocument = '.$settings['current_id'].' order by d.priority desc, d.created_date asc';
        }

        $this->firephp->warn($settings);
        $this->firephp->warn($where);

        return $this->db->query('select d.iddocument, d.priority, d.type, d.priority, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%d/%m/%Y") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser where d.status = 0 '.$where);
    }

    function get_around_document($iddocument,$created_for,$action){
        if($action == 'prev') $operand = '<';
        else if($action == 'next') $operand = '>';

        $query = $this->db->query('select d.iddocument, d.priority, d.type, d.priority, d.image, d.description, d.created_for, uu.username as created_for_name, u.username as created_by_name, d.status, d.status_edit_date, d.created_by, date_format(d.created_date, "%d/%m/%Y") AS created_date from documents d left join users u on d.created_by = u.iduser left join users uu on d.created_for = uu.iduser where d.status = 0 and d.created_for = '.$created_for.' and d.iddocument '.$operand.' '.$iddocument.' order by d.priority desc, d.created_date asc');

        if($query->num_rows() > 0) return true;

        return false;
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
        $where_list = array('ref_id'=>'d.iddocument','status'=>'d.status','status_date'=>'date_format(d.status_edit_date, "%Y-%m-%d")','type'=>'d.type','created_date'=>'date_format(d.created_date, "%Y-%m-%d")','created_by'=>'d.created_by','created_for'=>'d.created_for','priority'=>'d.priority','archived'=>'d.isarchived');

        $keys = array_keys($where_list);
        if(count($filter) > 0){
            foreach ($keys as $key){

                if(isset($filter[$key]) && $filter[$key] != ''){
                    $where .= ' and '.$where_list[$key] .'="'.$filter[$key].'"';
                }
            }
        }

        if(isset($filter['sorted_by']) && $filter['sorted_by'] != FALSE){
            $where .= ' order by '.$this->sorted_by[$filter['sorted_by']];
        }
        return $where;
    }

    function get_html_statistic_template($statistic){
        $app_url = base_url();
        $sent_date = date('d/m/Y');

        return <<<EOT
        <html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Statistic Report</title>
   <style type="text/css">
    a {color: #4A72AF;}
    body, #header h1, #header h2, p {margin: 0; padding: 0;}
    #main {border: 1px solid #cfcece;}
    img {display: block;}
    #top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    #header h1 {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
    #header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
    #header p {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 12px;  }
    h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
    h3,.font-large {font-size: 28px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    h4,.font-medium {font-size: 22px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    h5,.font-small {font-size: 18px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    p {font-size: 14px; color: #000000 !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
    #content-1 p { color: #ffffff !important; }
    #content-2 p { color: #000000 !important; }
    #content-2 h3 { color: #000000 !important;font-size: 36px; }
    #button h4 { margin-bottom: 0!important; }

   </style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td>

    <table id="top-message" cellpadding="20" cellspacing="0" width="600" align="center">
        <tr>
            <td align="center">
            </td>
        </tr>
    </table><!-- top message -->

    <table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
        <tr>
            <td>
                <table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="F89406">
                    <tr>
                        <td width="570" align="center" bgcolor="E08200"><h1>Document Statistic Report</h1></td>
                    </tr>
                    <tr>
                        <td width="570" align="center"><p>$sent_date</p></td>
                    </tr>
                </table><!-- header -->
            </td>
        </tr><!-- header -->
        <tr>
            <tr>
                <td>
                <table id="content-2" cellpadding="25" cellspacing="0" align="center">
                    <tr>
                    <td width="570" valign="bottom" align="center">
                        <h3>$statistic->unemailed<p>Document(s) Waiting for Response</p></h3>
                    </td>
                    </tr>
                </table>
                </td>
            </tr>
        </tr>
        <tr>
            <td>
            <table id="button" cellpadding="15" cellspacing="10" align="center">
                <td width="570" align="center" bgcolor="EAEAEA" valign="bottom">
                    <a href="$app_url"><h4><u>Go to Application</u></h4></a>
                </td>
            </table>
            </td>
        </tr>

    </table><!-- main -->
    <table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
        <tr>
            <td align="center">
                <p>@2013 | Developed by <a href="http://www.myme-tech.com" target="_blank">MyMe.Technology</a></p>
            </td>
        </tr>
    </table><!-- top message -->
</td></tr></table><!-- wrapper -->

</body>
</html>
EOT;
    }

    function get_html_mail_notification($doc){
        $app_url = base_url();

        return <<<EOT
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Statistic Report</title>
   <style type="text/css">
    a {color: #4A72AF;}
    body, #header h1, #header h2, p {margin: 0; padding: 0;}
    #main {border: 1px solid #cfcece;}
    img {display: block;}
    #top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    #header h1 {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
    #header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
    #header p {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 12px;  }
    h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
    h3,.font-large {font-size: 28px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    h4,.font-medium {font-size: 22px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    h5,.font-small {font-size: 18px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
    p {font-size: 24px; color: #000000 !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
    #content-1 p { color: #ffffff !important; }
    #content-2 p { color: #000000 !important; }
    #content-2 h3 { color: #000000 !important;font-size: 36px; }
    #button h4 { margin-bottom: 0!important; }

   </style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td>

    <table id="top-message" cellpadding="20" cellspacing="0" width="600" align="center">
        <tr>
            <td align="center">
            </td>
        </tr>
    </table><!-- top message -->

    <table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
        <tr>
            <td>
                <table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="F89406">
                    <tr>
                        <td width="570" align="center" bgcolor="E08200"><h1>Response Notification</h1></td>
                    </tr>
                    <tr>
                        <td width="570" align="center"><p>Response Date: $doc->status_edit_date</p></td>
                    </tr>
                </table><!-- header -->
            </td>
        </tr><!-- header -->
        <tr>
            <tr>
                <td>
                <table id="content-2" cellpadding="25" cellspacing="0" align="center">
                    <tr>
                        <td width="570" valign="bottom" align="center">
                            <h3><p>Document with Ref. ID</p>$doc->iddocument<p>Now Has Been <u>$doc->status</u></p></h3>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </tr>
        <tr>
            <td>
            <table id="button" cellpadding="15" cellspacing="10" align="center">
                <td width="570" align="center" bgcolor="EAEAEA" valign="bottom">
                    <a href="$app_url"><h4><u>Go to Application</u></h4></a>
                </td>
            </table>
            </td>
        </tr>

    </table><!-- main -->
    <table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
        <tr>
            <td align="center">
                <p>@2013 | Developed by <a href="http://www.myme-tech.com" target="_blank">MyMe.Technology</a></p>
            </td>
        </tr>
    </table><!-- top message -->
</td></tr></table><!-- wrapper -->

</body>
</html>
EOT;
    }

    function get_html_email_template($doc){
        $app_url = base_url();
        $doc->description = html_entity_decode($doc->description,ENT_QUOTES);
        return <<<EOT
        <html>
            <head>
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
               <title>Notification Email</title>
               <style type="text/css">
                a {color: #4A72AF;}
                body, #header h1, #header h2, p {margin: 0; padding: 0;}
                #main {border: 1px solid #cfcece;}
                img {display: block;}
                #top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
                #header h1 {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
                #header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
                #header p {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 12px;  }
                h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
                h3,.font-large {font-size: 28px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
                h4,.font-medium {font-size: 22px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
                h5,.font-small {font-size: 18px; color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; }
                p {font-size: 12px; color: #000000 !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
                #content-1 p,h3 { color: #000000 !important; }
                #content-2 p,h3 { color: #000000 !important; }
                #button h4 { margin-bottom: 0!important; }

               </style>
            </head>
            <body>

            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td>

                <table id="top-message" cellpadding="20" cellspacing="0" width="600" align="center">
                    <tr>
                        <td align="center">
                        </td>
                    </tr>
                </table><!-- top message -->

                <table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
                    <tr>
                        <td>
                        <table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="F89406">
                            <tr>
                                <td width="570" align="center" bgcolor="D34943" valign="bottom"><h1>Waiting for Response</h1></td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="F89406">
                                <tr>
                                    <td width="570" bgcolor="E08200"><h2>Document Ref ID: $doc->iddocument</h2></td>
                                </tr>
                                <tr>
                                    <td width="570"><p>$doc->created_date</p></td>
                                </tr>
                            </table><!-- header -->
                        </td>
                    </tr><!-- header -->
                    <tr>
                        <tr>
                            <td>
                            <table id="content-1" cellpadding="10" cellspacing="0" align="center">
                                <td width="170" valign="bottom" bgcolor="d0d0d0" align="center">
                                    <h3>$doc->status<p>Document Status</p></h3>
                                </td>
                                <td width="170" valign="bottom" bgcolor="d0d0d0" align="center">
                                    <h3>$doc->type<p>Document Type</p></h3>
                                </td>
                                <td width="170" valign="bottom" bgcolor="d0d0d0" align="center">
                                    <h3>$doc->priority<p>Document Priority</p></h3>
                                </td>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <table id="content-2" cellpadding="5" cellspacing="0" align="center">
                                <tr>
                                <td width="255" valign="bottom" bgcolor="d0d0d0" align="center">
                                    <h3>$doc->created_by_name<p>Created By</p></h3>
                                </td>
                                <td width="15" bgcolor="d0d0d0"></td>
                                <td width="255" valign="bottom" bgcolor="d0d0d0" align="center">
                                    <h3>$doc->created_for_name<p>Created For</p></h3>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <table id="content-3" cellpadding="0" cellspacing="0" align="center" width="100%">
                                <tr>
                                    <td valign="top" bgcolor="d0d0d0" style="padding:5px;">
                                        <img src="$doc->image" width="100%" />
                                    </td>
                                </tr>
                            </table><!-- content-3 -->
                        </td>
                    </tr><!-- content-3 -->
                    <tr>
                        <td>
                            <table id="content-4" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td width="570"><p>$doc->description</p></td>
                                </tr>
                            </table><!-- content-2 -->
                        </td>
                    </tr><!-- content-2 -->
                    <tr>
                    <td>
                        <table id="button" cellpadding="10" cellspacing="10" align="center">
                            <td width="570" align="center" bgcolor="EAEAEA" valign="bottom">
                                <a href="$app_url"><h4><u>Go to Application</u></h4></a>
                            </td>
                        </table>
                        </td>
                    </tr>

                </table><!-- main -->
                <table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
                    <tr>
                        <td align="center">
                            <p>@2013 | Developed by <a href="http://www.myme-tech.com" target="_blank">MyMe.Technology</a></p>
                        </td>
                    </tr>
                </table><!-- top message -->
            </td></tr></table><!-- wrapper -->

            </body>
            </html>
EOT;
    }

}

?>
