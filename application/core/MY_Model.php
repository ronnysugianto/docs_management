<?php

/**
 * Extended CI_Model with custom functions
 */
class MY_Model extends CI_Model {

    function __construct() {
        parent:: __construct();
        $this->load->helper('url');
        $this->load->database();
    }

    /**
     * Basic query for insert into database
     * @param string Database table name
     * @param array $arryInput Array with key as column name and value as column value in database
     * @return array retur array('query','result','lastid','error');
     */
    protected function insertToDatabase($tableName = "", $arryInput = array()) {
        $response = array('result' => 0, 'error' => '');

        if ($tableName != "" && count($arryInput) > 0) {

            $response['query'] = $this->db->insert($tableName, $arryInput);
            $response['result'] = $this->db->affected_rows();
            $response['lastid'] = $this->db->insert_id();

            if ($response['result'] > 0)
                $response['error'] = '';
            else
                $response['error'] = 'Inserting failed.. No data has been inserted';
        }
        return $response;
    }

    /**
     * Basic query for update in database
     * @param string $tableName Database table name
     * @param array $arryInput Array with key as column name and value as column value in database
     * @param string $where Where statement (ex: 'where id = ... ')
     * @return array Array('query','result','error');
     */
    protected function updateToDatabase($tableName = "", $arryInput = array(), $where = '') {
        $response = array('result' => 0, 'error' => '');

        if ($tableName != "" && count($arryInput) > 0) {

            $qText = "update " . $tableName . " set ";

            $keys = array_keys($arryInput);
            for ($i = 0; $i < count($keys); $i++) {
                $value = $arryInput[$keys[$i]];
                
                if ($i > 0) $qText .= ",";
                
                if($value == null || $value == 'null') $qText .= $keys[$i] .'=null'; 
                else $qText .= $keys[$i] . " = '" .$value. "'";
            }

            if ($where != "")
                $qText .= " " . $where;

            $response['query'] = $this->db->query($qText);
            $response['result'] = $this->db->affected_rows();

            if ($response['result'] > 0)
                $response['error'] = '';
            else
                $response['error'] = 'Updating failed.. No data has been updated';
        }
        return $response;
    }

    /**
     * Basic query for deleting in database
     * @param string $tableName Database table name
     * @param string $where Where statement ('where id=...');
     * @return array Array('query','result','error')
     */
    protected function deleteFromDatabase($tableName = "", $where = "") {
        $response = array('result' => 0, 'error' => '');

        if ($tableName != "") {
            $qText = "delete from " . $tableName . ' ' . $where;

            $response['query'] = $this->db->query($qText);
            $response['result'] = $this->db->affected_rows();

            if ($response['result'] > 0)
                $response['error'] = '';
            else
                $response['error'] = 'Deleting failed.. No data has been deleted';
        }

        return $response;
    }
    
    /**
     * Run custom query text with array('result','error') as response
     * @param type $query
     */

    protected function runQuery($query) {
        $response = array('result' => 0, 'error' => '');

        $response['query'] = $this->db->query($query);
        $response['result'] = $this->db->affected_rows();

        if ($response['result'] > 0)
            $response['error'] = '';
        else
            $response['error'] = 'There is an error.. Query did not execute successfully';
    }

}
