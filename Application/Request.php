<?php

if (!defined('__ROOT')) {
    exit;
}

class Request {
    
    private $_fields = array();
    
    public function __construct() {
    }
    
    public function set( $key, $value ) {
        
        $this->_fields[ $key ] = $value;
        return $this;
    }
    
    public function get( $key ) {
        
        return ( isset($this->_fields[ $key ]) ? $this->_fields[ $key ] : null );
        
    }
    
}