<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Master data Site
 *
 * @author ronnysugianto
 */

class docc extends MY_Controller {

    var $doc;
    var $user;
    var $tablegenerator;
    var $user_login;
    var $user_ability;
    var $image_real_path;
    var $upload_setting;
    var $resize;
    var $bulk_action_list;
    var $email_setting;

    function __construct() {
        parent:: __construct();

        $this->user_login = $this->session->userdata('userlogin');
        $this->user_ability = $this->user_login['ability'];

        $this->load->library('myme_library/class/TableGenerator');
        $this->load->model('doc_model');
        $this->load->model('user_model');
        $this->tablegenerator = new TableGenerator();
        $this->doc = new doc_model();
        $this->user = new user_model();
        $this->image_real_path = $this->base->get_realpath('../assets/images/');
        $this->bulk_action_list = array(
            // '-1'=>'MARK AS REJECTED',
            // '1'=>'MARK AS APPROVED',
            '3'=>'MARK AS ARCHIVED',
            '2'=>'DELETE');

        $this->upload_setting = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->image_real_path,
            'max_size' => 2000,
            'file_name' => time(),
        );

        $this->resize = array(
            'new_image' => $this->image_real_path,
            'maintain_ration' => true,
            'width' => 600,
            'height' => 350
        );

        $this->email_setting = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'smtp_user' => 'support@webmurahbagus.com',
            'smtp_pass' => 'webmurahbagus.com'
        );
    }

    function index($start = 0) {
        $limit = 20;
        // SET FILTER CRITERIA
        $indexs = array('ref_id','status','type','created_by','status_date','created_date','created_for','priority','sorted_by','archived','page');
        $filter = $this->uri->uri_to_assoc(3,$indexs);
        $uri_seg = count($this->uri->segment_array());

        if($this->user_login['role'] == 'SECRETARY')
            $filter['created_by'] = $this->user_login['iduser'];

        if($filter['page']){
            $start = $filter['page'];
            unset($filter['page']);
        }else{
            $start = end($this->uri->segments);
            if(!is_numeric($start)) $start = 0;
        }

        $data = $this->base->baseImport(array('datepicker'));

        $filter = $this->validateSetting($filter, $indexs);
        $data['filter'] = $filter;

        $custom_function = array(
        'modify_row_data' => function($row, $key) {
            if($key === 'status') $row->$key = $this->doc_status[$row->$key];
            else if($key === 'isarchived') $row->$key = $this->archived_status[$row->$key];
            return '';
        });

        $query = $this->doc->readAll($start, $limit, $filter);
        $this->console($this->db->last_query());

        $data['doctable'] = $this->tablegenerator->generateTable(array(
            'type' => 'ITEM',
            'idAndName' => 'doctable',
            'no_start' => $start + 1,
            'result' => $query->result(),
            'iditem' => 'iddocument',
            'header' => array(
                array('data' => 'Ref ID', 'width' => '8%'),
                array('data' => 'Type', 'width' => '15%'),
                array('data' => 'Description', 'width' => '30%'),
                array('data' => 'Created For', 'width' => '10%'),
                array('data' => 'Status', 'width' => '10%'),
                array('data' => 'Archived', 'width' => '10%'),
                array('data' => 'Priority', 'width' => '10%'),
                array('data' => 'Created Date', 'width' => '10%'),
            ),
            'itemlist' => array('iddocument'=>'text','type'=>'text','description'=>'longtext_with_excerpt','created_for_name'=>'text','status'=>'text','isarchived'=>'text','priority'=>'text','created_date'=>'text',
                array('data' => 'View', 'link' => base_url() . 'index.php/docc/view/', 'use_iditem' => true, 'action_group' => true, 'use_btn' => false)),
            'directory' => '',
            'controller' => 'docc',
            'custom_function' => $custom_function,
            'useedit' => false,
            'usedelete' => array_key_exists('delete_document', $this->user_ability['document_management']),
            'usecheckbox' => true,
            'action_group' => true,
            'moreAttr' => 'width=90%',
            'pagination' => array('base_url' => base_url().'index.php/docc/index/'.$this->construct_url($filter), 'total_rows' => $this->doc->row_count($filter), 'per_page' => $limit, 'num_links' => 10,'uri_segment'=>$uri_seg),
        ));

        $data['user_ability'] = $this->user_ability;
        $data['doc_status'] = $this->doc_status;
        $data['created_for_list'] = $this->user->get_list_by_role('DIRECTOR');
        $data['created_by_list'] = $this->user->get_list_by_role('SECRETARY');
        $data['priority_list'] = $this->priority_list;
        $data['archived_list'] = $this->archived_status;
        $data['doc_types'] = $this->doc_types;
        $data['sorted_list'] = $this->sorted_by;
        $data['bulk_action_list'] = $this->bulk_action_list;
        $data['filter_role'] = $this->user_ability['document_management']['filter_role'];

        $this->base->array_unshift_assoc($data['doc_status'], 'null', '');
        $this->base->array_unshift_assoc($data['created_for_list'], 'null', '');
        $this->base->array_unshift_assoc($data['created_by_list'], 'null', '');
        $this->base->array_unshift_assoc($data['priority_list'], 'null', '');
        $this->base->array_unshift_assoc($data['doc_types'], 'null', '');
        $this->base->array_unshift_assoc($data['sorted_list'], 'null', '');
        $this->base->array_unshift_assoc($data['archived_list'], 'null', '');

        $this->load_view_with_layout('Document List', 'doc/index', $data);
    }

    function approved($start = 0){

        $limit = 15;
        $indexs = array('ref_id','type','created_by','page','status','sorted_by','created_for');
        $filter = $this->uri->uri_to_assoc(3,$indexs);
        $filter['status'] = '1';
        $filter['sorted_by'] = '2';
        $filter['created_for'] = $this->user_login['iduser'];

        $uri_seg = count($this->uri->segment_array());

        $filter = $this->validateSetting($filter, $indexs);
        $data['filter'] = $filter;

        if($filter['page']){
            $start = $filter['page'];
            unset($filter['page']);
        }else{
            $start = end($this->uri->segments);
            if(!is_numeric($start)) $start = 0;
        }

        $custom_function = array(
        'modify_row_data' => function($row, $key) {
            if($key === 'status') $row->$key = $this->doc_status[$row->$key];
            return '';
        });

        $query = $this->doc->readAll($start, $limit, $filter);

        $data['doctable'] = $this->tablegenerator->generateTable(array(
            'type' => 'ITEM',
            'idAndName' => 'doctable',
            'no_start' => $start + 1,
            'result' => $query->result(),
            'iditem' => 'iddocument',
            'header' => array(
                array('data' => 'Ref ID', 'width' => '8%'),
                array('data' => 'Type', 'width' => '10%'),
                array('data' => 'Description', 'width' => '25%'),
                array('data' => 'Created For', 'width' => '10%'),
                array('data' => 'Status', 'width' => '10%'),
                array('data' => 'Priority', 'width' => '10%'),
                array('data' => 'Created Date', 'width' => '10%'),
                array('data' => 'View', 'width' => '7%'),
            ),
            'itemlist' => array('iddocument'=>'text','type'=>'text','description'=>'longtext_with_excerpt','created_for_name'=>'text','status'=>'text','priority'=>'text','created_date'=>'text',
                array('data' => 'View', 'link' => base_url().'index.php/docc/view/', 'use_iditem' => true, 'action_group' => false, 'use_btn' => true,'addition_url'=>'/1')),
            'directory' => '',
            'controller' => 'docc',
            'custom_function' => $custom_function,
            'useedit' => false,
            'usedelete' => false,
            'usecheckbox' => false,
            'action_group' => false,
            'moreAttr' => 'width=90%',
            'pagination' => array('base_url' => base_url().'index.php/docc/approved/', 'total_rows' => $this->doc->row_count($filter), 'per_page' => $limit, 'num_links' => 10,'uri_segment'=>$uri_seg),
        ));

        $data['created_by_list'] = $this->user->get_list_by_role('SECRETARY');
        $data['doc_types'] = $this->doc_types;

        $this->base->array_unshift_assoc($data['created_by_list'], 'null', '');
        $this->base->array_unshift_assoc($data['doc_types'], 'null', '');

        $this->load_view_with_layout('Document List', 'doc/approved', $data);
    }

    function pending($start = 0){

        $limit = 15;

        $indexs = array('ref_id','type','created_by','page','status','sorted_by','created_for');
        $filter = $this->uri->uri_to_assoc(3,$indexs);
        $filter['status'] = '0';
        $filter['sorted_by'] = '3';
        $filter['created_for'] = $this->user_login['iduser'];

        $uri_seg = count($this->uri->segment_array());

        $filter = $this->validateSetting($filter, $indexs);
        $data['filter'] = $filter;

        if($filter['page']){
            $start = $filter['page'];
            unset($filter['page']);
        }else{
            $start = end($this->uri->segments);
            if(!is_numeric($start)) $start = 0;
        }

        $custom_function = array(
        'modify_row_data' => function($row, $key) {
            if($key === 'status') $row->$key = $this->doc_status[$row->$key];
            if($key === 'iddocument') $_idItem = $row->$key;
            return '';
        });

        $query = $this->doc->readAll($start, $limit, $filter);
        $this->console($this->db->last_query());

        $data['doctable'] = $this->tablegenerator->generateTable(array(
            'type' => 'ITEM',
            'idAndName' => 'doctable',
            'no_start' => $start + 1,
            'result' => $query->result(),
            'iditem' => 'iddocument',
            'header' => array(
                array('data' => 'Ref ID', 'width' => '8%'),
                array('data' => 'Type', 'width' => '10%'),
                array('data' => 'Description', 'width' => '25%'),
                array('data' => 'Created For', 'width' => '10%'),
                array('data' => 'Status', 'width' => '10%'),
                array('data' => 'Priority', 'width' => '10%'),
                array('data' => 'Created Date', 'width' => '10%'),
                array('data' => 'View', 'width' => '7%'),
            ),
            'itemlist' => array('iddocument'=>'text','type'=>'text','description'=>'longtext_with_excerpt','created_for_name'=>'text','status'=>'text','priority'=>'text','created_date'=>'text',
                array('data' => 'View', 'link' => base_url().'index.php/docc/view/', 'use_iditem' => true, 'action_group' => false, 'use_btn' => true,'addition_url'=>'/2')),
            'directory' => '',
            'controller' => 'docc',
            'custom_function' => $custom_function,
            'useedit' => false,
            'usedelete' => false,
            'usecheckbox' => false,
            'action_group' => false,
            'moreAttr' => 'width=90%',
            'pagination' => array('base_url' => base_url().'index.php/docc/pending/', 'total_rows' => $this->doc->row_count($filter), 'per_page' => $limit, 'num_links' => 10,'uri_segment'=>$uri_seg),
        ));

        $data['created_by_list'] = $this->user->get_list_by_role('SECRETARY');
        $data['doc_types'] = $this->doc_types;

        $this->base->array_unshift_assoc($data['created_by_list'], 'null', '');
        $this->base->array_unshift_assoc($data['doc_types'], 'null', '');

        $this->load_view_with_layout('Document List', 'doc/pending', $data);
    }

    function approved_filter(){
        if($this->input->post()){
            $filter = array(
                'ref_id' => $this->input->post('ref_id'),
                'type' => $this->input->post('type'),
                'created_by' => $this->input->post('created_by'),
            );
            redirect(base_url().'index.php/docc/approved'.$this->construct_url($filter,0));
        }
    }

    function pending_filter(){
        if($this->input->post()){
            $filter = array(
                'ref_id' => $this->input->post('ref_id'),
                'type' => $this->input->post('type'),
                'created_by' => $this->input->post('created_by'),
            );
            redirect(base_url().'index.php/docc/pending'.$this->construct_url($filter,0));
        }
    }

    function document_wizard_view(){
        $action = $iddocument = 'null';
        $setting = array('current_id'=>'null','action'=>'null','created_for'=>$this->user_login['iduser']);

        if($this->input->post()){
            $action = $this->input->post('action');
            $iddocument = $this->input->post('iddocument');
            $status_selected = $this->input->post('status_selected');

            if($status_selected ==  '-1' || $status_selected == '1'){
                $result = $this->doc->update(array('status'=>$status_selected),'where iddocument = '.$iddocument);
                $action = 'next';

                if($result['result'] > 0){
                    if($status_selected == -1 || $status_selected == 1){
                        $doc = $this->doc->read($iddocument)->row();
                        $doc->status = $this->doc_status[$doc->status];
                        $html_text = $this->doc->get_html_mail_notification($doc);

                        if(isset($doc->image) && ($doc->image == NULL || $doc->image == '')) $doc->image = 'no_image.jpg';

                        $this->load->library('email');
                        $this->email->clear();
                        $this->email->initialize($this->email_setting);
                        $this->email->set_newline("\r\n");

                        $this->email->from('webmurahbagus.com','Administrator');
                        $this->email->to($doc->created_by_email);
                        $this->email->subject('[NOTIF] Document ref ID: '.$iddocument.' has been '.$doc->status.' by '.$doc->created_for_name);
                        $this->email->message($html_text);
                        $this->email->attach($this->image_real_path.'/'.$doc->image);
                        $this->console($this->image_real_path.'/'.$doc->image);

                        $this->email->send();
                    }
                }

                $this->base->generate_confirmation($result['result'],
                    array('message' => 'Previous Document with ref id: '.$iddocument.' successfully updated'),
                    array('message' => $result['error']));
            }
        }

        $setting['current_id'] = $iddocument;
        $setting['action'] = $action;

        $_query = $this->doc->get_lasted_document($setting);

        if($_query->num_rows() > 0){
            $data['doc'] = $_query->row();
            $data['current_id'] = $data['doc']->iddocument;
            $data['has_document'] = true;
            $data['has_next'] = $this->doc->get_around_document($data['doc']->iddocument,$this->user_login['iduser'],'next');
            $data['has_prev'] = $this->doc->get_around_document($data['doc']->iddocument,$this->user_login['iduser'],'prev');

        }else{
            $data['current_id'] = $iddocument;
            $data['has_document'] = false;
            $data['has_next'] = false;
            $data['has_prev'] = false;
        }

        $data['imgpath'] = $this->doc_imgpath;

        if(isset($data['doc']->image) && ($data['doc']->image == NULL || $data['doc']->image == '')) $data['doc']->image = 'no_image.jpg';
        if(isset($data['doc']->status)) $data['doc']->status = $this->doc_status[$data['doc']->status];

        $this->load_view_with_layout('Document ','doc/wizard',$data);
    }

    function statistic(){
        $filter = array('created_by'=>$this->user_login['iduser']);
        $data['statistic'] = $this->doc->statistic($filter)->row();
        $this->console($this->db->last_query());

        $this->load_view_with_layout('Document Statistic','doc/statistic',$data);
    }

    function send_email($iddocument){
        $doc = $this->doc->read($iddocument)->row();

        if($doc->image == ''){
            $doc->image = $this->doc_imgpath.'no_image.jpg';
            $file = 'no_image.jpg';
        }
        else{
            $file = $doc->image;
            $doc->image = $this->doc_imgpath.$doc->image;
        }
        $html_text = $this->doc->get_html_email_template($doc);

        $this->load->library('email');
        $this->email->clear();
        $this->email->initialize($this->email_setting);
        $this->email->set_newline("\r\n");

        $this->email->from('webmurahbagus.com',$doc->created_by_name);
        $this->email->to($doc->email);
        $this->email->subject('[URGENT] '.$doc->created_by_name.' notif you about Document: '.$iddocument);
        $this->email->message($html_text);
        $this->email->attach($this->image_real_path.'/'.$file);
        $this->console('>>> file path : '.$this->image_real_path.'/'.$file);
        // $this->email->attach($this->image_real_path.$file);

        if(!$this->email->send()) return false;

        return true;
    }

    function send_statistic(){
        $filter = array('created_by'=>$this->user_login['iduser']);
        $email_list = $this->doc->get_email_list($filter)->result();

        $this->load->library('email');
        $this->email->clear();
        $this->email->initialize($this->email_setting);
        $this->email->set_newline("\r\n");
        $error_message = '';

        $this->console('>> Sending Email Noww...');
        $this->console($this->db->last_query());
        $this->console($email_list);
        foreach($email_list as $email){
            if($email->unemailed > 0){
                $html_text = $this->doc->get_html_statistic_template($email);

                $this->email->clear();
                $this->email->from('webmurahbagus.com',$email->created_by_name);
                $this->email->to($email->email);
                $this->email->subject('Notification Pending Document: '.date('d/m/Y'));
                $this->email->message($html_text);

                if(!$this->email->send()){
                    if($error_message != '')
                        $error_message .= ',';

                    $error_message .= $email->email;
                }else{
                    $email->iddocument = explode(',', $email->iddocument);
                    $email->iddocument = $this->base->implodeArrayToEachString($email->iddocument);
                    $this->doc->update(array('isemailed'=>'1'),"where iddocument in (".$email->iddocument.")");
                    $this->console($this->db->last_query());
                }
            }
        }

        if($error_message == ''){
            $result['result'] = 1;
            $result['error'] = '';
        }else{
            $result['result'] = 0;
            $result['error'] = 'Failed to send email to '.$error_message.'. Please try again.. ';
        }
        $this->base->generate_confirmation($result['result'], array(
            'message' => 'All Emails have been sent..',
            'redirect' => 'docc/statistic/',
                ), array(
            'message' => $result['error'],
            'redirect' => 'docc/statistic/',
        ));
    }

    function view($id,$from=0){
        $data['doc'] = $this->doc->read($id)->row();
        $data['doc']->status_code = $data['doc']->status;
        $data['doc']->status = $this->doc_status[$data['doc']->status];
        $data['imgpath'] = $this->doc_imgpath;
        $data['iditem'] = $id;

        // Set URL for back button
        $data['prev_page'] = '';
        if($from == 1) $data['prev_page'] = 'approved';
        else if($from == 2) $data['prev_page'] = 'pending';


        if($data['doc']->image == '') $data['doc']->image = 'no_image.jpg';

        $this->load_view_with_layout('Detail Document','doc/view',$data);
    }

    function change_status($id){
        if($this->input->post()){
            $status_selected = $this->input->post('status_selected');

            if($status_selected == -1 || $status_selected == 1)
                $input['status'] = $status_selected;
            else if($status_selected == 3)
                $input['isarchived'] = 1;

            $input['status_edit_date'] = date('Y-m-d H:m:s');

            $result = $this->doc->update($input,'where iddocument = '.$id);
            if($result['result'] > 0){
                if($status_selected == -1 || $status_selected == 1){
                    $doc = $this->doc->read($id)->row();
                    $doc->status = $this->doc_status[$doc->status];
                    $html_text = $this->doc->get_html_mail_notification($doc);
                    if(isset($doc->image) && ($doc->image == NULL || $doc->image == '')) $doc->image = 'no_image.jpg';

                    $this->load->library('email');
                    $this->email->clear();
                    $this->email->initialize($this->email_setting);
                    $this->email->set_newline("\r\n");

                    $this->email->from('webmurahbagus.com','Administrator');
                    $this->email->to($doc->created_by_email);
                    $this->email->subject('[NOTIF] Document ref ID: '.$iddocument.' has been '.$doc->status.' by '.$doc->created_for_name);
                    $this->email->message($html_text);
                    $this->email->attach($this->image_real_path.$doc->image);

                    $this->email->send();
                }
            }

            $this->base->generate_confirmation($result['result'], array(
                'message' => 'Updating data success',
                'redirect' => 'docc/view/'.$id,
                    ), array(
                'message' => $result['error'],
                'redirect' => 'docc/view/'.$id,
            ));
        }
    }

    function bulk_action(){
        // $this->bulk_action_list = array('-1'=>'MARK AS REJECTED','0'=>'SHARE VIA EMAIL','1'=>'MARK AS APPROVED', '2'=>'DELETE');

        if($this->input->post()){
            $bulk_selected = $this->input->post('bulk_action');

            $selected_id = $this->input->post('selected_row_id');

            if($bulk_selected == '-1' || $bulk_selected == '1'){
                $result = $this->doc->update(array('status'=>$bulk_selected),'where iddocument in ('.$selected_id.')');
            }else if($bulk_selected == '2'){
                $result = $this->doc->update(array('isdeleted'=>1), 'where iddocument in ('.$selected_id.')');
            }else if($bulk_selected == '3'){
                $result = $this->doc->update(array('isarchived'=>1), 'where iddocument in ('.$selected_id.')');
            }

            $this->base->generate_confirmation($result['result'], array(
                'message' => 'Updating data success',
                'redirect' => 'docc/',
                    ), array(
                'message' => $result['error'],
                'redirect' => 'docc/',
            ));
        }
    }

    function filter(){
        if($this->input->post()){
            $filter = array(
                'ref_id' => $this->input->post('ref_id'),
                'status' => trim($this->input->post('status')),
                'status_date' => $this->input->post('status_date'),
                'type' => $this->input->post('type'),
                'created_by' => $this->input->post('created_by'),
                'created_for' => $this->input->post('created_for'),
                'created_date' => $this->input->post('created_date'),
                'priority' => $this->input->post('priority'),
                'archived' => $this->input->post('archived'),
                'sorted_by' => $this->input->post('sorted_by'),
            );
            redirect(base_url().'index.php/docc/index'.$this->construct_url($filter,0));
        }
    }

    function add() {
        $data = $this->base->baseImport(array(
            'tinymce' => array('button1' => 'bold,italic,underline', 'button2' => '', 'button3' => ''),
            'datepicker',
        ));
        $data['doc_types'] = $this->doc_types;
        $data['created_for_list'] = $this->user->get_list_by_role('DIRECTOR');
        $data['priority_list'] = $this->priority_list;
        $data['imgpath'] = $this->doc_imgpath;

        $this->load_view_with_layout('Add New Document', 'doc/add', $data);
    }

    function addItem() {
        if ($this->input->post()) {
            $input = array(
                'description' => htmlentities($this->input->post('doc_desc'),ENT_QUOTES),
                'priority' => $this->input->post('priority'),
                'type' => $this->input->post('type'),
                'created_for' => $this->input->post('created_for'),
                'created_by' => $this->user_login['iduser'],
                'status' => 0,

            );

            if($_FILES['userfile']['name'] != null){
                $result = $this->base->do_upload($this->upload_setting);

                if($result['error'] == '' && $result['file'] != null){
                    $result = $this->base->manipulate_image('resize',$result['file'],$this->resize);
                }

                // Jika resize berhasil maka masukkan ke database
                if($result['result'] > 0){
                    $input['image'] = $result['file']['file_name'];
                }
            }

            $result = $this->doc->insert($input);

            if($result['result'] > 0){
                if($input['priority'] == 'URGENT'){
                    if($this->send_email($result['lastid']))
                        $this->doc->update(array('isemailed'=>'1'),'where iddocument = '.$result['lastid']);
                }
            }

            $this->base->generate_confirmation($result['result'], array(
                'message' => 'Inserting data success.. Reference ID : '.$result['lastid'],
                'redirect' => 'docc/index',
                    ), array(
                'message' => $result['error'],
                'redirect' => 'docc/index',
            ));
        }
        else
            redirect('docc/');
    }

    function delete($id) {
        $doc = $this->doc->read($id)->row();

        $this->base->deleteIfExists($this->image_real_path,$doc->image);

        $result = $this->doc->delete('where iddocument=' . $id);

        $this->base->generate_confirmation($result['result'], array(
            'message' => 'Data has been deleted',
            'redirect' => 'docc/',
                ), array(
            'message' => $result['error'],
            'redirect' => 'docc/',
        ));
    }

    function construct_url($filter,$page=null){
        $add_url = '/';
        $urls = array('ref_id'=>'ref_id/','status'=>'status/','status_date'=>'status_date/','type'=>'type/','created_by'=>'created_by/','created_date'=>'created_date/','created_for'=>'created_for/','priority'=>'priority/','sorted_by'=>'sorted_by/','archived'=>'archived/','page'=>'page/');
        if($page !== null) $filter += array('page' => '0');

        $keys = array_keys($urls);
        foreach ($keys as $key){
           if(array_key_exists($key, $filter) && $filter[$key] != 'null' && $filter[$key] != '') $add_url .= $urls[$key].$filter[$key].'/';
        }

        return $add_url;
    }

}

?>
