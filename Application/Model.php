<?php

if (!defined('__ROOT')) {
    exit;
}

abstract class Model {
    
    public $_db;
    
    public $_fields = array();
    
    public $_table = null;
    
    public $_tableId = null;
    
    public $_where = array();
    
    public $_limit;
    
    public $_offset;
    
    public $_result;
    
    public function __construct() {
        $this->_db = Database::getInstance();
        $this->_table = Config::get('schema')[strtolower(get_class($this))]['table'];
        $this->_tableId = Config::get('schema')[strtolower(get_class($this))]['id'];
    }
    
    public function _request_method() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function fields( array $fields, $Id = null, $limit, $offset, $customWheres = array() ){
        
        $this->_fields = $fields;
        if ( !is_null( $Id ) ) {
            $this->_where[ $this->_tableId ] = $Id;
        }
        
        if ( !empty( $customWheres ) ) {
            $this->_where = $this->_where + $customWheres;
        }
        $this->_limit = $limit;
        $this->_offset = $offset;
    }
    
    public function process() {
        switch ( $this->_request_method() ) {
            case "GET":
                return $this->get( $this->_fields, $this->_table, $this->_where, $this->_limit, $this->_offset );
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"),$this->_body);
                return $this->put( $this->_body );
            default:
                //$this->response('',406);
                break;
        }
            
    }
    
    public function put( $input ){
        print_r($input);
        
    }
    
    public function get( array $select = array(), $table, array $where = array(), $limit, $offset ) {
        if ( empty($select) ) {
            $dlrb = '*';
        } else {
            $dlrb = implode(', ', $select);
        }
        
        
        $sql  = 'SELECT ' . $dlrb . ' '; 
        $sql .= 'FROM `' . $table . '` ';
        
        $where_params = array();
        
        if ( !empty( $where ) ) {
            
            
            $sql .= 'WHERE ';
            
            $where_compiled = array_map(function($value, $key) {
                return $key.' = :'.$key.' ';
            }, array_values($where), array_keys($where));
            
            //$where_compiled = implode( ' ', $where_compiled );
            $sep = ( count($where) <= 2 ) ? ' AND ' : ' ';
            $where_compiled = implode( $sep, $where_compiled );
            $sql .= $where_compiled;
            
            foreach($where as $key => $value) {
                $where_params[ ':'.$key ] = $value;
            }
            
        }
        
        $sql .= 'LIMIT ' . $limit . ' OFFSET ' . $offset;
        $_result = $this->_db->query( $sql )->execute( $where_params )->getResults();
        
        
        return $_result;
    }
}