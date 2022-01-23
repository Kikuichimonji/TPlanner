<?php

namespace Models;

use App\AbstractManager;

class ListsManager extends AbstractManager
{
    private static $classname = "Models\Lists";

    public function __construct()
    {
        self::connect();
    }

    public function findOneById($id)
    {

        $sql = "SELECT *".
            " FROM lists".
            " WHERE id = :id";
        $arg = ["id" => $id];

        return self::getOneOrNullResult(
            self::select($sql, $arg, false),
            self::$classname
        );
    }

    public function getCards($id) // we fetch all the cards from the list
    { 
        $sql = "SELECT * FROM cards c".
                " WHERE c.list_id = :id".
                " ORDER BY c.positions";
        $arg = ["id" => $id];
        return self::getResults(
            self::select($sql, $arg, true),
            "Models\Card"
        );
    }

    public function getPos($id) //we fetch the position of the list
    {
        $sql = "SELECT listPosition".
            " FROM lists".
            " WHERE id = :id";
        $arg = ["id" => $id];

        return self::getValue(
            self::select($sql, $arg, false)
        );
    }

    public function edit($list, $pos, $oldPos, $idBoard, $isArchive) //we edit the list position
    {
        $arg = [
            "position" => $pos,
            "oldPosition" => $oldPos,
            "list" => $list,
            "idBoard" => $idBoard,
        ];

        if ($isArchive === "true") { //if we archive the list
            $sql = "UPDATE lists".
                    " SET listPosition = listPosition -1".
                    " WHERE listPosition > :position".
                    " AND board_id = :idBoard;".
                    " UPDATE lists".
                    " SET isArchived = 1, listPosition = -2".
                    " WHERE id = :list";

            $arg = [
                "position" => $pos,
                "list" => $list,
                "idBoard" => $idBoard,
            ];
        } else {
            if ($pos > $oldPos) { //If we move right
                $sql = "UPDATE lists ".
                    " SET listPosition = listPosition-1".
                    " WHERE listPosition > :oldPosition".
                    " AND listPosition <= :position".
                    " AND board_id = :idBoard;".
                    " UPDATE lists".
                    " SET listPosition = :position".
                    " WHERE id = :list";
            } else {    //If we move left
                $sql = "UPDATE lists ".
                    " SET listPosition = listPosition+1".
                    " WHERE listPosition >= :position".
                    " AND listPosition < :oldPosition".
                    " AND board_id = :idBoard;".
                    " UPDATE lists".
                    " SET listPosition = :position".
                    " WHERE id = :list";
            }
        }
        return self::update($sql, $arg, $idBoard);
    }

    public function getMaxPos($id) //We fetch the higher position of the list in the board
    {
        $sql = "SELECT MAX(listPosition) as max".
            " FROM lists".
            " WHERE board_id = :id";
        $arg = ["id" => $id];

        return self::getValue(
            self::select($sql, $arg, false)
        );
    }

    public function add($id, $title) //We add a new list to the board
    {
        $pos = $this->getMaxPos($id)['max'] ? $this->getMaxPos($id)['max'] + 1 : 0;
        $sql = "INSERT INTO lists(label,listPosition,board_id)".
                " VALUES (:title,:positions,:idBoard)";

        $arg = [
            "title" => $title,
            "idBoard" => $id,
            "positions" => $pos
        ];

        return self::insert($sql, $arg);
    }

    public function deleteList($id, $pos, $board) //We delete the list from the board
    {

        $sql = "UPDATE lists".
                " SET listPosition = listPosition -1".
                " WHERE listPosition > :pos".
                " AND board_id = :idBoard;".
                " DELETE".
                " FROM lists".
                " WHERE id = :id ";

        $arg =  [
            "id" => $id,
            "pos" => $pos,
            "idBoard" => $board
        ];

        return self::delete($sql, $arg);
    }
    public function archiveDeleteList($id, $board) //We delete the list from the board (comming from archive)
    {
        $sql = "DELETE".
                " FROM lists".
                " WHERE id = :id ";

        $arg =  [
            "id" => $id,
        ];

        return self::delete($sql, $arg, $board);
    }

    public function updateTitle($id, $text, $board) //We update the list title
    {
        $sql = "UPDATE lists".
            " SET label = :text".
            " WHERE id = :id";

        $arg = [
            "text" => $text,
            "id" => $id,
        ];

        return self::update($sql, $arg, $board);
    }
}
