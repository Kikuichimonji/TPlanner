<?php
namespace Models;
use App\AbstractManager;

class CardsManager extends AbstractManager
{
    private static $classname = "Models\Card";

    public function __construct(){
        self::connect();
    }

    public function getOneById($id){ //We fetch one with the given id

        $sql =   "SELECT *".
                " FROM cards".
                " WHERE id = :id";
        $arg= ["id" => $id];     

        return self::getOneOrNullResult(
            self::select($sql,$arg, false),
            self::$classname
        );
    }
    public function getPos($id){ //We get the position of the card (order in the list)

        $sql =   "SELECT positions".
                " FROM cards".
                " WHERE id = :id";
        $arg= ["id" => $id];     

        return self::getValue(
            self::select($sql,$arg, false)
        );
    }

    public function edit($card,$list,$oldList,$pos,$oldPos,$idBoard,$isArchive){ //We edit the position of the card depending on how me move it

        if($oldList != $list){ 
            /* Si on change la carte de liste 
            *  1) On monte toutes les cartes après la nouvelle d'un cran
            *  2) On descend les anciennes cartes d'un cran
            *  3) On attribue la position a la nouvelle carte
            */ 
            $sql = <<<END
            UPDATE cards
            SET positions = positions+1 
            WHERE positions >= :position
            AND list_id = :list;
            UPDATE cards
            SET positions = positions-1
            WHERE positions >= :oldPosition
            AND list_id = :oldList;
            UPDATE cards
            SET positions = :position ,
            list_id = :list
            WHERE id = :card;
            END;

            
            if($isArchive === "true"){
                $sql .= " UPDATE cards".
                    " SET isArchived = 1".
                    " WHERE id = :card;";
            }else{
                $sql .= " UPDATE cards".
                    " SET isArchived = 0".
                    " WHERE id = :card;";
            }

        }else{
            if($pos>$oldPos){
                /* Si on place la carte plus bas dans la liste (visuellement)
                *  1) On descend les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                *  2) On attribue la position a la nouvelle carte
                */ 
                $sql = <<<END
                UPDATE cards
                SET positions = positions-1
                WHERE positions > :oldPosition
                AND positions <= :position
                AND list_id = :list;
                UPDATE cards
                SET positions = :position ,
                list_id = :list
                WHERE id = :card;
                END;
            }else{
                /* Si on place la carte plus haut dans la liste (visuellement)
                *  1) On monte les anciennes cartes d'un cran entre l'ancienne position et la nouvelle (incluse pour libérer l'id pour la carte)
                *  2) On attribue la position a la nouvelle carte
                */ 
                $sql = <<<END
                UPDATE cards
                SET positions = positions+1
                WHERE positions >= :position
                AND positions < :oldPosition
                AND list_id = :list;
                UPDATE cards
                SET positions = :position ,
                list_id = :list
                WHERE id = :card
                END;
            }
        }
        
        $arg= ["position" => $pos,
                "oldPosition" => $oldPos,
                "list" => $list,
                "oldList" => $oldList,
                "card" => $card];

        return self::update($sql,$arg,$idBoard);
    }

    public function getMaxPos($id){ //We fetch the hightest position in the list

        $sql = "SELECT MAX(positions) as max".
        " FROM cards".
        " WHERE list_id = :id";
        $arg= ["id" => $id];     

        return self::getValue(
            self::select($sql,$arg, false)
        );
    }

    public function add($id,$title,$idBoard){ //We add a new card in a list

        $pos = isset($this->getMaxPos($id)['max'])? $this->getMaxPos($id)['max']+1 : 0;
        $sql= "INSERT INTO cards(title,positions,list_id)".
                " VALUES (:title,:positions,:list_id)";

        $arg= ["title" => $title,
                "list_id" => $id,
                "positions" => $pos];

        return self::insert($sql,$arg,$idBoard);
    }

    public function deleteCard($id,$pos,$list,$idBoard){ //We remove a card from a list, then change the position of all the upper cards

        $sql = <<<END
        UPDATE cards
        SET positions = positions -1
        WHERE positions > :pos
        AND list_id = :list;
        DELETE
        FROM cards
        WHERE id = :id 
        END;

        $arg=  ["id" => $id,
                "pos" => $pos,
                "list"=> $list];

        return self::delete($sql,$arg,$idBoard);
    }

    public function editCardDesc($id,$text,$idBoard,$color){ //We update the card's elements
        
        $sql = "UPDATE cards".
        " SET description = :text, color = :color".
        " WHERE id = :id";
        
        $arg= ["text" => $text,
                "id" => $id,
                "color" => $color,
            ];

        return self::update($sql,$arg,$idBoard);
    }

    public function updateTitle($id,$text,$board){ //We update the card's title
            
        $sql = "UPDATE cards".
        " SET title = :text".
        " WHERE id = :id";
        
        $arg= ["text" => $text,
                "id" => $id,
            ];
            
        return self::update($sql,$arg,$board);
    }
}
