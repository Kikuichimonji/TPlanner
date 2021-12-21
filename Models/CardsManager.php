<?php
    namespace Models;
    use App\AbstractManager;

    class CardsManager extends AbstractManager
    {
        private static $classname = "Models\Card";

        public function __construct(){
            self::connect();
        }

        public function getOneById($id){

            $sql =   "SELECT *".
                    " FROM cards".
                    " WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }
        public function getPos($id){

            $sql =   "SELECT positions".
                    " FROM cards".
                    " WHERE id = :id";
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
                $sql = "UPDATE cards
                    SET positions = positions+1 
                    WHERE positions >= :position
                    AND id_list = :list;
                    UPDATE cards
                    SET positions = positions-1
                    WHERE positions >= :oldPosition
                    AND id_list = :oldList;
                    UPDATE cards
                    SET positions = :position ,
                    id_list = :list
                    WHERE id = :card";

            }else{
                if($pos>$oldPos){
                    /* Si on place la carte plus bas dans la liste (visuellement)
                    *  1) On descend les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE cards
                    SET positions = positions-1
                    WHERE positions > :oldPosition
                    AND positions <= :position
                    AND id_list = :list;
                    UPDATE cards
                    SET positions = :position ,
                    id_list = :list
                    WHERE id = :card";
                    
                }else{
                    /* Si on place la carte plus haut dans la liste (visuellement)
                    *  1) On monte les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                    *  2) On attribue la position a la nouvelle carte
                    */ 
                    $sql = "UPDATE cards
                    SET positions = positions+1
                    WHERE positions >= :position
                    AND positions < :oldPosition
                    AND id_list = :list;
                    UPDATE cards
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

            //var_dump($sql);
            //var_dump($card,$list,$oldList,$pos,$oldPos);
            return self::update($sql,$arg);
        }

        public function getMaxPos($id){

            $sql = "SELECT MAX(positions) as max
            FROM cards
            WHERE id_list = :id";
            $arg= ["id" => $id];     

            return self::getValue(
                self::select($sql,$arg, false)
            );
        }

        public function add($id,$title){


            $pos = isset($this->getMaxPos($id)['max'])? $this->getMaxPos($id)['max']+1 : 0;
            $sql= "INSERT INTO cards(title,positions,id_list) 
                   VALUES (:title,:positions,:id_list)";

            $arg= ["title" => $title,
                    "id_list" => $id,
                    "positions" => $pos];

            //var_dump($pos);die();

            return self::insert($sql,$arg);
        }

        public function deleteCard($id,$pos,$list){

            $sql = "UPDATE cards
                    SET positions = positions -1
                    WHERE positions > :pos
                    AND id_list = :list;
                    DELETE
                    FROM cards
                    WHERE id = :id ";

            $arg=  ["id" => $id,
                    "pos" => $pos,
                    "list"=> $list];

            //var_dump($pos);die();

            return self::delete($sql,$arg);
        }
    }

?>