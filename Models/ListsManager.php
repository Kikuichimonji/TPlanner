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

            $sql = "SELECT * FROM cards c
                    WHERE c.id_list = :id
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

        public function edit($list,$pos,$oldPos){
            
            if($pos>$oldPos){
                /* Si on place la carte plus bas dans la liste (visuellement)
                *  1) On descend les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                *  2) On attribue la position a la nouvelle carte
                */ 
                $sql = "UPDATE lists 
                SET listPosition = listPosition-1
                WHERE listPosition > :oldPosition
                AND listPosition <= :position;
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
                AND listPosition < :oldPosition;
                UPDATE lists
                SET listPosition = :position
                WHERE id = :list";
            }
            $sql2 = "UPDATE lists 
            SET listPosition = listPosition+1
            WHERE listPosition >= ".$pos."
            AND listPosition < ".$oldPos.";
            UPDATE lists
            SET listPosition = ".$pos."
            WHERE id = :list";
            
            $arg= ["position" => $pos,
                    "oldPosition" => $oldPos,
                    "list" => $list,
                ];
                //echo $sql2;
            return self::update($sql,$arg);
        }

        public function getMaxPos($id){

            $sql = "SELECT MAX(listPosition) as max
            FROM lists
            WHERE id_board = :id";
            $arg= ["id" => $id];     

            return self::getValue(
                self::select($sql,$arg, false)
            );
        }

        public function add($id,$title){


            $pos = $this->getMaxPos($id)['max']? $this->getMaxPos($id)['max']+1 : 0;
            $sql= "INSERT INTO lists(label,listPosition,id_board) 
                   VALUES (:title,:positions,:id_list)";

            $arg= ["title" => $title,
                    "id_list" => $id,
                    "positions" => $pos];

            //var_dump($pos);die();

            return self::insert($sql,$arg);
        }

        public function deleteList($id,$pos,$board){

            $sql = "UPDATE lists 
                    SET listPosition = listPosition -1
                    WHERE listPosition > :pos
                    AND id_board = :board;
                    DELETE
                    FROM lists
                    WHERE id = :id ";

            $arg=  ["id" => $id,
                    "pos" => $pos,
                    "board"=> $board];

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
    }

?>