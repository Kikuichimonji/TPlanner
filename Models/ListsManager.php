<?php
    namespace Models;
    use App\AbstractManager;

    class ListsManager extends AbstractManager
    {
        private static $classname = "Models\Lists";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneById($id){

            $sql = "SELECT *
            FROM lists
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM lists";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function getCards($id){

            $sql = "SELECT * FROM card c
                    WHERE c.id_list = :id
                    ORDER BY c.positions";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Card"
            );
        }
    }

?>