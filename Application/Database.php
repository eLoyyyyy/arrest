<?php

if (!defined('__ROOT')) {
    exit;
}

class Database {

    private $host;
    private $username;
    private $password;
    private $database;

    private $pdo;
    private $stmt;

	private static $instance;
	
    private function __construct($host,$user,$pass,$db) {
        $this->host = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->database = $db;

        $dsn = 'mysql:dbname=' . $this->database .';host=' . $this->host . ';charset=utf8';

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
	
	public static function getInstance(){
		if (!self::$instance){
			self::$instance = new Database(Config::get('server_name'),
											Config::get('user_name'),
											Config::get('user_pass'),
											Config::get('db_name')
										);
		} 
		return self::$instance;
	}

    public function query($query){
        $this->stmt = $this->pdo->prepare($query);
        return $this;
    }

    public function execute( array $values = array() ){
        
		$this->stmt->execute($values); 
		return $this; 
    }
	
	public function getResults(){
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function rowCount(){
		return $this->stmt->rowCount();
	}
	
	public function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}

}

/*
	usage:
	$db = Database::getInstance();
	$db->query( INSERT QUERY STRING HERE ) parameterized query here
		->execute( dito mo bind ung parameters mo. )
		->getResults() associative array na matik to
		->rowCount() how many rows ung result ng query .
*/
