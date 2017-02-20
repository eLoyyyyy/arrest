<?php

class Router {
    
    private static $_routes;
    
    private static $instance;
    
    private function __construct() {
        self::$_routes = array();
    }
    
    public static function getInstance(){
        if (!self::$instance){
            self::$instance = new Router();
        }
        return self::$instance;
    }
    
    public static function route( $url , $route , callable $function ){
        
        self::$_routes[] = $route;
        
        // $route i.e. /user/:id/article/:artid
        
        $route = rtrim( $route , '/');
        $url = '/' . $url;
        
        if ( strcmp ($route, $url) == 0 ) {
            //echo "Match sila..";
            $function( array() ); 
            return;
        }
        
        $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route)) . "$@D";
        $matches = array();
        $placeholders = array();
        $match = preg_match($pattern, $url, $matches);
        $ph = preg_match($pattern, str_replace(':', '', $route), $placeholders);


        if ( $match ) {
            
            array_shift($matches);
            array_shift($placeholders);

            $array_mod = array_combine( array_values($placeholders), array_values($matches) );
            $function( $array_mod );
            return;
        } else {
            return;
        }   
        
    }
}