<?php

class Master{


	public static function run(){

		Master::init();
		Master::autoload();
		Master::path();
	
	}


	public static function init(){

		define('ROOT',getcwd().'/');
		define('APPLICATION_PATH',ROOT.'application'.'/');
		define('CONTROLLER_PATH',APPLICATION_PATH.'controller'.'/');

		define('PLAT',isset($_GET['p']) ? $_GET['p'] : 'admin');
		define('CONTROLLER',isset($_GET['c']) ? $_GET['c'] : 'Admin');
		define('ACTION',isset($_GET['a']) ? $_GET['a'] : 'index');

		define('CUR_CONTROLLER',CONTROLLER_PATH.PLAT.'/');


	}

	
	public static function path(){
		$conrtollerName = CONTROLLER.'Controller';
		$ACTION = ACTION;

		$obj = new $conrtollerName();
		$obj->$ACTION();

	}


	public static function autoload(){

		spl_autoload_register([__CLASS__,'load']);

	}



	public static function load($classname){

		if(substr($classname, -10) == 'Controller'){
			
			include CUR_CONTROLLER."{$classname}.class.php";

		}


	}



	
}

