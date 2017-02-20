<?php

if (!defined('__ROOT')) {
    exit;
}

class Application {
    
    private $_request = array();
    
    private $_req;
    
    private $_router;
    
    private $_status = 200;
    
    public function __construct( Request $request, Router $router ){ 
        $this->_req = $request;
        $this->_router = $router;
    }
    
    public function preprocess(){ 
        $this->_request = $_REQUEST;
        
        if ( !Security::checkHeader() ){
            $this->_status = 400;
            $this->post_process( array() );
            exit;
        }
        
       /* $this->_request['url'] = explode('/', $this->_request['url']);
        $this->_request['url'] = array_map( function($input){
            return strtolower(
                    trim( 
                        preg_replace('~[^0-9a-z]+~i', '', 
                            html_entity_decode(
                                preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
                                    htmlentities($input, ENT_QUOTES, 'UTF-8')
                                ), 
                            ENT_QUOTES, 'UTF-8')
                        ), 
                    '')
            );
        }, $this->_request['url'] );
        $this->_req->set('url', $this->_request['url'] );*/
        
        $this->_request['fields'] = ( isset($this->_request['fields']) ) ? explode(',', $this->_request['fields']) : array();
        $this->_req->set('fields', $this->_request['fields'] );
        
        if ( isset($this->_request['limit']) ) {
            $this->_request['limit'] = ( is_numeric($this->_request['limit']) && !is_array($this->_request['limit']) ) ? $this->_request['limit'] : 0;
        } else {
            $this->_request['limit'] = 25;
        }
        $this->_req->set('limit', $this->_request['limit'] );
        
        if ( isset($this->_request['offset']) ) {
            $this->_request['offset'] = ( is_int($this->_request['offset']) && !is_array($this->_request['offset']) ) ? (int)$this->_request['offset'] : 0;
        } else {
            $this->_request['offset'] = 0;
        }
        $this->_req->set('offset', $this->_request['offset'] );
        //print_r($this->_request);
    }
    
    public function process(){
        $this->preprocess();
                
        $results = array();
        
        
        $this->_router->route( $this->_request['url'], '/user/:id', function($req) use (&$results){
            
            //print_r($req);
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();
                    
                    $controller->fields( 
                        $this->_req->get('fields'), 
                        $req['id'], 
                        1, 
                        0 
                    );
                    $results = $controller->process();
                } else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user', function($req) use (&$results){
            
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $controller->fields( 
                        $this->_req->get('fields'), 
                        null, 
                        $this->_req->get('limit'), 
                        $this->_req->get('offset') 
                    );
                    $results = $controller->process();

                } else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user/:id/article', function($req) use (&$results){
            
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $controller->fields( 
                        $this->_req->get('fields'), 
                        null, 
                        $this->_req->get('limit'), 
                        $this->_req->get('offset'),
                        array( 'cw_id' => $req['id'] )
                    );
                    $results = $controller->process();

                } else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user/:id/article/:artid', function($req) use (&$results){
            
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $controller->fields( 
                        $this->_req->get('fields'), 
                        null, 
                        $this->_req->get('limit'), 
                        $this->_req->get('offset'),
                        array( 
                            'cw_id' => $req['id'],
                            'id' => $req['artid']
                        )
                    );
                    $results = $controller->process();
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/article', function($req) use (&$results){
            
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $controller->fields( 
                        $this->_req->get('fields'), 
                        null, 
                        $this->_req->get('limit'), 
                        $this->_req->get('offset') 
                    );
                    $results = $controller->process();
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/article/:id', function($req) use (&$results){
            
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $controller->fields( 
                        $this->_req->get('fields'), 
                        $req['id'], 
                        1, 
                        0 
                    );
                    $results = $controller->process();
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );   
        
        $this->_router->route( $this->_request['url'], '/user/login', function($req) use (&$results){
            
            
            
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->login( $this->_request['username'] , $this->_request['password'] );
                    $results = array(
                        "login" => Security::check_password( $account['password'], $this->_request['password'] ),
                        "account" => $account,
                        
                    );
                    unset($results['account']['password']);
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user/:id/activate', function($req) use (&$results){
   
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->activate( $req['id'] );
                    $results = array(
                        "status" => $account,
                    );
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user/:id/deactivate', function($req) use (&$results){
   
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->activate( $req['id'] );
                    $results = array(
                        "status" => $account,
                    );
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/article/:id/approve', function($req) use (&$results){
   
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->approve( $req['id'] );
                    $results = array(
                        "status" => $account,
                    );
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/article/:id/reject', function($req) use (&$results){
   
            $model = 'article';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->reject( $req['id'] );
                    $results = array(
                        "status" => $account,
                    );
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        $this->_router->route( $this->_request['url'], '/user/:id/profile', function($req) use (&$results){
   
            $model = 'user';
            $file = ucfirst(strtolower($model)) . '.php';

            if ( file_exists( __MODEL_DIR . DIRECTORY_SEPARATOR . $file) ) {
                
                
                if ( class_exists( $model ) ) {
                    $controller = new $model();

                    $account = $controller->profile( $req['id'] );
                    $results = array(
                        "account" => $account,
                    );
                }   else {
                    echo "class does not exists";
                }

            } else {

            }
            
        } );
        
        //print_r( $results );
        $this->post_process( $results );
        
        
    }
    
    public function post_process( $results ) {
        
        $response = new Result( 
            $this->_status, 
            count($results), 
            ( $this->_req->get('limit') !== null ? $this->_req->get('limit') : 0 ), 
            ( $this->_req->get('offset') !== null ? $this->_req->get('offset') : 0 ), 
            $results 
        );
        
        // Turn on output buffering with the gzhandler
        /*ob_start('ob_gzhandler') OR ob_start();
        ob_flush();*/
        if(array_key_exists('callback', $_GET)){

            header('Content-Type: text/javascript; charset=utf8');
            header('Access-Control-Allow-Origin: ' . $_SERVER['SERVER_NAME']);
            header('Access-Control-Max-Age: 3628800');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
                                                              
            $callback = $_GET['callback'];
            
            echo $callback.'('.json_encode($response->render()).');';

        }else{
            // normal JSON string
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=utf8');
            echo json_encode($response->render());
        }
        //print_r( $response->render() );
        
        exit;
        
        //echo 'Request: ' . print_r($this->_request);
    }
    
    
}