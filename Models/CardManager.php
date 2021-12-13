<?php
    namespace Models;
    use App\AbstractManager;

    class CardManager extends AbstractManager
    {
        private static $classname = "Models\Card";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneById($id){

            $sql = "SELECT *
            FROM card
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM card";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }
    }

?>