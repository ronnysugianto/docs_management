<?php
include_once('MY_Class.php');
/**
 * Class for generate Table List with many variant type (ITEM, GALLERY, VIDEO GALLERY)
 */
class TableGenerator extends MY_Class{

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper('html');
        $this->ci->load->library('table');
        $this->ci->load->library('firephp');
    }

    /**
     * Automatic generate HTML Table from SQL Query with customization setting
     * @param $tableSetting Setting for generating HTML Table (in array).
     * <br/><br/>
     * Setting list key and explanation :
     * <ul>
     * <li>
     * <b>Basic setting keys : </b>
     *  <ul>
     *      <li>'type' => String : HTML Table type that will be generated ('ITEM','GALLERY','VIDEO GALLERY') </li>
     *      <li>'idAndName' => String : HTML Table id & name value</li>
     *      <li>'moreAttr' => String : More Attribute that will be added to Table Tag </li>
     *      <li>'iditem' => String : Query column name which its value that will be use for edit and delete action (usually is column that use as primary key) </li>
     *      <li>'result' => SQL query result : Query executed result from database</li>
     *      <li>'directory' => String : File directory path. Usually use for generated itemlist with 'img' type</li>
     *      <li>'controller' => String : Class controller name that will be use for this Table trigger action (edit, delete)</li>
     *      <li>'useedit' => bool : Boolean true/false for enable/disable edit action (controller_name/editItem/iditem_value). Default = false</li>
     *      <li>'usedelete' => bool : Boolean true/false for enable/disable delete action (controller_name/delete/iditem_value). Default = false</li>
     *      <li>'addition_param_edit' => String : Addition string that will be added at the end of edit url (controller_name/editItem/iditem_value/addition_param_edit)</li>
     *      <li>'addition_param_delete' => String : Addition string that will be added at the end of delete url (controller_name/delete/iditem_value/addition_param_delete)</li>
     *
     *  </ul>
     * </li>
     * <li>
     * <b>Setting keys for HTML Table type = 'ITEM'</b>
     *  <ul>
     *      <li>'no_start' => int : Start number for column header 'No' that will be auto_increment (usually use for pagination) </li>
     *      <li>'header' => Array of String / Array 2D (for customization header tag): List of strings that will be used for Table Header label (sequentially).
     *      <br/><br/>
     *      <i>Accept 2 format :</i>
     *      <ol>
     *          <li>Array of String, ex : array('Name','Title','Address',...)</li>
     *          <li>Array 2D : ex : array(array('data'=>'Name', 'width'=>'30%', ...)</li>
     *      </ol>
     *      <li>'itemlist' => Array of Object : List of Object that will be used for Table Row data. Array keys : select query column name, Array values : select query column value display type..
     *      <br/><br/>
     *      <i>Format accepted for Array Values : </i>
     *      <ol>
     *          <li>'text' : value will display as string (real value)</li>
     *          <li>'long_text' : value will display as string, but after filtering with html_entities for removing HTML tag. Value will be excerpt with limited 200 characters. Usually use for description.. </li>
     *          <li>'img' : value will be displayed in image tag with src = value from keys 'directory'+ (Query column value from column with name 'img' key's value) </li>
     *          <li>'date' : value will be displayed after formating with ('Y-m-d')</li>
     *      </ol>
     *      </li>
     *      <li>'use_checkbox' => bool : Boolean true/false for enable/disable checkbox on each table row. Default = false </li>
     *      <li>'action_group' => bool : Grouping all action on each row to dropdown box. Default = false </li>
     *      <li>'pagination' => Array : Pagination setting base on CI Pagination Class </li>
     *  </ul>
     * </li>
     *
     * <li>
     * <b>Setting keys for HTML Table type = 'GALLERY' </b>
     *  <ul>
     *      <li>'thumb_width' => Integer : Image's width size for each displayed image</li>
     *      <li>'thumb_height' => Integer : Image's height size for each displayed image</li>
     *      <li>'rowmax' => Integer : Maximum image for each row. Default = 10</li>
     *      <li>'filename' => String : Query column with name 'filename' key value that will be append after 'directory' key's value as img src</li>
     *  </ul>
     * </li>
     *
     * <li>
     * <b>Setting keys for HTML Table type = 'VIDEO GALLERY' </b>
     *  <ul>
     *      <li>'thumb_width' => Integer : Video box's width size for each displayed preview</li>
     *      <li>'thumb_height' => Integer : Video box's height size for each displayed preview</li>
     *      <li>'rowmax' => Integer : Maximum video box for each row. Default = 10</li>
     *      <li>'filename' => String : Query column with name 'filename' key value that will be append after 'directory' key's value as video src</li>
     *      <li>'embed_type' => String : Video embbed type that will use as display format of Video Preview
     *      <br/><br/>
     *      <i>Accept 2 formats : </i>
     *      <ol>
     *          <li>'old' : Use Youtube old style code for embedding</li>
     *          <li>'iframe' : Use Youtube iframe style code for embedding</li>
     *      </ol>
     *      </li>
     *      <li>'use_code' => bool : Query column with name 'filename' key value is a Youtube Video Code. Default = Use local directory + filename</li>
     *  </ul>
     * </li>
     *
     * </ul>
     * @return string HTML Table
     */
    public function generateTable($tableSetting){
        if(isset($tableSetting['type'])){
            if($tableSetting['type'] == 'ITEM')
                $settingKeys = array('type','idAndName','moreAttr','no_start','result','iditem','header','itemlist','directory','controller','useedit','usedelete','addition_param_edit','addition_param_delete','usecheckbox','action_group','usegallery','pagination','custom_function');
            else if($tableSetting['type'] == 'GALLERY')
                $settingKeys = array('type','idAndName','title','thumb_width','thumb_height','rowmax','result','iditem','filename','directory','controller','usedelete','addition_param_edit','addition_param_delete','custom_function');
            else if($tableSetting['type'] == 'VIDEO GALLERY')
                $settingKeys = array('type','idAndName','title','thumb_width','thumb_height','rowmax','result','iditem','filename','directory','controller','usedelete','addition_param_edit','addition_param_delete','embed_type','use_code','custom_function');

            else return '';
        }else return '';

        $tableSetting = $this->validateSetting($tableSetting, $settingKeys);
        $response = '';

        if($tableSetting['custom_function'] != '') $this->customFunction = $tableSetting['custom_function'];

        if($tableSetting['type'] == 'ITEM') $response .= $this->itemTable($tableSetting);
        if($tableSetting['type'] == 'GALLERY') $response .= $this->galleryTable($tableSetting,'IMAGE');
        if($tableSetting['type'] == 'VIDEO GALLERY') $response .= $this->galleryTable($tableSetting,'VIDEO');

        return $response;
    }

    /**
     * Generate Basic Table style
     * @param $tableSetting Setting value to generate Table
     * @return string Return generated table HTML as String
     */
    private function itemTable($tableSetting){
        $this->ci->table->set_template($this->getTableTemplate($tableSetting));
        $_isgroupactive = $_use_action_header = FALSE;
        if($tableSetting['action_group'] !== '' && $tableSetting['action_group'] == true){
            $_isgroupactive = TRUE;
            $_use_action_header = TRUE;
            array_push($tableSetting['header'],array('data'=>'Action'));
        }else{
            if($tableSetting['useedit'] == true)
                array_push($tableSetting['header'],array('data'=>'Edit','width'=>'80px'));
            if($tableSetting['usedelete'] == true)
                array_push($tableSetting['header'],array('data'=>'Delete','width'=>'100px'));
        }


        array_unshift($tableSetting['header'],array('data'=>'#','width'=>'5%'));

        if($tableSetting['usecheckbox'] == true) array_unshift($tableSetting['header'],array('data'=>'<input type="checkbox" id="'.$tableSetting['idAndName'].'_bulkcheckbox"/>'));

        if($tableSetting['itemlist'] != ""){
            $rowkeys = array_keys($tableSetting['itemlist']);
            $tableSetting['no_start'] == '' ? $_no = 1 : $_no = $tableSetting['no_start'];
            $custom_link = '';

            foreach($tableSetting['result'] as $row){
                $arryrows = array();
                $custom_link = '';
                foreach($rowkeys as $key){

                    if(is_numeric($key)){

                        if(!key_exists('action_group',$tableSetting['itemlist'][$key]))
                                $tableSetting['itemlist'][$key]['action_group'] = '';

                        if($tableSetting['itemlist'][$key]['action_group'] === '' || $tableSetting['itemlist'][$key]['action_group'] === false){
                            $_custom_data = $this->getCustomData($tableSetting['itemlist'][$key],$row->$tableSetting['iditem'],$tableSetting['directory']);
                            array_push($arryrows,$_custom_data);
                        }if($tableSetting['itemlist'][$key]['action_group'] === true ){
                            if(!$_use_action_header){
                                array_push($tableSetting['header'],array('data'=>'Action'));
                                $_use_action_header = TRUE;
                                $_isgroupactive = TRUE;
                            }
                            $custom_link .= '<li>'.$this->getCustomData($tableSetting['itemlist'][$key],$row->$tableSetting['iditem'],$tableSetting['directory']).'</li>';
                        }
                    }
                    else{
                        $this->run_custom_function('modify_row_data',array($row,$key));
                        array_push($arryrows,$this->getTableData($tableSetting['itemlist'][$key], $row->$key,$tableSetting['directory']));
                    }
                }

                array_unshift($arryrows,$_no++);
                if($_isgroupactive){

                    $edit_link = '';
                    $del_link = '';

                    if($tableSetting['useedit']) $edit_link = '<li>'.anchor($tableSetting['controller'].'/edit/'.$row->$tableSetting['iditem'].'/'.$tableSetting['addition_param_edit'],'<i class="icon-edit"></i>Edit').'</li>';

                    if($tableSetting['usedelete']) $del_link = '<li><a href=\'javascript:doDeleteAction("'.$row->$tableSetting['iditem'].'","'.$tableSetting['addition_param_delete'].'")\'><i class="icon-remove"></i>Delete</a></li>';

                    array_push($arryrows,'
                    <div style="text-align:center">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align:left">
                        '.$custom_link.''.$edit_link.''.$del_link.'
                        </ul>
                    </div>
                    </div>');
                }else{

                    if($tableSetting['useedit'] == true)
                        array_push($arryrows,
                            anchor($tableSetting['controller'].'/edit/'.$row->$tableSetting['iditem'].'/'.$tableSetting['addition_param_edit'],'<i class="icon-edit"></i>Edit','class="btn btn-medium"'));
                    if($tableSetting['usedelete'] == true)
                        array_push($arryrows,
                            '<a class="btn btn-medium" href=\'javascript:doDeleteAction("'.$row->$tableSetting['iditem'].'","'.$tableSetting['addition_param_delete'].'")\'><i class="icon-remove"></i>Delete</a>');
                }
                if($tableSetting['usecheckbox'] != "" || $tableSetting['usecheckbox'] == true){
                    if(is_array($tableSetting['usecheckbox'])){
                        $_checkboxarry = $tableSetting['usecheckbox'];
                        $_iditem = $_checkboxarry['iduse'];
                    }
                    else $_iditem = $tableSetting['iditem'];

                    array_unshift($arryrows,form_checkbox(array('name'=>$tableSetting["idAndName"].'_check[]','value'=>$row->$_iditem)));
                }

                $this->ci->table->add_row($arryrows);
            }
        }

        $_custom_additional_code = '';

        //generate pagination
        if($tableSetting['pagination'] != '' && is_array($tableSetting['pagination'])){
            $_custom_additional_code .= $this->generatePagination($tableSetting['pagination']);
        }

        //generate javascript function needed base on setting
        if($tableSetting['usedelete'] == true){
            $url = site_url().'/'.$tableSetting['controller'].'/delete/';
            $_custom_additional_code .= <<<EOT
                <script type="text/javascript">
                    function doDeleteAction(iddel,more_param){
                        var _del = confirm('Are you sure want to delete this data ?');
                        if(_del) location.href = '$url'+iddel+'/'+more_param;
                    }
                </script>
EOT;
        }
        if($tableSetting['usecheckbox'] == true){
            $_custom_additional_code .= <<<EOT
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#$tableSetting[idAndName]_bulkcheckbox').click(function(){
                            checkAllCheckboxes('$tableSetting[idAndName]_check[]',$('#$tableSetting[idAndName]_bulkcheckbox').is(':checked'));
                        });
                    });
                </script>
