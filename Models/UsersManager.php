<?php
    namespace Models;
    use App\AbstractManager;

    class UsersManager extends AbstractManager
    {
        private static $classname = "Models\User";

        public function __construct(){
            self::connect(self::$classname);
        }

        public function getOneByUsername($username){

            $sql = "SELECT *
            FROM users
            WHERE LOWER(username) = :username";
            $arg= ["username" => $username];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function getOneByMail($mail){

            $sql = "SELECT *
            FROM users
            WHERE LOWER(mail) = :mail";
            $arg= ["mail" => $mail];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function getOneById($id){

            $sql = "SELECT *
            FROM users
            WHERE id = :id";
            $arg= ["id" => $id];     

            return self::getOneOrNullResult(
                self::select($sql,$arg, false),
                self::$classname
            );
        }

        public function findAll(){
            $sql = "SELECT * FROM users";

            return self::getResults(
                self::select($sql, null, true),
                self::$classname
            );
        }

        public function getBoards($id){

            $sql = "SELECT b.id,b.label FROM boards b
                    INNER JOIN usersboard ub ON ub.id_board = b.id
                    INNER JOIN users u ON u.id = ub.id_user
                    WHERE u.id = :id
                    AND b.id_user = u.id;";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Board"
            );
        }

        public function getInvitedBoards($id){

            $sql = "SELECT b.id,b.label FROM boards b
                    INNER JOIN usersboard ub ON ub.id_board = b.id
                    INNER JOIN users u ON u.id = ub.id_user
                    WHERE u.id = :id
                    AND b.id_user != u.id;";
            $arg= ["id" => $id];   
            return self::getResults(
                self::select($sql,$arg, true),
                "Models\Board"
            );
        }

        public function newUser($username,$password,$mail)
        {
            $sql = "INSERT INTO users(username,password,mail,role,dateCreation)".
                    "VALUES (:pseudo,:pass,:mail,:role,:date)";
            
            $role = json_encode(['user']);
            $arg= ["pseudo" => $username,
                    "pass" => $password,
                    "mail" => $mail,
                    "date" => date("Y-m-d"),
                    "role" => $role];

            return self::insertNoChange($sql,$arg);
        }

        public function deleteUser($id,$boards){

            $sql = "UPDATE boards SET id_user = NULL WHERE id = :id;DELETE FROM usersboard WHERE id_user = :id; DELETE FROM users WHERE id = :id; ";

            $arg=  ["id" => $id];

            /*$sql .= "DELETE FROM users" ;
            count($boards) ? null : null ;
                
            foreach($boards as $board){
                var_dump($board->getId());die();
            }*/
            
            return self::delete($sql,$arg);
        }
    }

?>