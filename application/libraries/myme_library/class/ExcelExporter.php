<?php
include_once('MY_Class.php');
/**
 * Class for generating Excel file 
 */
class ExcelExporter extends MY_Class{
    
    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper('html');
        $this->ci->load->library('table');
        $this->ci->load->library('firephp');
    }
    
    /**
     * Generate Excel file 
     * @param type $filename Excel filename
     * @param type $settings Setting for configuring excel exporter
     * $settings is an array with key value : 
     * 1. query -> array with query resulted from run sql query.. (key value will be the title for each query)
     * 2. custom_function -> injected custom_function
     */
    public function generate_excel($filename, $settings){
        
        $static_keys = array('query','custom_function');
        $settings = $this->validateSetting($settings, $static_keys);
        
        if($settings['custom_function'] !== '') $this->customFunction = $settings['custom_function'];
        
        if($settings['query'] != '' && is_array($settings['query'])){
            
            $keys = array_keys($settings['query']);

            $hList = $rList = $title = array();
            $hCount = 0;

            foreach($keys as $key){
                $headers_ = $rows_ = array();

                //headers
                $col_index = 0;
                foreach($settings['query'][$key]->list_fields() as $field){ 
                    $headers_[$col_index++] = ucwords($field); 
                }
                
                // rows    
                $row_index = $col_index = 0;
                foreach ($settings['query'][$key]->result_array() as $row){
                    $keys2 = array_keys($row);
                    $col_index = 0;
                    foreach ($keys2 as $key2){
                        $row[$key2] = $this->run_custom_function('modify_row_data', array($row,$key2));
                        
                        $rows_[$row_index][$col_index++] = strip_tags(html_entity_decode($row[$key2],ENT_QUOTES));
                    }
                    $row_index++;
                }

                $title[$hCount] = $key;
                $hList[$hCount] = $headers_;
                $rList[$hCount++] = $rows_;
            }
            

            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");

            for($i=0;$i<sizeof($hList);$i++){
                print "\n\n";
                print $title[$i]."\n";
                //print header
                for($h=0;$h<sizeof($hList[$i]);$h++) print $hList[$i][$h]."\t";

                print "\n";
                //print rows

                $row = $rList[$i];
                for($rr=0;$rr<sizeof($row);$rr++){
                    for($rr1=0;$rr1<sizeof($row[$rr]);$rr1++){ print $row[$rr][$rr1]."\t"; }
                    print "\n";
                }

            }
        }
    }
}
?>