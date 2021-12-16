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
        public function getPos($id){

            $sql = "SELECT positions
            FROM card
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getValue(
                self::select($sql,$arg, false)
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM card";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function edit($card,$list,$oldList,$pos,$oldPos){
            if($oldList != $list){ 
                /* Si on change la carte de liste 
                *  1) On monte toutes les cartes après la nouvelle d'un cran
                *  2) On descend les anciennes cartes d'un cran
                *  3) On attribue la position a la nouvelle carte
                */ 
                $sql = "UPDATE card 
                    SET positions = positions+1 
                    WHERE positions >= :position
                    AND id_list = :list;
                    UPDATE card 
                    SET positions = positions-1
                    WHERE positions >= :oldPosition
                    AND id_list = :oldList;
                    UPDATE card
                    SET positions = :position ,
                    id_list = :list
                    WHERE id = :card";

            }else{
                if($pos>$oldPos){
                    /* Si on place la carte plus bas dans la liste (visuellement)
                    *  1) On descend les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE card 
                    SET positions = positions-1
                    WHERE positions > :oldPosition
                    AND positions <= :position;
                    UPDATE card
                    SET positions = :position ,
                    id_list = :list
                    WHERE id = :card";
                    
                }else{
                    /* Si on place la carte plus haut dans la liste (visuellement)
                    *  1) On monte les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE card 
                    SET positions = positions+1
                    WHERE positions >= :position
                    AND positions < :oldPosition;
                    UPDATE card
                    SET positions = :position ,
                    id_list = :list
                    WHERE id = :card";
                }
            }
            
            $arg= ["position" => $pos,
                    "oldPosition" => $oldPos,
                    "list" => $list,
                    "oldList" => $oldList,
                    "card" => $card];

            return self::update($sql,$arg);
        }
    }

?>