<?php 
    namespace App;
    
    abstract class DAO{

        protected static $link;
        const DB_HOST = "localhost";
        const DB_NAME = "tplanner";
        const DB_USER = "root";
        const DB_PASS = "";

        public static function connect(){
            try{
                self::$link = self::$link ?? (new \PDO("mysql:host=".self::DB_HOST.";port=3306;".
                                                        " dbname=".self::DB_NAME,
                                                        self::DB_USER,
                                                        self::DB_PASS,
                                                    [
                                                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                                                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                                                    ])); 
                //var_dump(self::$link);die();
                return self::$link;
            }
            catch(\PDOException $e) {
                echo APP_ENV === "dev"
                        ?  $e->getMessage()
                        :  "An error occured";
                die();
            }
            
        }
        public static function disconnect(){
            self::$link = null;
        }
    }
?>