EOT;
        }

//         if($tableSetting['usecheckbox'] == true){
//             $_custom_additional_code .= <<<EOT
//                 <script type="text/javascript">
//                     $(document).ready(function(){
//                         $( "#$tableSetting[idAndName]_checkAll").change(function(){
//                             checkAll('$tableSetting[idAndName]_check[]','$tableSetting[idAndName]_checkAll');
//                          });
//                      });

//                      function checkAll(name,btn){
//                         var checked = document.getElementById(btn).checked;
//                         checkAllCheckboxes(name,checked);
//                      }
//                 </script>
// EOT;

//         }

        $this->ci->table->set_heading($tableSetting['header']);
        $_response = $this->ci->table->generate().$_custom_additional_code;
        if(count($tableSetting['result']) == 0) $_response .= '<h4 style="padding-left:5px;">No Result Found</h4>';

        return $_response;
    }

    /**
     * Generate Gallery Table Style
     * @param $tableSetting Setting value to generate Table
     * @return string Return generated table HTML as String
     */
    private function galleryTable($tableSetting,$type='IMAGE'){

        $localResponse = '<ul class="thumb_gallery">';

        $result = $tableSetting['result'];
        $jumrow = count($result);

        $_thmbwidth = $tableSetting['thumb_width'];
        $_thmbheight = $tableSetting['thumb_height'];
        $_rowmax = $tableSetting['rowmax'];

        if($_thmbwidth == '') $_thmbwidth = '60px';
        if($_thmbheight == '') $_thmbheight = '70px';
        if($_rowmax == '') $_rowmax = 10;

        for ($i = 1; $i <= $jumrow; $i++) {
            $rows = $result[$i-1];

            $localResponse .= '<li>';

            if($type == 'IMAGE')
                $localResponse .= '<img class="img-polaroid" width="'.$_thmbwidth.'" height="'.$_thmbheight.'" src="'.$tableSetting['directory'].$rows->$tableSetting['filename'].'"/>';
            else if ($type == 'VIDEO'){
                $url = $tableSetting['directory'].$rows->$tableSetting['filename'];

                if($tableSetting['embed_type'] == 'old'){
                    if($tableSetting['use_code'] != '' && $tableSetting['use_code'] == true) $url = 'http://www.youtube.com/v/'.$rows->$tableSetting['filename'];

                    $localResponse .= '<object width="'.$_thmbwidth.'" height="'.$_thmbheight.'"><param name="movie" value="'.$url.'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$url.'" type="application/x-shockwave-flash" width="'.$_thmbwidth.'" height="'.$_thmbheight.'" allowscriptaccess="always" allowfullscreen="true"></embed></object>';

                }else if($tableSetting['embed_type'] == 'iframe'){
                    if($tableSetting['use_code'] != '' && $tableSetting['use_code'] == true) $url = 'http://www.youtube.com/embed/'.$rows->$tableSetting['filename'];
                    $localResponse .= '<iframe width="'.$_thmbwidth.'" height="'.$_thmbheight.'" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
                }
            }

            if($tableSetting['title'] != '')
                $localResponse .= '<br/><span>'.$rows->$tableSetting['title'].'</span>';
            $localResponse .= '<p><a class="btn btn-danger btn-mini" href=\'javascript:doDeleteAction("'.$rows->$tableSetting['iditem'].'","'.$tableSetting['addition_param_delete'].'")\'><i class="icon-search icon-remove"></i>Delete</a></p>';
            $localResponse .= '</li>';
        }

        $_custom_additional_code = '';
        if($tableSetting['usedelete'] == true){
            $url = site_url().'/'.$tableSetting['controller'].'/delete/';
            $_custom_additional_code .= <<<EOT
                <script type="text/javascript">
                    function doDeleteAction(iddel,more_param){
                        var _del = confirm('Are you sure want to delete this data ?');
                        if(_del) location.href = '$url'+iddel+'/'+more_param;
                    }
                </script>
EOT;

        }

        $localResponse .= '</ul>';
        $localResponse .= $_custom_additional_code;

        return $localResponse;
    }

    /**
     * Create custom row data in table (ex : create custom link)
     * @param $setting Custom row setting (
     * @param $iditem Iditem value that will be include in link
     * @param $imgDir File directory path
     * @return string
     */
    private function getCustomData($setting, $iditem, $imgDir){

        $settingKeys = array('type','link','data','addition_url','moreattr','use_iditem','use_btn','icon_btn');
        $setting = $this->validateSetting($setting,$settingKeys);

        $icon = 'icon-edit';
        if($setting['icon_btn'] !== '') $icon = $setting['icon_btn'];
        $btn = "class='btn btn-medium'";
        if($setting['use_btn'] === false) $btn = '';

        $localResponse = '';
        $localResponse .= $setting['data'];

        if($setting['use_iditem'] == '') $iditem = '';

        $type = 'link';
        if(isset($setting['type']) && $setting['type'] != '') $type = $setting['type'];

        if($type == 'link')
           $localResponse="<a ".$btn." href='".$setting['link'].$iditem.$setting['addition_url']."' ".$setting['moreattr']."><i class='".$icon."'></i>".$setting['data']."</a>";

        return $localResponse;
    }

    /**
     * Generate table row data
     * @param $type Data type (img/text/date,etc..)
     * @param $data Raw data
     * @param $imgDir File directory path
     * @return string
     */
    private function getTableData($type,$data,$imgDir){
        $localResponse = '';

        if($type == 'img') $localResponse = '<img width="60" height="60" src="'.$imgDir.$data.'" />';
        if($type == 'text' || $type == 'check' || $type == 'box') $localResponse = $data;
        if($type == 'date') $localResponse = date('Y-m-d',strtotime($data));

        if($type == 'longtext_with_excerpt'){
            $data = html_entity_decode($data,ENT_QUOTES);
            $localResponse = $this->get_excerpt($data,0,200,TRUE);
        }

        return $localResponse;
    }

    /**
     * Table template for generated HTML Table.. Use CI Table Class & Twitter Bootstrap style
     * @param $tableSetting Table setting to use as template value
     * @return array
     */
    private function getTableTemplate($tableSetting){
        $template = array();
        if($tableSetting['type'] == 'ITEM'){
            $template = array(
                'table_open'   => '<table id="'.$tableSetting['idAndName'].'" name="'.$tableSetting['idAndName'].'" class="table table-striped table-hover table-condensed table-bordered" '.$tableSetting['moreAttr'].'>',

                'thead_open'   => '<thead>',
                'thead_close'   => '</thead>',

                'heading_row_start'  => '<tr>',
                'heading_row_end'  => '</tr>',
                'heading_cell_start' => '<th style="text-align: center">',
                'heading_cell_end'  => '</th>',

                'tbody_open'   => '<tbody>',
                'tbody_close'   => '</tbody>',

                'row_start'    => '<tr>',
                'row_end'    => '</tr>',
                'cell_start'   => '<td>',
                'cell_end'    => '</td>',

                'row_alt_start'   => '<tr class="alt">',
                'row_alt_end'   => '</tr>',
                'cell_alt_start'  => '<td>',
                'cell_alt_end'   => '</td>',

                'table_close'   => '</table>'
            );
        }

        return $template;
    }

    /**
     * Generate HTML Table pagination
     * @param $pagSetting Pagination setting
     * @return mixed
     */
    private function generatePagination($pagSetting){
        $this->ci->load->library('pagination');

        $pagSetting['full_tag_open'] = '<div class="pagination"><ul>';
        $pagSetting['full_tag_close'] = '</ul></div><!--pagination-->';

        $pagSetting['first_link'] = '&laquo; First';
        $pagSetting['first_tag_open'] = '<li class="prev page">';
        $pagSetting['first_tag_close'] = '</li>';

        $pagSetting['last_link'] = 'Last &raquo;';
        $pagSetting['last_tag_open'] = '<li class="next page">';
        $pagSetting['last_tag_close'] = '</li>';

        $pagSetting['next_link'] = 'Next &rarr;';
        $pagSetting['next_tag_open'] = '<li class="next page">';
        $pagSetting['next_tag_close'] = '</li>';

        $pagSetting['prev_link'] = '&larr; Prev';
        $pagSetting['prev_tag_open'] = '<li class="prev page">';
        $pagSetting['prev_tag_close'] = '</li>';

        $pagSetting['cur_tag_open'] = '<li class="active"><a href="">';
        $pagSetting['cur_tag_close'] = '</a></li>';

        $pagSetting['num_tag_open'] = '<li class="page">';
        $pagSetting['num_tag_close'] = '</li>';

        $this->ci->pagination->initialize($pagSetting);

        $_response = $this->ci->pagination->create_links();
        return $_response;
    }

    /**
     * Get excerpt from string (same function in base class)
     *
     * @param String $str String to get an excerpt from
     * @param Integer $startPos Position int string to start excerpt from
     * @param Integer $maxLength Maximum length the excerpt may be
     * @return String excerpt
     */
    private function get_excerpt($str, $startPos=0, $maxLength=100, $withHTML=FALSE, $allowable_tags='') {
        $str = trim($str);

        if($withHTML) $str = strip_tags($str,$allowable_tags);

        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }
}