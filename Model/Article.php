<?php

if (!defined('__ROOT')) {
    exit;
}

class Article extends Model {
    
    public $_fields = array();
    
    public $_table = null;
    
    public $_tableId = null;
    
    public $_where = array();
    
    public $_limit;
    
    public $_offset;
    
    public $_result;
    
    public function __construct(){
        parent::__construct();
        $this->_table = Config::get('schema')[strtolower(get_class($this))]['table'];
        $this->_tableId = Config::get('schema')[strtolower(get_class($this))]['id'];
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
        switch ( $_SERVER['REQUEST_METHOD'] ) {
            case "GET":
                return $this->get( $this->_fields, $this->_table, $this->_where, $this->_limit, $this->_offset );
                break;
            default:
                //$this->response('',406);
                break;
        }
            
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
    
    public function approve( $id ){
        
        if($this->_request_method() != "PUT"){
            return;
        }
        
        $sql = "UPDATE ". $this->_table ." SET status = '1' WHERE id = :id "; //AND (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_updated)) > 360";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':id' => $id ) )
                    ->rowCount();
        
        var_dump($_result);
        return $_result;
        
    }
    
    public function reject( $id ){
        
        if($this->_request_method() != "PUT"){
            return;
        }
        
        $sql = "UPDATE ". $this->_table ." SET status = '2' WHERE id = :id "; //AND (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_updated)) > 360";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':id' => $id ) )
                    ->rowCount();
        
        var_dump($_result);
        return $_result;
        
    }
    
}