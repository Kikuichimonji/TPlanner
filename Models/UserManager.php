<?php
    namespace Models;
    use App\AbstractManager;

    class UserManager extends AbstractManager
    {
        private static $classname = "Models\User";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getMembre($username){

            $sql = "SELECT *
            FROM user 
            WHERE LOWER(username) = :username";
            $arg= ["username" => $username];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM user";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }
    }

?>