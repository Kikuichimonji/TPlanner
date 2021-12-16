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

        public function edit($card,$list,$pos,$oldPos){

            if($pos>$oldPos){
                $sql = "UPDATE card 
                SET positions = positions-1
                WHERE positions > :oldPosition
                AND positions <= :position;
                UPDATE card
                SET positions = :position ,
                id_list = :list
                WHERE id = :card";
                
            }else{
                $sql = "UPDATE card 
                SET positions = positions+1
                WHERE positions >= :position
                AND positions < :oldPosition;
                UPDATE card
                SET positions = :position ,
                id_list = :list
                WHERE id = :card";
            }
            
            
            $sql2 = "UPDATE card 
            SET positions = positions+1
            WHERE positions >= ".$oldPos."
            AND positions < ".$pos.";
            UPDATE card
            SET positions = ".$pos." ,
            id_list = ".$list."
            WHERE id = ".$card;
            var_dump($sql2);
            $arg= ["position" => $pos,
                    "oldPosition" => $oldPos,
                    "list" => $list,
                    "card" => $card];

            return self::update($sql,$arg);
        }
    }

?>