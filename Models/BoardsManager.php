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
                "Models\Lists"
            );
        }

        public function getCardsArchived($id){

            $sql = "SELECT c.id,c.title,c.description,c.color FROM cards c
            INNER JOIN lists l ON l.id = c.id_list
            AND c.isArchived = 1
            WHERE l.id_board = :id";

            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\card"
            );
        }

        public function getListsArchived($id){

            $sql = "SELECT * FROM lists l
            WHERE l.id_board = :id
            AND l.isArchived = 1";

            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Lists"
            );
        }

        public function getListArchived($id) {
            $sql = "SELECT * FROM lists l
            WHERE l.id_board = :idBoard
            AND l.isArchived = 1";
            $arg= ["idBoard" => $id];
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\lists"
            );
        }

        public function getCardArchived($id) {
            $sql = "SELECT c.id,c.title,c.description,c.color FROM cards c
            INNER JOIN lists l ON l.id = c.id_list
            AND c.isArchived = 1
            WHERE l.id_board = :idBoard";
            $arg= ["idBoard" => $id];
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\card"
            );
        }

        public function updateTitle($id,$text){
            
            $sql = "UPDATE boards
            SET label = :text
            WHERE id = :idBoard";
            
            $arg= ["text" => $text,
                    "idBoard" => $id,
                ];
                //echo $sql2;
            return self::update($sql,$arg);
        }

        public function addBoard($text,$id)
        {
            $sql= "INSERT INTO boards(label,id_user)".
                " VALUES (:label,:idBoard)";

            $arg= ["label" => $text,
                    "idBoard" => $id];

            //var_dump($arg);die();
            $idBoard = self::insertReturn($sql,$arg);

            $sql= "INSERT INTO usersboard(id_user,id_board)".
            " VALUES (:idu,:idBoard);
                    INSERT INTO lists(label,listPosition,isArchiveList,id_board)".
            " VALUES (:label,:pos,:isArch,:idBoard);";

            $arg= ["idu" => $id,
                    "idBoard" => $idBoard,
                    "label" => "Archive",
                    "pos" => -1,
                    "isArch" => 1,
                    ];

            self::insertNoChange($sql,$arg);

            return $idBoard;
        }
    }

?>