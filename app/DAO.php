<?php 
    namespace App;
    
    abstract class DAO{ //Why is it called DAO again? i don't remember, i'm just used to do it

        protected static $link;
        const DB_HOST = "localhost";
        const DB_NAME = "oflr1394_tplanner";
        const DB_USER = "oflr1394_thomas";
        const DB_PASS = "jZ8S7!#*OVVx";

        public static function connect(){ //We create the connection to the DB
            try{//If the link does not exist already we create a new one
                self::$link = self::$link ?? (new \PDO("mysql:host=".self::DB_HOST.";port=3306;".
                                                        " dbname=".self::DB_NAME,
                                                        self::DB_USER,
                                                        self::DB_PASS,
                                                    [
                                                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                                                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                                                    ])); 
                return self::$link;
            }
            catch(\PDOException $e) {
                echo APP_ENV === "dev" //Showing different errors depending on the environnement 
                        ?  $e->getMessage()
                        :  "An error occured";
                die();
            }
            
        }
        public static function disconnect(){ //we destroy the link to the DB to disconnect
            self::$link = null;
        }
    }
?>