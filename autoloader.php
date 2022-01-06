<?php

// Super Global
//const APP_BASE_PATH = __DIR__;
define('APP_ENV', 'dev');

define("DS",DIRECTORY_SEPARATOR);
define("ROOT",".".DS);
define('PUBLIC_PATH', ROOT.'Assets'.DS);
define('CSS_PATH', PUBLIC_PATH.'css'.DS);
define('IMG_PATH', PUBLIC_PATH.'img'.DS);

define("APP_PATH",ROOT."app".DS);
define("CONTROL_PATH", ROOT."controller".DS);
define("MODEL_PATH", ROOT."model".DS);    
define("VIEW_PATH", ROOT."view".DS);
define("CLASS_PATH", ROOT."classe".DS);

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

			// on extrait le dernier element 
			$className = array_pop($parts);
			//$className = VehiculeManager

			// on créé le chemin vers la classe
			// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 

			//avant : ['Model', 'Managers']
			//après implode : "model\managers"
			$path = implode(DS, $parts);
			
			$file = $className.'.php';
			//$file = VehiculeManager.php

			$filepath = ROOT.$path.DS.$file;
			//$filepath = ./model/managers/VehiculeManager.php

			//var_dump($filepath);die();
			if(file_exists($filepath)){
				require_once $filepath;
			}
    }
}



/*// App Loader
require_once 'App/DAO.php';
require_once 'App/AbstractEntity.php';
require_once 'App/AbstractManager.php';

// Controllers Loader
require_once 'Controllers/Controller.php';
require_once 'Controllers/WelcomeController.php';
require_once 'Controllers/HomeController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/UserController.php';

// Models Loader
require_once 'Models/Model.php';
require_once 'Models/User.php';
require_once 'Models/UserManager.php';
require_once 'Models/Note.php';
*/
