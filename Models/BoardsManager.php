<?php
    namespace Models;
    use App\AbstractManager;

    class BoardsManager extends AbstractManager
    {
        private static $classname = "Models\Board";

        public function __construct(){
            self::connect();
        }

        public function getOneById($id){

            $sql =   "SELECT *".
                    " FROM boards".
                    " WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM boards";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function getLists($id){

            $sql =   "SELECT * FROM lists l".
                    " WHERE l.id_board = :id".
                    " ORDER BY l.listPosition";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\lists"
            );
        }

        public function updateTitle($id,$text){
            
            $sql = "UPDATE boards
            SET label = :text
            WHERE id = :id";
            
            $arg= ["text" => $text,
                    "id" => $id,
                ];
                //echo $sql2;
            return self::update($sql,$arg);
        }

        public function addBoard($text,$id)
        {
            $sql= "INSERT INTO boards(label,id_user)".
                " VALUES (:label,:id)";

            $arg= ["label" => $text,
                    "id" => $id];

            //var_dump($arg);die();
            $idBoard = self::insertReturn($sql,$arg);

            $sql= "INSERT INTO usersboard(id_user,id_board)".
            " VALUES (:idu,:idb)";

            $arg= ["idu" => $id,
                    "idb" => $idBoard];

            self::insert($sql,$arg);

            return $idBoard;
        }
    }

?>