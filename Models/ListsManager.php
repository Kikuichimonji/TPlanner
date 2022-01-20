<?php
    namespace Models;
    use App\AbstractManager;

    class ListsManager extends AbstractManager
    {
        private static $classname = "Models\Lists";

        public function __construct(){
            self::connect();
        }

        public function findOneById($id){

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

            $sql = "SELECT * FROM cards c
                    WHERE c.list_id = :id
                    ORDER BY c.positions";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Card"
            );
        }

        public function getPos($id){

            $sql = "SELECT listPosition
            FROM lists
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getValue(
                self::select($sql,$arg, false)
            );
        }

        public function edit($list,$pos,$oldPos,$idBoard,$isArchive){

            $arg= ["position" => $pos,
                    "oldPosition" => $oldPos,
                    "list" => $list,
                    "idBoard" => $idBoard,
                    ];

            if($isArchive === "true"){
                $sql="UPDATE lists 
                    SET listPosition = listPosition -1
                    WHERE listPosition > :position
                    AND board_id = :idBoard;
                    UPDATE lists
                    SET isArchived = 1
                    WHERE id = :list";

                $arg= ["position" => $pos,
                        "list" => $list,
                        "idBoard" => $idBoard,
                        ];
            }else{
                if($pos>$oldPos){
                    /* Si on place la carte plus bas dans la liste (visuellement)
                    *  1) On descend les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE lists 
                    SET listPosition = listPosition-1
                    WHERE listPosition > :oldPosition
                    AND listPosition <= :position
                    AND board_id = :idBoard;
                    UPDATE lists
                    SET listPosition = :position
                    WHERE id = :list";
                    
                }else{
                    /* Si on place la carte plus haut dans la liste (visuellement)
                    *  1) On monte les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE lists 
                    SET listPosition = listPosition+1
                    WHERE listPosition >= :position
                    AND listPosition < :oldPosition
                    AND board_id = :idBoard;
                    UPDATE lists
                    SET listPosition = :position
                    WHERE id = :list";
                }
            }
            
            /*$sql2 = "UPDATE lists 
            SET listPosition = listPosition+1
            WHERE listPosition >= ".$pos."
            AND listPosition < ".$oldPos.";
            UPDATE lists
            SET listPosition = ".$pos."
            WHERE id = :list";
            */
          
                //echo $sql2;
            //var_dump($isArchive);die();
            return self::update($sql,$arg,$idBoard);
        }

        public function getMaxPos($id){

            $sql = "SELECT MAX(listPosition) as max
            FROM lists
            WHERE board_id = :id";
            $arg= ["id" => $id];     

            return self::getValue(
                self::select($sql,$arg, false)
            );
        }

        public function add($id,$title){


            $pos = $this->getMaxPos($id)['max']? $this->getMaxPos($id)['max']+1 : 0;
            $sql= "INSERT INTO lists(label,listPosition,board_id) 
                   VALUES (:title,:positions,:idBoard)";

            $arg= ["title" => $title,
                    "idBoard" => $id,
                    "positions" => $pos];

            //var_dump($sql);die();

            return self::insert($sql,$arg);
        }

        public function deleteList($id,$pos,$board){

            $sql = "UPDATE lists 
                    SET listPosition = listPosition -1
                    WHERE listPosition > :pos
                    AND board_id = :idBoard;
                    DELETE
                    FROM lists
                    WHERE id = :id ";

            $arg=  ["id" => $id,
                    "pos" => $pos,
                    "idBoard"=> $board];

            $cardSql = " DELETE
            FROM cards
            WHERE id IN(";

            $cards = $this->getCards($id);
            $count = 0;
            foreach ($cards as $card) {
                $cardSql.= $card->getId();
                $count++;
                if(count($cards) != $count){
                    $cardSql.= ",";
                }
            }
            $cardSql.=")";
            if($count){
                self::delete($cardSql);
            }
                
            return self::delete($sql,$arg);
        }
        public function archiveDeleteList($id,$board){

            $sql = "DELETE
                    FROM lists
                    WHERE id = :id ";

            $arg=  ["id" => $id,
                    ];

            $cardSql = " DELETE
            FROM cards
            WHERE id IN(";

            $cards = $this->getCards($id);
            $count = 0;
            foreach ($cards as $card) {
                $cardSql.= $card->getId();
                $count++;
                if(count($cards) != $count){
                    $cardSql.= ",";
                }
            }
            $cardSql.=")";
            if($count){
                self::delete($cardSql);
            }
            return self::delete($sql,$arg,$board);
        }

        public function updateTitle($id,$text,$board){
            
            $sql = "UPDATE lists
            SET label = :text
            WHERE id = :id";
            
            $arg= ["text" => $text,
                    "id" => $id,
                ];
                
            return self::update($sql,$arg,$board);
        }

    }

?>