<?php

if (!defined('__ROOT')) {
    exit;
}

class Result {
    
    private $_status = 200;
    
    private $_count = 0;
    
    private $_limit = 0;
    
    private $_offset = 0;
    
    private $_results = array();
    
    public function __construct($status, $count, $limit, $offset, array $results) {
        $this->_status = $status;
        $this->_count = $count;
        $this->_limit = $limit;
        $this->_offset = $offset;
        $this->_results = $results;
    }
    
    public function render(){
        return array(
            "metadata" => array(
                "status" => $this->_status,
                "resultset" => array(
                    "count" => $this->_count,
                    "limit" => $this->_limit,
                    "offset" => $this->_offset,
                )
            ),
            "results" => $this->_results
        );
    }
    
}