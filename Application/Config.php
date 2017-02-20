<?php

if (!defined('__ROOT')) {
    exit;
}

class Config {
    
    private static $file = 'application.php';
    private static $config_variables = array();
    
    private static $instance;
    
    public function __construct(){   
    }
    
    private static function getVariables(){
        self::$config_variables = require __CONFIG_DIR . DIRECTORY_SEPARATOR . self::$file;
	}
    
    public static function get( $variable ){
        self::getVariables();
        return self::$config_variables[ $variable ];
    }
    
    
}