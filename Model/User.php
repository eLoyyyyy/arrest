<?php

if (!defined('__ROOT')) {
    exit;
}

class User extends Model {
    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function login( $username, $password ) {
                
        if($this->_request_method() != "POST"){
            return;
        }
        
        //var_dump( $username );
        //var_dump( $password );
        
        $sql = "SELECT id, password, type FROM ". $this->_table ." WHERE username = :username LIMIT 1";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':username' => $username) )
                    ->getResults();
        
        return $_result[0];
        
        
    }
    
    public function activate( $id ){
        
        if($this->_request_method() != "PUT"){
            return;
        }
        
        $sql = "UPDATE ". $this->_table ." SET activate = '1' WHERE id = :id "; //AND (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_updated)) > 360";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':id' => $id ) )
                    ->rowCount();
        
        var_dump($_result);
        return $_result;
        
    }
    
    public function deactivate( $id ){
        
        if($this->_request_method() != "PUT"){
            return;
        }
        
        $sql = "UPDATE ". $this->_table ." SET activate = '0' WHERE id = :id "; //AND (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_updated)) > 360";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':id' => $id ) )
                    ->rowCount();
        
        var_dump($_result);
        return $_result;
        
    }
    
    public function profile( $id ){
        
        if($this->_request_method() != "GET"){
            return;
        }
        
        $sql = "SELECT first_name, last_name, email, prof_image, activate FROM ". $this->_table ." WHERE id = :id LIMIT 1";
        //var_dump( $sql );
        $_result = $this->_db->query( $sql )
                    ->execute( array( ':id' => $id) )
                    ->getResults();
        
        return $_result[0];
        
    }
}