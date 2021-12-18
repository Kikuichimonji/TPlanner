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
    }

?>