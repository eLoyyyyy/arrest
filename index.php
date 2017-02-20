<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


define('__ROOT', str_replace('\\','/', dirname(__FILE__)) );
define('__APP_DIR', __ROOT . DIRECTORY_SEPARATOR . 'Application');
define('__CONFIG_DIR', __ROOT . DIRECTORY_SEPARATOR . 'Config');
define('__MODEL_DIR', __ROOT . DIRECTORY_SEPARATOR . 'Model');

require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Request.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Application.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Config.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Database.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Result.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Model.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Router.php';
require_once __APP_DIR . DIRECTORY_SEPARATOR . 'Security.php';

require_once __MODEL_DIR . DIRECTORY_SEPARATOR . 'Article.php';
require_once __MODEL_DIR . DIRECTORY_SEPARATOR . 'User.php';



/*
$result = new Result(300, 10, 3, 0, array( 'bryan', 'jem', 'jared', 'dan') );
$response = $result->render();
echo print_r($response);*/

//header("Content-Type: application/json");
//echo json_encode($_GET);

/*if(array_key_exists('callback', $_GET)){

    header('Content-Type: text/javascript; charset=utf8');
    header('Access-Control-Allow-Origin: http://www.example.com/');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $callback = $_GET['callback'];
    echo $callback.'('.$data.');';

}else{
    // normal JSON string
    header('Content-Type: application/json; charset=utf8');

    echo $data;
}*/

$request = new Request();
$route = Router::getInstance();

$application = new Application( $request, $route );
$application->process();
/*echo Config::get('server_name');*/