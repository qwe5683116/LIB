<?php
class Db{

	private $host;
    private $port;
    private $user;
    private $pass;
    private $charset;
    private $mQuery;
    private static $link = false;
    private $dbName;
	private $pdo;
	private $succes;


	private $config = ['host'=>'127.0.0.1',
					   'port'=>'3306',
					   'user'=>'root',
					   'pass'=>'',	
					   'charset'=>'utf8',
					   'dbname'=>'notebook'
					  ];
					  


	private function __construct($config = array()){
		
		$config = $config ? $config : $this->config;
		$this->host = $config['host'];
        $this->port = $config['port'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->dbname = $config['dbname'];
        $this->charset = $config['charset'];

        $this->conn($config);

     
      

	}


	public static function  getInstance($config = ''){
		if(self::$link == false){
			self::$link = new self($config);
		}	
		return self::$link;
	}


	private function conn($config = array()){
		try{
			
			$dsn = 'mysql:dbname=' . $this->config["dbname"] . ';host=' . $this->config["host"] . '';
			$this->pdo = new \PDO($dsn, $this->config["user"], $this->config["pass"], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;"));	

			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);        
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);     
            $this->bConnected = true;


		}catch(\PDOException $e){

			print_r($e);
            //echo $this->ExceptionLog($e->getMessage());
            exit();

		}
	}


	public function Init($sql,$pams = ''){

		try{
			$this->mQuery = $this->pdo->prepare($sql);
			if(is_array($pams)){
				$i = 1;
				foreach ($pams as $key => $value) {				
					$this->mQuery->bindValue($i,$value);
					$i++;

				}
			}

			$this->succes = $this->mQuery->execute();


		}catch(\PDOException $e){
			print_r($e);
           // echo $this->ExceptionLog($e->getMessage());
            echo 'testsss';
            exit();
		}
		

	}

	public function CloseConnection(){
    
        $this->pdo = null;
    }


	public function query($sql,$pams = ''){
		$this->Init($sql,$pams);
		if($this->succes){
			return $this->mQuery->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

	public function excu($sql,$pams = ''){
		$this->Init($sql,$pams);
		if($this->succes){
			return $this->mQuery->rowCount();
		}

	}

	public function newId(){

		return $this->pdo->lastInsertId();
	
	}





 
}



