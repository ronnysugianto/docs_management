<?php
/**
 * Description of userc
 *
 * @author ronnysugianto
 */
class userc extends MY_Controller{
    var $user;
    var $tablegenerator;
    var $user_status;
    var $user_login;

    function __construct() {
        parent:: __construct();
        $this->load->library('myme_library/class/TableGenerator');
        $this->user_login = $this->session->userdata('userlogin');
        $this->load->model('user_model');
        $this->tablegenerator = new TableGenerator();
        $this->user = new user_model();
        $this->user_status = array('1'=>'ACTIVE','0'=>'INACTIVE');
    }
    
    function index($start=0,$limit=10){
        $userlogin = $this->session->userdata('userlogin');
        $ability = $userlogin['ability'];
        
        if($ability['add_user'] == false) $data['can_add'] = false;
        else $data['can_add'] = true;
        
        $custom_function = array(
        'modify_row_data' => function($row, $key) {
            if ($key == 'status'){
                if($row->$key == '0') $row->$key = 'INACTIVE';
                if($row->$key == '1') $row->$key = 'ACTIVE';
            }
            return '';
        });
        
        $query = $this->user->readAll($start,$limit);
        $data['usertable'] = $this->tablegenerator->generateTable(array(
            'type' => 'ITEM',
            'idAndName' => 'usertable',
            'no_start'=>$start+1,
            'result' => $query->result(),
            'iditem' => 'iduser',
            'header' => array(array('data'=>'Username','width'=>'40%'),array('data'=>'Role','filter'=>'false','width'=>'30%'), array('data'=>'Status','filter'=>'false','width'=>'20%')),
            'itemlist' => array('username'=>'text','role'=>'text','status'=>'text',array('data'=>'Password','link'=>base_url().'index.php/userc/pass/','use_iditem'=>true,'action_group'=>true,'use_btn'=>false)),
            'directory' => '',
            'controller' => 'userc',
            'custom_function' => $custom_function,
            'useedit' => true,
            'usedelete' => true,
            'action_group' => true,
            'moreAttr' => 'width=90%',
            'pagination' => array('base_url'=>base_url('index.php/userc/index/'), 'total_rows'=>$this->user->row_count(),'per_page'=>$limit,'num_links'=>10),
        ));

        $this->load_view_with_layout('Admin User','user/index', $data);
    }

    function profile($id){
        $data['user'] = $this->user->read($id)->row();
        $data['idedit'] = $id;

        $this->load_view_with_layout('My Profile','user/profile',$data);
     }

    function edit($id){
        $data['user'] = $this->user->read($id)->row();
        $data['idedit'] = $id;
        $data['user_roles'] = $this->user_roles;
        $data['user_status'] = $this->user_status;

        $this->load_view_with_layout('Edit User','user/edit',$data);
    }

    function add(){
        $data['user_roles'] = $this->user_roles;
        $this->load_view_with_layout('Add New User','user/add',$data);
    }
    
    function pass($id){
        $data['idedit'] = $id;
        $this->load_view_with_layout('Change Password','user/pass',$data);
    }

    function addItem(){
        if($this->input->post()){
            $input = array(
                'username' => htmlentities($this->input->post('username'),ENT_QUOTES),
                'password' => $this->base->ecnryptThis($this->input->post('password')),
                'role' => $this->input->post('user_role'),
                'status' => '1',
                'isdeleted' => '0',
                'created_date' => date('Y-m-d'),
                'created_by' => $this->user_login['iduser'],
            );

            $result = $this->user->insert($input);

            $this->base->generate_confirmation($result['result'],array(
                'message' => 'Inserting data success',
                'redirect' => 'userc/index',
            ),array(
                'message' => $result['error'],
                'redirect' => 'userc/index',
            ));

        }else redirect('userc/');
    }

    function editItem($id){
        if($this->input->post()){
            $input = array(
                'role' => $this->input->post('user_role'),
                'status' => $this->input->post('user_status'),
            );
            $result = $this->user->update($input,'where iduser='.$id);

            $this->base->generate_confirmation($result['result'],array(
               'message' => 'Updating data success',
               'redirect' => 'userc/index',
            ),array(
                'message' => $result['error'],
                'redirect' => 'userc/index',
            ));

        }else redirect('userc/');
    }
    
    function changePass($id){

        if($this->input->post()){
            $user = $this->user->read($id)->row();
            
            $redirect = 'userc/profile';
            if(!$this->base->check($this->input->post('old_pass'), $user->password)){
                $redirect = 'userc/pass/'.$id;
                $result = array('result' => 0, 'error' => 'Old Password did not match');
            }else{
                $input = array(
                    'password' => $this->base->ecnryptThis($this->input->post('new_pass')),
                );
                $result = $this->user->update($input, 'where iduser='.$id);
            }
            $this->base->generate_confirmation($result['result'],array(
                'message' => 'Updating data success',
                'redirect' => $redirect,
             ),array(
                 'message' => $result['error'],
                 'redirect' => $redirect,
             ));
        }
    }

    function change_pass_from_profile($id){
        if($this->input->post()){
            $user = $this->user->read($id)->row();
            
            $redirect = 'userc/profile/'.$id;
            $input = array(
                'password' => $this->base->ecnryptThis($this->input->post('new_pass')),
            );
            $result = $this->user->update($input, 'where iduser='.$id);
            
            $this->base->generate_confirmation($result['result'],array(
                'message' => 'Updating data success',
                'redirect' => $redirect,
             ),array(
                 'message' => $result['error'],
                 'redirect' => $redirect,
             ));
        }
    }
    
    function delete($id){
        $result = $this->user->delete('where iduser='.$id);

        $this->base->generate_confirmation($result['result'],array(
            'message' => 'Data has been deleted',
            'redirect' => 'userc/',
        ),array(
            'message' => $result['error'],
            'redirect' => 'userc/',
        ));
    }
}

?>
