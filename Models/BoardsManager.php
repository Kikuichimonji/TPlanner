<?php

namespace Models;

use App\AbstractManager;

class BoardsManager extends AbstractManager
{
    private static $classname = "Models\Board";

    public function __construct()
    {
        self::connect();
    }

    public function getOneById($id) //We fetch one with the given id
    {

        $sql =   "SELECT *" .
            " FROM boards" .
            " WHERE id = :id";
        $arg = ["id" => $id];

        return self::getOneOrNullResult(
            self::select($sql, $arg, false),
            self::$classname
        );
    }

    public function getLists($id) // We fetch the lists that are attached to the board
    {
        $sql =   "SELECT * FROM lists l" .
            " WHERE l.board_id = :id" .
            " ORDER BY l.listPosition";
        $arg = ["id" => $id];
        return self::getResults(
            self::select($sql, $arg, true),
            "Models\Lists"
        );
    }

    public function getCardsArchived($id) //We fetch the cards that are attached to the board and also archived
    {
        $sql = "SELECT c.id,c.title,c.description,c.color FROM cards c".
            " INNER JOIN lists l ON l.id = c.list_id".
            " AND c.isArchived = 1".
            " WHERE l.board_id = :id";

        $arg = ["id" => $id];
        return self::getResults(
            self::select($sql, $arg, true),
            "Models\card"
        );
    }

    public function getListsArchived($id) //We fetch the lists that are attached to the board and also archived
    {

        $sql = "SELECT * FROM lists l".
        " WHERE l.board_id = :idBoard".
        " AND l.isArchived = 1";
        
        $arg = ["idBoard" => $id];
        return self::getResults(
            self::select($sql, $arg, true),
            "Models\lists"
        );
    }

    public function updateTitle($id, $text) //We update the board title
    {

        $sql = "UPDATE boards".
            " SET label = :text".
            " WHERE id = :idBoard";

        $arg = [
            "text" => $text,
            "idBoard" => $id,
        ];
        return self::update($sql, $arg);
    }

    public function addBoard($text, $id) //We add a new board
    {
        $sql = "INSERT INTO boards(label,user_id,lastChange)" .
            " VALUES (:label,:idBoard,:time)";

        $arg = [
            "label" => $text,
            "idBoard" => $id,
            "time" => date("Y-m-d H:i:s")
        ];

        $idBoard = self::insertReturn($sql, $arg); //we use the id of the created board to create the mandatory archive list and attach it

        $sql = "INSERT INTO users_boards(user_id,board_id)" .
            " VALUES (:idu,:idBoard);
                    INSERT INTO lists(label,listPosition,isArchiveList,board_id)" .
            " VALUES (:label,:pos,:isArch,:idBoard);";

        $arg = [
            "idu" => $id,
            "idBoard" => $idBoard,
            "label" => "Archive",
            "pos" => -1,
            "isArch" => 1,
        ];

        self::insertNoChange($sql, $arg);

        return $idBoard;
    }

    public function getOrphan() //We fetch the board that do not have a creator attached to it (if the creator is deleted)
    {
        $sql = "SELECT * FROM boards WHERE user_id IS NULL";

        return self::getResults(
            self::select($sql, null, true),
            self::$classname
        );
    }

    public function inviteUser($idBoard, $idUser) //We add the user to the users_boards list so it can access the board
    {
        $sql = "INSERT INTO users_boards(user_id,board_id)" .
            " VALUES (:idUser,:idBoard)";

        $arg = [
            "idUser" => $idUser,
            "idBoard" => $idBoard
        ];

        return self::insert($sql, $arg);
    }

    public function removeUser($idBoard, $idUser) //We add the user to the users_boards list so it can access the board
    {
        $sql = "DELETE".
                " FROM users_boards".
                " WHERE user_id = :idUser ".
                " AND board_id = :idBoard ";

        $arg = [
            "idUser" => $idUser,
            "idBoard" => $idBoard
        ];

        return self::delete($sql, $arg);
    }

    public function getUsers($idBoard) //fetch the users from a board
    {
        $sql = "SELECT u.id, u.username, u.mail, u.color FROM users u" .
            " INNER JOIN users_boards ub ON u.id = ub.user_id" .
            " INNER JOIN boards b ON b.id = ub.board_id" .
            " WHERE b.id = :idBoard";

        $arg = ["idBoard" => $idBoard];
        //dd($sql);
        return self::getResults(
            self::select($sql, $arg, true),
            "Models\User"
        );
    }

    public function getCreator($id) //fetch the creator of the board
    {

        $sql =   "SELECT user_id" .
            " FROM boards" .
            " WHERE id = :id";
        $arg = ["id" => $id];

        return self::getValue(
            self::select($sql, $arg, false)
        );
    }

    public function deleteBoard($id) //We delete the board, lists and cards are cascading
    {

        $sql = "DELETE".
                " FROM boards".
                " WHERE id = :id ";

        $arg =  [
            "id" => $id,
        ];

        return self::delete($sql, $arg);
    }
    public function checkChange($id,$time) //We check if the time is different to reload the page
    {

        $sql = "SELECT lastChange".
                " FROM boards".
                " WHERE id = :id".
                " AND lastChange = :time";

        $arg =  [
            "id" => $id,
            "time" => $time
        ];

        return self::getValue(
            self::select($sql, $arg, false));
    }
}
