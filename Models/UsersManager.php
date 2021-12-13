<?php
    namespace Models;
    use App\AbstractManager;

    class UsersManager extends AbstractManager
    {
        private static $classname = "Models\Users";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneByUsername($username){

            $sql = "SELECT *
            FROM users
            WHERE LOWER(username) = :username";
            $arg= ["username" => $username];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM users";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }
    }

?>