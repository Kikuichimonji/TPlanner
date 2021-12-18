<?php
    namespace Models;
    use App\AbstractManager;

    class BoardManager extends AbstractManager
    {
        private static $classname = "Models\Board";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneById($id){

            $sql = "SELECT *
            FROM board
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM board";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function getLists($id){

            $sql = "SELECT * FROM lists l
                    WHERE l.id_board = :id
                    ORDER BY l.listPosition";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\lists"
            );
        }
    }

?>