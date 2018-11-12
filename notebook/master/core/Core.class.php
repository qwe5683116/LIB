<?php

class Core{

	public function run(){

		self::init();
		self::autoLoad();
		self::dispatch();


	}



	private static function init(){

		define('ROOT',getcwd().'/');
		define('APP_PATH',ROOT.'application'.'/');
		define('CONTROLLER_PATH',APP_PATH.'Controller'.'/');
		define('VIEW_PATH',APP_PATH.'VIEW'.'/');
		define('MASTER_PATH',ROOT.'master'.'/');
		define('CORE_PATH',MASTER_PATH.'core'.'/');


		define('PLATFORM',isset($_GET['p']) ? $_GET['p'] : 'Index');
		define('CONTROLLER',isset($_GET['c']) ? ucfirst($_GET['c']) : 'Index');
		define('ACTION',isset($_GET['a']) ? $_GET['a'] : 'index');	

		define('CUR_CONTROLLER',CONTROLLER_PATH.PLATFORM.'/');
		define('CUR_VIEW',VIEW_PATH.PLATFORM.'/');

		include CORE_PATH.'Db.php';


	}


	private static function dispatch(){

		$controllerName = CONTROLLER.'Controller';
		$actionName = ACTION;

		$obj = new $controllerName();
		$obj->$actionName();

	}


	private static function autoLoad(){

		spl_autoload_register([__CLASS__,'load']);

	}


	private  static function load($classname){

		if(substr($classname,-10) == 'Controller'){
			include CUR_CONTROLLER.$classname.'.class.php';
		}


	}


}