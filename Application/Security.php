<?php

class Security {
    
    // blowfish
	private static $algo = '$2a';
	
	// cost parameter
	private static $cost = '$10';
	
	// mainly for internal use
	public static function unique_salt() {
		return substr(sha1(mt_rand()),0,22);
	}
	
	// this will be used to generate a hash
	public static function hash($password) {
		return crypt($password,
                            self::$algo .
                            self::$cost .
                            '$' . self::unique_salt());
	}
	
	public static function check_password($hash, $password){
		$full_salt = substr($hash, 0, 29);
		
		$new_hash = crypt($password, $full_salt);
		
		return ($hash == $new_hash);
	}
    
    public static function checkHeader(){
        
        if ( isset( $_SERVER['PHP_AUTH_USER'] ) && isset( $_SERVER['PHP_AUTH_PW'] ) ){ 
            $auth_user = $_SERVER['PHP_AUTH_USER'];
            $auth_pw = $_SERVER['PHP_AUTH_PW'];
            
            $_user = Config::get('app_user');
            $_pw = Config::get('app_pw');
            
            self::signature();
            
            if ( $auth_user == $_user && $auth_pw == $_pw  ) {
                return true;
            } else {
                return false;
            }
            
        }
        
        
    }
    
    private static function signature() {
         
        print_r( $_GET );
        
    }
    
}