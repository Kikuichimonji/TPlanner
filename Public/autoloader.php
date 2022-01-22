<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Super Global
//const APP_BASE_PATH = __DIR__;
define('APP_ENV', 'dev');

define("DS",DIRECTORY_SEPARATOR);
define("ROOT","..".DS);
define('ASSET_PATH', ROOT.'Assets'.DS);
define('CSS_PATH', ASSET_PATH.'css'.DS);
define('IMG_PATH', ASSET_PATH.'img'.DS);
define('JS_PATH', ASSET_PATH.'scripts'.DS);

define("APP_PATH",ROOT."App".DS);
define("CONTROL_PATH", ROOT."Controllers".DS);
define("MODEL_PATH", ROOT."Models".DS);    
define("VIEW_PATH", ROOT."Views".DS);

abstract class Autoloader{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class)
    {
        /*var_dump($class);
        die();*/
        $parts = preg_split('#\\\#', $class);
			//$parts = ['Controllers', 'BoardController']

			$className = array_pop($parts);
			//$className = BoardController

			// on créé le chemin vers la classe
			// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 

			//avant : ['Controllers']
			//après implode : "Controllers"
			$path = implode(DS, $parts);
			
			$file = $className.'.php';
			//$file = BoardController.php

			$filepath = ROOT.$path.DS.$file;
			//$filepath = ..\Controllers\IndexController.php

			//var_dump($filepath);die();
			if(file_exists($filepath)){
				require_once $filepath;
			}
    }
}
function dd(...$data)
{
	foreach(func_get_args() as $arg){
		var_dump($arg);
		echo '<br>';
	}
	die();
}
function e($text)
{
	return htmlspecialchars($text);
}

